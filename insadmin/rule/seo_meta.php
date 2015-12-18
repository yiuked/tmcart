<?php

if(isset($_POST['SEOCateMetaUpdate']))
{
	if(isset($_POST['categoryBox']) && count($_POST['categoryBox']) > 0){
		SEOHelper::updateCategoryMeta($_POST);
	}
}

/** 错误处理 */
if (isset($errors)) {
	UIAdminAlerts::MError($errors);
}

/** 导航 */
$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('href' => 'index.php?rule=seo_meta', 'title' => 'Meta管理'));
$breadcrumb->add(array('title' => '编辑', 'active' => true));
$bread = $breadcrumb->draw();
$btn_group = array(
	array('type' => 'a', 'title' => '产品Metat管理', 'href' => 'index.php?rule=seo_meta_product', 'class' => 'btn-primary', 'icon' => 'share') ,
	array('type' => 'button', 'title' => '更新', 'id' => 'save-seo-meta-form', 'class' => 'btn-success', 'icon' => 'save') ,
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');

/** 构建表单 */
$form = new UIAdminEditForm('post', 'index.php?rule=seo_meta', 'form-horizontal', 'seo-meta-form');
$cate = array();
if(isset($_POST['categoryBox'])){
	$cate = Tools::getRequest('categoryBox');
}

$trads = array(
	'Home' 		=> '根分类',
	'selected' 	=> '选择',
	'Collapse All' => '关闭',
	'Expand All' 	=> '展开',
	'Check All'	=> '全选',
	'Uncheck All'	=> '全不选'
);

$form->items = array(
	'title' => array(
		'title' => 'Title规则',
		'type' => 'text',
		'value' => Tools::Q('title'),
		'info' => '可用参数:C_ID,C_NAME,{关键词1|关键词2|关键词3}'
	),
	'keywords' => array(
		'title' => 'Keywords规则',
		'type' => 'text',
		'value' => Tools::Q('keywords'),
		'info' => '可用参数:C_ID,C_NAME,{关键词1|关键词2|关键词3}'
	),
	'description' => array(
		'title' => 'Keywords',
		'type' => 'text',
		'value' => Tools::Q('description'),
		'info' => '可用参数:C_ID,C_NAME,{关键词1|关键词2|关键词3}'
	),
	'rewrite' => array(
		'title' => 'Keywords',
		'type' => 'text',
		'value' => Tools::Q('rewrite'),
		'info' => '可用参数:C_ID,C_NAME,{关键词1|关键词2|关键词3}'
	),
	'categoryBox' => array(
		'title' => '应用到分类',
		'type' => 'custom',
		'value' => Helper::renderAdminCategorieTree($trads,$cate, 'categoryBox', false,'Tree'),
	),
	'SEOCateMetaUpdate' => array(
		'type' => 'submit',
		'class' => 'btn-success',
		'icon' => 'save',
		'title' => '生成'
	),
);
echo UIViewBlock::area(array( 'title' => '编辑', 'body' => $form->draw()), 'panel');