<?php
	class IndexView extends View
	{
		public function displayMain()
		{
			global $smarty;
			$posts	= CMS::getCMS(true,1,20);

			$smarty->assign(array(
					'posts' => $posts['cmss'],
					'total' => $posts['total']
			));
			return $smarty->fetch('blog.tpl');
		}
	}

?>