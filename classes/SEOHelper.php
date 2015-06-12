<?php
class SEOHelper{
	public function updateCategoryMeta($post)
	{
		$rows = Db::getInstance()->ExecuteS("SELECT id_category,name FROM " . _DB_PREFIX_ . "category WHERE id_category IN(".implode(",",$post["categoryBox"]).")");

		foreach($rows as $row)
		{
			$title 			= mb_substr(self::replaceCategory($post["title"],$row),0,255);
			$keyword 		= mb_substr(self::replaceCategory($post["keywords"],$row),0,255);
			$description 	= mb_substr(self::replaceCategory($post["description"],$row),0,255);
			$rewrite 		= preg_replace("/[^a-zA-Z0-9\.]/","-",self::replaceCategory($post["rewrite"],$row));
			$rewrite		= strtolower(preg_replace("/(\-{2,})/","-",$rewrite));
			if(!empty($title))
				Db::getInstance()->Execute("UPDATE "._DB_PREFIX_."category SET meta_title='".pSQL($title)."' WHERE id_category=".intval($row['id_category']));
			if(!empty($keyword))
				Db::getInstance()->Execute("UPDATE "._DB_PREFIX_."category SET meta_keywords='".pSQL($keyword)."' WHERE id_category=".intval($row['id_category']));
			if(!empty($description))
				Db::getInstance()->Execute("UPDATE "._DB_PREFIX_."category SET meta_description='".pSQL($description)."' WHERE id_category=".intval($row['id_category']));
			if(!empty($rewrite)){
				Db::getInstance()->Execute("UPDATE "._DB_PREFIX_."category SET rewrite='".pSQL($rewrite)."' WHERE id_category=".intval($row['id_category']));
				Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'rule` SET `rule_link`="'.pSQL($rewrite).'" WHERE `entity`="Category" AND `id_entity` ='.intval($row['id_category']));
			}
		}
	}
	
	static private function replaceCategory($string,$row)
	{
		$fields =  array(
			"C_ID"=>"id_category",
			"C_NAME"=>"name");
	
		foreach($fields as $key=>$field){
			$string = str_replace($key,trim(str_replace(array("\r\n", "\r", "\n","'","\""),"",strip_tags(htmlspecialchars_decode($row[$field])))),$string);
		}
		return trim(preg_replace_callback("/{([^}]+)}/",array("self","randWithString"),$string));
	}
	
	public function updateProductMeta($post)
	{
		$pbrands = Tools::getRequest('id_brands');
		$brand_where = '';
		if(is_array($pbrands))
			$brand_where = ' AND p.id_brand IN('.implode(",",$pbrands).')';

		$rows = Db::getInstance()->ExecuteS("SELECT p.id_product,p.ean13,p.special_price,p.price,p.name,c.name AS category,cl.name AS color
				FROM "._DB_PREFIX_."product AS p
				Left Join "._DB_PREFIX_."category AS c ON p.id_category_default = c.id_category
				Left Join "._DB_PREFIX_."color AS cl ON p.id_color = cl.id_color
				WHERE p.id_category_default IN(".implode(",",$post["categoryBox"]).")".$brand_where);
		foreach($rows as $row)
		{
			$title 			= mb_substr(self::replaceProduct($post["title"],$row),0,255);
			$keyword 		= mb_substr(self::replaceProduct($post["keywords"],$row),0,255);
			$description 	= mb_substr(self::replaceProduct($post["description"],$row),0,255);
			$rewrite 		= preg_replace("/[^a-zA-Z0-9\.]/","-",self::replaceProduct($post["rewrite"],$row));
			$rewrite		= strtolower(preg_replace("/(\-{2,})/","-",$rewrite));

			if(!empty($title))
				Db::getInstance()->Execute("UPDATE "._DB_PREFIX_."product SET meta_title='".pSQL($title)."' WHERE id_product=".intval($row['id_product']));
			if(!empty($keyword))
				Db::getInstance()->Execute("UPDATE "._DB_PREFIX_."product SET meta_keywords='".pSQL($keyword)."' WHERE id_product=".intval($row['id_product']));
			if(!empty($description))
				Db::getInstance()->Execute("UPDATE "._DB_PREFIX_."product SET meta_description='".pSQL($description)."' WHERE id_product=".intval($row['id_product']));
			if(!empty($rewrite)){
				Db::getInstance()->Execute("UPDATE "._DB_PREFIX_."product SET rewrite='".pSQL($rewrite)."' WHERE id_product=".intval($row['id_product']));
				Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'rule` SET `rule_link`="'.pSQL($rewrite).'" WHERE `entity`="Product" AND `id_entity` ='.intval($row['id_product']));
			}
		}
	}
	
	static private function replaceProduct($string,$row)
	{
		$fields =  array(
			"P_ID"=>"id_product",
			"P_NAME"=>"name",
			"P_PRICE"=>"price",
			"P_OLD_PRICE"=>"special_price",
			"P_SKU"=>"ean13",
			"P_CATEGORY"=>"category",
			"P_COLOR"=>"color");
		foreach($fields as $key=>$field){
			$string = str_replace($key,trim(str_replace(array("\r\n", "\r", "\n","'","\""),"",strip_tags(htmlspecialchars_decode($row[$field])))),$string);
		}
		$string = str_replace("\r\n","",$string);
		return trim(preg_replace_callback("/{([^}]+)}/",array("self","randWithString"),$string));
	}
	
	static function randWithString($result)
	{
		$randStringArray = explode("|",$result[1]);
		return $randStringArray[array_rand($randStringArray)];
	}
}
?>