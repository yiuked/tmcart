<?php
class SearchView extends View
{
		public function displayHeader()
		{	
			global $smarty;
			
			if($query = Tools::getRequest('s'))
				$smarty->assign('query',$query);
			parent::displayHeader();
		}
		public function displayMain()
		{
			global $smarty,$cookie;			
			
			$query = Tools::getRequest('s');
			$query =  str_replace(array('%','\'','*','"'),'',$query);
			if($query){
				$this->loadFilter();
				$products = Product::getSreachProduct($query,$this->p,$this->n,$this->by,$this->way);
				$this->pagination($products['total']);
				if($products)
					$smarty->assign(array(
							'query'=>$query,
							'total'=>$products['total'],
							'products' => $products['entitys'],
					));
			}
			
			$smarty->display('search.tpl');
		}
		
		public function setHead()
		{
			global $smarty;
			$this->_js_file[]  	=  _TM_JQP_URL.'chosen/jquery.chosen.js';
			$this->_css_file[] 	=  _TM_JQP_URL.'chosen/jquery.chosen.css';
			parent::setHead();
		}
		
}
?>