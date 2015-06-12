<ul id="order_step" class="step">
	<li class="done"><span><i>01</i><strong>Summary</strong></span></li>
	<li class="done"><span><i>02</i><strong>Sign in/Login</strong></span></li>
	<li class="current"><span><i>03</i><strong>Delivery</strong></span></li>
	<li class="todo"><span><i>04</i><strong>Payment</strong></span></li>
</ul>
<div class="box-style">
<form action="{$link->getPage('ConfirmOrderView')}" method="post" class="bd" id="order-confrim">
<div class="row">
	<h2>Payment</h2>
	<div class="txt-22"><p>Please verify your information and select a payment method.</p></div>
</div>
<fieldset id="p-address">
	<legend>Shipping address</legend>
	<p class="selectedAddress">
        <strong>{$address->first_name} {$address->last_name}</strong><br>
		{$address->address}{if $address->address2} {$address->address2}{/if}<br>
		{$address->postcode} {$address->city} {if $address->country->need_state} {$address->state->name}{/if} <br>
		{$address->country->name}<br>
		{$address->phone}<br>
        <a href="{$link->getPage('AddressView')}?id_address={$address->id}&referer=CheckoutView" class="all"><strong>Change address</strong></a>
    </p>
	{*
	<ul id="address-list" class="address-list">
		<li>
			<input type="radio" name="id_address" value="{$address->id}" id="id_address_{$address->id}" {if $cart->id_address==$address->id}checked="checked"{/if}/>
			<label for="id_address_{$address->id}"><a href="{$link->getPage('AddressView')}?id_address={$address->id}&referer=CheckoutView" title="edit this address">
			{$address->first_name} {$address->last_name},
			{$address->address} {$address->address2},
			{$address->city}{if $address->country->need_state} {$address->state->name}{/if} {$address->postcode},
			{$address->country->name},{$address->phone}</a>
			</label>
			
		</li>
	</ul>
	<br/>
	<a href="{$link->getPage('AddressView')}?referer=CheckoutView" class="all" title="Add Address"><strong>Change your delivery address</strong></a>
	*}
</fieldset>
<br/>
{if count($carriers.entitys)>1}
<fieldset id="p-carrier">
	<legend>Delivery methods</legend>
	<ul id="carrier-list" class="carrier-list">
	{foreach from=$carriers.entitys item=carrier name=carrier}
		<li>
			<input type="radio" name="id_carrier" value="{$carrier.id_carrier}" class="carrier_list" id="id_address_{$carrier.id_carrier}" {if $cart->id_carrier==$carrier.id_carrier}checked="checked"{/if}/>
			<label for="id_carrier_{$carrier.id_carrier}"><strong>{$carrier.name}</strong> <span>{$carrier.description}</span></label>
			<font color="#f60">({if $carrier.shipping>0}+{displayPrice price=$carrier.shipping}{else}Free Shipping{/if})</font>
		</li>
	{/foreach}
	</ul>
	{*
	<div style="border-top: 1px dashed rgb(231, 231, 231); padding-top: 15px;"><img width="100%" src="{$img_dir}cart.bg.jpg"></div>
	*}
</fieldset>
<br/>
{/if}
{if $products}
<div class="cart_block">
	<table width="100%">
		{foreach from=$products item=product name=product}
		<tr>
			<td style="padding:5px"><a href="{$product.link}" title="{$product.name}" target="_blank"><img src="{$product.image}" alt="{$product.name}" /></a></td>
			<td valign="top"><a href="{$product.link}" title="{$product.name}" target="_blank">{$product.name|truncate:50:'...'|escape:'html':'UTF-8'}</a><br/>
				{foreach from=$product.attributes item=attribute name=attribute}
				<em>{$attribute.group_name}:{$attribute.name}</em><br/>
				{/foreach}
				Quantity:{$product.quantity}
			</td>
			<td align="right"><strong>{displayPrice price=$product.total}</strong></td>
		</tr>
		{/foreach}
	</table>
</div>
{/if}
<div class="panier-resume">
<div class="panier-livraison" {if $cart->id_carrier==0}style="display:none"{/if}>
	<p class="panier-resume-titre">
	{assign var="shipping" value=$cart->getShippingTotal()}
	{if $shipping==0}
		<label class="icon-checkmark">Shipping</label>
		<strong class="free">FREE</strong>
	{else}
		<label>Shipping</label>
		<strong>{displayPrice price=$shipping}</strong>
	{/if}
	</p>
</div>
{if $discount>0}
<div class="panier-promo">
	<div class="promocode-total">
		<div class="panier-resume-titre">
			<span>Promo code</span>
			<strong>-{displayPrice price=$discount}</strong>
		</div>
	</div>
</div>
{/if}
<div class="panier-total panier-resume-titre">
	<span>Total</span>
	<strong id="a_total">{displayPrice price=$total-$discount}</strong>
</div>
</div>
<br/>
<div class="tabs">
{foreach from=$payments item=payment name=payment}
{$payment}
{/foreach}
</div>
{*
<fieldset id="p-payment">
	<legend>Choose payment method</legend>
	<ul id="payment-list" class="payment-list">
	{foreach from=$payments item=payment name=payment}
		<li>{$payment}</li>
	{/foreach}
	</ul>
</fieldset>
<br/>

<p class="panier-send panier-send-bottom">
	<a class="form-send dbl button big east pink check_out" href="#" title="Order" onclick="return checkoutCheck()">
		   <span>Order <span class="secure">(<span>100% secured payment</span>)</span></span>
	 </a>
</p>
*}
</form>
</div>
<script type="text/javascript">
var ajaxLink = "{$link->getPage('AjaxView')}";
var id_cart  = {$cart->id}
{literal}
$(document).ready(function(){
		 $("input[name=id_carrier]").click(function(){
		  	$('#p-carrier').css('border','3px solid #eee');
		 });
		$('.carrier_list').click(function() {
			var id_carrier = $(this).val();
			ajaxStates (id_carrier);
		});
		function ajaxStates (id_carrier)
		{
			$.ajax({
				url: ajaxLink,
				cache: false,
				data: "getTotal=true&id_cart="+id_cart+"&id_carrier="+id_carrier,
				dataType: "json",
				success: function(data)
					{
						$(".panier-livraison").show("slow");
						if(parseInt(data.shipping.replace("$",""))==0){
							$(".panier-livraison label").addClass("icon-checkmark")
							$(".panier-livraison strong").addClass("free")
							$(".panier-livraison strong").html("Free");
						}else{
							$(".panier-livraison label").removeClass("icon-checkmark")
							$(".panier-livraison strong").removeClass("free")
							$(".panier-livraison strong").html(data.shipping);
						}
						$("#a_total").html(data.total);
					}
				}); 	
		  }; 
});
{/literal}
</script>