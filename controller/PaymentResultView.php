<?php
	class PaymentResultView extends View
	{	
		public function displayMain()
		{
			global $cookie,$smarty, $link;

			if(!$cookie->logged)
				Tools::redirect($link->getPage('UserView'));
			
			$payment  = Module::hook((int)(Tools::getRequest('id_module')));
			
			$smarty->assign('HOOK_PAYMENT_RESULT',$payment->resultPayment());
			return $smarty->fetch('payment_result.tpl');
		}

		public function displayFooter()
		{
			global $smarty;
			$smarty->assign(array(
					'FOOT_BLOCK' => Module::hookBlock(array('viewed')),
			));	
			return parent::displayFooter();
		}
	}

?>