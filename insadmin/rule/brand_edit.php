<?php
if(isset($_POST['sveBrand']) && Tools::getRequest('sveBrand')=='add')
{
	$brand = new Brand();
	$brand->copyFromPost();
	if($brand->add() && !empty($_FILES['logo']['name'])){
			$brand->updateLogo();
	}

	if(is_array($brand->_errors) AND count($brand->_errors)>0){
		$errors = $brand->_errors;
	}else{
		$_GET['id']	= $brand->id;
		echo '<div class="conf">创建对象成功</div>';
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
		if($obj->update() && !empty($_FILES['logo']['name'])){
			$obj->updateLogo();
		}
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
    <h3> <span style="font-weight: normal;" id="current_obj"> <span class="breadcrumb item-1 ">品牌<img src="<?php echo $_tmconfig['tm_img_dir'];?>admin/separator_breadcrum.png" style="margin-right:5px" alt="&gt;"> </span> <span class="breadcrumb item-2 ">编辑 </span> </span> </h3>
    <div class="cc_button">
      <ul>
        <li> <a title="Save" href="#" class="toolbar_btn" id="emploay-save"> <span class="process-icon-save "></span>
          <div>保存</div>
          </a> </li>
        <li> <a title="Back to list" href="javascript:history.back();" class="toolbar_btn" id="desc-product-back"> <span class="process-icon-back "></span>
          <div>返回列表</div>
          </a> </li>
      </ul>
    </div>
  </div>
</div>
<script language="javascript">
	$("#emploay-save").click(function(){
		$("#brand_form").submit();
	})
</script>
<div class="mianForm">
  <form enctype="multipart/form-data" method="post" action="index.php?rule=brand_edit<?php echo isset($id)?'&id='.$id:''?>" class="defaultForm admincmscontent" id="brand_form" name="example">
    <fieldset>
    <legend> <img alt="CMS 分类" src="<?php echo $_tmconfig['ico_dir'];?>category.png">品牌</legend>
    <label>品牌: </label>
    <div class="margin-form">
      <div style="display:block; float: left;">
        <input type="text" value="<?php echo isset($obj)?$obj->name:Tools::getRequest('name');?>"  name="name" class="text_input" onchange="copy2friendlyURL()" id="name">
        <span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span> </div>
      <sup>*</sup>
      <div class="clear"></div>
    </div>
    <label>LOGO: </label>
    <div class="margin-form">
      <div style="display:block; float: left;">
        <input type="file" value=""  name="logo">
       </div>
	   <?php if(isset($obj) && strlen($obj->logo)>3){?>
	   <div class="clear"></div>
	   <p class="preference_description"><img src="<?php echo $_tmconfig['brand_dir'].$obj->logo;?>" alt="<?php echo $obj->name;?>" /></p>
	   <?php }?>
      <div class="clear"></div>
    </div>
	<label>内容描述: </label>
	<div class="margin-form">
		<div style="display:block; float: left;">
			<textarea name="description" style="width:800px;height:100px;"><?php echo isset($obj)?$obj->description:Tools::getRequest('description');?></textarea>
		</div>
		<div class="clear"></div>
	</div>
	<label>Meta Title: </label>
	<div class="margin-form">
		<div style="display:block; float: left;">
			<input type="text" class="text_input" value="<?php echo isset($obj)?$obj->meta_title:Tools::getRequest('meta_title');?>"  name="meta_title">
			<span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span>
		</div>
		<div class="clear"></div>
	</div>
	<label>Meta Keywords: </label>
	<div class="margin-form">
		<div style="display:block; float: left;">
			<input type="text" class="text_input" value="<?php echo isset($obj)?$obj->meta_keywords:Tools::getRequest('meta_keywords');?>"  name="meta_keywords">
			<span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span>
		</div>
		<div class="clear"></div>
	</div>
	<label>Meta Description: </label>
	<div class="margin-form">
		<div style="display:block; float: left;">
			<input type="text" class="text_input" value="<?php echo isset($obj)?$obj->meta_description:Tools::getRequest('meta_description');?>"  name="meta_description">
			<span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span>
		</div>
		<div class="clear"></div>
	</div>
	<label>友好URL链接: </label>
	<div class="margin-form">
		<div style="display:block; float: left;">
			<input type="text" class="text_input" value="<?php echo isset($obj)?$obj->rewrite:Tools::getRequest('rewrite');?>" onchange="this.value = str2url(this.value);" name="rewrite" id="rewrite">
			<span name="help_box" class="hint" style="display: none;">只能包含数字,字母及"-"<span class="hint-pointer">&nbsp;</span></span>
		</div>
		<sup>*</sup>
		<div class="clear"></div>
	</div>
    <input type="hidden" value="<?php echo isset($id)?'edit':'add'?>"  name="sveBrand">
    </fieldset>
  </form>
</div>
