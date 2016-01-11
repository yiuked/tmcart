<?php /* Smarty version Smarty-3.1.12, created on 2016-01-11 10:23:54
         compiled from "D:\wamp\www\red\shoes\themes\shop\login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:23936549bc2850e7fa8-91165931%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '566a4e9131f046c7b4c396ae170546319abbd10b' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\themes\\shop\\login.tpl',
      1 => 1452476966,
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
    'address' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_549bc28519b118_34728984')) {function content_549bc28519b118_34728984($_smarty_tpl) {?><div id="login-page">
	<div class="container">
		<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./block/errors.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

		<div class="row">
			<div class="col-md-8">

			</div>
			<div class="col-md-4 login-form">
				<div class="panel panel-default">
					<div class="panel-heading"><h3>会员登录</h3></div>
					<div class="panel-body">
						<form method="post" action="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('LoginView');?>
"  class="form-horizontal"/>
						<div class="alert alert-warning" role="alert"><span aria-hidden="true" class="glyphicon glyphicon-info-sign"></span> 公共场所不建议使用记住密码，以防账号丢失</div>
						<div class="form-group">
							<label for="email" class="col-sm-2 control-label">邮箱</label>
							<div class="col-sm-8">
								<div class="input-group">
									<span class="input-group-addon">@</span>
									<input type="text" class="form-control" name="email" value="<?php if (isset($_POST['email'])){?><?php echo $_POST['email'];?>
<?php }elseif(isset($_smarty_tpl->tpl_vars['address']->value->email)){?><?php echo $_smarty_tpl->tpl_vars['address']->value->email;?>
<?php }?>" placeholder="邮箱地址">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="password" class="col-sm-2 control-label">密码</label>
							<div class="col-sm-8">
								<div class="input-group">
									<span class="input-group-addon"><span aria-hidden="true" class="glyphicon glyphicon-lock"></span></span>
									<input type="password" class="form-control" name="passwd" value="" >
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<div class="checkbox">
									<label>
										<input type="checkbox" name="remember-me"> 记住密码
									</label>
								</div>
							</div>
						</div>
						<p><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('PasswordView');?>
" class="all">忘记密码?</a>&nbsp;&nbsp;&nbsp;<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('JoinView');?>
">免费注册</a> </p>
						<button type="submit" class="btn btn-pink btn-block" name="loginSubmit">登录</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div><?php }} ?>