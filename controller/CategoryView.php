<?php
class CategoryView extends View
{
		public function __construct()
		{
			if (Tools::G('id') > 0) {
				$this->entity = new Category(Tools::G('id'));
			}
		}

		public function displayMain()
		{
			global $smarty,$link;
			$products = Product::loadData($this->p, $this->n, $this->by, $this->way, $this->filter);
			$this->pagination($products['total']);

			/** 品牌索引 **/
			$filters = array();
			$filters['brand'] = Db::getInstance()->getAll('SELECT fp.id_filter,b.id_brand,b.name,b.id_image,COUNT(fp.id_filter) AS filter_num FROM tm_filter_product fp
LEFT JOIN tm_product_to_category ptc ON (fp.id_product = ptc.id_product)
LEFT JOIN tm_filter f ON (f.id_filter = fp.id_filter)
LEFT JOIN tm_brand b ON (b.id_brand = f.value)
WHERE ptc.id_category = ' . (int) $this->entity->id . ' AND f.`key` = "id_brand"
GROUP BY fp.id_filter');

			/** 特征索引 **/
			$features_result = Db::getInstance()->query('SELECT fp.id_filter,ft.id_feature,ft.name AS feature,fv.name,COUNT(fp.id_filter) AS filter_num FROM tm_filter_product fp
LEFT JOIN tm_product_to_category ptc ON (fp.id_product = ptc.id_product)
LEFT JOIN tm_filter f ON (f.id_filter = fp.id_filter)
LEFT JOIN tm_feature_value fv ON (fv.id_feature_value = f.value)
LEFT JOIN tm_feature ft ON(fv.id_feature = ft.id_feature)
WHERE ptc.id_category =  ' . (int) $this->entity->id . ' AND f.`key` = "id_feature_value"
GROUP BY fp.id_filter');

			$features = array();
			while($row = Db::getInstance()->nextRow($features_result)) {
				$features[$row['id_feature']]['name'] = $row['feature'];
				$features[$row['id_feature']]['values'][] = $row;
			}

			$filters['feature'] = $features;

			/** 属性索引 **/
			$attribute_result = Db::getInstance()->query('SELECT fp.id_filter,ag.id_attribute_group,ag.name AS `group`,a.name,COUNT(fp.id_filter) AS filter_num FROM tm_filter_product fp
LEFT JOIN tm_product_to_category ptc ON (fp.id_product = ptc.id_product)
LEFT JOIN tm_filter f ON (f.id_filter = fp.id_filter)
LEFT JOIN tm_attribute a ON (f.value = a.id_attribute)
LEFT JOIN tm_attribute_group ag ON(a.id_attribute_group = ag.id_attribute_group)
WHERE ptc.id_category =  ' . (int) $this->entity->id . ' AND f.`key` = "id_attribute"
GROUP BY fp.id_filter');

			$attribute = array();
			while($row = Db::getInstance()->nextRow($attribute_result)) {
				$attribute[$row['id_attribute_group']]['name'] = $row['group'];
				$attribute[$row['id_attribute_group']]['values'][] = $row;
			}

			$filters['attribute'] = $attribute;

			/** 分类索引 **/
			$filters['categories'] = Db::getInstance()->getAll('SELECT fp.id_filter,c.name, COUNT(fp.id_filter) AS filter_num  FROM tm_filter_product fp
LEFT JOIN tm_filter f ON (f.id_filter = fp.id_filter)
LEFT JOIN tm_product_to_category ptc ON (fp.id_product = ptc.id_product)
LEFT JOIN tm_category c ON (f.value = c.id_category)
WHERE ptc.id_category =  ' . (int) $this->entity->id . ' AND f.`key` = "id_category" AND c.id_parent =  ' . (int) $this->entity->id . '
GROUP BY fp.id_filter');

			/** 结束索引 **/
			$smarty->assign(array(
					'filters' => $filters,
					'this_url' => $link->getPage('CategoryView', $this->entity->id),
					'products' => $products['items']
			));
			return $smarty->fetch('category.tpl');
		}

		public function sendSectionHead()
		{
			global $smarty;
			$this->loadFilter();

			$smarty->assign(array(
				'SECATION_HEAD'=>Module::hookBlock(array('breadcrumb'),$this),
				'filter'=>Tools::getFilters($this->filter),
				));
		}
		
		public function setHead()
		{
			if(!isset($this->entity->meta_title)||$this->entity->meta_title=='0')
				$this->entity->meta_title = $this->entity->name;
			if(!isset($this->entity->meta_keywords)||$this->entity->meta_keywords=='0')
				$this->entity->meta_keywords = $this->entity->name;
			if(!isset($this->entity->meta_description)||$this->entity->meta_description=='0')
				$this->entity->meta_description = $this->entity->name;
			$this->_js_file[] 	=  _TM_JQP_URL.'jquery.easing.js';
			$this->_js_file[] 	=  _TM_JQP_URL.'jquery.iosslider.min.js';
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