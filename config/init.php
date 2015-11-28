<?php
$currentDir = dirname(__FILE__);
define('_TM_ROOT_DIR_',realpath($currentDir.'/..'));

//网站目录定义
define('_TM_CORE_DIR', _TM_ROOT_DIR_.'/core/');
define('_TM_MODEL_DIR', _TM_ROOT_DIR_.'/model/');
define('_TM_CONF_DIR', _TM_ROOT_DIR_.'/config/');
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
define('_TM_CACHE_DIR', _TM_ROOT_DIR_.'/cache/');
define('_TM_FSO_DIR', _TM_CACHE_DIR.'fso/');

//include auto load
require_once(_TM_CONF_DIR . 'autoload.php');

//网站URL定义
define('_TM_BASE_URL_', Tools::getShopDomain(true));
define('_TM_ROOT_URL_', _TM_BASE_URL_.__TM_BASE_URI__);
define('_TM_JS_URL', _TM_ROOT_URL_.'js/');
define('_TM_JS_ADM_URL', _TM_JS_URL.'admin/');
define('_TM_CSS_URL', _TM_ROOT_URL_.'css/');
define('_TM_CSS_ADM_URL', _TM_CSS_URL.'admin/');
define('_TM_JQ_URL', _TM_JS_URL.'jquery/');
define('_TM_JQP_URL', _TM_JQ_URL.'plugins/');
define('_TM_IMG_URL', _TM_ROOT_URL_.'images/');
define('_TM_MOD_URL', _TM_ROOT_URL_.'modules/');
define('_TM_PRO_URL', _TM_IMG_URL.'pro/');
define('_TM_THEMES_URL', _TM_ROOT_URL_.'themes/'._TM_THEMES_.'/');

//include bootstrap config
require_once(_TM_CONF_DIR . 'bootstrap.php');

$_tmconfig = array(
	'root_dir'	=> _TM_ROOT_URL_,
	'tm_img_dir' => _TM_ROOT_URL_.'images/',
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

?>