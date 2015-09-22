<?php
include_once(dirname(__FILE__)."/init.php");

if (array_key_exists('sendorder', $_GET))
{
	if(isset($_GET['id_order'])){
		$order = new Order((int)$_GET['id_order']);
		
		$url 		= Configuration::get('TM_SENDORDER_URL');
		$key 		= Configuration::get('TM_SENDORDER_KEY');
		$webname 	= Configuration::get('TM_SENDORDER_SHOP_NAME');
		
		$products = $order->cart->getProducts("large");
		
		$product_name = array();
		$product_image = array();
		
		foreach ($products as $k => $product)
		{	
			if($product['attributes'])
				foreach($product['attributes'] as $attribute){
					$product['name'] .= ' - '.$attribute['group_name'].':'.str_replace("-","/",$attribute['name']);
				}
			$product_name[]  = $product['name'];
			$product_image[] = $product['image'];

		}
		$addressHtml  = $order->address->first_name.' '.$order->address->last_name.'<br>';
		$addressHtml .= $order->address->address.' '.$order->address->address2.'<br>';
		$addressHtml .= $order->address->postcode.' '.$order->address->city.' '.($order->address->country->need_state?$order->address->state->name:'').'<br>';
		$addressHtml .= $order->address->country->name.'<br>';
		$addressHtml .= $order->address->phone.'<br>';
		
		$data = array(
			'token'=>md5($webname.$order->id_cart.$order->user->email.$order->amount.$key),
			'web_name' =>$webname,
			'id_order' =>$order->id_order,
			'id_cart' =>$order->id_cart,
			'image' =>implode("|||",$product_image),
			'name' =>implode("|||",$product_name),
			'email' =>$order->user->email,
			'address' =>$addressHtml,
			'price_out' =>$order->amount,
			'add_date' =>$order->add_date
		);
		 
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		curl_setopt ( $ch, CURLOPT_HEADER, 0 );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
		$return = curl_exec ( $ch );
		curl_close ( $ch );
		$msg = json_decode($return);
		if(!$msg->hasErrors)
			die(json_encode(array('hasErrors'=>false)));
		die(json_encode(array('hasErrors'=>true,'msg'=>$msg->msg)));
	}
	die(json_encode(array('hasErrors'=>true,'msg'=>'找不到定单！')));
}

if (array_key_exists('carttoorder', $_GET))
{
	if(isset($_GET['id_cart'])){
		$id_order = Db::getInstance()->getValue('SELECT id_order FROM '._DB_PREFIX_.'order WHERE id_cart='.intval($_GET['id_cart']));
		if($id_order)
			die(json_encode(array('hasErrors'=>true,'msg'=>'该购物车定单已存在！')));
		$cart = new Cart((int)$_GET['id_cart']);
		if (Validate::isLoadedObject($cart)){
			$id_module = 0;
			$payment = new PaymentModule();
			if($payment->validateOrder($cart,$id_module,2))
			{
				die(json_encode(array('hasErrors'=>false)));
			}
			die(json_encode(array('hasErrors'=>true,'msg'=>'生顾定单失败！')));
		}
		die(json_encode(array('hasErrors'=>true,'msg'=>'购物车无效！')));
	}
	die(json_encode(array('hasErrors'=>true,'msg'=>'找不到购物车！')));
}