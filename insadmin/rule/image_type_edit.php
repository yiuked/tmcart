<?php
if(isset($_POST['sveImageType']) && Tools::getRequest('sveImageType')=='add')
{
	$image_type = new ImageType();
	$image_type->copyFromPost();
	if($image_type->add() && intval($_POST['reloadImages'])){
			$image_type->reloadImages();
	}
	
	if(is_array($image_type->_errors) AND count($image_type->_errors)>0){
		$errors = $image_type->_errors;
	}else{
		$_GET['id']	= $image_type->id;
		echo '<div class="conf">创建对象成功</div>';
	}
}

if(isset($_GET['id'])){
	$id  = (int)$_GET['id'];
	$obj = new ImageType($id);
}

if(isset($_POST['sveImageType']) && Tools::getRequest('sveImageType')=='edit')
{
	if(Validate::isLoadedObject($obj)){
		$obj->copyFromPost();
		
		if($obj->update() && isset($_POST['reloadImages'])){
			$obj->reloadImages();
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
    <h3> <span style="font-weight: normal;" id="current_obj"> <span class="breadcrumb item-1 ">图片配置<img src="<?php echo $_tmconfig['tm_img_dir'];?>admin/separator_breadcrum.png" style="margin-right:5px" alt="&gt;"> </span> <span class="breadcrumb item-2 ">编辑 </span> </span> </h3>
    <div class="cc_button">
      <ul>
        <li> <a title="Save" href="#" class="toolbar_btn" id="image_type-save"> <span class="process-icon-save "></span>
          <div>保存</div>
          </a> </li>
        <li> <a title="Back to list" href="index.php?rule=image_type" class="toolbar_btn" id="desc-product-back"> <span class="process-icon-back "></span>
          <div>返回列表</div>
          </a> </li>
      </ul>
    </div>
  </div>
</div>
<script language="javascript">
	$("#image_type-save").click(function(){
		$("#image_type_form").submit();
	})
</script>
<div class="mianForm">
  <form enctype="multipart/form-data" method="post" action="index.php?rule=image_type_edit<?php echo isset($id)?'&id='.$id:''?>" class="defaultForm admincmscontent" id="image_type_form" name="example">
    <fieldset>
    <legend> <img alt="CMS 分类" src="<?php echo $_tmconfig['ico_dir'];?>category.png">配送</legend>
    <label>名称: </label>
    <div class="margin-form">
      <div style="display:block; float: left;">
        <input type="text" value="<?php echo isset($obj)?$obj->name:Tools::getRequest('name');?>"  name="name">
        <span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span> </div>
      <sup>*</sup>
      <div class="clear"></div>
    </div>
    <label>高: </label>
    <div class="margin-form">
      <div style="display:block; float: left;">
        <input type="text" value="<?php echo isset($obj)?$obj->height:Tools::getRequest('height');?>"  name="height">
       </div>
      <div class="clear"></div>
    </div>
	<label>宽: </label>
    <div class="margin-form">
      <div style="display:block; float: left;">
        <input type="text" value="<?php echo isset($obj)?$obj->width:Tools::getRequest('width');?>"  name="width">
        <span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span> </div>
      <sup>*</sup>
      <div class="clear"></div>
    </div>
    <label>应用： </label>
    <div class="margin-form">
      <div style="display:block; float: left;">
        <input type="text" value="<?php echo isset($obj)?$obj->type:Tools::getRequest('type');?>"  name="type" size="8">
        <span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span> </div>
      <sup>*</sup>
	  <p class="preference_description">可选：product,category</p>
      <div class="clear"></div>
    </div>
	<label>重新生成图片： </label>
    <div class="margin-form">
      <div style="display:block; float: left;">
        <input type="checkbox" value="1" name="reloadImages" />
      </div>
      <div class="clear"></div>
    </div>
    <input type="hidden" value="<?php echo isset($id)?'edit':'add'?>"  name="sveImageType">
    </fieldset>
  </form>
</div>
