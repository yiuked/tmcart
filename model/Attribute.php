<?php 
class Attribute extends ObjectBase{
	protected $fields 			= array('name','id_attribute_group','position');
	protected $fieldsRequired	= array('name','id_attribute_group');
	protected $fieldsSize 		= array('name' => 56);
	protected $fieldsValidate	= array('name' => 'isGenericName');
	
	protected $identifier 		= 'id_attribute';
	protected $table			= 'attribute';
	
	public function getFields()
	{
		parent::validation();
		if (isset($this->id))
			$fields['id_attribute'] = (int)($this->id);
		$fields['id_attribute_group'] = (int)($this->id_attribute_group);
		$fields['position'] = (int)($this->position);
		$fields['name'] = pSQL($this->name);
		return $fields;
	}
	
	public function add($nullValues = false)
	{
		$this->position = self::getLastPosition($this->id_attribute_group);
		return parent::add($nullValues);
	}
	
	public function delete()
	{
		if(parent::delete())
		{
			return Db::getInstance()->exec('DELETE FROM `'.DB_PREFIX.'`product_to_attribute WHERE `id_attribute`='.(int)($this->id));
		}
	}
	
	public static function getLastPosition($id_attribute_group)
	{
		return (Db::getInstance()->getValue('SELECT MAX(position)+1 FROM `'.DB_PREFIX.'attribute` WHERE `id_attribute_group`='.(int)($id_attribute_group)));
	}
	
	public static function cleanPositions($id_group)
	{
		$result = Db::getInstance()->getAll('
		SELECT `id_attribute`
		FROM `'.DB_PREFIX.'attribute`
		WHERE `id_attribute_group` = '.(int)($id_group).'
		ORDER BY `position`');
		$sizeof = sizeof($result);
		for ($i = 0; $i < $sizeof; ++$i){
				$sql = '
				UPDATE `'.DB_PREFIX.'attribute`
				SET `position` = '.(int)($i).'
				WHERE `id_attribute_group` = '.(int)($id_group).'
				AND `id_attribute` = '.(int)($result[$i]['id_attribute']);
				Db::getInstance()->exec($sql);
			}
		return true;
	}
	
	public function updatePosition($way, $position)
	{	
		if (!$res = Db::getInstance()->getAll('
			SELECT `id_attribute`, `position`, `id_attribute_group` 
			FROM `'.DB_PREFIX.'attribute`
			WHERE `id_attribute_group` = '.(int)$this->id_attribute_group.' 
			ORDER BY `position` ASC'
		))
			return false;
		foreach ($res AS $attribute)
			if ((int)($attribute['id_attribute']) == (int)($this->id))
				$movedAttribute = $attribute;
		
		if (!isset($movedAttribute) || !isset($position))
			return false;
		// < and > statements rather than BETWEEN operator
		// since BETWEEN is treated differently according to databases
		return (Db::getInstance()->exec('
			UPDATE `'.DB_PREFIX.'attribute`
			SET `position`= `position` '.($way ? '- 1' : '+ 1').'
			WHERE `position` 
			'.($way 
				? '> '.(int)($movedAttribute['position']).' AND `position` <= '.(int)($position)
				: '< '.(int)($movedAttribute['position']).' AND `position` >= '.(int)($position)).'
			AND `id_attribute_group`='.(int)($movedAttribute['id_attribute_group']))
		AND Db::getInstance()->exec('
			UPDATE `'.DB_PREFIX.'attribute`
			SET `position` = '.(int)($position).'
			WHERE `id_attribute_group` = '.(int)($movedAttribute['id_attribute_group']).'
			AND `id_attribute`='.(int)($movedAttribute['id_attribute'])));
	}
	
	public static function getByAttributeString($attribute_str)
	{
		if(!strlen($attribute_str))
			return;
		return Db::getInstance()->getAll('SELECT a.`id_attribute`,a.`id_attribute_group`,a.`name`,g.`name` AS group_name FROM `'.DB_PREFIX.'attribute` a
									 LEFT JOIN `'.DB_PREFIX.'attribute_group` g ON (a.`id_attribute_group`=g.`id_attribute_group`)
									 WHERE a.`id_attribute` IN ('.pSQL($attribute_str).')');
	}
}
?>