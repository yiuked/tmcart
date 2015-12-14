<?php

if(Tools::G('delete') > 0){
	$object = new CMSComment(Tools::G('delete'));
	if(Validate::isLoadedObject($object)){
		$object->delete();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		UIAdminAlerts::conf('评论已删除');
	}
}elseif(Tools::isSubmit('subDelete')){
	$select_cat = Tools::P('categoryBox');
	$cmscomment	= new CMSComment();
		if($cmscomment->deleteSelection($select_cat))
			UIAdminAlerts::conf('评论已删除');
}elseif(Tools::isSubmit('subActiveON') OR Tools::isSubmit('subActiveOFF')){
	$select_cat = Tools::P('itemBox');
	$action		= Tools::isSubmit('subActiveON')?1:0;
	$object		= new CMSComment();
	if(is_array($select_cat)){
		if($object->statusSelection($select_cat,$action))
			UIAdminAlerts::conf('文章已更新');
	}
}

$table = new UIAdminTable('cms_comment',  'CMSComment', 'id_cms_comment');
$table->header = array(
	array(
		'sort' => false ,
		'isCheckAll' => 'itemBox[]',
	),
	array(
		'name' => 'id_cms_comment',
		'title' => 'ID',
		'filter' => 'string'
	),
	array(
		'name' => 'name',
		'title' => '访客',
		'filter' => 'string'
	),
	array(
		'name' => 'email',
		'title' => '邮箱',
		'filter' => 'string'
	),
	array(
		'name' => 'active',
		'title' => '状态',
		'filter' => 'bool'
	),
	array(
		'name' => 'comment',
		'title' => '内容',
	),
	array(
		'name' => 'add_date',
		'title' => '时间',
	),
	array(
		'sort' => false ,
		'title' => '操作',
		'class' => 'text-right',
		'isAction'=> array('delete')
	),
);

$filter = $table->initFilter();
$orderBy 	= isset($_GET['orderby']) ? Tools::G('orderby') : 'id_cms_comment';
$orderWay 	= isset($_GET['orderway']) ? Tools::G('orderway') : 'desc';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::G('p') ? (Tools::G('p') == 0 ? 1 : Tools::G('p')) : 1;

$result  	= CMSComment::loadData($p, $limit, $orderBy, $orderWay, $filter);

//导航
$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '访客评论', 'active' => true));
$bread = $breadcrumb->draw();
echo UIViewBlock::area(array('bread' => $bread), 'breadcrumb');

if (isset($errors)) {
	UIAdminAlerts::MError($errors);
}
$btn_group = array(
	array('type' => 'button', 'title' => '删除选中','confirm' => '确定要删除选中项?', 'name' => 'subDelete', 'btn_type' => 'submit', 'class' => 'btn-danger') ,
	array('type' => 'button', 'title' => '激活选中', 'name' => 'subActiveON',  'btn_type' => 'submit','class' => 'btn-default') ,
	array('type' => 'button', 'title' => '关闭选中', 'name' => 'subActiveOFF', 'btn_type' => 'submit', 'class' => 'btn-default') ,
);
echo UIViewBlock::area(array('title' => '文章', 'table' => $table, 'result' => $result, 'btn_groups' => $btn_group), 'table');
