<?php 
class Cart extends ObjectBase{
	protected $fields 			= array('id_user','id_address','id_carrier','id_currency','discount','msg','add_date','upd_date');
	protected $identifier 		= 'id_cart';
	protected $table			= 'cart';

	public function __construct($id=NULL)
	{
		parent::__construct($id);
		if($id){
			if($this->id_user)
				$this->user 	= new User((int)($this->id_user));
			if($this->id_address)
				$this->address 	= new Address((int)($this->id_address));
			if($this->id_carrier)
				$this->carrier 	= new Carrier((int)($this->id_carrier));
		}
	}

	public function getFields()
	{
		parent::validation();
		if (isset($this->id))
			$fields['id_cart'] = (int)($this->id);
		$fields['id_user'] = (int)($this->id_user);
		$fields['id_address'] = (int)($this->id_address);
		$fields['id_carrier'] = (int)($this->id_carrier);
		$fields['id_currency'] = (int)($this->id_currency);
		$fields['discount'] = (float)($this->discount);
		$fields['msg'] = pSQL($this->msg);
		$fields['add_date'] = pSQL($this->add_date);
		$fields['upd_date'] = pSQL($this->upd_date);
		return $fields;
	}
	
	public function copyFromPost()
	{
		global $cookie;
		parent::copyFromPost();
		if(empty($this->id_user) && isset($cookie->id_user))
			$this->id_user = (int)($cookie->id_user);
		else
			$this->id_user = 0;
		if(empty($this->id_carrier))
			$this->id_carrier = (int)Configuration::get('TM_DEFAULT_CARRIER_ID');
		if(empty($this->id_address))
			$this->id_address   = 0;
		if(empty($this->id_currency) && isset($cookie->id_currency))
			$this->id_currency = (int)($cookie->id_currency);
		else
			$this->id_currency = 0;
		if(empty($this->from_date))
			$this->from_date = '';
		if(empty($this->to_date))
			$this->to_date   = '';
	}
	
	public function add($nullValues = false)
	{
		global $cookie;
		if(isset($cookie->id_user))
		{
			$user    = new User($cookie->id_user);
			$address = $user->getDefaultAddress();
			if($address->id){
				$this->id_address = (int)$address->id;
			} 
		}
		if(parent::add($nullValues))
		{
			$cookie->id_cart = (int)($this->id);
			$cookie->write();
		}
	}
	
	public function delete()
	{
		if(parent::delete()){
			Db::getInstance()->Execute('DELETE FROM '._DB_PREFIX_.'cart_product WHERE id_cart='.(int)($this->id));
		}
	}
	
	public function getCartInfo()
	{
		$arr = array();
		$arr['cart_total'] 		= (float)$this->getProductTotal();
		$arr['cart_discount'] 	= (float)$this->discount;
		$arr['cart_shipping'] 	= (float)$this->getShippingTotal();
		$arr['cart_quantity']	= (int)$this->getProductQantity();
		$arr['cart_products'] 	= $this->getProducts();
		return $arr;
	}
	
	public function getProductTotal()
	{
		return Db::getInstance()->getValue('
			  SELECT SUM(`quantity`*`unit_price`) AS total FROM '._DB_PREFIX_.'cart_product 
			  WHERE id_cart='.(int)($this->id));
	}
	
	public function getProductQantity()
	{
		return (int)Db::getInstance()->getValue('SELECT SUM(quantity) FROM '._DB_PREFIX_.'cart_product WHERE id_cart='.(int)($this->id));
	}
	
	public function getOrderTotal()
	{
		$product_total = $this->getProductTotal();
		$shipping		= $this->getShippingTotal();
		$total			= (int)($product_total + $shipping-$this->discount);
		return $total; 
	}
	
	public function getShippingTotal()
	{
		if(!$this->id_carrier)
			return 0;
		$carrier = new Carrier((int)($this->id_carrier));
		$enjoy_free_shipping_total = (float)Configuration::get('ENJOY_FREE_SHIPPING');
		if($enjoy_free_shipping_total>0&&$this->getProductTotal()>$enjoy_free_shipping_total)
			return 0;
		return $carrier->shipping;
	}
	
	public function getProducts($image="small")
	{
		$products = array();
		$result = Db::getInstance()->ExecuteS('
				  SELECT c.*,p.`name`,p.`price`,p.`rewrite`,p.id_product,i.`id_image`,(c.`quantity`*p.`price`) AS total FROM '._DB_PREFIX_.'cart_product c 
				  LEFT JOIN '._DB_PREFIX_.'product p ON (c.`id_product` = p.`id_product`)
				  LEFT JOIN '._DB_PREFIX_.'image i ON (p.`id_product` = i.`id_product`)
				  WHERE id_cart='.(int)($this->id).' AND i.`cover`=1');
		if(!$result)
			return 0;
		foreach($result as &$row)
		{
			$row['image'] = Image::getImageLink($row['id_image'],$image);
			$row['link']  = Tools::getLink($row['rewrite']);
			$row['attributes'] = Attribute::getByAttributeString($row['id_attributes']);
		}
		return $result;
	}
	
	public function addProduct($id_product,$quantity,$price,$id_attributes='')
	{
		if(is_array($id_attributes))
			$id_attributes = implode(',',$id_attributes);
		if(Db::getInstance()->getValue('SELECT COUNT(*) FROM '._DB_PREFIX_.'cart_product WHERE id_cart='.(int)($this->id).' AND id_product='.(int)($id_product).' AND id_attributes="'.pSQL($id_attributes).'"'))
			return Db::getInstance()->Execute('UPDATE '._DB_PREFIX_.'cart_product SET quantity=quantity+'.(int)($quantity).' WHERE id_cart='.(int)($this->id).' AND id_product='.(int)($id_product).' AND id_attributes="'.pSQL($id_attributes).'"');
		else
			return Db::getInstance()->Execute('INSERT INTO '._DB_PREFIX_.'cart_product (id_cart,id_product,quantity,unit_price,id_attributes) VALUES('.(int)($this->id).','.(int)($id_product).','.(int)($quantity).','.(float)($price).',"'.pSQL($id_attributes).'")');
			
	}
	
	public function deleteProduct($id_cart_product)
	{
		if(Db::getInstance()->Execute('DELETE FROM '._DB_PREFIX_.'cart_product WHERE `id_cart_product`='.intval($id_cart_product))){
			$this->discount = 0;
			return $this->update();
		}
		return false;
	}
	
	public function updateProduct($id_cart_product,$quantity)
	{
		if(Db::getInstance()->Execute('UPDATE '._DB_PREFIX_.'cart_product SET `quantity`='.$quantity.' WHERE `id_cart_product`='.intval($id_cart_product))){
			$this->discount = 0;
			return $this->update();
		}
		return false;
	}
	
	public static function cartIsOrder($id_cart)
	{
		global $cookie;
		$id_order = Db::getInstance()->getValue('SELECT id_order FROM '._DB_PREFIX_.'order WHERE id_cart='.(int)$id_cart);
		if($id_order>0){
			unset($cookie->id_cart);
			return true;
		}
		return false;
	}
	
	public static function reload($result)
	{
		foreach($result as &$row)
		{
			$cart 			= new Cart((int)($row['id_cart']));
			$row['total'] 	= $cart->getOrderTotal();
		}
		return $result;
	}
	
	public static function getEntity($active = true,$p=1,$limit=50,$orderBy = NULL,$orderWay = NULL,$filter=array())
	{
	 	if (!Validate::isBool($active))
	 		die(Tools::displayError());

		$where = '';
		if(!empty($filter['id_cart']) && Validate::isInt($filter['id_cart']))
			$where .= ' AND a.`id_cart`='.intval($filter['id_cart']);
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
			$postion = 'ORDER BY `id_cart` DESC';
		}

		$total  = Db::getInstance()->getRow('SELECT COUNT(*) AS total
					FROM '._DB_PREFIX_.'cart AS a
					Left JOIN '._DB_PREFIX_.'currency AS y ON a.id_currency = y.id_currency
					Left JOIN '._DB_PREFIX_.'carrier AS r ON a.id_carrier = r.id_carrier
					Left JOIN '._DB_PREFIX_.'user AS u ON a.id_user = u.id_user
					WHERE 1 '.$where);
		if($total==0)
			return false;

		$result = Db::getInstance()->ExecuteS('SELECT a.id_cart,a.id_user,a.id_address,a.id_carrier,a.id_currency,u.first_name,u.last_name,r.name as carrier_name,r.shipping,a.add_date 
					FROM '._DB_PREFIX_.'cart AS a
					Left JOIN '._DB_PREFIX_.'currency AS y ON a.id_currency = y.id_currency
					Left JOIN '._DB_PREFIX_.'carrier AS r ON a.id_carrier = r.id_carrier
					Left JOIN '._DB_PREFIX_.'user AS u ON a.id_user = u.id_user
					WHERE 1 '.$where.'
					'.$postion.'
					LIMIT '.(($p-1)*$limit).','.(int)$limit);
		$rows   = array(
				'total' => $total['total'],
				'entitys'  => self::reload($result));
		return $rows;
	}
}
?>