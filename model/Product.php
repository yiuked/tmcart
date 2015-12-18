<?php 
class Product extends ObjectBase{

	protected $fields = array(
		'id_color' => array('type' => 'isInt'),
		'id_brand' => array('type' => 'isInt'),
		'id_category_default' => array('type' => 'isInt'),
		'id_image' => array('type' => 'isInt'),
		'price' => array('type' => 'isPrice', 'required' => true),
		'special_price' => array('type' => 'isPrice', 'required' => true),
		'ean13' => array('type' => 'isEan13'),
		'weight' => array('type' => 'isFloat'),
		'quantity' => array('type' => 'isInt'),
		'is_sale' => array('type' => 'isInt'),
		'is_new' => array('type' => 'isInt'),
		'is_top' => array('type' => 'isInt'),
		'in_stock' => array('type' => 'isInt'),
		'active' => array('type' => 'isInt'),
		'orders' => array('type' => 'isInt'),
		'name' => array('type' => 'isCatalogName', 'required' => true, 'size' => 256),
		'description_short' => array('type' => 'isCleanHtml'),
		'description' => array('type' => 'isCleanHtml'),
		'meta_title' => array('type' => 'isGenericName', 'size' => 256),
		'meta_keywords' => array('type' => 'isGenericName', 'size' => 256),
		'meta_description' => array('type' => 'isGenericName', 'size' => 256),
		'rewrite' => array('type' => 'isLinkRewrite', 'required' => true, 'size' => 256),
		'from_date' => array('type' => 'isDate'),
		'to_date' => array('type' => 'isDate'),
		'add_date' => array('type' => 'isDate'),
		'upd_date' => array('type' => 'isDate'),
	);
	
	protected $identifier 		= 'id_product';
	protected $table			= 'product';
	
	public function delete()
	{
		if(parent::delete()){
			Db::getInstance()->exec('DELETE FROM `'.DB_PREFIX.'product_to_category` WHERE `id_product`='.(int)$this->id);
			Db::getInstance()->exec('DELETE FROM `'.DB_PREFIX.'product_to_tag` WHERE `id_product`='.(int)$this->id);
			Db::getInstance()->exec('DELETE FROM `'.DB_PREFIX.'product_to_image` WHERE `id_product`='.(int)$this->id);
			Db::getInstance()->exec('DELETE FROM `'.DB_PREFIX.'product_to_attribute` WHERE `id_product`='.(int)$this->id);
			$this->deleteImages();
		}
		return true;
	}
	
	public static function batchDeleteProduct($id_products = array())
	{
		$ids_string = implode("," ,$id_products);
		Db::getInstance()->exec('DELETE FROM `'.DB_PREFIX.'product` WHERE `id_product` IN('.pSQL($ids_string).')');
		Db::getInstance()->exec('DELETE FROM `'.DB_PREFIX.'rule` WHERE `entity`="Product" AND `id_entity` IN('.pSQL($ids_string).')');
		Db::getInstance()->exec('DELETE FROM `'.DB_PREFIX.'product_to_category` WHERE `id_product` IN('.pSQL($ids_string).')');
		Db::getInstance()->exec('DELETE FROM `'.DB_PREFIX.'product_to_tag` WHERE `id_product` IN('.pSQL($ids_string).')');
		Db::getInstance()->exec('DELETE FROM `'.DB_PREFIX.'product_to_attribute` WHERE `id_product` IN('.pSQL($ids_string).')');
		$result = Db::getInstance()->getAll('SELECT `id_image` FROM `'.DB_PREFIX.'image` WHERE `id_product` IN('.pSQL($ids_string).')');
		if ($result)
			foreach ($result as $row)
			{
				Image::deleteAllImages(Image::getImgFolderStatic($row['id_image']));
			}
		Db::getInstance()->exec('DELETE FROM `'.DB_PREFIX.'image` WHERE `id_product` IN('.pSQL($ids_string).')');
		return true;
	}

	/**
	 * 获取产品图片position的最大值
	 *
	 * @param $id_product
	 * @return mixed
	 */
	public static function getImageLastPosition($id_product)
	{
		$result = Db::getInstance()->getRow('
		SELECT MAX(`position`) AS max
		FROM `' . DB_PREFIX . 'product_to_image`
		WHERE `id_product` = '.(int)$id_product);
		return (int) $result['max'] + 1;
	}

	/**
	 * 获取产品图片
	 */
	public function getImages()
	{
		$result = Db::getInstance()->getAll('
		SELECT *
		FROM `'.DB_PREFIX.'product_to_image`
		WHERE `id_product` = '.(int)($this->id) . ' ORDER BY position ASC');
		if ($result == false)
			return false;
		$imageType = ImageType::getImagesTypes(ImageType::IMAGE_PRDOCUT);
		foreach ($result as &$row) {
			foreach($imageType as $type) {
				$row[$type['name']] = Image::getImageLink($row['id_image'], $type['name']);
			}
		}
		return $result;
	}
	/**
	* 删除所有产品图片
	*
	* @return bool success
	*/
	public function deleteImages()
	{
		$result = Db::getInstance()->getAll('
		SELECT `id_image`
		FROM `'.DB_PREFIX.'product_to_image`
		WHERE `id_product` = '.(int)($this->id));

		$deleted = array();
		if ($result) {
			foreach ($result as $row)
			{
				$image = new Image($row['id_image']);
				if ($image->delete()) {
					$deleted[] = (int) $row['id_image'];
				}
			}
		}

		if (count($deleted) > 0) {
			return Db::getInstance()->exec('DELETE FROM ' . DB_PREFIX . 'product_to_image WHERE id_image IN(' . implode(',', $deleted) . ')');
		}
		return false;
	}
	
	public function getAlsoProduct($number=12)
	{
		$leftResult = Db::getInstance()->getAll('SELECT p.id_product,p.id_image_default,p.price,p.special_price,p.`name`,p.rewrite,b.name AS brand
		FROM '.DB_PREFIX.'product p
		LEFT JOIN `'.DB_PREFIX.'brand` b ON b.id_brand=p.id_brand
		WHERE p.id_product > '.$this->id.'
		AND p.active=1 AND p.id_category_default='.(int)($this->id_category_default).'
		ORDER BY p.id_product LIMIT '.intval($number/2));
		$leftNumber = count($leftResult);
		$rightNumber = $number - $leftNumber;
		$rightResult = Db::getInstance()->getAll('SELECT p.id_product,p.id_image_default,p.price,p.special_price,p.`name`,p.rewrite,b.name AS brand
		FROM '.DB_PREFIX.'product p
		LEFT JOIN `'.DB_PREFIX.'brand` b ON b.id_brand=p.id_brand
		WHERE p.id_product < '.$this->id.'
		AND p.active=1 AND p.id_category_default='.(int)($this->id_category_default).'
		ORDER BY p.id_product LIMIT '.intval($rightNumber));
		$result = array_merge($leftResult,$rightResult);
		if(!$result)
			return false;
		return self::reLoad($result);
	}
	
	public static function getSreachProduct($query,$p=1,$limit=50,$orderBy = NULL,$orderWay = NULL)
	{
		$cache_key = 'getsreachproduct-'.md5($query.':'.$p.':'.$limit.':'.$orderBy.':'.$orderWay);
		if(!$rows = Cache::getInstance()->get($cache_key)){
			if(!is_null($orderBy) AND !is_null($orderWay))
			{
				$postion = 'ORDER BY '.pSQL($orderBy).' '.pSQL($orderWay);
			}else{
				$postion = 'ORDER BY `id_product` DESC';
			}

			$total  = Db::getInstance()->getValue('SELECT count(*) FROM `'.DB_PREFIX.'product` WHERE active = 1
				AND (name LIKE "%'.pSQL($query).'%" OR meta_title LIKE "%'.pSQL($query).'%" OR `meta_keywords` LIKE "%'.pSQL($query).'%" OR `meta_description` LIKE "%'.pSQL($query).'%" OR `description` LIKE "%'.pSQL($query).'%")');
			if($total==0)
				return false;

			$result = Db::getInstance()->getAll('
				SELECT * FROM `'.DB_PREFIX.'product` WHERE active = 1
				AND (name LIKE "%'.pSQL($query).'%" OR meta_title LIKE "%'.pSQL($query).'%" OR `meta_keywords` LIKE "%'.pSQL($query).'%" OR `meta_description` LIKE "%'.pSQL($query).'%" OR `description` LIKE "%'.pSQL($query).'%")
				ORDER BY `add_date` DESC
				LIMIT '.(($p-1)*$limit).','.(int)($limit));

			$rows   = array(
					'total' => $total,
					'entitys'  => self::reLoad($result));
			Cache::getInstance()->set($cache_key,$rows);
		}
		return $rows;
	}
	
	public static function getNewProducts($p=1,$limit=50,$orderBy = NULL,$orderWay = NULL)
	{
		$cache_key = 'newproduct-'.md5($p.':'.$limit.':'.$orderBy.':'.$orderWay);
		if(!$rows = Cache::getInstance()->get($cache_key)){
			if(!is_null($orderBy) AND !is_null($orderWay))
			{
				$postion = 'ORDER BY '.pSQL($orderBy).' '.pSQL($orderWay);
			}else{
				$postion = 'ORDER BY `id_product` DESC';
			}
			
			$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'.DB_PREFIX.'product`
					WHERE active=1 AND is_new=1 ');
			if($total==0)
				return false;
	
			$result = Db::getInstance()->getAll('SELECT * FROM `'.DB_PREFIX.'product`
					WHERE active=1 AND is_new=1
					'.$postion.'
					LIMIT '.(($p-1)*$limit).','.(int)$limit);
			$rows   = array(
					'total' => $total['total'],
					'entitys'  => self::reLoad($result));
			Cache::getInstance()->set($cache_key,$rows);
		}
		return $rows;
	}
	
	public static function loadData($p=1, $limit=50, $orderBy = NULL, $orderWay = NULL, $filter=array())
	{
		$where = '';
		if(!empty($filter['id_product']) && Validate::isInt($filter['id_product']))
			$where .= ' AND a.`id_product`='.intval($filter['id_product']);
		if(!empty($filter['id_brand']) && Validate::isInt($filter['id_brand']))
			$where .= ' AND a.`id_brand`='.intval($filter['id_brand']);
		if(!empty($filter['name']) && Validate::isCatalogName($filter['name']))
			$where .= ' AND a.`name` LIKE "%'.pSQL($filter['name']).'%"';
		if(!empty($filter['rewrite']) && Validate::isCatalogName($filter['rewrite']))
			$where .= ' AND a.`rewrite` LIKE "%'.pSQL($filter['rewrite']).'%"';
		if(!empty($filter['active']) && Validate::isInt($filter['active']))
			$where .= ' AND a.`active`='.((int)($filter['active']) == 1 ? '1' : '0');
		if(!empty($filter['is_stock']) && Validate::isInt($filter['is_stock']))
			$where .= ' AND a.`is_stock`='.((int)($filter['is_stock'])==1?'1':'0');
		if(!empty($filter['id_category']) && Validate::isInt($filter['id_category']) && $filter['id_category']>1)
			$where .= ' AND (a.`id_product` IN (SELECT `id_product` FROM `'.DB_PREFIX.'product_to_category` WHERE `id_category`='.intval($filter['id_category']).') OR a.id_category_default ='.intval($filter['id_category']).')';
		
		if(!is_null($orderBy) AND !is_null($orderWay))
		{
			$postion = 'ORDER BY '.pSQL($orderBy).' '.pSQL($orderWay);
		}else{
			$postion = 'ORDER BY `id_product` DESC';
		}

		$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'.DB_PREFIX.'product` a
				LEFT JOIN `'.DB_PREFIX.'category` AS c ON a.id_category_default = c.id_category
				WHERE 1
				'.$where);
		if($total==0)
			return false;

		$result = Db::getInstance()->getAll('SELECT a.*,c.name AS c_name FROM `'.DB_PREFIX.'product` a
				LEFT JOIN `'.DB_PREFIX.'category` AS c ON a.id_category_default = c.id_category
				WHERE 1
				'.$where.'
				'.$postion.'
				LIMIT '.(($p-1)*$limit).','.(int)$limit);
		$rows   = array(
				'total' => $total['total'],
				'items'  => self::reLoad($result));
		return $rows;
	}
	
	public static function reLoad($result)
	{
		if(!is_array($result))
			return;
		foreach($result as &$row){
			$row['link'] = Tools::getLink($row['rewrite']);
			$row['name'] = stripslashes($row['name']);
			$row['tags'] = self::getProductTags($row['id_product']);
			$row['image_home'] = Image::getImageLink($row['id_image'],'home');
			$row['image_small'] = Image::getImageLink($row['id_image'],'small');
			$row['attributes'] = self::getAttributeAndGrop($row['id_product']);
			$row['rating']= self::feedbacStateWithProduct($row['id_product']);
			$row['price_save'] = 0;
			$row['price_save_off'] = 0;
			if($row['special_price']>0){
				$row['price_save'] = $row['special_price'] - $row['price'];
				$row['price_save_off'] = (int)(($row['special_price'] - $row['price'])/$row['special_price']*100);
			}
		}
		return $result;
	}
	
	public static function getAttributeAndGrop($id_product)
	{
		$attributes = array();
		$result = Db::getInstance()->getAll('SELECT t.id_attribute_product,t.id_product,t.id_attribute,a.`name`,g.id_attribute_group,g.`name` AS g_name
			FROM '.DB_PREFIX.'product_to_attribute AS t
			LEFT JOIN '.DB_PREFIX.'attribute AS a ON t.id_attribute = a.id_attribute
			LEFT JOIN '.DB_PREFIX.'attribute_group AS g ON a.id_attribute_group = g.id_attribute_group
			WHERE t.id_product = '.(int)($id_product).'
			ORDER BY a.position ASC');
		if(!$result)
			return $attributes;

		foreach($result as $row){
			$attributes[$row['id_attribute_group']]['id_attribute_group'] = $row['id_attribute_group'];
			$attributes[$row['id_attribute_group']]['name'] = $row['g_name'];
			$attributes[$row['id_attribute_group']]['attributes'][$row['id_attribute']]['id_attribute'] = $row['id_attribute'];
			$attributes[$row['id_attribute_group']]['attributes'][$row['id_attribute']]['id_attribute_product'] = $row['id_attribute_product'];
			$attributes[$row['id_attribute_group']]['attributes'][$row['id_attribute']]['name'] = $row['name'];
		}
		return 	$attributes;
	}
	
	public static function getProductTags($id_product)
	{
		$result = Db::getInstance()->getAll('
		SELECT pt.* FROM `'.DB_PREFIX.'product_tag` pt
		LEFT JOIN `'.DB_PREFIX.'product_to_tag` ptt ON (pt.`id_product_tag` = ptt.`id_product_tag`)
		WHERE ptt.`id_product` = '.(int)$id_product);
		
		if(!$result)
			return false;
		
		foreach($result as &$row)
			$row['link'] = Tools::getLink($row['rewrite']);
		return $result;
	}
	
	public static function getProductCategoriesFullId($id_product = ''){
		$ret = array();
		$row = Db::getInstance()->getAll('
		SELECT `id_category` FROM `'.DB_PREFIX.'product_to_category`
		WHERE `id_product` = '.(int)$id_product);
		
		foreach ($row as $val)
			$ret[] = $val['id_category'];
		return $ret;
	}
	
	public static function getProductCategoriesFull($id_product = '')
	{
		$ret = array();
		
		$row = Db::getInstance()->getAll('
		SELECT ptc.`id_category`, c.`name`, c.`rewrite` FROM `'.DB_PREFIX.'product_to_category` ptc
		LEFT JOIN `'.DB_PREFIX.'category` c ON (ptc.`id_category` = c.`id_category`)
		WHERE ptc.`id_product` = '.(int)$id_product);
		
		if(!$row)
			return false;
		foreach ($row as $val)
			$ret[$val['id_category']] = $val;
		return $ret;
	}


	public function getAttributes()
	{
		return Db::getInstance()->getAllValue('
		SELECT `id_attribute` FROM `'.DB_PREFIX.'product_to_attribute`
		WHERE `id_product` = '.(int)$this->id);
	}

	public function getFeatures()
	{
		return Db::getInstance()->getAllValue('
		SELECT `id_feature_value` FROM `'.DB_PREFIX.'product_to_feature`
		WHERE `id_product` = '.(int)$this->id);
	}
	
	/**
	 * getProductCategories return an array of categories which this product belongs to
	 *
	 * @return array of categories
	 */
	public function getCategories()
	{
		$ret = array();
		if ($row = Db::getInstance()->getAll('
		SELECT `id_category` FROM `'.DB_PREFIX.'product_to_category`
		WHERE `id_product` = '.(int)$this->id)
		)
			foreach ($row as $val)
				$ret[] = $val['id_category'];
		return $ret;
	}
	
	public function addToAttribute($attributes = array())
	{
		if (empty($attributes))
			return false;

		if (!is_array($attributes))
			$attributes=array($attributes);

		if (!sizeof($attributes))
			return false;

		$currentAttributes = $this->getAttributes();
		$Cats = array();
		foreach ($attributes as $newIdAtt)
			if (!in_array($newIdAtt,$currentAttributes))
				$Cats[] = '('. $this->id.', '. $newIdAtt.')';

		if (sizeof($Cats))
			return Db::getInstance()->exec('
			INSERT INTO `'.DB_PREFIX.'product_to_attribute` (`id_product`, `id_attribute`)
			VALUES '.implode(',', $Cats));

		return true;
	}
	
	public function addToCategories($categories = array())
	{
		if (empty($categories))
			return false;

		if (!is_array($categories))
			$categories=array($categories);

		if (!sizeof($categories))
			return false;

		$currentCategories = $this->getCategories();
		$Cats = array();
		foreach ($categories as $newIdCateg)
			if (!in_array($newIdCateg,$currentCategories))
				$Cats[] = '('. $this->id.', '. $newIdCateg.')';

		if (sizeof($Cats))
			return Db::getInstance()->exec('
			INSERT INTO `'.DB_PREFIX.'product_to_category` (`id_product`, `id_category`)
			VALUES '.implode(',', $Cats));

		return true;
	}
	
	public function deleteAttribute($id_attribute)
	{
		$return = Db::getInstance()->exec('DELETE FROM `'.DB_PREFIX.'product_to_attribute` WHERE `id_product` = '.(int)($this->id).' AND `id_attribute` = '.(int)$id_attribute .'' );
		return $return;
	}
	
	public function deleteCategory($id_category)
	{
		$return = Db::getInstance()->exec('DELETE FROM `'.DB_PREFIX.'product_to_category` WHERE `id_product` = '.(int)($this->id).' AND id_category = '.(int)$id_category .'' );
		return $return;
	}
	
	public function deleteTag($id_tag)
	{
		$return = Db::getInstance()->exec('DELETE FROM `'.DB_PREFIX.'product_to_tag` WHERE `id_product` = '.(int)($this->id).' AND id_tag = '.(int)$id_tag .'' );
		return $return;
	}
	
	public function updateAttribute($attributes)
	{
		if (!is_array($attributes) && intval($attributes) == 0) {
			return true;
		}

		if(!is_array($attributes))
			$attributes = explode(',',$attributes);
		$attributes = array_unique($attributes);
		// get max position in each categories
		$result = Db::getInstance()->getAllValue('SELECT `id_attribute`
				FROM `'.DB_PREFIX.'product_to_attribute`
				WHERE `id_attribute` NOT IN('.implode(',', array_map('intval', $attributes)).')
				AND `id_product` = '. $this->id );

		if (is_array($result)) {
			$need_add = array_diff($attributes, $result);
			$need_del = array_diff($result, $attributes);
		} else {
			$need_add = $attributes;
			$need_del = array();
		}

		$ret = true;
		if (count($need_add) > 0) {
			$addSQLs = array();
			foreach ($need_add as $id_attribute) {
				$addSQLs[] = '(' .(int) $this->id . ',' . (int) $id_attribute . ')';
			}
			$ret &= Db::getInstance()->exec('
			INSERT INTO `'.DB_PREFIX.'product_to_attribute` (`id_product`, `id_attribute`)
			VALUES '.implode(',', $addSQLs));
		}

		if (count($need_del) > 0) {
			$ret &= Db::getInstance()->exec('DELETE FROM `'.DB_PREFIX.'product_to_attribute` WHERE id_attribute IN('.implode(',', array_map('intval', $need_del)).')');
		}

		return $ret;
	}

	public function updateFeature($feature)
	{
		if (!is_array($feature) && intval($feature) == 0) {
			return true;
		}

		if(!is_array($feature))
			$feature = explode(',',$feature);
		$feature = array_unique($feature);
		// get max position in each categories
		$result = Db::getInstance()->getAllValue('SELECT `id_feature_value`
				FROM `'.DB_PREFIX.'product_to_feature`
				WHERE `id_product` = '. $this->id );

		if (is_array($result)) {
			$need_add = array_diff($feature, $result);
			$need_del = array_diff($result, $feature);
		} else {
			$need_add = $feature;
			$need_del = array();
		}


		$ret = true;
		if (count($need_add) > 0) {
			$addSQLs = array();
			foreach ($need_add as $id_featrue_value) {
				$addSQLs[] = '(' . (int) $id_featrue_value . ',' .(int) $this->id. ')';
			}
			$ret &= Db::getInstance()->exec('
			INSERT INTO `'.DB_PREFIX.'product_to_feature` (`id_feature_value`, `id_product`)
			VALUES '.implode(',', $addSQLs));
		}

		if (count($need_del) > 0) {
			$ret &= Db::getInstance()->exec('DELETE FROM `'.DB_PREFIX.'product_to_feature` WHERE id_feature_value IN('.implode(',', array_map('intval', $need_del)).')');
		}

		return $ret;
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
		if(!is_array($categories))
			$categories = array($categories);

		// get max position in each categories
		$result = Db::getInstance()->getAll('SELECT `id_category`
				FROM `'.DB_PREFIX.'product_to_category`
				WHERE `id_category` NOT IN('.implode(',', array_map('intval', $categories)).')
				AND `id_product` = '. $this->id );
		if(is_array($result))
			foreach ($result as $categToDelete)
				$this->deleteCategory($categToDelete['id_category']);

		if (!$this->addToCategories($categories))
			return false;

		return true;
	}

	/**
	 * 获取产品的tag id
	 * @return array
	 */
	public function getTags()
	{
		$ret = array();
		if ($row = Db::getInstance()->getAll('
		SELECT `id_tag` FROM `'.DB_PREFIX.'product_to_tag`
		WHERE `id_product` = '.(int)$this->id)
		)
			foreach ($row as $val)
				$ret[] = $val['id_tag'];
		return $ret;
	}

	/**
	 * 添加tags
	 * @param $tags
	 * @return bool
	 */
	public function addToTags($tags)
	{
		if (empty($tags))
			return false;

		$tags = explode(',', $tags);

		$currenTags = $this->getTags();
		$newTags = array();

		foreach($tags as $t){
			$id_tag = Tag::tagsExists($t);
			if ($id_tag){
				$newTags[] = $id_tag;
			}
		}

		$needDelete = array_diff($currenTags, $newTags);
		$needAdd = array_diff($newTags, $currenTags);

		$ret = true;
		if (count($needDelete)) {
			$ret &= Db::getInstance()->exec('
				DELETE FROM `'.DB_PREFIX.'product_to_tag`
				WHERE id_tag IN (' .implode(',', $needDelete) . ') AND id_product ='.(int) $this->id);
		}

		if (count($needAdd)){
			$insert = array();
			foreach ($needAdd as $id_temp) {
				$insert[] = '(' . $this->id . ',' . $id_temp . ')';
			}
			$ret &=  Db::getInstance()->exec('
				INSERT INTO `'.DB_PREFIX.'product_to_tag` (`id_product`, `id_tag`)
				VALUES '.implode(',', $insert));
		}

		return $ret;
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
	
	static public function updateOrders($id)
	{
		return Db::getInstance()->exec('
		UPDATE `'.DB_PREFIX.'product`
		SET `orders`=`orders`+1
		WHERE `id_product` = '.(int)($id));
	}
	
	static public function feedbacStateWithProduct($id_product)
	{
		$state  = Db::getInstance()->getRow('SELECT * FROM `'.DB_PREFIX.'feedback_state` WHERE id_product='.intval($id_product));
		if($state){
			$state['average'] 	= round($state['total_rating']/$state['times'],2);
			$state['total_pt'] 	= round($state['average']/5,4)*100;
		}
		return $state;
	}
	
	//获取产品定单数
	static public function ordersWithProduct($id_product)
	{
		$state = Db::getInstance()->getValue('SELECT orders FROM `'.DB_PREFIX.'product` WHERE id_product='.intval($id_product));
		return $state;
	}
}
?>