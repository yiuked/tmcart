<?php
class MyaddressesView extends View
{
		public function displayMain()
		{
			global $smarty,$link,$cookie;

			if(!$cookie->logged)
				Tools::redirect($link->getPage('LoginView'));
			$user = new User((int)($cookie->id_user));
			$smarty->assign(array(
				'address' => $user->getDefaultAddress(),
			));
			$smarty->display('my-addresses.tpl');
		}
		
		public function displayLeft()
		{
			global $smarty;
			$smarty->assign(array(
					'LEFT_BLOCK' => Module::hookBlock(array('myaccount')),
			));
			$smarty->display('block/left_columns.tpl');
		}
}
?>