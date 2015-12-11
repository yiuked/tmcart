<?php 
class Order extends ObjectBase{

	protected $fields = array(
		'id_cart' => array('type' => 'isInt'),
		'id_user' => array('type' => 'isInt'),
		'id_currency' => array('type' => 'isInt'),
		'reference' => array('type' => 'isGenericName'),
		'id_address' => array('type' => 'isInt'),
		'id_carrier' => array('type' => 'isInt'),
		'id_order_status' => array('type' => 'isInt'),
		'id_module' => array('type' => 'isInt'),
		'product_total' => array('type' => 'isPrice'),
		'shipping_total' => array('type' => 'isPrice'),
		'amount' => array('type' => 'isPrice'),
		'discount' => array('type' => 'isPrice'),
		'track_number' => array('type' => 'isGenericName'),
		'conversion_rate' => array('type' => 'isFloat'),
		'upd_date' => array('type' => 'isDate'),
		'add_date' => array('type' => 'isDate'),
	);

	protected $joinCache = array();
	protected $identifier 		= 'id_order';
	protected $table			= 'order';

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
	
	public function update($nullValues = false)
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
		$row = Db::getInstance()->getRow('SELECT id_order FROM `'.DB_PREFIX.'order` WHERE reference="'.pSQL($reference).'"');
		if(isset($row['id_order'])){
			$order = new Order($row['id_order']);
			return $order;
		}
		return false;
	}
	
	public static function loadData($p=1, $limit=50, $orderBy = NULL, $orderWay = NULL, $filter=array())
	{

		$where = '';
		if(!empty($filter['id_order']) && Validate::isInt($filter['id_order']))
			$where .= ' AND a.`id_order`='.intval($filter['id_order']);
		if(!empty($filter['reference']) && Validate::isInt($filter['reference']))
			$where .= ' AND a.`reference`='.intval($filter['reference']);
		if(!empty($filter['payment']))
			$where .= ' AND a.`payment` LIKE "%'.pSQL($filter['payment']).'%"';
		if(!empty($filter['id_cart']) && Validate::isCatalogName($filter['id_cart']))
			$where .= ' AND a.`id_cart` = '.intval($filter['id_cart']);
		if(!empty($filter['name']) && Validate::isCatalogName($filter['name']))
			$where .= ' AND u.`name` LIKE "%'.pSQL($filter['name']).'%"';
		if(!empty($filter['email']) && Validate::isInt($filter['email']))
			$where .= ' AND a.`email` LIKE "%'.pSQL($filter['email']).'%"';
		
		if(!is_null($orderBy) AND !is_null($orderWay))
		{
			$postion = 'ORDER BY '.pSQL($orderBy).' '.pSQL($orderWay);
		}else{
			$postion = 'ORDER BY `id_order` DESC';
		}

		$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'.DB_PREFIX.'order` a
				LEFT JOIN `'.DB_PREFIX.'user` u ON (a.id_user = u.id_user)
				LEFT JOIN `'.DB_PREFIX.'carrier` c ON (a.id_carrier = c.id_carrier)
				LEFT JOIN `'.DB_PREFIX.'order_status` os ON (os.id_order_status = a.id_order_status)
				WHERE 1
				'.$where);
		
		if ($total == 0) {
			return false;
		}

		$result = Db::getInstance()->getAll('SELECT a.*, m.name AS `payment`, u.name, c.name as carrier, os.name as status, os.color
				FROM `'.DB_PREFIX.'order` a
				LEFT JOIN `'.DB_PREFIX.'user` u ON (a.id_user = u.id_user)
				LEFT JOIN `'.DB_PREFIX.'module` m ON (a.id_module = m.id_module)
				LEFT JOIN `'.DB_PREFIX.'carrier` c ON (a.id_carrier = c.id_carrier)
				LEFT JOIN `'.DB_PREFIX.'order_status` os ON (os.id_order_status = a.id_order_status)
				WHERE 1 
				'.$where.'
				'.$postion.'
				LIMIT '.(($p-1)*$limit).','.(int)$limit
		);
		$rows   = array(
				'total' => $total['total'],
				'items'  => $result);
		return $rows;
	}
}
?>