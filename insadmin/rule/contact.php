<?php

if(intval(Tools::getRequest('delete'))>0){
	$object = new Contact(intval(Tools::getRequest('delete')));
	if(Validate::isLoadedObject($object)){
		$object->delete();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		echo '<div class="conf">删除留言成功</div>';
	}
}elseif(Tools::isSubmit('subDelete')){
	$select_cat = Tools::getRequest('categoryBox');
	$contact	= new Contact();
		if($contact->deleteSelection($select_cat))
			echo '<div class="conf">删除留言成功</div>';

}elseif(intval(Tools::getRequest('toggleStatus'))>0){
	$object = new Contact(intval(Tools::getRequest('toggleStatus')));
	if(Validate::isLoadedObject($object)){
		$object->toggleStatus();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		echo '<div class="conf">更新留言状态成功</div>';
	}
}

$table = new UIAdminTable('contact',  'Contact', 'id_contact');
$table->header = array(
	array('sort' => false ,'isCheckAll' => 'itemBox[]'),
	array('name' => 'id_contact','title' => 'ID','filter' => 'string'),
	array('name' => 'name','title' => '名称','filter' => 'string'),
	array('name' => 'email','title' => '邮箱','filter' => 'string'),
	array('name' => 'subject','title' => '主题','filter' => 'string'),
	array('name' => 'content','title' => '内容','filter' => 'string'),
	array('name' => 'active','title' => '状态','filter' => 'bool'),
	array('sort' => false ,'title' => '操作', 'width' => '120px', 'class' => 'text-right', 'isAction'=> array('edit', 'delete')),
);
$filter = $table->initFilter();

$orderBy 	= isset($_GET['orderby']) ? Tools::G('orderby') : 'id_contact';
$orderWay 	= isset($_GET['orderway']) ? Tools::G('orderway') : 'asc';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::G('p') ? (Tools::G('p') == 0 ? 1 : Tools::G('p')) : 1;

$result  	= Contact::loadData($p, $limit, $orderBy, $orderWay, $filter);

if (isset($errors)) {
	UIAdminAlerts::MError($errors);
}

$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '客户留言', 'active' => true));
$bread = $breadcrumb->draw();
echo UIViewBlock::area(array('bread' => $bread), 'breadcrumb');

$btn_group = array(
	array('type' => 'button', 'title' => '删除选中','confirm' => '确定要删除选中项?', 'name' => 'subDelete', 'btn_type' => 'submit', 'class' => 'btn-danger') ,
);
echo UIViewBlock::area(array('title' => '用户留言', 'table' => $table, 'result' => $result, 'limit' => $limit, 'btn_groups' => $btn_group), 'table');