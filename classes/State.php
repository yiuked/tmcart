<?php 
class State extends ObjectBase{
	protected $fields 			= array('iso_code','name','active','id_country');
	protected $fieldsRequired	= array('iso_code','name');
	protected $fieldsSize 		= array('name' => 64);
	protected $fieldsValidate	= array(
		'iso_code' => 'isLanguageIsoCode',
		'active' => 'isBool',
		'need_state' => 'isBool',
		'name'=> 'isGenericName');
	
	protected $identifier 		= 'id_state';
	protected $table			= 'state';
	
	public function getFields()
	{
		parent::validation();
		if (isset($this->id))
			$fields['id_state'] = (int)($this->id);
		$fields['id_country'] = (int)($this->id_country);
		$fields['iso_code'] = pSQL($this->iso_code);
		$fields['name'] = pSQL($this->name);
		$fields['active'] = (int)($this->active);
		return $fields;
	}
	
	public static function getEntity($active = true,$p=1,$limit=50,$orderBy = NULL,$orderWay = NULL,$filter=array())
	{
	 	if (!Validate::isBool($active))
	 		die(Tools::displayError());

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

		$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'._DB_PREFIX_.'state` a
				WHERE 1 '.($active?' AND a.`active`=1 ':'').'
				'.$where);
		if($total==0)
			return false;

		$result = Db::getInstance()->ExecuteS('SELECT a.* FROM `'._DB_PREFIX_.'state` a
				WHERE 1 '.($active?' AND a.`active`=1 ':'').'
				'.$where.'
				'.$postion.'
				LIMIT '.(($p-1)*$limit).','.(int)$limit);
		$rows   = array(
				'total' => $total['total'],
				'entitys'  => $result);
		return $rows;
	}
}
?>