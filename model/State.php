<?php 
class State extends ObjectBase{

	protected $fields = array(
		'iso_code' => array('type' => 'isInt'),
		'id_country' => array('type' => 'isInt'),
		'active' => array('type' => 'isInt'),
		'need_state' => array('type' => 'isInt'),
		'name' => array('type' => 'isGenericName', 'required' => true, 'size' => 40),
	);
	protected $identifier 		= 'id_state';
	protected $table			= 'state';

	/**
	 * 获取数据
	 * @param int $p
	 * @param int $limit
	 * @param null $orderBy
	 * @param null $orderWay
	 * @param array $filter
	 * @return array|bool
	 */
	public static function loadData($p=1 ,$limit=50, $orderBy = NULL, $orderWay = NULL, $filter=array())
	{
		$where = '';
		if(!empty($filter['id_state']) && Validate::isInt($filter['id_state']))
			$where .= ' AND a.`id_state`='.intval($filter['id_state']);
		if(!empty($filter['iso_code']) && Validate::isCatalogName($filter['iso_code']))
			$where .= ' AND a.`iso_code`="'.pSQL($filter['subject']).'"';
		if(!empty($filter['id_country']) && Validate::isCatalogName($filter['id_country']))
			$where .= ' AND a.`id_country` = '.intval($filter['id_country']);
		if(!empty($filter['name']) && Validate::isCatalogName($filter['name']))
			$where .= ' AND a.`name` LIKE "%'.pSQL($filter['name']).'%"';
		if(!empty($filter['active']) && Validate::isInt($filter['active']))
			$where .= ' AND a.`active`='.((int)($filter['active'])==1?'1':'0');

		if(!is_null($orderBy) AND !is_null($orderWay))
		{
			$postion = 'ORDER BY '.pSQL($orderBy).' '.pSQL($orderWay);
		}else{
			$postion = 'ORDER BY `id_state` DESC';
		}

		$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'.DB_PREFIX.'state` a
				LEFT JOIN `'.DB_PREFIX.'country` c ON (a.id_country = c.id_country)
				WHERE 1
				'.$where);
		if($total==0)
			return false;

		$result = Db::getInstance()->getAll('SELECT a.*, c.name as country FROM `'.DB_PREFIX.'state` a
				LEFT JOIN `'.DB_PREFIX.'country` c ON (a.id_country = c.id_country)
				WHERE 1
				'.$where.'
				'.$postion.'
				LIMIT '.(($p - 1) * $limit) . ','.(int) $limit);
		$rows   = array(
				'total' => $total['total'],
				'items'  => $result);
		return $rows;
	}
}
?>