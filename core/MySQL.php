<?php

/**
 * Created by PhpStorm.
 * User: shake
 * Date: 2015/11/27
 * Time: 15:30
 */

class MySQL extends Db
{
	public function connect()
	{
		if ($this->_link = @mysql_connect($this->_server, $this->_user, $this->_password))
		{
			if (!$this->set_db($this->_database))
				die(Tools::displayError('The database selection cannot be made.'));
		}
		else
			die(Tools::displayError('Link to database cannot be established.'));
		/* UTF-8 support */
		if (!mysql_query('SET NAMES \'utf8\'', $this->_link))
			die(Tools::displayError('PrestaShop Fatal error: no utf-8 support. Please check your server configuration.'));
		// removed SET GLOBAL SQL_MODE : we can't do that (see PSCFI-1548)
		return $this->_link;
	}
	
	/* do not remove, useful for some modules */
	public function set_db($db_name) {
		return mysql_select_db($db_name, $this->_link);
	}
	
	public function disconnect()
	{
		if ($this->_link)
			@mysql_close($this->_link);
		$this->_link = false;
	}

	public function Insert_ID()
	{
		if ($this->_link)
			return mysql_insert_id($this->_link);
		return false;
	}

	public function NumRows($query)
	{
		if ($this->_link)
		{
			$result = mysql_query($query, $this->_link);
			$nrows = mysql_num_rows($result);
			return $nrows;
		}
	}

	public function delete($table, $where = false, $limit = false)
	{
		if ($this->_link)
		{
			$query  = 'DELETE FROM `'.bqSQL($table).'`'.($where ? ' WHERE '.$where : '').($limit ? ' LIMIT '.(int)($limit) : '');
			$res =  mysql_query($query);
			return $res;
		}

		return false;
	}

	public function getServerVersion(){
		return mysql_get_server_info();
	}

	public function getRow($query)
	{
		$query .= ' LIMIT 1';
		if ($this->_link)
			if ($result = mysql_query($query, $this->_link))
			{
				return mysql_fetch_assoc($result);
			}
		return false;
	}

	public function getAll($query)
	{
		if ($this->_link)
		{
			$result = mysql_query($query, $this->_link);
			$resultArray = array();
			if ($result !== true)
				while ($row = mysql_fetch_assoc($result))
					$resultArray[] = $row;
			return $resultArray;
		}
		return false;
	}

	public function getValue($query,$filed)
	{
		if ($this->_link)
		{
			$result = mysql_query($query, $this->_link);
			$row = mysql_fetch_assoc($result);
			return $row[$filed];
		}
		return false;
	}

	public function getAllValue($query,$filed)
	{
		if ($this->_link)
		{
			$result = mysql_query($query, $this->_link);
			$resultArray = array();
			// Only SELECT queries and a few others return a valid resource usable with mysql_fetch_assoc
			if ($result !== true)
				while ($row = mysql_fetch_assoc($result))
					$resultArray[] = $row[$filed];
			return $resultArray;
		}
		return false;
	}

	protected function exec($query)
	{
		if ($this->_link)
		{
			$result =  mysql_query($query, $this->_link);
			return $result;
		}
		return false;
	}
}
