<?php
class ColorView extends View
{
		public function displayMain()
		{
			global $smarty;
			$this->loadFilter();
			$products = $this->entity->getProducts($this->p,$this->n,$this->by,$this->way);
			$this->pagination($products['total']);
			
			$smarty->assign(array(
					'BREADCRUMB' => Module::hookBlock(array('breadcrumb'),$this),
					'products' => $products['entitys']
			));
			
			$smarty->display('color.tpl');
		}
		
		public function displayLeft()
		{
			global $smarty;
			$smarty->assign(array(
					'LEFT_BLOCK' => Module::hookBlock(array('shopbycolor')),
			));
			$smarty->display('block/left_columns.tpl');
		}
}
?>