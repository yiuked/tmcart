<?php
/**
 * Created by PhpStorm.
 * User: shake
 * Date: 2015/11/27
 * Time: 15:30
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

	/** @var string Database name */
	protected $_database;

	/** @var mixed Ressource link */
	protected $_link;

	/** @var mixed Object 数据库单列类 */
	protected static $_instance = false;
	/**
	 * 获取一个数据库的单列
	 *
	 * @return object Db instance
	 */
	public static function getInstance()
	{
		if (!self::$_instance) {
			if (DB_TYPE == 'pdo') {
				self::$_instance = new DbPdo(DB_SERVER, DB_USER, DB_PASSWD, DB_NAME);
			}elseif (DB_TYPE == 'mysqli') {
				self::$_instance = new DbMySQLI(DB_SERVER, DB_USER, DB_PASSWD, DB_NAME);
			}else{
				self::$_instance = new DbMySQL(DB_SERVER, DB_USER, DB_PASSWD, DB_NAME);
			}
		}
		return self::$_instance;
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
		$this->_database = $database;
		$this->connect();
	}

	/**
	 * 添加数据到数据库
	 * @param $table
	 * @param $values
	 * @return bool|int
	 */
	public function insert($table, $values)
	{
		if (!sizeof($values))
			return true;

		$table_key = '';
		$table_val = '';
		foreach ($values AS $key => $value) {
			$table_key .= '`'.$key.'`,';
			$table_val .= '\''.$value.'\',';
		}
		$query = 'INSERT INTO `'.$table.'` (' . rtrim($table_key, ',') . ') VALUES ('. rtrim($table_val, ',') . ')';
		return $this->exec($query);
	}

	/**
	 * 更新数据到数据库
	 * @param $table
	 * @param $values
	 * @param bool|false $where
	 * @param bool|false $limit
	 * @return bool|int
	 */
	public function update($table, $values, $where = false, $limit = false)
	{
		if (!sizeof($values))
			return true;
		$query = 'UPDATE `'.$table.'` SET ';
		foreach ($values AS $key => $value)
			$query .= '`'.$key.'` = \''.$value.'\',';
		$query = rtrim($query, ',');
		if ($where)
			$query .= ' WHERE '.$where;
		if ($limit)
			$query .= ' LIMIT '.(int)($limit);
		return $this->exec($query);
	}

	/*********************************************************
	 * ABSTRACT METHODS
	 *********************************************************/

	/**
	 * 连接数据库
	 * @return mixed
	 */
	abstract public function connect();

	/**
	 * 返回最一后一次操作的ID
	 * @return int
	 */
	abstract public function Insert_ID();

	/**
	 * 返回记录条数
	 * @param $query
	 * @return mixed
	 */
	abstract public function NumRows($query);

	/**
	 * 删除指定条件的记录
	 * @param $table
	 * @param bool|false $where
	 * @param bool|false $limit
	 * @return bool
	 */
	abstract public function delete ($table, $where = false, $limit = false);

	/**
	 * 获取数据库版本信息
	 * @return string
	 */
	abstract public function getServerVersion();

	/**
	 * 获取一条记录集,会自行添加LIMIT 1
	 * @param $query
	 * @return mixed
	 */
	abstract public function getRow($query);

	/**
	 * 获取所有记录集
	 * @param $query
	 * @return mixed
	 */
	abstract public function getAll($query);

	/**
	 * 用于查询某一数据表中某一指定的字段指定条件的一条结果集
	 * @param $query
	 * @param $filed
	 * @return string
	 */
	abstract public function getValue($query, $filed = false);

	/**
	 * 用于查询某一数据表中某一指定的字段指定条件的所有结果集
	 * @param $query
	 * @param $filed
	 * @return array() 返回一个一维数组的结果集
	 */
	abstract public function getAllValue($query, $filed = false);

	/**
	 * 用于执行插入、更新等无返回结果集的$query
	 * @param string $query 需要执行的SQL语句
	 * @return int 返回受影响的数目
	 */
	abstract  public function exec($query);
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
	if (!is_numeric($string))
	{
		$string = addslashes($string);
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