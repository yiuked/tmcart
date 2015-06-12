<?php
class productreviews extends Module
{
	public $type = 'block';

	public function hookDisplay($view=false)
	{
		global $smarty;
		
		$smarty->assign('feedbacks',$this->getFeedback());
		$display = $this->display(__FILE__, 'productreviews.tpl');
		return $display;	
	}

	public function getFeedback()
	{
		global $link;

		$result = Db::getInstance()->ExecuteS('SELECT f.rating,f.id_product,f.name,f.feedback,f.flag_code,p.name,p.rewrite FROM '._DB_PREFIX_.'feedback AS f
		Left Join '._DB_PREFIX_.'product AS p ON f.id_product = p.id_product
		ORDER BY f.add_date DESC LIMIT 0, 20');
		foreach($result as &$row){
			$row['link']	= $link->getLink($row['rewrite']);
		}

		return $result;
	}

}
?>