<!--head-->
<script type="text/javascript" src="../js/tinymce/tinymce.min.js"></script>
<script type="text/javascript" src="../js/tinymce/tinymce.init.js"></script>
<!--//head-->
<?php
if(isset($_POST['sveCategory']) && Tools::getRequest('sveCategory')=='add')
{
	$cmscategory = new Category();
	$cmscategory->copyFromPost();
	$cmscategory->add();
	
	if(is_array($cmscategory->_errors) AND count($cmscategory->_errors)>0){
		$errors = $cmscategory->_errors;
	}else{
		$_GET['id']	= $cmscategory->id;
		UIAdminAlerts::conf('创建分类成功');
	}
}

if(isset($_GET['id'])){
	$id  = (int)$_GET['id'];
	$obj = new Category($id);
}

if(isset($_POST['sveCategory']) && Tools::getRequest('sveCategory')=='edit')
{

  if(Tools::getRequest('id_parent')==$obj->id){
  		$obj->_errors[] = '父分类不能为当前分类！';
  }elseif(Validate::isLoadedObject($obj)){
  		$obj->copyFromPost();
		$obj->update();
}
	

	if(is_array($obj->_errors) AND count($obj->_errors)>0){
		$errors = $obj->_errors;
	}else{
		UIAdminAlerts::conf('更新分类成功');
	}
 
}
if (isset($errors)) {
	UIAdminAlerts::MError($errors);
}
//导航
$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '分类', 'active' => true));
$bread = $breadcrumb->draw();
$btn_group = array(
	array('type' => 'a', 'title' => '返回', 'href' => 'index.php?rule=category', 'class' => 'btn-primary', 'icon' => 'level-up') ,
	array('type' => 'button', 'title' => '保存', 'id' => 'save-category', 'class' => 'btn-success', 'icon' => 'saved') ,
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');
?>

<script language="javascript">
	$("#save-category").click(function(){
		$("#category-form").submit();
	})
</script>
<div class="panel panel-default">
	<div class="panel-body">
		<div class="col-md-10">
			<form enctype="multipart/form-data" method="post" action="index.php?rule=category_edit<?php echo isset($id)?'&id='.$id:''?>" class="form-horizontal" id="category-form" >
				<div class="form-group">
					<label for="name" class="col-sm-2 control-label">名称</label>
					<div class="col-sm-10">
						<input type="text" value="<?php echo isset($obj)?$obj->name:Tools::getRequest('name');?>" id="name" class="form-control" name="name" size="60" onkeyup="if (isArrowKey(event)) return ;copy2friendlyURL();" onchange="copy2friendlyURL();">
					</div>
				</div>
				<div class="form-group">
					<label for="time" class="col-sm-2 control-label">状态</label>
					<div class="col-sm-6">
						<div class="btn-group" data-toggle="buttons">
							<label class="btn btn-grey enabled<?php echo isset($obj)&&$obj->active==1?' active':(Tools::getRequest('active')==1?' active':'');?>">
								<input type="radio" name="active" value="1" autocomplete="off" >启用
							</label>
							<label class="btn btn-grey">
								<input type="radio" name="active" value="0" autocomplete="off">关闭
							</label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="categoryBox" class="col-sm-2 control-label">关联分类</label>
					<div class="col-sm-10">
						<?php
						$trads = array(
							'Home' => '根分类',
							'selected' => '选择',
							'Collapse All' => '关闭',
							'Expand All' => '展开'
						);
						echo Helper::renderAdminCategorieTree($trads, array(isset($obj)?$obj->id_parent:1), 'id_parent', true,'Tree');
						?>
					</div>
				</div>
				<div class="form-group">
					<label for="meta_title" class="col-sm-2 control-label">Meta Title</label>
					<div class="col-sm-10">
						<input type="text" value="<?php echo isset($obj)?$obj->meta_title:Tools::getRequest('meta_title');?>" class="form-control" name="meta_title" >
					</div>
				</div>
				<div class="form-group">
					<label for="meta_keywords" class="col-sm-2 control-label">Meta Keywords</label>
					<div class="col-sm-10">
						<input type="text" value="<?php echo isset($obj)?$obj->meta_keywords:Tools::getRequest('meta_keywords');?>" class="form-control" name="meta_keywords" >
					</div>
				</div>
				<div class="form-group">
					<label for="meta_description" class="col-sm-2 control-label">Meta Description</label>
					<div class="col-sm-10">
						<input type="text" value="<?php echo isset($obj)?$obj->meta_description:Tools::getRequest('meta_description');?>" class="form-control" name="meta_description" >
					</div>
				</div>
				<div class="form-group">
					<label for="rewrite" class="col-sm-2 control-label">Url Rewrite</label>
					<div class="col-sm-10">
						<input type="text" value="<?php echo isset($obj)?$obj->rewrite:Tools::getRequest('rewrite');?>" class="form-control" name="rewrite" id="rewrite" onkeyup="if (isArrowKey(event)) return ;generateFriendlyURL();" onchange="generateFriendlyURL();">
					</div>
				</div>
				<div class="form-group">
					<label for="rewrite" class="col-sm-2 control-label">描述</label>
					<div class="col-sm-10">
							<textarea class="tinymce" name="description"><?php echo isset($obj)?$obj->description:Tools::getRequest('description');?></textarea>
					</div>
				</div>
				<input type="hidden" value="<?php echo isset($id)?'edit':'add'?>"  name="sveCategory">
				<div class="form-group">
					<div class="col-sm-10 col-sm-offset-2">
						<button type="submit"  class="btn btn-success"><span aria-hidden="true" class="glyphicon glyphicon-floppy-saved"></span> 保存</button>
						<a href="index.php?rule=category"  class="btn btn-primary"><span aria-hidden="true" class="glyphicon glyphicon-level-up"></span> 返回</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>

