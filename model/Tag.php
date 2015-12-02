<?php 
class Tag extends ObjectBase{

	protected $fields = array(
		'name' => array(
			'type' => 'isGenericName',
			'size' => 128,
			'required' => true,
		),
		'meta_title' => array(
			'type' => 'isGenericName',
			'size' => 256,
		),
		'meta_keywords' => array(
			'type' => 'isGenericName',
			'size' => 256,
		),
		'meta_description' => array(
			'type' => 'isGenericName',
			'size' => 256,
		),
		'rewrite' => array(
			'type' => 'isGenericName',
			'size' => 256,
			'required' => true,
		),
	);
	
	protected $identifier 		= 'id_tag';
	protected $table			= 'tag';
	
	public static function existsByTagName($name)
	{
		return Db::getInstance()->getValue('SELECT `id_tag` FROM `'.DB_PREFIX.'tag` WHERE `name` = "'.pSQL($name).'"');
	}
	
	public static function tagsExists($name)
	{
		$name = trim($name);
		if(empty($name))
			return;
		
		if($id_tag = self::existsByTagName($name))
			return 	$id_tag;

		$tag 			 = new Tag();
		$tag->copyFromPost();
		$tag->name	     = pSQL($name);
		$tag->rewrite	 = pSQL('tag-'.$name.'.html');
		$tag->add();
		
		return $tag->id;
	}
	
	public function getThisTags($p=1,$limit=50)
	{
		$result = Db::getInstance()->getAll('SELECT p.* FROM `'.DB_PREFIX.'product` p
				LEFT JOIN `'.DB_PREFIX.'product_to_tag` ptt ON (ptt.`id_product` = p.`id_product`)
				LEFT JOIN `'.DB_PREFIX.'tag` t ON (t.`id_tag` = ptt.`id_tag`)
				WHERE t.`id_tag`='.(int)($this->id).' AND p.active=1
				ORDER BY p.`id_product` DESC
				LIMIT '.(($p-1)*$limit).','.(int)$limit);
		$rows   = array(
				'total' => count($result),
				'entity'  => Product::reLoad($result));
		return $rows;
	}
	
	public static function tagToString($id_product)
	{
		if(!intval($id_product))
			return;
		$result = Db::getInstance()->getAll('
			SELECT `name` FROM `'.DB_PREFIX.'tag` t
			LEFT JOIN `'.DB_PREFIX.'product_to_tag` ptt ON (ptt.`id_tag` = t.`id_tag`)
			WHERE ptt.`id_product` = '.(int)($id_product));
		if(!$result)
			return;
		$tags_str = '';
		foreach($result as $t){
			$tags_str .= $t['name'].',';
		}
		$tags_str = trim($tags_str,',');
		return $tags_str;
	}
	
	public static function getTags($p=1, $limit=50, $orderBy = NULL, $orderWay = NULL, $filter=array())
	{

		$where = '';
		if(!empty($filter['id_tag']) && Validate::isInt($filter['id_tag']))
			$where .= ' AND a.`id_tag`='.intval($filter['id_tag']);
		if(!empty($filter['name']) && Validate::isCatalogName($filter['name']))
			$where .= ' AND a.`name` LIKE "%'.pSQL($filter['name']).'%"';
		
		if(!is_null($orderBy) AND !is_null($orderWay))
		{
			$postion = 'ORDER BY '.pSQL($orderBy).' '.pSQL($orderWay);
		}else{
			$postion = 'ORDER BY `id_tag` DESC';
		}
		
		$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'.DB_PREFIX.'tag` a
				WHERE 1 '.$where);
		if($total==0)
			return false;

		$result = Db::getInstance()->getAll('SELECT a.* FROM `'.DB_PREFIX.'tag` a
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