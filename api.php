<?php
require_once(dirname(__FILE__).'/config/config.php');
extract($_GET);
if(isset($rule)&&isset($token)){
	switch($rule){
		case 'track':
			if(isset($order)&&isset($number)){
				if(sendTrack($order,$number)){
					sendJson('NO');
				}
				sendJson('YES','Update fail!');
			}
			break;
	}
	sendJson('YES','Args is error');
}else{
	sendJson('YES','unkonw');
}

function sendTrack($id_order,$number)
{
	$order = new Order($id_order);
	
	if(!Validate::isLoadedObject($order))
		sendJson('YES','Order id is not find!');
		
	$order->track_number = $number;
	return $order->update();
}

function sendJson($isError,$msg="Not define")
{
	die(json_encode(array('isError'=>$isError,'msg'=>$msg)));
}
?>