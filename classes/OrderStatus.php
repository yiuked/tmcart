<?php
class OrderStatus extends ObjectBase
{
	protected $fields 			= array('name','color','send_mail','email_tpl','active');
	protected $fieldsRequired	= array('name','color');
	protected $fieldsSize 		= array('name' => 128,'color' => 56);
	protected $fieldsValidate	= array(
		'name' => 'isGenericName',
		'active'=> 'isBool',
		'color' => 'isColor', 
		'send_mail' => 'isBool', 
		'email_tpl' => 'isGenericName');
	
	protected $identifier 		= 'id_order_status';
	protected $table			= 'order_status';
	
	public function getFields()
	{
		parent::validation();
		if (isset($this->id))
			$fields['id_order_status'] = (int)($this->id);
		$fields['name'] 	= pSQL($this->name);
		$fields['color'] 	= pSQL($this->color);
		$fields['send_mail']= (int)($this->send_mail);
		$fields['email_tpl']= pSQL($this->email_tpl);
		$fields['active'] 	= (int)($this->active);
		return $fields;
	}
	
	public static function getEntity($active = true,$p=1,$limit=50,$orderBy = NULL,$orderWay = NULL,$filter=array())
	{
	 	if (!Validate::isBool($active))
	 		die(Tools::displayError());

		$where = '';
		if(!empty($filter['id_order_status']) && Validate::isInt($filter['id_order_status']))
			$where .= ' AND a.`id_order_status`='.intval($filter['id_order_status']);
		if(!empty($filter['color']) && Validate::isCatalogName($filter['color']))
			$where .= ' AND a.`color` LIKE "%'.pSQL($filter['color']).'%"';
		if(!empty($filter['name']) && Validate::isCatalogName($filter['name']))
			$where .= ' AND a.`name` LIKE "%'.pSQL($filter['name']).'%"';
		if(!empty($filter['active']) && Validate::isInt($filter['active']))
			$where .= ' AND a.`active`='.((int)($filter['active'])==1?'1':'0');
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

		$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'._DB_PREFIX_.'order_status` a
				WHERE 1 '.($active?' AND a.`active`=1 ':'').'
				'.$where);
		if($total==0)
			return false;

		$result = Db::getInstance()->ExecuteS('SELECT a.* FROM `'._DB_PREFIX_.'order_status` a
				WHERE 1 '.($active?' AND a.`active`=1 ':'').'
				'.$where.'
				'.$postion.'
				LIMIT '.(($p-1)*$limit).','.(int)$limit);
		$rows   = array(
				'total' => $total['total'],
				'entitys'  => $result);
		return $rows;
	}
	
	public function toggle($key,$default='NULL')
	{
	 	if (!Validate::isTableOrIdentifier($this->identifier) OR !Validate::isTableOrIdentifier($this->table))
	 		die('Fatal error:Object not exist!');

	 	/* Object must have a variable called 'active' */
	 	elseif (!key_exists($key, $this))
	 		die('Fatal error:No field \''.$key.'\'');

	 	/* Update active status on object */
		if($default == 'NULL'){
	 		$this->{$key} = $this->{$key}==1?0:1;
		}else{
			$this->{$key} = (int)($default);
		}

		/* Change status to active/inactive */
		return Db::getInstance()->Execute('
		UPDATE `'.pSQL(_DB_PREFIX_.$this->table).'`
		SET `'.pSQL($key).'` = '.(int)($this->{$key}).'
		WHERE `'.pSQL($this->identifier).'` = '.(int)($this->id));
	}
}
?>