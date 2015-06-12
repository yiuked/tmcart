<?php
if(isset($_POST['sveColor']) && Tools::getRequest('sveColor')=='add')
{
	$color = new Color();
	$color->name = strtolower(Tools::getRequest('name'));
	$color->code = strtolower(Tools::getRequest('code'));
	$color->rewrite = strtolower(Tools::getRequest('rewrite'));
	$color->add();
	
	if(is_array($color->_errors) AND count($color->_errors)>0){
		$errors = $color->_errors;
	}else{
		$_GET['id']	= $color->id;
		echo '<div class="conf">创建对象成功</div>';
	}
}

if(isset($_GET['id'])){
	$id  = (int)$_GET['id'];
	$obj = new Color($id);
}

if(isset($_POST['sveColor']) && Tools::getRequest('sveColor')=='edit')
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

$colors = Color::getEntitys();

require_once(dirname(__FILE__).'/../errors.php');
?>
<div class="path_bar">
  <div class="path_title">
    <h3> 
		<span style="font-weight: normal;" id="current_obj">
		<span class="breadcrumb item-1 ">颜色管理<img src="<?php echo $_tmconfig['tm_img_dir'];?>admin/separator_breadcrum.png" style="margin-right:5px" alt="&gt;"> </span>
		<span class="breadcrumb item-2 ">编辑 </span> </span> 
	</h3>
    <div class="cc_button">
      <ul>
        <li> <a title="Back to list" href="javascript:history.back();" class="toolbar_btn" id="desc-product-back"> <span class="process-icon-back "></span>
          <div>返回列表</div>
          </a> </li>
      </ul>
    </div>
  </div>
</div>
<div class="mianForm">
	<form enctype="multipart/form-data" method="post" action="index.php?rule=color_edit<?php echo isset($id)?'&id='.$id:''?>" class="defaultForm" id="entity_form" name="example">
		  <fieldset>
  			<legend> <img alt="属性组" src="<?php echo $_tmconfig['ico_dir'];?>category.png">颜色管理</legend>
			<label>颜色值: </label>
			<div class="margin-form">
				<div style="display:block; float: left;">
					<input type="text" value="<?php echo isset($obj)?$obj->code:Tools::getRequest('code');?>"  name="code" id="code">
					<span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span>
				</div>
				<sup>*</sup>
				<div class="clear"></div>
			</div>
			<label>颜色效果: </label>
			<div class="margin-form">
				<div id="showColor" style="width:60px;height:40px;border:2px solid #333;">点击查看</div>
				<div class="clear"></div>
			</div>
			<label>名称: </label>
			<div class="margin-form">
				<div style="display:block; float: left;">
					<input type="text" value="<?php echo isset($obj)?$obj->name:Tools::getRequest('name');?>"  name="name" id="name" onkeyup="copy2friendlyURL();">
					<span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span>
				</div>
				<sup>*</sup>
				<div class="clear"></div>
			</div>
			<label>友好URL: </label>
			<div class="margin-form">
				<div style="display:block; float: left;">
					<input type="text" value="<?php echo isset($obj)?$obj->rewrite:Tools::getRequest('rewrite');?>"  name="rewrite" id="rewrite" onchange="this.value = str2url(this.value);" size="128">
					<span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span>
				</div>
				<sup>*</sup>
				<div class="clear"></div>
			</div>
			<div class="margin-form">
				<input type="submit" name="submit" value="提交"  id="submit"/>
			</div>
			<input type="hidden" value="<?php echo isset($id)?'edit':'add'?>"  name="sveColor">
		  </fieldset>
	</form>
</div>
<script language="javascript">
	$("#showColor").click(function(){
		var color = $("#code").val();
		$(this).css("background-color",color);
	})
</script>