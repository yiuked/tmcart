<?php
class PaymentModule extends Module
{
	public $currentOrder;
	
	public static function getHookPayment()
	{
		$hook_payments = array();
		$payments = Module::getModulesByType('payment');
		foreach($payments as $key=>$payment){
			if((int)($payment['active'])==1){
				$pay = Module::Hook($payment['id']);
				$hook_payments[$key] = $pay->hookPayment();
			}
		}
		return $hook_payments;
	}
	
	public function validateOrder($cart,$id_module,$id_order_status)
	{
		global $cookie;
		if (!Validate::isLoadedObject($cart))
	 		die(Tools::displayError());
		$currency = new Currency((int)($cart->id_currency));
		$order = new Order();
		$order->id_cart = (int)($cart->id);
		$order->id_user = (int)($cart->id_user);
		$order->id_currency = (int)($cart->id_currency);
		$order->id_address = (int)($cart->id_address);
		$order->id_carrier = (int)($cart->id_carrier);
		$order->id_order_status = (int)($id_order_status);
		$order->id_module = (int)($id_module);
		$order->discount = floatval($cart->discount);
		$order->product_total = floatval($cart->getProductTotal());
		$order->shipping_total = floatval($cart->getShippingTotal());
		$order->amount = floatval($cart->getOrderTotal());
		$order->conversion_rate = floatval($currency->conversion_rate);
		$order->track_number = "null";
		if($order->add()){
			unset($cookie->id_cart);
			$this->currentOrder = $order->id;
			if($id_order_status==2){
				$products = $cart->getProducts();
				foreach($products as $row)
					Product::updateOrders($row['id_product']);
			}
			return true;
		}
		return false;
	}
	
	public function execPayment($cart){}
}
?>