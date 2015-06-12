<div id="main_columns">
<div id="login-page">
  {include file="$tpl_dir./block/errors.tpl"}
  <div id="loginContent">
    <div id="loginColumn">
	  <h2 class="tc-standard">Welcome Back</h2>
      <form method="post" action="{$link->getPage('LoginView')}" name="signin" id="signInForm"/>
	  	<div class="row">
			<label><strong>Email Address</strong></label>
			<input type="text" value="" name="email" maxlength="250" id="email" class="text" />
		</div>
		<div class="row">
			<label><strong>Password</strong></label>
			<input type="password" autocomplete="off" value="" name="passwd" maxlength="35" id="passwd" class="text"/>
		</div>		
		<p><a href="{$link->getPage('PasswordView')}" class="all"><strong>Forgot your password?</strong></a></p>
		<button title="Continue" type="submit" class="form-send button big east pink" id="signSubmit" name="signSubmit">Continue</button>
    </div>
	<div id="registerColumn">
		 <h2 class="tc-standard">Why Register?</h2>
		<p>Save your shipping and billing information - you won't ever need to re-enter your information.</p>
		<p>Access your order status and order history online.</p>
		<p>Just click the button below</p>
		<a href="{$link->getPage('JoinView')}" class="form-send button big east pink">Register Now</a>
	</div>
  </div>
</div>
</div>