<?php
	class IndexView extends View
	{
		public function setHead()
		{
			global $smarty;
			/*iosslider*/
			$this->_js_file[] 	=  _TM_JQP_URL.'jquery.easing.js';
			$this->_js_file[] 	=  _TM_JQP_URL.'jquery.iosslider.min.js';
			/*end iosslider*/
			parent::setHead();
		}
	
		public function sendSectionHead()
		{
			global $smarty;
			$this->loadFilter();

			$smarty->assign(array(
				'filter'=>Tools::getFilters($this->filter),
				));
			parent::sendSectionHead();
		}
		public function displayLeft()
		{
			global $smarty;
			
			$smarty->assign(array(
					'LEFT_BLOCK' => Module::hookBlock(array('filterby')),
			));
			$smarty->display('block/left_columns.tpl');
		}
	
		public function displayMain()
		{
			global $smarty,$cookie;

			$smarty->assign(array(
					'HOME_PAGE' => Module::hookBlock(array('homeslider','homeproduct')),
			));
			$smarty->display('index.tpl');
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