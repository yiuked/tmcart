<?php

class Configuration extends ObjectBase
{
	protected $fields = array(
		'name' => array(
			'required' => true,
			'size' => 128,
			'type' => 'isConfigName',
		),
		'value' => array(
			'required' => true,
			'size' => 512,
			'type' => 'isConfigValue',
		),
		'add_date' => array(
			'required' => true,
			'size' => 32,
			'type' => 'isDate',
		),
		'upd_date' => array(
			'required' => true,
			'size' => 32,
			'type' => 'isDate',
		),
	);

	protected	$table = 'configuration';
	protected 	$identifier = 'id_configuration';

	/** @var array Configuration cache */
	protected static $_CONF;

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

		if (Db::getInstance()->exec('DELETE FROM `'.DB_PREFIX.'configuration` WHERE `name` = \''.pSQL($key).'\''))
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
		elseif($value = Db::getInstance()->getValue('SELECT `value` FROM `'.DB_PREFIX.'configuration` WHERE `name` = \''.pSQL($key).'\'')){
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
				DB_PREFIX.'configuration',
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
		$result = Db::getInstance()->getAll('
		SELECT * FROM `'.DB_PREFIX.'configuration`');
		
		if (is_array($result))
			foreach ($result AS $row)
			{
				self::$_CONF[$row['name']] = $row['value'];
			}
	}
}

