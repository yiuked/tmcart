<?php
class MyordersView extends View
{
		public function displayMain()
		{
			global $smarty,$link,$cookie;

			if(!$cookie->logged)
				Tools::redirect($link->getPage('LoginView'));
			$user = new User((int)($cookie->id_user));
			
			if($reference = Tools::getRequest('reference'))
			{
				$order = Order::getByReference($reference);
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
			return $smarty->fetch('block/left_columns.tpl');
		}
}
?>