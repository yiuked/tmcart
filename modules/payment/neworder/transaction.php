<?php
function execPayment($cart, $additionInfo) {
    global $flag;
	$neworder = new neworder();
	$gatewayUrl = $neworder->getGatewayUrl();
	$mycurrency = new Currency($cart->id_currency);
    $postData = buildNameValueList($neworder,$cart,$mycurrency, $additionInfo);

	$result = payment_submit($gatewayUrl,$postData );

	if ($result == false) {
		return false; 
    }
    $resultObject = json_decode($result,TRUE);
    if($resultObject["status"]!="0000"){
        $resultObject["orderNo"] = substr($postData["OrderID"],8);
        $resultObject["amount"] = $postData["Amount"] / 100;
        $resultObject["orderCurrency"] = $mycurrency->iso_code ;
    }
	return $resultObject;
}

function buildNameValueList($neworder,$cart,$mycurrency, $additionInfo) {
	$merNo 			= trim(Configuration::get('NEWORDER_MERCHANT_NO'));
    $signKey 		= trim(Configuration::get('NEWORDER_MERCHANT_KEY'));
    $orderAmount	= number_format($cart->getOrderTotal(), 2, '.', '');
    
	$orderNo	= 'NB-'.$cart->id;
    $billInfo 	= new Address(intval($cart->id_address));
    $customer 	= new User(intval($cart->id_user));
    $shipInfo 	= $billInfo;

    $message 	= $cart->msg;
	$shipFee 	= number_format($cart->getShippingTotal(), 2, '.', '');

    $orderCurrency 	= toCurrencyCode($mycurrency->iso_code);
	//账单地址
    $firstName 		= $billInfo->first_name;
    $lastName 		= $billInfo->last_name;
    $address 		= strtolower($billInfo->address . $billInfo->address2);
    $city 			= $billInfo->city;
	$state			= "";
	if($billInfo->id_state>0){
    	$_state 		= new State((int)$billInfo->id_state);
    	$state 			= $_state->name;
	}
    $country 		= $billInfo->country->name;
    $zip 			= $billInfo->postcode;
    $email 			= $customer->email;
    $phone 			= $billInfo->phone;
	//发货地址
    $shipFirstName 	= $shipInfo->first_name;
    $shipLastName 	= $shipInfo->last_name;
    $shipZip 		= $shipInfo->postcode;
    $shipAddress 	= strtolower($shipInfo->address . $shipInfo->address2);
    $shipCity 		= $shipInfo->city;
    $shipState 		= $state;
    $shipCountry 	= $shipInfo->country->name;
    $countryCode	= $shipInfo->country->iso_code;
    $shipPhone 		= $shipInfo->phone;
    $shipEmail 		= $email;

    $cardNo 			= $additionInfo["CardPAN"];
    $cardSecurityCode 	= $additionInfo["CVV2"];
    $cardExpireMonth 	= $additionInfo["ExpirationMonth"];
    $cardExpireYear 	= substr($additionInfo["ExpirationYear"],2);;
    $ip 				= get_client_ip();
    $userAgent 			= $_SERVER['HTTP_USER_AGENT'];
    $webSite 			= $_SERVER["HTTP_HOST"];
   
    $products = $cart->getProducts();
    $goodsInfo = "";
    for ($i = 0; $i < count($products); $i++) {
        $goodsInfo.= md5($products[$i]["name"]) . "#,#" . $products[$i]["id_product"] . "#,#" . number_format($products[$i]["price"], 2, '.', '') . "#,#" . $products[$i]["quantity"] . "#;#";
    }
    $_shipMethod 	= new Carrier(intval($cart->id_carrier));
    $shipMethod 	= $_shipMethod->name;
	//配置到那去的？
    $notifyUrl 		= 'http://' . $_SERVER['HTTP_HOST'] . __TM_BASE_URI__ . 'modules/payment/neworder/notify.php';
    $remark 		= trim($message);
    $signSrc 		= $signKey.$merNo.(date('Ymd').$orderNo).($orderAmount *100).$orderCurrency;
	$hasValue 		= szComputeMD5Hash($signSrc);
	$cookies 		= '';
	foreach ($_COOKIE as $key=>$val)
	{
		$cookies = $cookies. $key.'='.$val.';';
	}
    $lang 			= Configuration::get('NEWORDER_MERCHANT_LANG');

	$data = array(
		'URL' => $webSite,
		'AcctNo' => $merNo,
		'CartID'=>$neworder->generateOrderNo($cart->id), 
		'OrderID' => $neworder->generateOrderNo($orderNo), 
		'CurrCode' => $orderCurrency,
		'Amount' => $orderAmount * 100,
		'IPAddress' => $ip,
		'Telephone' => $shipPhone,
		'CName' => $shipFirstName.' '.$shipLastName,
		'ExpDate' => $cardExpireYear.''.$cardExpireMonth,
		'BAddress' => $address,
		'BCity' => $shipCity,
		'PostCode' => $shipZip,
		'Email' => $email,
		'Bstate' => $shipState,
		'Bcountry' => $country,
		'PName' => string_replace($goodsInfo),
		'HashValue' => $hasValue,
		'OrderUrl' => $webSite,
		'Framework' => 'TMShop',
		'BCountryCode' => $countryCode,
		'CardPAN' => $cardNo, 
		'ExpirationMonth' => $cardExpireMonth,
		'ExpirationYear' => $cardExpireYear,
		'CVV2' => $cardSecurityCode,
		'IFrame'=>'1',
		'cookies'=>$cookies,
		'IVersion' => $neworder->IVersion,
		'Language' => $lang,
    );
    return $data;
}
function http_response($url, $data=null,$status = null, $wait = 3){ 
	$time = microtime(true); 
	$expire = $time + $wait; 
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL, $url); 
	curl_setopt($ch, CURLOPT_HEADER, FALSE);         
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);   
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);	
	$returnInfo = curl_exec($ch);         
	return $returnInfo;
}
	
function szComputeMD5Hash($input){
	  $md5hex=md5($input); 
	  $len=strlen($md5hex)/2; 
      $md5raw=""; 
      for($i=0;$i<$len;$i++) { $md5raw=$md5raw . chr(hexdec(substr($md5hex,$i*2,2))); } 
      $keyMd5=base64_encode($md5raw); 
	  return $keyMd5;
}
   
function payment_submit($payUrl, $data) {
    $info = curl_post($payUrl, http_build_query($data, '', '&'));
    return $info;
}
function http_pos($payUrl, $data) {
    $options = array(
        'http' => array(
            'method' => "POST",
            'header' => "Accept-language: en\r\n" . "Cookie: foo=bar\r\n",
            'content-type' => "multipart/form-data",
            'content' => $data,
            'timeout' => 15 * 20
        )
    );
    $context = stream_context_create($options);
    $result = file_get_contents($payUrl, false, $context);
    return $result;
}
function curl_post($payUrl, $data) {
    $curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $payUrl);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
    @curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_REFERER, $_SERVER['HTTP_REFERER']);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_TIMEOUT, 300);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $tmpInfo = curl_exec($curl);
    if (curl_errno($curl)) {
        return false;
    }
    curl_close($curl);
    return $tmpInfo;
}
function string_replace($string_before) {
    $string_after = str_replace("\n", " ", $string_before);
    $string_after = str_replace("\r", " ", $string_after);
    $string_after = str_replace("\r\n", " ", $string_after);
    $string_after = str_replace("'", "&#39 ", $string_after);
    $string_after = str_replace('"', "&#34 ", $string_after);
    $string_after = str_replace("(", "&#40 ", $string_after);
    $string_after = str_replace(")", "&#41 ", $string_after);
    return $string_after;
}
function get_client_ip() {
    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $online_ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $online_ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['HTTP_X_REAL_IP'])) {
        $online_ip = $_SERVER['HTTP_X_REAL_IP'];
    } else {
        $online_ip = $_SERVER['REMOTE_ADDR'];
    }
    $ips = explode(",", $online_ip);
    return $ips[0];
}
function getBrowserLang() {
    $acceptLan = '';
    if (isSet($_SERVER['HTTP_ACCEPT_LANGUAGE']) && !empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
        $acceptLan = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
        $acceptLan = $acceptLan[0];
    }
    return $acceptLan;
}
function toCurrencyCode($Currency){
$_95currency = "";
 switch ($Currency) {
			case 'USD' :
				$_95currency = '840';
				break;
			case 'EUR' :
				$_95currency = '978';
				break;
			case 'CNY' :
				$_95currency = '156';
				break;
			case 'GBP' :
				$_95currency = '826';
				break;
			case 'JPY' :
				$_95currency = '392';
				break;
			case 'HKD' :
				$_95currency = '344';
				break;
			case 'CAD' :
				$_95currency = '124';
				break;
			case 'DKK' :
				$_95currency = '208';
				break;
			case 'IDR' :
				$_95currency = '360';
				break;
			case 'ILS' :
				$_95currency = '376';
				break;
			case 'KRW' :
				$_95currency = '410';
				break;
			case 'MOP' :
				$_95currency = '446';
				break;
			case 'MYR' :
				$_95currency = '458';
				break;
			case 'NOK' :
				$_95currency = '578';
				break;
			case 'PHP' :
				$_95currency = '608';
				break;
			case 'RUB' :
				$_95currency = '643';
				break;
			case 'SGD' :
				$_95currency = '702';
				break;
			case 'ZAR' :
				$_95currency = '710';
				break;
			case 'SEK' :
				$_95currency = '752';
				break;
			case 'CHF' :
				$_95currency = '756';
				break;
			case 'TWD' :
				$_95currency = '901';
				break;
			case 'TRY' :
				$_95currency = '949';
				break;
			case 'NZD' :
				$_95currency = '554';
				break;
			case 'MXN' :
				$_95currency = '484';
				break;
			case 'BRL' :
				$_95currency = '986';
				break;
			case 'ARS' :
				$_95currency = '032';
				break;
			case 'PEN' :
				$_95currency = '604';
				break;
			case 'CLF' :
				$_95currency = '990';
				break;
			case 'COP' :
				$_95currency = '170';
				break;
			case 'VEF' :
				$_95currency = '862';
				break;
			default :
				$_95currency = '840';
				break;
		}	
	return $_95currency;
}
function getBrowser() {
    if (empty($_SERVER['HTTP_USER_AGENT'])) {
        return '';
    }
    if (false !== strpos($_SERVER['HTTP_USER_AGENT'], 'rv:11.0')) {
        return 'IE';
    }
    if (false !== strpos($_SERVER['HTTP_USER_AGENT'], 'rv:11.0') || false !== strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 10.0')) {
        return 'IE';
    }
    if (false !== strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 9.0')) {
        return 'IE';
    }
    if (false !== strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 8.0')) {
        return 'IE';
    }
    if (false !== strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 7.0')) {
        return 'IE';
    }
    if (false !== strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6.0')) {
        return 'IE';
    }
    if (false !== strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE')) {
        return 'IE';
    }
    if (false !== strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox')) {
        return 'Firefox';
    }
    if (false !== strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome')) {
        return 'Chrome';
    }
    if (false !== strpos($_SERVER['HTTP_USER_AGENT'], 'Safari')) {
        return 'Safari';
    }
    if (false !== strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') || false !== strpos($_SERVER['HTTP_USER_AGENT'], 'OPR')) {
        return 'Opera';
    }
    if (false !== strpos($_SERVER['HTTP_USER_AGENT'], '360SE')) {
        return '360SE';
    }
    return '';
}
?>
