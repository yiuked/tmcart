<?php
class OrderStatus extends ObjectBase
{
	protected $fields = array(
		'name' => array('type' => 'isGenericName', 'size' => 128, 'required' => true),
		'color' => array('type' => 'isColor', 'size' => 12, 'required' => true),
		'send_mail' => array('type' => 'isInt'),
		'email_tpl' => array('type' => 'isGenericName', 'size' => 128),
		'active' => array('type' => 'isInt'),
	);
	
	protected $identifier 		= 'id_order_status';
	protected $table			= 'order_status';
	
	public static function loadData($p = 1, $limit = 50, $orderBy = NULL, $orderWay = NULL, $filter=array())
	{
		$where = '';
		if(!empty($filter['id_order_status']) && Validate::isInt($filter['id_order_status']))
			$where .= ' AND a.`id_order_status`='.intval($filter['id_order_status']);
		if(!empty($filter['color']) && Validate::isCatalogName($filter['color']))
			$where .= ' AND a.`color` LIKE "%'.pSQL($filter['color']).'%"';
		if(!empty($filter['name']) && Validate::isCatalogName($filter['name']))
			$where .= ' AND a.`name` LIKE "%'.pSQL($filter['name']).'%"';
		if(!empty($filter['send_mail']) && Validate::isInt($filter['send_mail']))
			$where .= ' AND a.`send_mail`='.((int)($filter['send_mail'])==1?'1':'0');
		if(!empty($filter['email_tpl']) && Validate::isInt($filter['email_tpl']))
			$where .= ' AND a.`email_tpl` LIKE "%'.pSQL($filter['email_tpl']).'%"';
		
		if(!is_null($orderBy) AND !is_null($orderWay))
		{
			$postion = 'ORDER BY '.pSQL($orderBy).' '.pSQL($orderWay);
		}else{
			$postion = 'ORDER BY `id_order_status` DESC';
		}

		$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'.DB_PREFIX.'order_status` a
				WHERE 1 '.$where);
		if($total==0)
			return false;

		$result = Db::getInstance()->getAll('SELECT a.* FROM `'.DB_PREFIX.'order_status` a
				WHERE 1 '.$where.'
				'.$postion.'
				LIMIT '.(($p - 1) * $limit).','.(int) $limit);
		$rows   = array(
				'total' => $total['total'],
				'items'  => $result);
		return $rows;
	}
}
?>