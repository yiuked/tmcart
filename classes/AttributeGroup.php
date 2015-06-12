<?php 
class AttributeGroup extends ObjectBase{
	protected $fields 			= array('name','group_type','position');
	protected $fieldsRequired	= array('name','group_type');
	protected $fieldsSize 		= array('name' => 56);
	protected $fieldsValidate	= array('name' => 'isGenericName');
	
	protected $identifier 		= 'id_attribute_group';
	protected $table			= 'attribute_group';
	
	public function getFields()
	{
		parent::validation();
		if (isset($this->id))
			$fields['id_attribute_group'] = (int)($this->id);
		$fields['position'] = (int)($this->position);
		$fields['name'] = pSQL($this->name);
		$fields['group_type'] = pSQL($this->group_type);
		return $fields;
	}
	
	public function add($nullValues = false)
	{
		$this->position = self::getLastPosition();
		return parent::add($nullValues);
	}
	
	public function delete()
	{
		if(parent::delete())
		{
			$ret = true;
			$attributes = $this->getAttributes();
			foreach($attributes as $attribute){
				$attr = new Attribute((int)($attribute['id_attribute']));
				$ret &= $attr->delete();
			}
			return $ret;
		}
	} 
	
	public static function getEntitys($active = true,$p=1,$limit=50,$orderBy = NULL,$orderWay = NULL,$filter=array())
	{
	 	if (!Validate::isBool($active))
	 		die(Tools::displayError());

		$where = '';
		if(!empty($filter['id_attribute_group']) && Validate::isInt($filter['id_attribute_group']))
			$where .= ' AND a.`id_attribute_group`='.intval($filter['id_attribute_group']);
		if(!empty($filter['name']) && Validate::isCatalogName($filter['name']))
			$where .= ' AND a.`name` LIKE "%'.pSQL($filter['name']).'%"';
		
		if(!is_null($orderBy) AND !is_null($orderWay))
		{
			$postion = 'ORDER BY '.pSQL($orderBy).' '.pSQL($orderWay);
		}else{
			$postion = 'ORDER BY `position` DESC';
		}

		$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'._DB_PREFIX_.'attribute_group` a
				WHERE 1 '.$where);
		if($total==0)
			return false;

		$result = Db::getInstance()->ExecuteS('SELECT a.* FROM `'._DB_PREFIX_.'attribute_group` a
				WHERE 1 '.$where.'
				'.$postion.'
				LIMIT '.(($p-1)*$limit).','.(int)$limit);
		$rows   = array(
				'total' => $total['total'],
				'entitys'  => $result);
		return $rows;
	}
	
	public function getAttributes()
	{
		return Db::getInstance()->ExecuteS('
				   SELECT * FROM `'._DB_PREFIX_.'attribute`
				   WHERE `id_attribute_group`='.(int)($this->id).'
				   ORDER BY position ASC
		');
	}
	
	public static function getLastPosition()
	{
		return (Db::getInstance()->getValue('SELECT MAX(position)+1 FROM `'._DB_PREFIX_.'attribute_group`'));
	}
}
?>