<?php
class ContactView extends View
{
		public function displayMain()
		{
			global $smarty;
			parent::displayMain();
			if(Tools::isSubmit('contactUs'))
				$this->postContact();
			
			$smarty->assign(array(
					'errors' => $this->_errors,
					'success' => $this->_success,
			));
			$smarty->display('contact.tpl');
		}

		public function displayLeft()
		{
			global $smarty;
			$smarty->assign(array(
					'LEFT_BLOCK' => Module::hookBlock(array('cmsblock')),
			));
			$smarty->display('block/left_columns.tpl');
		}

		public function postContact()
		{	
			global $smarty,$cookie;
			session_start();
			if($_SESSION['validate_code']==strtolower(Tools::getRequest('validate_code'))){
				if($cookie->isLogged()){
					$user = new User($cookie->id_user);
					$_POST['name']  = $user->first_name.' '.$user->last_name; 
					$_POST['email'] = $user->email;
					if(isset($_POST['id_user'])) unset($_POST['id_user']);
					$_POST['id_user'] = $user->id;
				}
				$contact = new Contact();
				$contact->copyFromPost();
				if($contact->add()){
					$vars = array(
						'{name}'=>$contact->name,
						'{subject}'=>$contact->subject,
						'{email}'=>$contact->email,
						'{message}'=>$contact->content,
					);
					Mail::Send('contact',$contact->subject,$vars,Configuration::get('TM_SHOP_EMAIL'));
					$this->_success = 'Your message has been successfully sent to our team.';
				}else{
					$this->_errors = $contact->_errors;
				}
			}else{
				$this->_errors[] = 'Confirmation code is error！';
			}
		}
}
?>