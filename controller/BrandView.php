<?php
class BrandView extends View
{
		public function displayMain()
		{
			global $smarty;
			$products = $this->entity->getProducts($this->p,$this->n,$this->by,$this->way,$this->filter);
			$this->pagination($products['total']);
			
			$smarty->assign(array(
					'entity'   => $this->entity,
					'products' => $products['entitys']
			));
			return $smarty->fetch('brand.tpl');
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