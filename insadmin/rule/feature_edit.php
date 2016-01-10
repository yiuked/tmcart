<?php
if (Tools::P('saveFeature') == 'add') {
    $feature = new Feature();
    $feature->copyFromPost();
    $feature->add();

    if (is_array($feature->_errors) AND count($feature->_errors) > 0){
        $errors = $feature->_errors;
    } else {
        $_GET['id']	= $feature->id;
        UIAdminAlerts::conf('商品特征已添加');
    }
}

if(isset($_GET['id'])){
    $id  = (int)$_GET['id'];
    $obj = new Feature($id);
}

if (Tools::P('saveFeature') == 'edit') {
    if(Validate::isLoadedObject($obj)){
        $obj->copyFromPost();
        $obj->update();
    }

    if(is_array($obj->_errors) AND count($obj->_errors)>0){
        $errors = $obj->_errors;
    }else{
        UIAdminAlerts::conf('商品特征已更新');
    }
}


/** 输出错误信息 */
if (isset($errors)) {
    UIAdminAlerts::MError($errors);
}

/** 导航 */
$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '商品特征', 'href' => 'index.php?rule=feature'));
$breadcrumb->add(array('title' => '编辑', 'active' => true));
$bread = $breadcrumb->draw();
$btn_group = array(
    array('type' => 'a', 'title' => '返回', 'href' => 'index.php?rule=feature', 'class' => 'btn-primary', 'icon' => 'level-up') ,
    array('type' => 'button', 'title' => '保存', 'id' => 'save-feature-form', 'class' => 'btn-success', 'icon' => 'save') ,
);

echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');
?>
<script language="javascript">
    $("#save-feature-form").click(function(){
        $("#feature-form").submit();
    })
</script>
<?php
$form = new UIAdminEditForm('post', 'index.php?rule=feature_edit'. (isset($id) ? '&id=' . $id : ''), 'form-horizontal', 'feature-form');
$form->items = array(
    'name' => array(
        'title' => '特征名',
        'type' => 'text',
        'value' => isset($obj) ? $obj->name : Tools::Q('name'),
    ),
    'saveFeature' => array(
        'type' => 'hidden',
        'value' => isset($id) ? 'edit' : 'add',
    ),
);
echo UIViewBlock::area(array( 'title' => '编辑', 'body' => $form->draw()), 'panel');
