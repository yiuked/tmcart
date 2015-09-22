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
			Tools::redirect($link->getPage('JoinView')."?step=2");
		}else{
			$this->LoginedAction();
		}
		$smarty->display('checkout.tpl');
	}
	
	public function LoginedAction()
	{
		global $cookie,$smarty;
		if(!isset($cookie->id_cart))
			die('Shpping cart is empty!');

		$cart = new Cart((int)($cookie->id_cart));
		$user = new User((int)($cart->id_user));
		$address = $user->getDefaultAddress();
		if($cart->id_address!=$address->id){
			$cart->id_address = $address->id;
			$cart->update();
		}
		
		$carriers  = Carrier::getEntity(true);
		$payments   = PaymentModule::getHookPayment();
		
		$smarty->assign(array(
			'cart'=>$cart,
			'address' => $address,
			'carriers'  => $carriers,
			'payments'  => $payments,
			'products' => $cart->getProducts(),
			'discount'=>$cart->discount,
			'total' => $cart->getProductTotal(),
		));
	}
}
?>