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
				'addresses' => Address::loadData(1, 10, 'is_default', 'desc', array('id_user' => $user->id)),
			));
			return $smarty->fetch('my-addresses.tpl');
		}
		
		public function displayLeft()
		{
			global $smarty;
			$smarty->assign(array(
					'LEFT_BLOCK' => Module::hookBlock(array('myaccount')),
			));
			return $smarty->fetchy('block/left_columns.tpl');
		}
}
?>