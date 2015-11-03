<?php
include_once(dirname(__FILE__)."/../config/config.php");
if(isset($_GET['logout']))
	$cookie->adminLogout();
?>
<!DOCTYPE html>
<html lang="zh">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Administration panel - PrestaShop&trade;</title>
  <link rel="shortcut icon" href="<?php echo _TM_IMG_URL;?>favicon.ico" />
  <link href="<?php echo BOOTSTRAP_CSS;?>bootstrap.min.css" rel="stylesheet">
  <link href="<?php echo _TM_CSS_ADM_URL;?>login.css" rel="stylesheet">
</head>
<body>
<div id="container">
      <div id="error" class="hidden"> </div>
      <br />
      <div id="login">
        <h1>If Shop</h1>
        <form action="#" id="login_form" method="post">
          <div class="form-group">
            <label for="email">Email 地址</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email">
          </div>
          <div class="form-group">
            <label for="passwd">Password</label>
            <input type="password" class="form-control" id="passwd" name="passwd" placeholder="Password">
          </div>
          <div class="checkbox">
            <label>
              <input type="checkbox" name="rememberme"> 保持登录
            </label>
          </div>
            <div class="form-group">
                <button type="submit" class="btn btn-default  pull-left">登录</button>
                <p class="pull-left no-margin ajax-loader hidden"> <img src="<?php echo $_tmconfig['tm_img_dir'];?>admin/loader.gif"> </p>
                <p class="pull-right no-margin"> <a href="javascript:void(0)" class="show-forgot-password">忘记密码?</a> </p>
                <div class="clearfix"></div>
          </div>
          <input type="hidden" name="redirect" id="redirect" value="index.php?controller=&token=71673a774de7b53615ba6d363adc95a6"/>
        </form>
          <!--找加密码-->
        <form action="#" id="forgot_password_form" method="post" class="hidden">
          <h3>忘记了你的密码吗?</h3>
          <span id="helpBlock" class="help-block">请输入注册过程中输入的邮箱地址，系统将发送密码到此邮箱.</span>
            <div class="form-group">
                <label for="email">Email 地址</label>
                <input type="email" class="form-control" id="email_forgot" name="email_forgot" placeholder="Email">
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-default  pull-left">发送</button>
                <p class="fl no-margin hide ajax-loader"> <img src="<?php echo $_tmconfig['tm_img_dir'];?>admin/loader.gif"> </p>
                <div class="clearfix"></div>
          </div>
            <p> <a href="javascript:void(0)" class="show-login-form">返回登录</a> </p>
        </form>
      </div>
</div>
<footer class="footer">
  <div class="container">
    <p class="text-muted">&copy; 2005 - 2012 Copyright by PrestaShop. all rights reserved.</p>
  </div>
</footer>
<script src="<?php echo _TM_JQ_URL;?>jquery.min.js"></script>
<script src="<?php echo _TM_JS_ADM_URL;?>login.js"></script>
<script src="<?php echo BOOTSTRAP_JS;?>bootstrap.min.js"></script>
</body>
</html>
