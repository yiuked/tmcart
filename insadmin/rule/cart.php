<?php

if ( Tools::P('delete') > 0) {
	$object = new Cart(Tools::P('delete'));
	if(Validate::isLoadedObject($object)){
		$object->delete();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		UIAdminAlerts::conf('购物车已删除');
	}
} elseif(Tools::isSubmit('delSelected')) {
	$select_cat = Tools::P('itemsBox');
	$cart	= new Cart();
	if ($cart->deleteMulti($select_cat)){
		UIAdminAlerts::conf('购物车已删除');
	}
}

$table = new UIAdminTable('cart',  'Cart', 'id_cart');
$table->header = array(
	array('sort' => false ,'isCheckAll' => 'itemsBox[]'),
	array('name' => 'id_cart', 'title' => 'ID', 'width'=> '80px', 'filter' => 'string'),
	array('name' => 'name', 'title' => '用户', 'filter' => 'string'),
	array('sort' => false ,'name' => 'total_display', 'title' => '金额', 'width'=> '80px'),
	array('name' => 'carrier', 'title' => '物流', 'filter' => 'string'),
	array('sort' => 'shipping' ,'name' => 'shipping_display', 'title' => '运费'),
	array('sort' => 'status' ,'name' => 'status_label', 'title' => '状态', 'color' => true),
	array('name' => 'add_date', 'title' => '添加时间'),
	array('sort' => false , 'title' => '操作',  'class' => 'text-right',  'isAction'=> array( 'edit', 'delete')),
);
$filter = $table->initFilter();

$orderBy 	= isset($_GET['orderby']) ? Tools::G('orderby') : 'id_cart';
$orderWay 	= isset($_GET['orderway']) ? Tools::G('orderway') : 'desc';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::G('p') ? (Tools::G('p') == 0 ? 1 : Tools::G('p')) : 1;

$result  	= Cart::loadData($p, $limit, $orderBy, $orderWay, $filter);

if (isset($errors)) {
	UIAdminAlerts::MError($errors);
}

$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '购物车', 'active' => true));
$bread = $breadcrumb->draw();
echo UIViewBlock::area(array('bread' => $bread), 'breadcrumb');

$btn_group = array(
	array('type' => 'button', 'title' => '删除选中','confirm' => '确定要删除选中项?', 'name' => 'delSelected', 'btn_type' => 'submit', 'class' => 'btn-danger') ,
);
echo UIViewBlock::area(array('title' => '用户留言', 'table' => $table, 'result' => $result, 'limit' => $limit, 'btn_groups' => $btn_group), 'table');