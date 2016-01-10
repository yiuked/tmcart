<?php

if(Tools::G('delete') > 0){
	$attributeGroup = new AttributeGroup(Tools::G('delete'));
	if(Validate::isLoadedObject($attributeGroup)){
		$attributeGroup->delete();
	}

	if(is_array($attributeGroup->_errors) AND count($attributeGroup->_errors)>0){
		$errors = $attributeGroup->_errors;
	}else{
		UIAdminAlerts::conf('商品特征已删除');
	}
}elseif(Tools::isSubmit('delSelected')){
	$select_cat = Tools::P('itemsBox');
	$attributeGroup	= new AttributeGroup();
	if($attributeGroup->deleteMulti($select_cat)){
		UIAdminAlerts::conf('商品特征已删除');
	}
}

/** 初始化表格 */
echo UIAdminDndTable::loadHead();
$table = new UIAdminDndTable('attribute_group',  'AttributeGroup', 'id_attribute_group');
$table->addAttribte('id', 'feature');
$table->header = array(
	array('sort' => false ,'isCheckAll' => 'itemsBox[]'),
	array('name' => 'id_attribute_group','title' => 'ID','filter' => 'string', 'rule' => 'attribute'),
	array('name' => 'name','title' => '名称','filter' => 'string' ,'rule' => 'attribute'),
	array('name' => 'position','title' => '排序'),
	array('sort' => false ,'title' => '操作', 'width' => '120px', 'class' => 'text-right', 'isAction'=> array('edit', 'delete')),
);
$filter = $table->initFilter();

$orderBy 	= isset($_GET['orderby']) ? Tools::G('orderby') : 'position';
$orderWay 	= isset($_GET['orderway']) ? Tools::G('orderway') : 'asc';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::G('p') ? (Tools::G('p') == 0 ? 1 : Tools::G('p')) : 1;

$result  	= AttributeGroup::loadData($p, $limit, $orderBy, $orderWay, $filter);

/** 错误处理 */
if (isset($errors)) {
	UIAdminAlerts::MError($errors);
}

/** 输出导航 */
$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '属性', 'active' => true));
$bread = $breadcrumb->draw();

$btn_group = array(
	array('type' => 'a', 'title' => '新属性组', 'href' => 'index.php?rule=attribute_group_edit', 'class' => 'btn-success', 'icon' => 'plus') ,
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');

/** 输出属性组 */
$btn_group = array(
	array('type' => 'button', 'title' => '删除选中','confirm' => '确定要删除选中项?', 'name' => 'delSelected', 'btn_type' => 'submit', 'class' => 'btn-danger') ,
);
echo UIViewBlock::area(array('title' => '用户留言', 'table' => $table, 'result' => $result, 'limit' => $limit, 'btn_groups' => $btn_group), 'table');