<?php 
class Country extends ObjectBase{
	protected $fields = array(
		'iso_code' => array(
			'type' => 'isLanguageIsoCode',
			'required' => true,
		),
		'name' => array(
			'type' => 'isGenericName',
			'required' => true,
			'size' => 64
		),
		'active' => array(
			'type' => 'isInt',
		),
		'need_state' => array(
			'type' => 'isInt',
		),
		'position' => array(
			'type' => 'isInt',
		),
	);
	
	protected $identifier 		= 'id_country';
	protected $table			= 'country';
	
	public static function getEntity($p = 1, $limit = 50, $orderBy = NULL, $orderWay = NULL, $filter=array())
	{
		$where = '';
		if(!empty($filter['id_country']) && Validate::isInt($filter['id_country']))
			$where .= ' AND a.`id_country`='.intval($filter['id_country']);
		if(!empty($filter['iso_code']) && Validate::isCatalogName($filter['iso_code']))
			$where .= ' AND a.`iso_code`="'.pSQL($filter['subject']).'"';
		if(!empty($filter['name']) && Validate::isCatalogName($filter['name']))
			$where .= ' AND a.`name` LIKE "%'.pSQL($filter['name']).'%"';
		if(!empty($filter['active']) && Validate::isInt($filter['active']))
			$where .= ' AND a.`active`='.((int)($filter['active']) == 1 ? '1' : '0');
		if(!empty($filter['need_state']) && Validate::isInt($filter['need_state']))
			$where .= ' AND a.`need_state`='.((int)($filter['need_state'])==1?'1':'0');

		if(!is_null($orderBy) AND !is_null($orderWay))
		{
			$postion = 'ORDER BY '.pSQL($orderBy).' '.pSQL($orderWay);
		}else{
			$postion = 'ORDER BY `position`,`name` ASC';
		}

		$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'.DB_PREFIX.'country` a
				WHERE 1
				'.$where);
		if($total==0)
			return false;

		$result = Db::getInstance()->getAll('SELECT a.* FROM `'.DB_PREFIX.'country` a
				WHERE 1
				'.$where.'
				'.$postion.'
				LIMIT '.(($p-1)*$limit).','.(int)$limit);
		$rows   = array(
				'total' => $total['total'],
				'entitys'  => $result);
		return $rows;
	}
	
	public static function cleanPositions()
	{
		$result = Db::getInstance()->getAll('
		SELECT `id_country`
		FROM `'.DB_PREFIX.'country`
		ORDER BY `id_country`');
		$sizeof = sizeof($result);
		for ($i = 0; $i < $sizeof; ++$i){
				$sql = '
				UPDATE `'.DB_PREFIX.'country`
				SET `position` = '.(int)($i).'
				WHERE `id_country` = '.(int)($result[$i]['id_country']);
				Db::getInstance()->exec($sql);
			}
		return true;
	}
	
	public function updatePosition($way, $position)
	{	
		if (!$res = Db::getInstance()->getAll('
			SELECT cp.`id_country`, cp.`position` 
			FROM `'.DB_PREFIX.'country` cp
			ORDER BY cp.`position` ASC'
		))
			return false;
		foreach ($res AS $country)
			if ((int)($country['id_country']) == (int)($this->id))
				$movedCountry = $country;
		
		if (!isset($movedCountry) || !isset($position))
			return false;

		return (Db::getInstance()->exec('
			UPDATE `'.DB_PREFIX.'country`
			SET `position`= `position` '.($way ? '- 1' : '+ 1').'
			WHERE `position` 
			'.($way 
				? '> '.(int)($movedCountry['position']).' AND `position` <= '.(int)($position)
				: '< '.(int)($movedCountry['position']).' AND `position` >= '.(int)($position)
				))
		AND Db::getInstance()->exec('
			UPDATE `'.DB_PREFIX.'country`
			SET `position` = '.(int)($position).'
			WHERE `id_country`='.(int)($movedCountry['id_country'])
			)
		);
	}
}
?>