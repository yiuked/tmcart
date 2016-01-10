<?php
if (Tools::P('saveCMSTag') == 'add') {
	$cmstag = new CMSTag();
	$cmstag->copyFromPost();
	$cmstag->add();

	if(is_array($cmstag->_errors) && count($cmstag->_errors) > 0) {
		$errors = $cmstag->_errors;
	}else{
		$_GET['id']	= $cmstag->id;
		UIAdminAlerts::conf('CMS标签已添加');
	}
}

if(isset($_GET['id'])){
	$id  = (int)$_GET['id'];
	$obj = new CMSTag($id);
}

if(Tools::P('saveCMSTag') == 'edit')
{
	if(Validate::isLoadedObject($obj)){
		$obj->copyFromPost();
		$obj->update();
	}
	
	if(is_array($obj->_errors) AND count($obj->_errors)>0){
		$errors = $obj->_errors;
	}else{
		UIAdminAlerts::conf('CMS标签已更新');
	}

}
$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => 'CMS标签', 'href' => 'index.php?rule=cms_tag'));
$breadcrumb->add(array('title' => '编辑', 'active' => true));
$bread = $breadcrumb->draw();
$btn_groups = array(
	array('type' => 'a', 'title' => '返回', 'href' => 'index.php?rule=cms_tag', 'class' => 'btn-primary', 'icon' => 'level-up') ,
	array('type' => 'button', 'title' => '保存', 'id' => 'save-cms-tag-form', 'class' => 'btn-success', 'icon' => 'save') ,
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_groups), 'breadcrumb');

if (isset($errors)) {
	UIAdminAlerts::MError($errors);
}
?>
<script language="javascript">
	$("#save-cms-tag-form").click(function(){
		$("#cms-tag-form").submit();
	})
</script>
<?php
$form = new UIAdminEditForm('post', 'index.php?rule=cms_tag_edit'. (isset($id) ? '&id=' . $id : ''), 'form-horizontal', 'cms-tag-form');
$form->items = array(
	'name' => array(
		'title' => 'Tag名称',
		'type' => 'text',
		'value' => isset($obj) ? $obj->name : Tools::Q('name'),
		'id' => 'name',
		'other' => 'onkeyup="if (isArrowKey(event)) return ;copy2friendlyURL();" onchange="copy2friendlyURL();"'
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
		'title' => 'Meta描述',
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
	'saveCMSTag' => array(
		'type' => 'hidden',
		'value' => isset($id) ? 'edit' : 'add',
	),
);
echo UIViewBlock::area(array( 'title' => '编辑', 'body' => $form->draw()), 'panel');