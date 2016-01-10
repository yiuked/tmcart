<?php 
class CMSComment extends ObjectBase{

	protected $fields = array(
		'id_cms' => array(
			'type' => 'isInt',
		),
		'name' => array(
			'type' => 'isName',
			'size' => '128',
			'required' => true
		),
		'email' => array(
			'type' => 'isEmail',
			'size' => '128',
			'required' => true
		),
		'comment' => array(
			'type' => 'isMessage',
			'size' => '512',
			'required' => true
		),
		'active' => array(
			'type' => 'isInt',
		),
		'add_date' => array(
			'type' => 'isDate',
		),
		'upd_date' => array(
			'type' => 'isDate',
		),
	);
	protected $identifier 		= 'id_cms_comment';
	protected $table			= 'cms_comment';
	
	public static function loadData($p=1, $limit=50, $orderBy = NULL, $orderWay = NULL, $filter=array())
	{

		$where = '';
		if(!empty($filter['id_cms_comment']) && Validate::isInt($filter['id_cms_comment']))
			$where .= ' AND a.`id_cms_comment`='.intval($filter['id_cms_comment']);
		if(!empty($filter['website']) && Validate::isCatalogName($filter['website']))
			$where .= ' AND a.`website` LIKE "%'.pSQL($filter['website']).'%"';
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
			$postion = 'ORDER BY `id_cms_comment` DESC';
		}
		
		$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'.DB_PREFIX.'cms_comment` a
				LEFT JOIN `'.DB_PREFIX.'cms` b ON (a.`id_cms` = b.`id_cms`)
				WHERE 1'.$where);
		if($total==0)
			return false;

		$result = Db::getInstance()->getAll('SELECT a.*,b.title FROM `'.DB_PREFIX.'cms_comment` a
				LEFT JOIN `'.DB_PREFIX.'cms` b ON (a.`id_cms` = b.`id_cms`)
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