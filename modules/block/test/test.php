<?php
class viewed extends Module
{
	public $type = 'block';

	public function hookDisplay($view=false)
	{
		global $smarty;
		$noloadid = 0;
		if(isset($_GET['entity']) && $_GET['entity']=='Product' && $_GET['id_entity']>0)
		{
			$this->add($_GET['id_entity']);
			$noloadid = intval($_GET['id_entity']);
		}
		$smarty->assign('vieweds',$this->get(5,$noloadid));
		$display = $this->display(__FILE__, 'viewed.tpl');
		return $display;	
	}
	
	public function add($id_product)
	{
		global $cookie;
		$_content = array();
		if(isset($cookie->viewed)&&strlen($cookie->viewed)>0){
			$_content = explode(",",$cookie->viewed);
		}
		if(!in_array($id_product,$_content))
			$_content[] = (int)$id_product;
	
		$cookie->viewed  = implode(",",$_content);
	}
	
	public function get($limit=10,$noloadid=0)
	{
		global $cookie;

		$_content = array();
		if(isset($cookie->viewed)&&strlen($cookie->viewed)>0){
			$_content = explode(",",$cookie->viewed);
		}
		
		$product_ids = array();
		$content_num = count($_content);
		if($content_num>0){
			$j = 0;
			for($i=$content_num-1;$i>=0;$i--){
				if($_content[$i]!=$noloadid){
					$product_ids[] = $_content[$i];
					$j++;
				}
				if($j>=$limit)
					break;
			}
		}else
			return false;
		
		if(count($product_ids)==0)
			return false;
		$result = Db::getInstance()->ExecuteS('SELECT p.*,b.name AS brand FROM `'._DB_PREFIX_.'product` p
		LEFT JOIN `'._DB_PREFIX_.'brand` b ON b.id_brand=p.id_brand
		WHERE id_product IN('.implode(',', array_map('intval', $product_ids)).')');
		if(!$result)
			return false;
		return Product::reLoad($result);
	}

}
?>