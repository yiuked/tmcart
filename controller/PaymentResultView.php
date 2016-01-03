<?php
	class PaymentResultView extends View
	{	
		public function displayMain()
		{
			global $cookie,$smarty;

			if(!$cookie->logged)
				Tools::redirect($link->getPage('UserView'));
			
			$payment  = Module::hook((int)(Tools::getRequest('id_module')));
			
			$smarty->assign('HOOK_PAYMENT_RESULT',$payment->resultPayment());
			$smarty->display('payment_result.tpl');
		}
		
		public function setHead()
		{
			global $smarty;
			$this->_js_file[] =  _TM_JQP_URL.'jquery.easing.js';
			$this->_js_file[] =  _TM_JQP_URL.'jquery.iosslider.min.js';		
			parent::setHead();
		}
		
		public function displayFooter()
		{
			global $smarty;
			$smarty->assign(array(
					'FOOT_BLOCK' => Module::hookBlock(array('viewed')),
			));	
			parent::displayFooter();
		}
	}

?>