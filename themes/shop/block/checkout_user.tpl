<div style="padding:15px 0px 15px 0px;">
      <div style="float:left;"><img height="22" border="0" width="316" alt="Your Shipping Address" src="{$img_dir}your_shipping_address.gif">       </div> 
       
  		<div style="clear:both;"></div>
		<p style="padding:5px 0px 0px 25px;margin:0px">  
	  <span class="signatureRequired">PLEASE NOTE: SIGNATURE REQUIRED</span>. The accurate delivery address. 
	 </p>
</div>
<form action="" method="post">
  <div class="ck_address">
    <div class="formField">
      <div style="width:500px;" class="inputDiv"> <span class="requiredRed">* </span>Quick Name for future reference:
        <input type="text" class="" id="alias" value="{if isset($smarty.post.alias)}{$smarty.post.alias}{/if}" maxlength="20" size="15" name="alias">
        <span style="font-size:10px"> Such as home, work, etc. </span> </div>
    </div>
    <div class="formField">
      <div class="labelDiv"><span class="requiredRed">* </span>First Name: </div>
      <div id="nameInputDiv" class="inputDiv">
        <input type="text" class="" id="first_name" value="{if isset($smarty.post.first_name)}{$smarty.post.first_name}{/if}" maxlength="40" size="30" name="first_name">
        &nbsp;&nbsp;<span class="requiredRed">* </span>Last Name:&nbsp;
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

  <div class="ck_customer">
  	<div style="font-size:21px;color:#567AA0;margin:30px 0px 30px 0px;text-align:center;">
        Sign up to receive updates on new arrivals, special offers, private sales and more!
    </div>
    <div class="formField">
	  <div class="labelDiv"><span class="requiredRed">* </span>Email:</div>
      <div class="inputDiv"><input type="text" value="{if isset($smarty.post.email)}{$smarty.post.email}{/if}" name="email" id="email" class="text"></div>
	  <div style="text-align:left;font-size:10px;color:#000000;padding:3px 0px 15px 0px;" class="formField">Your email address will be your username for login.&nbsp;&nbsp;</div>
    </div>
    <div class="formField">
	  <div class="labelDiv"><span class="requiredRed">* </span>Password:</div>
      <div class="inputDiv"><input type="password" value="{if isset($smarty.post.country)}{$smarty.post.country}{/if}" name="passwd" id="passwd" class="text" ></div>
	  <div style="font-size:9px;color:#000000;" class="input">Passwords must be between 5-10 characters.</div>
    </div>
  </div>

  <p class="submit">
    <input type="submit" name="CreateUser" value="Submit" />
  </p>
</form>
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