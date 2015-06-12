<?php
if(isset($_POST['sveOrderStatus']) && Tools::getRequest('sveOrderStatus')=='add')
{
	$orderstatus = new OrderStatus();
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
	$obj = new OrderStatus($id);
}

if(isset($_POST['sveOrderStatus']) && Tools::getRequest('sveOrderStatus')=='edit')
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
    <h3> <span style="font-weight: normal;" id="current_obj"> <span class="breadcrumb item-1 ">货币<img src="<?php echo $_tmconfig['tm_img_dir'];?>admin/separator_breadcrum.png" style="margin-right:5px" alt="&gt;"> </span> <span class="breadcrumb item-2 ">编辑 </span> </span> </h3>
    <div class="cc_button">
      <ul>
        <li> <a title="Save" href="#" class="toolbar_btn" id="emploay-save"> <span class="process-icon-save "></span>
          <div>保存</div>
          </a> </li>
        <li> <a title="Back to list" href="index.php?rule=order_status" class="toolbar_btn" id="desc-product-back"> <span class="process-icon-back "></span>
          <div>返回列表</div>
          </a> </li>
      </ul>
    </div>
  </div>
</div>
<script language="javascript">
	$("#emploay-save").click(function(){
		$("#orderstatus_form").submit();
	})
</script>
<div class="mianForm">
  <form enctype="multipart/form-data" method="post" action="index.php?rule=order_status_edit<?php echo isset($id)?'&id='.$id:''?>" class="defaultForm admincmscontent" id="orderstatus_form" name="example">
    <fieldset>
    <legend> <img alt="CMS 分类" src="<?php echo $_tmconfig['ico_dir'];?>category.png">定单状态</legend>
    <label>状态名: </label>
    <div class="margin-form">
      <div style="display:block; float: left;">
        <input type="text" value="<?php echo isset($obj)?$obj->name:Tools::getRequest('name');?>"  name="name">
        <span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span> </div>
      <sup>*</sup>
      <div class="clear"></div>
    </div>
    <label>标识颜色: </label>
    <div class="margin-form">
      <div style="display:block; float: left;">
        <input type="text" value="<?php echo isset($obj)?$obj->color:Tools::getRequest('color');?>"  name="color">
        <span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span> </div>
      <sup>*</sup>
      <p class="preference_description">用于区分标识定单状态，格式如:#FF9900</p>
      <div class="clear"></div>
    </div>
    <label>发送邮件： </label>
    <div class="margin-form">
      <div style="display:block; float: left;">
        <input type="checkbox" value="1" <?php echo (isset($obj)&&$obj->send_mail)?'checked="checked"':'';?> name="send_mail">
		<span class="preference_description">定单更变为此状态时，是否发向客户发送邮件</span>
      </div>
      <div class="clear"></div>
    </div>
    <label>邮件模板： </label>
    <div class="margin-form">
      <div style="display:block; float: left;">
        <input type="text" value="<?php echo isset($obj)?$obj->email_tpl:Tools::getRequest('email_tpl');?>"  name="email_tpl">
        <span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span> </div>
      <p class="preference_description">注意,汇率是相对的,默认货币的汇率为1,其它货币是相对默认货币的汇率</p>
      <div class="clear"></div>
    </div>
	<label>模板状态： </label>
    <div class="margin-form">
      <input type="radio" checked="checked" value="1" id="active_on" name="active">
      <label for="active_on" class="t"> <img title="Enabled" alt="Enabled" src="<?php echo $_tmconfig['ico_dir'];?>enabled.gif"> </label>
      <input type="radio" value="0" id="active_off" name="active">
      <label for="active_off" class="t"> <img title="Disabled" alt="Disabled" src="<?php echo $_tmconfig['ico_dir'];?>disabled.gif"> </label>
    </div>
    <input type="hidden" value="<?php echo isset($id)?'edit':'add'?>"  name="sveOrderStatus">
    </fieldset>
  </form>
</div>