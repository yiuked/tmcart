<!--head-->
<link type="text/css" rel="stylesheet" href="../themes/default/default.css" />
<link type="text/css" href="../js/jquery/ui/themes/base/jquery.ui.theme.css" rel="stylesheet"  media="all" />
<link type="text/css" href="../js/jquery/ui/themes/base/jquery.ui.theme.css" rel="stylesheet"  media="all" />
<script type="text/javascript" src="../js/kindeditor/kindeditor-min.js"></script>
<script type="text/javascript" src="../js/kindeditor/lang/zh_CN.js"></script>
<script type="text/javascript" src="../js/jquery/ui/jquery.ui.core.min.js"></script>
<script type="text/javascript" src="../js/jquery/ui/jquery.ui.datepicker.min.js"></script>
<script type="text/javascript" src="../js/jquery/ui/i18n/jquery.ui.datepicker-en.js"></script>
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
		AdminAlerts::conf('创建分类成功');
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
		AdminAlerts::conf('更新分类成功');
	}
 
}
if (isset($errors)) {
	AdminAlerts::MError($errors);
}

?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="col-md-6">
				<?php
				echo AdminBreadcrumb::getInstance()->home()
					->add(array('href' => 'index.php?rule=category', 'title' => '分类'))
					->add(array('title' => '编辑', 'active' => true))
					->generate();
				?>
				</div>
				<div class="col-md-6">
					<div class="btn-group pull-right" role="group">
						<a href="index.php?rule=category"  class="btn btn-primary"><span aria-hidden="true" class="glyphicon glyphicon-level-up"></span> 返回</a>
					</div>

					<div class="btn-group save-group pull-right" role="group">
						<a href="javascript:void(0)"  class="btn btn-success" id="submit-form"><span aria-hidden="true" class="glyphicon glyphicon-floppy-saved"></span> 保存</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script language="javascript">
	$("#submit-form").click(function(){
		$("#cms_category_form").submit();
	})
</script>
<div class="panel panel-default">
	<div class="panel-body">
		<div class="col-md-10 form-horizontal">
			<form enctype="multipart/form-data" method="post" action="index.php?rule=category_edit<?php echo isset($id)?'&id='.$id:''?>" class="defaultForm admincmscontent" id="cms_category_form" name="example">
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
				<script>
					KindEditor.ready(function(K) {
						var editor1 = K.create('textarea[name="description"]', {
							cssPath : '../js/kindeditor/plugins/code/prettify.css',
							uploadJson : '../js/kindeditor/php/upload_json.php',
							fileManagerJson : '../js/kindeditor/php/file_manager_json.php',
							allowFileManager : true,
							afterCreate: function () {
								this.sync();
							},
							afterBlur: function () {
								this.sync();
							}
						});
					});
				</script>
				<div class="form-group">
					<label for="rewrite" class="col-sm-2 control-label">描述</label>
					<div class="col-sm-10">
							<textarea name="description" style="width:800px;height:400px;visibility:hidden;"><?php echo isset($obj)?$obj->description:Tools::getRequest('description');?></textarea>
					</div>
				</div>
				<script type="text/javascript">
					$(function() {
						if ($(".datepicker").length > 0)
							$(".datepicker").datepicker({
								prevText: '',
								nextText: '',
								dateFormat: 'yy-mm-dd'
							});
					});
				</script>
				<input type="hidden" value="<?php echo isset($id)?'edit':'add'?>"  name="sveCategory">
			</form>
		</div>
	</div>
</div>

