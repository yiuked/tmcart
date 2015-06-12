<?php
	if(!$id = Tools::getRequest('id'))
		die('无法载入对象!');
	$obj = Module::loadModule($id);
	echo $obj->getContent();
?>