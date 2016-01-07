<div id="login-page">
	<div class="container">
		{include file="$tpl_dir./block/errors.tpl"}
		<div class="row">
			<div class="col-md-8">

			</div>
			<div class="col-md-4 login-form">
				<div class="panel panel-default">
					<div class="panel-heading"><h3>会员登录</h3></div>
					<div class="panel-body">
						<form method="post" action="{$link->getPage('LoginView')}"  class="form-horizontal"/>
						<div class="alert alert-warning" role="alert"><span aria-hidden="true" class="glyphicon glyphicon-info-sign"></span> 公共场所不建议使用记住密码，以防账号丢失</div>
						<div class="form-group">
							<label for="email" class="col-sm-2 control-label">邮箱</label>
							<div class="col-sm-8">
								<div class="input-group">
									<span class="input-group-addon">@</span>
									<input type="text" class="form-control" name="email" value="{if isset($smarty.post.email)}{$smarty.post.email}{elseif isset($address->email)}{$address->email}{/if}" placeholder="邮箱地址">
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
						<p><a href="{$link->getPage('PasswordView')}" class="all">忘记密码?</a>&nbsp;&nbsp;&nbsp;<a href="{$link->getPage('JoinView')}">免费注册</a> </p>
						<button type="submit" class="btn btn-pink btn-block" name="loginSubmit">登录</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>