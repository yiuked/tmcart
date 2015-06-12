<?php
if(isset($_POST['sveState']) && Tools::getRequest('sveState')=='add')
{
	$orderstatus = new State();
	$orderstatus->copyFromPost();
	$orderstatus->add();
	
	if(is_array($orderstatus->_errors) AND count($orderstatus->_errors)>0){
		$errors = $orderstatus->_errors;
	}else{
		$_GET['id']	= $orderstatus->id;
		echo '<div class="conf">创建对象成功</div>';
	}
}

if(isset($_GET['id'])){
	$id  = (int)$_GET['id'];
	$obj = new State($id);
}

if(isset($_POST['sveState']) && Tools::getRequest('sveState')=='edit')
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
    <h3> <span style="font-weight: normal;" id="current_obj"> 
	<span class="breadcrumb item-1 ">国家<img src="<?php echo $_tmconfig['tm_img_dir'];?>admin/separator_breadcrum.png" style="margin-right:5px" alt="&gt;"></span>
	<span class="breadcrumb item-1 ">州/省<img src="<?php echo $_tmconfig['tm_img_dir'];?>admin/separator_breadcrum.png" style="margin-right:5px" alt="&gt;"></span>
	<span class="breadcrumb item-2 ">编辑 </span> </span> </h3>
    <div class="cc_button">
      <ul>
        <li> <a title="Save" href="#" class="toolbar_btn" id="country-save"> <span class="process-icon-save "></span>
          <div>保存</div>
          </a> </li>
        <li> <a title="Back to list" href="index.php?rule=country" class="toolbar_btn" id="desc-product-back"> <span class="process-icon-back "></span>
          <div>返回列表</div>
          </a> </li>
      </ul>
    </div>
  </div>
</div>
<script language="javascript">
	$("#country-save").click(function(){
		$("#country_form").submit();
	})
</script>
<div class="mianForm">
  <form enctype="multipart/form-data" method="post" action="index.php?rule=country_edit<?php echo isset($id)?'&id='.$id:''?>" class="defaultForm admincmscontent" id="country_form" name="example">
    <fieldset>
    <legend> <img alt="州/省" src="<?php echo $_tmconfig['ico_dir'];?>category.png">州/省</legend>
    <label>州/省: </label>
    <div class="margin-form">
      <div style="display:block; float: left;">
        <input type="text" value="<?php echo isset($obj)?$obj->name:Tools::getRequest('name');?>"  name="name">
        <span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span> </div>
      <sup>*</sup>
      <div class="clear"></div>
    </div>
    <label>ISO Code: </label>
    <div class="margin-form">
      <div style="display:block; float: left;">
        <input type="text" value="<?php echo isset($obj)?$obj->iso_code:Tools::getRequest('iso_code');?>"  name="color">
        <span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span> </div>
      <sup>*</sup>
      <p class="preference_description">用于区分国家的国际ISO 代码，格式如:美国对应的ISO Code为'US'.</p>
      <div class="clear"></div>
    </div>
    <label>国家: </label>
    <div class="margin-form">
      <div style="display:block; float: left;">
	    <?php $countrys = Country::getEntity(true);?>
        <select id="id_country" name="id_country">
			<option value="NULL">--选择--</option>
			<?php foreach($countrys['entitys'] as $country){?>
			<option value="<?php echo $country['id_country'];?>" <?php echo isset($obj)?($country['id_country']==$obj->id_country?'selected="selected"':''):''; ?>><?php echo $country['name'];?></option>
			<?php }?>
		</select>
       </div>
      <sup>*</sup>
      <div class="clear"></div>
    </div>
	<label>状态： </label>
    <div class="margin-form">
      <input type="radio" checked="checked" value="1" id="active_on" name="active">
      <label for="active_on" class="t"> <img title="Enabled" alt="Enabled" src="<?php echo $_tmconfig['ico_dir'];?>enabled.gif"> </label>
      <input type="radio" value="0" id="active_off" name="active" <?php echo isset($obj)?($obj->active==0?'checked="checked"':''):'';?>>
      <label for="active_off" class="t"> <img title="Disabled" alt="Disabled" src="<?php echo $_tmconfig['ico_dir'];?>disabled.gif"> </label>
    </div>
    <input type="hidden" value="<?php echo isset($id)?'edit':'add'?>"  name="sveState">
    </fieldset>
  </form>
</div>