<?php
$id 		= Tools::getRequest('id')?Tools::getRequest('id'):1;
$category 	= new CMSCategory($id);
$filter		= array();

if(intval(Tools::getRequest('delete'))>0){
	$object = new CMSCategory(intval(Tools::getRequest('delete')));
	if(Validate::isLoadedObject($object)){
		$object->delete();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		echo '<div class="conf">删除分类成功</div>';
	}
}elseif(Tools::isSubmit('subDelete')){
	$select_cat = Tools::getRequest('categoryBox');
	if(Validate::isLoadedObject($category) AND is_array($select_cat)){
		$category->deleteSelection($select_cat);
	}
	
	if(is_array($category->_errors) AND count($category->_errors)>0){
		$errors = $category->_errors;
	}else{
		echo '<div class="conf">删除分类成功</div>';
	}
}elseif(intval(Tools::getRequest('toggleStatus'))>0){
	$object = new CMSCategory(intval(Tools::getRequest('toggleStatus')));
	if(Validate::isLoadedObject($object)){
		$object->toggleStatus();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		echo '<div class="conf">更新分类状态成功</div>';
	}
}elseif(Tools::isSubmit('subActiveON') OR Tools::isSubmit('subActiveOFF')){
	$select_cat = Tools::getRequest('categoryBox');
	$action		= Tools::isSubmit('subActiveON')?1:0;
	$object		= new CMSCategory();
	if(is_array($select_cat)){
		if($object->statusSelection($select_cat,$action))
			echo '<div class="conf">更新分类状态成功</div>';
	}
}elseif (isset($_GET['position'])){
	if (!Validate::isLoadedObject($object = new CMSCategory((int)(Tools::getRequest('id_category_to_move')))))
		$errors[] = '无法输入对象';
	if (!$object->updatePosition((int)(Tools::getRequest('way')), (int)(Tools::getRequest('position'))))
		$errors[] = '更新排序失败';
	else {
		echo '<div class="conf">更新排序成功</div>';
	}
}

echo UIAdminDndTable::loadHead();
$table = new UIAdminDndTable('cms_category',  'CMSCategory', 'id_cms_category');
$table->addAttribte('id', 'cms_category');
$table->parent = 'id_parent';
$table->child = true;
$table->header = array(
	array('sort' => false ,'isCheckAll' => 'categoryBox[]'),
	array('name' => 'id_cms_category','title' => 'ID','filter' => 'string'),
	array('name' => 'name','title' => '名称','filter' => 'string'),
	array('name' => 'active','title' => '状态','filter' => 'bool'),
	array('name' => 'position','title' => '排序'),
	array('name' => 'add_date','title' => '添加时间'),
	array('sort' => false ,'title' => '操作', 'class' => 'text-right', 'isAction'=> array( 'edit','view', 'delete')),
);
$filter = $table->initFilter();
$orderBy 	= isset($_GET['orderby']) ? Tools::G('orderby') : 'position';
$orderWay 	= isset($_GET['orderway']) ? Tools::G('orderway') : 'asc';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::G('p') ? (Tools::G('p') == 0 ? 1 : Tools::G('p')) : 1;

$result  	= $category->getSubCMSCategories($limit, $p, $orderBy, $orderWay, $filter);
$catBar = $category->getCatBar($category->id);
krsort($catBar);

if (isset($errors)) {
	UIAdminAlerts::MError($errors);
}

//导航
$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '分类', 'active' => true));
$bread = $breadcrumb->draw();
$btn_group = array();
if ($id > 1) {
	$btn_group[] = array('type' => 'a', 'title' => '上级', 'href' => 'index.php?rule=cms_category&id=' . $category->id_parent , 'class' => 'btn-primary', 'icon' => 'level-up') ;
}
$btn_group[] = array('type' => 'a', 'title' => '新分类', 'href' => 'index.php?rule=cms_category_edit', 'class' => 'btn-success', 'icon' => 'plus');
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');

//表头导航
$catalogPath = new UIAdminBreadcrumb();
foreach ($catBar as $Bar) {
	if ($category->id == $Bar['id_cms_category']) {
		$catalogPath->add(array('title' => $category->name, 'active' => true));
	} else {
		$catalogPath->add(array('href' => 'index.php?rule=cms_category&id=' . $Bar['id_cms_category'], 'title' => $Bar['name']));
	}
}
$panelHead =  $catalogPath->draw();

//生成表格
$btn_groups = array(
	array('type' => 'button', 'title' => '删除选中', 'confirm' => '确定要删除选中项?', 'name' => 'subDelete', 'btn_type' => 'submit', 'class' => 'btn-default'),
	array('type' => 'button', 'title' => '激活选中',  'name' => 'subActiveON', 'btn_type' => 'submit', 'class' => 'btn-default'),
	array('type' => 'button', 'title' => '关闭选中',  'name' => 'subActiveOFF', 'btn_type' => 'submit', 'class' => 'btn-default'),
);
echo UIViewBlock::area(array('title' => $panelHead, 'table' => $table, 'result' => $result, 'limit' => $limit, 'btn_groups' => $btn_groups), 'table');