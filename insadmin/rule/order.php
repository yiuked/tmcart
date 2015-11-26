<?php

if(intval(Tools::getRequest('delete'))>0){
	$object = new Order(intval(Tools::getRequest('delete')));
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
	$order	= new Order();
		if($order->deleteSelection($select_cat))
			echo '<div class="conf">删除对象成功</div>';

}elseif(intval(Tools::getRequest('toggleStatus'))>0){
	$object = new Order(intval(Tools::getRequest('toggleStatus')));
	if(Validate::isLoadedObject($object)){
		$object->toggleStatus();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		echo '<div class="conf">更新对象状态成功</div>';
	}
}

$table = new UIAdminTable('order',  'Order', 'id_order');
$table->header = array(
	array('sort' => false ,'isCheckAll' => 'orderBox[]'),
	array('name' => 'id_order', 'title' => 'ID', 'width'=> '80px', 'filter' => 'string'),
	array('name' => 'reference', 'title' => '引用', 'width'=> '110px', 'filter' => 'string'),
	array('name' => 'name', 'title' => '用户', 'filter' => 'string'),
	array('name' => 'amount', 'title' => '金额', 'width'=> '80px', 'filter' => 'string'),
	array('name' => 'carrier', 'title' => '物流', 'filter' => 'string'),
	array('name' => 'payment', 'title' => '支付', 'filter' => 'string'),
	array('name' => 'status', 'title' => '状态', 'filter' => 'string', 'color' => true),
	array('name' => 'add_date', 'title' => '添加时间'),
	array('sort' => false , 'title' => '操作',  'class' => 'text-right',  'isAction'=> array( 'edit', 'delete')),
);
$filter = $table->initFilter();

$orderBy 	= isset($_GET['orderby']) ? Tools::G('orderby') : 'id_order';
$orderWay 	= isset($_GET['orderway']) ? Tools::G('orderway') : 'desc';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::G('p') ? (Tools::G('p') == 0 ? 1 : Tools::G('p')) : 1;

$result  	= Order::getEntity(false,$p,$limit,$orderBy,$orderWay,$filter);

if (isset($errors)) {
	UIAdminAlerts::MError($errors);
}
$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '定单', 'active' => true));
$bread = $breadcrumb->draw();
$btn_group = array(
	array('type' => 'a', 'title' => '定单提交配置', 'href' => 'index.php?rule=sendorder', 'class' => 'btn-success', 'icon' => 'wrench') ,
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');
$btn_group = array(
	array('type' => 'button', 'title' => '批量删除', 'confirm' => '你确定要删除选中项?', 'name' => 'deleteItems', 'class' => 'btn-danger', 'icon' => 'remove') ,
);
echo UIViewBlock::area(array('title' => '定单状态', 'table' => $table, 'result' => $result, 'limit' => $limit, 'btn_groups' => $btn_group), 'table');