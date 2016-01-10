<?php

/**
 * Created by PhpStorm.
 * User: shake
 * Date: 2015/11/27
 * Time: 15:30
 */

class DbMySQLI extends Db
{
    public function connect()
    {
        $this->_link = mysqli_connect($this->_server, $this->_user, $this->_password, $this->_database);
        if ($this->_link->connect_errno)
        {
                die(Tools::displayError('Link to database cannot be established.'));
        }

        /* UTF-8 support */
        if (!$this->_link->query('SET NAMES \'utf8\''))
            die(Tools::displayError('PrestaShop Fatal error: no utf-8 support. Please check your server configuration.'));
        // removed SET GLOBAL SQL_MODE : we can't do that (see PSCFI-1548)
        return $this->_link;
    }

    public function disconnect()
    {
        if ($this->_link)
            @mysqli_close($this->_link);
        $this->_link = false;
    }

    public function Insert_ID()
    {
        if ($this->_link)
            return mysqli_insert_id($this->_link);
        return false;
    }

    public function NumRows($query)
    {
        if ($this->_link) {
            if ($result = $this->_link->query($query)) {
                $nrows = $result->num_rows();
                return $nrows;
            }
        }
    }

    public function delete($table, $where = false, $limit = false)
    {
        if ($this->_link) {
            $query  = 'DELETE FROM `'.bqSQL($table).'`'.($where ? ' WHERE '.$where : '').($limit ? ' LIMIT '.(int)($limit) : '');
            $res =  $this->_link->query($query);
            return $res;
        }

        return false;
    }

    public function getServerVersion(){
        return mysqli_get_server_info();
    }

    public function getRow($query)
    {
        $query .= ' LIMIT 1';
        if ($this->_link) {
            if ($result = $this->_link->query($query)) {
                return $result->fetch_assoc();
            }
        }
        return false;
    }

    public function getAll($query)
    {
        if ($this->_link) {
            if ($result = $this->_link->query($query)){
                $resultArray = array();
                while ($row = $result->fetch_assoc())
                    $resultArray[] = $row;
                return $resultArray;
            }
        }
        return false;
    }

    public function getValue($query, $filed = false)
    {
        if ($this->_link)
        {
            if ($st = $this->_link->query($query)){
                $value = '';
                if ($filed) {
                    $row = $row = $st->fetch_assoc();
                    $value = $row[$filed];
                } else {
                    $row = $row = $st->fetch_array(MYSQLI_NUM);
                    $value = $row[0];
                }
                return $value;
            }
        }
        return false;
    }

    public function getAllValue($query,$filed = false)
    {
        if ($this->_link)
        {
            if ($result = $this->_link->query($query)){
                $resultArray = array();

                if ($filed) {
                    while ($row = $result->fetch_assoc())
                        $resultArray[] = $row[$filed];
                }else{
                    while ($row = $result->fetch_array(MYSQLI_NUM))
                        $resultArray[] = $row[0];
                }
                return $resultArray;
            }
        }
        return false;
    }

    public function exec($query)
    {
        if ($this->_link)
        {
            $result =  $this->_link->query($query);
            return $result;
        }
        return false;
    }
}
