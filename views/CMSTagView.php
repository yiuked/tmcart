<?php
class CMSTagView extends View
{
		public function displayMain()
		{
			global $smarty;
			$posts = $this->entity->getThisTags();
			
			$smarty->assign(array(
					'posts' => CMS::resetCMS($posts['posts']),
					'total' => $posts['total']
			));
			$smarty->display('cms_list.tpl');
		}
}
?>