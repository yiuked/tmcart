<?php

if(intval(Tools::getRequest('delete'))>0){
	$object = new Address(intval(Tools::getRequest('delete')));
	if(Validate::isLoadedObject($object)){
		$object->delete();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		UIAdminAlerts::conf('已删除地址');
	}
}elseif(Tools::isSubmit('subDelete')){
	$select_cat = Tools::getRequest('categoryBox');
	$address	= new Address();
		if($address->deleteSelection($select_cat))
			UIAdminAlerts::conf('已删除选中地址');

}

$table =  new UIAdminTable('address', 'Address', 'id_address');
$table->header = array(
	array('sort' => false, 'isCheckAll' => 'itemsBox[]','name' => 'id_address'),
	array('name' => 'id_address','title' => 'ID','filter' => 'string'),
	array('name' => 'name','title' => '昵称','filter' => 'string'),
	array('name' => 'country','title' => '国家','filter' => 'string'),
	array('name' => 'state','title' => '省/州','filter' => 'string'),
	array('name' => 'postcode','title' => '邮编','filter' => 'string'),
	array('name' => 'city','title' => '城市','filter' => 'string'),
	array('name' => 'phone','title' => '城市','filter' => 'string'),
	array('name' => 'add_date','title' => '添加时间'),
	array('sort' => false, 'title' => '操作', 'class' => 'text-right', 'isAction'=> array( 'edit', 'delete')),
);

$filter = $table->initFilter();
$orderBy 	= isset($_GET['orderby']) ? Tools::G('orderby') : 'id_address';
$orderWay 	= isset($_GET['orderway']) ? Tools::G('orderway') : 'desc';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::G('p') ? (Tools::G('p') == 0 ? 1 : Tools::G('p')) : 1;

$result  	= Address::getEntity($p, $limit, $orderBy, $orderWay, $filter);

if (isset($errors)) {
	UIAdminAlerts::MError($errors);
}

$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '地址', 'active' => true));
$bread = $breadcrumb->draw();
$btn_group = array(
	array('type' => 'a', 'title' => '新地址', 'href' => 'index.php?rule=address_edit', 'class' => 'btn-success', 'icon' => 'plus') ,
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');
$btn_group = array(
	array('type' => 'button', 'title' => '批量删除', 'confirm' => '你确定要删除选中项?', 'name' => 'deleteItems', 'class' => 'btn-danger', 'icon' => 'remove') ,
);
echo UIViewBlock::area(array('title' => '地址列表', 'table' => $table, 'result' => $result, 'limit' => $limit, 'btn_groups' => $btn_group), 'table');