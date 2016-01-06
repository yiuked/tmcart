<?php
class Link
{
	public function getPage($view, $id = false)
	{
		$array = preg_split("/(?=[A-Z])/", $view);
		$route = trim(strtolower(implode('-', $array)), '-');
		return _TM_ROOT_URL_ . 'index.php?route=' . $route . ($id ? '&id=' . $id : '');
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
	
	public function getImageLink($id_image, $name = "")
	{
		return Image::getImageLink($id_image, $name);
	}
}
?>