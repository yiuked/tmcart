<?php /* Smarty version Smarty-3.1.12, created on 2015-05-11 16:30:21
         compiled from "D:\wamp\www\red\shoes\themes\shop\login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:23936549bc2850e7fa8-91165931%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '566a4e9131f046c7b4c396ae170546319abbd10b' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\themes\\shop\\login.tpl',
      1 => 1431333016,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '23936549bc2850e7fa8-91165931',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_549bc28519b118_34728984',
  'variables' => 
  array (
    'link' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_549bc28519b118_34728984')) {function content_549bc28519b118_34728984($_smarty_tpl) {?><div id="main_columns">
<div id="login-page">
  <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./block/errors.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

  <div id="loginContent">
    <div id="loginColumn">
	  <h2 class="tc-standard">Welcome Back</h2>
      <form method="post" action="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('LoginView');?>
" name="signin" id="signInForm"/>
	  	<div class="row">
			<label><strong>Email Address</strong></label>
			<input type="text" value="" name="email" maxlength="250" id="email" class="text" />
		</div>
		<div class="row">
			<label><strong>Password</strong></label>
			<input type="password" autocomplete="off" value="" name="passwd" maxlength="35" id="passwd" class="text"/>
		</div>		
		<p><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('PasswordView');?>
" class="all"><strong>Forgot your password?</strong></a></p>
		<button title="Continue" type="submit" class="form-send button big east pink" id="signSubmit" name="signSubmit">Continue</button>
    </div>
	<div id="registerColumn">
		 <h2 class="tc-standard">Why Register?</h2>
		<p>Save your shipping and billing information - you won't ever need to re-enter your information.</p>
		<p>Access your order status and order history online.</p>
		<p>Just click the button below</p>
		<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('JoinView');?>
" class="form-send button big east pink">Register Now</a>
	</div>
  </div>
</div>
</div><?php }} ?>