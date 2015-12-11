<?php
if(Tools::P('saveUser') == 'add')
{
	$user = new User();
	if(User::userExists(Tools::P('email'))) {
		$user->_errors[] = '邮箱地址已存在！';
	}elseif(!Validate::isPasswd(Tools::P('passwd'))) {
		$user->_errors[] = '用户密码错误！';
	}else{
		$user->copyFromPost();
		if ($user->add()) {
			UIAdminAlerts::conf('用户已添加');
		}
	}

	if(is_array($user->_errors) AND count($user->_errors)>0){
		$errors = $user->_errors;
	}
}

if(isset($_GET['id'])){
	$id  = (int) Tools::G('id');
	$obj = new User($id);
}

if(Tools::P('saveUser') == 'edit')
{
	  if(Tools::P('email') != $obj->email && User::userExists(Tools::P('email'))){
			$obj->_errors[] = '邮箱地址已存在！';
	  }elseif(Validate::isLoadedObject($obj)){
			$obj->copyFromPost();
			$obj->update();
	  }

	if(is_array($obj->_errors) AND count($obj->_errors)>0){
		$errors = $obj->_errors;
	}else{
		UIAdminAlerts::conf('用户已更新');
	}
}

$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '用户', 'active' => true));
$bread = $breadcrumb->draw();
$btn_groups = array(
	array('type' => 'a', 'title' => '返回', 'href' => 'index.php?rule=user', 'class' => 'btn-primary', 'icon' => 'level-up') ,
	array('type' => 'button', 'title' => '保存',  'id' => 'save-user-form', 'class' => 'btn-success', 'icon' => 'save') ,
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_groups), 'breadcrumb');

if (isset($errors)) {
	UIAdminAlerts::MError($errors);
}
?>
<script language="javascript">
	$("#save-user-form").click(function(){
		$("#user-form").submit();
	})
</script>
<?php
$form = new UIAdminEditForm('post', 'index.php?rule=user_save'. (isset($id) ? '&id=' . $id : ''), 'form-horizontal', 'brand-form', 'multipart/form-data');
$form->items = array(
	'name' => array(
		'title' => '姓名',
		'type' => 'text',
		'value' => isset($obj) ? $obj->name : Tools::Q('name'),
	),
	'active' => array(
		'title' => '状态',
		'type' => 'bool',
		'value' => isset($obj) ? $obj->active : Tools::Q('active'),
	),
	'email' => array(
		'title' => '邮箱',
		'type' => 'text',
		'value' => isset($obj) ? $obj->email : Tools::Q('email'),
	),
	'passwd' => array(
		'title' => '密码',
		'type' => 'text',
		'value' => "",
	),
	'sveUser' => array(
		'type' => 'hidden',
		'value' => 'edit',
	),
	'submit' => array(
		'title' => '保存',
		'type' => 'submit',
		'class' => 'btn-success',
		'icon' => 'save',
	),
);
echo UIViewBlock::area(array( 'title' => '编辑','class' => 'col-md-5', 'body' => $form->draw()), 'panel');
?>
<div class="row">
<?php
if(isset($obj)) {
	$carts = $obj->getCarts();
	if ($carts) {
		$cartTable = new UIAdminTable('cart', 'User', 'id_cart');
		$cartTable->header = array(
			array('sort' => false, 'name' => 'id_cart', 'title' => '购物车ID'),
			array('sort' => false, 'name' => 'status_label', 'title' => '状态', 'color' => true),
			array('sort' => false, 'name' => 'add_date', 'title' => '添加时间'),
		);
		$cartTable->data = $carts;
		echo UIViewBlock::area(array( 'title' => '购物车清单', 'row' => false, 'class' => 'col-md-3', 'body' => $cartTable->draw()), 'panel');
	}

	$orders = $obj->getOrders();
	if ($orders) {
		$orderTable = new UIAdminTable('order', 'User', 'id_order');
		$orderTable->header = array(
			array('sort' => false,'name' => 'id_order', 'title' => '定单ID'),
			array('sort' => false, 'name' => 'status', 'title' => '状态', 'color' => true),
			array('sort' => false,'name' => 'add_date', 'title' => '添加时间'),
		);
		$orderTable->data = $orders;
		echo UIViewBlock::area(array( 'title' => '定单历史', 'row' => false, 'class' => 'col-md-3', 'body' => $orderTable->draw()), 'panel');
	}

}
?>
</div>
