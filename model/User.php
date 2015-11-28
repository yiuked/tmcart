<?php 
class User extends ObjectBase{
	protected $fields 			= array('name','email','passwd','active','add_date','upd_date');
	protected $fieldsRequired	= array('name','email');
	protected $fieldsSize 		= array('name' => 32,'email' => 128,'passwd' => 32);
	protected $fieldsValidate	= array(
		'name' => 'isName',
		'passwd' => 'isPasswd',
		'active'=> 'isBool',
		'email' => 'isEmail');
	
	protected $identifier 		= 'id_user';
	protected $table			= 'user';
	
	public function getFields()
	{
		parent::validation();
		if (isset($this->id))
			$fields['id_user'] = (int)($this->id);
		$fields['name'] = pSQL($this->name);
		$fields['email'] = pSQL($this->email);
		$fields['passwd'] = pSQL($this->passwd);
		$fields['active'] = 1;
		$fields['add_date'] = pSQL($this->add_date);
		$fields['upd_date'] = pSQL($this->upd_date);
		return $fields;
	}

	public static function userExists($email)
	{
		return (bool)Db::getInstance()->getValue('
		SELECT `id_user`
		FROM `'.DB_PREFIX.'user`
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
	 	if (!Validate::isEmail($email) OR ($passwd != NULL AND !Validate::isPasswd($passwd))){
	 		$this->_errors[] = 'invalid email password combination';
			return false;
		}

		$result = Db::getInstance()->getRow('
		SELECT *
		FROM `'.DB_PREFIX.'user`
		WHERE `active` = 1
		AND `email` = \''.pSQL($email).'\'
		'.($passwd ? 'AND `passwd` = \''.Tools::encrypt($passwd).'\'' : ''));
		if (!$result){
			$this->_errors[] = 'invalid email password combination1';
			return false;
		}
		$this->id = $result['id_user'];
		foreach ($result AS $key => $value)
				$this->{$key} = $value;
		return $this;
	}

	public function logined($vals = array())
	{
		global $cookie;
		$cookie->logged =1;
		$cookie->id_user = $this->id;
		$cookie->email = $this->email;
		$cookie->passwd = $this->passwd;
		$cookie->first_name = $this->first_name;
		$cookie->last_name = $this->last_name;
		if(count($vals)>0)
			foreach($vals as $key=>$val)
				$cookie->{$key} = $val;
		
		if(isset($cookie->id_cart)){
			$cart = new Cart((int)($cookie->id_cart));
			$cart->id_user = $this->id;
			if(isset($vals['id_address']))
				$cart->id_address = (int)($vals['id_address']);
			$cart->update();
		}
		$cookie->write();
	}
	
	/**
	  * Check if user password is the right one
	  *
	  * @param string $passwd Password
	  * @return boolean result
	  */
	public static function checkPassword($id_user, $passwd)
	{
	 	if (!Validate::isPasswd($passwd, 6))
	 		return false;

		return Db::getInstance()->getValue('
		SELECT `id_user`
		FROM `'.DB_PREFIX.'user`
		WHERE `id_user` = '.(int)$id_user.'
		AND `passwd` = \''.pSQL($passwd).'\'
		AND active = 1');
	}
	
	public function getAddress()
	{
		$addresses	= array();
		$result 	= Db::getInstance()->getAll('SELECT `id_address` FROM `'.DB_PREFIX.'address` WHERE `deleted`=0 AND `id_user`='.(int)($this->id));
		foreach($result as $row)
		{
			$addresses[] = new Address(intval($row['id_address']));
		}
		return $addresses;
	}
	
	public function getDefaultAddress()
	{
		$addresses	= array();
		$id_address 	= Db::getInstance()->getValue('SELECT `id_address` FROM `'.DB_PREFIX.'address` WHERE `deleted`=0 AND is_default=1 AND `id_user`='.(int)($this->id));
		if($id_address)
			return new Address(intval($id_address));
		return false;
	}

	public function getCarts()
	{
		$result 	= Db::getInstance()->getAll('SELECT `id_cart`,`add_date` FROM `'.DB_PREFIX.'cart` WHERE `id_user`='.(int)($this->id));
		return $result;
	}
	
	public function getContacts()
	{
		$result 	= Db::getInstance()->getAll('SELECT `id_contact`,`add_date` FROM `'.DB_PREFIX.'contact` WHERE `id_parent`=0 AND `id_user`='.(int)($this->id));
		return $result;
	}
	
	public function getOrders()
	{
		$orders	= array();
		$result 	= Db::getInstance()->getAll('SELECT `id_order` FROM `'.DB_PREFIX.'order` WHERE `id_user`='.(int)($this->id));
		foreach($result as $row)
		{
			$orders[] = new Order(intval($row['id_order']));
		}
		return $orders;
	}
	
	public function getPaymentedProduct()
	{
		$result= Db::getInstance()->getAll('SELECT o.id_cart,c.id_product,c.id_attributes,c.unit_price,c.quantity,tm_product.name,i.id_image
					FROM tm_order AS o
					Left Join tm_cart_product AS c ON o.id_cart = c.id_cart
					Left Join tm_product ON c.id_product = tm_product.id_product
					Left Join tm_image AS i ON tm_product.id_product = i.id_product
					WHERE  i.cover =  1 AND o.id_user ='.(int)$this->id);
		foreach($result as &$row){
			$row["data"] 	= base64_encode($row['id_product']."-".$row['id_cart']."-".$row['unit_price']."-".$row['quantity']."-".$row['id_attributes']);
			$row["md5_key"] = md5($row["data"]); 
		}
		return $result;
	}
	
	public static function getEntitys($p=1, $limit=50, $orderBy = NULL, $orderWay = NULL, $filter=array())
	{
		$where = '';
		if(!empty($filter['id_contact']) && Validate::isInt($filter['id_contact']))
			$where .= ' AND a.`id_contact`='.intval($filter['id_contact']);
		if(!empty($filter['subject']) && Validate::isCatalogName($filter['subject']))
			$where .= ' AND a.`subject` LIKE "%'.pSQL($filter['subject']).'%"';
		if(!empty($filter['name']) && Validate::isCatalogName($filter['name']))
			$where .= ' AND a.`name` LIKE "%'.pSQL($filter['name']).'%"';
		if(!empty($filter['active']) && Validate::isInt($filter['active']))
			$where .= ' AND a.`active`='.((int)($filter['active'])==1?'1':'0');
		if(!empty($filter['email']) && Validate::isInt($filter['email']))
			$where .= ' AND a.`email` LIKE "%'.pSQL($filter['email']).'%"';
		
		if(!is_null($orderBy) AND !is_null($orderWay))
		{
			$postion = 'ORDER BY '.pSQL($orderBy).' '.pSQL($orderWay);
		}else{
			$postion = 'ORDER BY `id_user` DESC';
		}

		$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'.DB_PREFIX.'user` a
				WHERE 1
				'.$where);
		if($total==0)
			return false;

		$result = Db::getInstance()->getAll('SELECT a.* FROM `'.DB_PREFIX.'user` a
				WHERE 1
				'.$where.'
				'.$postion.'
				LIMIT '.(($p-1)*$limit).','.(int)$limit);
		$rows   = array(
				'total' => $total['total'],
				'entitys'  => $result);
		return $rows;
	}
}
?>