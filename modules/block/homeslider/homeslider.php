<?php
class homeslider extends Module
{
	public $type = 'block';
	
	public function hookDisplay()
	{
		global $smarty;

		$display = $this->display(__FILE__, 'homeslider.tpl');
		return $display;
	}
}
?>