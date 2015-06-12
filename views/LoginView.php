<?php
class LoginView extends View
{
	public function displayMain()
	{
		global $smarty,$link,$cookie;
		if($cookie->logged)
			Tools::redirect($link->getPage('MyaccountView'));
		if(Tools::isSubmit('signSubmit'))
			if(Tools::getRequest('email') && Tools::getRequest('passwd')){
				$user = new User();
				if($user->getByEmail(Tools::getRequest('email'),Tools::getRequest('passwd'))){
					$user->logined();
					Tools::redirect($link->getPage('MyaccountView'));
				}else
					$smarty->assign('errors',$user->_errors);			
			}else
				$smarty->assign('errors','invalid email password combination');
		
		$smarty->display('login.tpl');
	}
}
?>