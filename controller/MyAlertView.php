<?php
class MyAlertView extends View
{
		public function requestAction()
		{
			global $smarty,$cart;
	
			$cart_info = array('cart_total'=>0,'cart_quantity'=>0,'cart_products'=>0);
			if(isset($cart)&& Validate::isLoadedObject($cart)){
				$cart_info = $cart->getCartInfo();
			}
			if(isset($_GET['id_alert'])){
				$alert = new Alert(intval($_GET['id_alert']));
				$alert->is_read = 1;
				$alert->update();
			}
			$wishs  = Wish::getWishSumByUser();
			$alerts = Alert::getAlertSumByUser();
			$smarty->assign(array(
				'wish_total'   => $wishs['count'],
				'wish_array'   => $wishs['array'],
				'alert_total'  => $alerts['count'],
				'cart_products'=> $cart_info['cart_products'],
				'cart_total'   => $cart_info['cart_total'],
				'cart_quantity'=> $cart_info['cart_quantity']
			));
		}
		
		public function displayMain()
		{
			global $smarty,$link,$cookie;

			if(!$cookie->logged)
				Tools::redirect($link->getPage('LoginView'));

			$smarty->assign(array(
					'alerts' => Alert::alerts($cookie->id_user)
			));
			return $smarty->fetch('my-alerts.tpl');
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