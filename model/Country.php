<?php 
class Country extends ObjectBase{
	protected $fields = array(
		'iso_code' => array(
			'type' => 'isLanguageIsoCode',
			'required' => true,
		),
		'name' => array(
			'type' => 'isGenericName',
			'required' => true,
			'size' => 64
		),
		'active' => array(
			'type' => 'isInt',
		),
		'need_state' => array(
			'type' => 'isInt',
		),
		'position' => array(
			'type' => 'isInt',
		),
	);
	
	protected $identifier 		= 'id_country';
	protected $table			= 'country';
	
	public static function loadData($p = 1, $limit = 50, $orderBy = NULL, $orderWay = NULL, $filter=array())
	{
		$where = '';
		if(!empty($filter['id_country']) && Validate::isInt($filter['id_country']))
			$where .= ' AND a.`id_country`='.intval($filter['id_country']);
		if(!empty($filter['iso_code']) && Validate::isCatalogName($filter['iso_code']))
			$where .= ' AND a.`iso_code`="'.pSQL($filter['subject']).'"';
		if(!empty($filter['name']) && Validate::isCatalogName($filter['name']))
			$where .= ' AND a.`name` LIKE "%'.pSQL($filter['name']).'%"';
		if(!empty($filter['active']) && Validate::isInt($filter['active']))
			$where .= ' AND a.`active`='.((int)($filter['active']) == 1 ? '1' : '0');
		if(!empty($filter['need_state']) && Validate::isInt($filter['need_state']))
			$where .= ' AND a.`need_state`='.((int)($filter['need_state'])==1?'1':'0');

		if(!is_null($orderBy) AND !is_null($orderWay))
		{
			$postion = 'ORDER BY '.pSQL($orderBy).' '.pSQL($orderWay);
		}else{
			$postion = 'ORDER BY `position`,`name` ASC';
		}

		$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'.DB_PREFIX.'country` a
				WHERE 1
				'.$where);
		if($total==0)
			return false;

		$result = Db::getInstance()->getAll('SELECT a.* FROM `'.DB_PREFIX.'country` a
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