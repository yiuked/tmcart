<?php
class SearchView extends View
{
		public function displayHeader()
		{	
			global $smarty;
			
			if($query = Tools::getRequest('s'))
				$smarty->assign('query',$query);
			return parent::displayHeader();
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

			return $smarty->fetch('search.tpl');
		}
		
}
?>