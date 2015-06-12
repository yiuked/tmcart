<?php
class MyordersView extends View
{
		public function displayMain()
		{
			global $smarty,$link,$cookie;

			if(!$cookie->logged)
				Tools::redirect($link->getPage('LoginView'));
			$user = new User((int)($cookie->id_user));
			
			if($id_order = Tools::getRequest('id_order'))
			{
				$order = new Order((int)($id_order));
				$smarty->assign(array(
					'products'=>$order->cart->getProducts(),
					'h_order'=>$order
					));
			}
			
			$smarty->assign(array(
				'orders' => $user->getOrders(),
			));
			$smarty->display('my-orders.tpl');
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