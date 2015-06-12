<?php 
class Color extends ObjectBase{
	protected $fields 			= array('name','top','code','rewrite');
	protected $fieldsRequired	= array('name','code','rewrite');
	protected $fieldsSize 		= array('name' => 56,'code'=>56);
	protected $fieldsValidate	= array('name' => 'isGenericName','code'=>'isColor','rewrite' => 'isLinkRewrite',);
	
	protected $identifier 		= 'id_color';
	protected $table			= 'color';
	
	public function getFields()
	{
		parent::validation();
		if (isset($this->id))
			$fields['id_color'] = (int)($this->id);
		$fields['top'] = (int)($this->top);
		$fields['code'] = pSQL($this->code);
		$fields['rewrite'] = pSQL($this->rewrite);
		$fields['name'] = pSQL($this->name);
		return $fields;
	}
	
	public function add()
	{
		$num = Db::getInstance()->getValue("SELECT * FROM `"._DB_PREFIX_."color` WHERE code='".pSQL(strtolower($this->code))."'");
		if($num>0)
			return true;
		else
			return parent::add();
	}
	
	public static function getEntitys()
	{
		$result = Db::getInstance()->ExecuteS('SELECT * FROM `'._DB_PREFIX_.'color` ORDER BY `top` ASC');
		return $result;
	}
	
	public function getProducts($p=1,$limit=50,$orderBy = NULL,$orderWay = NULL)
	{
		$cache_key = 'color-'.md5($this->id.':'.$p.':'.$limit.':'.$orderBy.':'.$orderWay);
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