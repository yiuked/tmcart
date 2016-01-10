<?php
header("Content-type: text/html; charset=utf-8");
function_exists('ignore_user_abort') && ignore_user_abort(false);
session_start();
include(dirname(__FILE__) . '/../../../config/config.php');
include(dirname(__FILE__).'/neworder.php');
include(dirname(__FILE__).'/transaction.php');

define('HTTP_TIMEOUT', 180);
if(!ini_get('safe_mode')){
    @set_time_limit((HTTP_TIMEOUT + 10));
}
if(ini_get('max_execution_time') < HTTP_TIMEOUT){
    @ini_set('max_execution_time', (HTTP_TIMEOUT + 10));
}

define('PAY_DEBUG', true);

if(PAY_DEBUG){
    error_reporting(E_ALL);
    @ini_set('display_errors', 'On');
}else{
    error_reporting(0);
}

if(isset($_POST['validateCreditCard'])&&Tools::getRequest('validateCreditCard')=='connect')
{
	if (!$cookie->isLogged()) {
			Paylog::msg(0,"101","用户未登录");
			die(json_encode(array(
				"isError"=>"YES",
				"msg"=>"Payment failed!, Response Code:101",
			)));
	}
	if(!isset($cart)){
		if(!isset($cookie->id_cart)||!isset($cookie->id_user)){
			Paylog::msg(0,"102","检测不到id_cart或者id_user");
			die(json_encode(array(
				"isError"=>"YES",
				"msg"=>"Payment failed!, Response Code:102",
			)));
		}
		$cart = new Cart($cookie->id_cart);
	}

	$additionInfo = array(
		'CardPAN' => $_POST['neworder_cardNo'],
		'CVV2' => $_POST['neworder_cardSecurityCode'],
		'ExpirationMonth' => $_POST['neworder_cardExpireMonth'],
		'ExpirationYear' => $_POST['neworder_cardExpireYear'],
	);
	$paymentid = (int)$_POST['neworder_paymentid'];
	$neworder = new neworder();

	if ($cart->id_user == 0 OR $cart->id_address == 0) {
		Paylog::msg($cart->id,"103","用户ID为0或者地址ID为0或者支付模块未启用");
		die(json_encode(array(
			"isError"=>"YES",
			"msg"=>"Payment failed!, Response Code:103",
		)));
	}

	$payResultJson = execPayment($cart, $additionInfo);
	if(!$payResultJson)
	{
		//支付过程提交请求失败.
		Paylog::msg($cart->id,"201","支付请求没有连接到服务器");
		die(json_encode(array(
			"isError"=>"YES",
			"msg"=>"Payment failed!, Response Code:201",
		)));
	}

	$status = $payResultJson['status'];
	$siteOrderNo = $payResultJson["orderNo"];
	$amount = $payResultJson["amount"];
	$currCode = $payResultJson["orderCurrency"];
	$errorMessage = $payResultJson["msg"];
	$messages = $neworder->getMessages();
	$orderNoLabel = $messages["lblOrderNumber"];
	$amountLabel = $messages["lblpayment"];
	$isPendingPayment = $payResultJson["isPendingPayment"];

	if($status=="0000"){
		$orderNo		= $payResultJson['data']['orderNO'];
		$siteOrderNo	= substr($orderNo,8);
		$amount			= $payResultJson['data']['amount'];
		$currCode		= $payResultJson['data']['par6'];
		$pkid			= $payResultJson["data"]["par3"];
		$acctNo			= $payResultJson["data"]["par1"];
		$result			= $payResultJson["data"]["par5"];
		$succeed		= $payResultJson["data"]["par4"];
		$hashValue		= $payResultJson['data']['hashValue'];
		$signkey		= trim(Configuration::get('NEWORDER_MERCHANT_KEY'));
		$signSrc		= $signkey.$acctNo.$orderNo.$pkid.$succeed.$result.$currCode;
		$signInfo		= szComputeMD5Hash($signSrc);

		if($hashValue == $signInfo){
			if ($succeed=="00") {
        Paylog::msg($cart->id,"00","支付成功");
				$pay = Module::Hook($paymentid);
				$pay->validateOrder($cart,$pay->id,2);
				$order = new Order($pay->currentOrder);
				$redirct = $link->getPage('PaymentResultView')."?id_order=".$pay->currentOrder."&id_module=".$paymentid."&toke_open=".md5($order->id_user);
				die(json_encode(array(
					"isError"=>"NO",
					"redirct"=>$redirct,
					"msg"=>'Transaction has been successfully，the page will redirect after 3 seconds，If there is no redirect, please click <a href="'.$redirct.'">here</a>'
				)));
			 }else{
				//信息不是从支付服务器返回
				Paylog::msg($cart->id,"202","返回状态码是成功,但succeed不为00".(empty($errorMessage)?$messages["errorNote"]:str_replace("@@@",$errorMessage, $messages["payFailure"])));
				die(json_encode(array(
					"isError"=>"YES",
					"isPendingPayment"=>$isPendingPayment,
					"msg"=>"Payment failed!, Response Code: 202,".(empty($errorMessage)?$messages["errorNote"]:str_replace("@@@",$errorMessage, $messages["payFailure"])),
				)));
			 }
		}else{
			//信息不是从支付服务器返回
			Paylog::msg($cart->id,"203","返回状态码是成功的，但hash验证失败，信息可能不是从服务器传回");
			die(json_encode(array(
				"isError"=>"YES",
				"msg"=>"Payment failed!, Response Code:203",
			)));
		}
	}else{
		Paylog::msg($cart->id,"204",(empty($errorMessage)?$messages["errorNote"]:str_replace("@@@",$errorMessage, $messages["payFailure"])));
		die(json_encode(array(
			"isError"=>"YES",
			"isPendingPayment"=>$isPendingPayment,
			"msg"=>"Payment failed!, Response Code: 204,".(empty($errorMessage)?$messages["errorNote"]:str_replace("@@@",$errorMessage, $messages["payFailure"])),
		)));
	}

	function _getFormatedAddress(Address $the_address, $line_sep, $fields_style = array()) {
		return AddressFormat::generateAddress($the_address, array('avoid' => array()), $line_sep, ' ', $fields_style);
	}
}
?>
