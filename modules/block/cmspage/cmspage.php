<?php
class cmspage extends Module
{
	public $type = 'block';
	
	public function hookDisplay()
	{
		global $smarty, $cookie;

		$display = $this->display(__FILE__, 'cmspage.tpl');
		return $display;
		
	}
}
?>