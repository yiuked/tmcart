<?php
if(Tools::Q('saveAttributeGroup') == 'add')
{
	$attribute_group = new AttributeGroup();
	$attribute_group->copyFromPost();
	$attribute_group->add();
	
	if(is_array($attribute_group->_errors) AND count($attribute_group->_errors)>0){
		$errors = $attribute_group->_errors;
	}else{
		$_GET['id']	= $attribute_group->id;
		UIAdminAlerts::conf('已添加属性组');
	}
}

if(isset($_GET['id'])){
	$id  = (int) Tools::G('id');
	$obj = new AttributeGroup($id);
}

if(Tools::Q('saveAttributeGroup') == 'edit')
{
	if(Validate::isLoadedObject($obj)){
		$obj->copyFromPost();
		$obj->update();
	}
	
	if(is_array($obj->_errors) AND count($obj->_errors)>0){
		$errors = $obj->_errors;
	}else{
		UIAdminAlerts::conf('已更新属性组');
	}
}

if (isset($errors)) {
	UIAdminAlerts::MError($errors);
}

$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '属性组', 'href' => 'index.php?rule=attribute_group'));
$breadcrumb->add(array('title' => '编辑', 'active' => true));
$bread = $breadcrumb->draw();

$btn_group = array(
	array('type' => 'a', 'title' => '返回', 'href' => 'index.php?rule=attribute_group', 'class' => 'btn-primary', 'icon' => 'level-up') ,
	array('type' => 'button', 'title' => '保存', 'id' => 'save-attribute-group', 'class' => 'btn-success', 'icon' => 'saved') ,
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');
?>
<script language="javascript">
	$("#save-attribute-group").click(function(){
		$("#attribute-group-form").submit();
	})
</script>
<?php
$form = new UIAdminEditForm('post', 'index.php?rule=attribute_group_edit'. (isset($id) ? '&id=' . $id : ''), 'form-horizontal', 'attribute-group-form');
$attributeGroup = AttributeGroup::getEntitys();
$groups = array();
foreach($attributeGroup['entitys'] as $group){
	$groups[$group['id_attribute_group']] = $group['name'];
}
$items = array(
	AttributeGroup::GROUP_TYPE_SELECT => '下单菜单',
	AttributeGroup::GROUP_TYPE_RADIO => '单选按钮',
	AttributeGroup::GROUP_TYPE_CHECKBOX => '复选框',
);
$form->items = array(
	'name' => array(
		'title' => '属性值',
		'type' => 'text',
		'value' => isset($obj) ? $obj->name : Tools::Q('name'),
	),
	'group_type' => array(
		'title' => '类别',
		'type' => 'radio',
		'value' => isset($obj) ? $obj->group_type : Tools::Q('group_type'),
		'items' => $items,
	),
	'saveAttributeGroup' => array(
		'type' => 'hidden',
		'value' => isset($id) ? 'edit' : 'add',
	),
);
echo UIViewBlock::area(array( 'title' => '编辑', 'body' => $form->draw()), 'panel');
?>