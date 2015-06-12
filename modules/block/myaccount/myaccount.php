<?php
class myaccount extends Module
{
	public $type = 'block';

	
	public function hookDisplay()
	{
		global $smarty;


		$display = $this->display(__FILE__, 'myaccount.tpl');
		return $display;
		
	}
}
?>