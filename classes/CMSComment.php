<?php 
class CMSComment extends ObjectBase{
	protected $fields 			= array('id_cms_comment','id_cms','id_keep','name','email','website','comment','active','add_date','upd_date');
	protected $fieldsRequired	= array('name','email','comment');
	protected $fieldsSize 		= array('name' => 256, 'email' => 256,'comment' => 512);
	protected $fieldsValidate	= array(
		'website' => 'isUrl',
		'active'=> 'isBool',
		'name' => 'isName', 
		'email' => 'isEmail', 
		'comment' => 'isMessage');
	
	protected $identifier 		= 'id_cms_comment';
	protected $table			= 'cms_comment';
	
	public function getFields()
	{
		parent::validation();
		if (isset($this->id))
			$fields['id_cms_comment'] = (int)($this->id);
		$fields['website'] = pSQL($this->website);
		$fields['name'] = pSQL($this->name);
		$fields['comment'] = pSQL($this->comment);
		$fields['email'] = pSQL($this->email);
		$fields['id_cms'] = (int)($this->id_cms);
		$fields['id_keep'] = (int)($this->id_keep);
		$fields['active'] = isset($this->active)?(int)($this->active):0;
		$fields['add_date'] = pSQL($this->add_date);
		$fields['upd_date'] = pSQL($this->upd_date);
		return $fields;
	}
	
	public static function getComments($active = true,$p=1,$limit=50,$orderBy = NULL,$orderWay = NULL,$filter=array())
	{
	 	if (!Validate::isBool($active))
	 		die(Tools::displayError());

		$where = '';
		if(!empty($filter['id_cms_comment']) && Validate::isInt($filter['id_cms_comment']))
			$where .= ' AND a.`id_cms_comment`='.intval($filter['id_cms_comment']);
		if(!empty($filter['website']) && Validate::isCatalogName($filter['website']))
			$where .= ' AND a.`website` LIKE "%'.pSQL($filter['website']).'%"';
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
			$postion = 'ORDER BY `id_cms_comment` DESC';
		}
		
		$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'._DB_PREFIX_.'cms_comment` a
				LEFT JOIN `'._DB_PREFIX_.'cms` b ON (a.`id_cms` = b.`id_cms`)
				WHERE 1 '.($active?' AND a.`active`=1 ':'').'
				'.$where);
		if($total==0)
			return false;

		$result = Db::getInstance()->ExecuteS('SELECT a.*,b.title FROM `'._DB_PREFIX_.'cms_comment` a
				LEFT JOIN `'._DB_PREFIX_.'cms` b ON (a.`id_cms` = b.`id_cms`)
				WHERE 1 '.($active?' AND a.`active`=1 ':'').'
				'.$where.'
				'.$postion.'
				LIMIT '.(($p-1)*$limit).','.(int)$limit);
		$rows   = array(
				'total' => $total['total'],
				'comments'  => $result);
		return $rows;
	}
}
?>