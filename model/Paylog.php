<?php
class Paylog extends ObjectBase
{
	protected 	$fields 			= array('id_cart','code','msg','add_date');
 	protected 	$fieldsRequired = array('code', 'msg');
	
	protected 	$table = 'paylog';
	protected 	$identifier = 'id_pay';

	public function getFields()
	{
		parent::validation();
		if (isset($this->id))
			$fields['id_pay'] = (int)($this->id);
		$fields['id_cart'] = (int)($this->id_cart);
		$fields['code'] = pSQL($this->code);
		$fields['msg']  = pSQL($this->msg);
		$fields['add_date'] = pSQL($this->add_date);
		return $fields;
	}
	
	public static function msg($id_cart,$code="null",$msg="null")
	{
		$log = new Paylog();
		$log->id_cart 	= (int)$id_cart;
		$log->code 		= pSQL($code);
		$log->msg 		= pSQL($msg);
		$log->add_date 	= date("Y-m-d H:i:s");;
		$log->add();
	}
	
	public static function getEntity($p = 1, $limit = 50, $orderBy = NULL, $orderWay = NULL, $filter=array())
	{
		$where = '';
		if(!empty($filter['id_pay']) && Validate::isInt($filter['id_pay']))
			$where .= ' AND a.`id_pay`='.intval($filter['id_pay']);
		if(!empty($filter['id_cart']) && Validate::isCatalogName($filter['id_cart']))
			$where .= ' AND a.`id_cart` = '.intval($filter['id_cart']);
		
		if(!is_null($orderBy) AND !is_null($orderWay))
		{
			$postion = 'ORDER BY '.pSQL($orderBy).' '.pSQL($orderWay);
		}else{
			$postion = 'ORDER BY `id_pay` DESC';
		}

		$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'._DB_PREFIX_.'paylog` a
				WHERE 1'.$where);
		if($total == 0)
			return false;

		$result = Db::getInstance()->ExecuteS('SELECT a.* FROM `'._DB_PREFIX_.'paylog` a
				WHERE 1 '.$where.'
				'.$postion.'
				LIMIT '.(($p-1)*$limit).','.(int)$limit);
		$rows   = array(
				'total' => $total['total'],
				'entitys'  => $result);
		return $rows;
	}
}

