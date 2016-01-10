<?php
include_once(dirname(__FILE__)."/../../config/config.php");

//init内需要完成后台验证，判断后台登录的用户类型给予用户相关权限.
if(!$cookie->__isset('ad_id_employee') || !$cookie->__isset('ad_passwd')){
	header('Location: login.php?logout');
}elseif(!Employee::checkPassword($cookie->ad_id_employee,$cookie->ad_passwd)){
	header('Location: login.php?logout');
}

//$admin_path = trim(str_replace(_TM_ROOT_DIR_,'',_TM_ADMIN_DIR_),'\\');
//define('_TM_ADMIN_URL',_TM_ROOT_URL_.$admin_path.'/');
?>