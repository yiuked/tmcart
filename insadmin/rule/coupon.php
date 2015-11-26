<?php

if(intval(Tools::getRequest('delete'))>0){
	$object = new Coupon(intval(Tools::getRequest('delete')));
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
	$coupon	= new Coupon();
		if($coupon->deleteSelection($select_cat))
			echo '<div class="conf">删除对象成功</div>';

}elseif(intval(Tools::getRequest('toggleStatus'))>0){
	$object = new Coupon(intval(Tools::getRequest('toggleStatus')));
	if(Validate::isLoadedObject($object)){
		$object->toggleStatus();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		echo '<div class="conf">更新分类状态成功</div>';
	}
}

$table = new UIAdminTable('coupon',  'Coupon', 'id_coupon');
$table->header = array(
	array('sort' => false ,'isCheckAll' => 'itemsBox[]'),
	array('name' => 'id_coupon', 'title' => 'ID', 'width'=> '80px', 'filter' => 'string'),
	array('name' => 'id_user', 'title' => '状态码', 'filter' => 'string'),
	array('name' => 'off', 'title' => '状态信息', 'filter' => 'string'),
	array('name' => 'amount', 'title' => '状态信息', 'filter' => 'string'),
	array('name' => 'active', 'title' => '状态信息', 'filter' => 'string'),
	array('name' => 'add_date', 'title' => '状态信息', 'filter' => 'string'),
	array('sort' => false , 'title' => '操作',  'class' => 'text-right',  'isAction'=> array( 'edit', 'delete')),
);
$filter = $table->initFilter();

$orderBy 	= isset($_GET['orderby']) ? Tools::G('orderby') : 'id_coupon';
$orderWay 	= isset($_GET['orderway']) ? Tools::G('orderway') : 'desc';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::G('p') ? (Tools::G('p') == 0 ? 1 : Tools::G('p')) : 1;

$result  	= Coupon::getEntity($p,$limit,$orderBy,$orderWay,$filter);

if (isset($errors)) {
	UIAdminAlerts::MError($errors);
}

$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '优惠码', 'active' => true));
$bread = $breadcrumb->draw();
echo UIViewBlock::area(array('bread' => $bread), 'breadcrumb');
$btn_group = array(
	array('type' => 'button', 'title' => '批量删除', 'confirm' => '你确定要删除选中项?', 'class' => 'btn-danger', 'icon' => 'remove') ,
);
echo UIViewBlock::area(array('title' => '优惠码', 'table' => $table, 'result' => $result, 'limit' => $limit, 'btn_groups' => $btn_group), 'table');