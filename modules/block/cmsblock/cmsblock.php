<?php
class cmsblock extends Module
{
	public $type = 'block';

	
	public function hookDisplay()
	{
		global $smarty;

		$display = $this->display(__FILE__, 'cmsblock.tpl');
		return $display;
		
	}
}
?>