<?php
if (!defined('_TM_MAGIC_QUOTES_GPC_'))
	define('_TM_MAGIC_QUOTES_GPC_',         get_magic_quotes_gpc());
if (!defined('_TM_MYSQL_REAL_ESCAPE_STRING_'))
	define('_TM_MYSQL_REAL_ESCAPE_STRING_', function_exists('mysql_real_escape_string'));

define('_TM_BASE_URL_', Tools::getShopDomain(true));
define('_TM_ROOT_URL_', _TM_BASE_URL_.__TM_BASE_URI__);

$currentDir = dirname(__FILE__);
define('_TM_ROOT_DIR_',realpath($currentDir.'/..'));

define('_TM_THEMES_DIR', _TM_ROOT_DIR_.'/themes/'._TM_THEMES_.'/');
define('_TM_TOOLS_DIR', _TM_ROOT_DIR_.'/tools/');
define('_TM_SWIFT_DIR', _TM_TOOLS_DIR.'/swift/');
define('_TM_MODULES_DIR', _TM_ROOT_DIR_.'/modules/');
define('_TM_PAYMENT_DIR', _TM_MODULES_DIR.'/payment/');
define('_TM_TEMP_DIR', _TM_ROOT_DIR_.'/temp/');
define('_TM_IMG_DIR', _TM_ROOT_DIR_.'/images/');
define('_TM_PRO_IMG_DIR', _TM_IMG_DIR.'pro/');
define('_TM_TMP_IMG_DIR', _TM_IMG_DIR.'tmp/');
define('_TM_VIEWS_DIR', _TM_ROOT_DIR_.'/views/');
define('_TM_FSO_DIR', _TM_ROOT_DIR_.'/cache/fso/');

define('_TM_JS_URL', _TM_ROOT_URL_.'js/');
define('_TM_JQ_URL', _TM_JS_URL.'jquery/');
define('_TM_JQP_URL', _TM_JQ_URL.'plugins/');
define('_TM_IMG_URL', _TM_ROOT_URL_.'images/');
define('_TM_MOD_URL', _TM_ROOT_URL_.'modules/');
define('_TM_PRO_URL', _TM_IMG_URL.'pro/');
define('_TM_THEMES_URL', _TM_ROOT_URL_.'themes/'._TM_THEMES_.'/');

$_tmconfig = array(
	'root_dir'	=> _TM_ROOT_URL_,
	'tm_img_dir'	=> _TM_ROOT_URL_.'images/',
	'ico_dir'	=> _TM_ROOT_URL_.'images/icon/',
	'adm_dir'	=> _TM_ROOT_URL_.'images/admin/',
	'pro_dir'	=> _TM_ROOT_URL_.'images/pro/',
	'car_dir'	=> _TM_ROOT_URL_.'images/car/',
	'brand_dir'	=> _TM_ROOT_URL_.'images/brand/',
	'tm_css_dir'	=> _TM_ROOT_URL_.'css/',
	'tm_js_dir'	=> _TM_ROOT_URL_.'js/',
	'tools_dir'=>_TM_ROOT_URL_.'tools/',
	'pay_dir' => _TM_MOD_URL.'payment/',
	'img_dir' =>_TM_THEMES_URL.'img/',
	'css_dir' =>_TM_THEMES_URL.'css/',
	'js_dir' =>_TM_THEMES_URL.'js/',
	'tpl_dir' =>_TM_THEMES_DIR,	
);


function __autoload($className)
{
	if(file_exists(dirname(__FILE__).'/../classes/'.$className.'.php'))
		require_once(dirname(__FILE__).'/../classes/'.$className.'.php');
	elseif(file_exists(dirname(__FILE__).'/../class/lib/'.$className.'.php'))
		require_once(dirname(__FILE__).'/../class/lib/'.$className.'.php');
	elseif(file_exists(dirname(__FILE__).'/../views/'.$className.'.php'))
		require_once(dirname(__FILE__).'/../views/'.$className.'.php');
	else
		die('Class \''.$className.'\' not found!');
}
?>