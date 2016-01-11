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
			'DISPLAY_LEFT' => Module::hookBlock(array('myaccount')),
		));
		return $smarty->fetch('my-wish.tpl');
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