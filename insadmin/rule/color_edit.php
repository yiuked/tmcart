<?php
if(isset($_POST['sveColor']) && Tools::getRequest('sveColor')=='add')
{
	$color = new Color();
	$color->copyFromPost();
	$color->add();
	
	if(is_array($color->_errors) AND count($color->_errors) > 0){
		$errors = $color->_errors;
	}else{
		$_GET['id']	= $color->id;
		UIAdminAlerts::conf('创建对象成功');
	}
}

if(isset($_GET['id'])){
	$id  = (int)$_GET['id'];
	$obj = new Color($id);
}

if(isset($_POST['sveColor']) && Tools::getRequest('sveColor')=='edit')
{
	if(Validate::isLoadedObject($obj)){
		$obj->copyFromPost();
		$obj->update();
	}
	
	if(is_array($obj->_errors) AND count($obj->_errors)>0){
		$errors = $obj->_errors;
	}else{
		UIAdminAlerts::conf('更新对象成功');
	}
}

$colors = Color::getEntitys();

if (isset($errors)) {
	UIAdminAlerts::MError($errors);
}

$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '颜色', 'href' => 'index.php?rule=color'));
$breadcrumb->add(array('title' => '编辑', 'active' => true));
$bread = $breadcrumb->draw();

$btn_group = array(
	array('type' => 'a', 'title' => '返回', 'href' => 'index.php?rule=color', 'class' => 'btn-primary', 'icon' => 'level-up') ,
	array('type' => 'a', 'title' => '保存', 'id' => 'save-color', 'href' => '#', 'class' => 'btn-success', 'icon' => 'save') ,
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');
?>
<link href="<?php echo _TM_JS_URL; ?>boootstrap-colorpicker/css/colorpicker.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="<?php echo _TM_JS_URL; ?>boootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script>
	$(document).ready(function(){
		$('#save-color').click(function(){
			$('#color_form').submit();
			$('.colorpicker').colorpicker();
		})
	})
</script>
<?php
$form = new UIAdminEditForm('post', 'index.php?rule=color_edit'. (isset($id) ? '&id=' . $id : ''), 'form-horizontal', 'color_form');
$form->items = array(
	'name' => array(
		'title' => '颜色',
		'type' => 'text',
		'id' => 'name',
		'value' => isset($obj) ? $obj->name : Tools::Q('name'),
		'other' => 'onkeyup="if (isArrowKey(event)) return ;copy2friendlyURL();" onchange="copy2friendlyURL();"'
	),
	'code' => array(
		'title' => '颜色值',
		'type' => 'text',
		'class' => 'colorpicker',
		'value' => isset($obj) ? $obj->code : Tools::Q('code'),
		'css' => 'width:40px;',
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
		'title' => '描述',
		'type' => 'text',
		'value' => isset($obj) ? $obj->meta_description : Tools::Q('meta_description'),
	),
	'rewrite' => array(
		'title' => '友好URL链接',
		'type' => 'text',
		'value' => isset($obj) ? $obj->rewrite : Tools::Q('rewrite'),
		'id' => 'rewrite',
		'other' => 'onkeyup="if (isArrowKey(event)) return ;copy2friendlyURL();" onchange="copy2friendlyURL();"'
	),
	'sveColor' => array(
		'type' => 'hidden',
		'value' => isset($id) ? 'edit' : 'add',
	),
);
echo UIViewBlock::area(array('col' => 'col-md-12', 'title' => '编辑', 'body' => $form->draw()), 'panel');
?>