<?php 
class CMS extends ObjectBase{
	protected $fields = array(
		'id_category_default' => array('type' => 'isInt'),
		'title' => array('type' => 'isString','size' => 256, 'required' => true),
		'active' => array('type' => 'isInt'),
		'is_top' => array('type' => 'isInt'),
		'meta_title' => array('type' => 'isString','size' => 256),
		'meta_keywords' => array('type' => 'isString','size' => 256),
		'meta_description' => array('type' => 'isString','size' => 256),
		'rewrite' => array('type' => 'isLinkRewrite','size' => 256, 'required' => true),
		'content' => array('type' => 'isCleanHtml', 'required' => true),
	);
	
	protected $identifier 		= 'id_cms';
	protected $table			= 'cms';
	
	public function delete()
	{
		if(parent::delete())
			Db::getInstance()->exec('DELETE FROM `'.DB_PREFIX.'cms_to_category` WHERE `id_cms`='.(int)$this->id);
		return true;
	}
	
	public static function loadData($p=1, $limit=50, $orderBy = NULL, $orderWay = NULL, $filter=array())
	{

		$where = '';
		if(!empty($filter['id_cms']) && Validate::isInt($filter['id_cms']))
			$where .= ' AND a.`id_cms`='.intval($filter['id_cms']);
		if(!empty($filter['title']) && Validate::isCatalogName($filter['title']))
			$where .= ' AND a.`title` LIKE "%'.pSQL($filter['title']).'%"';
		if(!empty($filter['rewrite']) && Validate::isCatalogName($filter['rewrite']))
			$where .= ' AND a.`rewrite` LIKE "%'.pSQL($filter['rewrite']).'%"';
		if(!empty($filter['active']) && Validate::isInt($filter['active']))
			$where .= ' AND a.`active`='.((int)($filter['active'])==1?'1':'0');
		if(!empty($filter['is_top']) && Validate::isInt($filter['is_top']))
			$where .= ' AND a.`is_top`='.((int)($filter['is_top'])==1?'1':'0');
		if(!empty($filter['id_cms_category']) && Validate::isInt($filter['id_cms_category']) && $filter['id_cms_category']>1)
			$where .= ' AND a.`id_cms` IN (SELECT `id_cms` FROM `'.DB_PREFIX.'cms_to_category` WHERE `id_cms_category`='.intval($filter['id_cms_category']).')';
		
		if(!is_null($orderBy) AND !is_null($orderWay))
		{
			$postion = 'ORDER BY '.pSQL($orderBy).' '.pSQL($orderWay);
		}else{
			$postion = 'ORDER BY `id_cms` DESC';
		}
		
		$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'.DB_PREFIX.'cms` a
				WHERE 1
				'.$where);
		if($total==0)
			return false;

		$result = Db::getInstance()->getAll('SELECT * FROM `'.DB_PREFIX.'cms` a
				WHERE 1
				'.$where.'
				'.$postion.'
				LIMIT '.(($p-1)*$limit).','.(int)$limit);
		$rows   = array(
				'total' => $total['total'],
				'items'  => self::resetCMS($result));
		return $rows;
	}
	
	public static function resetCMS($result)
	{
		global $link;
		if(!is_array($result))
			return;
		foreach($result as &$row){
			$row['link'] = $link->getPage('CMSView', $row['id_cms']);
			$row['tags'] = self::getCMSTags($row['id_cms']);
		}
		return $result;
	}
	
	public static function getCMSTags($id_cms)
	{
		global $link;
		$result = Db::getInstance()->getAll('
		SELECT ct.* FROM `'.DB_PREFIX.'cms_tag` ct
		LEFT JOIN `'.DB_PREFIX.'cms_to_tag` ctt ON (ct.`id_cms_tag` = ctt.`id_cms_tag`)
		WHERE ctt.`id_cms` = '.(int)$id_cms);
		foreach($result as &$row)
			$row['link'] = $link->getPage('CMSViewTag', $row['id_cms_tag']);
		return $result;
	}
	
	public static function getCMSCategoriesFullId($id_cms = ''){
		$ret = array();
		$row = Db::getInstance()->getAll('
		SELECT `id_cms_category` FROM `'.DB_PREFIX.'cms_to_category`
		WHERE `id_cms` = '.(int)$id_cms);
		
		foreach ($row as $val)
			$ret[] = $val['id_cms_category'];
		return $ret;
	}
	
	public static function getCMSCategoriesFull($id_cms = '')
	{
		$ret = array();
		
		$row = Db::getInstance()->getAll('
		SELECT ct.`id_cms_category`, c.`name`, c.`rewrite` FROM `'.DB_PREFIX.'cms_to_category` ct
		LEFT JOIN `'.DB_PREFIX.'cms_category` c ON (ct.`id_cms_category` = c.`id_cms_category`)
		WHERE ct.`id_cms` = '.(int)$id_cms);
		foreach ($row as $val)
			$ret[$val['id_cms_category']] = $val;
		return $ret;
	}
	
	/**
	 * getProductCategories return an array of categories which this product belongs to
	 *
	 * @return array of categories
	 */
	public function getCMSCategories()
	{
		$ret = array();
		if ($row = Db::getInstance()->getAll('
		SELECT `id_cms_category` FROM `'.DB_PREFIX.'cms_to_category`
		WHERE `id_cms` = '.(int)$this->id)
		)
			foreach ($row as $val)
				$ret[] = $val['id_cms_category'];
		return $ret;
	}
	
	/**
	 * getProductCategories return an array of categories which this product belongs to
	 *
	 * @return array of categories
	 */
	public function getTags()
	{
		$ret = array();
		if ($row = Db::getInstance()->getAll('
		SELECT `id_cms_category` FROM `'.DB_PREFIX.'cms_to_tag`
		WHERE `id_cms` = '.(int)$this->id)
		)
			foreach ($row as $val)
				$ret[] = $val['id_cms_category'];
		return $ret;
	}
	
	/**
	 * addToCategories add this product to the category/ies if not exists.
	 *
	 * @param mixed $categories id_category or array of id_category
	 * @return boolean true if succeed
	 */
	public function addToCategories($categories = array())
	{
		if (empty($categories))
			return false;

		if (!is_array($categories))
			$categories=array($categories);

		if (!sizeof($categories))
			return false;

		$currentCategories = $this->getCMSCategories();
		$cmsCats = array();
		foreach ($categories as $newIdCateg)
			if (!in_array($newIdCateg,$currentCategories))
				$cmsCats[] = '('. $this->id.', '. $newIdCateg.')';

		if (sizeof($cmsCats))
			return Db::getInstance()->exec('
			INSERT INTO `'.DB_PREFIX.'cms_to_category` (`id_cms`, `id_cms_category`)
			VALUES '.implode(',', $cmsCats));

		return true;
	}
	
	public function addToTags($tags)
	{		
			if (empty($tags))
			return false;
			
			$currenTags = $this->getTags();
			$tagCats = array();

			foreach($tags as $t){
				$id_cms_tag = CMSTag::tagsExists($t);
				if (!in_array($t,$currenTags) && $id_cms_tag)
					$tagCats[] = '('. $this->id.', '. $id_cms_tag.')';
			}
			
			if (sizeof($tagCats))
				return Db::getInstance()->exec('
				INSERT INTO `'.DB_PREFIX.'cms_to_tag` (`id_cms`, `id_cms_tag`)
				VALUES '.implode(',', $tagCats));
			
			return true;
	}
	
	/**
	 * deleteCategory delete this product from the category $id_category
	 *
	 * @param mixed $id_category
	 * @param mixed $cleanPositions
	 * @return boolean
	 */
	public function deleteCategory($id_category)
	{
		$return = Db::getInstance()->exec('DELETE FROM `'.DB_PREFIX.'cms_to_category` WHERE `id_cms` = '.(int)($this->id).' AND id_cms_category = '.(int)$id_category .'' );
		return $return;
	}
	
	/**
	 * deleteCategory delete this product from the category $id_category
	 *
	 * @param mixed $id_category
	 * @param mixed $cleanPositions
	 * @return boolean
	 */
	public function deleteTag($id_cms_tag)
	{
		$return = Db::getInstance()->exec('DELETE FROM `'.DB_PREFIX.'cms_to_tag` WHERE `id_cms` = '.(int)($this->id).' AND id_cms_tag = '.(int)$id_cms_tag .'' );
		return $return;
	}
	
	/**
	* Update categories to index product into
	*
	* @param string $productCategories Categories list to index product into
	* @param boolean keepingCurrentPos (deprecated, no more used)
	* @return array Update/insertion result
	*/
	public function updateCategories($categories)
	{

		if (empty($categories))
			return false;

		// get max position in each categories
		$result = Db::getInstance()->getAll('SELECT `id_cms_category`
				FROM `'.DB_PREFIX.'cms_to_category`
				WHERE `id_cms_category` NOT IN('.implode(',', array_map('intval', $categories)).')
				AND id_cms = '. $this->id .'');
		if(is_array($result))
			foreach ($result as $categToDelete)
				$this->deleteCategory($categToDelete['id_cms_category']);

		if (!$this->addToCategories($categories))
			return false;

		return true;
	}
	
	public function updateTags($tags_str)
	{

		$tags = explode(',',trim($tags_str,','));
		if(!is_array($tags))
			return;

		// get max position in each categories
		$result = Db::getInstance()->getAll('SELECT `id_cms_tag`
				FROM `'.DB_PREFIX.'cms_to_tag`
				WHERE `id_cms_tag` NOT IN('.implode(',', array_map('intval', $tags)).')
				AND id_cms = '. $this->id .'');
		if(is_array($result))
			foreach ($result as $tagToDelete)
				$this->deleteTag($tagToDelete['id_cms_tag']);

		if (!$this->addToTags($tags))
			return false;

		return true;
	}
	
	public function getComments($id_keep=0)
	{
		$result = Db::getInstance()->getAll('SELECT *
		FROM `'.DB_PREFIX.'cms_comment`
		WHERE `id_keep`='.(int)($id_keep).' AND active=1
		AND id_cms = '.(int) $this->id .'');
		if($result)
			foreach($result as &$row)
				$row['children'] = $this->getComments($row['id_cms_comment']);
		return $result;
	}
}
?>