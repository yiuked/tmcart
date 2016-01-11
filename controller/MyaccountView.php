<?php
class MyaccountView extends View
{
		public function displayMain()
		{
			global $smarty, $link, $cookie;

			if (!$cookie->logged) {
				Tools::redirect($link->getPage('LoginView'));
			}
			$smarty->assign(array(
				'DISPLAY_LEFT' => Module::hookBlock(array('myaccount')),
			));
			return $smarty->fetch('my-account.tpl');
		}
}
?>