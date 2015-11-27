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
<script>
	$(document).ready(function(){
		$('#save-color').click(function(){
			$('#color_form').submit();
		})
	})
</script>
<link href="<?php echo _TM_JS_URL; ?>boootstrap-colorpicker/css/colorpicker.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="<?php echo _TM_JS_URL; ?>boootstrap-colorpicker/js/bootstrap-colorpicker.js"></script>
<script>
	$(document).ready(function() {
		$('.colorpicker').colorpicker()
	})
</script>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
			颜色编辑
			</div>
			<div class="panel-body">
				<form method="post" action="index.php?rule=color_edit<?php echo isset($id)?'&id='.$id:''?>" class="form-horizontal" id="color_form">
					<div class="form-group">
						<label for="name" class="col-md-2 control-label">颜色</label>
						<div class="col-md-5">
							<input type="text" class="form-control" name="name" value="<?php echo isset($obj)?$obj->name:Tools::getRequest('name');?>" id="name" onkeyup="if (isArrowKey(event)) return ;copy2friendlyURL();" onchange="copy2friendlyURL();">
						</div>
					</div>
					<div class="form-group">
						<label for="code" class="col-md-2 control-label">颜色值</label>
						<div class="col-md-1">
							<input type="text" class="form-control colorpicker" name="code" value="<?php echo isset($obj)?$obj->code:Tools::getRequest('code');?>">
						</div>
					</div>
					<div class="form-group">
						<label for="meta_title" class="col-md-2 control-label">标题</label>
						<div class="col-md-5">
							<input type="text" class="form-control" name="meta_title" value="<?php echo isset($obj)?$obj->meta_title:Tools::getRequest('meta_title');?>">
						</div>
					</div>
					<div class="form-group">
						<label for="meta_keywords" class="col-md-2 control-label">关键词</label>
						<div class="col-md-5">
							<input type="text" class="form-control" name="meta_keywords" value="<?php echo isset($obj)?$obj->meta_keywords:Tools::getRequest('meta_keywords');?>">
						</div>
					</div>
					<div class="form-group">
						<label for="meta_description" class="col-md-2 control-label">Meta 描述</label>
						<div class="col-md-5">
							<input type="text" class="form-control" name="meta_description" value="<?php echo isset($obj)?$obj->meta_description:Tools::getRequest('meta_description');?>">
						</div>
					</div>
					<div class="form-group">
						<label for="rewrite" class="col-md-2 control-label">友好URL链接</label>
						<div class="col-md-5">
							<input type="text" class="form-control" name="rewrite" value="<?php echo isset($obj)?$obj->rewrite:Tools::getRequest('rewrite');?>" id="rewrite" onkeyup="if (isArrowKey(event)) return ;generateFriendlyURL();" onchange="generateFriendlyURL();">
						</div>
					</div>
					<input type="hidden" value="<?php echo isset($id)?'edit':'add'?>"  name="sveColor">
				</form>
			</div>
		</div>
	</div>
</div>