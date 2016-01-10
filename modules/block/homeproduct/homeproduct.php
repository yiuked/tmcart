<?php
class homeproduct extends Module
{
	public $type = 'block';
	
	public function hookDisplay()
	{
		global $smarty, $cookie;


		$result = Db::getInstance()->getAll('SELECT a.*
				FROM `'.DB_PREFIX.'product` a
				WHERE a.active=1 AND a.is_top=1
				LIMIT 0,4');
		$products = Product::reLoad($result);
		$smarty->assign('products', $products);

		$display = $this->display(__FILE__, 'homeproduct.tpl');
		return $display;
		
	}
}
?>