<?php
class filterby extends Module
{
	public $type = 'block';
	
	public function hookDisplay()
	{
		global $smarty;
		$limit = "";
		$args  = "";
		
		if(isset($_GET['id_color']))
		{
			$limit ="&";
			$args  = "?";
		}

		$smarty->assign(array(
			'mit'	=>$limit,
			'ags'	=>$args,
			'styles'=>$this->getStyle(),
			'colors'=>$this->getColor(),
			));

		$display = $this->display(__FILE__, 'filterby.tpl');
		return $display;
		
	}

	public function getStyle()
	{
		global $link;
		
		$cache_key = 'style-list-data';
		if(!$result = Cache::getInstance()->get($cache_key)){
			$result = Db::getInstance()->getAll('
			SELECT id_category,name,rewrite
			FROM `' . DB_PREFIX . 'category`
			WHERE `active` = 1 AND `id_parent` = 1
			ORDER BY `position` ASC');
			if($result){
				foreach ($result as &$row)
				{
					$row['link'] = $link->getPage('CategoryView', $row['id_category']);
				}
			}
			Cache::getInstance()->set($cache_key,$result);
		}

		return $result;
	}

	public function getColor()
	{
		global $link;
		$cache_key = 'color-list-data';
		if(!$result = Cache::getInstance()->get($cache_key)){
			$result = Db::getInstance()->getAll('SELECT *
					FROM `' . DB_PREFIX . 'color` ORDER BY `top` ASC');
			if($result){
				foreach ($result as &$row)
				{
					$row['link'] = $link->getLink($row['rewrite']);
				}
			}
			Cache::getInstance()->set($cache_key,$result);
		}
		return $result;
	}
}
?>