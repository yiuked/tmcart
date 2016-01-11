<?php
class LoginView extends View
{
	public function displayMain()
	{
		global $smarty,$link,$cookie;
		if($cookie->logged)
			Tools::redirect($link->getPage('MyaccountView'));
		if(Tools::isSubmit('loginSubmit'))
			if(Tools::getRequest('email') && Tools::getRequest('passwd')){
				$user = new User();
				if($user->getByEmail(Tools::getRequest('email'),Tools::getRequest('passwd'))){
					$user->logined();
					if(Tools::G("step") == 2) {
						Tools::redirect($link->getPage('CheckoutView'));
					}else{
						Tools::redirect($link->getPage('MyaccountView'));
					}
				}else
					$smarty->assign('errors',$user->_errors);			
			}else
				$smarty->assign('errors','invalid email password combination');

		return $smarty->fetch('login.tpl');
	}
}
?>