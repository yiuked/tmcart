<?php

if(intval(Tools::getRequest('delete'))>0){
	$object = new Paylog(intval(Tools::getRequest('delete')));
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
	$paylog	= new Paylog();
		if($paylog->deleteSelection($select_cat))
			echo '<div class="conf">删除对象成功</div>';

}

$table = new UIAdminTable('paylog',  'Paylog', 'id_pay');
$table->header = array(
	array('sort' => false ,'isCheckAll' => 'itemsBox[]'),
	array('name' => 'id_pay', 'title' => 'ID', 'width'=> '80px', 'filter' => 'string', 'edit' => false),
	array('name' => 'code', 'title' => '状态码', 'filter' => 'string', 'edit' => false),
	array('name' => 'msg', 'title' => '状态信息', 'filter' => 'string', 'edit' => false),
);
$filter = $table->initFilter();

$orderBy 	= isset($_GET['orderby']) ? Tools::G('orderby') : 'id_pay';
$orderWay 	= isset($_GET['orderway']) ? Tools::G('orderway') : 'desc';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::G('p') ? (Tools::G('p') == 0 ? 1 : Tools::G('p')) : 1;

$result  	= Paylog::loadData($p, $limit, $orderBy, $orderWay, $filter);

if (isset($errors)) {
	UIAdminAlerts::MError($errors);
}

$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '支付日志', 'active' => true));
$bread = $breadcrumb->draw();
echo UIViewBlock::area(array('bread' => $bread), 'breadcrumb');
$btn_group = array(
	array('type' => 'button', 'title' => '批量删除', 'confirm' => '你确定要删除选中项?', 'class' => 'btn-danger', 'icon' => 'remove') ,
);
echo UIViewBlock::area(array('title' => '支付日志', 'table' => $table, 'result' => $result, 'limit' => $limit, 'btn_groups' => $btn_group), 'table');
?>
