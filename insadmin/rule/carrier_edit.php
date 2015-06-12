<?php
if(isset($_POST['sveCarrier']) && Tools::getRequest('sveCarrier')=='add')
{
	$carrier = new Carrier();
	$carrier->copyFromPost();
	if($carrier->add() && !empty($_FILES['logo']['name'])){
			$carrier->updateCarrierLogo();
	}
	
	if(is_array($carrier->_errors) AND count($carrier->_errors)>0){
		$errors = $carrier->_errors;
	}else{
		$_GET['id']	= $carrier->id;
		echo '<div class="conf">创建对象成功</div>';
	}
}

if(isset($_GET['id'])){
	$id  = (int)$_GET['id'];
	$obj = new Carrier($id);
}

if(isset($_POST['sveCarrier']) && Tools::getRequest('sveCarrier')=='edit')
{
	if(Validate::isLoadedObject($obj)){
		$obj->copyFromPost();
		if($obj->update() && !empty($_FILES['logo']['name'])){
			$obj->updateCarrierLogo();
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
    <h3> <span style="font-weight: normal;" id="current_obj"> <span class="breadcrumb item-1 ">配送<img src="<?php echo $_tmconfig['tm_img_dir'];?>admin/separator_breadcrum.png" style="margin-right:5px" alt="&gt;"> </span> <span class="breadcrumb item-2 ">编辑 </span> </span> </h3>
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
		$("#carrier_form").submit();
	})
</script>
<div class="mianForm">
  <form enctype="multipart/form-data" method="post" action="index.php?rule=carrier_edit<?php echo isset($id)?'&id='.$id:''?>" class="defaultForm admincmscontent" id="carrier_form" name="example">
    <fieldset>
    <legend> <img alt="CMS 分类" src="<?php echo $_tmconfig['ico_dir'];?>category.png">配送</legend>
    <label>配送商: </label>
    <div class="margin-form">
      <div style="display:block; float: left;">
        <input type="text" value="<?php echo isset($obj)?$obj->name:Tools::getRequest('name');?>"  name="name">
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
	   <p class="preference_description"><img src="<?php echo $_tmconfig['car_dir'].$obj->logo;?>" alt="<?php echo $obj->name;?>" /></p>
	   <?php }?>
      <div class="clear"></div>
    </div>
	<label>描述: </label>
    <div class="margin-form">
      <div style="display:block; float: left;">
        <input type="text" value="<?php echo isset($obj)?$obj->description:Tools::getRequest('description');?>"  name="description">
        <span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span> </div>
      <sup>*</sup>
      <p class="preference_description">如:3天内发货，7-10天运到</p>
      <div class="clear"></div>
    </div>
    <label>运费： </label>
    <div class="margin-form">
      <div style="display:block; float: left;">
        <input type="text" value="<?php echo isset($obj)?$obj->shipping:Tools::getRequest('shipping');?>"  name="shipping" size="8">
        <span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span> </div>
      <sup>*</sup>
      <div class="clear"></div>
    </div>
    <label>状态: </label>
    <div class="margin-form">
      <input type="radio" checked="checked" value="1" id="active_on" name="active">
      <label for="active_on" class="t"> <img title="Enabled" alt="Enabled" src="<?php echo $_tmconfig['ico_dir'];?>enabled.gif"> </label>
      <input type="radio" value="0" id="active_off" name="active">
      <label for="active_off" class="t"> <img title="Disabled" alt="Disabled" src="<?php echo $_tmconfig['ico_dir'];?>disabled.gif"> </label>
    </div>
    <input type="hidden" value="<?php echo isset($id)?'edit':'add'?>"  name="sveCarrier">
    </fieldset>
  </form>
</div>
