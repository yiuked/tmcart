<?php
if(Tools::P('saveOnepage') == 'add')
{
	$onepage = new Onepage();
	$onepage->copyFromPost();
	$onepage->add();
	
	if(is_array($onepage->_errors) AND count($onepage->_errors) > 0){
		$errors = $onepage->_errors;
	}else{
		$_GET['id']	= $onepage->id;
		UIAdminAlerts::conf('页面已创建');
	}
}

if(isset($_GET['id'])){
	$id  = (int)$_GET['id'];
	$obj = new Onepage($id);
}

if(Tools::P('saveOnepage') == 'edit')
{
	if(Validate::isLoadedObject($obj)){
		$obj->copyFromPost();
		$obj->update();
	}
	
	if(is_array($obj->_errors) AND count($obj->_errors)>0){
		$errors = $obj->_errors;
	}else{
		UIAdminAlerts::conf('页面已更新');
	}

}
/** 错误处理 */
if (isset($errors)) {
	UIAdminAlerts::MError($errors);
}

/** 导航 */
$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('href' => 'index.php?rule=brand', 'title' => '单面管理'));
$breadcrumb->add(array('title' => '编辑', 'active' => true));
$bread = $breadcrumb->draw();
$btn_group = array(
	array('type' => 'a', 'title' => '返回', 'href' => 'index.php?rule=onepage', 'class' => 'btn-primary', 'icon' => 'level-up') ,
	array('type' => 'button', 'title' => '保存', 'id' => 'save-onepage-form', 'class' => 'btn-success', 'icon' => 'save') ,
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');
?>
<script language="javascript">
	$("#save-onepage-form").click(function(){
		$("#onepage-form").submit();
	})
</script>
<?php
$form = new UIAdminEditForm('post', 'index.php?rule=brand_edit'. (isset($id) ? '&id=' . $id : ''), 'form-horizontal', 'brand-form');
$form->items = array(
	'view_name' => array(
		'title' => '示图名',
		'type' => 'text',
		'value' => isset($obj) ? $obj->view_name : Tools::Q('view_name'),
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
	'saveOnepage' => array(
		'type' => 'hidden',
		'value' => isset($id) ? 'edit' : 'add',
	),
);
echo UIViewBlock::area(array( 'title' => '编辑', 'body' => $form->draw()), 'panel');