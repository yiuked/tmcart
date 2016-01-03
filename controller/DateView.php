<?php
class DateView extends View
{
		public function displayMain()
		{
			global $smarty;
				
			$d_date = pSQL($this->_args[1].'-'.$this->_args[2]);
			$posts  = CMSHelper::getDateCMS($d_date);	
			$smarty->assign(array(
					'posts' => $posts,
			));
			
			$smarty->display('cms_list.tpl');
		}
}
?>