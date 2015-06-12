<?php
class PasswordView extends View
{
	public function displayMain()
	{
		global $smarty,$link;

		$errors = array();
		$step   = 1;
		$isExp = false;
		if(Tools::getRequest('reset')=='passwd'){
			$step = 2;
		}
		
		if($step ==1 && Tools::isSubmit('ResetPassword')){
			$user = new User();
			$user->getByEmail(Tools::getRequest('email'));
			if(Validate::isLoadedObject($user)){
				$md5_key = md5(_COOKIE_KEY_.$user->email.$user->passwd.$user->upd_date);
				$subject = 'Reset your password in'.Configuration::get('TM_SHOP_DOMAIN');
				$vars = array(
					'{name}'=>$user->first_name.' '.$user->last_name,
					'{subject}'=>$subject,
					'{link}'=>$link->getPage('PasswordView').'?reset=passwd&id_user='.$user->id.'&key='.$md5_key
				);

				if(Mail::Send('passwd',$subject,$vars,$user->email))
				{
					$step = 4;
				}else{
					$errors[] = 'Send mail fail! Pless try agen!';
				}
			}else{
				$errors[] = 'The email don\'t exists!';
			}
		}elseif($step ==2){
			$sign    = Tools::getRequest('key');
			$id_user = Tools::getRequest('id_user');
			$user 	 = new User($id_user);
			if(Validate::isLoadedObject($user)){
				$md5_key = md5(_COOKIE_KEY_.$user->email.$user->passwd.$user->upd_date);
				if($md5_key==$sign){
					if(Tools::isSubmit('confrimPassword')){
						$user->copyFromPost();
						if(Validate::isPasswd(Tools::getRequest('passwd')) && $user->update()){
							$step = 3;
						}else{
							$errors[] = 'This passwd is incorrect';
						}
					}
				}else{
					$isExp    = true;
					$errors[] = 'This link has expired!';
				}
			}else{
				$isExp    = true;
				$errors[] = 'The customer don\'t exists!';
			}
		}

		$smarty->assign(array(
			'step'=>$step,
			'isExp'=>$isExp,
			'errors' => $errors,
		));
		
		$smarty->display('password.tpl');
	}
}
?>