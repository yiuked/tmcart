<?php
class shopbycolor extends Module
{
	public $type = 'block';

	public function hookDisplay($view=false)
	{
		global $smarty;
		
		$smarty->assign('colors',$this->getColor());
		$display = $this->display(__FILE__, 'shopbycolor.tpl');
		return $display;	
	}

	public function getColor()
	{
		global $link;
		$cache_key = 'color-list-data';
		if(!$result = Cache::getInstance()->get($cache_key)){
			$result = Db::getInstance()->ExecuteS('SELECT * 
					FROM `'._DB_PREFIX_.'color` ORDER BY `top` ASC');
			foreach($result as &$row){
				$row['link']	= $link->getLink($row['rewrite']);
			}
			//Cache::getInstance()->set($cache_key,$result);
		}
		return $result;
	}

}
?>