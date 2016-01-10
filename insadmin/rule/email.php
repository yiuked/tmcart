<?php

if(isset($_POST['emailFrom']))
{
	if($mail_method = Tools::P('TM_MAIL_METHOD'))
		Configuration::updateValue('TM_MAIL_METHOD',$mail_method);
	//SMTP setting
	if($smtp_domain = Tools::P('TM_MAIL_DOMAIN'))
		Configuration::updateValue('TM_MAIL_DOMAIN',$smtp_domain);
	if($smtp_server = Tools::P('TM_MAIL_SERVER'))
		Configuration::updateValue('TM_MAIL_SERVER',$smtp_server);
	if($smtp_user = Tools::P('TM_MAIL_USER'))
		Configuration::updateValue('TM_MAIL_USER',$smtp_user);
	if($smtp_passwd = Tools::P('TM_MAIL_PASSWD'))
		Configuration::updateValue('TM_MAIL_PASSWD',$smtp_passwd);
	if($smtp_encryption = Tools::P('TM_MAIL_SMTP_ENCRYPTION'))
		Configuration::updateValue('TM_MAIL_SMTP_ENCRYPTION',$smtp_encryption);
	if($smtp_port = Tools::P('TM_MAIL_SMTP_PORT'))
		Configuration::updateValue('TM_MAIL_SMTP_PORT',$smtp_port);
	UIAdminAlerts::conf('配置已更新');
}
if (isset($errors)) {
  UIAdminAlerts::MError($errors);
}

/** 导航 */
$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '系统设置', 'active' => true));
$breadcrumb->add(array('title' => '邮件设置', 'active' => true));
$bread = $breadcrumb->draw();
$btn_group = array(
    array('type' => 'button', 'title' => '保存', 'id' => 'save-email-form', 'class' => 'btn-success', 'icon' => 'save') ,
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');
?>
<script language="javascript">
	$("#save-email-form").click(function(){
		$("#email-form").submit();
	})
</script>
<?php
$form = new UIAdminEditForm('post', 'index.php?rule=email', 'form-horizontal', 'base-form');
$form->items = array(
    'TM_MAIL_METHOD' => array(
        'title' => '网站名称',
        'type' => 'radio',
        'value' => Configuration::get('TM_MAIL_METHOD'),
        'items' => array(
          '1' => '使用PHP默认函数发送邮件',
          '2' => '设置为SMTP发送邮件'
        ),
    ),
    'TM_MAIL_DOMAIN' => array(
        'title' => 'SMTP域名',
        'type' => 'text',
        'value' => Configuration::get('TM_MAIL_DOMAIN'),
    ),
    'TM_MAIL_SERVER' => array(
        'title' => 'SMTP服务器',
        'type' => 'text',
        'value' => Configuration::get('TM_MAIL_SERVER'),
    ),
    'TM_MAIL_USER' => array(
        'title' => 'SMTP用户名',
        'type' => 'text',
        'value' => Configuration::get('TM_MAIL_USER'),
    ),
    'TM_MAIL_PASSWD' => array(
        'title' => 'SMTP密码',
        'type' => 'password',
        'value' => '',
    ),
    'TM_MAIL_SMTP_ENCRYPTION' => array(
        'title' => 'SMTP加密方式',
        'type' => 'radio',
        'value' => Configuration::get('TM_MAIL_SMTP_ENCRYPTION'),
        'items' => array(
            'tls' => 'TLS',
            'ssl' => 'SSL'
        ),
    ),
    'TM_MAIL_SMTP_PORT' => array(
        'title' => 'SMTP端口',
        'type' => 'text',
        'value' => Configuration::get('TM_MAIL_SMTP_PORT'),
    ),
    'saveEmail' => array(
        'type' => 'hidden',
        'value' => 'update',
    ),
);
echo UIViewBlock::area(array('col' => 'col-md-12', 'title' => '编辑', 'body' => $form->draw()), 'panel');
?>