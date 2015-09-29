<?php 
class Order extends ObjectBase{
	protected $fields 			= array('id_cart','id_user','id_currency','id_address','id_carrier','id_module','track_number','product_total','shipping_total','discount','amount','conversion_rate','id_order_status','reference','add_date','upd_date');
	protected $fieldsRequired	= array('id_cart','id_user','id_currency','id_address','id_carrier','id_module','product_total','shipping_total','discount','amount','conversion_rate','id_order_status');
	protected $fieldsValidate	= array(
		'id_cart' => 'isUnsignedId',
		'id_user'=> 'isUnsignedId',
		'id_currency' => 'isUnsignedId', 
		'id_address' => 'isUnsignedId', 
		'id_carrier'=> 'isUnsignedId',
		'id_order_status'=>'isUnsignedId',
		'id_module' => 'isUnsignedId', 
		'product_total'=>'isPrice',
		'shipping_total'=>'isPrice',
		'amount' => 'isPrice',
		'discount' => 'isPrice',
		'conversion_rate' => 'isFloat');
	
	protected $identifier 		= 'id_order';
	protected $table			= 'order';
	
	public function __construct($id=NULL)
	{
		parent::__construct($id);
		if($id){
			if($this->id_cart)
				$this->cart 	= new Cart((int)($this->id_cart));
			if($this->id_user)
				$this->user 	= new User((int)($this->id_user));
			if($this->id_address)
				$this->address 	= new Address((int)($this->id_address));
			if($this->id_carrier)
				$this->carrier 	= new Carrier((int)($this->id_carrier));
			if($this->id_order_status)
				$this->order_status = new OrderStatus((int)($this->id_order_status));
		}
	}
	
	public function getFields()
	{
		parent::validation();
		if (isset($this->id))
			$fields['id_order'] = (int)($this->id);
		$fields['id_cart'] = (int)($this->id_cart);
		$fields['id_user'] = (int)($this->id_user);
		$fields['id_currency'] = (int)($this->id_currency);
		$fields['id_address'] = (int)($this->id_address);
		$fields['id_carrier'] = (int)($this->id_carrier);
		$fields['id_order_status'] = (int)($this->id_order_status);
		$fields['id_module'] = (int)($this->id_module);
		$fields['track_number'] = pSQL($this->track_number);
		$fields['product_total'] = floatval($this->product_total);
		$fields['shipping_total'] = floatval($this->shipping_total);
		$fields['amount'] = floatval($this->amount);
		$fields['discount'] = floatval($this->discount);
		$fields['conversion_rate'] = floatval($this->conversion_rate);
		$fields['reference'] = pSQL($this->reference);
		$fields['add_date'] = isset($this->add_date)?pSQL($this->add_date):'';
		$fields['upd_date'] = isset($this->upd_date)?pSQL($this->upd_date):'';
		return $fields;
	}
	
	public function add()
	{	
		$this->reference = self::generateReference();
		if(parent::add()){
			$cart = new Cart($this->id_cart);
			$cart->status = Cart::IS_ORDER;
			return $cart->update();
		}
		return false;
	}

	public function delete()
	{
		if(parent::delete()){
			$cart = new Cart($this->id_cart);
			$cart->status = Cart::IS_CLOSE;
			return $cart->update();
		}
		return false;
	}
	
	public function update()
	{
		if($this->id_order_status==2){
			$products = $this->cart->getProducts();
			foreach($products as $row)
				Product::updateOrders($row['id_product']);
		}
		return parent::update();
	}
	
	public static function generateReference()
	{
		do
		$reference = strtoupper(Tools::passwdGen(9, 'NO_NUMERIC'));
		while (Order::getByReference($reference));
		return $reference;
	}
	
	public static function getByReference($reference)
	{
		$row = Db::getInstance()->getRow('SELECT id_order FROM `'._DB_PREFIX_.'order` WHERE reference="'.pSQL($reference).'"');
		if(isset($row['id_order'])){
			$order = new Order($row['id_order']);
			return $order;
		}
		return false;
	}
	
	public static function getEntity($active = true,$p=1,$limit=50,$orderBy = NULL,$orderWay = NULL,$filter=array())
	{
	 	if (!Validate::isBool($active))
	 		die(Tools::displayError());

		$where = '';
		if(!empty($filter['id_order']) && Validate::isInt($filter['id_order']))
			$where .= ' AND a.`id_order`='.intval($filter['id_order']);
		if(!empty($filter['reference']) && Validate::isInt($filter['reference']))
			$where .= ' AND a.`reference`='.intval($filter['reference']);
		if(!empty($filter['subject']) && Validate::isCatalogName($filter['subject']))
			$where .= ' AND a.`subject` LIKE "%'.pSQL($filter['subject']).'%"';
		if(!empty($filter['id_cart']) && Validate::isCatalogName($filter['id_cart']))
			$where .= ' AND a.`id_cart` = '.intval($filter['id_cart']);
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
			$postion = 'ORDER BY `id_order` DESC';
		}

		$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'._DB_PREFIX_.'order` a
				LEFT JOIN `'._DB_PREFIX_.'user` u ON (a.id_user = u.id_user)
				LEFT JOIN `'._DB_PREFIX_.'carrier` c ON (a.id_carrier = c.id_carrier)
				LEFT JOIN `'._DB_PREFIX_.'order_status` os ON (os.id_order_status = a.id_order_status)
				WHERE 1
				'.$where);
		
		if($total==0)
			return false;

		$result = Db::getInstance()->ExecuteS('SELECT a.*,u.first_name,u.last_name,c.name as carrier,os.name as status,os.color FROM `'._DB_PREFIX_.'order` a
				LEFT JOIN `'._DB_PREFIX_.'user` u ON (a.id_user = u.id_user)
				LEFT JOIN `'._DB_PREFIX_.'carrier` c ON (a.id_carrier = c.id_carrier)
				LEFT JOIN `'._DB_PREFIX_.'order_status` os ON (os.id_order_status = a.id_order_status)
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