<?php
ob_start();
	require_once(dirname(__FILE__).'/config/config.php');
	$view = View::run();
	$view->display();
	if(false!==0){
		echo 'xxx';
	}else{
		echo 'ooo';
	}
?>