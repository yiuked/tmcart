<?php
class UserView extends View
{
		public function displayMain()
		{
			global $smarty,$link,$cookie;

			if(!$cookie->logged)
				Tools::redirect($link->getPage('LoginView'));
				
			$user = new User((int)($cookie->id_user));
			if(Tools::isSubmit('joinCommit')){
				if(User::checkPassword($user->id,Tools::encrypt($_POST['old_passwd']))){
					if(Tools::getRequest('confirmation')==Tools::getRequest('passwd')){
						if(!empty($_POST['passwd']) && Validate::isPasswd($_POST['passwd'])){
							$user->copyFromPost();
							if($user->update()){
								$cookie->passwd = $user->passwd;
								$cookie->write();
								$smarty->assign('success','Your personal information has been successfully updated.');
							}
						}else{
							$user->_errors[] = 'Password is invalid.';
						}
					}else{
						$user->_errors[] = 'Password and confirmation do not match.';
					}
				}else{
					$user->_errors[] = 'Your password is incorrect.';
				}
			}
			$smarty->assign(array(
				'errors'=>$user->_errors,
				'DISPLAY_LEFT' => Module::hookBlock(array('myaccount')),
				'user' =>$user,
			));
			return $smarty->fetch('my-user.tpl');
		}
}
?>