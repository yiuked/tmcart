<?php

if(Tools::G('delete') > 0){
	$object = new CMSTag(Tools::G('delete'));
	if(Validate::isLoadedObject($object)){
		$object->delete();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		UIAdminAlerts::conf('标签已删除');
	}
}elseif(Tools::isSubmit('subDelete')){
	$select_cat = Tools::P('categoryBox');
	$cmstag	= new CMSTag();
		if($cmstag->deleteSelection($select_cat))
			UIAdminAlerts::conf('标签已删除');

}

if (isset($errors)) {
	UIAdminAlerts::MError($errors);
}

$table =  new UIAdminTable('cms_tag', 'CMSTag', 'id_cms_tag');
$table->header = array(
	array('sort' => false, 'isCheckAll' => 'itemsBox[]','name' => 'id_cms_tag'),
	array('name' => 'id_cms_tag','title' => 'ID','filter' => 'string'),
	array('name' => 'name','title' => '名称','filter' => 'string'),
	array('name' => 'rewrite','title' => 'URL','filter' => 'string'),
	array('name' => 'add_date','title' => '添加时间'),
	array('sort' => false, 'title' => '操作', 'class' => 'text-right', 'isAction'=> array( 'edit', 'delete')),
);

$filter = $table->initFilter();
$orderBy 	= isset($_GET['orderby']) ? Tools::G('orderby') : 'id_cms_tag';
$orderWay 	= isset($_GET['orderway']) ? Tools::G('orderway') : 'desc';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::G('p') ? (Tools::G('p') == 0 ? 1 : Tools::G('p')) : 1;

$result  	= CMSTag::loadData($p, $limit, $orderBy, $orderWay, $filter);

$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => 'CMS', 'active' => true));
$bread = $breadcrumb->draw();
echo UIViewBlock::area(array('bread' => $bread), 'breadcrumb');

$btn_groups = array(
	array('type' => 'button', 'title' => '删除选中', 'confirm' => '确定要删除选中项?', 'name' => 'subDelete', 'btn_type' => 'submit', 'class' => 'btn-default'),
);
echo UIViewBlock::area(array('title' => 'Tag列表', 'table' => $table, 'result' => $result, 'limit' => $limit, 'btn_groups' => $btn_groups), 'table');
