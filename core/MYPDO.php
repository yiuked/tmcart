<?php
/**
 * Created by PhpStorm.
 * User: shake
 * Date: 2015/11/27
 * Time: 15:30
 */

class MYPDO extends Db
{
    public function connect(){
        try{
            $this->_link = new PDO("mysql:host={$this->_server}; dbname={$this->_database}", $this->_user, $this->_password);
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
            $st = $this->_link->query($query);
            return $st->rowCount();
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
            $st = $this->_link->query($query);
            return $st->fetch(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function getAll($query)
    {
        if ($this->_link)
        {
            $resultArray = array();
            $st = $this->_link->query($query);
            while ($row =  $st->fetch(PDO::FETCH_ASSOC))
                $resultArray[] = $row;
            return $resultArray;
        }
        return false;
    }

    public function getValue($query,$filed)
    {
        if ($this->_link)
        {
            $st = $this->_link->query($query);
            $row = $row = $st->fetch(PDO::FETCH_ASSOC);
            return $row[$filed];
        }
        return false;
    }

    public function getAllValue($query,$filed)
    {
        if ($this->_link)
        {
            $st = $this->_link->query($query);
            $resultArray = array();
            while ($row = $st->fetch(PDO::FETCH_ASSOC))
                $resultArray[] = $row[$filed];
            return $resultArray;
        }
        return false;
    }

    protected function exec($query)
    {
        if ($this->_link)
        {
            $result =  $this->_link->exec($query);
            return $result;
        }
        return false;
    }
}
