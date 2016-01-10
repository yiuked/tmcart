<?php
include_once(dirname(__FILE__)."/../../config/config.php");

if (array_key_exists('submitLogin', $_POST))
{
	$passwd 	= pSQL(Tools::getRequest('passwd'));
	$email 		= pSQL(Tools::getRequest('email'));
	
	if (!Validate::isEmail($email) OR ($passwd != NULL AND !Validate::isPasswd($passwd)))
		die(json_encode(array('hasErrors'=>true,'errors'=>array('邮箱或密码不能为空！'))));
	
	$employee 	=  new Employee();
	if($employee->getByEmail($email) && $employee->passwd == Tools::encrypt($passwd)){
			/* Creating cookie */
			$cookie->ad_id_employee 	= $employee->id;
			$cookie->ad_name 			= $employee->name;
			$cookie->ad_email 			= $employee->email;
			$cookie->ad_passwd 			= $employee->passwd;
			$cookie->ad_remote_addr 	= ip2long(Tools::getRemoteAddr());
			$cookie->write();
		die(json_encode(array('hasErrors'=>false)));
	}else
		die(json_encode(array('hasErrors'=>true,'errors'=>array('邮箱或密码有误！'))));
}