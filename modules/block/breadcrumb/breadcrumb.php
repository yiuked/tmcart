<?php
class breadcrumb extends Module
{
	public $type = 'block';

	public function hookDisplay($view=false)
	{
		global $smarty,$_tmconfig,$link;

		$view_name = get_class($view);
		$fullPath = '<ul class="breadcrumb">';
		$fullPath .= '<li class="back-arrow"><i class="icon-arrow-left"></i><strong><a href="javascript:history.back();">Back</a></strong>&nbsp;</li>';
		$fullPath .= '<li><a href="'.$_tmconfig['root_dir'].'">Home</a></li>';
		
		if ($view_name === 'ProductView' OR $view_name === 'CategoryView' )
		{
			$entityid = "";
			if($view_name === 'ProductView'){
				$id_category = $view->entity->id_category_default;
			}else if($view_name==='CategoryView'){
				$entityid    = ",".$view->entity->id;
				$id_category = $view->entity->id_parent;
			}
			$last_page   = '<li><strong>'.$view->entity->name.'</strong></li>';
			
			$category = Db::getInstance()->getRow('
			SELECT id_category, level_depth, nleft, nright
			FROM '._DB_PREFIX_.'category
			WHERE id_category = '.(int)$id_category);
			$id_parent_path = ",1,".$id_category;
			if (isset($category['id_category']))
			{
				$categories = Db::getInstance()->ExecuteS('
				SELECT id_category,name,rewrite
				FROM '._DB_PREFIX_.'category
				WHERE nleft <= '.(int)$category['nleft'].' AND nright >= '.(int)$category['nright'].' AND id_category != 1
				ORDER BY level_depth ASC
				LIMIT '.(int)$category['level_depth']);

				$n = 1;
				$nCategories = (int)sizeof($categories);
				foreach ($categories AS $category)
				{
					$id_parent_path .= ",".$category['id_category'];
					$fullPath .=
					('<li><a href="'.$link->getLink($category['rewrite']).'" title="'.htmlentities($category['name'], ENT_NOQUOTES, 'UTF-8').'">').
					htmlentities($category['name'], ENT_NOQUOTES, 'UTF-8').
					('</a></li>');
				}

				$id_parent_path .= $entityid.",";
				$smarty->assign('id_parent_path',$id_parent_path);
			}
			$fullPath .= $last_page;
	    }else if($view_name == 'ColorView'){
				$fullPath .= '<li><strong>'.$view->entity->name.'</strong></li>';
		}else if($view_name == 'SaleView'){
				$fullPath .= '<li><strong>Hot sale</strong></li>';
		}else if($view_name == 'BrandsView'){
				$fullPath .= '<li><strong>Brands</strong></li>';
		}
		$fullPath .= "</ul>";

		$smarty->assign('breadcrumbs',$fullPath);
		$display = $this->display(__FILE__, 'breadcrumb.tpl');
		return $display;	
	}

}
?>