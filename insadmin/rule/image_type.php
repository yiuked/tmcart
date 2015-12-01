<?php
if(intval(Tools::getRequest('delete'))>0){
	$object = new ImageType(intval(Tools::getRequest('delete')));
	if(Validate::isLoadedObject($object)){
		$object->delete();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		UIAdminAlerts::conf('图片类别已删除');
	}
}

$table = new UIAdminTable('image_type',  'ImageType', 'id_image_type');
$table->header = array(
	array('sort' => false ,'isCheckAll' => 'itemrBox[]'),
	array('name' => 'id_image_type','title' => 'ID','filter' => 'string'),
	array('name' => 'name','title' => '名称','filter' => 'string'),
	array('name' => 'width','title' => '宽度'),
	array('name' => 'height','title' => '高度'),
	array('name' => 'type','title' => '所属'),
	array('sort' => false ,'title' => '操作', 'class' => 'text-right', 'isAction'=> array( 'edit', 'delete')),
);

$filter = $table->initFilter();
$orderBy 	= isset($_GET['orderby']) ? Tools::G('orderby') : 'id_image_type';
$orderWay 	= isset($_GET['orderway']) ? Tools::G('orderway') : 'desc';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::G('p') ? (Tools::G('p') == 0 ? 1 : Tools::G('p')) : 1;

$result  	= ImageType::getEntity($p, $limit, $orderBy, $orderWay, $filter);

if (isset($errors)) {
	UIAdminAlerts::MError($errors);
}

$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '图片类别', 'active' => true));
$bread = $breadcrumb->draw();

$btn_group = array(
	array('type' => 'a', 'title' => '新类别', 'href' => 'index.php?rule=image_type_edit', 'class' => 'btn-success', 'icon' => 'plus') ,
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');
echo UIViewBlock::area(array('title' => '图片类别', 'table' => $table, 'result' => $result), 'table');