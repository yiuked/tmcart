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
					'products' => $order->cart->getProducts(),
					'h_order' => $order
				));
			}
			
			$smarty->assign(array(
				'orders' => $user->getOrders(),
				'DISPLAY_LEFT' => Module::hookBlock(array('myaccount')),
			));
			return $smarty->fetch('my-orders.tpl');
		}
}