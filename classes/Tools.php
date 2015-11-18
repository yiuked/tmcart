<?php
class Tools{

	/**
	 * getHttpHost return the <b>current</b> host used, with the protocol (http or https) if $http is true
	 * This function should not be used to choose http or https domain name.
	 * Use Tools::getShopDomain() or Tools::getShopDomainSsl instead
	 *
	 * @param boolean $http
	 * @param boolean $entities
	 * @return string host
	 */
	public static function getHttpHost($http = false, $entities = false)
	{
		$host = (isset($_SERVER['HTTP_X_FORWARDED_HOST']) ? $_SERVER['HTTP_X_FORWARDED_HOST'] : $_SERVER['HTTP_HOST']);
		if ($entities)
			$host = htmlspecialchars($host, ENT_COMPAT, 'UTF-8');
		//if ($http)
		//	$host = (Configuration::get('PS_SSL_ENABLED') ? 'https://' : 'http://').$host;
		return $host;
	}
	/*
	生成随机密码
	参数
	$length 参数长度
	$flag 密码类别，NUMERIC为纯数字密码，NO_NUMERIC为字母密码，默认为数字加字母
	返回值
	返回一个指定长度与类别的密码
	*/
	public static function passwdGen($length = 8, $flag = 'ALPHANUMERIC')
	{
		switch ($flag)
		{
			case 'NUMERIC':
				$str = '0123456789';
				break;
			case 'NO_NUMERIC':
				$str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
				break;
			default:
				$str = 'abcdefghijkmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
				break;
		}

		for ($i = 0, $passwd = ''; $i < $length; $i++)
			$passwd .= Tools::substr($str, mt_rand(0, Tools::strlen($str) - 1), 1);
		return $passwd;
	}
	
	/**
	*获取客户端IP地址
	*/
	function getClientIp() {
		$ip = NULL;
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
			$pos =  array_search('unknown',$arr);
			if(false !== $pos) unset($arr[$pos]);
			$ip   =  trim($arr[0]);
		}elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}elseif (isset($_SERVER['REMOTE_ADDR'])) {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		// IP地址合法验证
		$ip = (false !== ip2long($ip)) ? $ip : '0.0.0.0';
		return $ip;
	}
	
	function isGoogleBot($ip=false)
	{
		if($ip)
			$ip = isset($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:'0.0.0.0';
		$ipint = ip2long($ip);
		if($ipint>=ip2long("64.68.80.0")&&$ipint<=ip2long("64.68.92.255"))
			return true;
		elseif($ipint>=ip2long("64.233.160.0")&&$ipint<=ip2long("64.233.191.255"))
			return true;
		elseif($ipint>=ip2long("66.102.0.0")&&$ipint<=ip2long("66.102.15.255"))
			return true;
		elseif($ipint>=ip2long("66.249.64.0")&&$ipint<=ip2long("66.249.95.255"))
			return true;
		elseif($ipint>=ip2long("72.14.192.0")&&$ipint<=ip2long("72.14.255.255"))
			return true;
		elseif($ipint>=ip2long("74.125.0.0")&&$ipint<=ip2long("74.125.255.255"))
			return true;
		elseif($ipint>=ip2long("209.85.128.0")&&$ipint<=ip2long("209.85.255.255"))
			return true;
		elseif($ipint>=ip2long("209.185.108.0")&&$ipint<=ip2long("209.85.255.255"))
			return true;
		elseif($ipint>=ip2long("216.33.229.0")&&$ipint<=ip2long("216.33.229.255"))
			return true;
		elseif($ipint>=ip2long("216.239.32.0")&&$ipint<=ip2long("216.239.63.255"))
			return true;
		return false;
	}
	
	/**
	 * getShopDomain returns domain name according to configuration and ignoring ssl
	 *
	 * @param boolean $http if true, return domain name with protocol
	 * @param boolean $entities if true,
	 * @return string domain
	 */
	public static function getShopDomain($http = false, $entities = false)
	{
		if (!($domain = Configuration::get('TM_SHOP_DOMAIN')))
			$domain = self::getHttpHost();
		if ($entities)
			$domain = htmlspecialchars($domain, ENT_COMPAT, 'UTF-8');
		if ($http)
			$domain = 'http://'.$domain;
		return $domain;
	}
	
	public static function getLink($alias)
	{
		if(URL_REWRITE)
			return _TM_ROOT_URL_.$alias;
		else
			return _TM_ROOT_URL_.'index.php?rule='.$alias;
	}
	
	/**
	* Sanitize a string
	*
	* @param string $string String to sanitize
	* @param boolean $full String contains HTML or not (optional)
	* @return string Sanitized string
	*/
	public static function safeOutput($string, $html = false)
	{
	 	if (!$html)
			$string = strip_tags($string);
		return @Tools::htmlentitiesUTF8($string, ENT_QUOTES);
	}
	
	public static function htmlentitiesUTF8($string, $type = ENT_QUOTES)
	{
		if (is_array($string))
			return array_map(array('Tools', 'htmlentitiesUTF8'), $string);
		return htmlentities($string, $type, 'utf-8');
	}
	
	/**
	* Get a value from $_POST / $_GET
	* if unavailable, take a default value
	*
	* @param string $key Value key
	* @param mixed $defaultValue (optional)
	* @return mixed Value
	*/
	public static function getRequest($key, $defaultValue = false)
	{
	 	if (!isset($key) OR empty($key) OR !is_string($key))
			return false;

		$ret = (isset($_POST[$key]) ? $_POST[$key] : (isset($_GET[$key]) ? $_GET[$key] : $defaultValue));

		if (is_string($ret) === true)
			$ret = urldecode(preg_replace('/((\%5C0+)|(\%00+))/i', '', urlencode($ret)));
		return !is_string($ret)? $ret : stripslashes($ret);
	}

	public static  function Q($key, $defaultValue = false)
	{
		if (!isset($key) OR empty($key) OR !is_string($key))
			return false;

		$ret = (isset($_POST[$key]) ? $_POST[$key] : (isset($_GET[$key]) ? $_GET[$key] : $defaultValue));

		if (is_string($ret) === true)
			$ret = urldecode(preg_replace('/((\%5C0+)|(\%00+))/i', '', urlencode($ret)));
		return !is_string($ret)? $ret : stripslashes($ret);
	}

	public static function P($key, $defaultValue = false)
	{
		if (!isset($key) OR empty($key) OR !is_string($key))
			return false;
		$ret =  isset($_POST[$key]) ? $_POST[$key] : $defaultValue;

		if (is_string($ret) === true)
			$ret = urldecode(preg_replace('/((\%5C0+)|(\%00+))/i', '', urlencode($ret)));
		return !is_string($ret)? $ret : stripslashes($ret);
	}

	public static function G($key, $defaultValue = false)
	{
		if (!isset($key) OR empty($key) OR !is_string($key))
			return false;
		$ret =  isset($_GET[$key]) ? $_GET[$key] : $defaultValue;

		if (is_string($ret) === true)
			$ret = urldecode(preg_replace('/((\%5C0+)|(\%00+))/i', '', urlencode($ret)));
		return !is_string($ret)? $ret : stripslashes($ret);
	}
	
	public static function isEmpty($field)
	{
		return ($field === '' OR $field === NULL);
	}
	
	public static function strlen($str, $encoding = 'UTF-8')
	{
		if (is_array($str))
			return false;
		$str = html_entity_decode($str, ENT_COMPAT, 'UTF-8');
		if (function_exists('mb_strlen'))
			return mb_strlen($str, $encoding);
		return strlen($str);
	}

	public static function substr($str, $start, $length = false, $encoding = 'utf-8')
	{
		if (is_array($str))
			return false;
		if (function_exists('mb_substr'))
			return mb_substr($str, (int)$start, ($length === false ? Tools::strlen($str) : (int)$length), $encoding);
		return substr($str, $start, ($length === false ? Tools::strlen($str) : (int)$length));
	}
	
	/**
	* Redirect user to another page
	*
	* @param string $url Desired URL
	* @param string $baseUri Base URI (optional)
	*/
	public static function redirect($url, $baseUri = __TM_BASE_URI__)
	{
		if (strpos($url, 'http://') === FALSE && strpos($url, 'https://') === FALSE)
		{
			global $link;
			if (strpos($url, $baseUri) !== FALSE && strpos($url, $baseUri) == 0)
				$url = substr($url, strlen($baseUri));
			$explode = explode('?', $url, 2);
			// don't use ssl if url is home page
			// used when logout for example
			$useSSL = !empty($url);
			$url = $link->getPageLink($explode[0], $useSSL);
			if (isset($explode[1]))
				$url .= '?'.$explode[1];
			$baseUri = '';
		}

		if (isset($_SERVER['HTTP_REFERER']) AND ($url == $_SERVER['HTTP_REFERER']))
			header('Location: '.$_SERVER['HTTP_REFERER']);
		else
			header('Location: '.$url);
		exit;
	}
	
	/**
	* Display an error according to an error code
	*
	* @param string $string Error message
	* @param boolean $htmlentities By default at true for parsing error message with htmlentities
	*/
	public static function displayError($string = 'Fatal error', $htmlentities = true)
	{
		global $_ERRORS, $cookie;

		return str_replace('"', '&quot;', stripslashes($string));
	}
	
	/**
	 * Display error and dies or silently log the error.
	 *
	 * @param string $msg
	 * @param bool $die
	 * @return success of logging
	 */
	public static function dieOrLog($msg, $die = true)
	{
		if ($die || (defined('_TM_MODE_DEV_') && _TM_MODE_DEV_))
			die($msg);
		return Logger::addLog($msg);
	}	
	
	/**
	* Encrypt password
	*
	* @param object $object Object to display
	*/
	public static function encrypt($passwd)
	{
		return md5(pSQL(_COOKIE_KEY_.$passwd));
	}
	
	/**
	* Check if submit has been posted
	*
	* @param string $submit submit name
	*/
	public static function isSubmit($submit)
	{
		return (
			isset($_POST[$submit]) OR isset($_POST[$submit.'_x']) OR isset($_POST[$submit.'_y'])
			OR isset($_GET[$submit]) OR isset($_GET[$submit.'_x']) OR isset($_GET[$submit.'_y'])
		);
	}

	/**
	* Get the server variable REMOTE_ADDR, or the first ip of HTTP_X_FORWARDED_FOR (when using proxy)
	*
	* @return string $remote_addr ip of client
	*/
	static function getRemoteAddr()
	{
		// This condition is necessary when using CDN, don't remove it.
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) AND $_SERVER['HTTP_X_FORWARDED_FOR'] AND (!isset($_SERVER['REMOTE_ADDR']) OR preg_match('/^127\..*/i', trim($_SERVER['REMOTE_ADDR'])) OR preg_match('/^172\.16.*/i', trim($_SERVER['REMOTE_ADDR'])) OR preg_match('/^192\.168\.*/i', trim($_SERVER['REMOTE_ADDR'])) OR preg_match('/^10\..*/i', trim($_SERVER['REMOTE_ADDR']))))
		{
			if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ','))
			{
				$ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
				return $ips[0];
			}
			else
				return $_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		return $_SERVER['REMOTE_ADDR'];
	}
	
	static function autoFromDate($obj,$value,$default=0)
	{
		if(is_object($obj) && isset($obj->{$value}))
			return 	$obj->{$value};
		
		if(Tools::getRequest($value))
			return Tools::getRequest($value);
		
		return $default;
	}
	
		/**
	* Return price with currency sign for a given product
	*
	* @param float $price Product price
	* @param object $currency Current currency (object, id_currency, NULL => getCurrent())
	* @return string Price correctly formated (sign, decimal separator...)
	*/
	public static function displayPrice($price, $currency = NULL, $no_utf8 = false)
	{
		if ($currency === NULL)
			$currency = Currency::getCurrent();
		/* if you modified this function, don't forget to modify the Javascript function formatCurrency (in tools.js) */
		if (is_int($currency))
			$currency = Currency::getCurrencyInstance((int)$currency);

		$price = self::convertPrice($price);
		if (is_array($currency))
		{
			$c_char = $currency['sign'];
			$c_format = $currency['format'];
			$c_decimals = 2;
			$c_blank = '';
		}
		elseif (is_object($currency))
		{
			$c_char = $currency->sign;
			$c_format = $currency->format;
			$c_decimals = 2;
			$c_blank = '';
		}
		else
			return false;
		
		$blank = ($c_blank ? ' ' : '');
		$ret = 0;
		if (($isNegative = ($price < 0)))
			$price *= -1;
		$price = round($price, $c_decimals);
		switch ($c_format)
	 	{
	 	 	/* X 0,000.00 */
	 	 	case 1:
				$ret = $c_char.$blank.number_format($price, $c_decimals, '.', ',');
				break;
			/* 0 000,00 X*/
			case 2:
				$ret = number_format($price, $c_decimals, ',', ' ').$blank.$c_char;
				break;
			/* X 0.000,00 */
			case 3:
				$ret = $c_char.$blank.number_format($price, $c_decimals, ',', '.');
				break;
			/* 0,000.00 X */
			case 4:
				$ret = number_format($price, $c_decimals, '.', ',').$blank.$c_char;
				break;
		}
		if ($isNegative)
			$ret = '-'.$ret;
		if ($no_utf8)
			return str_replace('€', chr(128), $ret);
		return $ret;
	}

	public static function displayPriceSmarty($params)
	{
		if (array_key_exists('currency', $params))
		{
			$currency = Currency::getCurrencyInstance((int)($params['currency']));
			if (Validate::isLoadedObject($currency))
				return self::displayPrice($params['price'], $currency, false);
		}
		return self::displayPrice($params['price']);
	}
	
	/**
	* Return price converted
	*
	* @param float $price Product price
	* @param object $currency Current currency object
	* @param boolean $to_currency convert to currency or from currency to default currency
	*/
	public static function convertPrice($price, $currency = NULL, $to_currency = true)
	{
		if ($currency === NULL)
			$currency = Currency::getCurrent();
		elseif (is_numeric($currency))
			$currency = Currency::getCurrencyInstance($currency);

		$c_id = (is_array($currency) ? $currency['id_currency'] : $currency->id);
		$c_rate = (is_array($currency) ? $currency['conversion_rate'] : $currency->conversion_rate);

		if ($c_id != (int)(Configuration::get('ID_CURRENCY_DEFAULT')))
		{
			if ($to_currency)
				$price *= $c_rate;
			else
				$price /= $c_rate;
		}

		return $price;
	}
	/*
	检测数组里是否有重复元素，如果有，则全部删除
	*/
	public static function arrayToggle($array)
	{
		$unique_arr = array_unique ($array); 
		$repeat_arr = array_diff_assoc($array,$unique_arr);
		sort($repeat_arr);
		$last_arr	= array_diff($unique_arr,$repeat_arr);
		sort($last_arr);
		return $last_arr; 
	}
	
	static function getFilters($filter)
	{
		$filters = array();
		if(!is_array($filter) || count($filter)==0)
			return $filters;

		if(isset($filter['id_color'])&&count($filter['id_color'])>0)
		{
				$result = Db::getInstance()->ExecuteS('SELECT `id_color`,`name` FROM `'._DB_PREFIX_.'color` WHERE `id_color` IN('.pSQL(implode(',',$filter['id_color'])).')');
				if($result){
					if(count($result)==1){
						$filters['color']['name'] 		=  $result[0]['name'];
						$filters['color']['path'] 		=  $result[0]['id_color']."_";
						$filters['color']['id'] 		=  array($result[0]['id_color']);
					}else{
						$path = "";
						$id_colors = array();
						foreach($result as $row){
							$path .= $row["id_color"]."_";
							$id_colors[] = $row["id_color"];
						}
						$filters['color']['name'] 		=  count($result)." selected";
						$filters['color']['path'] 		=  $path;
						$filters['color']['id'] 		=  $id_colors;
					}
				}
		}
		
		if(isset($filter['id_brand'])&&count($filter['id_brand'])>0)
		{
				$result = Db::getInstance()->ExecuteS('SELECT `id_brand`,`name` FROM `'._DB_PREFIX_.'brand` WHERE `id_brand` IN('.pSQL(implode(',',$filter['id_brand'])).')');
				if($result){
					if(count($result)==1){
						$filters['brand']['name'] 		=  $result[0]['name'];
						$filters['brand']['path'] 		=  $result[0]['id_brand']."_";
						$filters['brand']['id'] 		=  array($result[0]['id_brand']);
					}else{
						$path = "";
						$id_brands = array();
						foreach($result as $row){
							$path .= $row["id_brand"]."_";
							$id_brands[] = $row["id_brand"];
						}
						$filters['brand']['name'] 		=  count($result)." selected";
						$filters['brand']['path'] 		=  $path;
						$filters['brand']['id'] 		=  $id_brands;
					}
				}
		}
		
		if(isset($filter['id_style'])&&count($filter['id_style'])>0)
		{
				$result = Db::getInstance()->getRow('SELECT `id_category` as id_style,`name` FROM `'._DB_PREFIX_.'category` WHERE `id_category` ='.intval($filter['id_style']));
				if($result){
					$filters['style']['name'] 		=  $result['name'];
					$filters['style']['id'] 		=  $result['id_style'];
				}
		}

		return $filters;
	}
	
	public static function radioStatus($entity,$key,$val)
	{
		if(isset($entity)){
			if($entity==$val)
				return "checked";
		}elseif(Tools::getRequest($key)==$val)
			return "checked";
		return;
	}
	
	public static function Tstart()
	{
		return explode(" ",microtime());
	}
	
	public static function Tend($hand)
	{
		$end=explode(" ",microtime()); 
		echo "Time:".($end[1]+$end[0]-$hand[1]-$hand[0]);
		echo "<br>";
		printf('memory usage: %01.2f MB', memory_get_usage()/1024/1024);
	}

	public static function getFileType($filename)
	{
		return substr($filename, strrpos($filename, '.') + 1);
	}
}

?>