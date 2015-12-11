<?php 
class Coupon extends ObjectBase{

	protected $fields = array(
		'code' => array('type' => 'isInt'),
		'id_user' => array('type' => 'isGenericName', 'required' => true, 'size' => 32),
		'use' => array('type' => 'isInt'),
		'off' => array('type' => 'isInt'),
		'amount' => array('type' => 'isPrice'),
		'active' => array('type' => 'isInt'),
		'total_over' => array('type' => 'isPrice'),
		'quantity_over' => array('type' => 'isInt'),
		'add_date' => array('type' => 'isDate'),
	);
	
	protected $identifier 		= 'id_coupon';
	protected $table			= 'coupon';

	
	public static function loadData($p = 1, $limit = 50, $orderBy = NULL, $orderWay = NULL, $filter = array())
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

		$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'.DB_PREFIX.'coupon` a
				WHERE 1'.$where);
		if($total == 0)
			return false;

		$result = Db::getInstance()->getAll('SELECT a.* FROM `'.DB_PREFIX.'coupon` a
				WHERE 1 '.$where.'
				'.$postion.'
				LIMIT '.(($p - 1) * $limit).','.(int) $limit);
		$rows   = array(
				'total' => $total['total'],
				'items' => $result);
		return $rows;
	}
}
?>