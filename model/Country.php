<?php 
class Country extends ObjectBase{
	protected $fields 			= array('iso_code','name','active','need_state','position');
	protected $fieldsRequired	= array('iso_code','name');
	protected $fieldsSize 		= array('name' => 64);
	protected $fieldsValidate	= array(
		'iso_code' => 'isLanguageIsoCode',
		'active' => 'isBool',
		'need_state' => 'isBool',
		'name'=> 'isGenericName');
	
	protected $identifier 		= 'id_country';
	protected $table			= 'country';
	
	public function getFields()
	{
		parent::validation();
		if (isset($this->id))
			$fields['id_country'] = (int)($this->id);
		$fields['iso_code'] = pSQL($this->iso_code);
		$fields['name'] = pSQL($this->name);
		$fields['active'] = (int)($this->active);
		$fields['position'] = (int)($this->position);
		$fields['need_state'] = (int)($this->need_state);
		return $fields;
	}
	
	public static function getEntity($active = true,$p=1,$limit=50,$orderBy = NULL,$orderWay = NULL,$filter=array())
	{
	 	if (!Validate::isBool($active))
	 		die(Tools::displayError());

		$where = '';
		if(!empty($filter['id_country']) && Validate::isInt($filter['id_country']))
			$where .= ' AND a.`id_country`='.intval($filter['id_country']);
		if(!empty($filter['iso_code']) && Validate::isCatalogName($filter['iso_code']))
			$where .= ' AND a.`iso_code`="'.pSQL($filter['subject']).'"';
		if(!empty($filter['name']) && Validate::isCatalogName($filter['name']))
			$where .= ' AND a.`name` LIKE "%'.pSQL($filter['name']).'%"';
		if(!empty($filter['active']) && Validate::isInt($filter['active']))
			$where .= ' AND a.`active`='.((int)($filter['active'])==1?'1':'0');
		if(!empty($filter['need_state']) && Validate::isInt($filter['need_state']))
			$where .= ' AND a.`need_state`='.((int)($filter['need_state'])==1?'1':'0');

		if(!is_null($orderBy) AND !is_null($orderWay))
		{
			$postion = 'ORDER BY '.pSQL($orderBy).' '.pSQL($orderWay);
		}else{
			$postion = 'ORDER BY `position`,`name` ASC';
		}

		$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'._DB_PREFIX_.'country` a
				WHERE 1 '.($active?' AND a.`active`=1 ':'').'
				'.$where);
		if($total==0)
			return false;

		$result = Db::getInstance()->ExecuteS('SELECT a.* FROM `'._DB_PREFIX_.'country` a
				WHERE 1 '.($active?' AND a.`active`=1 ':'').'
				'.$where.'
				'.$postion.'
				LIMIT '.(($p-1)*$limit).','.(int)$limit);
		$rows   = array(
				'total' => $total['total'],
				'entitys'  => $result);
		return $rows;
	}
	
	public function toggle($key,$default=NULL)
	{
	 	if (!Validate::isTableOrIdentifier($this->identifier) OR !Validate::isTableOrIdentifier($this->table))
	 		die('Fatal error:Object not exist!');

	 	/* Object must have a variable called 'active' */
	 	elseif (!key_exists($key, $this))
	 		die('Fatal error:No field \''.$key.'\'');

	 	/* Update active status on object */
	 	$this->{$key} = is_null($default)?(int)(!$this->{$key}):(int)($default);

		/* Change status to active/inactive */
		return Db::getInstance()->Execute('
		UPDATE `'.pSQL(_DB_PREFIX_.$this->table).'`
		SET `'.pSQL($key).'` = '.$this->{$key}.' 
		WHERE `'.pSQL($this->identifier).'` = '.(int)($this->id));
	}
	
	public static function cleanPositions()
	{
		$result = Db::getInstance()->ExecuteS('
		SELECT `id_country`
		FROM `'._DB_PREFIX_.'country`
		ORDER BY `id_country`');
		$sizeof = sizeof($result);
		for ($i = 0; $i < $sizeof; ++$i){
				$sql = '
				UPDATE `'._DB_PREFIX_.'country`
				SET `position` = '.(int)($i).'
				WHERE `id_country` = '.(int)($result[$i]['id_country']);
				Db::getInstance()->Execute($sql);
			}
		return true;
	}
	
	public function updatePosition($way, $position)
	{	
		if (!$res = Db::getInstance()->ExecuteS('
			SELECT cp.`id_country`, cp.`position` 
			FROM `'._DB_PREFIX_.'country` cp
			ORDER BY cp.`position` ASC'
		))
			return false;
		foreach ($res AS $country)
			if ((int)($country['id_country']) == (int)($this->id))
				$movedCountry = $country;
		
		if (!isset($movedCountry) || !isset($position))
			return false;

		return (Db::getInstance()->Execute('
			UPDATE `'._DB_PREFIX_.'country`
			SET `position`= `position` '.($way ? '- 1' : '+ 1').'
			WHERE `position` 
			'.($way 
				? '> '.(int)($movedCountry['position']).' AND `position` <= '.(int)($position)
				: '< '.(int)($movedCountry['position']).' AND `position` >= '.(int)($position)
				))
		AND Db::getInstance()->Execute('
			UPDATE `'._DB_PREFIX_.'country`
			SET `position` = '.(int)($position).'
			WHERE `id_country`='.(int)($movedCountry['id_country'])
			)
		);
	}
}
?>