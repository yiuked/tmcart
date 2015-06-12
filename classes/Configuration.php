<?php

class Configuration extends ObjectBase
{
	/** @var string Key */
	public 		$name;

	/** @var string Value */
	public 		$value;

	/** @var string Object creation date */
	public 		$add_date;

	/** @var string Object last modification date */
	public 		$upd_date;

	protected	$fieldsRequired = array('name');
	protected	$fieldsSize = array('name' => 256);
	protected	$fieldsValidate = array('name' => 'isConfigName');

	protected	$table = 'configuration';
	protected 	$identifier = 'id_configuration';

	/** @var array Configuration cache */
	protected static $_CONF;
	
	
	
	public function getFields()
	{
		parent::validation();
		$fields['name'] = pSQL($this->name);
		$fields['value'] = pSQL($this->value);
		$fields['add_date'] = pSQL($this->add_date);
		$fields['upd_date'] = pSQL($this->upd_date);
		return $fields;
	}

	/**
	  * Delete a configuration key in database (with or without language management)
	  *
	  * @param string $key Key to delete
	  * @return boolean Deletion result
	  */
	public static function deleteByName($key)
	{
	 	if (!Validate::isConfigName($key))
			return false;

		if (Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'configuration` WHERE `name` = \''.pSQL($key).'\''))
		{
			unset(self::$_CONF[$key]);
			return true;
		}
		return false;
	}

	/**
	  * Get a single configuration value (in one language only)
	  *
	  * @param string $key Key wanted
	  * @param integer $id_lang Language ID
	  * @return string Value
	  */
	public static function get($key)
	{
		if (is_array(self::$_CONF) AND key_exists($key, self::$_CONF))
			return self::$_CONF[$key];
		elseif($value = Db::getInstance()->getValue('SELECT `value` FROM `'._DB_PREFIX_.'configuration` WHERE `name` = \''.pSQL($key).'\'')){
			self::$_CONF[$key] = $value;
			return $value;
		}
		return false;
	}

	/**
	  * Get several configuration values (in one language only)
	  *
	  * @param array $keys Keys wanted
	  * @param integer $id_lang Language ID
	  * @return array Values
	  */
	public static function getMultiple($keys)
	{
		
	 	if (!is_array($keys) OR !is_array(self::$_CONF))
	 		die(Tools::displayError());

		$resTab = array();

		foreach ($keys AS $key)
			if (key_exists($key, self::$_CONF))
				$resTab[$key] = self::$_CONF[$key];
		return $resTab;
	}

	/**
	  * Set TEMPORARY a single configuration value (in one language only)
	  *
	  * @param string $key Key wanted
	  * @param mixed $values $values is an array if the configuration is multilingual, a single string else.
	  */
	public static function set($key, $values)
	{
		if (!Validate::isConfigName($key))
	 		die(Tools::displayError());
	 	/* Update classic values */
		self::$_CONF[$key] = $values;
	}


	/**
	  * Insert configuration key and value into database
	  *
	  * @param string $key Key
	  * @param string $value Value
	  * @eturn boolean Insert result
	  */
	static protected function _addConfiguration($key, $value = NULL)
	{
		$newConfig = new Configuration();
		$newConfig->name = $key;
		if (!is_null($value))
			$newConfig->value = $value;
		return $newConfig->add();
	}

	/**
	  * Update configuration key and value into database (automatically insert if key does not exist)
	  *
	  * @param string $key Key
	  * @param mixed $values $values is an array if the configuration is multilingual, a single string else.
	  * @param boolean $html Specify if html is authorized in value
	  * @return boolean Update result
	  */
	public static function updateValue($key, $values, $html = false)
	{
		if ($key == NULL) return;
		if (!Validate::isConfigName($key))
	 		die(Tools::displayError());
		$db = Db::getInstance();
		/* Update classic values */
		if (Configuration::get($key) !== false)
		{
			$values = pSQL($values, $html);
			$result = $db->AutoExecute(
				_DB_PREFIX_.'configuration',
				array('value' => $values, 'upd_date' => date('Y-m-d H:i:s')),
				'UPDATE', '`name` = \''.pSQL($key).'\'', true, true);
			self::$_CONF[$key] = stripslashes($values);
		}
		else
		{
			$result = self::_addConfiguration($key, $values);
			if ($result)
				self::$_CONF[$key] = stripslashes($values);
			return $result;
		}

		return $result;
	}

	public static function loadConfiguration()
	{
		self::$_CONF = array();
		$result = Db::getInstance()->ExecuteS('
		SELECT * FROM `'._DB_PREFIX_.'configuration`');
		
		if (is_array($result))
			foreach ($result AS $row)
			{
				self::$_CONF[$row['name']] = $row['value'];
			}
	}
}

