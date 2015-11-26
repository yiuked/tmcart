<?php
/*
* 2007-2011 PrestaShop 
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2011 PrestaShop SA
*  @version  Release: $Revision: 9160 $
*  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (file_exists(dirname(__FILE__).'/../config/settings.inc.php'))
	include_once(dirname(__FILE__).'/../config/settings.inc.php');

abstract class Db
{
	/** @var string Server (eg. localhost) */
	protected $_server;

	/** @var string Database user (eg. root) */
	protected $_user;

	/** @var string Database password (eg. can be empty !) */
	protected $_password;

	/** @var string Database type (MySQL, PgSQL) */
	protected $_type;

	/** @var string Database name */
	protected $_database;

	/** @var mixed Ressource link */
	protected $_link;

	/** @var mixed SQL cached result */
	protected $_result;

	/** @var mixed ? */
	protected static $_db;

	/** @var mixed Object instance for singleton */
	protected static $_instance = array();

	protected static $_servers = array(	
	array('server' => _DB_SERVER_, 'user' => _DB_USER_, 'password' => _DB_PASSWD_, 'database' => _DB_NAME_), /* MySQL Master server */
	/* Add here your slave(s) server(s)*/
	/*array('server' => '192.168.0.15', 'user' => 'rep', 'password' => '123456', 'database' => 'rep'),
	array('server' => '192.168.0.3', 'user' => 'myuser', 'password' => 'mypassword', 'database' => 'mydatabase'),
	*/
	);
	
	protected $_lastQuery;
	protected $_lastCached;
	
	protected static $_idServer;

	/**
	 * Get Db object instance (Singleton)
	 *
	 * @param boolean $master Decides wether the connection to be returned by the master server or the slave server
	 * @return object Db instance
	 */
	public static function getInstance($master = 1)
	{
		if ($master OR ($nServers = sizeof(self::$_servers)) == 1)
			$idServer = 0;
		else
			$idServer = ($nServers > 2 AND ($id = ++self::$_idServer % (int)$nServers) !== 0) ? $id : 1;

		if (!isset(self::$_instance[$idServer]))
			self::$_instance[(int)($idServer)] = new MySQL(self::$_servers[(int)($idServer)]['server'], self::$_servers[(int)($idServer)]['user'], self::$_servers[(int)($idServer)]['password'], self::$_servers[(int)($idServer)]['database']);
		
		return self::$_instance[(int)($idServer)];
	}
	
	public function getRessource() { return $this->_link;}
	
	public function __destruct()
	{
		$this->disconnect();
	}

	/**
	 * Build a Db object
	 */
	public function __construct($server, $user, $password, $database)
	{
		$this->_server = $server;
		$this->_user = $user;
		$this->_password = $password;
		$this->_type = _DB_TYPE_;
		$this->_database = $database;

		$this->connect();
	}

	/**
	 * Filter SQL query within a blacklist
	 *
	 * @param string $table Table where insert/update data
	 * @param string $values Data to insert/update
	 * @param string $type INSERT or UPDATE
	 * @param string $where WHERE clause, only for UPDATE (optional)
	 * @param string $limit LIMIT clause (optional)
	 * @return mixed|boolean SQL query result
	 */
	public function	autoExecute($table, $values, $type, $where = false, $limit = false)
	{
		if (!sizeof($values))
			return true;

		if (strtoupper($type) == 'INSERT')
		{
			$query = 'INSERT INTO `'.$table.'` (';
			foreach ($values AS $key => $value)
				$query .= '`'.$key.'`,';
			$query = rtrim($query, ',').') VALUES (';
			foreach ($values AS $key => $value)
				$query .= '\''.$value.'\',';
			$query = rtrim($query, ',').')';
			if ($limit)
				$query .= ' LIMIT '.(int)($limit);
			return $this->q($query);
		}
		elseif (strtoupper($type) == 'UPDATE')
		{
			$query = 'UPDATE `'.$table.'` SET ';
			foreach ($values AS $key => $value)
				$query .= '`'.$key.'` = \''.$value.'\',';
			$query = rtrim($query, ',');
			if ($where)
				$query .= ' WHERE '.$where;
			if ($limit)
				$query .= ' LIMIT '.(int)($limit);
			//echo $query;
			return $this->q($query);
		}
		
		return false;
	}

	/**
	 * @param string $table Table name without prefix
	 * @param array $data Data to insert as associative array. If $data is a list of arrays, multiple insert will be done
	 * @param string $where WHERE condition
	 * @param int $limit
	 * @param bool $null_values If we want to use NULL values instead of empty quotes
	 * @param bool $use_cache
	 * @param bool $add_prefix Add or not _DB_PREFIX_ before table name
	 * @return bool
	 */
	public function update($table, $data, $where = '', $limit = 0, $null_values = false, $use_cache = true, $add_prefix = true)
	{
		if (!$data)
			return true;

		if ($add_prefix)
			$table = _DB_PREFIX_.$table;

		$sql = 'UPDATE `'.$table.'` SET ';
		foreach ($data as $key => $value)
		{
			if (!is_array($value))
				$value = array('type' => 'text', 'value' => $value);
			if ($value['type'] == 'sql')
				$sql .= "`$key` = {$value['value']},";
			else
				$sql .= ($null_values && ($value['value'] === '' || is_null($value['value']))) ? "`$key` = NULL," : "`$key` = '{$value['value']}',";
		}

		$sql = rtrim($sql, ',');
		if ($where)
			$sql .= ' WHERE '.$where;
		if ($limit)
			$sql .= ' LIMIT '.(int)$limit;
		return (bool)$this->q($sql, $use_cache);
	}

	/**
	 * Filter SQL query within a blacklist
	 *
	 * @param string $table Table where insert/update data
	 * @param string $values Data to insert/update
	 * @param string $type INSERT or UPDATE
	 * @param string $where WHERE clause, only for UPDATE (optional)
	 * @param string $limit LIMIT clause (optional)
	 * @return mixed|boolean SQL query result
	 */
	public function	autoExecuteWithNullValues($table, $values, $type, $where = false, $limit = false)
	{
		if (!sizeof($values))
			return true;

		if (strtoupper($type) == 'INSERT')
		{
			$query = 'INSERT INTO `'.$table.'` (';
			foreach ($values AS $key => $value)
				$query .= '`'.$key.'`,';
			$query = rtrim($query, ',').') VALUES (';
			foreach ($values AS $key => $value)
				$query .= (($value === '' OR $value === NULL) ? 'NULL' : '\''.$value.'\'').',';
			$query = rtrim($query, ',').')';
			if ($limit)
				$query .= ' LIMIT '.(int)($limit);
			return $this->q($query);
		}
		elseif (strtoupper($type) == 'UPDATE')
		{
			$query = 'UPDATE `'.$table.'` SET ';
			foreach ($values AS $key => $value)
				$query .= '`'.$key.'` = '.(($value === '' OR $value === NULL) ? 'NULL' : '\''.$value.'\'').',';
			$query = rtrim($query, ',');
			if ($where)
				$query .= ' WHERE '.$where;
			if ($limit)
				$query .= ' LIMIT '.(int)($limit);
			return $this->q($query);
		}
		
		return false;
	}

	/*********************************************************
	 * ABSTRACT METHODS
	 *********************************************************/
	
	/**
	 * Open a connection
	 */
	abstract public function connect();

	/**
	 * Get the ID generated from the previous INSERT operation
	 */
	abstract public function Insert_ID();

	/**
	 * Get number of affected rows in previous databse operation
	 */
	abstract public function Affected_Rows();

	/**
	 * Gets the number of rows in a result
	 */
	abstract public function NumRows();

	/**
	 * Delete
	 */
	abstract public function delete ($table, $where = false, $limit = false);
	/**
	 * Fetches a row from a result set
	 */
	abstract public function Execute ($query);

	/**
	 * Fetches an array containing all of the rows from a result set
	 */
	abstract public function ExecuteS($query, $array = true);
	
	abstract public function ExecuteField($query,$filed);
	/*
	 * Get next row for a query which doesn't return an array 
	 */
	abstract public function nextRow($result = false);
	
	/*
	 * return sql server version.
	 * used in Order.php to allow or not subquery in update
	 */
	abstract public function getServerVersion();

	/**
		 * Alias of Db::getInstance()->ExecuteS
		 *
		 * @acces string query The query to execute
		 * @return array Array of line returned by MySQL
		 */
	public static function s($query)
	{
		return Db::getInstance()->ExecuteS($query, true);
	}
	
	public static function ps($query)
	{
		$ret = Db::s($query);
		p($ret);
		return $ret;
	}
	
	public static function ds($query)
	{
		Db::s($query);
		die();
	}

	/**
	 * getRow return an associative array containing the first row of the query
	 * This function automatically add "limit 1" to the query
	 * 
	 * @param mixed $query the select query (without "LIMIT 1")
	 * @param int $use_cache find it in cache first
	 * @return array associative array of (field=>value)
	 */
	abstract public function getRow($query);

	/**
	 * getValue return the first item of a select query.
	 * 
	 * @param mixed $query 
	 * @param int $use_cache 
	 * @return void
	 */
	abstract public function getValue($query);

	/**
	 * Returns the text of the error message from previous database operation
	 */
	abstract public function getMsgError();
}

/**
 * Sanitize data which will be injected into SQL query
 *
 * @param string $string SQL data which will be injected into SQL query
 * @param boolean $htmlOK Does data contain HTML code ? (optional)
 * @return string Sanitized data
 */
function pSQL($string, $htmlOK = false)
{
	if (_TM_MAGIC_QUOTES_GPC_)
		$string = stripslashes($string);
	if (!is_numeric($string))
	{
		$link = Db::getInstance()->getRessource();
		$string = _TM_MYSQL_REAL_ESCAPE_STRING_ ? mysql_real_escape_string($string, $link) : addslashes($string);
		if (!$htmlOK)
			$string = strip_tags(nl2br2($string));
	}
		
	return $string;
}

function bqSQL($string)
{
	return str_replace('`', '\`', pSQL($string));
}

/**
 * Convert \n and \r\n and \r to <br />
 *
 * @param string $string String to transform
 * @return string New string
 */
function nl2br2($string)
{
	return str_replace(array("\r\n", "\r", "\n"), '<br />', $string);
}