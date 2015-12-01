<?php
if(isset($_POST['sveBrand']) && Tools::getRequest('sveBrand') == 'add')
{
	$brand = new Brand();
	$brand->copyFromPost();
	if ($brand->add()) {
		UIAdminAlerts::conf('品牌已更新');
	}

	if(is_array($brand->_errors) AND count($brand->_errors)>0){
		$errors = $brand->_errors;
	}
}

if(isset($_GET['id'])){
	$id  = (int)$_GET['id'];
	$obj = new Brand($id);
}

if(isset($_POST['sveBrand']) && Tools::getRequest('sveBrand')=='edit')
{
	if(Validate::isLoadedObject($obj)){
		$obj->copyFromPost();
		if ($obj->update()) {
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
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="col-md-6">
					<?php
					$breadcrumb = new UIAdminBreadcrumb();
					$breadcrumb->home();
					$breadcrumb->add(array('href' => 'index.php?rule=brand', 'title' => '品牌'));
					$breadcrumb->add(array('title' => '编辑', 'active' => true));
					echo $breadcrumb->draw();
					?>
				</div>
				<div class="col-md-6">
					<div class="btn-group save-group pull-right" role="group">
						<a href="index.php?rule=brand"  class="btn btn-primary"><span aria-hidden="true" class="glyphicon glyphicon-level-up"></span> 返回</a>
					</div>
					<div class="btn-group save-group pull-right" role="group">
						<a href="javascript:void(0)"  class="btn btn-success" id="brand-save"><span aria-hidden="true" class="glyphicon glyphicon-save"></span> 保存</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script language="javascript">
	$("#brand-save").click(function(){
		$("#brand-form").submit();
	})
</script>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-body">
			  <form method="post" action="index.php?rule=brand_edit<?php echo isset($id)?'&id='.$id:''?>" class="form-horizontal" id="brand-form" enctype="multipart/form-data" >
				  <div class="form-group">
					  <label for="name" class="col-md-2 control-label">品牌</label>
					  <div class="col-md-5">
						  <input type="text" class="form-control" name="name" onchange="copy2friendlyURL()" id="name" value="<?php echo isset($obj) ? $obj->name : Tools::P('name');?>">
					  </div>
				  </div>
				  <div class="form-group">
					  <label for="logo" class="col-md-2 control-label">LOGO</label>
					  <div class="col-md-5">
						  <input type="file" value=""  name="qqfile" >
						  <?php if(isset($obj) && $obj->id_image > 0 ){?>
						  <img src="<?php echo Image::getImageLink($obj->id_image, 'large');?>" alt="<?php echo $obj->name;?>" class="img-rounded">
						  <?php }?>
					  </div>
				  </div>
				  <div class="form-group">
					  <label for="description" class="col-md-2 control-label">描述</label>
					  <div class="col-md-8">
						  <textarea name="description" class="form-control"><?php echo isset($obj)?$obj->description:Tools::getRequest('description');?></textarea>
					  </div>
				  </div>
				  <div class="form-group">
					  <label for="name" class="col-md-2 control-label">标题</label>
					  <div class="col-md-5">
						  <input type="text" class="form-control" name="meta_title" value="<?php echo isset($obj)?$obj->meta_title:Tools::getRequest('meta_title');?>">
					  </div>
				  </div>
				  <div class="form-group">
					  <label for="name" class="col-md-2 control-label">关键词</label>
					  <div class="col-md-5">
						  <input type="text" class="form-control" name="meta_keywords" value="<?php echo isset($obj)?$obj->meta_keywords:Tools::getRequest('meta_keywords');?>">
					  </div>
				  </div>
				  <div class="form-group">
					  <label for="name" class="col-md-2 control-label">Meta 描述</label>
					  <div class="col-md-5">
						  <input type="text" class="form-control" name="meta_description" value="<?php echo isset($obj)?$obj->meta_description:Tools::getRequest('meta_description');?>">
					  </div>
				  </div>
				  <div class="form-group">
					  <label for="name" class="col-md-2 control-label">伪静态</label>
					  <div class="col-md-5">
						  <input type="text" class="form-control" name="rewrite" id="rewrite" value="<?php echo isset($obj)?$obj->rewrite:Tools::getRequest('rewrite');?>" onchange="this.value = str2url(this.value);">
					  </div>
				  </div>
				<input type="hidden" value="<?php echo isset($id)?'edit':'add'?>"  name="sveBrand">
			  </form>
			</div>
		</div>
	</div>
</div>
