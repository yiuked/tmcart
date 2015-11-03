<?php
ob_start();
	require_once(dirname(__FILE__).'/config/config.php');
	$view = View::run();
	$view->display();

?>