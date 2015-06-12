<?php

if(isset($_POST['baseFrom']))
{
	if($shop_name = Tools::getRequest('TM_SHOP_NAME'))
		Configuration::updateValue('TM_SHOP_NAME',$shop_name);
	if($shop_email = Tools::getRequest('TM_SHOP_EMAIL'))
		Configuration::updateValue('TM_SHOP_EMAIL',$shop_email);
	if($shop_domain = Tools::getRequest('TM_SHOP_DOMAIN'))
		Configuration::updateValue('TM_SHOP_DOMAIN',$shop_domain);
	if($pre_page = Tools::getRequest('TM_PRODUCTS_PER_PAGE'))
		Configuration::updateValue('TM_PRODUCTS_PER_PAGE',$pre_page);
	if($page_list = Tools::getRequest('TM_PRODUCTS_PER_PAGE_LIST'))
		Configuration::updateValue('TM_PRODUCTS_PER_PAGE_LIST',$page_list);
	if($id_country = Tools::getRequest('TM_DEFAULT_COUNTRY_ID'))
		Configuration::updateValue('TM_DEFAULT_COUNTRY_ID',$id_country);
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
        <li> <a title="Back to list" href="index.php?rule=base" class="toolbar_btn" id="desc-base-back"> <span class="process-icon-back "></span>
          <div>返回列表</div>
          </a> </li>
      </ul>
    </div>
  </div>
</div>
<script language="javascript">
	$("#desc-base-save").click(function(){
		$("#base_form").submit();
	})
</script>
<div class="mianForm">
	<form enctype="multipart/form-data" method="post" action="index.php?rule=base" class="defaultForm admincmscontent" id="base_form" name="example">
		  <fieldset class="small">
  			<legend> <img alt="设置" src="<?php echo $_tmconfig['ico_dir'];?>edit.gif">网站设置</legend>

		 <div style="clear: both; padding-top:15px;" id="conf_id_TM_SHOP_NAME">
			<label class="conf_title"> 网站名称:</label>
			<div class="margin-form">
			  <input type="text" size="50" name="TM_SHOP_NAME" value="<?php echo Configuration::get('TM_SHOP_NAME');?>">
			</div>
		  </div>
		  <div style="clear: both; padding-top:15px;" id="conf_id_TM_SHOP_EMAIL">
			<label class="conf_title"> E-Mail:</label>
			<div class="margin-form">
			  <input type="text" size="30" name="TM_SHOP_EMAIL" value="<?php echo Configuration::get('TM_SHOP_EMAIL');?>">
			</div>
		  </div>
		  <div style="clear: both; padding-top:15px;" id="conf_id_TM_SHOP_URL">
			<label class="conf_title"> 网站域名:</label>
			<div class="margin-form">
			  <input type="text" size="50" name="TM_SHOP_DOMAIN" value="<?php echo Configuration::get('TM_SHOP_DOMAIN');?>">
			</div>
		  </div>
		  <div style="clear: both; padding-top:15px;" id="conf_id_TM_DEFAULT_COUNTRY_ID">
			<label class="conf_title"> 默认国家:</label>
		<?php
						$countrys = Country::getEntity(true,1,500);
					?>
		<div class="margin-form">
		  <select id="TM_DEFAULT_COUNTRY_ID" name="TM_DEFAULT_COUNTRY_ID">
			<option value="NULL">--选择--</option>
			<?php foreach($countrys['entitys'] as $country){?>
			<option value="<?php echo $country['id_country'];?>" <?php echo  Configuration::get('TM_DEFAULT_COUNTRY_ID')==$country['id_country']?'selected="selected"':''?>><?php echo $country['name'];?></option>
			<?php }?>
		  </select>
		  <div class="clear"></div>
		</div>
		  </fieldset>
		  
		  <fieldset class="small">
  			<legend> <img alt="设置" src="<?php echo $_tmconfig['ico_dir'];?>edit.gif">商品设置</legend>

		 <div style="clear: both; padding-top:15px;" id="conf_id_TM_PRODUCTS_PER_PAGE">
			<label class="conf_title">每页显示数量:</label>
			<div class="margin-form">
			  <input type="text" name="TM_PRODUCTS_PER_PAGE" value="<?php echo Configuration::get('TM_PRODUCTS_PER_PAGE');?>">
			</div>
		  </div>
		  <div style="clear: both; padding-top:15px;" id="conf_id_TM_PRODUCTS_PER_PAGE_LIST">
			<label class="conf_title">允许每页显示:</label>
			<div class="margin-form">
			  <input type="text" name="TM_PRODUCTS_PER_PAGE_LIST" value="<?php echo Configuration::get('TM_PRODUCTS_PER_PAGE_LIST');?>">
			  <p class="preference_description">以逗号分隔，最好为每页显示的数量的公倍数.如:8,24,40</p>
			</div>
		  </div>
		  </fieldset>
		  
		  <input type="hidden" name="baseFrom" value=""/>
	</form>
</div>
