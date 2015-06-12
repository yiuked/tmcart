<div id="main_columns" class="custom">
<div class="back-arrow"><i class="icon-arrow-left"></i><strong><a href="javascript:history.back();">Back</a></strong></div>
{include file="$tpl_dir./block/errors.tpl"}
<div class="box-style">
<form action="" method="post" name="eidtAddress" id="editAddress" class="bd">
<div style="padding:15px 0px 15px 0px;">
        <h2>Your Shipping Address</h2>
  		<div style="clear:both;"></div>
		<p style="padding:5px 0px 0px 25px;margin:0px">  
	  <span class="signatureRequired">PLEASE NOTE: SIGNATURE REQUIRED</span>. The accurate delivery address. 
	 </p>
</div>
  <div class="ck_address">
    <div class="formField">
	   <div class="labelDiv"><span class="requiredRed">* </span>First Name: </div>       
	   <div class="inputDiv"> <input type="text" class="" id="first_name" value="{if isset($smarty.post.first_name)}{$smarty.post.first_name}{elseif isset($address->first_name)}{$address->first_name}{/if}" maxlength="40" size="30" name="first_name"></div>         
    </div>
	<div class="formField">
		<div class="labelDiv"><span class="requiredRed">* </span>Last Name:</div>  
		<div class="inputDiv"><input type="text" id="last_name" value="{if isset($smarty.post.last_name)}{$smarty.post.last_name}{elseif isset($address->last_name)}{$address->last_name}{/if}" maxlength="40" size="30" name="last_name"></div>
	</div>
	<div class="formField">
		<div class="labelDiv"><span class="requiredRed">* </span>Address:</div>  
		<div class="inputDiv"><input type="text" id="address" value="{if isset($smarty.post.address)}{$smarty.post.address}{elseif isset($address->address)}{$address->address}{/if}" maxlength="100" size="60" name="address"></div>
	</div>
	<div class="formField">
		<div class="labelDiv">Address 2:</div>  
		<div class="inputDiv"><input type="text" id="address2" value="{if isset($smarty.post.address2)}{$smarty.post.address2}{elseif isset($address->address2)}{$address->address2}{/if}" maxlength="100" size="60" name="address2">	</div>
	</div>
	<div class="formField">
		<div class="labelDiv"><span class="requiredRed">* </span>City:</div>  
		<div class="inputDiv"><input type="text" id="city" value="{if isset($smarty.post.city)}{$smarty.post.city}{elseif isset($address->city)}{$address->city}{/if}" maxlength="40" size="40" name="city"></div>
	</div>  
	 <div class="formField">
	 	<div class="labelDiv"><span class="requiredRed">* </span>Post Code:</div>
		<div class="inputDiv">
		<input type="text" value="{if isset($smarty.post.postcode)}{$smarty.post.postcode}{elseif isset($address->postcode)}{$address->postcode}{/if}" name="postcode" id="postcode" class="text" >
		</div>
	  </div>
	<div class="formField" id="contains_states" style="display: none;">
		<div class="labelDiv"><span class="requiredRed">* </span>State:</div>
		<div class="inputDiv">
		<select id="id_state" name="id_state"></select>
		</div>
	</div> 
	  <div class="formField left">
		<div class="labelDiv"><span class="requiredRed">* </span>Country:</div>
		<div class="inputDiv">
		<select id="id_country" name="id_country" style="margin-right:15px">
		<option value="NULL">--choose--</option>
		{foreach from=$countrys.entitys name=country item=country}
		<option value="{$country.id_country}" {if isset($smarty.post.id_country)}{if $smarty.post.id_country==$country.id_country}selected="selected"{/if}{else}{if isset($address) && $address->country->id==$country.id_country}selected="selected"{/if}{/if}>{$country.name}</option>
		{/foreach}
	   </select>
	   </div>
	  </div>
	  <div class="formField">
	  	<div class="labelDiv"><span class="requiredRed">* </span>Phone:</div>
		<div class="inputDiv">
		<input type="text" value="{if isset($smarty.post.phone)}{$smarty.post.phone}{elseif isset($address->phone)}{$address->phone}{/if}" name="phone" id="phone" class="text" >
		</div>
	  </div>
	</div>
  <p class="submit">
  	<input type="hidden" value="{if isset($address->id)}{$address->id}{/if}" />
	<input type="submit" class="form-send button big east pink collapse" value="Submit" name="saveAddress">
  </p>
</form>
</div>
</div>
<script type="text/javascript">
var ajaxLink = "{$link->getPage('AjaxView')}";
{if isset($address) && $address->country->need_state}
var secat_id = {$address->state->id};
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