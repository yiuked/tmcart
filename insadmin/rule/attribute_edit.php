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
<div class="path_bar">
  <div class="path_title">
    <h3> 
		<span style="font-weight: normal;" id="current_obj">
		<span class="breadcrumb item-1 ">属性组<img src="<?php echo $_tmconfig['tm_img_dir'];?>admin/separator_breadcrum.png" style="margin-right:5px" alt="&gt;"> </span>
		<span class="breadcrumb item-2 ">编辑 </span> </span> 
	</h3>
    <div class="cc_button">
      <ul>
        <li> <a title="Save" href="#" class="toolbar_btn" id="entity-save"> <span class="process-icon-save "></span>
          <div>保存</div>
          </a> </li>
        <li> <a title="Back to list" href="index.php?rule=attribute_group" class="toolbar_btn" id="desc-product-back"> <span class="process-icon-back "></span>
          <div>返回列表</div>
          </a> </li>
      </ul>
    </div>
  </div>
</div>
<script language="javascript">
	$("#entity-save").click(function(){
		$("#entity_form").submit();
	})
</script>
<div class="mianForm">
	<form enctype="multipart/form-data" method="post" action="index.php?rule=attribute_edit<?php echo isset($id)?'&id='.$id:''?>" class="defaultForm" id="entity_form" name="example">
		  <fieldset>
  			<legend> <img alt="属性组" src="<?php echo $_tmconfig['ico_dir'];?>category.png">属性组</legend>
			<label>名称: </label>
			<div class="margin-form">
				<div style="display:block; float: left;">
					<input type="text" value="<?php echo isset($obj)?$obj->name:Tools::getRequest('name');?>"  name="name">
					<span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span>
				</div>
				<sup>*</sup>
				<div class="clear"></div>
			</div>
			<label>属性组: </label>
			<div class="margin-form">
			  <?php $attributeGroup = AttributeGroup::getEntitys();?>
			  <select id="id_attribute_group" class="" name="id_attribute_group">
			  <?php foreach($attributeGroup['entitys'] as $group){?>
				<option value="<?php echo $group['id_attribute_group'];?>"><?php echo $group['name'];?></option>
			  <?php }?>
			  </select>
			  <sup>*</sup>
			  <p class="preference_description">选择属性组</p>
			</div>
			<input type="hidden" value="<?php echo isset($id)?'edit':'add'?>"  name="sveAttribute">
		  </fieldset>
	</form>
</div>