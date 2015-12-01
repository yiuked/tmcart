<?php 
class Brand extends ObjectBase{

	protected $fields = array(
		'id_image' => array(
			'type' => 'isInt'
		),
		'name' => array(
			'required' => true,
			'size' => 256,
			'type' => 'isCatalogName'
		),
		'description' => array(
			'type' => 'isCleanHtml'
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
		'active' => array(
			'type' => 'isInt',
		),
	);
	
	protected $identifier 		= 'id_brand';
	protected $table			= 'brand';

	/**
	 * ¸üÐÂÆ·ÅÆÍ¼Æ¬
	 *
	 * @return bool
	 */
	public function updateLogo()
	{
		$uploader = new FileUploader();
		$result = $uploader->handleUpload('brand');
		if (isset($result['success'])) {
			if ($this->id_image > 0 ) {
				$image = new Image($this->id_image);
				if (Validate::isLoadedObject($image)) {
					$image->delete();
				}
			}
			$this->id_image = $result['success']['id_image'];
			return $this->update();
		}
		return false;
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

			$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'.DB_PREFIX.'product` a
					'.($cid>0?'LEFT JOIN `'.DB_PREFIX.'product_to_category` ptc ON a.id_product = ptc.id_product':'').'
					WHERE a.active=1 AND a.id_brand='.(int)$this->id.' '.$where);
			if($total==0)
				return false;

			$result = Db::getInstance()->getAll('SELECT a.*
					FROM `'.DB_PREFIX.'product` a
					'.($cid>0?'LEFT JOIN `'.DB_PREFIX.'product_to_category` ptc ON a.id_product = ptc.id_product':'').'
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

		$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'.DB_PREFIX.'brand` a
				WHERE 1'.$where);
		if($total==0)
			return false;

		$result = Db::getInstance()->getAll('SELECT a.* FROM `'.DB_PREFIX.'brand` a
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