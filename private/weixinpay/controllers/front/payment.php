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

require_once(_PS_MODULE_DIR_.'weixinpay/defines.php');
require_once(WXP_MODDULE_DIR.'classes/WxPay.NativePay.php');
require_once(WXP_MODDULE_DIR.'classes/qrcode/QRencode.php');

class WeixinpayPaymentModuleFrontController extends ModuleFrontController
{
    public $ssl = true;
    public $display_column_left = false;

    /**
     * @see FrontController::initContent()
     */
    public function initContent()
    {
        parent::initContent();

        $cart = $this->context->cart;
        $customer = $this->context->customer;
        
        if (!$this->module->checkCurrency($cart) || !Validate::isLoadedObject($cart) || $cart->id_customer != $customer->id) {
            Tools::redirect('index.php?controller=order');
        }

        $id_order = $this->generateOrder($cart->id);
        if (!$id_order) {
            return false;
        }

        $order = new order($id_order);

        $filename = 'WXP-'.md5(md5($order->reference)).'.png';
        $url = $this->unifiedOrder($cart, $order->reference);

        if ($url) {
            QRcode::png($url, WXP_MODDULE_DIR.WXP_MODDULE_DATA.$filename, WXP_QRCODE_E_LEVEL, WXP_QRCODE_SIZE);
        }

        $this->context->smarty->assign(array(
            'nbProducts' => $cart->nbProducts(),
            'cust_currency' => $cart->id_currency,
            'payimage' => $this->module->getPathUri().WXP_MODDULE_DATA.$filename,
            'expire_time' => WXP_TIMEOUT/60,
            'rand_args' => $order->reference,
            'return_url' => Context::getContext()->link->getModuleLink('weixinpay', 'return', array('id_cart' => $cart->id)),
            'currencies' => $this->module->getCurrency((int) $cart->id_currency),
            'total' => $cart->getOrderTotal(true, Cart::BOTH),
            'this_path' => $this->module->getPathUri(),
            'this_path_bw' => $this->module->getPathUri(),
            'this_path_ssl' => Tools::getShopDomainSsl(true, true).__PS_BASE_URI__.'modules/'.$this->module->name.'/'
        ));

        $this->setTemplate('payment_execution.tpl');
    }

    public function unifiedOrder($cart, $reference)
    {
        $total = (float)$cart->getOrderTotal(true, Cart::BOTH);
        $total = (int)($total*100);

        $detail = '';
        $nbProducts = $cart->nbProducts();
        if ($nbProducts>1){
            $detail = $this->module->l('Cart').' '.$nbProducts.' '.$this->module->l('Products');
        }else{
            $products = $cart->getProducts();
            $detail = $products[0]['name'];
        }

        $time_start = date("YmdHis");
        $time_expire = date("YmdHis", time() + WXP_TIMEOUT);
        if (WXP_TIMEZONE != Configuration::get('PS_TIMEZONE')) {
            $china_timezone = new DateTimeZone(WXP_TIMEZONE);
            $system_timezone = new DateTimeZone(Configuration::get('PS_TIMEZONE'));
            $start = new DateTime($time_start, $system_timezone);
            $start->setTimezone($china_timezone);
            $time_start = $start->format("YmdHis");

            $expire = new DateTime($time_expire, $system_timezone);
            $expire->setTimezone($china_timezone);
            $time_expire = $expire->format("YmdHis");
        }

        $notify = new NativePay();
        $input = new WxPayUnifiedOrder();
        $input->SetBody($detail);
        $input->SetDetail($detail);
        $input->SetOut_trade_no($reference);
        $input->SetTotal_fee($total);
        $input->SetTime_start($time_start);
        $input->SetTime_expire($time_expire);
        $input->SetNotify_url(Configuration::get('WEIXIN_NOTIFY_URL'));
        $input->SetTrade_type("NATIVE");
        $input->SetProduct_id($reference);
        $result = $notify->getPayUrl($input);

        if (isset($result["code_url"])) {
            return $result["code_url"];
        }

        return false;
    }

    public function generateOrder($id_cart)
    {
        $cart = new Cart((int)$id_cart);

        if (!Validate::isLoadedObject($cart)) {
            return false;
        }

        $customer = new Customer($cart->id_customer);

        if (!Validate::isLoadedObject($customer)) {
            return false;
        }

        $currency = new Currency(Currency::getIdByIsoCode(WXP_CURRENCY_ISO_CODE));
        if (!Validate::isLoadedObject($currency)) {
            return false;
        }

        $weixinpay = new Weixinpay();
        $total = (float) $cart->getOrderTotal(true, Cart::BOTH);

        if ($weixinpay->validateOrder($cart->id, Configuration::get('WEIXIN_STATUS_AWAITING'), $total, $weixinpay->displayName, null, array(), (int) $currency->id, false, $customer->secure_key)) {
            return $weixinpay->currentOrder;
        }

        return false;
    }
}
