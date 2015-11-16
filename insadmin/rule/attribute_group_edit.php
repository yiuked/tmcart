<?php
if(isset($_POST['sveAttributeGroup']) && Tools::getRequest('sveAttributeGroup')=='add')
{
	$attribute_group = new AttributeGroup();
	$attribute_group->copyFromPost();
	$attribute_group->add();
	
	if(is_array($attribute_group->_errors) AND count($attribute_group->_errors)>0){
		$errors = $attribute_group->_errors;
	}else{
		$_GET['id']	= $attribute_group->id;
		echo '<div class="conf">创建对象失败</div>';
	}
}

if(isset($_GET['id'])){
	$id  = (int)$_GET['id'];
	$obj = new AttributeGroup($id);
}

if(isset($_POST['sveAttributeGroup']) && Tools::getRequest('sveAttributeGroup')=='edit')
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
require_once(dirname(__FILE__).'/../errors.php');
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="col-md-6">
					<?php
					$breadcrumb = new UIAdminBreadcrumb();
					$breadcrumb->home();
					$breadcrumb->add(array('title' => '属性组', 'href' => 'index.php?rule=attribute_group'));
					$breadcrumb->add(array('title' => '编辑', 'active' => true));
					echo $breadcrumb->draw();
					?>
				</div>
				<div class="col-md-6">
					<div class="btn-group pull-right" role="group">
						<a href="index.php?rule=attribute_group"  class="btn btn-primary"><span aria-hidden="true" class="glyphicon glyphicon-level-up"></span> 返回</a>
					</div>

					<div class="btn-group save-group pull-right" role="group">
						<a href="javascript:void(0)"  class="btn btn-success" id="attribute-group-save"><span aria-hidden="true" class="glyphicon glyphicon-floppy-saved"></span> 保存</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script language="javascript">
	$("#attribute-group-save").click(function(){
		$("#attribute_group_form").submit();
	})
</script>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				属性组
			</div>
			<div class="panel-body">
				<form method="post"  action="index.php?rule=attribute_group_edit<?php echo isset($id)?'&id='.$id:''?>" id="attribute_group_form" class="form-horizontal">
						<div class="form-group">
							<label for="name" class="col-md-2 control-label">名称</label>
							<div class="col-md-5">
								<input type="text" value="<?php echo isset($obj) ? $obj->name : Tools::P('name');?>"  name="name" class="form-control" >
							</div>
						</div>
						<div class="form-group">
							<label for="group_type" class="col-md-2 control-label">类别</label>
							<div class="col-md-5">
								<div class="btn-group radio-group" data-toggle="buttons">
									<label class="btn btn-grey<?php echo isset($obj) && $obj->group_type == 'select' ? ' active' : ''; ?>">
										<input type="radio" name="group_type" id="option2" value="select" > 下单菜单
									</label>
									<label class="btn btn-grey<?php echo isset($obj) && $obj->group_type == 'radio' ? ' active' : ''; ?>">
										<input type="radio" name="group_type" id="option3" value="radio" > 单选按钮
									</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="group_type" class="col-md-2 control-label">排序</label>
							<div class="col-md-5">
								<input type="text" value="<?php echo isset($obj) ? $obj->position : Tools::P('position');?>"  name="position" class="form-control" >
							</div>
						</div>
						<input type="hidden" value="<?php echo isset($id)?'edit':'add'?>"  name="sveAttributeGroup">
				</form>
			</div>
		</div>
	</div>
</div>