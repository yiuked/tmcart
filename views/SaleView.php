<?php
class SaleView extends View
{
		public function displayMain()
		{
			global $smarty;
			$products = ProductStatic::getSaleProducts($this->p,$this->n,$this->by,$this->way,$this->filter);
			$this->pagination($products['total']);
			
			$smarty->assign(array(
					'products' => $products['entitys']
			));
			$smarty->display('sale.tpl');
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
		
		public function setHead()
		{
			global $smarty;
			$this->_js_file[]  	=  _TM_JQP_URL.'chosen/jquery.chosen.js';
			$this->_js_file[] 	=  _TM_JQP_URL.'jquery.easing.js';
			$this->_js_file[] 	=  _TM_JQP_URL.'jquery.iosslider.min.js';
			$this->_css_file[] 	=  _TM_JQP_URL.'chosen/jquery.chosen.css';
			parent::setHead();
		}
		
		public function displayLeft()
		{
			global $smarty;
			
			$smarty->assign(array(
					//'name'=>$this->entity->name,
					'LEFT_BLOCK' => Module::hookBlock(array('filterby')),
			));
			$smarty->display('block/left_columns.tpl');
		}
		
		public function displayFooter()
		{
			global $smarty;
			$smarty->assign(array(
					'FOOT_BLOCK' => Module::hookBlock(array('viewed')),
			));	
			parent::displayFooter();
		}
}
?>