<?php 
class Onepage extends ObjectBase{
	protected $fields 			= array('id_onepage','view_name','meta_title','meta_keywords','meta_description','rewrite','add_date','upd_date');
	protected $fieldsRequired	= array('view_name','rewrite');
	protected $fieldsSize 		= array('view_name'=>128,'meta_description' => 256, 'meta_keywords' => 256,
		'meta_title' => 256, 'rewrite' => 256, 'title' => 256);
	protected $fieldsValidate	= array(
		'view_name' => 'isEntityName',
		'meta_title' => 'isGenericName',
		'meta_keywords' => 'isGenericName',
		'meta_description' => 'isGenericName', 
		'rewrite' => 'isLinkRewrite');
	
	protected $identifier 		= 'id_onepage';
	protected $table			= 'onepage';
	
	public function getFields()
	{
		parent::validation();
		if (isset($this->id))
			$fields['id_onepage'] = (int)($this->id);
		$fields['view_name'] = pSQL($this->view_name);
		$fields['meta_title'] = pSQL($this->meta_title);
		$fields['meta_keywords'] = pSQL($this->meta_keywords);
		$fields['meta_description'] = pSQL($this->meta_description);
		$fields['rewrite'] = pSQL($this->rewrite);
		$fields['add_date'] = pSQL($this->add_date);
		$fields['upd_date'] = pSQL($this->upd_date);
		return $fields;
	}

	public static function getPages($action=true,$p=1,$limit=50,$orderBy = NULL,$orderWay = NULL,$filter=array())
	{
		$where = '';
		if(!empty($filter['id_onepage']) && Validate::isInt($filter['id_onepage']))
			$where .= ' AND a.`id_onepage`='.intval($filter['id_onepage']);
		if(!empty($filter['view_name']) && Validate::isEntityName($filter['view_name']))
			$where .= ' AND a.`view_name` LIKE "%'.pSQL($filter['view_name']).'%"';
		if(!empty($filter['meta_title']) && Validate::isGenericName($filter['meta_title']))
			$where .= ' AND a.`meta_title` LIKE "%'.pSQL($filter['meta_title']).'%"';
		if(!empty($filter['rewrite']) && Validate::isLinkRewrite($filter['rewrite']))
			$where .= ' AND a.`rewrite` LIKE "%'.pSQL($filter['rewrite']).'%"';
		
		if(!is_null($orderBy) AND !is_null($orderWay))
		{
			$postion = 'ORDER BY '.pSQL($orderBy).' '.pSQL($orderWay);
		}else{
			$postion = 'ORDER BY `id_onepage` DESC';
		}

		$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'.DB_PREFIX.'onepage` a
				WHERE 1 '.$where);
		if($total==0)
			return false;

		$result = Db::getInstance()->getAll('SELECT a.* FROM `'.DB_PREFIX.'onepage` a
				WHERE 1 '.$where.'
				'.$postion.'
				LIMIT '.(($p-1)*$limit).','.(int)$limit);
		$rows   = array(
				'total' => $total['total'],
				'entitys'  => $result);
		return $rows;
	}
}
?>