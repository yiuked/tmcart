<?php
include_once(dirname(__FILE__) . "/../../config/config.php");

//init内需要完成后台验证，判断后台登录的用户类型给予用户相关权限.
if(!$cookie->__isset('ad_id_employee') || !$cookie->__isset('ad_passwd')){
	header('Location: login.php?logout');
}elseif(!Employee::checkPassword($cookie->ad_id_employee,$cookie->ad_passwd)){
	header('Location: login.php?logout');
}

define('ADMIN_DIR', realpath(dirname(__FILE__) . '/../'));
define('ADMIN_BLOCK_DIR', ADMIN_DIR . '/block/');
