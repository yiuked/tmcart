<?php 
class Product extends ObjectBase{
	protected $fields 			= array(
		'id_category_default','id_image_default','id_color','id_brand',
		'price','special_price',
		'ean13','weight','quantity',
		'name','meta_title','meta_keywords','meta_description','rewrite','description','description_short',
		'active','is_sale','is_new','in_stock','is_top','orders',
		'from_date','to_date','add_date','upd_date');
	protected $fieldsRequired	= array('id_category_default','price','name','rewrite');
	protected $fieldsSize 		= array('meta_description' => 256, 'meta_keywords' => 256,
		'meta_title' => 256, 'rewrite' => 256, 'name' => 256);
	protected $fieldsValidate	= array(
		'id_brand'=>'isInt',
		'price' => 'isPrice',
		'special_price' => 'isPrice',
		'ean13' => 'isEan13',
		'weight' => 'isUnsignedFloat',
		'quantity' => 'isUnsignedId',
		'is_sale' => 'isBool',
		'is_new' => 'isBool',
		'in_stock' => 'isBool',
		'active' => 'isBool',
		'name' => 'isCatalogName',
		'meta_title' => 'isGenericName',
		'meta_keywords' => 'isGenericName',
		'meta_description' => 'isGenericName',
		'rewrite' => 'isLinkRewrite');
	
	protected $identifier 		= 'id_product';
	protected $table			= 'product';
	
	public function getFields()
	{
		parent::validation();
		if (isset($this->id))
			$fields['id_product'] = (int)($this->id);
		$fields['id_color'] = (int)($this->id_color);
		$fields['id_brand'] = (int)($this->id_brand);
		$fields['id_category_default'] = (int)($this->id_category_default);
		$fields['id_image_default'] = (int)($this->id_image_default);
		$fields['price'] = (float)($this->price);
		$fields['special_price'] = (float)($this->special_price);
		$fields['ean13'] = pSQL($this->ean13);
		$fields['weight'] = (float)($this->weight);
		$fields['quantity'] = (int)($this->quantity);
		$fields['name'] = pSQL($this->name);
		$fields['description_short'] = pSQL($this->description_short,true);
		$fields['description'] = pSQL($this->description,true);
		$fields['meta_title'] = pSQL($this->meta_title);
		$fields['meta_keywords'] = pSQL($this->meta_keywords);
		$fields['meta_description'] = pSQL($this->meta_description);
		$fields['rewrite'] = pSQL($this->rewrite);
		$fields['active'] = (int)($this->active);
		$fields['is_sale'] = (int)($this->is_sale);
		$fields['is_new'] = (int)($this->is_new);
		$fields['is_top'] = (int)($this->is_top);
		$fields['orders'] = (int)($this->orders);
		$fields['in_stock'] = (int)($this->in_stock);
		$fields['from_date'] = pSQL($this->from_date);
		$fields['to_date'] = pSQL($this->to_date);
		$fields['add_date'] = pSQL($this->add_date);
		$fields['upd_date'] = pSQL($this->upd_date);
		return $fields;
	}
	
	public function delete()
	{
		if(parent::delete()){
			Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'product_to_category` WHERE `id_product`='.(int)$this->id);
			Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'product_to_tag` WHERE `id_product`='.(int)$this->id);
			Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'product_to_attribute` WHERE `id_product`='.(int)$this->id);
			$this->deleteImages();
		}
		return true;
	}
	
	public static function batchDeleteProduct($id_products = array())
	{
		$ids_string = implode(",",$id_products);
		Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'product` WHERE `id_product` IN('.pSQL($ids_string).')');
		Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'rule` WHERE `entity`="Product" AND `id_entity` IN('.pSQL($ids_string).')');
		Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'product_to_category` WHERE `id_product` IN('.pSQL($ids_string).')');
		Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'product_to_tag` WHERE `id_product` IN('.pSQL($ids_string).')');
		Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'product_to_attribute` WHERE `id_product` IN('.pSQL($ids_string).')');
		$result = Db::getInstance()->ExecuteS('SELECT `id_image` FROM `'._DB_PREFIX_.'image` WHERE `id_product` IN('.pSQL($ids_string).')');
		if ($result)
			foreach ($result as $row)
			{
				Image::deleteAllImages(Image::getImgFolderStatic($row['id_image']));
			}
		Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'image` WHERE `id_product` IN('.pSQL($ids_string).')');
		return true;
	}

	/**
	* Delete product images from database
	*
	* @return bool success
	*/
	public function deleteImages()
	{
		$result = Db::getInstance()->ExecuteS('
		SELECT `id_image`
		FROM `'._DB_PREFIX_.'image`
		WHERE `id_product` = '.(int)($this->id));

		$status = true;
		if ($result)
			foreach ($result as $row)
			{
				$image = new Image($row['id_image']);
				$status &= $image->delete();
			}
		return $status;
	}

	public function copyFromPost()
	{
		parent::copyFromPost();
		if(empty($this->from_date))
			$this->from_date = '000-00-00 00:00:00';
		if(empty($this->to_date))
			$this->to_date   = '000-00-00 00:00:00';
	}
	
	public function getAlsoProduct($number=12)
	{
		$leftResult = Db::getInstance()->ExecuteS('SELECT p.id_product,p.id_image_default,p.price,p.special_price,p.`name`,p.rewrite,b.name AS brand 
		FROM '._DB_PREFIX_.'product p
		LEFT JOIN `'._DB_PREFIX_.'brand` b ON b.id_brand=p.id_brand
		WHERE p.id_product > '.$this->id.'
		AND p.active=1 AND p.id_category_default='.(int)($this->id_category_default).'
		ORDER BY p.id_product LIMIT '.intval($number/2));
		$leftNumber = count($leftResult);
		$rightNumber = $number - $leftNumber;
		$rightResult = Db::getInstance()->ExecuteS('SELECT p.id_product,p.id_image_default,p.price,p.special_price,p.`name`,p.rewrite,b.name AS brand 
		FROM '._DB_PREFIX_.'product p
		LEFT JOIN `'._DB_PREFIX_.'brand` b ON b.id_brand=p.id_brand
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

			$total  = Db::getInstance()->getValue('SELECT count(*) FROM `'._DB_PREFIX_.'product` WHERE active = 1
				AND (name LIKE "%'.pSQL($query).'%" OR meta_title LIKE "%'.pSQL($query).'%" OR `meta_keywords` LIKE "%'.pSQL($query).'%" OR `meta_description` LIKE "%'.pSQL($query).'%" OR `description` LIKE "%'.pSQL($query).'%")');
			if($total==0)
				return false;

			$result = Db::getInstance()->ExecuteS('
				SELECT * FROM `'._DB_PREFIX_.'product` WHERE active = 1
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
			
			$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'._DB_PREFIX_.'product`
					WHERE active=1 AND is_new=1 ');
			if($total==0)
				return false;
	
			$result = Db::getInstance()->ExecuteS('SELECT * FROM `'._DB_PREFIX_.'product`
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
	
	public static function getProducts($active = true,$p=1,$limit=50,$orderBy = NULL,$orderWay = NULL,$filter=array())
	{
	 	if (!Validate::isBool($active))
	 		die(Tools::displayError());

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
			$where .= ' AND a.`active`='.((int)($filter['active'])==1?'1':'0');
		if(!empty($filter['is_stock']) && Validate::isInt($filter['is_stock']))
			$where .= ' AND a.`is_stock`='.((int)($filter['is_stock'])==1?'1':'0');
		if(!empty($filter['id_category']) && Validate::isInt($filter['id_category']) && $filter['id_category']>1)
			$where .= ' AND (a.`id_product` IN (SELECT `id_product` FROM `'._DB_PREFIX_.'product_to_category` WHERE `id_category`='.intval($filter['id_category']).') OR a.id_category_default ='.intval($filter['id_category']).')';
		
		if(!is_null($orderBy) AND !is_null($orderWay))
		{
			$postion = 'ORDER BY '.pSQL($orderBy).' '.pSQL($orderWay);
		}else{
			$postion = 'ORDER BY `id_product` DESC';
		}

		$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'._DB_PREFIX_.'product` a
				LEFT JOIN `'._DB_PREFIX_.'category` AS c ON a.id_category_default = c.id_category
				WHERE 1 '.($active?' AND a.`active`=1 ':'').'
				'.$where);
		if($total==0)
			return false;

		$result = Db::getInstance()->ExecuteS('SELECT a.*,c.name AS c_name FROM `'._DB_PREFIX_.'product` a
				LEFT JOIN `'._DB_PREFIX_.'category` AS c ON a.id_category_default = c.id_category
				WHERE 1 '.($active?' AND a.`active`=1 ':'').'
				'.$where.'
				'.$postion.'
				LIMIT '.(($p-1)*$limit).','.(int)$limit);
		$rows   = array(
				'total' => $total['total'],
				'entitys'  => self::reLoad($result));
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
			$row['image_home'] = Image::getImageLink($row['id_image_default'],'home');
			$row['image_small'] = Image::getImageLink($row['id_image_default'],'small');
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
		$result = Db::getInstance()->ExecuteS('SELECT t.id_attribute_product,t.id_product,t.id_attribute,a.`name`,g.id_attribute_group,g.`name` AS g_name 
			FROM '._DB_PREFIX_.'product_to_attribute AS t
			LEFT JOIN '._DB_PREFIX_.'attribute AS a ON t.id_attribute = a.id_attribute
			LEFT JOIN '._DB_PREFIX_.'attribute_group AS g ON a.id_attribute_group = g.id_attribute_group
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
		$result = Db::getInstance()->ExecuteS('
		SELECT pt.* FROM `'._DB_PREFIX_.'product_tag` pt
		LEFT JOIN `'._DB_PREFIX_.'product_to_tag` ptt ON (pt.`id_product_tag` = ptt.`id_product_tag`)
		WHERE ptt.`id_product` = '.(int)$id_product);
		
		if(!$result)
			return false;
		
		foreach($result as &$row)
			$row['link'] = Tools::getLink($row['rewrite']);
		return $result;
	}
	
	public static function getProductCategoriesFullId($id_product = ''){
		$ret = array();
		$row = Db::getInstance()->ExecuteS('
		SELECT `id_category` FROM `'._DB_PREFIX_.'product_to_category`
		WHERE `id_product` = '.(int)$id_product);
		
		foreach ($row as $val)
			$ret[] = $val['id_category'];
		return $ret;
	}
	
	public static function getProductCategoriesFull($id_product = '')
	{
		$ret = array();
		
		$row = Db::getInstance()->ExecuteS('
		SELECT ptc.`id_category`, c.`name`, c.`rewrite` FROM `'._DB_PREFIX_.'product_to_category` ptc
		LEFT JOIN `'._DB_PREFIX_.'category` c ON (ptc.`id_category` = c.`id_category`)
		WHERE ptc.`id_product` = '.(int)$id_product);
		
		if(!$row)
			return false;
		foreach ($row as $val)
			$ret[$val['id_category']] = $val;
		return $ret;
	}


	public function getAttributes()
	{
		$ret = array();
		if ($row = Db::getInstance()->ExecuteS('
		SELECT `id_attribute` FROM `'._DB_PREFIX_.'product_to_attribute`
		WHERE `id_product` = '.(int)$this->id)
		)
			foreach ($row as $val)
				$ret[] = $val['id_attribute'];
		return $ret;
	}
	
	/**
	 * getProductCategories return an array of categories which this product belongs to
	 *
	 * @return array of categories
	 */
	public function getCategories()
	{
		$ret = array();
		if ($row = Db::getInstance()->ExecuteS('
		SELECT `id_category` FROM `'._DB_PREFIX_.'product_to_category`
		WHERE `id_product` = '.(int)$this->id)
		)
			foreach ($row as $val)
				$ret[] = $val['id_category'];
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
		if ($row = Db::getInstance()->ExecuteS('
		SELECT `id_tag` FROM `'._DB_PREFIX_.'product_to_tag`
		WHERE `id_product` = '.(int)$this->id)
		)
			foreach ($row as $val)
				$ret[] = $val['id_tag'];
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
			return Db::getInstance()->Execute('
			INSERT INTO `'._DB_PREFIX_.'product_to_attribute` (`id_product`, `id_attribute`)
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
			return Db::getInstance()->Execute('
			INSERT INTO `'._DB_PREFIX_.'product_to_category` (`id_product`, `id_category`)
			VALUES '.implode(',', $Cats));

		return true;
	}
	
	public function addToTags($tags)
	{		
			if (empty($tags))
			return false;
			
			$currenTags = $this->getTags();
			$tagCats = array();

			foreach($tags as $t){
				$id_tag = Tag::tagsExists($t);
				if (!in_array($t,$currenTags) && $id_tag)
					$tagCats[] = '('. $this->id.', '. $id_tag.')';
			}
			
			if (sizeof($tagCats))
				return Db::getInstance()->Execute('
				INSERT INTO `'._DB_PREFIX_.'product_to_tag` (`id_product`, `id_tag`)
				VALUES '.implode(',', $tagCats));
			
			return true;
	}
	
	public function deleteAttribute($id_attribute)
	{
		$return = Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'product_to_attribute` WHERE `id_product` = '.(int)($this->id).' AND `id_attribute` = '.(int)$id_attribute .'' );
		return $return;
	}
	
	public function deleteCategory($id_category)
	{
		$return = Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'product_to_category` WHERE `id_product` = '.(int)($this->id).' AND id_category = '.(int)$id_category .'' );
		return $return;
	}
	
	public function deleteTag($id_tag)
	{
		$return = Db::getInstance()->Execute('DELETE FROM `'._DB_PREFIX_.'product_to_tag` WHERE `id_product` = '.(int)($this->id).' AND id_tag = '.(int)$id_tag .'' );
		return $return;
	}
	
	public function updateAttribute($attributes)
	{	
		if(!is_array($attributes))
			$attributes = explode(',',$attributes);
		$attributes = array_unique($attributes);
		// get max position in each categories
		$result = Db::getInstance()->ExecuteS('SELECT `id_attribute`
				FROM `'._DB_PREFIX_.'product_to_attribute`
				WHERE `id_attribute` NOT IN('.implode(',', array_map('intval', $attributes)).')
				AND `id_product` = '. $this->id );
		if(is_array($result))
			foreach ($result as $attributeToDelete)
				$this->deleteAttribute($attributeToDelete['id_attribute']);

		if (!$this->addToAttribute($attributes))
			return false;

		return true;
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
		$result = Db::getInstance()->ExecuteS('SELECT `id_category`
				FROM `'._DB_PREFIX_.'product_to_category`
				WHERE `id_category` NOT IN('.implode(',', array_map('intval', $categories)).')
				AND `id_product` = '. $this->id );
		if(is_array($result))
			foreach ($result as $categToDelete)
				$this->deleteCategory($categToDelete['id_category']);

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
		$result = Db::getInstance()->ExecuteS('SELECT `id_tag`
				FROM `'._DB_PREFIX_.'product_to_tag`
				WHERE `id_tag` NOT IN('.implode(',', array_map('intval', $tags)).')
				AND `id_product` = '. $this->id .'');
		if(is_array($result))
			foreach ($result as $tagToDelete)
				$this->deleteTag($tagToDelete['id_tag']);

		if (!$this->addToTags($tags))
			return false;

		return true;
	}
	
	public function getComments($id_keep=0)
	{
		$result = Db::getInstance()->ExecuteS('SELECT *
		FROM `'._DB_PREFIX_.'cms_comment`
		WHERE `id_keep`='.(int)($id_keep).' AND active=1
		AND id_cms = '.(int) $this->id .'');
		if($result)
			foreach($result as &$row)
				$row['children'] = $this->getComments($row['id_cms_comment']);
		return $result;
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
		SET `'.pSQL($key).'` = '.$this->{$key}.',`upd_date`="'.date('Y-m-d H:i:s').'"
		WHERE `'.pSQL($this->identifier).'` = '.(int)($this->id));
	}
	
	static public function updateOrders($id)
	{
		return Db::getInstance()->Execute('
		UPDATE `'._DB_PREFIX_.'product`
		SET `orders`=`orders`+1
		WHERE `id_product` = '.(int)($id));
	}
	
	static public function feedbacStateWithProduct($id_product)
	{
		$state  = Db::getInstance()->getRow('SELECT * FROM `'._DB_PREFIX_.'feedback_state` WHERE id_product='.intval($id_product));
		if($state){
			$state['average'] 	= round($state['total_rating']/$state['times'],2);
			$state['total_pt'] 	= round($state['average']/5,4)*100;
		}
		return $state;
	}
	
	//获取产品定单数
	static public function ordersWithProduct($id_product)
	{
		$state = Db::getInstance()->getValue('SELECT orders FROM `'._DB_PREFIX_.'product` WHERE id_product='.intval($id_product));
		return $state;
	}
}
?>