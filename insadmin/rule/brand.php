<?php

if(intval(Tools::getRequest('delete'))>0){
	$object = new Brand(intval(Tools::getRequest('delete')));
	if(Validate::isLoadedObject($object)){
		$object->delete();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		echo '<div class="conf">删除对象成功</div>';
	}
}elseif(Tools::isSubmit('subDelete')){
	$select_cat = Tools::getRequest('categoryBox');
	$brand	= new Brand();
		if($brand->deleteSelection($select_cat))
			echo '<div class="conf">删除对象成功</div>';

}elseif(intval(Tools::getRequest('toggleStatus'))>0){
	$object = new Brand(intval(Tools::getRequest('toggleStatus')));
	if(Validate::isLoadedObject($object)){
		$object->toggleStatus();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		echo '<div class="conf">更新对象状态成功</div>';
	}
}

$table = new UIAdminTable('brand',  'Brand', 'id_brand');
$table->header = array(
	array('sort' => false ,'isCheckAll' => 'brandBox[]'),
	array('name' => 'id_brand','title' => 'ID','filter' => 'string'),
	array('sort' => false ,'name' => 'image_small','isImage' => true,'title' => '图片'),
	array('name' => 'name','title' => '名称','filter' => 'string'),
	array('name' => 'active','title' => '状态','filter' => 'bool'),
	array('sort' => false ,'title' => '操作', 'class' => 'text-right', 'isAction'=> array('edit', 'view', 'delete')),
);
$filter = $table->initFilter();

$orderBy 	= isset($_GET['orderby']) ? Tools::G('orderby') : 'id_brand';
$orderWay 	= isset($_GET['orderway']) ? Tools::G('orderway') : 'asc';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::G('p') ? (Tools::G('p') == 0 ? 1 : Tools::G('p')) : 1;

$result  	= Brand::loadData($p, $limit, $orderBy, $orderWay, $filter);

if (isset($errors)) {
	UIAdminAlerts::MError($errors);
}

$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '购物车', 'active' => true));
$bread = $breadcrumb->draw();
$btn_groups = array(
	array('type' => 'a', 'title' => '新分类', 'href' => 'index.php?rule=category_edit', 'class' => 'btn-success', 'icon' => 'plus')
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_groups), 'breadcrumb');

$btn_group = array(
	array('type' => 'button', 'title' => '批量删除', 'confirm' => '你确定要删除选中项?', 'name' => 'deleteItems', 'class' => 'btn-danger', 'icon' => 'remove') ,
	array('type' => 'button', 'title' => '批量启用', 'name' => 'subActiveON', 'class' => 'btn-default') ,
	array('type' => 'button', 'title' => '批量关闭', 'name' => 'subActiveOFF', 'class' => 'btn-default') ,
);
echo UIViewBlock::area(array('title' => '地址列表', 'table' => $table, 'result' => $result, 'limit' => $limit, 'btn_groups' => $btn_group), 'table');