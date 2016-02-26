<ul id="order_step" class="step">
	<li class="done"><span><i>01</i><strong>购物车</strong></span></li>
	<li class="done"><span><i>02</i><strong>注册/登录</strong></span></li>
	<li class="current"><span><i>03</i><strong>核对定单</strong></span></li>
	<li class="todo"><span><i>04</i><strong>支付</strong></span></li>
</ul>
<form action="{$link->getPage('ConfirmOrderView')}" method="post" id="order-confrim">
<p class="tex-info">请确认您的定单信息后继续支付.</p>

<div class="panel panel-default">
	<div class="panel-body">
		<div class="address-block radio-new-style">
			<h3>收货人信息</h3>
			{foreach from=$addresses item=address}
			<div class="row item{if $address->is_default} active{/if}">
				<div class="col-md-2 text-center name">{if $address->is_default}<b></b>{/if}<strong>{$address->name}</strong></div>
				<div class="col-md-8">
				<span class="addr-country">{$address->join('Country',  'id_country')->name}</span>
				{if $address->join('Country',  'id_country')->need_state}<span class="addr-state">{$address->join('State',  'id_state')->name}{/if}</span>
				<span class="addr-city">{$address->city}</span>
				<span class="addr-address">{$address->address}{if $address->address2} {$address->address2}{/if}</span>
				<span class="addr-postcode">{$address->postcode}</span>
				<span class="addr-phone">{$address->phone}</span>
				{if $address->is_default}<span class="label label-default">默认地址</span>{/if}
				</div>
				<div class="col-md-2">
					<a href="{$link->getPage('AddressView', $address->id, "referer=CheckoutView")}" class="all"><strong>编辑</strong></a>
				</div>
			</div>
			{/foreach}
		</div>

		{if count($carriers.items) > 1}
		<div class="address-block">
			<h3>配送方式</h3>
			{foreach from=$carriers.items item=carrier name=carrier}
				<div class="row item">
					<div class="col-md-2 text-center name"><strong>{$carrier.name}</strong></div>
					<div class="col-md-8">{$carrier.description}</div>
					<div class="col-md-2">{if $carrier.shipping>0} + {displayPrice price=$carrier.shipping} {else}免运费{/if}</div>
				</div>
			{/foreach}
		</div>
		{/if}
		{if $products}
			<div class="cart_block">
				<table class="table">
					{foreach from=$products item=product name=product}
						<tr>
							<td><a href="{$product.link}" title="{$product.name}" target="_blank"><img src="{$product.image}" alt="{$product.name}" /></a></td>
							<td><a href="{$product.link}" title="{$product.name}" target="_blank">{$product.name|truncate:50:'...'|escape:'html':'UTF-8'}</a><br/>
								{foreach from=$product.attributes item=attribute name=attribute}
									<em>{$attribute.group_name}:{$attribute.name}</em><br/>
								{/foreach}
								数量:{$product.quantity}
							</td>
							<td align="right"><strong>{displayPrice price=$product.total}</strong></td>
						</tr>
					{/foreach}
				</table>
			</div>
		{/if}
	</div>
</div>

<div class="order-resume">
<div class="shipping-resume" {if $cart->id_carrier==0}style="display:none"{/if}>
	{assign var="shipping" value=$cart->getShippingTotal()}
	{if $shipping==0}
		<label class="icon-checkmark">运费</label>
		<strong class="free">包邮</strong>
	{else}
		<label>运费</label>
		<strong>{displayPrice price=$shipping}</strong>
	{/if}
</div>
{if $discount > 0}
<div class="discount-resume">
	<div class="title">
		<span>优惠</span>
		<strong>-{displayPrice price=$discount}</strong>
	</div>
</div>
{/if}
<div class="total-resume">
	<div class="title">
		<span>应付总金额:</span>
		<strong id="a_total">{displayPrice price=$total-$discount}</strong>
	</div>
</div>
</div>
<br/>
<div class="tabs">
{foreach from=$payments item=payment name=payment}
{$payment}
{/foreach}
</div>
</form>
<script type="text/javascript">
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
				url: ajax_dir,
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