<?php
	class AddressView extends View
	{
		public function displayMain()
		{
			global $smarty,$link,$cookie;
			$errors = false;

			if(!$cookie->logged || !User::checkPassword($cookie->id_user, $cookie->passwd))
				Tools::redirect($link->getPage('userView'));
			
			$referer = Tools::Q('referer') ? $link->getPage(Tools::Q('referer')):$link->getPage('MyAddressesView');
			if($id_address = Tools::getRequest('id_address')){
				$address   = new Address((int)($id_address));
				if(Tools::isSubmit('saveAddress')){
					$address->copyFromPost();
					if($address->update()){
						echo $referer;
						Tools::redirect($referer);
					}else{
						$errors  = $address->_errors;
					}
				}
				$smarty->assign('address',$address);
			}elseif(Tools::isSubmit('saveAddress')){
				$address =  new Address();
				$address->copyFromPost();
				$address->id_user = $cookie->id_user;
				if($address->add())
					Tools::redirect($referer);
				else
					$errors  = $address->_errors;
				
			}
			
			$countrys = Country::loadData(1, 1000, 'position', 'asc', array('active' => true));

			$smarty->assign(array(
				'referer'=>$referer,
				'countrys'=>$countrys,
				'errors'   => $errors,
			));
			$smarty->display('address.tpl');
		}
	}

?>