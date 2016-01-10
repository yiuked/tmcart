<?php 
class CMSTag extends ObjectBase{
	protected $fields = array(
		'name' => array(
			'type' => 'isGenericName',
			'size' => 56,
			'required' => true,
		),
		'rewrite' => array(
			'type' => 'isGenericName',
			'size' => 128,
			'required' => true,
		),
		'meta_title' => array(
			'type' => 'isGenericName',
		),
		'meta_keywords' => array(
			'type' => 'isGenericName',
		),
		'meta_description' => array(
			'type' => 'isGenericName',
		),
		'add_date' => array(
			'type' => 'isDate',
		),
		'upd_date' => array(
			'type' => 'isDate',
		),
	);
	protected $identifier 		= 'id_cms_tag';
	protected $table			= 'cms_tag';
	
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
	
	public function getThisTags($p = 1, $limit = 50)
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
	
	public static function loadData($p=1, $limit=50, $orderBy = NULL, $orderWay = NULL, $filter=array())
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
		if($total == 0)
			return false;

		$result = Db::getInstance()->getAll('SELECT a.* FROM `'.DB_PREFIX.'cms_tag` a
				WHERE 1 '.$where.'
				'.$postion.'
				LIMIT '.(($p - 1) * $limit).','.(int) $limit);
		$rows   = array(
				'total' => $total['total'],
				'items'  => $result);
		return $rows;
	}
}
?>