<?php
if(isset($_POST['saveAttribute']) && Tools::getRequest('saveAttribute')=='add')
{
	$attribute_group = new Attribute();
	$attribute_group->copyFromPost();
	$attribute_group->add();
	
	if(is_array($attribute_group->_errors) AND count($attribute_group->_errors)>0){
		$errors = $attribute_group->_errors;
	}else{
		$_GET['id']	= $attribute_group->id;
		UIAdminAlerts::conf('属性值已添加');
	}
}

if(isset($_GET['id'])){
	$id  = (int)$_GET['id'];
	$obj = new Attribute($id);
}

if(isset($_POST['saveAttribute']) && Tools::getRequest('saveAttribute')=='edit')
{
	if(Validate::isLoadedObject($obj)){
		$obj->copyFromPost();
		$obj->update();
	}
	
	if(is_array($obj->_errors) AND count($obj->_errors)>0){
		$errors = $obj->_errors;
	}else{
		UIAdminAlerts::conf('属性值已更新');
	}
}

if (isset($errors)) {
	UIAdminAlerts::MError($errors);
}

$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '属性组', 'href' => 'index.php?rule=attribute_group'));
$breadcrumb->add(array('title' => '属性', 'active' => true));
$bread = $breadcrumb->draw();

$btn_group = array(
	array('type' => 'a', 'title' => '返回', 'href' => 'index.php?rule=attribute_group', 'class' => 'btn-primary', 'icon' => 'level-up') ,
	array('type' => 'button', 'title' => '保存', 'id' => 'save-attribute', 'class' => 'btn-success', 'icon' => 'saved') ,
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');
?>
<script language="javascript">
	$("#save-attribute").click(function(){
		$("#attribute-form").submit();
	})
</script>
<?php
$form = new UIAdminEditForm('post', 'index.php?rule=attribute_edit'. (isset($id) ? '&id=' . $id : ''), 'form-horizontal', 'attribute-form');
$attributeGroup = AttributeGroup::getEntitys();
$groups = array();
foreach($attributeGroup['entitys'] as $group){
	$groups[$group['id_attribute_group']] = $group['name'];
}
$form->items = array(
	'name' => array(
		'title' => '属性值',
		'type' => 'text',
		'value' => isset($obj) ? $obj->name : Tools::Q('name'),
	),
	'id_attribute_group' => array(
		'title' => '所属属性组',
		'type' => 'select',
		'value' => isset($obj) ? $obj->id_attribute_group : Tools::Q('id_attribute_group'),
		'option' => $groups,
	),
	'saveAttribute' => array(
		'type' => 'hidden',
		'value' => isset($id) ? 'edit' : 'add',
	),
);
echo UIViewBlock::area(array( 'title' => '编辑', 'body' => $form->draw()), 'panel');
?>