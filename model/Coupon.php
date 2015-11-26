<?php 
class Coupon extends ObjectBase{
	protected $fields 			= array('id_user','code','off','use','total_over','quantity_over',
		'amount','active','add_date');
	protected $fieldsRequired	= array('code');
	protected $fieldsSize 		= array('code' => 32);
	protected $fieldsValidate	= array(
		'code' => 'isGenericName');
	
	protected $identifier 		= 'id_coupon';
	protected $table			= 'coupon';
	
	public function getFields()
	{
		parent::validation();
		if (isset($this->id))
			$fields['id_coupon'] = (int)($this->id);
		$fields['id_user'] = (int)($this->id_user);
		$fields['code'] = pSQL($this->code);
		$fields['use'] = (int)($this->use);
		$fields['off'] = (int)($this->off);
		$fields['amount'] = floatval($this->amount);
		$fields['active'] = intval($this->active);
		$fields['total_over'] = floatval($this->total_over);
		$fields['quantity_over'] = intval($this->quantity_over);
		$fields['add_date'] = pSQL($this->add_date);
		return $fields;
	}
	
	public static function getEntity($p=1, $limit=50, $orderBy = NULL, $orderWay = NULL, $filter=array())
	{
		$where = '';
		if(!empty($filter['id_coupon']) && Validate::isInt($filter['id_coupon']))
			$where .= ' AND a.`id_coupon`='.intval($filter['id_coupon']);
		if(!empty($filter['code']) && Validate::isCatalogName($filter['code']))
			$where .= ' AND a.`code` LIKE "%'.pSQL($filter['code']).'%"';
		
		if(!is_null($orderBy) AND !is_null($orderWay))
		{
			$postion = 'ORDER BY '.pSQL($orderBy).' '.pSQL($orderWay);
		}else{
			$postion = 'ORDER BY `id_coupon` DESC';
		}

		$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'._DB_PREFIX_.'coupon` a
				WHERE 1'.$where);
		if($total==0)
			return false;

		$result = Db::getInstance()->ExecuteS('SELECT a.* FROM `'._DB_PREFIX_.'coupon` a
				WHERE 1 '.$where.'
				'.$postion.'
				LIMIT '.(($p-1)*$limit).','.(int)$limit);
		$rows   = array(
				'total' => $total['total'],
				'entitys'  => $result);
		return $rows;
	}
}
?>