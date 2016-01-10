<?php
class categories extends Module
{
	public $type = 'block';
	public function getTree($resultParents, $resultIds, $maxDepth, $id_category = 1, $currentDepth = 0)
	{
		global $link,$cookie;

		$children = array();
		if (isset($resultParents[$id_category]) AND sizeof($resultParents[$id_category]) AND ($maxDepth == 0 OR $currentDepth < $maxDepth))
			foreach ($resultParents[$id_category] as $subcat)
				$children[] = $this->getTree($resultParents, $resultIds, $maxDepth, $subcat['id_category'], $currentDepth + 1);
		if (!isset($resultIds[$id_category]))
			return false;
		return array('id' => $id_category, 'link' => $link->getLink($resultIds[$id_category]['rewrite']),
					 'name' => $resultIds[$id_category]['name'], 'rewrite'=> $resultIds[$id_category]['rewrite'],
					 'children' => $children);
	}
	
	public function hookDisplay()
	{
		global $smarty, $cookie;

		$result = Db::getInstance()->ExecuteS('
			SELECT *
			FROM `'._DB_PREFIX_.'category`
			WHERE (`active` = 1 OR `id_category` = 1)
			GROUP BY id_category
			ORDER BY `level_depth` ASC, `position` ASC');
		if(!$result)
			return;
			
		$resultParents = array();
		$resultIds = array();

		foreach ($result as &$row)
		{
			$resultParents[$row['id_parent']][] = &$row;
			$resultIds[$row['id_category']] = &$row;
		}

		$blockCategTree = $this->getTree($resultParents, $resultIds, Configuration::get('BLOCK_CATEG_MAX_DEPTH'));
		unset($resultParents);
		unset($resultIds);

		$smarty->assign('blockCategTree', $blockCategTree);

		$display = $this->display(__FILE__, 'categories.tpl');
		return $display;
		
	}
}
?>