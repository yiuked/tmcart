<?php

if(Tools::G('delete') > 0){
	$object = new Employee(Tools::G('delete'));
	if(Validate::isLoadedObject($object)){
		$object->delete();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		UIAdminAlerts::conf('管理员已删除');
	}
}

$table =  new UIAdminTable('employee', 'Employee', 'id_employee');
$table->header = array(
	array('sort' => false, 'isCheckAll' => 'itemsBox[]','name' => 'id_employee'),
	array('name' => 'id_employee','title' => 'ID','filter' => 'string'),
	array('name' => 'name','title' => '昵称','filter' => 'string'),
	array('name' => 'email','title' => 'Email','filter' => 'string'),
	array('name' => 'active','title' => '状态','filter' => 'bool'),
	array('name' => 'upd_date','title' => '最后登录'),
	array('sort' => false, 'title' => '操作', 'class' => 'text-right', 'isAction'=> array( 'edit', 'delete')),
);

$filter = $table->initFilter();
$orderBy 	= isset($_GET['orderby']) ? Tools::G('orderby') : 'id_employee';
$orderWay 	= isset($_GET['orderway']) ? Tools::G('orderway') : 'asc';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::G('p') ? (Tools::G('p') == 0 ? 1 : Tools::G('p')) : 1;

$result  	= Employee::loadData($p, $limit, $orderBy, $orderWay, $filter);

$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '管理员', 'active' => true));
$bread = $breadcrumb->draw();
$btn_group = array(
	array('type' => 'a', 'title' => '新管理员', 'href' => 'index.php?rule=employee_edit', 'class' => 'btn-success', 'icon' => 'plus') ,
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');
echo UIViewBlock::area(array('title' => '管理员列表', 'table' => $table, 'result' => $result, 'limit' => $limit), 'table');