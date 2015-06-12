<?php
define('_TM_SMARTY_DIR_', _TM_TOOLS_DIR.'smarty/');
require_once(_TM_SMARTY_DIR_.'Smarty.class.php');

global $smarty;
$smarty = new Smarty();
$smarty->template_dir = _TM_THEMES_DIR;
$smarty->compile_dir = _TM_SMARTY_DIR_.'compile';
$smarty->cache_dir = _TM_SMARTY_DIR_.'cache';
$smarty->caching = false;
$smarty->compile_check = true;
$smarty->debugging = false; 
spl_autoload_register("__autoload");

$link = new Link();
$smarty->assign($_tmconfig);
$smarty->assign(array(
		'link'      => $link,
		'logged'	=> $cookie->logged,
		'shop_name' => Configuration::get('TM_SHOP_NAME')
));

if($cookie->logged){
	$smarty->assign(array(
			'user_email'      => $cookie->email,
			'logged'	=> $cookie->logged
	));
}

smartyRegisterFunction($smarty, 'function', 'displayPrice', array('Tools', 'displayPriceSmarty'));
smartyRegisterFunction($smarty, 'function', 'hookBlock', array('Module', 'hookBlock'));


function smartyRegisterFunction($smarty, $type, $function, $params)
{
	if (!in_array($type, array('function', 'modifier')))
		return false;
	$smarty->registerPlugin($type, $function, $params);
}
?>