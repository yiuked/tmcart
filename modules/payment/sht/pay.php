<?php
header("Content-type: text/html; charset=utf-8");
function_exists('ignore_user_abort') && ignore_user_abort(false);
session_start();
require_once(dirname(__FILE__).'/../../../config/config.php');
require 'includes/System_Response.php';
require 'includes/Http_Curl_Query.php';
require 'includes/Http_Client.php';

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

$referer = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:_TM_ROOT_URL_;
$homePageUrl = 'http://' . $_SERVER['HTTP_HOST'];
$userAgent = $_SERVER['HTTP_USER_AGENT'];

if(isset($_POST['validateCreditCard'])&&Tools::getRequest('validateCreditCard')=='connect')
{
		if(!isset($cart)){
			if(!isset($cookie->id_cart)||!isset($cookie->id_user)){
				Paylog::msg(0,"100","检测不到id_cart或者id_user");
				die(json_encode(array(
					"isError"=>"YES",
					"msg"=>"100",
				)));
			}
			$cart = new Cart($cookie->id_cart);
		}

		$Amount			= $Amount1 = number_format($cart->getOrderTotal(), 2, '.', '');
		$BillNo			= $cart->id;
		$MerNo 			= Configuration :: get('MODULE_PAYMENT_SHT_SELLER');
		$MD5key 		= Configuration :: get('MODULE_PAYMENT_SHT_MD5KEY');
		$handler 		= Configuration :: get('MODULE_PAYMENT_SHT_HANDLER');
		$ReturnURL 		= Configuration :: get('MODULE_PAYMENT_SHT_RETURN_URL');
		$Language 		= Configuration :: get('MODULE_PAYMENT_SHT_LANGUAGE');
		$Currencytype 	= Configuration :: get('MODULE_PAYMENT_SHT_MONEYTYPE');
		$Currencytype	= getCurrencyType($Currencytype);
		
		$MD5src 	= $MerNo . $BillNo . $Currencytype . $Amount . $Language . $ReturnURL . trim($MD5key);
		$MD5info 	= strtoupper(md5($MD5src));
		
		$data				= $_POST;
		$data['Amount']		= $Amount;//定单金额
		$data['BillNo']		= $BillNo;//定单号
		$data['Currency']	= $Currencytype;//币种
		$data['MD5info']	= $MD5info;//语言 en
		$data['Language']	= $Language;//语言 en
		$data['Remark']		= _TM_ROOT_URL_;//备注
		$data['ReturnURL']	= $ReturnURL;//返回地址
		$data['account_id']	= $MerNo;//商户ID
		$data['order_token']= createToken($data);//表单凭证
		
		$data['MerNo'] 		= $MerNo;
		$data['merchantnoValue'] = $MerNo;
		$data['ip'] 		= Tools::getClientIp();
		
		//发货信息
		$address = new Address((int)$cart->id_address);
		$user	 = new User($cart->id_user);
		$data['shippingAddress']	= $address->address." ".$address->address2;
		$data['shippingCity']		= $address->city;
		$data['shippingCountry']	= $address->country->name;
		$data['shippingEmail']		= $user->email;
		$data['shippingFirstName']	= $address->first_name;
		$data['shippingLastName']	= $address->last_name;
		$data['shippingPhone']		= $address->phone;
		$data['shippingSstate']		= $address->country->need_state?$address->state->name:"";
		$data['shippingZipcode']	= $address->postcode;
		$data['products']			= "";
		
		//validate data
		$requiredField2 = array('MerNo', 'BillNo', 'Currency', 'ReturnURL', 'MD5info', 'merchantnoValue', 'Amount');
		$requiredField3 = array('firstname', 'lastname', 'address', 'city', 'country', 'zipcode', 'email', 'phone');
		$requiredField = array('cardnum', 'cvv2', 'year', 'month', 'cardbank');
		$requiredField = array_merge($requiredField, $requiredField2, $requiredField3);
		
		$fieldError = false;
		$errorCode	= "";
		foreach($requiredField as $field){
			if(!isset($data[$field]) or !preg_match('/.+/s', $data[$field])){
				$fieldError[$field] = "YES";
			}
		}
		
		$emailPattern = '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/';
		if(!preg_match($emailPattern, $data['email'])){
			$fieldError["email"] = "YES";
			$errorCode .= "201,";
		}
		if(!preg_match('/^[-\+]?\d+(\.\d+)?$/', $data['Amount'])){
			$fieldError["Amount"] = "YES";
			$errorCode .= "202,";
		}
		if(!preg_match('/^\d{13,}$/', $data['cardnum'])){
			$fieldError["cardnum"] = "YES";
			$errorCode .= "203,";
		}
		if(!preg_match('/^\d{4}$/', $data['year'])){
			$fieldError["year"] = "YES";
			$errorCode .= "204,";
		}
		if(!preg_match('/^\d+$/', $data['month'])){
			$fieldError["month"] = "YES";
			$errorCode .= "205,";
		}
		if(!preg_match('/^\d{3}/', $data['cvv2'])){
			$fieldError["cvv2"] = "YES";
			$errorCode .= "206,";
		}
		
		if($fieldError){
			Paylog::msg($cart->id,"200",implode(",",$fieldError));
			die(json_encode(array(
				"isError"=>"YES",
				"content"=>$fieldError,
				"msg"=>"200",
			)));
		}
		
		$result = false;
		$error = '';
		$status = 0;
		$type = '';

		if(function_exists('curl_init') && function_exists('curl_exec')){
			$type = 'curl';
			$httpCurlQuery = new Http_Curl_Query();
		
			$headers[] = "Expect: ";
			$status = $httpCurlQuery
				->setOpt(CURLOPT_URL, $handler)
				->setOpt(CURLOPT_SSL_VERIFYPEER, FALSE)
				->setOpt(CURLOPT_SSL_VERIFYHOST, 0)
				->setOpt(CURLOPT_HTTPHEADER, $headers)
				->setOpt(CURLOPT_TIMEOUT, HTTP_TIMEOUT)
				->setOpt(CURLOPT_CONNECTTIMEOUT, HTTP_TIMEOUT)
				->setOpt(CURLOPT_FRESH_CONNECT, 1)
				->httpPost($data)->response['http_code'];
		
			if($status == 200){
				$result = $httpCurlQuery->response['content'];
			}else{
				$error = $httpCurlQuery->response['error'];
			}
		}else if(function_exists('fsockopen')){
			$type = 'fsockopen';
			$parts = parse_url(handler);
			$host = $parts['host'];
			$scheme = isset($parts['scheme']) ? strtolower($parts['scheme']) : '';
			$path = isset($parts['path']) ? $parts['path'] : '/';
		
			if(isset($parts['port'])){
				$port = intval($parts['port']);
			}else{
				if($scheme == 'https'){
					$port = 443;
				}else{
					$port = 80;
				}
			}
		
			$httpClient = new Http_Client($host);
			$httpClient->setDebug(PAY_DEBUG);
			$httpClient->setPersistReferers(false);
			$httpClient->referer = $referer;
			$httpClient->setUserAgent($userAgent);
			$httpClient->timeout = HTTP_TIMEOUT;
		
			$flag = $httpClient->post($path, $data);
			$status = $httpClient->getStatus();
			if($flag === true){
				$result = $httpClient->getContent();
			}else{
				$error = $httpClient->getError();
			}
		}else{
			Paylog::msg($cart->id,"300","尝试curl和fsockopen提交定单到速汇通，均失败!");
			die(json_encode(array(
				"isError"=>"YES",
				"msg"=>"300",
			)));
		}
		
		if($status == 200 && $result){
			parse_str($result, $rData);
			$systemResponse = new System_Response();
			
			Paylog::msg($cart->id,$rData['Succeed'],$systemResponse->getMsg($rData['Succeed']));
			if($rData['Succeed'] == "9"){
				die(json_encode(array(
					"isError"=>"YES",
					"msg"=>"401,Payment Failed!",
				)));
			}
			
			//判断是否支付成功
			$isSystemCode   = $systemResponse->isSucceed($rData['Succeed']);
			if($isSystemCode === true){
				$sht = Module::Hook($data['paymentid']);
				$sht->validateOrder($cart,$sht->id,2);
				$redirct = $link->getPage('PaymentResultView')."?id_order=".$sht->currentOrder."&id_module=".$sht->id."&toke_open=".$data['order_token'];
				die(json_encode(array(
					"isError"=>"NO",
					"redirct"=>$redirct,
					"msg"=>'Transaction has been successfully，the page will redirect after 3 seconds，If there is no redirect, please click <a href="'.$redirct.'">here</a>'
				)));
			}
			
			//检测是为不配置错误
			$isSystemCode   = $systemResponse->isSystem($rData['Succeed']);
			if($isSystemCode === true){
				die(json_encode(array(
					"isError"=>"YES",
					"msg"=>"Payment failed!, Response Code: {$rData['Succeed']},Please check your information or contact the technician",
				)));
			}
			
			//检测是否为用户操作失误
			$isSystemCode   = $systemResponse->isUser($rData['Succeed']);
			if($isSystemCode === true){
				die(json_encode(array(
					"isError"=>"YES",
					"msg"=>"Submit failed!, Response Code: {$rData['Succeed']},Tip:{$systemResponse->userCodeMsg[$rData['Succeed']]}",
				)));
			}
			
		}elseif($status != 200 && $type == 'curl'){
			die(json_encode(array(
				"isError"=>"YES",
				"msg"=>"301:".$error,
			)));
		}elseif($status != 200 && $type == 'fsockopen'){
			die(json_encode(array(
				"isError"=>"YES",
				"msg"=>"302:".$error,
			)));
		}else{
			die(json_encode(array(
				"isError"=>"YES",
				"msg"=>"300",
			)));
		}
}

function createToken($data){
	$encryptStr = session_id() . $data['account_id'] . $data['BillNo'] . $data['Amount'];
	$token = strtoupper(md5($encryptStr));
	$data['order_token'] = $token;
	$_SESSION['order_token'] = $token;
	return $token;
}

function getCurrencyType($Currencytype)
{
	switch($Currencytype)
	{
		case 'USD':$Currencytype='1';break;
		case 'EUR':$Currencytype='2';break;
		case 'CNY':$Currencytype='3';break;
		case 'GBP':$Currencytype='4';break;
		
		case 'HKD':$Currencytype='5';break;
		case 'JPY':$Currencytype='6';break;
		case 'AUD':$Currencytype='7';break;
		case 'CAD':$Currencytype='8';break;
		case 'NOK':$Currencytype='9';break;
		default:$Currencytype='1';break;
	}
	return $Currencytype;
}

?>