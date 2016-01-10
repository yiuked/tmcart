<?php
class TagView extends View
{
		public function displayMain()
		{
			global $smarty;
			$this->loadFilter();
			$products = $this->entity->getThisTags($this->p,$this->n);
			$this->pagination($products['total']);

			$smarty->assign(array(
					'tag_name' =>  $this->entity->name,
					'products' => $products['entity'],
			));
			return $smarty->fetch('tag.tpl');
		}

		public function displayLeft()
		{
			global $smarty;
			$smarty->assign(array(
					'LEFT_BLOCK' => Module::hookBlock(array('categories')),
			));
			return $smarty->fetch('block/left_columns.tpl');
		}
}

?>
