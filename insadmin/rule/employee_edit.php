<?php
if(Tools::P('saveEmployee') == 'add')
{
	$employee = new Employee();
	if(Tools::P('passwd') != Tools::P('passwd_conf')){
		$employee->_errors[] = '两次输入的密码不一样！';
	}elseif(Employee::employeeExists(Tools::P('email'))){
		$employee->_errors[] = '邮箱地址已存在！';
	}else{
		$employee->copyFromPost();
		$employee->add();
	}
	
	if(is_array($employee->_errors) AND count($employee->_errors)>0){
		$errors = $employee->_errors;
	}else{
		$_GET['id']	= $employee->id;
		UIAdminAlerts::conf('管理员已添加');
	}
}

if(isset($_GET['id'])){
	$id  = (int)$_GET['id'];
	$obj = new Employee($id);
}

if(Tools::P('saveEmployee') == 'edit')
{

	  if(Tools::P('passwd') != Tools::P('passwd_conf')){
			$obj->_errors[] = '两次输入的密码不一样！';
	  }elseif(Tools::P('email') != $obj->email && Employee::employeeExists(Tools::getRequest('email'))){
			$obj->_errors[] = '邮箱地址已存在！';
	  }elseif(Validate::isLoadedObject($obj)){
			$obj->copyFromPost();
			$obj->update();
	  }
	

		if(is_array($obj->_errors) AND count($obj->_errors)>0){
			$errors = $obj->_errors;
		}else{
			UIAdminAlerts::conf('管理员已更新');
		}
 
}
if (isset($errors)) {
	UIAdminAlerts::MError($errors);
}
$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '管理员', 'href' => 'index.php?rule=employee'));
$breadcrumb->add(array('title' => '编辑', 'active' => true));
$bread = $breadcrumb->draw();

$btn_group = array(
	array('type' => 'a', 'title' => '返回', 'href' => 'index.php?rule=employee', 'class' => 'btn-primary', 'icon' => 'level-up') ,
	array('type' => 'a', 'title' => '保存', 'id' => 'save-employee-form', 'href' => '#', 'class' => 'btn-success', 'icon' => 'save') ,
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');
?>
<script language="javascript">
	$("#save-employee-form").click(function(){
		$("#employee-form").submit();
	})
</script>
<?php
$form = new UIAdminEditForm('post', 'index.php?rule=employee_edit'. (isset($id) ? '&id=' . $id : ''), 'form-horizontal', 'country-form');
$form->items = array(
	'name' => array(
		'title' => '昵称',
		'type' => 'text',
		'value' => isset($obj) ? $obj->name : Tools::Q('name'),
	),
	'email' => array(
		'title' => '邮箱',
		'type' => 'text',
		'value' => isset($obj) ? $obj->email : Tools::Q('email'),
	),
	'passwd' => array(
		'title' => '密码',
		'type' => 'password',
		'value' => '',
	),
	'active' => array(
		'title' => '状态',
		'type' => 'bool',
		'value' => isset($obj) ? $obj->active : Tools::Q('active'),
	),
	'saveEmployee' => array(
		'type' => 'hidden',
		'value' => isset($id) ? 'edit' : 'add',
	),
);
echo UIViewBlock::area(array('col' => 'col-md-12', 'title' => '编辑', 'body' => $form->draw()), 'panel');

