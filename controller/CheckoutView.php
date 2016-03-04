<?php
class CheckoutView extends View
{
	public function displayMain()
	{
		global $smarty,$cookie,$link;
		$cart = new Cart((int)($cookie->id_cart));
		if(isset($_POST['msg'])&&pSQL($_POST['msg'],true)!=$cart->msg){
			$cart->msg = substr(pSQL($_POST['msg'],true),0,500);
			$cart->update();
		}

		if(!$cookie->logged ||!User::checkPassword($cookie->id_user,$cookie->passwd)){
			Tools::redirect($link->getPage('LoginView', false, array('step' => 2) ));
		}else{
			$this->LoginedAction();
		}
		$smarty->assign(array(
			'id_default_carrier' => Configuration::get('TM_DEFAULT_CARRIER_ID'),
		));
		return $smarty->fetch('checkout.tpl');
	}
	
	private function LoginedAction()
	{
		global $cookie, $smarty;
		if(!isset($cookie->id_cart))
			die('Shpping cart is empty!');

		$cart = new Cart((int)($cookie->id_cart));
		$user = new User((int)($cart->id_user));
		$addresses = $user->getAddresses();
		
		$carriers  = Carrier::loadData();
		$payments   = PaymentModule::getHookPayment();
		
		$smarty->assign(array(
			'cart'=>$cart,
			'addresses' => $addresses,
			'carriers'  => $carriers,
			'payments'  => $payments,
			'products' => $cart->getProducts(),
			'discount'=>$cart->discount,
			'total' => $cart->getProductTotal(),
		));
	}
}