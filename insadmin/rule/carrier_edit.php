<?php
if(Tools::P('saveCarrier') == 'add')
{
	$carrier = new Carrier();
	$carrier->copyFromPost();
	if($carrier->add() && $carrier->updateLogo()){
        UIAdminAlerts::conf('配送商已添加');
        $_GET['id']	= $carrier->id;
	}

    if(is_array($carrier->_errors) AND count($carrier->_errors)>0){
        $errors = $carrier->_errors;
    }
}

if(isset($_GET['id'])){
	$id  = (int) Tools::G('id');
	$obj = new Carrier($id);
}

if(Tools::P('saveCarrier') == 'edit')
{
	if(Validate::isLoadedObject($obj)){
		$obj->copyFromPost();
		if($obj->update() && $obj->updateLogo()){
            UIAdminAlerts::conf('配送商已更新');
		}
	}

    if(is_array($obj->_errors) AND count($obj->_errors)>0){
        $errors = $obj->_errors;
    }

}
if (isset($errors)) {
    UIAdminAlerts::MError($errors);
}
?>
<?php
if (isset($errors)) {
  UIAdminAlerts::MError($errors);
}

$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '物流', 'active' => true));
$bread = $breadcrumb->draw();
$btn_group = array(
    array('type' => 'a', 'title' => '返回', 'href' => 'index.php?rule=carrier', 'class' => 'btn-primary', 'icon' => 'level-up') ,
    array('type' => 'button', 'title' => '保存', 'id' => 'save-carrier-form', 'class' => 'btn-success', 'icon' => 'save') ,
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');
?>
<script language="javascript">
	$("#save-carrier-form").click(function(){
		$("#carrier-form").submit();
	})
</script>
<?php
$form = new UIAdminEditForm('post', 'index.php?rule=carrier_edit'. (isset($id) ? '&id=' . $id : ''), 'form-horizontal', 'carrier-form', 'multipart/form-data');
$form->items = array(
    'name' => array(
        'title' => '配送商',
        'type' => 'text',
        'value' => isset($obj) ? $obj->name : Tools::Q('name'),
    ),
    'qqfile' => array(
        'title' => 'Logo',
        'type' => 'file',
        'info' => (isset($obj) && $obj->id_image > 0 ) ? '<img src="' . Image::getImageLink($obj->id_image, 'small'). '" alt="' . $obj->name . '" class="img-rounded">' : '',
    ),
    'description' => array(
        'title' => '描述',
        'type' => 'textarea',
        'value' => isset($obj) ? $obj->description : Tools::Q('description'),
    ),
    'shipping' => array(
        'title' => '运费',
        'type' => 'text',
        'value' => isset($obj) ? $obj->shipping : Tools::Q('shipping'),
    ),
    'active' => array(
        'title' => '状态',
        'type' => 'bool',
        'value' => isset($obj) ? $obj->active : Tools::Q('active'),
    ),
    'saveCarrier' => array(
        'type' => 'hidden',
        'value' => isset($id) ? 'edit' : 'add',
    ),
);
echo UIViewBlock::area(array( 'title' => '编辑', 'body' => $form->draw()), 'panel');
?>
