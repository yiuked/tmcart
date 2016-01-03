<?php 
class User extends ObjectBase{

	protected $fields = array(
		'name' => array(
			'type' => 'isName',
			'required' => true,
			'name' => 32
		),
		'email' => array(
			'type' => 'isEmail',
			'required' => true,
			'name' => 128
		),
		'passwd' => array(
			'type' => 'isPasswd',
			'required' => true,
			'name' => 32
		),
		'active' => array(
			'type' => 'isInt',
		),
		'add_date' => array(
			'type' => 'isDate',
		),
		'upd_date' => array(
			'type' => 'isDate',
		),
	);
	
	protected $identifier 		= 'id_user';
	protected $table			= 'user';

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
	
	public function getAddresses()
	{
		$addresses	= array();
		$result 	= Db::getInstance()->getAll('SELECT `id_address` FROM `'.DB_PREFIX.'address` WHERE `id_user`='.(int)($this->id));
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

	/**
	 *获取用户购物车
	 * @return miex
	 */
	public function getCarts()
	{
		$result 	= Db::getInstance()->getAll('SELECT * FROM `'.DB_PREFIX.'cart` WHERE `id_user`='.(int)($this->id));
		if ($result) {
			return Cart::reload($result, false);
		}
		return false;
	}
	
	public function getContacts()
	{
		$result 	= Db::getInstance()->getAll('SELECT `id_contact`, `active`, `add_date` FROM `'.DB_PREFIX.'contact` WHERE `id_parent` = 0 AND `id_user` = '.(int)($this->id));
		return $result;
	}
	
	public function getOrders()
	{
		$result 	= Db::getInstance()->getAll('
		SELECT o.`id_order`,o.reference,os.name as status,os.color,o.add_date FROM `'.DB_PREFIX.'order` o
		LEFT JOIN `'.DB_PREFIX.'order_status` os ON (o.id_order_status = os.id_order_status)
		WHERE o.`id_user`='.(int)($this->id));

		return $result;
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
	
	public static function loadData($p = 1, $limit = 50, $orderBy = NULL, $orderWay = NULL, $filter = array())
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
				'items'  => $result);
		return $rows;
	}
}
?>