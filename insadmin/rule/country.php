<?php
if(intval(Tools::getRequest('delete'))>0){
	$object = new Country(intval(Tools::getRequest('delete')));
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
	$country	= new Country();
		if($country->deleteSelection($select_cat))
			echo '<div class="conf">删除对象成功</div>';

}elseif(Tools::getRequest('toggle') && intval(Tools::getRequest('id'))>0){
	$object = new Country((int)(Tools::getRequest('id')));
	if(Validate::isLoadedObject($object)){
		$object->toggle(Tools::getRequest('toggle'));
	}

	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		echo '<div class="conf">更新对象成功</div>';
	}
}elseif(Tools::isSubmit('subActiveON') OR Tools::isSubmit('subActiveOFF')){
	$select_cat = Tools::getRequest('categoryBox');
	$action		= Tools::isSubmit('subActiveON')?1:0;
	$object		= new Country();
	if(is_array($select_cat)){
		if($object->statusSelection($select_cat,$action))
			echo '<div class="conf">更新对象成功</div>';
	}
}

UIAdminDndTable::loadHead();
$table =  new UIAdminDndTable('country', 'Country', 'id_country');
$table->header = array(
	array('sort' => false, 'isCheckAll' => 'itemsBox[]','name' => 'id_country'),
	array('name' => 'id_country','title' => 'ID','filter' => 'string'),
	array('name' => 'name','title' => '国家','filter' => 'string'),
	array('name' => 'need_state','title' => '省/州','filter' => 'bool'),
	array('name' => 'active','title' => '状态','filter' => 'bool'),
	array('name' => 'position','title' => '排序'),
	array('sort' => false, 'title' => '操作', 'class' => 'text-right', 'isAction'=> array( 'edit', 'delete')),
);

$filter = $table->initFilter();
$orderBy 	= isset($_GET['orderby']) ? Tools::G('orderby') : 'position';
$orderWay 	= isset($_GET['orderway']) ? Tools::G('orderway') : 'asc';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::G('p') ? (Tools::G('p') == 0 ? 1 : Tools::G('p')) : 1;

$result  	= Country::loadData($p, $limit, $orderBy, $orderWay, $filter);

if (isset($errors)) {
	UIAdminAlerts::MError($errors);
}

$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '国家', 'active' => true));
$bread = $breadcrumb->draw();
$btn_group = array(
	array('type' => 'a', 'title' => '新国家', 'href' => 'index.php?rule=country_edit', 'class' => 'btn-success', 'icon' => 'plus') ,
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');
$btn_group = array(
	array('type' => 'button', 'title' => '批量删除', 'confirm' => '你确定要删除选中项?', 'name' => 'deleteItems', 'class' => 'btn-danger', 'icon' => 'remove') ,
);
echo UIViewBlock::area(array('title' => '国家列表', 'table' => $table, 'result' => $result, 'limit' => $limit, 'btn_groups' => $btn_group), 'table');
