<?php

if(Tools::P('saveCMS') == 'add')
{
	$cms = new CMS();
	$cms->copyFromPost();
	if($cms->add())
		if(!$cms->updateCategories($_POST['categoryBox']) OR !$cms->updateTags($_POST['tags']))
			$cms->_errors = '添加CMS内容时发生了一个错误';
	
	if(is_array($cms->_errors) AND count($cms->_errors)>0){
		$errors = $cms->_errors;
	}else{
		$_GET['id'] = $cms->id;
		UIAdminAlerts::conf('文章已添加');
	}
}

if(isset($_GET['id'])){
	$id  = (int) Tools::G('id');
	$obj = new CMS($id);
}

if(Tools::P('saveCMS') == 'edit')
{
	if(Validate::isLoadedObject($obj)){
		$obj->copyFromPost();
		if($obj->update())
			if(!$obj->updateCategories($_POST['categoryBox']) OR !$obj->updateTags($_POST['tags']))
				$obj->_errors = '更新CMS内容时发生了一个错误';
	}
	if(is_array($obj->_errors) AND count($obj->_errors)>0){
		$errors = $obj->_errors;
	}else{
		UIAdminAlerts::conf('文章已更新');
	}
	
}

?>
<!--head-->
<link href="<?php echo BOOTSTRAP_CSS;?>bootstrap-tagsinput.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo _TM_JS_URL;?>tinymce/tinymce.min.js"></script>
<script type="text/javascript" src="<?php echo _TM_JS_URL;?>tinymce/tinymce.init.js"></script>
<script type="text/javascript" src="<?php echo BOOTSTRAP_JS;?>bootstrap-tagsinput.min.js"></script>
<!--//head-->
<?php
//导航
$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => 'CMS', 'href' => 'index.php?rule=cms'));
$breadcrumb->add(array('title' => '编辑', 'active' => true));
$bread = $breadcrumb->draw();
$btn_group = array(
	array('type' => 'a', 'title' => '返回', 'href' => 'index.php?rule=cms', 'class' => 'btn-primary', 'icon' => 'level-up'),
	array('type' => 'button', 'title' => '保存', 'id' => 'save-cms-form', 'class' => 'btn-success', 'icon' => 'save'),
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');

if (isset($errors)) {
	UIAdminAlerts::MError($errors);
}
?>
<script language="javascript">
	$("#save-cms-save").click(function(){
		$("#cms-form").submit();
	})
</script>
<?php
$form = new UIAdminEditForm('post', 'index.php?rule=cms_edit'. (isset($id) ? '&id=' . $id : ''), 'form-horizontal', 'cms-form');
$result = Country::getEntity(1,500);
$countrys = array();
foreach($result['entitys'] as $country) {
	$countrys[$country['id_country']] = $country['name'];
}

$trads = array(
	'selected' => '选择',
	'Home' 		=> '根分类',
	'Collapse All' => '关闭',
	'Expand All' 	=> '展开',
);
if (!isset($obj))
{
	$categoryBox = Tools::getRequest('categoryBox')?Tools::getRequest('categoryBox'):array();
}
else
{
	if (Tools::isSubmit('categoryBox'))
		$categoryBox = Tools::getRequest('categoryBox');
	else
		$categoryBox = CMS::getCMSCategoriesFullId($obj->id);
}
$category =  Helper::renderAdminCategorieTree($trads,$categoryBox, 'categoryBox', true,'CMSTree');
$tag = '<div class="tagify-container"><input type="text" value="'.(isset($obj) ? (Tag::tagToString($obj->id)) : Tools::P('tags')).'" class="form-control" data-role="tagsinput" name="tags" ></div>';
$form->items = array(
	'title' => array(
		'title' => '标题',
		'type' => 'text',
		'value' => isset($obj) ? $obj->title : Tools::Q('title'),
	),
	'active' => array(
		'title' => '状态',
		'type' => 'bool',
		'value' => isset($obj) ? $obj->active : Tools::Q('active'),
	),
	'is_top' => array(
		'title' => '置顶',
		'type' => 'bool',
		'value' => isset($obj) ? $obj->is_top : Tools::Q('is_top'),
	),
	'categoryBox' => array(
		'title' => '分类',
		'type' => 'custom',
		'value' => $category
	),
	'tags' => array(
		'title' => 'Tag标签',
		'type' => 'custom',
		'value' => $tag
	),
	'meta_title' => array(
		'title' => 'Meta标题',
		'type' => 'text',
		'value' => isset($obj) ? $obj->meta_title : Tools::Q('meta_title'),
	),
	'meta_keywords' => array(
		'title' => 'Meta关键词',
		'type' => 'text',
		'value' => isset($obj) ? $obj->meta_keywords : Tools::Q('meta_keywords'),
	),
	'meta_description' => array(
		'title' => 'Meta描述',
		'type' => 'text',
		'value' => isset($obj) ? $obj->meta_description : Tools::Q('meta_description'),
	),
	'rewrite' => array(
		'title' => '静态链接',
		'type' => 'text',
		'value' => isset($obj) ? $obj->rewrite : Tools::Q('rewrite'),
	),
	'content' => array(
		'title' => '内容',
		'type' => 'textarea',
		'class' => 'tinymce',
		'value' => isset($obj) ? $obj->content : Tools::Q('content'),
	),
	'saveCMS' => array(
		'type' => 'hidden',
		'value' => isset($id) ? 'edit' : 'add',
	),
);
echo UIViewBlock::area(array('col' => 'col-md-12', 'title' => '编辑', 'body' => $form->draw()), 'panel');
?>