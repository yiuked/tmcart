<?php 
class Address extends ObjectBase{
	protected $fields 			= array('id_user','first_name','last_name','id_country','id_state','city','postcode','address','address2','phone','is_default','deleted','add_date','upd_date');
	protected $fieldsRequired	= array('id_user','first_name','last_name','id_country','city','postcode','phone','address');
	protected $fieldsSize 		= array('first_name' => 32, 'last_name' => 32,'email' => 128,'passwd' => 32);
	protected $fieldsValidate	= array(
		'first_name' => 'isName',
		'last_name' => 'isName',
		'id_country' => 'isUnsignedId',
		'id_state'=> 'isUnsignedId',
		'city'=> 'isGenericName',
		'address' => 'isAddress',
		'address2'=> 'isAddress',
		'phone'=> 'isPhoneNumber',
		'postcode'=>'isPostCode',
		'is_default'=> 'isUnsignedId');
	
	protected $identifier 		= 'id_address';
	protected $table			= 'address';

	public function __construct($id=NULL)
	{
		parent::__construct($id);
		if($id!==NULL)
		{
			if($this->id_country)
				$this->country 	= new Country((int)($this->id_country));
			if($this->id_state)
				$this->state 	= new State((int)($this->id_state));
		}
	}

	public function getFields()
	{
		parent::validation();
		if (isset($this->id))
			$fields['id_address'] = (int)($this->id);
		$fields['id_user'] = (int)($this->id_user);
		$fields['first_name'] = pSQL($this->first_name);
		$fields['last_name'] = pSQL($this->last_name);
		$fields['id_country'] = (int)($this->id_country);
		$fields['id_state'] = (int)($this->id_state);
		$fields['is_default'] = (int)($this->is_default);
		$fields['deleted'] = (int)($this->deleted);
		$fields['city'] = pSQL($this->city);
		$fields['address'] = pSQL($this->address);
		$fields['address2'] = pSQL($this->address2);
		$fields['phone'] = pSQL($this->phone);
		$fields['postcode'] = pSQL($this->postcode);
		$fields['add_date'] = pSQL($this->add_date);
		$fields['upd_date'] = pSQL($this->upd_date);
		return $fields;
	}
	
	/**
	 * @see ObjectModel::delete()
	 */
	public function delete()
	{

		if (!$this->isUsed())
			return parent::delete();
		else
		{
			$this->deleted = 1;
			return $this->update();
		}
	}
	
	/**
	 * Check if address is used (at least one order placed)
	 *
	 * @return integer Order count for this address
	 */
	public function isUsed()
	{
		$result = Db::getInstance()->getRow('
		SELECT COUNT(`id_order`) AS used
		FROM `'._DB_PREFIX_.'orders`
		WHERE `id_address` = '.(int)$this->id);

		return isset($result['used']) ? $result['used'] : false;
	}
	
	public static function getEntity($active = true,$p=1,$limit=50,$orderBy = NULL,$orderWay = NULL,$filter=array())
	{
	 	if (!Validate::isBool($active))
	 		die(Tools::displayError());

		$where = '';
		if(!empty($filter['id_address']) && Validate::isInt($filter['id_address']))
			$where .= ' AND a.`id_address`='.intval($filter['id_address']);
		if(!empty($filter['id_country']) && Validate::isInt($filter['id_country']))
			$where .= ' AND a.`id_country`='.intval($filter['id_country']);
		if(!empty($filter['id_state']) && Validate::isInt($filter['id_state']))
			$where .= ' AND a.`id_state`='.intval($filter['id_state']);
		if(!empty($filter['address']) && Validate::isCatalogName($filter['address']))
			$where .= ' AND a.`address` LIKE "%'.pSQL($filter['address']).'%"';
		if(!empty($filter['city']) && Validate::isCatalogName($filter['city']))
			$where .= ' AND a.`city` LIKE "%'.pSQL($filter['city']).'%"';
		if(!empty($filter['name']) && Validate::isCatalogName($filter['name']))
			$where .= ' AND a.`first_name` LIKE "%'.pSQL($filter['name']).'%" OR a.`last_name` LIKE "%'.pSQL($filter['name']).'%"';
		if(!empty($filter['active']) && Validate::isInt($filter['active']))
			$where .= ' AND a.`active`='.((int)($filter['active'])==1?'1':'0');
		
		if(!is_null($orderBy) AND !is_null($orderWay))
		{
			$postion = 'ORDER BY '.pSQL($orderBy).' '.pSQL($orderWay);
		}else{
			$postion = 'ORDER BY `id_address` DESC';
		}

		$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'._DB_PREFIX_.'address` a
				WHERE 1 '.($active?' AND a.`active`=1 ':'').'
				'.$where);
		if($total==0)
			return false;

		$result = Db::getInstance()->ExecuteS('SELECT a.* FROM `'._DB_PREFIX_.'address` a
				WHERE 1 '.($active?' AND a.`active`=1 ':'').'
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