<?php
abstract class Cache
{
	/** @var mixed Object instance for singleton */
	private static $_instance;
	
	protected $_cached = array();
	protected $_keysCached = array();
	
	abstract public function get($key);
	abstract public function delete($key);
	abstract public function set($key, $value);

	/**
	 * Get Db object instance (Singleton)
	 *
	 * @return object Db instance
	 */
	public static function getInstance()
	{
		if(!isset(self::$_instance))
			self::$_instance = new CacheFSO();
		return self::$_instance;
	}
	

}
?>