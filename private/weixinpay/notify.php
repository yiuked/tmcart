<?php
/**
* 2010-2015 Yiuked
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade yiukedautoseo to newer
* versions in the future.
*
*  @author    Yiuked SA <yiuked@vip.qq.com>
*  @copyright 2010-2015 Yiuked
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*/

include(dirname(__FILE__).'/../../config/config.inc.php');
require_once(_PS_MODULE_DIR_.'weixinpay/defines.php');
require_once(WXP_MODDULE_DIR.'classes/lib/WxPay.Notify.php');
require_once(WXP_MODDULE_DIR.'classes/Log.php');

//初始化日志
$logHandler = new CLogFileHandler(WXP_MODDULE_DIR.WXP_MODDULE_LOGS.date('Y-m-d').'.log');
$log = Log::init($logHandler, 15);

class PayNotifyCallBack extends WxPayNotify
{
    //查询订单
    public function queryOrder($transaction_id)
    {
        $input = new WxPayOrderQuery();
        $input->SetTransaction_id($transaction_id);
        $result = WxPayApi::orderQuery($input);
        Log::DEBUG("query:" . Tools::jsonEncode($result));
        if (array_key_exists("return_code", $result)
            && array_key_exists("result_code", $result)
            && $result["return_code"] == "SUCCESS"
            && $result["result_code"] == "SUCCESS") {
            if (!$this->changeOrderStatus($result['out_trade_no'])) {
                Log::DEBUG("change:5.更改定单状态失败");
            }

            return true;
        }

        return false;
    }

    //重写回调处理函数
    public function notifyProcess($data, &$msg)
    {
        Log::DEBUG("call back:" . Tools::jsonEncode($data));
        $notfiyOutput = array();

        if (!array_key_exists("transaction_id", $data)) {
            $msg = "输入参数不正确";

            return false;
        }
        //查询订单，判断订单真实性
        if (!$this->queryOrder($data["transaction_id"])) {
            $msg = "订单查询失败";

            return false;
        }

        return true;
    }

    public function changeOrderStatus($result_order)
    {
        $orders = Order::getByReference($result_order);
        $isOk = true;
        if ($orders) {
            foreach ($orders as $order) {
                $isOk &= $this->changeOrderStatusSub($order->id);
            }
        }
        return $isOk;
    }

    public function changeOrderStatusSub($id_order)
    {
        Log::DEBUG("change:1.".$id_order);
        if ($id_order) {
            Log::DEBUG("change:2.".$id_order);
            $lastHistory = OrderHistory::getLastOrderState($id_order);
            if ($lastHistory->id == Configuration::get('PS_OS_PAYMENT')) {
                Log::DEBUG("change:2.1.".$id_order);

                return true;
            }

            $history  = new OrderHistory();
            $history->id_order = (int) $id_order;
            $history->changeIdOrderState(Configuration::get('PS_OS_PAYMENT'), (int) $id_order);
            Log::DEBUG("change:3.".$id_order);
            if ($history->addWithemail()) {
                Log::DEBUG("change:4.".$id_order);
                return true;
            }
        }
        return false;
    }
}

Log::DEBUG("call back:begin notify");
$notify = new PayNotifyCallBack();
$notify->handle(false);
