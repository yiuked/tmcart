<?php
class Wish extends ObjectBase
{
	protected $fields = array(
		'id_user' => array(
			'type' => 'isInt',
		),
		'id_product' => array(
			'type' => 'isInt',
		),
		'add_date' => array(
			'type' => 'isDate',
		),
	);
	
	protected 	$table = 'wish';
	protected 	$identifier = 'id_wish';

	public static function getWishProductWithUser($id_user)
	{
		$products = array();
		$result = Db::getInstance()->getAll('
				  SELECT p.* FROM '.DB_PREFIX.'wish w
				  LEFT JOIN '.DB_PREFIX.'product p ON (w.`id_product` = p.`id_product`)
				  WHERE w.id_user=' . (int) $id_user);
		if(!$result)
			return 0;
		$products = Product::reLoad($result);
		return $products;
	}
	
	public static function getWishSumByUser()
	{
		global $cookie;
		$array = array(
				'count'=> 0,
				'array'=> array()
				);
		if (isset($cookie->id_user) && $cookie->id_user > 0) {
			$result = Db::getInstance()->getAllValue('SELECT id_product FROM '.DB_PREFIX.'wish WHERE id_user=' . intval($cookie->id_user));
			if($result)
			{
				$array['count'] = count($result);
				$array['array'] = $result;
			}
		}

		return $array;
	}
	
}

