<?php
class viewed extends Module
{
	public $type = 'block';

	public function hookDisplay($view=false)
	{
		global $smarty;
		$noloadid = 0;
		if(Tools::G('route') == 'product-view' && Tools::G('id') > 0)
		{
			$this->addViewed(Tools::G('id'));
			$noloadid = intval(Tools::G('id'));
		}
		$smarty->assign('vieweds',$this->getViewed(10, $noloadid));
		$display = $this->display(__FILE__, 'viewed.tpl');
		return $display;	
	}
	
	public function addViewed($id_product)
	{
		global $cookie;
		$_content = array();
		if (isset($cookie->viewed) && strlen($cookie->viewed) > 0) {
			$_content = explode(",",$cookie->viewed);
		}
		if(!in_array($id_product,$_content))
			$_content[] = (int)$id_product;
	
		$cookie->viewed  = implode(",",$_content);
	}
	
	public function getViewed($limit = 10, $noloadid = 0)
	{
		global $cookie;

		$_content = array();
		if(isset($cookie->viewed) && strlen($cookie->viewed) > 0){
			$_content = explode(",", $cookie->viewed);
		}
		
		$product_ids = array();
		$content_num = count($_content);
		if ($content_num > 0) {
			$j = 0;
			for ($i = $content_num - 1; $i >= 0; $i--) {
				if ($_content[$i]!=$noloadid) {
					$product_ids[] = $_content[$i];
					$j++;
				}
				if ($j >= $limit)
					break;
			}
		}else
			return false;
		
		if (count($product_ids) == 0)
			return false;
		$result = Db::getInstance()->getAll('SELECT p.*,b.name AS brand FROM `'.DB_PREFIX.'product` p
		LEFT JOIN `'.DB_PREFIX.'brand` b ON b.id_brand=p.id_brand
		WHERE id_product IN('.implode(',', array_map('intval', $product_ids)).')');
		if(!$result)
			return false;
		return Product::reLoad($result);
	}

}
?>