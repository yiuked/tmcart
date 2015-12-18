<?php 
class Onepage extends ObjectBase{

	protected $fields = array(
		'view_name' => array(
			'type' => 'isEntityName',
			'required' => true,
			'size' => '56',
		),
		'meta_title' => array(
			'type' => 'isGenericName',
			'size' => '256',
		),
		'meta_keywords' => array(
			'type' => 'isGenericName',
			'size' => '256',
		),
		'meta_description' => array(
			'type' => 'isGenericName',
			'size' => '256',
		),
		'rewrite' => array(
			'type' => 'isLinkRewrite',
			'required' => true,
			'size' => '256',
		),
		'add_date' => array(
			'type' => 'isDate',
		),
		'upd_date' => array(
			'type' => 'isDate',
		),
	);
	protected $identifier 		= 'id_onepage';
	protected $table			= 'onepage';

	public static function loadData($p = 1, $limit = 50, $orderBy = NULL, $orderWay = NULL, $filter=array())
	{
		$where = '';
		if(!empty($filter['id_onepage']) && Validate::isInt($filter['id_onepage']))
			$where .= ' AND a.`id_onepage`='.intval($filter['id_onepage']);
		if(!empty($filter['view_name']) && Validate::isEntityName($filter['view_name']))
			$where .= ' AND a.`view_name` LIKE "%'.pSQL($filter['view_name']).'%"';
		if(!empty($filter['meta_title']) && Validate::isGenericName($filter['meta_title']))
			$where .= ' AND a.`meta_title` LIKE "%'.pSQL($filter['meta_title']).'%"';
		if(!empty($filter['rewrite']) && Validate::isLinkRewrite($filter['rewrite']))
			$where .= ' AND a.`rewrite` LIKE "%'.pSQL($filter['rewrite']).'%"';
		
		if(!is_null($orderBy) AND !is_null($orderWay))
		{
			$postion = 'ORDER BY '.pSQL($orderBy).' '.pSQL($orderWay);
		}else{
			$postion = 'ORDER BY `id_onepage` DESC';
		}

		$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'.DB_PREFIX.'onepage` a
				WHERE 1 '.$where);
		if($total==0)
			return false;

		$result = Db::getInstance()->getAll('SELECT a.* FROM `'.DB_PREFIX.'onepage` a
				WHERE 1 '.$where.'
				'.$postion.'
				LIMIT '.(($p-1)*$limit).','.(int)$limit);
		$rows   = array(
				'total' => $total['total'],
				'items'  => $result);
		return $rows;
	}
}
?>