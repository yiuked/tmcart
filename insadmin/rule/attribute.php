<?php
if(Tools::G('delete') > 0){
    $attribute = new Attribute(Tools::G('delete'));
    if(Validate::isLoadedObject($attribute)){
        $attribute->delete();
    }

    if(is_array($attribute->_errors) AND count($attribute->_errors)>0){
        $errors = $attribute->_errors;
    }else{
        UIAdminAlerts::conf('商品特征值已删除');
    }
}elseif(Tools::isSubmit('delSelected')){
    $select_cat = Tools::P('itemsBox');
    $attribute	= new Attribute();
    if($attribute->deleteMulti($select_cat))
        UIAdminAlerts::conf('商品特征值已删除');

}

/** 输出错误信息 */
if (isset($errors)) {
    UIAdminAlerts::MError($errors);
}

/** 导航 */
$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '属性组', 'href' => 'index.php?rule=attribute_group'));
$breadcrumb->add(array('title' => '属性值', 'active' => true));
$bread = $breadcrumb->draw();
$btn_group = array(
    array('type' => 'a', 'title' => '返回', 'href' => 'index.php?rule=attribute_group', 'class' => 'btn-primary', 'icon' => 'level-up'),
    array('type' => 'a', 'title' => '新属性值', 'href' => 'index.php?rule=attribute_edit&id_attribute_group=' .Tools::G('id'), 'class' => 'btn-success', 'icon' => 'plus')
);

echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');

/** 属性值 */
echo UIAdminDndTable::loadHead();
$table = new UIAdminDndTable('attribute',  'Attribute', 'id_attribute');
$table->addAttribte('id', 'attribute');
$table->child = true;
$table->header = array(
    array('sort' => false ,'isCheckAll' => 'itemsBox[]'),
    array('name' => 'id_attribute','title' => 'ID','filter' => 'string'),
    array('name' => 'name','title' => '名称','filter' => 'string'),
    array('name' => 'position','title' => '排序'),
    array('sort' => false ,'title' => '操作', 'width' => '120px', 'class' => 'text-right', 'isAction'=> array('edit', 'delete')),
);
$filter = $table->initFilter();
$filter['id_attribute_group'] = Tools::G('id');

$orderBy 	= isset($_GET['orderby']) ? Tools::G('orderby') : 'position';
$orderWay 	= isset($_GET['orderway']) ? Tools::G('orderway') : 'asc';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::G('p') ? (Tools::G('p') == 0 ? 1 : Tools::G('p')) : 1;

$result  	= Attribute::loadData($p, $limit, $orderBy, $orderWay, $filter);
$btn_group = array(
    array('type' => 'button', 'title' => '删除选中','confirm' => '确定要删除选中项?', 'name' => 'subDelete', 'btn_type' => 'submit', 'class' => 'btn-danger') ,
);
echo UIViewBlock::area(array('title' => '商品特征值', 'table' => $table, 'result' => $result, 'limit' => $limit, 'btn_groups' => $btn_group), 'table');
