<?php
if(Tools::P('sveBrand') == 'add')
{
	$brand = new Brand();
	$brand->copyFromPost();
	if ($brand->add() && $brand->updateLogo()) {
		UIAdminAlerts::conf('品牌已更新');
	}

	if(is_array($brand->_errors) AND count($brand->_errors)>0){
		$errors = $brand->_errors;
	}
}

if(isset($_GET['id'])){
	$id  = (int) Tools::G('id');
	$obj = new Brand($id);
}

if(isset($_POST['sveBrand']) && Tools::P('sveBrand') == 'edit')
{
	if(Validate::isLoadedObject($obj)){
		$obj->copyFromPost();
		if ($obj->update() && $obj->updateLogo()) {
			if (!isset($_FILES['qqfile']['name']) || (isset($_FILES['qqfile']['name']) && $obj->updateLogo())) {
				UIAdminAlerts::conf('品牌已更新');
			}
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
$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('href' => 'index.php?rule=brand', 'title' => '品牌'));
$breadcrumb->add(array('title' => '编辑', 'active' => true));
$bread = $breadcrumb->draw();
$btn_group = array(
	array('type' => 'a', 'title' => '返回', 'href' => 'index.php?rule=brand', 'class' => 'btn-primary', 'icon' => 'level-up') ,
	array('type' => 'button', 'title' => '保存', 'id' => 'save-brand-form', 'class' => 'btn-success', 'icon' => 'save') ,
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');
?>
<script language="javascript">
$("#save-brand-form").click(function(){
	$("#brand-form").submit();
})
</script>
<?php
$form = new UIAdminEditForm('post', 'index.php?rule=brand_edit'. (isset($id) ? '&id=' . $id : ''), 'form-horizontal', 'brand-form', 'multipart/form-data');
$form->items = array(
	'name' => array(
		'title' => '品牌',
		'type' => 'text',
		'value' => isset($obj) ? $obj->name : Tools::Q('name'),
		'id' => 'name',
		'other' => 'onkeyup="if (isArrowKey(event)) return ;copy2friendlyURL();" onchange="copy2friendlyURL();"'
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
	'meta_title' => array(
		'title' => '标题',
		'type' => 'text',
		'value' => isset($obj) ? $obj->meta_title : Tools::Q('meta_title'),
	),
	'meta_keywords' => array(
		'title' => '关键词',
		'type' => 'text',
		'value' => isset($obj) ? $obj->meta_keywords : Tools::Q('meta_keywords'),
	),
	'meta_description' => array(
		'title' => 'Meta 描述',
		'type' => 'text',
		'value' => isset($obj) ? $obj->meta_description : Tools::Q('meta_description'),
	),
	'rewrite' => array(
		'title' => '伪静态',
		'type' => 'text',
		'value' => isset($obj) ? $obj->rewrite : Tools::Q('rewrite'),
		'id' => 'rewrite',
		'other' => 'onkeyup="if (isArrowKey(event)) return ;copy2friendlyURL();" onchange="copy2friendlyURL();"'
	),
	'sveBrand' => array(
		'type' => 'hidden',
		'value' => isset($id) ? 'edit' : 'add',
	),
);
echo UIViewBlock::area(array( 'title' => '编辑', 'body' => $form->draw()), 'panel');
?>