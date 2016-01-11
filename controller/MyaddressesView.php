<?php
class MyaddressesView extends View
{
		public function displayMain()
		{
			global $smarty,$link,$cookie;

			if (!$cookie->logged) {
				Tools::redirect($link->getPage('LoginView'));
			}

			$user = new User((int)($cookie->id_user));
			$smarty->assign(array(
				'DISPLAY_LEFT' => Module::hookBlock(array('myaccount')),
				'addresses' => $user->getAddresses(),
			));
			return $smarty->fetch('my-addresses.tpl');
		}
}