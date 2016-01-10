<?php
class JoinView extends View
{
	public function setHead()
	{
		$this->_js_file[]  	=  _TM_JS_URL.'bootstrap-validator/js/bootstrapValidator.min.js';
		$this->_css_file[] 	=  _TM_JS_URL.'bootstrap-validator/css/bootstrapValidator.min.css';
		parent::setHead();
	}

	public function displayMain()
	{
		global $smarty,$link;

		$errors = array();

		if(Tools::isSubmit('CreateUser')){
			if(!Validate::isEmail(Tools::getRequest('email')) || User::userExists(Tools::getRequest('email'))){
				$errors[] = 'The email is invalid or an account is already registered with this e-mail!';
			}elseif(empty($_POST['passwd'])){
				$errors[] = 'The password is empty!';
			}else{
				$user = new User();
				$user->copyFromPost();
				$user->active = 1;
				if($user->add()){
					$address = new Address();
					$address->copyFromPost();
					$address->id_user = $user->id;
					$address->is_default = 1;
					if($address->add()){
						$user->logined(array('id_address'=>$address->id));
						if(Tools::getRequest("step")==2)
							Tools::redirect($link->getPage('CheckoutView'));
						else
							Tools::redirect($link->getPage('MyaccountView'));
						return;
					}else
					 $errors = $address->_errors;
				}else
					$errors = $user->_errors;
			}
		}
		$countrys = Country::loadData(1, 500, null, null, array('active' => 1));
		$smarty->assign(array(
			'id_default_country'=>Configuration::get('TM_DEFAULT_COUNTRY_ID'),
			'countrys'=>$countrys,
			'step'=>Tools::getRequest("step"),
			'errors' => $errors,
		));

		return $smarty->fetch('join.tpl');
	}
}
?>