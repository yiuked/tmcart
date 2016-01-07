<?php
class SaleView extends View
{
		public function displayMain()
		{
			global $smarty;

			$products = Product::loadData($this->p, $this->n, $this->by, $this->way, array('is_sale' => 1, 'brand.active' => 1, 'active' => 1));
			$this->pagination($products['total']);
			
			$smarty->assign(array(
					'products' => $products['items']
			));
			return $smarty->fetch('sale.tpl');
		}

		public function sendSectionHead()
		{
			global $smarty;
			$this->loadFilter();

			$smarty->assign(array(
				'SECATION_HEAD'=>Module::hookBlock(array('breadcrumb'),$this),
				'filter'=>Tools::getFilters($this->filter),
				));
		}
		
		public function displayLeft()
		{
			global $smarty;
			
			$smarty->assign(array(
					//'name'=>$this->entity->name,
					'LEFT_BLOCK' => Module::hookBlock(array('filterby')),
			));
			return $smarty->fetch('block/left_columns.tpl');
		}
		
		public function displayFooter()
		{
			global $smarty;
			$smarty->assign(array(
					'FOOT_BLOCK' => Module::hookBlock(array('viewed')),
			));	
			return parent::displayFooter();
		}
}
?>