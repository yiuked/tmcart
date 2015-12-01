<?php
if(Tools::P('imageTypeSaveType') == 'add')
{
	$image_type = new ImageType();
	$image_type->copyFromPost();
	if($image_type->add() && Tools::P('reloadImages')){
			$image_type->reloadImages();
	}
	
	if(is_array($image_type->_errors) AND count($image_type->_errors)>0){
		$errors = $image_type->_errors;
	}else{
		$_GET['id']	= $image_type->id;
		UIAdminAlerts::conf('图片类型已添加');
	}
}

if(isset($_GET['id'])){
	$id  = (int)$_GET['id'];
	$obj = new ImageType($id);
}

if(Tools::P('imageTypeSaveType') == 'edit')
{
	if(Validate::isLoadedObject($obj)){
		$obj->copyFromPost();
		
		if($obj->update() && Tools::P('reloadImages')){
			$obj->reloadImages();
		}
	}

	if(is_array($obj->_errors) AND count($obj->_errors)>0){
		$errors = $obj->_errors;
	}else{
		UIAdminAlerts::conf('图片类型已更新');
	}
}
?>
<?php
if (isset($errors)) {
UIAdminAlerts::MError($errors);
}

$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '图片类别', 'href' => 'index.php?rule=image_type'));
$breadcrumb->add(array('title' => '编辑', 'active' => true));
$bread = $breadcrumb->draw();

$btn_group = array(
array('type' => 'a', 'title' => '返回', 'href' => 'index.php?rule=image_type', 'class' => 'btn-primary', 'icon' => 'level-up') ,
array('type' => 'a', 'title' => '保存', 'id' => 'save-image-type', 'href' => '#', 'class' => 'btn-success', 'icon' => 'save') ,
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');
?>
<script language="javascript">
  $("#save-image-type").click(function(){
    $("#image-type-form").submit();
  })
</script>
<?php
$form = new UIAdminEditForm('post', 'index.php?rule=image_type_edit'. (isset($id) ? '&id=' . $id : ''), 'form-horizontal', 'image-type-form');
$form->items = array(
    'name' => array(
        'title' => '名称',
        'type' => 'text',
        'value' => isset($obj) ? $obj->name : Tools::Q('name')
    ),
    'height' => array(
        'title' => '高',
        'type' => 'text',
        'value' => isset($obj) ? $obj->height : Tools::Q('height'),
    ),
    'width' => array(
        'title' => '宽',
        'type' => 'text',
        'value' => isset($obj) ? $obj->width : Tools::Q('width'),
    ),
    'type' => array(
        'title' => '应用',
        'type' => 'text',
        'value' => isset($obj) ? $obj->type : Tools::Q('type'),
    ),
    'reloadImages' => array(
        'title' => '重载图片',
        'type' => 'bool',
        'info' => '重载图片将删除以前图片按新的属性重新生成图片,这个过程可能会需要一些时间'
    ),
    'imageTypeSaveType' => array(
        'type' => 'hidden',
        'value' => isset($id) ? 'edit' : 'add',
    ),
);
echo UIViewBlock::area(array('col' => 'col-md-12', 'title' => '编辑', 'body' => $form->draw()), 'panel');
?>
