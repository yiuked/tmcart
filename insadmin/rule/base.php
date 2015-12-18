<?php

if(isset($_POST['saveBase']))
{
	if($shop_name = Tools::P('TM_SHOP_NAME'))
		Configuration::updateValue('TM_SHOP_NAME',$shop_name);
	if($shop_email = Tools::P('TM_SHOP_EMAIL'))
		Configuration::updateValue('TM_SHOP_EMAIL',$shop_email);
	if($shop_domain = Tools::P('TM_SHOP_DOMAIN'))
		Configuration::updateValue('TM_SHOP_DOMAIN',$shop_domain);
	if($pre_page = Tools::P('TM_PRODUCTS_PER_PAGE'))
		Configuration::updateValue('TM_PRODUCTS_PER_PAGE',$pre_page);
	if($page_list = Tools::P('TM_PRODUCTS_PER_PAGE_LIST'))
		Configuration::updateValue('TM_PRODUCTS_PER_PAGE_LIST',$page_list);
	if($id_country = Tools::P('TM_DEFAULT_COUNTRY_ID'))
		Configuration::updateValue('TM_DEFAULT_COUNTRY_ID',$id_country);
	UIAdminAlerts::conf('配置已更新');
}

if (isset($errors)) {
	UIAdminAlerts::MError($errors);
}

/** 导航 */
$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '系统设置', 'active' => true));
$breadcrumb->add(array('title' => '基本设置', 'active' => true));
$bread = $breadcrumb->draw();
$btn_group = array(
	array('type' => 'button', 'title' => '保存', 'id' => 'save-base-form', 'class' => 'btn-success', 'icon' => 'save') ,
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');
?>
<script language="javascript">
	$("#save-base-form").click(function(){
		$("#base-form").submit();
	})
</script>
<?php
$form = new UIAdminEditForm('post', 'index.php?rule=base', 'form-horizontal', 'base-form');
$result = Country::loadData(1,500);
$countrys = array();
foreach($result['items'] as $country) {
	$countrys[$country['id_country']] = $country['name'];
}

$form->items = array(
	'TM_SHOP_NAME' => array(
		'title' => '网站名称',
		'type' => 'text',
		'value' => Configuration::get('TM_SHOP_NAME'),
	),
	'TM_SHOP_DOMAIN' => array(
		'title' => '网站域名',
		'type' => 'text',
		'value' => Configuration::get('TM_SHOP_DOMAIN'),
	),
	'TM_DEFAULT_COUNTRY_ID' => array(
		'title' => '默认国家',
		'type' => 'select',
		'value' => Configuration::get('TM_DEFAULT_COUNTRY_ID'),
		'option' => $countrys,
	),
	'TM_SHOP_EMAIL' => array(
		'title' => '邮箱地址',
		'type' => 'text',
		'value' => Configuration::get('TM_SHOP_EMAIL'),
	),
	'TM_PRODUCTS_PER_PAGE' => array(
		'title' => '每页显示数量',
		'type' => 'text',
		'value' => Configuration::get('TM_PRODUCTS_PER_PAGE'),
	),
	'TM_PRODUCTS_PER_PAGE_LIST' => array(
		'title' => '允许每页显示',
		'type' => 'text',
		'value' => Configuration::get('TM_PRODUCTS_PER_PAGE_LIST'),
		'info' => '以逗号分隔，最好为每页显示的数量的公倍数.如:8,24,40'
	),
	'saveBase' => array(
		'type' => 'hidden',
		'value' => 'update',
	),
);
echo UIViewBlock::area(array('col' => 'col-md-12', 'title' => '编辑', 'body' => $form->draw()), 'panel');

