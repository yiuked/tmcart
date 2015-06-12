<?php
class shopbystyle extends Module
{
	public $type = 'block';
	
	public function hookDisplay()
	{
		global $smarty, $cookie,$link;
		
		if($_GET['entity']=='Category' && $_GET['id_entity']>0){

			$result = Db::getInstance()->ExecuteS('
			SELECT *
			FROM `'._DB_PREFIX_.'category`
			WHERE `active` = 1 AND `id_parent` = '.(int)$_GET['id_entity'].'
			ORDER BY `position` ASC');
			if(!$result)
				return;
		}

		foreach ($result as &$row)
		{
			$row['link'] = $link->getLink($row['rewrite']);
		}

		$smarty->assign('shopByStyle', $result);

		$display = $this->display(__FILE__, 'shopbystyle.tpl');
		return $display;
		
	}
}
?>