<?php
class ShopView extends View
{
		public function displayMain()
		{
			global $smarty;
			$products = Product::getProducts();
			$smarty->assign(array(
					'products' => $products['entitys'],
			));
			$smarty->display('shop.tpl');
		}
}
?>