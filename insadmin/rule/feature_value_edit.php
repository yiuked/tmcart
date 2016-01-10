<?php
if (Tools::G('id_feature') > 0) {
    $id_feature = Tools::G('id_feature');
}

if (Tools::P('saveFeatureValue') == 'add' && Tools::P('id_feature') > 0) {
    $featureV = new FeatureValue();
    $featureV->copyFromPost();
    $featureV->add();

    if (is_array($featureV->_errors) AND count($featureV->_errors) > 0){
        $errors = $featureV->_errors;
    } else {
        $_GET['id']	= $featureV->id;
        UIAdminAlerts::conf('商品特征值已添加');
    }
    $id_feature = Tools::P('id_feature');
}

if (isset($_GET['id'])) {
    $id  = (int)$_GET['id'];
    $obj = new FeatureValue($id);
    $id_feature = $obj->id_feature;
}

if (Tools::P('saveFeatureValue') == 'edit') {
    if(Validate::isLoadedObject($obj)){
        $obj->copyFromPost();
        $obj->update();
    }

    if(is_array($obj->_errors) AND count($obj->_errors)>0){
        $errors = $obj->_errors;
    }else{
        UIAdminAlerts::conf('商品特征值已更新');
    }
}
if (!isset($id_feature)) {
    $errors[] = '商品特征未指定';
}
/** 输出错误信息 */
if (isset($errors)) {
    UIAdminAlerts::MError($errors);
}

/** 导航 */
$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '商品特征', 'href' => 'index.php?rule=feature_edit&id=' . $id_feature));
$breadcrumb->add(array('title' => '编辑', 'active' => true));
$bread = $breadcrumb->draw();
$btn_group = array(
    array('type' => 'a', 'title' => '返回', 'href' => 'index.php?rule=feature_value&id=' . $id_feature, 'class' => 'btn-primary', 'icon' => 'level-up') ,
    array('type' => 'button', 'title' => '保存', 'id' => 'save-feature-value-form', 'class' => 'btn-success', 'icon' => 'save') ,
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');
?>
<script language="javascript">
    $("#save-feature-value-form").click(function(){
        $("#feature-value-form").submit();
    })
</script>
<?php
$form = new UIAdminEditForm('post', 'index.php?rule=feature_value_edit'. (isset($id) ? '&id=' . $id : ''), 'form-horizontal', 'feature-value-form');
$form->items = array(
    'name' => array(
        'title' => '特征值',
        'type' => 'text',
        'value' => isset($obj) ? $obj->name : Tools::Q('name'),
    ),
    'id_feature' => array(
        'type' => 'hidden',
        'value' => $id_feature,
    ),
    'saveFeatureValue' => array(
        'type' => 'hidden',
        'value' => isset($id) ? 'edit' : 'add',
    ),
);
echo UIViewBlock::area(array( 'title' => '编辑', 'body' => $form->draw()), 'panel');