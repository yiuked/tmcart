<?php

if(intval(Tools::getRequest('delete'))>0){
	$object = new OrderStatus(intval(Tools::getRequest('delete')));
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
	$order	= new OrderStatus();
		if($order->deleteSelection($select_cat))
			echo '<div class="conf">删除对象成功</div>';

}elseif(Tools::getRequest('toggle') && intval(Tools::getRequest('id'))>0){
	$object = new OrderStatus((int)(Tools::getRequest('id')));
	if(Validate::isLoadedObject($object)){
		$object->toggle(Tools::getRequest('toggle'));
	}

	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		echo '<div class="conf">更新对象成功</div>';
	}
}

$table = new UIAdminTable('order_status',  'OrderStatus', 'id_order_status');
$table->header = array(
	array('sort' => false ,'isCheckAll' => 'itemsBox[]'),
	array('name' => 'id_order_status', 'title' => 'ID', 'width'=> '80px', 'filter' => 'string'),
	array('name' => 'name', 'title' => '状态', 'filter' => 'string', 'color' => true),
	array('name' => 'send_mail', 'title' => '发送邮件', 'filter' => 'bool'),
	array('name' => 'email_tpl', 'title' => '模板', 'filter' => 'string'),
	array('sort' => false , 'title' => '操作',  'class' => 'text-right',  'isAction'=> array( 'edit', 'delete')),
);
$filter = $table->initFilter();

$orderBy 	= isset($_GET['orderby']) ? Tools::G('orderby') : 'id_order_status';
$orderWay 	= isset($_GET['orderway']) ? Tools::G('orderway') : 'desc';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::G('p') ? (Tools::G('p') == 0 ? 1 : Tools::G('p')) : 1;

$result  	= OrderStatus::loadData($p, $limit, $orderBy, $orderWay, $filter);

if (isset($errors)) {
	UIAdminAlerts::MError($errors);
}

$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '定单状态', 'active' => true));
$bread = $breadcrumb->draw();
$btn_group = array(
	array('type' => 'a', 'title' => '新状态', 'href' => 'index.php?rule=order_status_edit', 'class' => 'btn-success', 'icon' => 'plus') ,
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');

$btn_group = array(
	array('type' => 'button', 'title' => '批量删除', 'confirm' => '你确定要删除选中项?', 'name' => 'deleteItems', 'class' => 'btn-danger', 'icon' => 'remove') ,
);
echo UIViewBlock::area(array('title' => '定单状态', 'table' => $table, 'result' => $result, 'limit' => $limit, 'btn_groups' => $btn_group), 'table');
?>
