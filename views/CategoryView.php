<?php
class CategoryView extends View
{
		public function displayMain()
		{
			global $smarty;
			$products = $this->entity->getProducts($this->p,$this->n,$this->by,$this->way,$this->filter);
			$this->pagination($products['total']);
			
			$smarty->assign(array(
					'products' => $products['entitys']
			));
			$smarty->display('category.tpl');
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
			if(!isset($this->entity->meta_title)||$this->entity->meta_title=='0')
				$this->entity->meta_title = $this->entity->name;
			if(!isset($this->entity->meta_keywords)||$this->entity->meta_keywords=='0')
				$this->entity->meta_keywords = $this->entity->name;
			if(!isset($this->entity->meta_description)||$this->entity->meta_description=='0')
				$this->entity->meta_description = $this->entity->name;
			$this->_js_file[]  	=  _TM_JQP_URL.'chosen/jquery.chosen.js';
			$this->_css_file[] 	=  _TM_JQP_URL.'chosen/jquery.chosen.css';
			$this->_js_file[] 	=  _TM_JQP_URL.'jquery.easing.js';
			$this->_js_file[] 	=  _TM_JQP_URL.'jquery.iosslider.min.js';
			parent::setHead();
		}
		
		public function displayLeft()
		{
			global $smarty;
			
			$smarty->assign(array(
					'name'=>$this->entity->name,
					'id_parent'=>$this->entity->id_parent,
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