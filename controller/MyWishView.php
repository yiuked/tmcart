<?php
class MyWishView extends View
{
	public function displayMain()
	{
		global $smarty,$link,$cookie;

		if(!$cookie->logged)
			Tools::redirect($link->getPage('LoginView'));

		$smarty->assign(array(
			'products' => Wish::getWishProductWithUser($cookie->id_user),
		));
		return $smarty->display('wish.tpl');
	}
		
	public function setHead()
	{
		$this->_js_file[]  	=  _TM_JQP_URL.'chosen/jquery.chosen.js';
		$this->_js_file[] 	=  _TM_JQP_URL.'jquery.easing.js';
		$this->_js_file[] 	=  _TM_JQP_URL.'jquery.iosslider.min.js';
		$this->_css_file[] 	=  _TM_JQP_URL.'chosen/jquery.chosen.css';
		parent::setHead();
	}

	public function displayLeft()
	{
		global $smarty;
		$smarty->assign(array(
			'LEFT_BLOCK' => Module::hookBlock(array('myaccount')),
		));
		return $smarty->fetch('block/left_columns.tpl');
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