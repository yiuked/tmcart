<?php 
class Contact extends ObjectBase{
	protected $fields = array(
		'id_parent' => array('type' => 'isInt'),
		'id_user' => array('type' => 'isInt'),
		'name' => array('type' => 'isName', 'size' => '128', 'required' => true),
		'email' => array('type' => 'isEmail', 'size' => '256', 'required' => true),
		'subject' => array('type' => 'isMailSubject'),
		'content' => array('type' => 'isMessage', 'required' => true),
		'active' => array('type' => 'isInt'),
		'add_date' => array('type' => 'isDate'),
		'upd_date' => array('type' => 'isDate'),
	);
	
	protected $identifier 		= 'id_contact';
	protected $table			= 'contact';
	
	public static function loadData($p=1, $limit=50, $orderBy = NULL, $orderWay = NULL, $filter=array())
	{

		$where = '';
		if(!empty($filter['id_contact']) && Validate::isInt($filter['id_contact']))
			$where .= ' AND a.`id_contact`='.intval($filter['id_contact']);
		if(!empty($filter['subject']) && Validate::isCatalogName($filter['subject']))
			$where .= ' AND a.`subject` LIKE "%'.pSQL($filter['subject']).'%"';
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
			$postion = 'ORDER BY `id_contact` DESC';
		}

		$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'.DB_PREFIX.'contact` a
				WHERE 1 AND `id_parent`=0
				'.$where);
		if($total==0)
			return false;

		$result = Db::getInstance()->getAll('SELECT a.* FROM `'.DB_PREFIX.'contact` a
				WHERE 1 AND `id_parent`=0
				'.$where.'
				'.$postion.'
				LIMIT '.(($p-1) * $limit).','.(int)$limit);
		$rows   = array(
				'total' => $total['total'],
				'items'  => $result);
		return $rows;
	}
	
	public function getContactByUser()
	{
		if(intval($this->id_user)==0)
			return false;
		$result = Db::getInstance()->getAll('SELECT * FROM `'.DB_PREFIX.'contact` where id_user='.(int)$this->id_user);
		if(!$result)
			return false;
		$contacts = array();
		foreach($result as $row){
			if($row['id_parent']==0)
				$contacts[$row['id_contact']]=$row;
			else
				$contacts[$row['id_parent']]['reply'][] = $row;
		}
		return $contacts;
		
	}
	
	public function getSubMessage()
	{
		return Db::getInstance()->getAll('SELECT * FROM `'.DB_PREFIX.'contact` WHERE `id_parent`='.(int)($this->id));
	}
}
?>