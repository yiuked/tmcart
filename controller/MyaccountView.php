<?php
class MyaccountView extends View
{
		public function displayMain()
		{
			global $smarty, $link, $cookie;

			if (!$cookie->logged) {
				Tools::redirect($link->getPage('LoginView'));
			}

			return $smarty->fetch('my-account.tpl');
		}
		
		public function displayLeft()
		{
			global $smarty;
			$smarty->assign(array(
					'LEFT_BLOCK' => Module::hookBlock(array('myaccount')),
			));
			return $smarty->fetch('block/left_columns.tpl');
		}
}
?>