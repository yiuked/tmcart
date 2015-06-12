<?php
class homeproduct extends Module
{
	public $type = 'block';
	
	public function hookDisplay()
	{
		global $smarty, $cookie;


		$result = Db::getInstance()->ExecuteS('SELECT a.* 
				FROM `'._DB_PREFIX_.'product` a
				WHERE a.active=1 AND a.is_top=1
				LIMIT 0,12');
		$products = Product::reLoad($result);
		$smarty->assign('products', $products);

		$display = $this->display(__FILE__, 'homeproduct.tpl');
		return $display;
		
	}
}
?>