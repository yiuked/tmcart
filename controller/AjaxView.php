<?php
class AjaxView extends View
{
	public $use_tpl = false;
	public function displayMain(){
		global $cookie;
		/*
		when user add or change address,from addressView or joinView
		*/
		if (isset($_GET['ajaxStates']) AND isset($_GET['id_country']))
		{
			$states = Db::getInstance()->getAll('
			SELECT s.id_state, s.name
			FROM '.DB_PREFIX.'state s
			LEFT JOIN '.DB_PREFIX.'country c ON (s.`id_country` = c.`id_country`)
			WHERE s.id_country = '.(int)(Tools::G('id_country')).' AND s.active = 1 AND c.`need_state` = 1
			ORDER BY s.`name` ASC');
		
		if (is_array($states) AND !empty($states))
			{
				$list = '';
				if (Tools::G('no_empty') != true)
					$list = '<option value="0">-----------</option>'."\n";
		
				foreach ($states AS $state)
					$list .= '<option value="' . (int) ($state['id_state']) . '"' .(Tools::G('id_state') == $state['id_state'] ? ' selected="selected"' : '') . '>' . $state['name'] . '</option>'."\n";
			}
			else
				$list = 'false';
		
			die($list);
		}//end get states
		
		/*
		from cartView get total
		*/
		if(isset($_GET['getTotal']) AND isset($_GET['id_cart']) AND isset($_GET['id_carrier']))
		{
			$carrier  = new Carrier((int)($_GET['id_carrier']));
			$cart	  = new Cart((int)($_GET['id_cart']));
			$shipping = $carrier->shipping;
			$p_total  = $cart->getProductTotal();
			$total	  = $shipping + $p_total - $cart->discount;
			$arr	  = array(
					  'name'=>$carrier->name,
					  'shipping'=>Tools::displayPrice($shipping),
					  'total'=>Tools::displayPrice($total));
			echo json_encode($arr);
			exit();
		}//end use gettotal
		
		/*
		start use promo code,from CartView
		*/
		if(isset($_GET['validatedPromocode'])&&isset($_GET['code'])){
			if(!isset($cookie->id_cart)){
				$arr	  = array(
				'status'=>"NO",
				'msg'=>"cart is not init!",
				);
				echo json_encode($arr);exit();
			}
			$row = Db::getInstance()->getRow('SELECT * FROM '._DB_PREFIX_.'coupon WHERE code="'.pSQL($_GET['code']).'" AND active=1');
			if($row){
				if($row['id_user']==0||$row['id_user']==@$cookie->id_user){
					$cart 		= new Cart($cookie->id_cart);
					$total 		= $cart->getProductTotal();
					$quantity 	= $cart->getProductQantity();
					$discount   = 0;
					if($total>$row['total_over']||($row['quantity_over']>0&&$quantity>$row['quantity_over'])){
						if($row['off']>0){
							$discount = (float)$total*$row['off']/100;
						}else{
							$discount = (float)$row['amount'];
						}
						$cart->discount = $discount;
						if($cart->update()){
							$arr	  = array(
							'status'=>"YES",
							'discount'=>"-".Tools::displayPrice($discount),
							'total'=>Tools::displayPrice($cart->getOrderTotal()),
							);
							echo json_encode($arr);exit();
						}
						
					}
				}
			}
			$arr	  = array(
			'status'=>"NO",
			'msg'=>"the code don't found!",
			);
			echo json_encode($arr);exit();
		}//end use promo code

		/**
		 * 购物车
		 */
		if (Tools::G('c') == 'Cart') {
			global $cart;
			switch (Tools::G('m')) {
				case 'removeItem':
					if ($cart->deleteProduct(Tools::G('id'))) {
						$cart_info = $cart->getCartInfo();
						$result = array(
							'status' => 'yes',
							'cart_total' => Tools::displayPrice($cart_info['cart_total']),
							'cart_quantity' => $cart_info['cart_quantity'],
						);
						die(json_encode($result));
					}
					die(json_encode(array("status" => "no")));
					break;
				case 'plusItem':
					if ($row = $cart->plusProduct(Tools::G('id'))) {
						$cart_info = $cart->getCartInfo();
						$result = array(
							'status' => 'yes',
							'cart_total' => Tools::displayPrice($cart_info['cart_total']),
							'cart_quantity' => $cart_info['cart_quantity'],
							'item' => array(
								'quantity' => $row['quantity'],
								'total' => Tools::displayPrice($row['total']),
							)
						);
						die(json_encode($result));
					}
					die(json_encode(array("status" => "no")));
					break;
				case 'minusItem':
					if ($row = $cart->minusProduct(Tools::G('id'))) {
						$cart_info = $cart->getCartInfo();
						$result = array(
							'status' => 'yes',
							'cart_total' => Tools::displayPrice($cart_info['cart_total']),
							'cart_quantity' => $cart_info['cart_quantity'],
							'item' => array(
								'quantity' => $row['quantity'],
								'total' => Tools::displayPrice($row['total']),
							)
						);
						die(json_encode($result));
					}
					die(json_encode(array("status" => "no")));
					break;
				case 'deleteMultiItem':
					if ($cart->deleteMultiProduct(explode(',', Tools::G('id')))) {
						$cart_info = $cart->getCartInfo();
						$result = array(
							'status' => 'yes',
							'cart_total' => Tools::displayPrice($cart_info['cart_total']),
							'cart_quantity' => $cart_info['cart_quantity'],
						);
						die(json_encode($result));
					}
					die(json_encode(array("status" => "no")));
					break;
				default:
					break;
			}
		}

		/**
		* 商品收藏
		*/
		if (Tools::G('c') == 'Wish') {
			if (!isset($cookie->id_user)) {
				die(json_encode(array("status" => "no", "msg" => "d'not login!")));
			}
			$user = new User((int) $cookie->id_user);
			if (!Validate::isLoadedObject($user)) {
				die(json_encode(array("status" => "no", "msg" => "user load fail!")));
			}

			switch (Tools::G('m')) {
				case 'addItem':
					if ($status = $user->addToWish(Tools::G('id'))) {
						if ($status === 1) {
							$result = array(
								"m" => "add",
								'status' => 'yes',
							);
						} else if ($status === -1) {
							$result = array(
								"m" => "delete",
								'status' => 'yes',
							);
						}
						die(json_encode($result));
					}
					die(json_encode(array("status" => "no")));
					break;
				default:
					break;
			}
		}

				/*
		start use add wish,from ProductView or CategoryView
		*/
		if(isset($_GET['action'])&&$_GET['action']=='add_wish'&&isset($_GET['id_product']))
		{
			if($action = Wish::userAddWishProduct($_GET['id_product'])){
				$wishs    	= Wish::getWishSumByUser();
				$count_html = "";
				if($wishs['count']>0)
					$count_html = "<i>{$wishs['count']}</i>";
					
				$arr	  = array(
							'action'=>$action,
							'count'=>$count_html,
							'status'=>"YES"
							);
				echo json_encode($arr);
			}else{
				$arr	  = array('status'=>"NO");
				echo json_encode($arr);
			}
			exit();
		}//end use add wish


		/**
		 * 邮箱是否已被注册
		 */
		if (Tools::P('existsEmail')) {
			$valid = true;
			if (User::userExists(Tools::P('existsEmail'))) {
				$valid = false;
			}
			echo json_encode(array(
				'valid' => $valid,
			));
		}
	}
}
?>