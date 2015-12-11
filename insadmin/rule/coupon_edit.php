<?php
if(Tools::P('saveCoupon') == 'add')
{
	$coupon = new Coupon();
	$coupon->copyFromPost();
	$coupon->add();
	
	if(is_array($coupon->_errors) AND count($coupon->_errors)>0){
		$errors = $coupon->_errors;
	}else{
		$_GET['id']	= $coupon->id;
		UIAdminAlerts::conf('优惠码已添加');
	}
}

if(isset($_GET['id'])){
	$id  = (int)$_GET['id'];
	$obj = new Coupon($id);
}

if(Tools::P('saveCoupon') == 'edit')
{
	if(Validate::isLoadedObject($obj)){
		$obj->copyFromPost();
		$obj->update();
	}
	
	if(is_array($obj->_errors) AND count($obj->_errors)>0){
		$errors = $obj->_errors;
	}else{
		UIAdminAlerts::conf('优惠码已更新');
	}
}
if (isset($errors)) {
	UIAdminAlerts::MError($errors);
}

$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '促销码', 'href' => 'index.php?rule=coupon'));
$breadcrumb->add(array('title' => '编辑', 'active' => true));
$bread = $breadcrumb->draw();
$btn_groups = array(
	array('type' => 'button', 'title' => '保存', 'id' => 'save-coupon-form', 'class' => 'btn-success', 'icon' => 'save'),
	array('type' => 'a', 'title' => '返回', 'href' => 'index.php?rule=coupon', 'class' => 'btn-primary', 'icon' => 'level-up'),
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_groups), 'breadcrumb');
?>
<script language="javascript">
	$("#save-coupon-form").click(function(){
		$("#coupon-form").submit();
	})
</script>
<?php
$form = new UIAdminEditForm('post', 'index.php?rule=coupon_edit'. (isset($id) ? '&id=' . $id : ''), 'form-horizontal', 'coupon-form');
$form->items = array(
	'id_user' => array(
		'title' => '用户ID',
		'type' => 'text',
		'value' => isset($obj) ? $obj->id_user : Tools::Q('id_user'),
		'info' => '如果为0则表示任何用户都可使用该促销码',
	),
	'code' => array(
		'title' => '优惠码',
		'type' => 'text',
		'value' => isset($obj) ? $obj->code : Tools::Q('code'),
	),
	'off' => array(
		'title' => '优惠幅度',
		'type' => 'text',
		'value' => isset($obj) ? $obj->off : Tools::Q('off'),
		'info' => '按百分比优惠，0-100间的整数，表示优惠x%,如果为0则以优惠金额为参照',
	),
	'amount' => array(
		'title' => '优惠金额',
		'type' => 'text',
		'value' => isset($obj) ? $obj->amount : Tools::Q('amount'),
		'info' => '按指定金额进行优惠，如果为0则使用优惠幅度.',
	),
	'total_over' => array(
		'title' => '产品金额超过',
		'type' => 'text',
		'value' => isset($obj) ? $obj->total_over : Tools::Q('total_over'),
	),
	'quantity_over' => array(
		'title' => '产品数量超过',
		'type' => 'text',
		'value' => isset($obj) ? $obj->quantity_over : Tools::Q('quantity_over'),
		'info' => '促销码使用条件，如果为0，则表示数量无条件限制.'
	),
	'active' => array(
		'title' => '状态',
		'type' => 'bool',
		'value' => isset($obj) ? $obj->active : Tools::Q('active'),
	),
	'saveCoupon' => array(
		'type' => 'hidden',
		'value' => isset($id) ? 'edit' : 'add',
	),
);
echo UIViewBlock::area(array('col' => 'col-md-12', 'title' => '编辑', 'body' => $form->draw()), 'panel');
