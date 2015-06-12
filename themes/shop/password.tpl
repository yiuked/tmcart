<div id="main_columns">
<div id="login-page">
  {include file="$tpl_dir./block/errors.tpl"}
  <div id="loginContent">
  {if $step==1}
    <div id="loginColumn">
	  <h2 class="tc-standard">Forgot your password?</h2>
      <form method="post" action="" name="signin" id="signInForm"/>
	  	<div class="row">
			<label><strong>Email Address</strong></label>
			<input type="text" value="{if isset($smarty.post.email)}{$smarty.post.email}{/if}" name="email" maxlength="250" id="email" class="text" />
		</div>	
		<button title="Continue" type="submit" class="form-send button big east pink" id="ResetPassword" name="ResetPassword">Retrieve Password</button>
	  </form>
    </div>
  {else if $step==2 && $isExp==false}
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
	{else if $step==3}
	<div id="loginColumn">
	    <h2 class="tc-standard">Forgot your password?</h2>
		<div class="conf">Your password is reset successful!</div>
		<p>Now you can <a href="{$link->getPage('LoginView')}" class="form-send button big east pink">Login</a></p>
    </div>
	{else if $step==4}
	<div id="loginColumn">
	    <h2 class="tc-standard">Forgot your password?</h2>
		<div class="conf">Mail sent successfully!</div>
		<p>Please login your email and links to reset your password by email!</p>
    </div>
	{/if}
  </div>
</div>
</div>