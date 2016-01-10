<!--head-->
<script type="text/javascript" src="../js/tinymce/tinymce.min.js"></script>
<!--//head-->
<?php
if(isset($_POST['sveCMSCategory']) && Tools::getRequest('sveCMSCategory')=='add')
{
	$cmscategory = new CMSCategory();
	$cmscategory->copyFromPost();
	$cmscategory->add();
	
	if(is_array($cmscategory->_errors) AND count($cmscategory->_errors)>0){
		$errors = $cmscategory->_errors;
	}else{
		$_GET['id']	= $cmscategory->id;
		echo '<div class="conf">创建分类成功</div>';
	}
}

if(isset($_GET['id'])){
	$id  = (int)$_GET['id'];
	$obj = new CMSCategory($id);
}

if(isset($_POST['sveCMSCategory']) && Tools::getRequest('sveCMSCategory')=='edit')
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
		echo '<div class="conf">更新分类成功</div>';
	}
 
}
if (isset($errors)) {
	UIAdminAlerts::MError($errors);
}
//导航
$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => 'CMS分类', 'active' => true));
$bread = $breadcrumb->draw();
$btn_group = array(
	array('type' => 'a', 'title' => '返回', 'href' => 'index.php?rule=cms_category', 'class' => 'btn-primary', 'icon' => 'level-up') ,
	array('type' => 'button', 'title' => '保存', 'id' => 'save-category', 'class' => 'btn-success', 'icon' => 'saved') ,
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');
?>
<script language="javascript">
	$("#desc-product-save").click(function(){
		$("#cms_category_form").submit();
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
				echo Helper::renderAdminCategorieTree($trads, array(isset($obj)?$obj->id_parent:1), 'id_parent', true,'CMSTree');
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
				<script>
					tinymce.init({
						selector: '.tinymce',
						menu: {
							edit: {title: 'Edit', items: 'undo redo | cut copy paste | selectall'},
							insert: {title: 'Insert', items: 'media image link | pagebreak'},
							view: {title: 'View', items: 'visualaid'},
							format: {title: 'Format', items: 'bold italic underline strikethrough superscript subscript | formats | removeformat'},
							table: {title: 'Table', items: 'inserttable tableprops deletetable | cell row column'},
							tools: {title: 'Tools', items: 'code'}
						},
						plugins : "link image paste pagebreak table contextmenu filemanager table code media autoresize textcolor",
						external_filemanager_path:  "<?php echo ADMIN_URL;?>filemanager/",
						filemanager_title: "文件管理" ,
						external_plugins: { "filemanager" : "<?php echo ADMIN_URL;?>filemanager/plugin.min.js"},
						relative_urls : false,//相对URL
						convert_urls: false,//必设属性否则URL地址将对不上
						toolbar: 'code | insertfile undo redo | styleselect | bold italic forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',// 需在工具栏显示的
						language: 'zh_CN',
					});
				</script>
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
