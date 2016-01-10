<?php
class CartView extends View
{
	private $cart_info = array(
				'cart_products'=>0,
				'cart_quantity'=>0,
				'cart_msg'=>'',
				'cart_discount'=>0,
				'cart_shipping'=>0,
				'cart_total'=>0,
				);

	public function requestAction()
	{
		global $smarty,$cookie,$cart,$link;

		parent::requestAction();

		if(!Validate::isLoadedObject($cart) && isset($cookie->id_cart))
		{
			$cart = new Cart((int)($cookie->id_cart));
		}

		if(Tools::isSubmit('addToCart')){
			if(!isset($cart) || !Validate::isLoadedObject($cart))
			{
				$cart = new Cart();
				$cart->copyFromPost();
				if ($cart->add()) {
					$cookie->__set('id_cart', $cart->id);
				}
			}
		
			if(Tools::getRequest('id_product'))
				$id_product = Tools::getRequest('id_product');
			
			if(Tools::getRequest('quantity'))
				$quantity = Tools::getRequest('quantity');
			
			if(Tools::getRequest('id_attributes'))
				$attributes = Tools::getRequest('id_attributes');

			$product = new Product(intval($id_product));
			if(Validate::isLoadedObject($cart)){
				$cart->addProduct($id_product,$quantity,$product->price,$attributes);
			}
			Tools::redirect($link->getPage('CartView'));
		}

		if(isset($_GET['delete']) AND intval($_GET['delete'])>0){
			$cart->deleteProduct(intval($_GET['delete']));
			Tools::redirect($link->getPage('CartView'));
		}
		
		if(Tools::isSubmit('cart_update'))
		{
			$quantitys = Tools::getRequest('quantity');
			if(count($quantitys)>0)
				foreach($quantitys as $key=>$val)
					$cart->updateProduct($key,$val['quantity']);
			Tools::redirect($link->getPage('CartView'));
		}
		
		if(isset($cart) && Validate::isLoadedObject($cart))
		{
			$this->cart_info = $cart->getCartInfo();
			$this->cart_info["cart_msg"] = $cart->msg;
		}
		
		$smarty->assign(array(
			'cart_products'=>$this->cart_info['cart_products'],
			'cart_quantity'=>$this->cart_info['cart_quantity'],
			'cart_msg'=>$this->cart_info['cart_msg'],
			'cart_discount'=>$this->cart_info['cart_discount'],
			'cart_shipping'=>$this->cart_info['cart_shipping'],
			'cart_total'=>$this->cart_info['cart_total'],
			'enjoy_free_shipping'=>(float)Configuration::get('ENJOY_FREE_SHIPPING'),
		));
	}
	
	public function setHead()
	{
		$this->_js_file[] 	=  _TM_JQP_URL.'jquery.easing.js';
		$this->_js_file[] 	=  _TM_JQP_URL.'jquery.iosslider.min.js';
		parent::setHead();
	}
	
	public function displayMain()
	{
		global $smarty;
		$result = Coupon::loadData();
		if($result){
			$smarty->assign(array(
					'coupons' => $result,
			));	
		}
		return $smarty->fetch('cart.tpl');
	}
	
	public function displayFooter()
	{
		global $smarty;
		$smarty->assign(array(
				'FOOT_BLOCK' => Module::hookBlock(array('viewed')),
		));	
		return parent::displayFooter();
	}
}
?>