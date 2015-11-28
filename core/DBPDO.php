<?php
/**
 * Created by PhpStorm.
 * User: shake
 * Date: 2015/11/27
 * Time: 15:30
 */

class DbPdo extends Db
{
    public function connect(){
        try{
            $this->_link = new PDO("mysql:host={$this->_server}; dbname={$this->_database};charset=utf8;charset=utf8", $this->_user, $this->_password);
            $this->_link->exec('SET NAMES \'utf8\'');
        } catch (PDOException $e) {
            die("Error: ".$e->__toString()."<br/>");
        }
    }

    public function Insert_ID()
    {
        if ($this->_link) {
            return $this->_link->lastInsertId();
        }
        return false;
    }

    public function NumRows($query)
    {
        if ($this->_link) {
            if($st = $this->_link->query($query)){
                return $st->rowCount();
            }
        }
        return false;
    }

    public function delete($table, $where = false, $limit = false)
    {
        if ($this->_link)
        {
            $query  = 'DELETE FROM `'.bqSQL($table).'`'.($where ? ' WHERE '.$where : '').($limit ? ' LIMIT '.(int)($limit) : '');
            $res =   $this->_link->exec($query);
            return $res;
        }
        return false;
    }

    public  function getServerVersion()
    {
        return $this->_link->getAttribute(PDO::ATTR_SERVER_VERSION);
    }

    public function getRow($query)
    {
        $query .= ' LIMIT 1';
        if ($this->_link){
            if ($st = $this->_link->query($query)) {
                return $st->fetch(PDO::FETCH_ASSOC);
            }
        }
        return false;
    }

    public function getAll($query)
    {
        if ($this->_link)
        {
            $resultArray = array();
            if ($st = $this->_link->query($query)) {
                while ($row =  $st->fetch(PDO::FETCH_ASSOC))
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
            $st = $this->_link->query($query);
            if ($st) {
                $value = '';
                if ($filed) {
                    $row = $row = $st->fetch(PDO::FETCH_ASSOC);
                    $value = $row[$filed];
                } else {
                    $row = $row = $st->fetch(PDO::FETCH_NUM);
                    $value = $row[0];
                }
                return $value;
            }
        }
        return false;
    }

    public function getAllValue($query, $filed)
    {
        if ($this->_link)
        {
            $st = $this->_link->query($query);
            if ($st) {
                $resultArray = array();
                if ($filed) {
                    while ($row = $st->fetch(PDO::FETCH_ASSOC)){
                        $resultArray[] = $row[$filed];
                    }
                } else {
                    while ($row = $st->fetch(PDO::FETCH_NUM)) {
                        $resultArray[] = $row[0];
                    }
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
            $result =  $this->_link->exec($query);
            return $result;
        }
        return false;
    }

    public function disconnect()
    {
        if ($this->_link)
            unset($this->_link);
        $this->_link = false;
    }
}
