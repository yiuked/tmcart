<?php 
class Attribute extends ObjectBase{

	protected $fields	= array(
		'id_attribute_group' => array(
			'required' => true,
			'type' => 'isInt',
		),
		'name' => array(
			'required' => true,
			'size' => 56,
			'type' => 'isGenericName',
		),
		'position' => array(
			'type' => 'isInt',
		),
	);
	
	protected $identifier 		= 'id_attribute';
	protected $table			= 'attribute';
	
	public function add()
	{
		$this->position = $this->getLastPosition();
		return parent::add();
	}
	
	public function delete()
	{
		if(parent::delete())
		{
			return Db::getInstance()->exec('DELETE FROM `'.DB_PREFIX.'`product_to_attribute WHERE `id_attribute`='.(int)($this->id));
		}
	}
	
	public function getLastPosition()
	{
		return (Db::getInstance()->getValue('SELECT MAX(position) + 1 FROM `'.DB_PREFIX.'attribute` WHERE `id_attribute_group`='.(int)($this->id_attribute_group)));
	}
	
	public function cleanPositions()
	{
		$result = Db::getInstance()->getAll('
		SELECT `id_attribute`
		FROM `'.DB_PREFIX.'attribute`
		WHERE `id_attribute_group` = '.(int)($this->id_attribute_group).'
		ORDER BY `position`');
		$sizeof = sizeof($result);
		for ($i = 0; $i < $sizeof; ++$i){
				$sql = '
				UPDATE `'.DB_PREFIX.'attribute`
				SET `position` = '.(int)($i).'
				WHERE `id_attribute_group` = '.(int)($this->id_attribute_group).'
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

	public static function loadData($p = 1, $limit = 50, $orderBy = NULL, $orderWay = NULL, $filter = array())
	{
		$where = '';
		if (!isset($filter['id_attribute_group']) || (isset($filter['id_attribute_group']) && (int) $filter['id_attribute_group'] == 0)) {
			return false;
		} else {
			$where .= ' AND a.`id_attribute_group`='.intval($filter['id_attribute_group']);
		}

		if(!empty($filter['id_attribute']) && Validate::isInt($filter['id_attribute']))
			$where .= ' AND a.`id_attribute`='.intval($filter['id_attribute']);
		if(!empty($filter['name']) && Validate::isCatalogName($filter['name']))
			$where .= ' AND a.`name` LIKE "%'.pSQL($filter['name']).'%"';

		if(!is_null($orderBy) AND !is_null($orderWay))
		{
			$postion = 'ORDER BY '.pSQL($orderBy).' '.pSQL($orderWay);
		}else{
			$postion = 'ORDER BY `position` ASC';
		}

		$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'.DB_PREFIX.'attribute` a
				WHERE 1 '.$where);
		if($total==0)
			return false;

		$result = Db::getInstance()->getAll('SELECT a.* FROM `'.DB_PREFIX.'attribute` a
				WHERE 1 '.$where.'
				'.$postion.'
				LIMIT '.(($p - 1) * $limit).','.(int) $limit);
		$rows   = array(
			'total' => $total['total'],
			'items'  => $result);
		return $rows;
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