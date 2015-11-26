<?php 
class Color extends ObjectBase{
	protected $fields 			= array('name', 'position', 'code', 'meta_title','meta_keywords', 'meta_description', 'rewrite');
	protected $fieldsRequired	= array('name','code','rewrite');
	protected $fieldsSize 		= array('name' => 56,'code'=>56);
	protected $fieldsValidate	= array(
		'name' => 'isGenericName',
		'code' => 'isColor',
		'position' => 'isInt',
		'meta_title' => 'isCleanHtml',
		'meta_keywords' => 'isCleanHtml',
		'meta_description' => 'isCleanHtml',
		'rewrite' => 'isLinkRewrite'
	);
	public $fieldss = array(
		'name' => array(
			'type' => 'isGenericName',
			'size' => 56,
			'required' => true,
		),
		'position' => array(
			'type' => 'isInt',
		),
		'name' => array(
			'type' => 'isGenericName',
			'size' => 56,
			'required' => true,
		),
		'code' => array(
			'type' => 'isColor',
			'size' => 32,
			'required' => true,
		),
		'meta_title' => array(
			'type' => 'isCleanHtml',
			'size' => 256,
		),
		'meta_keywords' => array(
			'type' => 'isCleanHtml',
			'size' => 256,
		),
		'meta_description' => array(
			'type' => 'isCleanHtml',
			'size' => 256,
		),
		'rewrite' => array(
			'type' => 'isLinkRewrite',
			'size' => 256,
			'required' => true,
		),
	);
	
	protected $identifier 		= 'id_color';
	protected $table			= 'color';
	
	public function getFields()
	{
		parent::validation();
		if (isset($this->id))
			$fields['id_color'] = (int)($this->id);
		$fields['position'] = (int)($this->position);
		$fields['code'] = pSQL($this->code);
		$fields['meta_title'] = pSQL($this->meta_title);
		$fields['meta_keywords'] = pSQL($this->meta_keywords);
		$fields['meta_description'] = pSQL($this->meta_description);
		$fields['rewrite'] = pSQL($this->rewrite);
		$fields['name'] = pSQL($this->name);
		return $fields;
	}
	
	public function add($nullValues = false)
	{
		$num = Db::getInstance()->getValue("SELECT * FROM `"._DB_PREFIX_."color` WHERE code='".pSQL(strtolower($this->code))."'");
		if($num>0)
			return true;
		else
			return parent::add();
	}
	
	public static function getEntitys($orderBy = NULL, $orderWay = NULL)
	{
		if(!is_null($orderBy) AND !is_null($orderWay))
		{
			$postion = 'ORDER BY '.pSQL($orderBy).' '.pSQL($orderWay);
		}else{
			$postion = 'ORDER BY `position` DESC';
		}
		$result = Db::getInstance()->ExecuteS('SELECT *,code as color  FROM `'._DB_PREFIX_.'color` '.$postion);
		return array(
			'total' => count($result),
			'entitys' => $result
		);
	}
	
	public function getProducts($p = 1, $limit = 50, $orderBy = NULL, $orderWay = NULL)
	{
		$cache_key = 'color-' . md5($this->id . ':' . $p . ':' . $limit . ':' . $orderBy . ':' . $orderWay);
		if(!$rows = Cache::getInstance()->get($cache_key)){
			if(!is_null($orderBy) AND !is_null($orderWay))
			{
				$postion = 'ORDER BY a.'.pSQL($orderBy).' '.pSQL($orderWay);
			}else{
				$postion = 'ORDER BY a.`id_product` DESC';
			}

			$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'._DB_PREFIX_.'product` a
					WHERE a.active=1 AND a.id_color='.(int)($this->id));
			if($total==0)
				return false;

			$result = Db::getInstance()->ExecuteS('SELECT a.* 
					FROM `'._DB_PREFIX_.'product` a
					WHERE a.active=1 AND a.id_color='.(int)($this->id).'
					'.$postion.'
					LIMIT '.(($p-1)*$limit).','.(int)$limit);
			$rows   = array(
					'total' => $total['total'],
					'entitys'  => Product::reLoad($result));
			Cache::getInstance()->set($cache_key,$rows);
		}
		return $rows;
	}
	
	static public function addProduct($id_color,$id_products)
	{
		foreach($id_products as $id_product)
		{
			Db::getInstance()->Execute('INSERT INTO '._DB_PREFIX_.'color_product (`id_color`,`id_product`) VALUES('.(int)$id_color.','.(int)$id_product.')');
		}
		return;
	}
}
?>