<?php
include_once(dirname(__FILE__) . "/../config/init.php");
/**
 * 处理各种taggle请求
 */
if(isset($_GET['toggle']))
{
	$fields = array(
		'Product' => array('active','in_stock','is_new','is_sale','is_top'),
		'Category'=> array('active'),
		'User'=> array('active'),
		'Brand'=> array('active'),
		'OrderStatus'=> array('send_mail'),
		'CMS'=> array('active', 'is_top'),
		'Country' => array('need_state', 'active'),
	);

	$key    = Tools::G('key');
	$object = Tools::G('toggle');
	$id  	= Tools::G('id');

	if (isset($fields[$object]) && in_array($key,$fields[$object])){
		$entity = new $object($id);
		if($entity->toggle($key))
		{
			die(json_encode(array("status"=>"YES")));
		}
	}
	die(json_encode(array("status"=>"NO")));
}

/**
 * ajax动态状态国家下的省/州
 */
if (isset($_GET['ajaxStates']) AND isset($_GET['id_country']))
{
	$states = Db::getInstance()->getAll('
	SELECT s.id_state, s.name
	FROM '.DB_PREFIX.'state s
	LEFT JOIN '.DB_PREFIX.'country c ON (s.`id_country` = c.`id_country`)
	WHERE s.id_country = '.(int)(Tools::getRequest('id_country')).' AND s.active = 1 AND c.`need_state` = 1
	ORDER BY s.`name` ASC');

	if (is_array($states) AND !empty($states))
	{
		$list = '';
		if (Tools::getRequest('no_empty') != true)
			$list = '<option value="0">--选择--</option>'."\n";

		foreach ($states AS $state)
			$list .= '<option value="'.(int)($state['id_state']).'"'.((isset($_GET['id_state']) AND $_GET['id_state'] == $state['id_state']) ? ' selected="selected"' : '').'>'.$state['name'].'</option>'."\n";
	}
	else
		$list = 'false';

	die($list);
}

/**
 * Jquery tree动态获取子目信息
 */
if (Tools::isSubmit('getChildrenCategories') && Tools::getRequest('id_category_parent'))
{
	if(Tools::getRequest('type')=='CMSTree'){
		$children_categories = CMSCategory::getChildrenWithNbSelectedSubCat(Tools::getRequest('id_category_parent'), Tools::getRequest('selectedCat'));
		die(json_encode($children_categories));
	}elseif(Tools::getRequest('type') == 'Tree'){
		$children_categories = Category::getChildrenWithNbSelectedSubCat(Tools::getRequest('id_category_parent'), Tools::getRequest('selectedCat'));
		die(json_encode($children_categories));
	}
}

/*CMS Category position*/
if (array_key_exists('ajaxCMSCategoriesPositions', $_POST))
{
	$id_cms_category_to_move = (int)(Tools::getRequest('id_cms_category_to_move'));
	$id_cms_category_parent = (int)(Tools::getRequest('id_cms_category_parent'));
	$way = (int)(Tools::getRequest('way'));
	$positions = Tools::getRequest('cms_category');
	if (is_array($positions))
		foreach ($positions AS $key => $value)
		{
			$pos = explode('_', $value);
			if ((isset($pos[1]) AND isset($pos[2])) AND ($pos[1] == $id_cms_category_parent AND $pos[2] == $id_cms_category_to_move))
			{
				$position = $key;
				break;
			}
		}
	$cms_category = new CMSCategory($id_cms_category_to_move);
	if (Validate::isLoadedObject($cms_category))
	{
		if (isset($position) && $cms_category->updatePosition($way, $position))
			die(true);
		else
			die('{"hasError" : true, "errors" : "Can not update cms categories position"}');
	}
	else
		die('{"hasError" : true, "errors" : "This cms category can not be loaded"}');
}
/*Category Positrion*/
if (array_key_exists('ajaxCategoriesPositions', $_POST))
{
	$id_category_to_move = (int)(Tools::getRequest('id_category_to_move'));
	$id_category_parent = (int)(Tools::getRequest('id_category_parent'));
	$way = (int)(Tools::getRequest('way'));
	$positions = Tools::getRequest('category');
	if (is_array($positions))
		foreach ($positions AS $key => $value)
		{
			$pos = explode('_', $value);
			if ((isset($pos[1]) AND isset($pos[2])) AND ($pos[1] == $id_category_parent AND $pos[2] == $id_category_to_move))
			{
				$position = $key;
				break;
			}
		}
	$category = new Category($id_category_to_move);
	if (Validate::isLoadedObject($category))
	{
		if (isset($position) && $category->updatePosition($way, $position))
			die(true);
		else
			die('{"hasError" : true, "errors" : "Can not update categories position"}');
	}
	else
		die('{"hasError" : true, "errors" : "This category can not be loaded"}');
}

/**
 * id_country_to_move 当前操作的行的country id值
 * way 操作行是向上则为0，向下则为1
 * country 是一个数组，它的每一项为这样的值,这个值是前端js排序处理后的最终结果，这个结果代表着新的排序信息.
 * tr_5_1,tr_6_2...  值为table下tr的id值，页tr的id为 tr_ + id_country + _ + position
 */
if (array_key_exists('ajaxCountryPositions', $_POST))
{

	$id_country_to_move = (int)(Tools::getRequest('id_country_to_move'));
	$way = (int)(Tools::getRequest('way'));
	$positions = Tools::getRequest('country');
	if (is_array($positions))
		foreach ($positions AS $key => $value)
		{
			$pos = explode('_', $value);
			if (isset($pos[1]) AND $pos[1] == $id_country_to_move)
			{
				$position = $key;
				break;
			}
		}
	$country = new Country($id_country_to_move);
	if (Validate::isLoadedObject($country))
	{
		if (isset($position) && $country->updatePosition($way, $position))
			die(true);
		else
			die('{"hasError" : true, "errors" : "Can not update cms countrys position"}');
	}
	else
		die('{"hasError" : true, "errors" : "This country can not be loaded"}');
}
/*Attribute Postion*/
if (array_key_exists('ajaxAttributePositions', $_POST))
{
	$id_attribute 	= (int)(Tools::getRequest('id_attribute'));
	$id_group 		= (int)(Tools::getRequest('id_group'));
	$way = (int)(Tools::getRequest('way'));
	$positions = Tools::getRequest('attribute_'.$id_group);
	if (is_array($positions))
		foreach ($positions AS $key => $value)
		{
			$pos = explode('_', $value);
			if ((isset($pos[1]) AND isset($pos[2])) AND ($pos[1] == $id_group AND $pos[2] == $id_attribute))
			{
				$position = $key;
				break;
			}
		}
	$attribute = new Attribute($id_attribute);
	if (Validate::isLoadedObject($attribute))
	{
		if (isset($position) && $attribute->updatePosition($way, $position))
			die(true);
		else
			die('{"hasError" : true, "errors" : "Can not update attribute position"}');
	}
	else
		die('{"hasError" : true, "errors" : "This attribute can not be loaded"}');
}