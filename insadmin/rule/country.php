<?php
if(Tools::G('delete') > 0){
	$object = new Country(Tools::G('delete'));
	if(Validate::isLoadedObject($object)){
		$object->delete();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		UIAdminAlerts::conf('国家已删除');
	}
}elseif(Tools::isSubmit('subDelete')){
	$select_cat = Tools::P('categoryBox');
	$country	= new Country();
		if($country->deleteSelection($select_cat))
			UIAdminAlerts::conf('国家已删除');

}elseif(Tools::isSubmit('subActiveON') OR Tools::isSubmit('subActiveOFF')){
	$select_cat = Tools::getRequest('categoryBox');
	$action		= Tools::isSubmit('subActiveON')?1:0;
	$object		= new Country();
	if(is_array($select_cat)){
		if($object->statusSelection($select_cat,$action))
			UIAdminAlerts::conf('国家已更新');
	}
}

echo UIAdminDndTable::loadHead();
$table =  new UIAdminDndTable('country', 'Country', 'id_country');
$table->addAttribte('id', 'country');
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
