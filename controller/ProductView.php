<?php

class ProductView extends View
{
		public function __construct()
		{
			if (Tools::G('id') > 0) {
				$this->entity = new Product(Tools::G('id'));
			}
		}

		public function displayMain()
		{
			global $smarty;
			
			$attributes = Product::getAttributeAndGrop($this->entity->id);
			$feedbacks = Feedback::feedbackWithProdict($this->entity->id);
			$brand		= $this->entity->id_brand> 0 ? new Brand($this->entity->id_brand):false;
			$smarty->assign(array(
				'feedback'=>$feedbacks,
				'entity'   => $this->entity,
				'images' => $this->entity->getImages(),
				'groups'=>Product::getAttributeAndGrop($this->entity->id),
				'brand'=>$brand,
				'products'=>$this->entity->getAlsoProduct(),
			));
			return $smarty->fetch('product.tpl');
		}

		public function sendSectionHead()
		{
			global $smarty;
			$smarty->assign('SECATION_HEAD',Module::hookBlock(array('breadcrumb'),$this));
		}

		public function setHead()
		{
			global $smarty;
			if(!isset($this->entity->meta_title)||$this->entity->meta_title=='0')
				$this->entity->meta_title = $this->entity->name;
			if(!isset($this->entity->meta_keywords)||$this->entity->meta_keywords=='0')
				$this->entity->meta_keywords = $this->entity->name;
			if(!isset($this->entity->meta_description)||$this->entity->meta_description=='0')
				$this->entity->meta_description = $this->entity->name;

			$this->_js_file[] =  _TM_THEMES_URL.'js/product.js';
			$category = new Category($this->entity->id_category_default);
			$smarty->assign(array(
				'id_category'=>$category->id_parent==1?$category->id:$category->id_parent
				));
			parent::setHead();
		}
		
		public function displayFooter()
		{
			global $smarty;
			$smarty->assign(array(
					'FOOT_BLOCK' => Module::hookBlock(array('viewed')),
			));
			return parent::displayFooter();
		}
}
?>