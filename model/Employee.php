<?php
class Employee extends ObjectBase
{

	protected $fields = array(
		'name' => array('type' => 'isName', 'size' => '64', 'required' => true),
		'email' => array('type' => 'isEmail', 'size' => '128', 'required' => true),
		'passwd' => array('type' => 'isPasswdAdmin', 'size' => '32', 'required' => true),
		'active' => array('type' => 'isInt'),
		'add_date' => array('type' => 'isDate'),
		'upd_date' => array('type' => 'isDate'),
		'last_date' => array('type' => 'isDate'),
	);
	
	protected $identifier 		= 'id_employee';
	protected $table			= 'employee';

	
	public static function employeeExists($email)
	{
	 	if (!Validate::isEmail($email))
	 		die ('Email地址错误！');

		return (bool)Db::getInstance()->getValue('
		SELECT `id_employee`
		FROM `'.DB_PREFIX.'employee`
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
		FROM `'.DB_PREFIX.'employee`
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
		FROM `'.DB_PREFIX.'employee`
		WHERE `id_employee` = '.(int)$id_employee.'
		AND `passwd` = \''.pSQL($passwd).'\'
		AND active = 1');
	}
	
	public static function loadData($p=1, $limit=50, $orderBy = NULL, $orderWay = NULL, $filter=array())
	{

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
		$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'.DB_PREFIX.'employee` a
				WHERE 1
				'.$where);

		$result = Db::getInstance()->getAll('SELECT * FROM `'.DB_PREFIX.'employee` a
				WHERE 1
				'.$where.'
				'.$postion.'
				LIMIT '.(($p-1)*$limit).','.(int)$limit);
		$rows   = array(
				'total' => $total['total'],
				'items'  => $result);
		return $rows;
	}

}
?>