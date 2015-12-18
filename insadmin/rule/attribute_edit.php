<?php
if (Tools::G('id_attribute_group') > 0) {
	$id_attribute_group = Tools::G('id_attribute_group');
}

if (Tools::P('saveAttribute') == 'add' && Tools::P('id_attribute_group') > 0) {
	$attribute = new Attribute();
	$attribute->copyFromPost();
	$attribute->add();

	if (is_array($attribute->_errors) AND count($attribute->_errors) > 0){
		$errors = $attribute->_errors;
	} else {
		$_GET['id']	= $attribute->id;
		UIAdminAlerts::conf('属性值已添加');
	}
	$id_attribute_group = Tools::P('id_attribute_group');
}

if (isset($_GET['id'])) {
	$id  = (int)$_GET['id'];
	$attribute = new Attribute($id);
	$id_attribute_group = $attribute->id_attribute_group;
}

if (Tools::P('saveAttribute') == 'edit') {
	if(Validate::isLoadedObject($attribute)){
		$attribute->copyFromPost();
		$attribute->update();
	}

	if(is_array($attribute->_errors) AND count($attribute->_errors)>0){
		$errors = $attribute->_errors;
	}else{
		UIAdminAlerts::conf('属性值已更新');
	}
}
if (!isset($id_attribute_group)) {
	$errors[] = '属性组未指定';
}

if (isset($errors)) {
	UIAdminAlerts::MError($errors);
}

$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '属性组', 'href' => 'index.php?rule=attribute_group'));
$breadcrumb->add(array('title' => '属性值', 'href' => 'index.php?rule=attribute&id=' . (int) $id_attribute_group));
$breadcrumb->add(array('title' => '编辑', 'active' => true));
$bread = $breadcrumb->draw();

$btn_group = array(
	array('type' => 'a', 'title' => '返回', 'href' =>  'index.php?rule=attribute&id=' . (int) $id_attribute_group, 'class' => 'btn-primary', 'icon' => 'level-up') ,
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
$form->items = array(
	'name' => array(
		'title' => '属性值',
		'type' => 'text',
		'value' => isset($attribute) ? $attribute->name : Tools::Q('name'),
	),
	'id_attribute_group' => array(
		'type' => 'hidden',
		'value' => (int) $id_attribute_group,
	),
	'saveAttribute' => array(
		'type' => 'hidden',
		'value' => isset($id) ? 'edit' : 'add',
	),
);
echo UIViewBlock::area(array( 'title' => '编辑', 'body' => $form->draw()), 'panel');
?>