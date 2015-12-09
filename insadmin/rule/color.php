<?php
if(intval(Tools::getRequest('delete'))>0){
	$object = new Color(intval(Tools::getRequest('delete')));
	if(Validate::isLoadedObject($object)){
		$object->delete();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		UIAdminAlerts::conf('颜色已删除');
	}
}elseif(Tools::isSubmit('subDelete')){
	$select_cat = Tools::getRequest('categoryBox');
	$color	= new Color();
	if($color->deleteSelection($select_cat)){
		UIAdminAlerts::conf('颜色已删除');
	}
}
echo UIAdminDndTable::loadHead();
$table = new UIAdminDndTable('color',  'Color', 'id_color');
$table->addAttribte('id', 'color');
$table->header = array(
	array('sort' => false ,'isCheckAll' => 'colorBox[]'),
	array('name' => 'id_color','title' => 'ID'),
	array('name' => 'name','title' => '名称'),
	array('name' => 'code','title' => '颜色','color' => true),
	array('name' => 'position','title' => '排序'),
	array('sort' => false ,'title' => '操作', 'class' => 'text-right', 'isAction'=> array( 'edit', 'delete')),
);
$orderBy 	= isset($_GET['orderby']) ? Tools::G('orderby') : 'position';
$orderWay 	= isset($_GET['orderway']) ? Tools::G('orderway') : 'asc';
$result = Color::getEntitys($orderBy, $orderWay);

if (isset($errors)) {
	UIAdminAlerts::MError($errors);
}

$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '颜色', 'active' => true));
$bread = $breadcrumb->draw();

$btn_group = array(
	array('type' => 'a', 'title' => '取消关联', 'href' => 'index.php?rule=color_cannel_product', 'class' => 'btn-primary', 'icon' => 'level-up') ,
	array('type' => 'a', 'title' => '产品关联', 'href' => 'index.php?rule=color_product', 'class' => 'btn-primary', 'icon' => 'level-up') ,
	array('type' => 'a', 'title' => '新颜色', 'href' => 'index.php?rule=color_edit', 'class' => 'btn-success', 'icon' => 'plus') ,
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');
echo UIViewBlock::area(array('title' => '颜色', 'table' => $table, 'result' => $result), 'table');

