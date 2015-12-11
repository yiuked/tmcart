<?php

if(intval(Tools::getRequest('delete'))>0){
	$object = new Feedback(intval(Tools::getRequest('delete')));
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
	$feedbacks	= new Feedback();
		if($feedbacks->deleteSelection($select_cat))
			echo '<div class="conf">删除对象成功</div>';

}elseif(Tools::isSubmit('subShowProductPage')){
	$select_cat = Tools::getRequest('categoryBox');
	$feedbacks	= new Feedback();
		if($feedbacks->statusSelection($select_cat,true))
			echo '<div class="conf">启用对象成功</div>';

}

$table = new UIAdminTable('feedback',  'Feedback', 'id_feedback');
$table->header = array(
	array('sort' => false ,'isCheckAll' => 'categoryBox[]'),
	array('name' => 'name','title' => 'ID','filter' => 'string'),
	array('name' => 'flag_code','title' => '国家','filter' => 'string'),
	array('name' => 'id_product','title' => '产品ID','filter' => 'string'),
	array('name' => 'rating','title' => '评分','filter' => 'string'),
	array('name' => 'feedback','title' => '内容'),
	array('name' => 'add_date','title' => '时间'),
	array('sort' => false ,'title' => '操作', 'class' => 'text-right','width' => '120px', 'isAction'=> array('delete')),
);
$filter = $table->initFilter();
$orderBy 	= isset($_GET['orderby']) ? Tools::G('orderby') : 'id_feedback';
$orderWay 	= isset($_GET['orderway']) ? Tools::G('orderway') : 'asc';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::G('p') ? (Tools::G('p') == 0 ? 1 : Tools::G('p')) : 1;

$result  	= Feedback::loadData($p, $limit, $orderBy, $orderWay, $filter);

require_once(dirname(__FILE__).'/../errors.php');
?>
<?php
$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '客户反馈', 'active' => true));
$bread = $breadcrumb->draw();

$btn_group = array(
	array('type' => 'a', 'title' => '批量导入', 'href' => 'index.php?rule=feedback_import', 'class' => 'btn-primary', 'icon' => 'random') ,
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');
$btn_group = array(
	array('type' => 'button', 'title' => '批量删除', 'confirm' => '你确定要删除选中项?', 'name' => 'deleteItems', 'class' => 'btn-danger', 'icon' => 'remove') ,
	array('type' => 'button', 'title' => '批量启用',  'name' => 'subActiveON', 'class' => 'btn-default') ,
	array('type' => 'button', 'title' => '批量关闭',  'name' => 'subActiveOFF', 'class' => 'btn-default') ,
);
echo UIViewBlock::area(array('title' => '用户列表', 'table' => $table, 'result' => $result, 'limit' => $limit, 'btn_groups' => $btn_group), 'table');
?>