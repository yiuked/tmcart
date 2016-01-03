<?php
	class NotFundView extends View
	{
		public function displayMain()
		{
			global $smarty;

			$smarty->display('404.tpl');
		}
		
		public function setHead()
		{
			global $smarty;
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