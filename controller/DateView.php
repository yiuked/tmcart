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

			return $smarty->fetch('cms_list.tpl');
		}
}
?>