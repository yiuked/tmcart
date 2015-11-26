<?php

if(intval(Tools::getRequest('delete'))>0){
	$object = new User(intval(Tools::getRequest('delete')));
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
	$user	= new User();
	if($user->deleteSelection($select_cat))
		echo '<div class="conf">删除对象成功</div>';

}elseif(intval(Tools::getRequest('toggleStatus'))>0){
	$object = new User(intval(Tools::getRequest('toggleStatus')));
	if(Validate::isLoadedObject($object)){
		$object->toggleStatus();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		echo '<div class="conf">更新对象状态成功</div>';
	}
}

$table =  new UIAdminTable('user', 'User', 'id_user');
$table->header = array(
	array('sort' => false, 'isCheckAll' => 'itemsBox[]','name' => 'id_user'),
	array('name' => 'id_user','title' => 'ID','filter' => 'string'),
	array('name' => 'name','title' => '昵称','filter' => 'string'),
	array('name' => 'email','title' => '邮箱','filter' => 'string'),
	array('name' => 'active','title' => '状态','filter' => 'bool'),
	array('name' => 'upd_date','title' => '最后登录'),
	array('name' => 'add_date','title' => '注册时间'),
	array('sort' => false, 'title' => '操作', 'class' => 'text-right', 'isAction'=> array( 'edit', 'delete')),
);

$filter = $table->initFilter();
$orderBy 	= isset($_GET['orderby']) ? Tools::G('orderby') : 'id_user';
$orderWay 	= isset($_GET['orderway']) ? Tools::G('orderway') : 'desc';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::G('p') ? (Tools::G('p') == 0 ? 1 : Tools::G('p')) : 1;

$result  	= User::getEntitys($p,$limit,$orderBy,$orderWay,$filter);
if (isset($errors)) {
	UIAdminAlerts::MError($errors);
}
$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '用户', 'active' => true));
$bread = $breadcrumb->draw();
$btn_group = array(
	array('type' => 'a', 'title' => '新用户', 'href' => 'index.php?rule=user_add', 'class' => 'btn-success', 'icon' => 'plus') ,
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');
$btn_group = array(
	array('type' => 'button', 'title' => '批量删除', 'confirm' => '你确定要删除选中项?', 'name' => 'deleteItems', 'class' => 'btn-danger', 'icon' => 'remove') ,
);
echo UIViewBlock::area(array('title' => '用户列表', 'table' => $table, 'result' => $result, 'limit' => $limit, 'btn_groups' => $btn_group), 'table');