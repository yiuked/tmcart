<?php
class Wish extends ObjectBase
{
	protected 	$fields 			= array('id_user','id_product','add_date');
 	protected 	$fieldsRequired = array('id_user', 'id_product');
	
	protected 	$table = 'wish';
	protected 	$identifier = 'id_wish';

	public function getFields()
	{
		parent::validation();
		if (isset($this->id))
			$fields['id_wish'] = (int)($this->id);
		$fields['id_user'] = (int)($this->id_user);
		$fields['id_product'] = (int)($this->id_product);
		return $fields;
	}
	
	public static function getWishProductWithUser($id_user)
	{
		$products = array();
		$result = Db::getInstance()->getAll('
				  SELECT p.*,i.`id_image` FROM '.DB_PREFIX.'wish w
				  LEFT JOIN '.DB_PREFIX.'product p ON (w.`id_product` = p.`id_product`)
				  LEFT JOIN '.DB_PREFIX.'image i ON (p.`id_product` = i.`id_product`)
				  WHERE w.id_user='.(int)($id_user).' AND i.`cover`=1');
		if(!$result)
			return 0;
		$products = Product::reLoad($result);
		return $products;
	}
	
	public static function getWishSumByUser()
	{
		global $cookie;
		$array = array(
				'count'=>0,
				'array'=>array()
				);
		if(isset($cookie->id_user)&&$cookie->id_user>0){
			$result = Db::getInstance()->ExecuteField('SELECT id_product FROM '.DB_PREFIX.'wish WHERE id_user='.intval($cookie->id_user),'id_product');
			if($result)
			{
				$array['count'] = count($result);
				$array['array'] = $result;
			}
		}
		return $array;
	}
	
	public function userAddWishProduct($id_product)
	{
		global $cookie;
		 $id_user = 0;
		 if(isset($cookie->id_user))
		 	$id_user = intval($cookie->id_user);
		 if($id_user==0||$id_product==0)
		 	return false;

		 $id_wish = Db::getInstance()->getValue('SELECT id_wish FROM '.DB_PREFIX.'wish WHERE id_user='.intval($id_user).' AND id_product='.intval($id_product));
		 if($id_wish>0){
			$wish = new Wish($id_wish);
			$wish->delete();
			return "-";
		 }else{
		 	$wish = new Wish();
			$wish->id_user		= (int)$id_user;
			$wish->id_product	= (int)$id_product;
			if($wish->add())
				return "+";
			return false;
		 }
	}
}

