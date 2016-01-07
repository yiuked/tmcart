<?php
	class NotFundView extends View
	{
		public function displayMain()
		{
			global $smarty;

			return $smarty->fetch('404.tpl');
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