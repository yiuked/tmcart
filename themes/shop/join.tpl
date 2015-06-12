<div id="main_columns">
{include file="$tpl_dir./block/errors.tpl"}
{if $step==2}
<ul id="order_step" class="step">
	<li class="done"><span><i>01</i><strong>Summary</strong></span></li>
	<li class="current"><span><i>02</i><strong>Sign in/Login</strong></span></li>
	<li class="todo"><span><i>03</i><strong>Delivery</strong></span></li>
	<li class="todo"><span><i>04</i><strong>Payment</strong></span></li>
</ul>
{/if}
<div class="box-style">
	<form action="" method="post" class="bd">
	  <div class="row">
		<h2>Create a new account</h2>
		<h3>Account settings</h3>
	  </div>
	  <div class="ck_customer">
		<div class="formField">
		  <div class="labelDiv"><span class="requiredRed">* </span>Email:</div>
		  <div class="inputDiv"><input type="text" value="{if isset($smarty.post.email)}{$smarty.post.email}{/if}" name="email" id="email" class="text" size="50"></div>
		  <div style="text-align:left;font-size:10px;color:#949494; padding-left:100px;" class="input">Your email address will be your username for login.&nbsp;&nbsp;</div>
		</div>
		<div class="formField">
		  <div class="labelDiv"><span class="requiredRed">* </span>Password:</div>
		  <div class="inputDiv"><input type="password" value="{if isset($smarty.post.country)}{$smarty.post.country}{/if}" name="passwd" id="passwd" class="text" ></div>
		  <div style="font-size:9px;color:#949494;padding-left:100px;" class="input">Passwords must be between 5-10 characters.</div>
		</div>
	  </div>
	
	  <div class="ck_address">
		<h3>Your Shipping Address</h3> 
		<div class="formField">
		  <div class="labelDiv"><span class="requiredRed">* </span>First Name: </div>
		  <div class="inputDiv">
			<input type="text" class="" id="first_name" value="{if isset($smarty.post.first_name)}{$smarty.post.first_name}{/if}" maxlength="40" size="30" name="first_name">
		  </div>
		</div>
		<div class="formField">
		  <div class="labelDiv"><span class="requiredRed">* </span>Last Name:</div>
		  <div class="inputDiv">
			<input type="text" id="last_name" value="{if isset($smarty.post.last_name)}{$smarty.post.last_name}{/if}" maxlength="40" size="30" name="last_name">
		  </div>
		</div>
		<div class="formField">
		  <div class="labelDiv"><span class="requiredRed">* </span>Address:</div>
		  <div class="inputDiv">
			<input type="text" id="address" value="{if isset($smarty.post.address)}{$smarty.post.address}{/if}" maxlength="100" size="60" name="address">
		  </div>
		</div>
		<div class="formField">
		  <div class="labelDiv">Address 2:</div>
		  <div class="inputDiv">
			<input type="text" id="address2" value="{if isset($smarty.post.address)}{$smarty.post.address}{/if}" maxlength="100" size="60" name="address2">
		  </div>
		</div>
		<div class="formField">
		  <div class="labelDiv"><span class="requiredRed">* </span>City:</div>
		  <div class="inputDiv">
			<input type="text" id="city" value="{if isset($smarty.post.city)}{$smarty.post.city}{/if}" maxlength="40" size="40" name="city">
		  </div>
		</div>
		<div class="formField">
		  <div class="labelDiv"><span class="requiredRed">* </span>Post Code:</div>
		  <div class="inputDiv">
			<input type="text" value="{if isset($smarty.post.postcode)}{$smarty.post.postcode}{/if}" name="postcode" id="postcode" class="text" >
		  </div>
		</div>
		<div class="formField" id="contains_states" style="display: none;">
		  <div class="labelDiv"><span class="requiredRed">* </span>State:</div>
		  <div class="inputDiv">
			<select id="id_state" name="id_state">
			</select>
		  </div>
		</div>
		<div class="formField left">
		  <div class="labelDiv"><span class="requiredRed">* </span>Country:</div>
		  <div class="inputDiv">
			  <select id="id_country" name="id_country" style="margin-right:15px">
				<option value="NULL">--choose--</option>
				{foreach from=$countrys.entitys name=country item=country}
				<option value="{$country.id_country}" {if isset($smarty.post.id_country)}{if $smarty.post.id_country==$country.id_country}selected="selected"{/if}{else}{if $id_default_country==$country.id_country}selected="selected"{/if}{/if}>{$country.name}</option>
				{/foreach}
			  </select>
		  </div>
		</div>
		<div class="formField">
		  <div class="labelDiv"><span class="requiredRed">* </span>Phone:</div>
		  <div class="inputDiv">
			<input type="text" value="{if isset($smarty.post.phone)}{$smarty.post.phone}{/if}" name="phone" id="phone" class="text" >
		  </div>
		</div>
	  </div>
	  <p class="submit">
		<input type="submit" name="CreateUser" value="Submit" class="form-send button big east pink collapse" />
	  </p>
	</form>
 </div>
</div>
<script type="text/javascript">
var ajaxLink = "{$link->getPage('AjaxView')}";
{if isset($smarty.post.id_state)}
var secat_id = {$smarty.post.id_state};
{else}
var secat_id = 0;
{/if}
{literal}
	$(document).ready(function(){
			ajaxStates ();
			$('#id_country').change(function() {
				ajaxStates ();
				});
			function ajaxStates ()
			{
				$.ajax({
					url: ajaxLink,
					cache: false,
					data: "ajaxStates=1&id_country="+$('#id_country').val()+"&id_state="+$('#id_state').val(),
					success: function(html)
						{
							if (html == 'false')
							{
								$("#contains_states").fadeOut();
								$('#id_state option[value=0]').attr("selected", "selected");
							}
							else
							{
								$("#id_state").html(html);
								$("#contains_states").fadeIn();
								$('#id_state option[value='+secat_id+']').attr("selected", "selected");
							}
						}
					}); 	
			  }; 
		}); 
{/literal}
</script>