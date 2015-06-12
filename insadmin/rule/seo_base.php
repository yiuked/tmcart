<?php
if(isset($_POST['SEOBaseFrom']))
{
	if($google_meta = Tools::getRequest('GOOGLEBOT_SHOW'))
		Configuration::updateValue('GOOGLEBOT_SHOW',$google_meta);
	if($allow_cn = Tools::getRequest('ALLOW_CN','NO'))
		Configuration::updateValue('ALLOW_CN',$allow_cn);
	if($open_js = Tools::getRequest('OPEN_JS','NO'))
		Configuration::updateValue('OPEN_JS',$open_js);
	if($open_php = Tools::getRequest('OPEN_PHP','NO'))
		Configuration::updateValue('OPEN_PHP',$open_php);
	if($open_ip = Tools::getRequest('OPEN_IP','NO'))
		Configuration::updateValue('OPEN_IP',$open_ip);
	if($direct = Tools::getRequest('DIRECT_LINK','about:blank'))
		Configuration::updateValue('DIRECT_LINK',$direct);
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
	<form enctype="multipart/form-data" method="post" action="index.php?rule=seo_base" class="defaultForm admincmscontent" id="base_form" name="example">
		  <fieldset class="small">
  			<legend> <img alt="设置" src="<?php echo $_tmconfig['ico_dir'];?>edit.gif">SEO相关配置</legend>

			<label>仅对Google蜘蛛显示Meta: </label>
			<div class="margin-form">
					<input type="radio" <?php if(Configuration::get('GOOGLEBOT_SHOW')=='YES'){echo 'checked="checked"';}?> value="YES" name="GOOGLEBOT_SHOW" >
					<label for="active_on" class="t">
						<img title="Enabled" alt="Enabled" src="<?php echo $_tmconfig['ico_dir'];?>enabled.gif">
					</label>
					<input type="radio" value="NO" name="GOOGLEBOT_SHOW" <?php if(Configuration::get('GOOGLEBOT_SHOW')=='NO'){echo 'checked="checked"';}?>>
					<label for="active_off" class="t">
						<img title="Disabled" alt="Disabled" src="<?php echo $_tmconfig['ico_dir'];?>disabled.gif">
					</label>
			</div>
			<label>允许国内用户访问: </label>
			<div class="margin-form">
					<input type="radio" <?php if(Configuration::get('ALLOW_CN')=='YES'){echo 'checked="checked"';}?> value="YES" name="ALLOW_CN" >
					<label for="active_on" class="t">
						<img title="Enabled" alt="Enabled" src="<?php echo $_tmconfig['ico_dir'];?>enabled.gif">
					</label>
					<input type="radio" value="NO" name="ALLOW_CN" <?php if(Configuration::get('ALLOW_CN')=='NO'){echo 'checked="checked"';}?>>
					<label for="active_off" class="t">
						<img title="Disabled" alt="Disabled" src="<?php echo $_tmconfig['ico_dir'];?>disabled.gif">
					</label>
					<p>
						<input type="checkbox" value="YES" name="OPEN_JS" <?php if(Configuration::get('OPEN_JS')=='YES'){echo 'checked="checked"';}?>>开启JS屏蔽
						<input type="checkbox" value="YES" name="OPEN_PHP" <?php if(Configuration::get('OPEN_PHP')=='YES'){echo 'checked="checked"';}?>>开启PHP屏蔽
						<input type="checkbox" value="YES" name="OPEN_IP" <?php if(Configuration::get('OPEN_IP')=='YES'){echo 'checked="checked"';}?>>开启IP屏蔽
					</p>
					<p>
					跳转到:<input type="text" value="<?php echo Configuration::get('DIRECT_LINK')?Configuration::get('DIRECT_LINK'):Tools::getRequest('DIRECT_LINK','about:blank');?>" name="DIRECT_LINK" size="100">
					</p>
					<p class="preference_description">通过时区与浏览器语言判断，禁用JS则会通过refresh跳转</p>
			</div>
			
		  </fieldset>
		  
		  <input type="hidden" name="SEOBaseFrom" value=""/>
	</form>
</div>
