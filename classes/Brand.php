<?php 
class Brand extends ObjectBase{
	protected $fields 			= array('logo',
		'name','description',
		'meta_title','meta_keywords','meta_description','rewrite'
		);
	protected $fieldsRequired	= array('name','rewrite');
	protected $fieldsSize 		= array('meta_description' => 256, 'meta_keywords' => 256,
		'meta_title' => 256, 'link_rewrite' => 256, 'name' => 256);
	protected $fieldsValidate	= array(
		'name' => 'isCatalogName',
		'meta_title' => 'isGenericName',
		'meta_keywords' => 'isGenericName',
		'meta_description' => 'isGenericName', 
		'rewrite' => 'isLinkRewrite', 
		'description' => 'isCleanHtml');
	
	protected $identifier 		= 'id_brand';
	protected $table			= 'brand';
	public 	  $img_dir;
	
	public function __construct($id = NULL)
	{
		parent::__construct($id);
		$this->img_dir = _TM_IMG_DIR.'brand/';
	}
	
	public function getFields()
	{
		parent::validation();
		if (isset($this->id))
			$fields['id_brand'] = (int)($this->id);
		$fields['logo'] = pSQL($this->logo);
		$fields['name'] = pSQL($this->name);
		$fields['description'] = pSQL($this->description);
		$fields['meta_title'] = pSQL($this->meta_title);
		$fields['meta_keywords'] = pSQL($this->meta_keywords);
		$fields['meta_description'] = pSQL($this->meta_description);
		$fields['rewrite'] = pSQL($this->rewrite);
		return $fields;
	}
	
	public function updateLogo()
	{
		$allowedExtensions 	= array('jpg','png','gif');
		$filename 			= $this->id.'-'.$_FILES['logo']['name'];
		$pathinfo 			= pathinfo($filename);
		$ext 				= $pathinfo['extension'];
		$tmpName			= $this->img_dir.$filename;
		if(in_array(strtolower($ext),$allowedExtensions))
			!move_uploaded_file($_FILES['logo']['tmp_name'], $tmpName);
		Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.$this->table.'` SET `logo`="'.pSQL($filename).'" WHERE `'.$this->identifier.'`='.(int)($this->id));
	}
	
	public function getProducts($p=1,$limit=50,$orderBy = NULL,$orderWay = NULL,$filter=array())
	{
		$cid = isset($filter['id_style'])?intval($filter['id_style']):0;
		$where = '';
		if(!empty($filter['id_color']) && is_array($filter['id_color']))
			$where .= ' AND a.`id_color` IN('.implode(',',array_map("intval",$filter['id_color'])).')';
		if($cid>0)
			$where .= ' AND ptc.`id_category`='.intval($cid);
		
			
		$cache_key = 'brand-'.md5($cid.':'.$p.':'.$limit.':'.$orderBy.':'.$orderWay.':'.$where);
		if(!$rows = Cache::getInstance()->get($cache_key)){
			if(!is_null($orderBy) AND !is_null($orderWay))
			{
				$postion = 'ORDER BY a.'.pSQL($orderBy).' '.pSQL($orderWay);
			}else{
				$postion = 'ORDER BY a.`id_product` DESC';
			}

			$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'._DB_PREFIX_.'product` a
					'.($cid>0?'LEFT JOIN `'._DB_PREFIX_.'product_to_category` ptc ON a.id_product = ptc.id_product':'').'
					WHERE a.active=1 AND a.id_brand='.(int)$this->id.' '.$where);
			if($total==0)
				return false;

			$result = Db::getInstance()->ExecuteS('SELECT a.* 
					FROM `'._DB_PREFIX_.'product` a
					'.($cid>0?'LEFT JOIN `'._DB_PREFIX_.'product_to_category` ptc ON a.id_product = ptc.id_product':'').'
					WHERE a.active=1 AND a.id_brand='.(int)$this->id.' '.$where.'
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
	
	public static function getEntity($active = true,$p=1,$limit=50,$orderBy = NULL,$orderWay = NULL,$filter=array())
	{
	 	if (!Validate::isBool($active))
	 		die(Tools::displayError());

		$where = '';
		if(!empty($filter['id_brand']) && Validate::isInt($filter['id_brand']))
			$where .= ' AND a.`id_brand`='.intval($filter['id_brand']);
		if(!empty($filter['name']) && Validate::isCatalogName($filter['name']))
			$where .= ' AND a.`name` LIKE "%'.pSQL($filter['name']).'%"';
		
		if(!is_null($orderBy) AND !is_null($orderWay))
		{
			$postion = 'ORDER BY '.pSQL($orderBy).' '.pSQL($orderWay);
		}else{
			$postion = 'ORDER BY `id_brand` DESC';
		}

		$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'._DB_PREFIX_.'brand` a
				WHERE 1'.$where);
		if($total==0)
			return false;

		$result = Db::getInstance()->ExecuteS('SELECT a.* FROM `'._DB_PREFIX_.'brand` a
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