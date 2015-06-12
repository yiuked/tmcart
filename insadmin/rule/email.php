<?php

if(isset($_POST['emailFrom']))
{
	if($mail_method = Tools::getRequest('TM_MAIL_METHOD'))
		Configuration::updateValue('TM_MAIL_METHOD',$mail_method);
	
	//SMTP setting
	if($smtp_domain = Tools::getRequest('TM_MAIL_DOMAIN'))
		Configuration::updateValue('TM_MAIL_DOMAIN',$smtp_domain);
	if($smtp_server = Tools::getRequest('TM_MAIL_SERVER'))
		Configuration::updateValue('TM_MAIL_SERVER',$smtp_server);
	if($smtp_user = Tools::getRequest('TM_MAIL_USER'))
		Configuration::updateValue('TM_MAIL_USER',$smtp_user);
	if($smtp_passwd = Tools::getRequest('TM_MAIL_PASSWD'))
		Configuration::updateValue('TM_MAIL_PASSWD',$smtp_passwd);
	if($smtp_encryption = Tools::getRequest('TM_MAIL_SMTP_ENCRYPTION'))
		Configuration::updateValue('TM_MAIL_SMTP_ENCRYPTION',$smtp_encryption);
	if($smtp_port = Tools::getRequest('TM_MAIL_SMTP_PORT'))
		Configuration::updateValue('TM_MAIL_SMTP_PORT',$smtp_port);
	echo '<div class="conf">更新成功</div>';
}
require_once(_TM_ADMIN_DIR_.'/errors.php');
?>

<div class="path_bar">
  <div class="path_title">
    <h3> <span style="font-weight: normal;" id="current_obj"> <span class="breadcrumb item-1 ">Email设置</span> </h3>
    <div class="cc_button">
      <ul>
        <li> <a title="Save" href="#" class="toolbar_btn" id="desc-email-save"> <span class="process-icon-save "></span>
          <div>保存</div>
          </a> </li>
        <li> <a title="Back to list" href="index.php?rule=email" class="toolbar_btn" id="desc-email-back"> <span class="process-icon-back "></span>
          <div>返回列表</div>
          </a> </li>
      </ul>
    </div>
  </div>
</div>
<script language="javascript">
	$("#desc-email-save").click(function(){
		$("#email_form").submit();
	})
</script>
<div class="mianForm">
  <form enctype="multipart/form-data" method="post" action="index.php?rule=email" class="defaultForm admincmscontent" id="email_form" name="example">
    <fieldset>
    <legend> <img alt="设置" src="<?php echo $_tmconfig['tm_img_dir'];?>icon/category.png">设置</legend>
    <div class="margin-form">
      <input type="radio" onclick="$('#smtp').slideUp();" <?php echo Configuration::get('TM_MAIL_METHOD')==1?'checked="checked"':'';?> value="1" id="TM_MAIL_METHOD_1" name="TM_MAIL_METHOD">
      <label for="TM_MAIL_METHOD_1" class="t">使用PHP默认函数发送邮件</label>
      <br>
      <input type="radio" onclick="$('#smtp').slideDown();" value="2" id="TM_MAIL_METHOD_2" name="TM_MAIL_METHOD" <?php echo Configuration::get('TM_MAIL_METHOD')==2?'checked="checked"':'';?>>
      <label for="TM_MAIL_METHOD_2" class="t">设置为SMTP发送邮件</label>
      <br>
      <br>
    </div>
    <input type="hidden" name="emailFrom" value=""/>
    </fieldset>
    <div  <?php echo Configuration::get('TM_MAIL_METHOD')==2?'style="display: block;"':'style="display: none;"';?> id="smtp">
      <fieldset>
      <legend> <img src="../img/t/AdminEmails.gif"> E-mail </legend>
      <div id="conf_id_PS_MAIL_DOMAIN" style="clear: both; padding-top:15px;">
        <label class="conf_title">发送邮件域:</label>
        <div class="margin-form">
          <input type="text" value="<?php echo Configuration::get('TM_MAIL_DOMAIN');?>" name="TM_MAIL_DOMAIN" size="30">
          <p class="preference_description">如果不知道，则留空</p>
        </div>
      </div>
      <div class="clear"></div>
      <div id="conf_id_PS_MAIL_SERVER" style="clear: both; padding-top:15px;">
        <label class="conf_title"> SMTP 服务器:</label>
        <div class="margin-form">
          <input type="text" value="<?php echo Configuration::get('TM_MAIL_SERVER');?>" name="TM_MAIL_SERVER" size="30">
          <p class="preference_description">IP地址或者域名</p>
        </div>
      </div>
      <div class="clear"></div>
      <div id="conf_id_PS_MAIL_USER" style="clear: both; padding-top:15px;">
        <label class="conf_title"> SMTP 用户名:</label>
        <div class="margin-form">
          <input type="text" value="<?php echo Configuration::get('TM_MAIL_USER');?>" name="TM_MAIL_USER" size="30">
        </div>
      </div>
      <div class="clear"></div>
      <div id="conf_id_PS_MAIL_PASSWD" style="clear: both; padding-top:15px;">
        <label class="conf_title"> SMTP 密码:</label>
        <div class="margin-form">
          <input type="password" autocomplete="off" value="<?php echo Configuration::get('TM_MAIL_PASSWD');?>" name="TM_MAIL_PASSWD" size="30">
        </div>
      </div>
      <div class="clear"></div>
      <div id="conf_id_PS_MAIL_SMTP_ENCRYPTION" style="clear: both; padding-top:15px;">
        <label class="conf_title"> 加密方式:</label>
        <div class="margin-form">
          <select id="TM_MAIL_SMTP_ENCRYPTION" name="TM_MAIL_SMTP_ENCRYPTION">
            <option selected="selected" value="off">None</option>
            <option value="tls" <?php echo Configuration::get('TM_MAIL_PASSWD')=='tls'?'selected="selected"':'';?>>TLS</option>
            <option value="ssl" <?php echo Configuration::get('TM_MAIL_PASSWD')=='ssl'?'selected="selected"':'';?>>SSL</option>
          </select>
        </div>
      </div>
      <div class="clear"></div>
      <div id="conf_id_PS_MAIL_SMTP_PORT" style="clear: both; padding-top:15px;">
        <label class="conf_title"> 端口:</label>
        <div class="margin-form">
          <input type="text" value="<?php echo Configuration::get('TM_MAIL_SMTP_PORT')?Configuration::get('TM_MAIL_SMTP_PORT'):25;?>" name="TM_MAIL_SMTP_PORT" size="5">
          <p class="preference_description">SMTP发信端口</p>
        </div>
      </div>
      <div class="clear"></div>
      </fieldset>
    </div>
  </form>
</div>
