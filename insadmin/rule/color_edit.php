<?php
if(isset($_POST['sveColor']) && Tools::getRequest('sveColor')=='add')
{
	$color = new Color();
	$color->name = strtolower(Tools::getRequest('name'));
	$color->code = strtolower(Tools::getRequest('code'));
	$color->rewrite = strtolower(Tools::getRequest('rewrite'));
	$color->add();
	
	if(is_array($color->_errors) AND count($color->_errors)>0){
		$errors = $color->_errors;
	}else{
		$_GET['id']	= $color->id;
		echo '<div class="conf">创建对象成功</div>';
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
		echo '<div class="conf">更新对象成功</div>';
	}
}

$colors = Color::getEntitys();

require_once(dirname(__FILE__).'/../errors.php');
?>
<?php
$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '颜色', 'href' => 'index.php?rule=color'));
$breadcrumb->add(array('title' => '编辑', 'active' => true));
$bread = $breadcrumb->draw();

$btn_group = array(
	array('type' => 'a', 'title' => '返回', 'href' => 'index.php?rule=color', 'class' => 'btn-primary', 'icon' => 'level-up') ,
	array('type' => 'a', 'title' => '保存', 'id' => 'save-color', 'href' => 'index.php?rule=color_edit', 'class' => 'btn-success', 'icon' => 'save') ,
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
			颜色编辑
			</div>
			<div class="panel-body">
				<form method="post" action="index.php?rule=color_edit<?php echo isset($id)?'&id='.$id:''?>" class="form-horizontal" id="entity_form">
					<div class="form-group">
						<label for="code" class="col-md-2 control-label">标题</label>
						<div class="col-md-5">
							<input type="text" class="form-control" name="code" value="<?php echo isset($obj)?$obj->code:Tools::getRequest('code');?>">
						</div>
					</div>
					<div class="form-group">
						<label for="code" class="col-md-2 control-label">颜色效果</label>
						<div class="col-md-5">
							<div id="showColor" style="width:60px;height:40px;border:2px solid #333;">点击查看</div>
						</div>
					</div>
					<div class="form-group">
						<label for="name" class="col-md-2 control-label">标题</label>
						<div class="col-md-5">
							<input type="text" class="form-control" name="name" value="<?php echo isset($obj)?$obj->meta_title:Tools::getRequest('meta_title');?>">
						</div>
					</div>
					<div class="form-group">
						<label for="name" class="col-md-2 control-label">Meta 描述</label>
						<div class="col-md-5">
							<input type="text" class="form-control" name="name" value="<?php echo isset($obj)?$obj->meta_description:Tools::getRequest('meta_description');?>">
						</div>
					</div>
						<input type="hidden" value="<?php echo isset($id)?'edit':'add'?>"  name="sveColor">
				</form>
			</div>
		</div>
	</div>
</div>
<script language="javascript">
	$("#showColor").click(function(){
		var color = $("#code").val();
		$(this).css("background-color",color);
	})
</script>