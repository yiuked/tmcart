<?php 
class Color extends ObjectBase{
	protected $fields = array(
		'name' => array(
			'required' => true,
			'size' => 56,
			'type' => 'isGenericName',
		),
		'position' => array(
			'type' => 'isInt',
		),
		'name' => array(
			'required' => true,
			'size' => 56,
			'type' => 'isGenericName',
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

	public static function loadData($orderBy = NULL, $orderWay = NULL)
	{
		if(!is_null($orderBy) AND !is_null($orderWay))
		{
			$postion = 'ORDER BY '.pSQL($orderBy).' '.pSQL($orderWay);
		}else{
			$postion = 'ORDER BY `position` DESC';
		}
		$result = Db::getInstance()->getAll('SELECT *,code as color  FROM `'.DB_PREFIX.'color` '.$postion);
		return array(
			'total' => count($result),
			'items' => $result
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

			$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'.DB_PREFIX.'product` a
					WHERE a.active=1 AND a.id_color='.(int)($this->id));
			if($total==0)
				return false;

			$result = Db::getInstance()->getAll('SELECT a.*
					FROM `'.DB_PREFIX.'product` a
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
			Db::getInstance()->exec('INSERT INTO '.DB_PREFIX.'color_product (`id_color`,`id_product`) VALUES('.(int)$id_color.','.(int)$id_product.')');
		}
		return;
	}
}
?>