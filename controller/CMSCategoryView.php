<?php
class CMSCategoryView extends View
{
		public function displayMain()
		{
			global $smarty;
			$posts = $this->entity->getThisTags();
			
			$smarty->assign(array(
					'posts' => CMS::resetCMS($posts['posts']),
					'total' => $posts['total']
			));
			return $smarty->fetch('cms_list.tpl');
		}
}
?>