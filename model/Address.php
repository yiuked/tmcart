<?php 
class Address extends ObjectBase{
	protected $fields = array(
		'name' => array(
			'type' => 'isInt',
		),
		'id_country' => array(
			'type' => 'isInt',
		),
		'id_state' => array(
			'type' => 'isInt',
		),
		'city' => array(
			'type' => 'isCityName',
		),
		'postcode' => array(
			'type' => 'isPostCode',
		),
		'address' => array(
			'type' => 'isAddress',
		),
		'address2' => array(
			'type' => 'isAddress',
		),
		'phone' => array(
			'type' => 'isPhoneNumber',
		),
		'add_date' => array(
			'type' => 'isDate',
		),
		'upd_date' => array(
			'type' => 'isDate',
		),
	);
	protected $identifier 		= 'id_address';
	protected $table			= 'address';
	
	public static function getEntity($p=1, $limit=50, $orderBy = NULL, $orderWay = NULL, $filter=array())
	{
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
			$where .= ' AND a.`name` LIKE "%'.pSQL($filter['name']).'%"';
		
		if(!is_null($orderBy) AND !is_null($orderWay))
		{
			$postion = 'ORDER BY '.pSQL($orderBy).' '.pSQL($orderWay);
		}else{
			$postion = 'ORDER BY `id_address` DESC';
		}

		$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'.DB_PREFIX.'address` a
				LEFT JOIN  `'.DB_PREFIX.'country` c ON (a.id_country = c.id_country)
				LEFT JOIN  `'.DB_PREFIX.'state` s ON (a.id_state = s.id_state)
				WHERE 1' . $where);
		if($total==0)
			return false;

		$result = Db::getInstance()->getAll('SELECT a.*, c.name AS country, s.name AS state FROM `'.DB_PREFIX.'address` a
				LEFT JOIN  `'.DB_PREFIX.'country` c ON (a.id_country = c.id_country)
				LEFT JOIN  `'.DB_PREFIX.'state` s ON (a.id_state = s.id_state)
				WHERE 1 ' . $where.'
				'.$postion.'
				LIMIT '.(($p-1)*$limit).','.(int)$limit);
		$rows   = array(
				'total' => $total['total'],
				'entitys'  => $result);
		return $rows;
	}
}
?>