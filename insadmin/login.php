<?php
include_once(dirname(__FILE__)."/../config/config.php");
if(isset($_GET['logout']))
	$cookie->adminLogout();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
<meta name="robots" content="NOFOLLOW, NOINDEX" />
<title>Administration panel - PrestaShop&trade;</title>
<link href="../css/admin/login.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="../js/jquery/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="../js/admin/login.js"></script>
<script type="text/javascript" src="../js/jquery/ui/jquery.ui.widget.min.js"></script>
<script type="text/javascript" src="../js/jquery/ui/jquery.effects.core.min.js"></script>
<script type="text/javascript" src="../js/jquery/ui/jquery.effects.shake.min.js"></script>
<script type="text/javascript" src="../js/jquery/ui/jquery.effects.slide.min.js"></script>
<link rel="shortcut icon" href="../images/favicon.ico" />
<style type="text/css">
		div#header_infos, div#header_infos a#header_shopname, div#header_infos a#header_logout, div#header_infos a#header_foaccess {
		color:#383838
		}
	</style>
</head>
<body style="">
<div id="main">
  <div id="content">
    <div id="container">
      <div id="error" class="hide"> </div>
      <br />
      <div id="login">
        <h1>If Shop</h1>
        <form action="#" id="login_form" method="post">
          <div class="field">
            <label for="email">E-mail 地址:</label>
            <input type="text" id="email" name="email" class="input email_field" value="" />
          </div>
          <div class="field">
            <label for="passwd">密 码:</label>
            <input id="passwd" type="password" name="passwd" class="input password_field" value=""/>
          </div>
          <div class="field">
            <input type="submit" name="submitLogin" value="登 录" class="button fl margin-right-5" />
            <p class="fl no-margin hide ajax-loader"> <img src="<?php echo $_tmconfig['tm_img_dir'];?>admin/loader.gif"> </p>
            <p class="fr no-margin"> <a href="#" class="show-forgot-password">忘记密码?</a> </p>
            <div class="clear"></div>
          </div>
          <input type="hidden" name="redirect" id="redirect" value="index.php?controller=&token=71673a774de7b53615ba6d363adc95a6"/>
        </form>
        <form action="#" id="forgot_password_form" method="post" class="hide">
          <h2 class="no-margin">忘记了你的密码吗?</h2>
          <p class="bold">请输入注册过程中输入的邮箱地址，系统将发送密码到此邮箱.</p>
          <div class="field">
            <label>E-mail 地址:</label>
            <input type="text" name="email_forgot" id="email_forgot" class="input email_field" />
          </div>
          <div class="field">
            <input type="submit" name="submit" value="发送" class="button fl margin-right-5" />
            <p class="fl no-margin hide ajax-loader"> <img src="<?php echo $_tmconfig['tm_img_dir'];?>admin/loader.gif"> </p>
            <p class="fr no-margin"> <a href="#" class="show-login-form">返回登录</a> </p>
            <div class="clear"></div>
          </div>
        </form>
      </div>
      <h2><a href="http://www.prestashop.com">&copy; 2005 - 2012 Copyright by PrestaShop. all rights reserved.</a></h2>
    </div>
  </div>
</div>
<div id="scrollTop"><a href="#top"></a></div>
</body>
</html>
