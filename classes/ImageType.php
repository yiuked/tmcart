<?php

class ImageType extends ObjectBase
{
	protected $fields 			= array('name','width','height','type');
	protected $fieldsRequired	= array('name','width','height','type');
	
	protected $identifier 		= 'id_image_type';
	protected $table			= 'image_type';

	public function getFields()
	{
		parent::validation();
		if (isset($this->id))
			$fields['id_image_type'] = (int)($this->id);
		$fields['name'] 		= pSQL($this->name);
		$fields['width'] 		= pSQL($this->width);
		$fields['height'] 		= pSQL($this->height);
		$fields['type'] 		= pSQL($this->type);
		return $fields;
	}

	/**
	 * @var array Image types cache
	 */
	protected static $images_types_cache = array();

	/**
	* Returns image type definitions
	*
	* @param string|null Image type
	* @return array Image type definitions
	*/
	public static function getImagesTypes($type = null)
	{
		$where = 'WHERE 1';
		if(!empty($type))
			$where .= ' AND `type`="'.pSQL($type).'"';

		$query = 'SELECT * FROM `'._DB_PREFIX_.'image_type` '.$where.' ORDER BY `name` ASC';
		return Db::getInstance()->executeS($query);
	}

	public function reloadImages()
	{
		$dir = _TM_PRO_IMG_DIR;
		$productsImages = Image::getAllImages();
		
		foreach ($productsImages AS $k => $image)
		{
			$imageObj = new Image($image['id_image']);
			//echo $dir.$imageObj->getExistingImgPath().'.jpg';
			if(file_exists($dir.$imageObj->getExistingImgPath().'.jpg')){
				if(!ImageCore::imageResize($dir.$imageObj->getExistingImgPath().'.jpg', $dir.$imageObj->getExistingImgPath().'-'.stripslashes($this->name).'.jpg', (int)($this->width), (int)($this->height)))
						$errors = true;
			}
		}
	}

	/**
	* Check if type already is already registered in database
	*
	* @param string $typeName Name
	* @return integer Number of results found
	*/
	public static function typeAlreadyExists($typeName)
	{
		if (!Validate::isImageTypeName($typeName))
			die(Tools::displayError());

		Db::getInstance()->executeS('
		SELECT `id_image_type`
		FROM `'._DB_PREFIX_.'image_type`
		WHERE `name` = \''.pSQL($typeName).'\'');

		return Db::getInstance()->NumRows();
	}

	/**
	 * Finds image type definition by name and type
	 * @param string $name
	 * @param string $type
	 */
	public static function getByNameNType($name, $type)
	{
		return Db::getInstance()->getRow('SELECT `id_image_type`, `name`, `width`, `height`, `products`, `categories`, `manufacturers`, `suppliers`, `scenes` FROM `'._DB_PREFIX_.'image_type` WHERE `name` = \''.pSQL($name).'\' AND `'.pSQL($type).'` = 1');
	}
	
	public static function getEntity($active = true,$p=1,$limit=50,$orderBy = NULL,$orderWay = NULL,$filter=array())
	{
	 	if (!Validate::isBool($active))
	 		die(Tools::displayError());

		$where = '';
		if(!empty($filter['id_image_type']) && Validate::isInt($filter['id_image_type']))
			$where .= ' AND a.`id_image_type`='.intval($filter['id_image_type']);
		if(!empty($filter['name']) && Validate::isCatalogName($filter['name']))
			$where .= ' AND a.`name` LIKE "%'.pSQL($filter['name']).'%"';
		
		if(!is_null($orderBy) AND !is_null($orderWay))
		{
			$postion = 'ORDER BY '.pSQL($orderBy).' '.pSQL($orderWay);
		}else{
			$postion = 'ORDER BY `position` DESC';
		}

		$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'._DB_PREFIX_.'image_type` a
				WHERE 1 '.$where);
		if($total==0)
			return false;

		$result = Db::getInstance()->ExecuteS('SELECT a.* FROM `'._DB_PREFIX_.'image_type` a
				WHERE 1 '.$where.'
				'.$postion.'
				LIMIT '.(($p-1)*$limit).','.(int)$limit);
		$rows   = array(
				'total' => $total['total'],
				'entitys'  => $result);
		return $rows;
	}

}
