<?php
include(dirname(__FILE__).'/../../../config/config.php');
if (!$cookie->isLogged(true) || !isset($_POST['BillNo']))
    Tools::redirect($link->getPage('UserView'));

//获得接口返回数据
$BillNo = $_POST['BillNo'];
$Currency = $_POST['Currency'];
$Amount = $_POST['Amount'];
$Succeed = $_POST['Succeed'];
$Result = $_POST['Result'];
$MD5info = $_POST['MD5info'];
$MD5key = Configuration :: get('MODULE_PAYMENT_SHT_MD5KEY');
$md5src = $BillNo . $Currency . $Amount . $Succeed . $MD5key;
$md5sign = strtoupper(md5($md5src));
$message='';
//基本验证
if ($MD5info == $md5sign) {
	//echo "<br/>md5sign:".$md5sign;
	if ($Currency == '1')
		$Currency = 'USD';
	else if($Currency=='2'){
		$Currency = 'EUR';
	}else if($Currency=='4'){
		$Currency = 'GBP';
	}else if($Currency=='3'){
		$Currency = 'CNY';
	}else{
		$Currency = 'USD';
	}
	//是否成功支付'88''19''1''9'表示支付成功
	if($Succeed =='88'){
	/* if ($Succeed == '88' || $Succeed == '19' || $Succeed == '1' || $Succeed == '9') { */
		$sht_order_status = 2;

	} else {
		$sht_order_status = 3;
	}

} else {
	$sht_order_status = 3;
}
$order = new Order((int)($_POST['BillNo']));
$order->id_order_status = (int)($sht_order_status);
$order->update();
Tools::redirect($link->getPage('PaymentResultView').'?id_module='.$order->id_module.'&id_order='.$order->id);
?>
