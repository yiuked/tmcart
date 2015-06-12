<?php 
class Category extends ObjectBase{
	protected $fields 			= array('id_parent','level_depth','nleft','nright','position','name','description',
		'meta_title','meta_keywords','meta_description','rewrite','active','add_date','upd_date');
	protected $fieldsRequired	= array('name','rewrite');
	protected $fieldsSize 		= array('meta_description' => 256, 'meta_keywords' => 256,
		'meta_title' => 256, 'link_rewrite' => 256, 'name' => 256);
	protected $fieldsValidate	= array(
		'name' => 'isCatalogName',
		'active'=> 'isBool',
		'meta_title' => 'isGenericName',
		'meta_keywords' => 'isGenericName',
		'meta_description' => 'isGenericName', 
		'rewrite' => 'isLinkRewrite', 
		'description' => 'isCleanHtml');
	
	protected $identifier 		= 'id_category';
	protected $table			= 'category';
	
	public function getFields()
	{
		parent::validation();
		if (isset($this->id))
			$fields['id_category'] = (int)($this->id);
		$fields['id_parent'] = (int)($this->id_parent);
		$fields['level_depth'] = (int)($this->level_depth);
		$fields['nleft'] = (int)($this->nleft);
		$fields['nright'] = (int)($this->nright);
		$fields['position'] = (int)($this->position);
		$fields['name'] = pSQL($this->name);
		$fields['description'] = pSQL($this->description);
		$fields['meta_title'] = pSQL($this->meta_title);
		$fields['meta_keywords'] = pSQL($this->meta_keywords);
		$fields['meta_description'] = pSQL($this->meta_description);
		$fields['rewrite'] = pSQL($this->rewrite);
		$fields['active'] = (int)($this->active);
		$fields['add_date'] = pSQL($this->add_date);
		$fields['upd_date'] = pSQL($this->upd_date);
		return $fields;
	}
	
	public	function add($nullValues = false)
	{
		$this->position = self::getLastPosition((int)$this->id_parent);
		if (!isset($this->level_depth) OR !$this->level_depth){
			$this->level_depth = $this->calcLevelDepth();
		}
		$ret = parent::add($nullValues);
		if (!isset($this->doNotRegenerateNTree) OR !$this->doNotRegenerateNTree)
			self::regenerateEntireNtree();
		return $ret;
	}	

	public	function update($nullValues = false)
	{
		$this->level_depth = $this->calcLevelDepth();
		$ret = parent::update();
		if (!isset($this->doNotRegenerateNTree) OR !$this->doNotRegenerateNTree)
		{
			self::regenerateEntireNtree();
			$this->recalculateLevelDepth($this->id);
		}
		return $ret;
	}

	public function delete()
	{
		if ($this->id == 1) return false;

		/* Get childs categories */
		$toDelete = array((int)($this->id));
		$this->recursiveDelete($toDelete, (int)($this->id));
		$toDelete = array_unique($toDelete);

		/* Delete CMS Category and its child from database */
		$list = sizeof($toDelete) > 1 ? implode(',', $toDelete) : (int)($this->id);
		Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'category` WHERE `id_category` IN ('.$list.')');
		
		/*取消排序可大大加快删除速度*/
		//self::cleanPositions($this->id_parent);
		
		/* Delete pages which are in categories to delete */
		$result = Db::getInstance()->ExecuteS('
		SELECT `id_rule`
		FROM `'._DB_PREFIX_.'rule`
		WHERE `id_entity` IN ('.$list.') AND entity="'.(get_class($this)).'"');
		foreach ($result as $p)
		{
			$rule = new Rule((int)($p['id_rule']));
			if (Validate::isLoadedObject($rule))
				$rule->delete();
		}
		
		/* Delete pages which are in categories to delete */
		$result = Db::getInstance()->ExecuteS('
		SELECT `id_product`
		FROM `'._DB_PREFIX_.'product`
		WHERE `id_category_default` IN ('.$list.')');
		$products = array();
		foreach ($result as $p)
		{
			$products[] = $p['id_product'];
		}
		
		/*采用批量删除产品方法*/
		Product::batchDeleteProduct($products);
		Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'product_to_category` WHERE `id_product` IN('.pSQL($list).')');
		return true;
	}
	
	
	public function getProducts($p=1,$limit=50,$orderBy = NULL,$orderWay = NULL,$filter=array())
	{
		$where = '';
		if(!empty($filter['id_color']) && is_array($filter['id_color']))
			$where .= ' AND a.`id_color` IN('.implode(',',array_map("intval",$filter['id_color'])).')';
			
		$cache_key = 'category-'.md5($this->id.':'.$p.':'.$limit.':'.$orderBy.':'.$orderWay.':'.$where);
		if(!$rows = Cache::getInstance()->get($cache_key)){
			if(!is_null($orderBy) AND !is_null($orderWay))
			{
				$postion = 'ORDER BY a.'.pSQL($orderBy).' '.pSQL($orderWay);
			}else{
				$postion = 'ORDER BY a.`id_product` DESC';
			}

			$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'._DB_PREFIX_.'product` a
					LEFT JOIN `'._DB_PREFIX_.'product_to_category` ptc ON a.id_product = ptc.id_product
					WHERE active=1 AND id_category='.(int)($this->id).' '.$where);
			if($total==0)
				return false;

			$result = Db::getInstance()->ExecuteS('SELECT a.* 
					FROM `'._DB_PREFIX_.'product` a
					LEFT JOIN `'._DB_PREFIX_.'product_to_category` ptc ON a.id_product = ptc.id_product
					WHERE active=1 AND id_category='.(int)($this->id).' '.$where.'
					'.$postion.'
					LIMIT '.(($p-1)*$limit).','.(int)$limit);
			$rows   = array(
					'total' => $total['total'],
					'entitys'  => Product::reLoad($result));
			Cache::getInstance()->set($cache_key,$rows);
		}/*else{
			foreach($rows as &$row)
			{
				$row['orders']= self::ordersWithProduct($row['id_product']);
				$row['rating']= self::feedbacStateWithProduct($row['id_product']);
			}
		}*/
		return $rows;
	}
	
	public static function getLastPosition($id_category_parent)
	{
		return (Db::getInstance()->getValue('SELECT MAX(position)+1 FROM `'._DB_PREFIX_.'category` WHERE `id_parent` = '.(int)($id_category_parent)));
	}
	
	/**
	  * Get the depth level for the category
	  *
	  * @return integer Depth level
	  */
	public function calcLevelDepth()
	{
		/* Root category */
		if (!$this->id_parent)
			return 0;

		$parentCategory = new Category((int)($this->id_parent));
		if (!Validate::isLoadedObject($parentCategory))
			die('parent category does not exist');
		return $parentCategory->level_depth + 1;
	}
	
	public function getCategories($active = true, $order = true, $sql_filter = '', $sql_sort = '',$sql_limit = '')
	{
	 	if (!Validate::isBool($active))
	 		die(Tools::displayError());

		$result = Db::getInstance()->ExecuteS('
		SELECT *
		FROM `'._DB_PREFIX_.'category` c
		WHERE `id_category` != 1 '.$sql_filter.'
		'.($active ? 'AND `active` = 1' : '').'
		'.($sql_sort != '' ? $sql_sort : 'ORDER BY c.`position` ASC').'
		'.($sql_limit != '' ? $sql_limit : '')
		);

		if (!$order)
			return $result;

		$categories = array();
		foreach ($result AS $row)
			$categories[$row['id_parent']][$row['id_category']]['infos'] = $row;

		return $categories;
	}
	
	/**
	  * Return current category childs
	  *
	  * @param integer $id_lang Language ID
	  * @param boolean $active return only active categories
	  * @return array Categories
	  */
	public function getSubCategories($active = true,$limit=20,$p=20,$orderBy = NULL,$orderWay = NULL,$filter=array())
	{
	 	if (!Validate::isBool($active))
	 		die(Tools::displayError());
		
		$where = '';
		if(!empty($filter['id_category']) && Validate::isInt($filter['id_category']))
			$where .= ' AND `id_category`='.intval($filter['id_category']);
		if(!empty($filter['name']) && Validate::isCatalogName($filter['name']))
			$where .= ' AND `name` LIKE "%'.pSQL($filter['name']).'%"';
		if(!empty($filter['rewrite']) && Validate::isCatalogName($filter['rewrite']))
			$where .= ' AND `rewrite` LIKE "%'.pSQL($filter['rewrite']).'%"';
		if(!empty($filter['active']) && Validate::isInt($filter['active']))
			$where .= ' AND `active`='.((int)($filter['active'])==1?'1':'0');
		
		if(!is_null($orderBy) AND !is_null($orderWay))
		{
			$postion = 'ORDER BY '.pSQL($orderBy).' '.pSQL($orderWay);
		}else{
			$postion = 'ORDER BY `position` ASC';
		}
		
		$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'._DB_PREFIX_.'category`
		WHERE 1 '.($active?' `active`=1 AND':'').'
		'.$where);

		$result = Db::getInstance()->ExecuteS('
		SELECT * FROM `'._DB_PREFIX_.'category`
		WHERE `id_parent` = '.(int)($this->id).' '.$where.'
		'.($active ? 'AND `active` = 1' : '').'
		'.$postion.'
		LIMIT '.(($p-1)*$limit).','.(int)$limit);

		$rows   = array(
				'total' => $total['total'],
				'entitys'  => $result);

		return $rows;
	}
	
	/**
	 * This method allow to return children categories with the number of sub children selected for a product
	 *
	 * @param int $id_parent
	 * @param int $id_product
	 * @param int $id_lang
	 * @return array
	 */
	public static function getChildrenWithNbSelectedSubCat($id_parent, $selectedCat)
	{

		$selectedCat = explode(',', str_replace(' ', '', $selectedCat));	
	
		return Db::getInstance()->ExecuteS('
		SELECT c.`id_category` AS id_category, c.`level_depth`,c.`name`, IF((
			SELECT COUNT(*)
			FROM `'._DB_PREFIX_.'category` c2
			WHERE c2.`id_parent` = c.`id_category`
		) > 0, 1, 0) AS has_children, '.($selectedCat ? '(
			SELECT count(c3.`id_category`)
			FROM `'._DB_PREFIX_.'category` c3
			WHERE c3.`nleft` > c.`nleft`
			AND c3.`nright` < c.`nright`
			AND c3.`id_category`  IN ('.implode(',', array_map('intval', $selectedCat)).')
		)' : '0').' AS nbSelectedSubCat
		FROM `'._DB_PREFIX_.'category` c
		WHERE c.`id_parent` = '.(int)($id_parent).'
		ORDER BY `position` ASC');
	}
	
	/**
	  * Recursively add specified CMSCategory childs to $toDelete array
	  *
	  * @param array &$toDelete Array reference where categories ID will be saved
	  * @param array $id_category Parent CMSCategory ID
	  */
	protected function recursiveDelete(&$toDelete, $id_category)
	{
	 	if (!is_array($toDelete) OR !$id_category)
	 		die(Tools::displayError());

		$result = Db::getInstance()->ExecuteS('
		SELECT `id_category`
		FROM `'._DB_PREFIX_.'category`
		WHERE `id_parent` = '.(int)($id_category));
		foreach ($result AS $row)
		{
			$toDelete[] = (int)($row['id_category']);
			$this->recursiveDelete($toDelete, (int)($row['id_category']));
		}
	}
	
	public static function cleanPositions($id_category_parent)
	{
		$result = Db::getInstance()->ExecuteS('
		SELECT `id_category`
		FROM `'._DB_PREFIX_.'category`
		WHERE `id_parent` = '.(int)($id_category_parent).'
		ORDER BY `position`');
		$sizeof = sizeof($result);
		for ($i = 0; $i < $sizeof; ++$i){
				$sql = '
				UPDATE `'._DB_PREFIX_.'category`
				SET `position` = '.(int)($i).'
				WHERE `id_parent` = '.(int)($id_category_parent).'
				AND `id_category` = '.(int)($result[$i]['id_category']);
				Db::getInstance()->Execute($sql);
			}
		return true;
	}
	
	public function updatePosition($way, $position)
	{	
		if (!$res = Db::getInstance()->ExecuteS('
			SELECT cp.`id_category`, cp.`position`, cp.`id_parent` 
			FROM `'._DB_PREFIX_.'category` cp
			WHERE cp.`id_parent` = '.(int)$this->id_parent.' 
			ORDER BY cp.`position` ASC'
		))
			return false;
		foreach ($res AS $category)
			if ((int)($category['id_category']) == (int)($this->id))
				$movedCategory = $category;
		
		if (!isset($movedCategory) || !isset($position))
			return false;
		// < and > statements rather than BETWEEN operator
		// since BETWEEN is treated differently according to databases
		return (Db::getInstance()->Execute('
			UPDATE `'._DB_PREFIX_.'category`
			SET `position`= `position` '.($way ? '- 1' : '+ 1').'
			WHERE `position` 
			'.($way 
				? '> '.(int)($movedCategory['position']).' AND `position` <= '.(int)($position)
				: '< '.(int)($movedCategory['position']).' AND `position` >= '.(int)($position)).'
			AND `id_parent`='.(int)($movedCategory['id_parent']))
		AND Db::getInstance()->Execute('
			UPDATE `'._DB_PREFIX_.'category`
			SET `position` = '.(int)($position).'
			WHERE `id_parent` = '.(int)($movedCategory['id_parent']).'
			AND `id_category`='.(int)($movedCategory['id_category'])));
	}
	
	public function getCatBar($id_parent,$catBar=array())
	{
		$category = Db::getInstance()->getRow('SELECT `id_category`,`id_parent`,`level_depth`,`name` FROM `'._DB_PREFIX_.'category` WHERE `id_category`='.intval($id_parent));
		if(sizeof($category)>1)
			$catBar[] = $category;
		if($id_parent>0){
			$catBar = $this->getCatBar($category['id_parent'],$catBar);
		}
		return $catBar;
	}
	
	/**
	  * Re-calculate the values of all branches of the nested tree
	  */
	public static function regenerateEntireNtree()
	{
		$categories = Db::getInstance()->ExecuteS('SELECT id_category, id_parent FROM '._DB_PREFIX_.'category ORDER BY id_parent ASC, position ASC');
		$categoriesArray = array();
		foreach ($categories AS $category)
			$categoriesArray[(int)$category['id_parent']]['subcategories'][(int)$category['id_category']] = 1;
		$n = 1;
		self::_subTree($categoriesArray, 1, $n);
	}

	protected static function _subTree(&$categories, $id_category, &$n)
	{
		$left = (int)$n++;
		if (isset($categories[(int)$id_category]['subcategories']))
			foreach (array_keys($categories[(int)$id_category]['subcategories']) AS $id_subcategory)
				self::_subTree($categories, (int)$id_subcategory, $n);
		$right = (int)$n++;

		Db::getInstance()->Execute('UPDATE '._DB_PREFIX_.'category SET nleft = '.(int)$left.', nright = '.(int)$right.' WHERE id_category = '.(int)$id_category.' LIMIT 1');
	}
	
		/**
	  * Updates level_depth for all children of the given id_category
	  *
	  * @param integer $id_category parent category
	  */
	public function recalculateLevelDepth($id_category)
	{
		/* Gets all children */
		$categories = Db::getInstance()->ExecuteS('
			SELECT id_category, id_parent, level_depth
			FROM '._DB_PREFIX_.'category
			WHERE id_parent = '.(int)$id_category);
		/* Gets level_depth */
		$level = Db::getInstance()->getRow('
			SELECT level_depth
			FROM '._DB_PREFIX_.'category
			WHERE id_category = '.(int)$id_category);
		/* Updates level_depth for all children */
		foreach ($categories as $sub_category)
		{
			Db::getInstance()->Execute('
				UPDATE '._DB_PREFIX_.'category
				SET level_depth = '.(int)($level['level_depth'] + 1).'
				WHERE id_category = '.(int)$sub_category['id_category']);
			/* Recursive call */
			$this->recalculateLevelDepth($sub_category['id_category']);
		}
	}
	
	/**
	 *
	 * @param Array $ids_category
	 * @param int $id_lang
	 * @return Array
	 */
	public static function getCategoryInformations($ids_category)
	{

		if (!is_array($ids_category) || !sizeof($ids_category))
			return;

		$categories = array();
		$results = Db::getInstance()->ExecuteS('
			SELECT c.`id_category`, c.`name`, c.`rewrite`
			FROM `'._DB_PREFIX_.'category` c
			WHERE c.`id_category` IN ('.implode(',', array_map('intval', $ids_category)).')
		');

		foreach($results as $category)
			$categories[$category['id_category']] = $category;

		return $categories;
	}
}
?>