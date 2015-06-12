<?php

class Validate
{
	public static function isIp2Long($ip)
	{
		return preg_match('#^-?[0-9]+$#', (string)$ip);
	}

	public static function isAnything($data)
	{
		return true;
	}

	/**
	* Check for an integer validity (unsigned)
	* Mostly used in database for auto-increment
	*
	* @param integer $id Integer to validate
	* @return boolean Validity is ok or not
	*/
	public static function isUnsignedId($id)
	{
		return self::isUnsignedInt($id); /* Because an id could be equal to zero when there is no association */
	}
	
 	/**
	* Check for e-mail validity
	*
	* @param string $email e-mail address to validate
	* @return boolean Validity is ok or not
	*/
	public static function isEmail($email)
	{
		return !empty($email) AND preg_match('/^[a-z0-9!#$%&\'*+\/=?^`{}|~_-]+[.a-z0-9!#$%&\'*+\/=?^`{}|~_-]*@[a-z0-9]+[._a-z0-9-]*\.[a-z0-9]+$/ui', $email);
	}

	/**
	* Check for module URL validity
	*
	* @param string $url module URL to validate
	* @param array $errors Reference array for catching errors
	* @return boolean Validity is ok or not
	*/ 
	public static function isModuleUrl($url, &$errors)
	{
		if (!$url OR $url == 'http://')
			$errors[] = Tools::displayError('Please specify module URL');
		elseif (substr($url, -4) != '.tar' AND substr($url, -4) != '.zip' AND substr($url, -4) != '.tgz' AND substr($url, -7) != '.tar.gz')
			$errors[] = Tools::displayError('Unknown archive type');
		else
		{
			if ((strpos($url, 'http')) === false)
				$url = 'http://'.$url;
			if (!is_array(@get_headers($url)))
				$errors[] = Tools::displayError('Invalid URL');
		}
		if (!sizeof($errors))
			return true;
		return false;

	}
	
	/**
	* Check for standard name validity
	*
	* @param string $name Name to validate
	* @return boolean Validity is ok or not
	*/
	public static function isGenericName($name)
	{
		return empty($name) OR preg_match('/^[^<>;#{}]*$/u', $name);
	}

	/**
	* Check for module name validity
	*
	* @param string $moduleName Module name to validate
	* @return boolean Validity is ok or not
	*/
	public static function isModuleName($moduleName)
	{
		return preg_match('/^[a-zA-Z0-9_-]+$/', $moduleName);
	}
	
	/**
	* Check for MD5 string validity
	*
	* @param string $md5 MD5 string to validate
	* @return boolean Validity is ok or not
	*/
	public static function isMd5($md5)
	{
		return preg_match('/^[a-f0-9A-F]{32}$/', $md5);
	}

	/**
	* Check for module name validity
	*
	* @param string $moduleName Module name to validate
	* @return boolean Validity is ok or not
	*/
	public static function isEntityName($entityName)
	{
		return preg_match('/^[a-zA-Z0-9_]+$/', $entityName);
	}

	/**
	* Check for SHA1 string validity
	*
	* @param string $sha1 SHA1 string to validate
	* @return boolean Validity is ok or not
	*/
	public static function isSha1($sha1)
	{
		return preg_match('/^[a-fA-F0-9]{40}$/', $sha1);
	}

	/**
	* Check for a float number validity
	*
	* @param float $float Float number to validate
	* @return boolean Validity is ok or not
	*/
	public static function isFloat($float)
	{
		return strval((float)($float)) == strval($float);
	}
	
	public static function isUnsignedFloat($float)
	{
			return strval((float)($float)) == strval($float) AND $float >= 0;
	}

	/**
	* Check for a float number validity
	*
	* @param float $float Float number to validate
	* @return boolean Validity is ok or not
	*/
	public static function isOptFloat($float)
	{
		return empty($float) OR self::isFloat($float);
	}

	/**
	* Check for a carrier name validity
	*
	* @param string $name Carrier name to validate
	* @return boolean Validity is ok or not
	*/
	public static function isCarrierName($name)
	{
		return empty($name) OR preg_match('/^[^<>;=#{}]*$/u', $name);
	}

	/**
	* Check for an image size validity
	*
	* @param string $size Image size to validate
	* @return boolean Validity is ok or not
	*/
	public static function isImageSize($size)
	{
		return preg_match('/^[0-9]{1,4}$/', $size);
	}

	/**
	* Check for name validity
	*
	* @param string $name Name to validate
	* @return boolean Validity is ok or not
	*/
	public static function isName($name)
	{
		return preg_match('/^[^0-9!<>,;?=+()@#"°{}_$%:]*$/u', stripslashes($name));
	}


	/**
	* Check for sender name validity
	*
	* @param string $mailName Sender name to validate
	* @return boolean Validity is ok or not
	*/
	public static function isMailName($mailName)
	{
		return preg_match('/^[^<>;=#{}]*$/u', $mailName);
	}

	/**
	* Check for e-mail subject validity
	*
	* @param string $mailSubject e-mail subject to validate
	* @return boolean Validity is ok or not
	*/
	public static function isMailSubject($mailSubject)
	{
		return preg_match('/^[^<>]*$/u', $mailSubject);
	}


	/**
	* Check for template name validity
	*
	* @param string $tplName Template name to validate
	* @return boolean Validity is ok or not
	*/
	public static function isTplName($tplName)
	{
		return preg_match('/^[a-zA-Z0-9_-]+$/', $tplName);
	}

	/**
	 * @deprecated
	 * @param string $tplFileName
	 * @return bool
	 */
	public static function isTplFileName($tplFileName)
	{
		Tools::displayAsDeprecated();
		return preg_match('/^[a-zA-Z0-9\/_.-]+/', $tplFileName);
	}

	/**
	* Check for icon file validity
	*
	* @param string $icon Icon filename to validate
	* @return boolean Validity is ok or not
	* @deprecated
	*/
	public static function isIconFile($icon)
	{
		Tools::displayAsDeprecated();
		return preg_match('/^[a-z0-9_-]+\.(gif|jpg|jpeg|png)$/i', $icon);
	}

	/**
	* Check for ico file validity
	*
	* @param string $icon Icon filename to validate
	* @return boolean Validity is ok or not
	* @deprecated
	*/
	public static function isIcoFile($icon)
	{
		Tools::displayAsDeprecated();
		return preg_match('/^[a-z0-9_-]+\.ico$/i', $icon);
	}

	/**
	* Check for image type name validity
	*
	* @param string $type Image type name to validate
	* @return boolean Validity is ok or not
	*/
	public static function isImageTypeName($type)
	{
		return preg_match('/^[a-zA-Z0-9_ -]+$/', $type);
	}

	/**
	* Check for price validity
	*
	* @param string $price Price to validate
	* @return boolean Validity is ok or not
	*/
	public static function isPrice($price)
	{
		return preg_match('/^[0-9]{1,10}(\.[0-9]{1,9})?$/', $price);
	}
	
	public static function isStateIsoCode($isoCode)
	{
		return preg_match('/^[a-zA-Z0-9]{2,3}((-)[a-zA-Z0-9]{1,3})?$/', $isoCode);
	}


	/**
	* Check for product or category name validity
	*
	* @param string $name Product or category name to validate
	* @return boolean Validity is ok or not
	*/
	public static function isCatalogName($name)
	{
		return preg_match('/^[^<>;={}]*$/u', $name);
	}

	/**
	* Check for a message validity
	*
	* @param string $message Message to validate
	* @return boolean Validity is ok or not
	*/
	public static function isMessage($message)
	{
		return !preg_match('/[<>{}]/i', $message);
	}

	/**
	* Check for a country name validity
	*
	* @param string $name Country name to validate
	* @return boolean Validity is ok or not
	*/
	public static function isCountryName($name)
	{
		return preg_match('/^[a-zA-Z -]+$/', $name);
	}

	/**
	* Check for a link (url-rewriting only) validity
	*
	* @param string $link Link to validate
	* @return boolean Validity is ok or not
	*/
	public static function isLinkRewrite($link)
	{
		return (boolean)preg_match('/^[_a-zA-Z0-9-\.]+$/', $link);
	}

	/**
	* Check for a postal address validity
	*
	* @param string $address Address to validate
	* @return boolean Validity is ok or not
	*/
	public static function isAddress($address)
	{
		return empty($address) OR preg_match('/^[^!<>?=+@{}_$%]*$/u', $address);
	}

	/**
	* Check for city name validity
	*
	* @param string $city City name to validate
	* @return boolean Validity is ok or not
	*/
	public static function isCityName($city)
	{
		return preg_match('/^[^!<>;?=+@#"°{}_$%]*$/u', $city);
	}

	/**
	* Check for search query validity
	*
	* @param string $search Query to validate
	* @return boolean Validity is ok or not
	*/
	public static function isValidSearch($search)
	{
		return preg_match('/^[^<>;=#{}]{0,64}$/u', $search);
	}

	/**
	* Check for HTML field validity (no XSS please !)
	*
	* @param string $html HTML field to validate
	* @return boolean Validity is ok or not
	*/
	public static function isCleanHtml($html)
	{
		$jsEvent = 'onmousedown|onmousemove|onmmouseup|onmouseover|onmouseout|onload|onunload|onfocus|onblur|onchange|onsubmit|ondblclick|onclick|onkeydown|onkeyup|onkeypress|onmouseenter|onmouseleave|onerror';
		return (!preg_match('/<[ \t\n]*script/i', $html) && !preg_match('/<?.*('.$jsEvent.')[ \t\n]*=/i', $html)  && !preg_match('/.*script\:/i', $html));
	}

	/**
	* Check for password validity
	*
	* @param string $passwd Password to validate
	* @return boolean Validity is ok or not
	*/
	public static function isPasswd($passwd, $size = 5)
	{
		return preg_match('/^[.a-zA-Z_0-9-!@#$%\^&*()]{'.(int)$size.',32}$/', $passwd);
	}

	public static function isPasswdAdmin($passwd)
	{
		return self::isPasswd($passwd, 8);
	}

	/**
	* Check for configuration key validity
	*
	* @param string $configName Configuration key to validate
	* @return boolean Validity is ok or not
	*/
	public static function isConfigName($configName)
	{
		return preg_match('/^[a-zA-Z_0-9-]+$/', $configName);
	}
	
	/**
	* Check date formats like http://php.net/manual/en/function.date.php
	*
	* @param string $date_format date format to check
	* @return boolean Validity is ok or not
	*/
	public static function isPhpDateFormat($date_format)
	{
		// We can't really check if this is valid or not, because this is a string and you can write whatever you want in it. That's why only < et > are forbidden (HTML)
		return preg_match('/^[^<>]+$/', $date_format);
	}

	/**
	* Check for date format
	*
	* @param string $date Date to validate
	* @return boolean Validity is ok or not
	*/
	public static function isDateFormat($date)
	{
		return (bool)preg_match('/^([0-9]{4})-((0?[0-9])|(1[0-2]))-((0?[1-9])|([0-2][0-9])|(3[01]))( [0-9]{2}:[0-9]{2}:[0-9]{2})?$/', $date);
	}
	
	/**
	* Check for date validity
	*
	* @param string $date Date to validate
	* @return boolean Validity is ok or not
	*/
	public static function isDate($date)
	{
		if (!preg_match('/^([0-9]{4})-((0?[1-9])|(1[0-2]))-((0?[1-9])|([1-2][0-9])|(3[01]))( [0-9]{2}:[0-9]{2}:[0-9]{2})?$/', $date, $matches))
			return false;
		return checkdate((int)$matches[2], (int)$matches[5], (int)$matches[0]);
	}

	/**
	* Check for boolean validity
	*
	* @param boolean $bool Boolean to validate
	* @return boolean Validity is ok or not
	*/
	public static function isBool($bool)
	{
		return is_null($bool) OR is_bool($bool) OR preg_match('/^0|1$/', $bool);
	}

	/**
	* Check for phone number validity
	*
	* @param string $phoneNumber Phone number to validate
	* @return boolean Validity is ok or not
	*/
	public static function isPhoneNumber($phoneNumber)
	{
		return preg_match('/^[+0-9. ()-]*$/', $phoneNumber);
	}

	/**
	* Check for barcode validity (EAN-13)
	*
	* @param string $ean13 Barcode to validate
	* @return boolean Validity is ok or not
	*/
	public static function isEan13($ean13)
	{
		return !$ean13 OR preg_match('/^([0-9a-zA-Z-_]+)$/', $ean13);
	}
	
	/**
	* Check for barcode validity (UPC)
	*
	* @param string $upc Barcode to validate
	* @return boolean Validity is ok or not
	*/
	public static function isUpc($upc)
	{
		return !$upc OR preg_match('/^[0-9]{0,12}$/', $upc);
	}

	/**
	* Check for postal code validity
	*
	* @param string $postcode Postal code to validate
	* @return boolean Validity is ok or not
	*/
	public static function isPostCode($postcode)
	{
		return empty($postcode) OR preg_match('/^[a-zA-Z 0-9-]+$/', $postcode);
	}
	
	/**
	* Check for zip code format validity
	*
	* @param string $zip_code zip code format to validate
	* @return boolean Validity is ok or not
	*/
	public static function isZipCodeFormat($zip_code)
	{
		if (!empty($zip_code))
			return preg_match('/^[NLCnlc -]+$/', $zip_code);
		return true;
	}
	
	/**
	* Check for table or identifier validity
	* Mostly used in database for table names and id_table
	*
	* @param string $table Table/identifier to validate
	* @return boolean Validity is ok or not
	*/
	public static function isTableOrIdentifier($table)
	{
		return preg_match('/^[a-zA-Z0-9_-]+$/', $table);
	}

	/**
	* Check for tags list validity
	*
	* @param string $list List to validate
	* @return boolean Validity is ok or not
	*/
	public static function isTagsList($list)
	{
		return preg_match('/^[^!<>;?=+#"°{}_$%]*$/u', $list);
	}

	/**
	* Check for an integer validity
	*
	* @param integer $id Integer to validate
	* @return boolean Validity is ok or not
	*/
	public static function isInt($value)
	{
		return ((string)(int)$value === (string)$value OR $value === false);
	}

	/**
	* Check for an integer validity (unsigned)
	*
	* @param integer $id Integer to validate
	* @return boolean Validity is ok or not
	*/
	public static function isUnsignedInt($value)
	{
		return (preg_match('#^[0-9]+$#', (string)$value) AND $value < 4294967296 AND $value >= 0);
	}

	/**
	* Check object validity
	*
	* @param integer $object Object to validate
	* @return boolean Validity is ok or not
	*/
	public static function isLoadedObject($object)
	{
		return is_object($object) AND $object->id;
	}

	/**
	* Check object validity
	*
	* @param integer $object Object to validate
	* @return boolean Validity is ok or not
	*/
	public static function isColor($color)
	{
		return preg_match('/^(#[0-9a-fA-F]{6}|[a-zA-Z0-9-]*)$/', $color);
	}

	/**
	* Check url valdity (disallowed empty string)
	*
	* @param string $url Url to validate
	* @return boolean Validity is ok or not
	*/
	public static function isUrl($url)
	{
		if (!empty($url))
			return preg_match('/^https?:\/\/[:#%&_=\(\)\.\? \+\-@\/a-zA-Z0-9]+$/', $url);
		return true;
	}


	public static function isSubDomainName($subDomainName)
	{
		return preg_match('/^[a-zA-Z0-9-_]*$/', $subDomainName);
	}

	/**
	* Check if $data is a PrestaShop cookie object
	*
	* @param mixed $data to validate
	* @return bool
	*/
	public static function isCookie($data)
	{
		return (is_object($data) AND get_class($data) == 'Cookie');
	}

	/**
	* Price display method validity
	*
	* @param string $data Data to validate
	* @return boolean Validity is ok or not
	*/
	public static function isString($data)
	{
		return is_string($data);
	}
	
	/**
	* Check for language code (ISO) validity
	*
	* @param string $isoCode Language code (ISO) to validate
	* @return boolean Validity is ok or not
	*/
	public static function isLanguageIsoCode($isoCode)
	{
		return preg_match('/^[a-zA-Z]{2,3}$/', $isoCode);
	}
	
	public static function isLanguageCode($s)
	{
		return preg_match('/^[a-zA-Z]{2}(-[a-zA-Z]{2})?$/', $s);
	}
	
	public static function isNumericIsoCode($isoCode)
	{
		return preg_match('/^[0-9]{2,3}$/', $isoCode);
	}
}

