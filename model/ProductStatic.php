<?php 
class ProductStatic{
	public function getSaleProducts($p=1,$limit=50,$orderBy = NULL,$orderWay = NULL,$filter=array())
	{
		$cid = isset($filter['id_style'])?intval($filter['id_style']):0;
		$where = '';
		if(!empty($filter['id_color']) && is_array($filter['id_color']))
			$where .= ' AND a.`id_color` IN('.implode(',',array_map("intval",$filter['id_color'])).')';
		if(!empty($filter['id_brand']) && is_array($filter['id_brand']))
			$where .= ' AND a.`id_brand` IN('.implode(',',array_map("intval",$filter['id_brand'])).')';
		if($cid>0)
			$where .= ' AND ptc.`id_category`='.intval($cid);
		
			
		$cache_key = 'hot-sale-'.md5($cid.':'.$p.':'.$limit.':'.$orderBy.':'.$orderWay.':'.$where);
		if(!$rows = Cache::getInstance()->get($cache_key)){
			if(!is_null($orderBy) AND !is_null($orderWay))
			{
				$postion = 'ORDER BY a.'.pSQL($orderBy).' '.pSQL($orderWay);
			}else{
				$postion = 'ORDER BY a.`id_product` DESC';
			}

			$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'._DB_PREFIX_.'product` a
					'.($cid>0?'LEFT JOIN `'._DB_PREFIX_.'product_to_category` ptc ON a.id_product = ptc.id_product':'').'
					WHERE a.active=1 AND a.is_sale=1 '.$where);
			if($total==0)
				return false;

			$result = Db::getInstance()->ExecuteS('SELECT a.* 
					FROM `'._DB_PREFIX_.'product` a
					'.($cid>0?'LEFT JOIN `'._DB_PREFIX_.'product_to_category` ptc ON a.id_product = ptc.id_product':'').'
					WHERE a.active=1 AND a.is_sale=1 '.$where.'
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
	
	public function getBrandProducts($p=1,$limit=50,$orderBy = NULL,$orderWay = NULL,$filter=array())
	{
		$cid = isset($filter['id_style'])?intval($filter['id_style']):0;
		$where = '';
		if(!empty($filter['id_color']) && is_array($filter['id_color']))
			$where .= ' AND a.`id_color` IN('.implode(',',array_map("intval",$filter['id_color'])).')';
		if(!empty($filter['id_brand']) && is_array($filter['id_brand']))
			$where .= ' AND a.`id_brand` IN('.implode(',',array_map("intval",$filter['id_brand'])).')';
		if($cid>0)
			$where .= ' AND ptc.`id_category`='.intval($cid);
		
			
		$cache_key = 'hot-sale-'.md5($cid.':'.$p.':'.$limit.':'.$orderBy.':'.$orderWay.':'.$where);
		if(!$rows = Cache::getInstance()->get($cache_key)){
			if(!is_null($orderBy) AND !is_null($orderWay))
			{
				$postion = 'ORDER BY a.'.pSQL($orderBy).' '.pSQL($orderWay);
			}else{
				$postion = 'ORDER BY a.`id_product` DESC';
			}

			$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'._DB_PREFIX_.'product` a
					'.($cid>0?'LEFT JOIN `'._DB_PREFIX_.'product_to_category` ptc ON a.id_product = ptc.id_product':'').'
					WHERE a.active=1 '.$where);
			if($total==0)
				return false;

			$result = Db::getInstance()->ExecuteS('SELECT a.* 
					FROM `'._DB_PREFIX_.'product` a
					'.($cid>0?'LEFT JOIN `'._DB_PREFIX_.'product_to_category` ptc ON a.id_product = ptc.id_product':'').'
					WHERE a.active=1 '.$where.'
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
}
?>