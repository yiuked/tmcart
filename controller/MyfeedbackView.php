<?php
class MyfeedbackView extends View
{
		public function displayMain()
		{
			global $smarty,$link,$cookie;

			if(!$cookie->logged)
				Tools::redirect($link->getPage('LoginView'));
			$user = new User((int)($cookie->id_user));
			$errors  = array();
			$success = false; 
			//添加feedback
			//1.添加创建对象
			if(Tools::isSubmit('submit')){
				$feedback =  new Feedback();
				$feedback->copyFromPost();
				if($feedback->rating<=0&&$feedback->rating>5)
					$feedback->rating = 4;
				
				$data 					= explode("-",base64_decode(Tools::getRequest("data")));
				$feedback->id_product 	= (int)$data[0];
				$feedback->unit_price 	= (float)$data[2];
				$feedback->quantity 	= (int)$data[3];
				$feedback->md5_key 		= md5(Tools::getRequest("data"));
				$feedback->name	   		= substr($user->first_name,0,1)."***".substr($user->last_name,-1,1);
				$feedback->id_user 		= $user->id;
				if($feedback->add())
					$success = true;
				else
					$errors  = $feedback->_errors;
			}
			//2.获取用户评论过的MD5KEY
			$proids 	= Feedback::haveFeedbackWithUser($user->id);
			//3.获取用户购买过的产品
			$products   = array();
			if ($result 	= $user->getPaymentedProduct()){
				foreach($result as &$row)
					if(!in_array($row['md5_key'],$proids)){
						$products [] = $row;
					}
			}
			
			$smarty->assign(array(
				'success'=>$success,
				'errors'=>$errors,
				'products'=>$products,
				'DISPLAY_LEFT' => Module::hookBlock(array('myaccount')),
			));
			return $smarty->fetch('my-feedback.tpl');
		}
}