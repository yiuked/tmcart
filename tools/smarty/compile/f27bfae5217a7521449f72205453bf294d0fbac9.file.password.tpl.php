<?php /* Smarty version Smarty-3.1.12, created on 2015-05-11 18:16:12
         compiled from "D:\wamp\www\red\shoes\themes\shop\password.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10751555068bc9b2931-64557242%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f27bfae5217a7521449f72205453bf294d0fbac9' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\themes\\shop\\password.tpl',
      1 => 1431339364,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10751555068bc9b2931-64557242',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_555068bca06ca7_51738729',
  'variables' => 
  array (
    'step' => 0,
    'isExp' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555068bca06ca7_51738729')) {function content_555068bca06ca7_51738729($_smarty_tpl) {?><div id="main_columns">
<div id="login-page">
  <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./block/errors.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

  <div id="loginContent">
  <?php if ($_smarty_tpl->tpl_vars['step']->value==1){?>
    <div id="loginColumn">
	  <h2 class="tc-standard">Forgot your password?</h2>
      <form method="post" action="" name="signin" id="signInForm"/>
	  	<div class="row">
			<label><strong>Email Address</strong></label>
			<input type="text" value="<?php if (isset($_POST['email'])){?><?php echo $_POST['email'];?>
<?php }?>" name="email" maxlength="250" id="email" class="text" />
		</div>	
		<button title="Continue" type="submit" class="form-send button big east pink" id="ResetPassword" name="ResetPassword">Retrieve Password</button>
	  </form>
    </div>
  <?php }elseif($_smarty_tpl->tpl_vars['step']->value==2&&$_smarty_tpl->tpl_vars['isExp']->value==false){?>
	<div id="loginColumn">
	  <h2 class="tc-standard">Forgot your password?</h2>
      <form method="post" action="" name="signin" id="signInForm"/>
	  	<div class="row">
			<label><strong>New Password</strong></label>
			<input type="password" value="" name="passwd" maxlength="250" id="passwd" class="text" />
		</div>	
		<button title="Continue" type="submit" class="form-send button big east pink" id="confrimPassword" name="confrimPassword">Confrim Password</button>
	  </form>
    </div>
	<?php }elseif($_smarty_tpl->tpl_vars['step']->value==3){?>
	<div id="loginColumn">
	    <h2 class="tc-standard">Forgot your password?</h2>
		<div class="conf">Your password is reset successful!</div>
		<p>Now you can <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('LoginView');?>
" class="form-send button big east pink">Login</a></p>
    </div>
	<?php }?>
  </div>
</div>
</div><?php }} ?>