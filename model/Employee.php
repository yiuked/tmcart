<?php
class Employee extends ObjectBase
{
	protected $fields 			= array('name','email','passwd','active','add_date','upd_date','last_date');
	protected $fieldsRequired	= array('name','email','passwd');
	protected $fieldsSize 		= array('name' => 64, 'email' => 128,'passwd' => 32);
	protected $fieldsValidate	= array(
		'name' => 'isName',
		'active'=> 'isBool',
		'passwd' => 'isPasswdAdmin',
		'email' => 'isEmail');
	
	protected $identifier 		= 'id_employee';
	protected $table			= 'employee';
	
	public function getFields()
	{
		parent::validation();
		if (isset($this->id))
			$fields['id_emploayee'] = (int)($this->id);
		$fields['name'] 		= pSQL($this->name);
		$fields['email'] 		= pSQL($this->email);
		$fields['passwd'] 		= pSQL($this->passwd);
		$fields['active'] 		= (int)($this->active);
		$fields['add_date'] 	= pSQL($this->add_date);
		$fields['upd_date'] 	= pSQL($this->upd_date);
		$fields['last_date'] 	= pSQL($this->last_date);
		return $fields;
	}
	
	public function add($nullValues = false)
	{
		$this->last_date = date('Y-m-d H:i:s');
		return parent::add($nullValues);
	}
	
	public function delete()
	{
		if ($this->id == 1) return false;
		return parent::delete();
	}
	
	public static function employeeExists($email)
	{
	 	if (!Validate::isEmail($email))
	 		die ('Email地址错误！');

		return (bool)Db::getInstance()->getValue('
		SELECT `id_employee`
		FROM `'._DB_PREFIX_.'employee`
		WHERE `email` = \''.pSQL($email).'\'');
	}
	
	/**
	  * Return employee instance from its e-mail (optionnaly check password)
	  *
	  * @param string $email e-mail
	  * @param string $passwd Password is also checked if specified
	  * @return Employee instance
	  */
	public function getByEmail($email, $passwd = NULL)
	{
	 	if (!Validate::isEmail($email) OR ($passwd != NULL AND !Validate::isPasswd($passwd)))
	 		die('邮箱或密码有误！');

		$result = Db::getInstance()->getRow('
		SELECT *
		FROM `'._DB_PREFIX_.'employee`
		WHERE `active` = 1
		AND `email` = \''.pSQL($email).'\'
		'.($passwd ? 'AND `passwd` = \''.Tools::encrypt($passwd).'\'' : ''));
		if (!$result)
			return false;
		$this->id = $result['id_employee'];
		foreach ($result AS $key => $value)
				$this->{$key} = $value;
		return $this;
	}
	
	/**
	  * Check if employee password is the right one
	  *
	  * @param string $passwd Password
	  * @return boolean result
	  */
	public static function checkPassword($id_employee, $passwd)
	{
	 	if (!Validate::isPasswd($passwd, 8))
	 		die (Tools::displayError());

		return Db::getInstance()->getValue('
		SELECT `id_employee`
		FROM `'._DB_PREFIX_.'employee`
		WHERE `id_employee` = '.(int)$id_employee.'
		AND `passwd` = \''.pSQL($passwd).'\'
		AND active = 1');
	}
	
	public static function getEmployee($active = true,$p=1,$limit=50,$orderBy = NULL,$orderWay = NULL,$filter=array())
	{
	 	if (!Validate::isBool($active))
	 		die(Tools::displayError());

		$where = '';
		if(!empty($filter['id_employee']) && Validate::isInt($filter['id_employee']))
			$where .= ' AND a.`id_employee`='.intval($filter['id_employee']);
		if(!empty($filter['name']) && Validate::isCatalogName($filter['name']))
			$where .= ' AND a.`name` LIKE "%'.pSQL($filter['name']).'%"';
		if(!empty($filter['email']) && Validate::isCatalogName($filter['email']))
			$where .= ' AND a.`email` LIKE "%'.pSQL($filter['email']).'%"';
		if(!empty($filter['active']) && Validate::isInt($filter['active']))
			$where .= ' AND a.`active`='.((int)($filter['active'])==1?'1':'0');
		
		if(!is_null($orderBy) AND !is_null($orderWay))
		{
			$postion = 'ORDER BY '.pSQL($orderBy).' '.pSQL($orderWay);
		}else{
			$postion = 'ORDER BY `position` ASC';
		}
		$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'._DB_PREFIX_.'employee` a
				WHERE 1 '.($active?' a.`active`=1 AND':'').'
				'.$where);

		$result = Db::getInstance()->ExecuteS('SELECT * FROM `'._DB_PREFIX_.'employee` a
				WHERE 1 '.($active?' a.`active`=1 AND':'').'
				'.$where.'
				'.$postion.'
				LIMIT '.(($p-1)*$limit).','.(int)$limit);
		$rows   = array(
				'total' => $total['total'],
				'employees'  => $result);
		return $rows;
	}

}
?>