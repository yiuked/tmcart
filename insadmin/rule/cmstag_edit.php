<?php
if(isset($_POST['sveCMSTag']) && Tools::getRequest('sveCMSTag')=='add')
{
	$cmstag = new CMSTag();
	$cmstag->copyFromPost();
	$cmstag->add();
	
	if(is_array($cmstag->_errors) AND count($cmstag->_errors)>0){
		$errors = $cmstag->_errors;
	}else{
		$_GET['id']	= $cmstag->id;
		echo '<div class="conf">创建标签成功</div>';
	}
}

if(isset($_GET['id'])){
	$id  = (int)$_GET['id'];
	$obj = new CMSTag($id);
}

if(isset($_POST['sveCMSTag']) && Tools::getRequest('sveCMSTag')=='edit')
{
	if(Validate::isLoadedObject($obj)){
		$obj->copyFromPost();
		$obj->update();
	}
	
	if(is_array($obj->_errors) AND count($obj->_errors)>0){
		$errors = $obj->_errors;
	}else{
		echo '<div class="conf">更新标签成功</div>';
	}

}
require_once(dirname(__FILE__).'/../errors.php');
?>
<div class="path_bar">
  <div class="path_title">
    <h3> 
		<span style="font-weight: normal;" id="current_obj">
		<span class="breadcrumb item-1 ">单页<img src="<?php echo $_tmconfig['tm_img_dir'];?>admin/separator_breadcrum.png" style="margin-right:5px" alt="&gt;"> </span>
		<span class="breadcrumb item-2 ">编辑 </span> </span> 
	</h3>
    <div class="cc_button">
      <ul>
        <li> <a title="Save" href="#" class="toolbar_btn" id="cmstag-save"> <span class="process-icon-save "></span>
          <div>保存</div>
          </a> </li>
        <li> <a title="Back to list" href="javascript:history.back();" class="toolbar_btn" id="desc-cmstag-back"> <span class="process-icon-back "></span>
          <div>返回列表</div>
          </a> </li>
      </ul>
    </div>
  </div>
</div>
<script language="javascript">
	$("#cmstag-save").click(function(){
		$("#cmstag_form").submit();
	})
</script>
<div class="mianForm">
	<form enctype="multipart/form-data" method="post" action="index.php?rule=editcmstag<?php echo isset($id)?'&id='.$id:''?>" class="defaultForm" id="cmstag_form" name="example">
		  <fieldset>
  			<legend> <img alt="CMS 分类" src="<?php echo $_tmconfig['tm_img_dir'];?>icon/category.png">编辑单面</legend>
			<div class="entity_from">
				<label>Tag名称: </label>
				<div class="margin-form">
					<div style="display:block; float: left;">
						<input type="text" class="text_input" value="<?php echo isset($obj)?$obj->name:Tools::getRequest('name');?>"  name="name">
						<span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span>
					</div>
					<sup>*</sup>
					<div class="clear"></div>
				</div>
			</div>
			<div class="clear"></div>
			<div class="entity_from">
				<label>Meta Title: </label>
				<div class="margin-form">
					<div style="display:block; float: left;">
						<input type="text" class="text_input" value="<?php echo isset($obj)?$obj->meta_title:Tools::getRequest('meta_title');?>"  name="meta_title">
						<span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span>
					</div>
					<div class="clear"></div>
				</div>
			</div>
			<div class="clear"></div>
			<div class="entity_from">
				<label>Meta Keywords: </label>
				<div class="margin-form">
					<div style="display:block; float: left;">
						<input type="text" class="text_input" value="<?php echo isset($obj)?$obj->meta_keywords:Tools::getRequest('meta_keywords');?>"  name="meta_keywords">
						<span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span>
					</div>
					<div class="clear"></div>
				</div>
			</div>
			<div class="clear"></div>
			<div class="entity_from">
				<label>Meta Description: </label>
				<div class="margin-form">
					<div style="display:block; float: left;">
						<input type="text" class="text_input" value="<?php echo isset($obj)?$obj->meta_description:Tools::getRequest('meta_description');?>"  name="meta_description">
						<span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span>
					</div>
					<div class="clear"></div>
				</div>
			</div>
			<div class="clear"></div>
			<div class="entity_from">
				<label>Url Rwrite: </label>
				<div class="margin-form">
					<div style="display:block; float: left;">
						<input type="text" class="text_input" value="<?php echo isset($obj)?$obj->rewrite:Tools::getRequest('rewrite');?>"  name="rewrite">
						<span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span>
					</div>
					<sup>*</sup>
					<div class="clear"></div>
				</div>
			</div>
			<div class="clear"></div>
			<input type="hidden" value="<?php echo isset($id)?'edit':'add'?>"  name="sveCMSTag">
			<input type="hidden" value="<?php echo isset($obj)?$obj->add_date:Tools::getRequest('add_date');?>"  name="add_date">
		  </fieldset>
	</form>
</div>