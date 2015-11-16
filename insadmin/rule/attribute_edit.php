<?php
if(isset($_POST['sveAttribute']) && Tools::getRequest('sveAttribute')=='add')
{
	$attribute_group = new Attribute();
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
	$obj = new Attribute($id);
}

if(isset($_POST['sveAttribute']) && Tools::getRequest('sveAttribute')=='edit')
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
						<a href="javascript:void(0)"  class="btn btn-success" id="attribute-save"><span aria-hidden="true" class="glyphicon glyphicon-floppy-saved"></span> 保存</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script language="javascript">
	$("#attribute-save").click(function(){
		$("#attribute_form").submit();
	})
</script>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				属性
			</div>
			<div class="panel-body">
				<form method="post" action="index.php?rule=attribute_edit<?php echo isset($id)?'&id='.$id:''?>" class="form-horizontal" id="attribute_form">
					<div class="form-group">
						<label for="name" class="col-md-2 control-label">属性值</label>
						<div class="col-md-5">
							<input type="text" class="form-control" value="" name="name" placeholder="属性值">
						</div>
					</div>
					<div class="form-group">
						<label for="id_attribute_group" class="col-md-2 control-label">所属属性组</label>
						<div class="col-md-5">
							<?php $attributeGroup = AttributeGroup::getEntitys();?>
							<select id="id_attribute_group" name="id_attribute_group" class="form-control">
								<?php foreach($attributeGroup['entitys'] as $group){?>
									<option value="<?php echo $group['id_attribute_group'];?>"><?php echo $group['name'];?></option>
								<?php }?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="group_type" class="col-md-2 control-label">排序</label>
						<div class="col-md-5">
							<input type="text" value="<?php echo isset($obj) ? $obj->position : Tools::P('position');?>"  name="position" class="form-control" >
						</div>
					</div>
					<input type="hidden" value="<?php echo isset($id)?'edit':'add'?>"  name="sveAttribute">
				</form>
			</div>
		</div>
	</div>
</div>