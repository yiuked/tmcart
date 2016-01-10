<?php

if(Tools::G('delete') > 0){
    $feature = new Feature(Tools::G('delete'));
    if(Validate::isLoadedObject($feature)){
        $feature->delete();
    }

    if(is_array($feature->_errors) AND count($feature->_errors)>0){
        $errors = $feature->_errors;
    }else{
        UIAdminAlerts::conf('商品特征已删除');
    }
}elseif(Tools::isSubmit('delSelected')){
    $select_cat = Tools::P('itemsBox');
    $feature	= new Feature();
    if($feature->deleteMulti($select_cat))
        UIAdminAlerts::conf('商品特征已删除');

}

echo UIAdminDndTable::loadHead();
$table = new UIAdminDndTable('feature',  'Feature', 'id_feature');
$table->addAttribte('id', 'feature');
$table->header = array(
    array('sort' => false ,'isCheckAll' => 'itemsBox[]'),
    array('name' => 'id_feature','title' => 'ID','filter' => 'string', 'rule' => 'feature_value'),
    array('name' => 'name','title' => '名称','filter' => 'string' ,'rule' => 'feature_value'),
    array('name' => 'position','title' => '排序'),
    array('sort' => false ,'title' => '操作', 'width' => '120px', 'class' => 'text-right', 'isAction'=> array('edit', 'delete')),
);
$filter = $table->initFilter();

$orderBy 	= isset($_GET['orderby']) ? Tools::G('orderby') : 'position';
$orderWay 	= isset($_GET['orderway']) ? Tools::G('orderway') : 'asc';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::G('p') ? (Tools::G('p') == 0 ? 1 : Tools::G('p')) : 1;

$result  	= Feature::loadData($p, $limit, $orderBy, $orderWay, $filter);

if (isset($errors)) {
    UIAdminAlerts::MError($errors);
}

$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '商品特征', 'active' => true));
$bread = $breadcrumb->draw();
$btn_group = array(
    array('type' => 'a', 'title' => '新商品特征', 'href' => 'index.php?rule=feature_edit', 'class' => 'btn-success', 'icon' => 'plus') ,
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');

$btn_group = array(
    array('type' => 'button', 'title' => '删除选中','confirm' => '确定要删除选中项?', 'name' => 'delSelected', 'btn_type' => 'submit', 'class' => 'btn-danger') ,
);
echo UIViewBlock::area(array('title' => '用户留言', 'table' => $table, 'result' => $result, 'limit' => $limit, 'btn_groups' => $btn_group), 'table');