<?php
class Rule extends ObjectBase{

	protected $fields 			= array('entity','view_name','id_entity','rule_link');
	protected $fieldsRequired	= array('entity','view_name','id_entity','rule_link');
	protected $fieldsSize 		= array('entity' => 32,'view_name', 'rule_link' => 256);
	protected $fieldsValidate	= array(
		'entity' => 'isEntityName',
		'view_name' => 'isEntityName',
		'rule_link' => 'isLinkRewrite');
	
	protected $identifier 		= 'id_rule';
	protected $table			= 'rule';
	
	public function getFields()
	{
		parent::validation();
		if (isset($this->id))
			$fields['id_rule'] 	= (int)($this->id);
		$fields['id_entity'] 	= (int)($this->id_entity);
		$fields['entity'] 		= pSQL($this->entity);
		$fields['view_name'] 	= pSQL($this->view_name);
		$fields['rule_link'] 	= pSQL($this->rule_link);
		return $fields;
	}
	
	public static function loadRule($filter=array())
	{	
		$where = 'WHERE 1';
		if(isset($filter['entity']))
			$where .= ' AND `entity`="'.pSQL($filter['entity']).'"';
		if(isset($filter['id_entity']))
			$where .= ' AND `id_entity`='.intval($filter['id_entity']).'';
		if(isset($filter['rule_link']))
			$where .= ' AND `rule_link`="'.pSQL($filter['rule_link']).'"';
	
		$id_rule = Db::getInstance()->getValue('SELECT id_rule FROM `'.DB_PREFIX.'rule` '.$where);
		return new Rule($id_rule);
	}
	
	public static function getRule($active = true,$p=1,$limit=50,$orderBy = NULL,$orderWay = NULL,$filter=array())
	{
	 	if (!Validate::isBool($active))
	 		die(Tools::displayError());

		$where = '';
		if(!empty($filter['id_rule']) && Validate::isInt($filter['id_rule']))
			$where .= ' AND a.`id_rule`='.intval($filter['id_rule']);
		if(!empty($filter['entity']) && Validate::isCatalogName($filter['entity']))
			$where .= ' AND a.`entity` LIKE "%'.pSQL($filter['entity']).'%"';
		if(!empty($filter['rule_link']) && Validate::isCatalogName($filter['rule_link']))
			$where .= ' AND a.`rule_link` LIKE "%'.pSQL($filter['rule_link']).'%"';
		if(!empty($filter['id_entity']) && Validate::isInt($filter['id_entity']))
			$where .= ' AND a.`id_entity`='.(int)$filter['id_entity'];
		
		if(!is_null($orderBy) AND !is_null($orderWay))
		{
			$postion = 'ORDER BY '.pSQL($orderBy).' '.pSQL($orderWay);
		}else{
			$postion = 'ORDER BY `position` ASC';
		}
		$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'.DB_PREFIX.'rule` a
				WHERE 1 '.$where);

		$result = Db::getInstance()->getAll('SELECT * FROM `'.DB_PREFIX.'rule` a
				WHERE 1 '.$where.'
				'.$postion.'
				LIMIT '.(($p-1)*$limit).','.(int)$limit);
		$rows   = array(
				'total' => $total['total'],
				'rules'  => $result);
		return $rows;
	}
	
	public static function existsByLink($r)
	{
		return Db::getInstance()->getValue('SELECT `id_rule` FROM `'.DB_PREFIX.'rule` WHERE `rule_link`="'.pSQL($r).'"');
	}
	
	public static function deleteByUrlLink($link)
	{
		return Db::getInstance()->exec('DELETE FROM `'.DB_PREFIX.'rule` WHERE `rule_link`="'.pSQL($link).'"');
	}
}

?>