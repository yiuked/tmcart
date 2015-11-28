<?php 
class Contact extends ObjectBase{
	protected $fields 			= array('id_contact','id_parent','id_user','name','email','subject','content','active','add_date','upd_date');
	protected $fieldsRequired	= array('name','email');
	protected $fieldsSize 		= array('name' => 256, 'email' => 256,'subject' => 256,'content' => 512);
	protected $fieldsValidate	= array(
		'subject' => 'isCatalogName',
		'active'=> 'isBool',
		'name' => 'isName', 
		'email' => 'isEmail', 
		'content' => 'isMessage');
	
	protected $identifier 		= 'id_contact';
	protected $table			= 'contact';
	
	public function getFields()
	{
		parent::validation();
		if (isset($this->id))
			$fields['id_contact'] = (int)($this->id);
		$fields['id_parent'] = (int)($this->id_parent);
		$fields['id_user'] = (int)($this->id_user);
		$fields['name'] = pSQL($this->name);
		$fields['subject'] = pSQL($this->subject);
		$fields['content'] = pSQL($this->content);
		$fields['email'] = pSQL($this->email);
		$fields['active'] = isset($this->active)?(int)($this->active):0;
		$fields['add_date'] = pSQL($this->add_date);
		$fields['upd_date'] = pSQL($this->upd_date);
		return $fields;
	}
	
	public static function getContact($active = true,$p=1,$limit=50,$orderBy = NULL,$orderWay = NULL,$filter=array())
	{
	 	if (!Validate::isBool($active))
	 		die(Tools::displayError());

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
				WHERE 1 AND `id_parent`=0 '.($active?' AND a.`active`=1 ':'').'
				'.$where);
		if($total==0)
			return false;

		$result = Db::getInstance()->getAll('SELECT a.* FROM `'.DB_PREFIX.'contact` a
				WHERE 1 AND `id_parent`=0 '.($active?' AND AND a.`active`=1 ':'').'
				'.$where.'
				'.$postion.'
				LIMIT '.(($p-1)*$limit).','.(int)$limit);
		$rows   = array(
				'total' => $total['total'],
				'contacts'  => $result);
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