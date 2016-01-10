<?php

if(Tools::G('delete') > 0){
	$object = new Onepage(Tools::G('delete'));
	if(Validate::isLoadedObject($object)){
		$object->delete();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		UIAdminAlerts::conf('页面已删除');
	}
}

$table = new UIAdminTable('onepage',  'Onepage', 'id_onepage');
$table->header = array(
	array('sort' => false ,'isCheckAll' => 'itemsBox[]'),
	array('name' => 'id_onepage','title' => 'ID','filter' => 'string'),
	array('name' => 'view_name','title' => '示图名','filter' => 'string'),
	array('name' => 'meta_title','title' => 'Meta标题','filter' => 'string'),
	array('name' => 'rewrite','title' => 'URL','filter' => 'string'),
	array('name' => 'add_date','title' => '添加时间'),
	array('sort' => false ,'title' => '操作', 'class' => 'text-right', 'isAction'=> array('edit', 'delete')),
);
$filter = $table->initFilter();

$orderBy 	= isset($_GET['orderby']) ? Tools::G('orderby') : 'id_onepage';
$orderWay 	= isset($_GET['orderway']) ? Tools::G('orderway') : 'asc';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::G('p') ? (Tools::G('p') == 0 ? 1 : Tools::G('p')) : 1;

$result  	= Onepage::loadData($p, $limit, $orderBy, $orderWay, $filter);

/** 错误处理 */
if (isset($errors)) {
	UIAdminAlerts::MError($errors);
}

/** 导航 */
$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '系统设置', 'active' => true));
$breadcrumb->add(array('title' => '单面管理', 'active' => true));
$bread = $breadcrumb->draw();
$btn_group = array(
	array('type' => 'a', 'title' => '新页面', 'href' => 'index.php?rule=onepage_edit', 'class' => 'btn-success', 'icon' => 'plus') ,
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');

/** 列表输出 */
echo UIViewBlock::area(array('title' => '地址列表', 'table' => $table, 'result' => $result, 'limit' => $limit), 'table');