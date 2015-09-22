<?php
if(isset($_POST['sveCurrency']) && Tools::getRequest('sveCurrency')=='add')
{
	$currency = new Currency();
	$currency->copyFromPost();
	$currency->add();
	
	if(is_array($currency->_errors) AND count($currency->_errors)>0){
		$errors = $currency->_errors;
	}else{
		$_GET['id']	= $currency->id;
		echo '<div class="conf">创建对象成功</div>';
	}
}

if(isset($_GET['id'])){
	$id  = (int)$_GET['id'];
	$obj = new Currency($id);
}

if(isset($_POST['sveCurrency']) && Tools::getRequest('sveCurrency')=='edit')
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
        <li> <a title="Back to list" href="index.php?rule=currency" class="toolbar_btn" id="desc-product-back"> <span class="process-icon-back "></span>
          <div>返回列表</div>
          </a> </li>
      </ul>
    </div>
  </div>
</div>
<script language="javascript">
	$("#emploay-save").click(function(){
		$("#currency_form").submit();
	})
</script>
<div class="mianForm">
  <form enctype="multipart/form-data" method="post" action="index.php?rule=currency_edit<?php echo isset($id)?'&id='.$id:''?>" class="defaultForm admincmscontent" id="currency_form" name="example">
    <fieldset>
    <legend> <img alt="CMS 分类" src="<?php echo $_tmconfig['ico_dir'];?>category.png">货币</legend>
    <label>货币名称: </label>
    <div class="margin-form">
      <div style="display:block; float: left;">
        <input type="text" value="<?php echo isset($obj)?$obj->name:Tools::getRequest('name');?>"  name="name">
        <span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span> </div>
      <sup>*</sup>
      <div class="clear"></div>
    </div>
    <label>ISO 代码: </label>
    <div class="margin-form">
      <div style="display:block; float: left;">
        <input type="text" value="<?php echo isset($obj)?$obj->iso_code:Tools::getRequest('iso_code');?>"  name="iso_code">
        <span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span> </div>
      <sup>*</sup>
      <p class="preference_description">ISO代码(如: USD代表美元，EUR代表欧元)...</p>
      <div class="clear"></div>
    </div>
	<label>ISO数字代码: </label>
    <div class="margin-form">
      <div style="display:block; float: left;">
        <input type="text" value="<?php echo isset($obj)?$obj->iso_code_num:Tools::getRequest('iso_code_num');?>"  name="iso_code_num">
        <span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span> </div>
      <sup>*</sup>
      <p class="preference_description">ISO数字代码(如：840代表美元，978代表欧元)...</p>
      <div class="clear"></div>
    </div>
    <label>货币符号： </label>
    <div class="margin-form">
      <div style="display:block; float: left;">
        <input type="text" value="<?php echo isset($obj)?$obj->sign:Tools::getRequest('sign');?>"  name="sign" size="6">
        <span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span> </div>
      <sup>*</sup>
      <p class="preference_description">ISO货币符号(如:$,€)...</p>
      <div class="clear"></div>
    </div>
    <label>汇率： </label>
    <div class="margin-form">
      <div style="display:block; float: left;">
        <input type="text" value="<?php echo isset($obj)?$obj->conversion_rate:Tools::getRequest('conversion_rate');?>"  name="conversion_rate">
        <span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span> </div>
      <sup>*</sup>
      <p class="preference_description">注意,汇率是相对的,默认货币的汇率为1,其它货币是相对默认货币的汇率</p>
      <div class="clear"></div>
    </div>
	<?php
		$format = isset($obj)?$obj->format:Tools::getRequest('format');
	?>
	<label>货币显示格式： </label>
    <div class="margin-form">
      <select size="5" id="format" class="" name="format">
        <option value="1" <?php echo $format==1?'selected="selected"':'';?>>X0,000.00 (美元格式)</option>
        <option value="2" <?php echo $format==2?'selected="selected"':'';?>>0 000,00X (欧元格式)</option>
        <option value="3" <?php echo $format==3?'selected="selected"':'';?>>X0.000,00</option>
        <option value="4" <?php echo $format==4?'selected="selected"':'';?>>0,000.00X</option>
        <option value="5" <?php echo $format==5?'selected="selected"':'';?>>0 000.00X</option>
      </select>
      <sup>*</sup>
      <p class="preference_description">此设置将用于所有价格显示</p>
    </div>
    <label>状态: </label>
    <div class="margin-form">
      <input type="radio" checked="checked" value="1" id="active_on" name="active">
      <label for="active_on" class="t"> <img title="Enabled" alt="Enabled" src="<?php echo $_tmconfig['ico_dir'];?>enabled.gif"> </label>
      <input type="radio" value="0" id="active_off" name="active">
      <label for="active_off" class="t"> <img title="Disabled" alt="Disabled" src="<?php echo $_tmconfig['ico_dir'];?>disabled.gif"> </label>
    </div>
    <input type="hidden" value="<?php echo isset($id)?'edit':'add'?>"  name="sveCurrency">
    </fieldset>
  </form>
</div>
