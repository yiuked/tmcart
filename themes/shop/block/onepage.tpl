<ul id="order_step" class="step">
	<li class="done"><span><i>01</i><strong>购物车</strong></span></li>
	<li class="done"><span><i>02</i><strong>注册/登录</strong></span></li>
	<li class="current"><span><i>03</i><strong>配送</strong></span></li>
	<li class="todo"><span><i>04</i><strong>支付</strong></span></li>
</ul>
<div class="box-style">
<form action="{$link->getPage('ConfirmOrderView')}" method="post" class="bd" id="order-confrim">
<div class="row">
	<h2>支付</h2>
	<div class="txt-22"><p>请确认您的定单信息后继续支付.</p></div>
</div>
<fieldset id="p-address">
	<legend>收货地址</legend>
	<p class="selectedAddress">
        <strong>{$address->name}</strong><br>
		{$address->address}{if $address->address2} {$address->address2}{/if}<br>
		{$address->postcode} {$address->city} {if $address->join('Country',  'id_country')->need_state} {$address->join('State',  'id_state')->name}{/if} <br>
		{$address->join('Country',  'id_country')->name}<br>
		{$address->phone}<br>
        <a href="{$link->getPage('AddressView', $address->id, "referer=CheckoutView")}" class="all"><strong>编辑</strong></a>
    </p>
</fieldset>
<br/>
{if count($carriers.items) > 1}
<fieldset id="p-carrier">
	<legend>Delivery methods</legend>
	<ul id="carrier-list" class="carrier-list">
	{foreach from=$carriers.items item=carrier name=carrier}
		<li>
			<input type="radio" name="id_carrier" value="{$carrier.id_carrier}" class="carrier_list" id="id_address_{$carrier.id_carrier}" {if $cart->id_carrier==$carrier.id_carrier}checked="checked"{/if}/>
			<label for="id_carrier_{$carrier.id_carrier}"><strong>{$carrier.name}</strong> <span>{$carrier.description}</span></label>
			<font color="#f60">({if $carrier.shipping>0}+{displayPrice price=$carrier.shipping}{else}Free Shipping{/if})</font>
		</li>
	{/foreach}
	</ul>
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