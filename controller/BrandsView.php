<?php
class BrandsView extends View
{
		public function displayMain()
		{
			global $smarty;
			$results = Brand::getEntity();
			$smarty->assign(array(
					'brands' => $results['entitys'],
			));
			$smarty->display('brands.tpl');
		}

		public function sendSectionHead()
		{
			global $smarty;
			$smarty->assign('SECATION_HEAD',Module::hookBlock(array('breadcrumb'),$this));
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

			$this->_js_file[] 	=  _TM_JQP_URL.'jquery.easing.js';
			$this->_js_file[] 	=  _TM_JQP_URL.'jquery.iosslider.min.js';
			parent::setHead();
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