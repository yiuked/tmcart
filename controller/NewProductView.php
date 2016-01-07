<?php
class NewProductView extends View
{
		public function displayMain()
		{
			global $smarty;
			$this->loadFilter();
			$products = Product::getNewProducts($this->p,$this->n,$this->by,$this->way);
			$this->pagination($products['total']);
			
			$smarty->assign(array(
					'products' => $products['entitys'],
			));
			return $smarty->fetch('new-products.tpl');
		}
		
		public function displayLeft()
		{
			global $smarty;
			$smarty->assign(array(
					'LEFT_BLOCK' => Module::hookBlock(array('categories')),
			));
			return $smarty->fetch('block/left_columns.tpl');
		}
}
?>