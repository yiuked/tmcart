<?php
	class IndexView extends View
	{
		public function setHead()
		{
			$this->_css_file[] 	=  _TM_MOD_URL.'block/homeslider/homeslider.css';
			parent::setHead();
		}
		public function displayMain()
		{
			global $smarty;

			$smarty->assign(array(
					'HOME_PAGE' => Module::hookBlock(array('homeslider','homeproduct')),
			));
			$smarty->display('index.tpl');
		}
		
		public function displayFooter()
		{
			global $smarty;
			/*$smarty->assign(array(
					'FOOT_BLOCK' => Module::hookBlock(array('viewed')),
			));	*/
			parent::displayFooter();
		}
	}

?>