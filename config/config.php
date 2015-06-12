<?php
define('_DB_SERVER_', 'localhost');
define('_DB_TYPE_', 'MySQL');
define('_DB_NAME_', 'red_shoes');
define('_DB_USER_', 'root');
define('_DB_PASSWD_', '');
define('_DB_PREFIX_', 'tm_');
define('__TM_BASE_URI__', '/red/shoes/');
define('_TM_THEMES_', 'shop');

define('URL_REWRITE', true);
define('USE_CACHE', false);

define('_TM_VERSION_', '0.1.1');
define('_COOKIE_KEY_', 'MeUFIDgbWnPp7Ffj708TG40Jj7TNBLvoEOa0ZhQFKBvzGV2MbRMHScUn');
define('_COOKIE_IV_', '5DvPoNt2');


/*基本设置*/
@ini_set('display_errors', 'on');
date_default_timezone_set('PRC');
define('_TM_MODE_DEV_', false);

require_once(dirname(__FILE__).'/init.php');
Db::getInstance();
Configuration::loadConfiguration();
if(Configuration::get('TM_SHOP_DOMAIN')!=$_SERVER['HTTP_HOST']){
	header('HTTP/1.1 301 Moved Permanently');
	header('Location: '.Tools::getShopDomain(true).$_SERVER['REQUEST_URI']);
	exit();
}

$cookie = new Cookie();
$cookie->isLogged();

if(isset($cookie->id_cart)&&!Cart::cartIsOrder($cookie->id_cart)){
	$cart = new Cart((int)($cookie->id_cart));
}

if($id_currency = Tools::getRequest('id_currency'))
{
	$currency = new Currency((int)($id_currency));
	$cookie->id_currency = $id_currency;
	$cookie->write();
	if(Validate::isLoadedObject($cart)){
		$cart->id_currency = (int)($id_currency);
		$cart->update();
	}
}
if(!(int)($cookie->id_currency)){
	$currency = new Currency((int)(Configuration::get('ID_CURRENCY_DEFAULT')));
	$cookie->id_currency = $currency->id;
	$cookie->write();
}
if(isset($cart) && !(int)($cart->id_currency)){
	$cart->id_currency = (int)($cookie->id_currency);
	$cart->update();
}

if(isset($_GET['mylogout']))
	$cookie->mylogout();

require_once(dirname(__FILE__).'/smarty.inc.php');

?>