<?php

if(isset($_POST['baseFrom']))
{
	if($url = Tools::getRequest('TM_SENDORDER_URL'))
		Configuration::updateValue('TM_SENDORDER_URL',$url);
	if($key = Tools::getRequest('TM_SENDORDER_KEY'))
		Configuration::updateValue('TM_SENDORDER_KEY',$key);
	if($shop_name = Tools::getRequest('TM_SENDORDER_SHOP_NAME'))
		Configuration::updateValue('TM_SENDORDER_SHOP_NAME',$shop_name);
	echo '<div class="conf">更新成功</div>';
}
require_once(_TM_ADMIN_DIR_.'/errors.php');
?>
<div class="path_bar">
  <div class="path_title">
    <h3> 
		<span style="font-weight: normal;" id="current_obj">
		<span class="breadcrumb item-1 ">基本设置</span>
	</h3>
    <div class="cc_button">
      <ul>
        <li> <a title="Save" href="#" class="toolbar_btn" id="desc-base-save"> <span class="process-icon-save "></span>
          <div>保存</div>
          </a> </li>
        <li> <a title="Back to list" href="index.php?rule=order" class="toolbar_btn" id="desc-base-back"> <span class="process-icon-back "></span>
          <div>返回列表</div>
          </a> </li>
      </ul>
    </div>
  </div>
</div>
<script language="javascript">
	$("#desc-base-save").click(function(){
		$("#sendorder_form").submit();
	})
</script>
<div class="mianForm">
	<form enctype="multipart/form-data" method="post" action="index.php?rule=sendorder" class="defaultForm admincmscontent" id="sendorder_form" name="example">
		  <fieldset class="small">
  			<legend> <img alt="设置" src="<?php echo $_tmconfig['ico_dir'];?>edit.gif">发送设置</legend>

		 <div style="clear: both; padding-top:15px;" id="conf_id_TM_SENDORDER_URL">
			<label class="conf_title">接收地址:</label>
			<div class="margin-form">
			  <input type="text" name="TM_SENDORDER_URL" value="<?php echo Configuration::get('TM_SENDORDER_URL');?>" size="100">
			</div>
		  </div>
		  <div style="clear: both; padding-top:15px;" id="conf_id_TM_SENDORDER_KEY">
			<label class="conf_title">接收KEY:</label>
			<div class="margin-form">
			  <input type="text" name="TM_SENDORDER_KEY" value="<?php echo Configuration::get('TM_SENDORDER_KEY');?>" size="50">
			</div>
		  </div>
		  <div style="clear: both; padding-top:15px;" id="conf_id_TM_SENDORDER_SHOP_NAME">
			<label class="conf_title">网站标识:</label>
			<div class="margin-form">
			  <input type="text" name="TM_SENDORDER_SHOP_NAME" value="<?php echo Configuration::get('TM_SENDORDER_SHOP_NAME');?>" size="50">
			</div>
		  </div>
		  </fieldset>
		  
		  <input type="hidden" name="baseFrom" value=""/>
	</form>
</div>
