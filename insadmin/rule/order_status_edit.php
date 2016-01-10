<?php
if(Tools::P('saveOrderStatus') == 'add')
{
	$orderstatus = new OrderStatus();
	$orderstatus->copyFromPost();
	$orderstatus->add();
	
	if(is_array($orderstatus->_errors) AND count($orderstatus->_errors)>0){
		$errors = $orderstatus->_errors;
	}else{
		$_GET['id']	= $orderstatus->id;
		UIAdminAlerts::conf('定单状态已添加');
	}
}

if(isset($_GET['id'])){
	$id  = (int) $_GET['id'];
	$obj = new OrderStatus($id);
}

if(Tools::P('saveOrderStatus') == 'edit')
{
	if(Validate::isLoadedObject($obj)){
		$obj->copyFromPost();
		$obj->update();
	}
	
	if(is_array($obj->_errors) AND count($obj->_errors)>0){
		$errors = $obj->_errors;
	}else{
      UIAdminAlerts::conf('定单状态已更新');
	}
}
/** 错误处理 */
if (isset($errors)) {
  UIAdminAlerts::MError($errors);
}

/** 导航 */
$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '定单状态', 'href' => 'index.php?rule=order_status'));
$breadcrumb->add(array('title' => '编辑', 'active' => true));
$bread = $breadcrumb->draw();
$btn_group = array(
    array('type' => 'a', 'title' => '返回', 'href' => 'index.php?rule=order_status', 'class' => 'btn-primary', 'icon' => 'level-up') ,
    array('type' => 'button', 'title' => '保存', 'id' => 'save-ordder-status-form', 'class' => 'btn-success', 'icon' => 'save') ,
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');
?>
<script language="javascript">
	$("#save-ordder-status-form").click(function(){
		$("#ordder-status-form").submit();
	})
</script>
<link href="<?php echo _TM_JS_URL; ?>boootstrap-colorpicker/css/colorpicker.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="<?php echo _TM_JS_URL; ?>boootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script>
$(document).ready(function() {
  $('.colorpicker').colorpicker();
})
</script>
<?php
$form = new UIAdminEditForm('post', 'index.php?rule=order_status_edit'. (isset($id) ? '&id=' . $id : ''), 'form-horizontal', 'order-status-form');
$form->items = array(
    'name' => array(
        'title' => '状态名',
        'type' => 'text',
        'value' => isset($obj) ? $obj->name : Tools::Q('name'),
    ),
    'color' => array(
        'title' => '颜色值',
        'type' => 'text',
        'class' => 'colorpicker',
        'value' => isset($obj) ? $obj->color : Tools::Q('color'),
        'css' => 'width:40px;',
    ),
    'send_mail' => array(
        'title' => '发送邮件',
        'type' => 'bool',
        'value' => isset($obj) ? $obj->send_mail : Tools::Q('send_mail'),
    ),
    'email_tpl' => array(
        'title' => '邮件模板',
        'type' => 'text',
        'value' => isset($obj) ? $obj->email_tpl : Tools::Q('email_tpl'),
    ),
    'active' => array(
        'title' => '状态',
        'type' => 'bool',
        'value' => isset($obj) ? $obj->active : Tools::Q('active'),
    ),
    'saveOrderStatus' => array(
        'type' => 'hidden',
        'value' => isset($id) ? 'edit' : 'add',
    ),
);
echo UIViewBlock::area(array( 'title' => '编辑', 'body' => $form->draw()), 'panel');