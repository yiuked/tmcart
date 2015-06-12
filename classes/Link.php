<?php
class Link
{
	public function getPage($view,$id_entity=0)
	{
		$alias = Db::getInstance()->getValue('SELECT `rule_link` FROM `'._DB_PREFIX_.'rule` WHERE `view_name`="'.pSQL($view).'"'.($id_entity?' AND id_entity='.(int)($id_entity):''));
		if(!$alias)
			return _TM_ROOT_URL_.'index.php?rule='.$view;
		return $this->getLink($alias);
	}

	public function getLink($alias)
	{
		if(URL_REWRITE)
			return _TM_ROOT_URL_.$alias;
		else
			return _TM_ROOT_URL_.'index.php?rule='.$alias;
	}
	
	public function goPage($url, $p)
	{
		return $url.($p == 1 ? '' : (!strstr($url, '?') ? '?' : '&amp;').'p='.(int)($p));
	}
	
	public function getImageLink($id_image,$name)
	{
		return Image::getImageLink($id_image,$name);
	}
}
?>