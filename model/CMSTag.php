<?php 
class CMSTag extends ObjectBase{
	protected $fields 			= array('id_cms_tag','name','meta_title','meta_keywords','meta_description','rewrite','add_date','upd_date');
	protected $fieldsRequired	= array('name','rewrite');
	protected $fieldsSize 		= array('name' => 256);
	protected $fieldsValidate	= array(
		'name' => 'isGenericName',
		'meta_title' => 'isGenericName',
		'meta_keywords' => 'isGenericName',
		'meta_description' => 'isGenericName', 
		'rewrite' => 'isLinkRewrite');
	
	protected $identifier 		= 'id_cms_tag';
	protected $table			= 'cms_tag';
	
	public function getFields()
	{
		parent::validation();
		if (isset($this->id))
			$fields['id_cms_tag'] = (int)($this->id);
		$fields['name'] = pSQL($this->name);
		$fields['meta_title'] = pSQL($this->meta_title);
		$fields['meta_keywords'] = pSQL($this->meta_keywords);
		$fields['meta_description'] = pSQL($this->meta_description);
		$fields['rewrite'] = pSQL($this->rewrite);
		$fields['add_date'] = pSQL($this->add_date);
		$fields['upd_date'] = pSQL($this->upd_date);
		return $fields;
	}
	
	public static function existsByTagName($name)
	{
		return Db::getInstance()->getValue('SELECT `id_cms_tag` FROM `'.DB_PREFIX.'cms_tag` WHERE `name` = "'.pSQL($name).'"');
	}
	
	public static function tagsExists($name)
	{
		if(empty($name))
			return;
		
		if($id_cms_tag = self::existsByTagName($name))
			return 	$id_cms_tag;

		$tag 			 = new CMSTag();
		$tag->copyFromPost();
		$tag->name	     = pSQL($name);
		$tag->rewrite	 = pSQL('post-tag-'.$name.'.html');
		$tag->add();
		
		return $tag->id;
	}
	
	public function getThisTags($p=1,$limit=50)
	{
		$result = Db::getInstance()->getAll('SELECT c.* FROM `'.DB_PREFIX.'cms` c
				LEFT JOIN `'.DB_PREFIX.'cms_to_tag` ctt ON (ctt.`id_cms` = c.`id_cms`)
				LEFT JOIN `'.DB_PREFIX.'cms_tag` ct ON (ct.`id_cms_tag` = ctt.`id_cms_tag`)
				WHERE ct.`id_cms_tag`='.(int)($this->id).' AND c.active=1
				ORDER BY c.`id_cms` DESC
				LIMIT '.(($p-1)*$limit).','.(int)$limit);
		$rows   = array(
				'total' => count($result),
				'posts'  => $result);
		return $rows;
	}
	
	public static function CMSTagToString($id_cms)
	{
		if(!intval($id_cms))
			return;
		$result = Db::getInstance()->getAll('
			SELECT `name` FROM `'.DB_PREFIX.'cms_tag` ct
			LEFT JOIN `'.DB_PREFIX.'cms_to_tag` ctt ON (ctt.`id_cms_tag` = ct.`id_cms_tag`)
			WHERE ctt.`id_cms` = '.(int)($id_cms));
		if(!$result)
			return;
		$tags_str = '';
		foreach($result as $t){
			$tags_str .= $t['name'].',';
		}
		$tags_str = trim($tags_str,',');
		return $tags_str;
	}
	
	public static function getTags($p=1,$limit=50,$orderBy = NULL,$orderWay = NULL,$filter=array())
	{

		$where = '';
		if(!empty($filter['id_cms_tag']) && Validate::isInt($filter['id_cms_tag']))
			$where .= ' AND a.`id_cms_tag`='.intval($filter['id_cms_tag']);
		if(!empty($filter['name']) && Validate::isCatalogName($filter['name']))
			$where .= ' AND a.`name` LIKE "%'.pSQL($filter['name']).'%"';
		
		if(!is_null($orderBy) AND !is_null($orderWay))
		{
			$postion = 'ORDER BY '.pSQL($orderBy).' '.pSQL($orderWay);
		}else{
			$postion = 'ORDER BY `id_cms_tag` DESC';
		}
		
		$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'.DB_PREFIX.'cms_tag` a
				WHERE 1 '.$where);
		if($total==0)
			return false;

		$result = Db::getInstance()->getAll('SELECT a.* FROM `'.DB_PREFIX.'cms_tag` a
				WHERE 1 '.$where.'
				'.$postion.'
				LIMIT '.(($p-1)*$limit).','.(int)$limit);
		$rows   = array(
				'total' => $total['total'],
				'tags'  => $result);
		return $rows;
	}
}
?>