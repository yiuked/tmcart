<?php
	class ConfirmOrderView extends View
	{
		public $use_tpl = false;
		
		public function displayMain()
		{
			global $cookie,$link;

			if(!isset($cookie->id_cart) || !$cookie->logged)
				Tools::redirect($link->getPage('UserView'));
			
			if(!Tools::getRequest('id_module') || !Tools::getRequest('id_address'))
				Tools::redirect($link->getPage('CheckoutView'));

			$cart = new Cart((int)($cookie->id_cart));
			$cart->id_address = (int)(Tools::getRequest('id_address'));
			$cart->id_carrier = (int)(Tools::getRequest('id_carrier'));
			$cart->update();
			
			$payment  = Module::hook((int)(Tools::getRequest('id_module')));
			if(!$payment->active)
				Tools::redirect($link->getPage('CheckoutView'));
			
			echo $payment->execPayment($cart);
		}
	}

?>