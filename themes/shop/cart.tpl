<div class="container">
{if $cart_quantity>0}
<ul id="order_step" class="step">
	<li class="current"><span><i>01</i><strong>购物车</strong></span></li>
	<li class="todo"><span><i>02</i><strong>登录/注册</strong></span></li>
	<li class="todo"><span><i>03</i><strong>填写收货地址</strong></span></li>
	<li class="todo"><span><i>04</i><strong>支付</strong></span></li>
</ul>
<h2 class="tc-standard">购物车 <small>{$cart_quantity} 件商品</small></h2>
<table class="table cart-table">
	<tr class="cart-header">
		<th class="th-select"><input type="checkbox" name="check-all"> 全选</th>
		<th class="th-image"></th>
		<th class="th-name">商品</th>
		<th class="th-price">单价</th>
		<th class="th-quantity">数量</th>
		<th class="th-total">小计</th>
		<th class="th-action">操作</th>
	</tr>
	{foreach from=$cart_products item=product name=product}
	<tr class="item">
		<td class="td-select"><input type="checkbox" name="id_cart_product[]" value="{$product.id_cart_product}"></td>
		<td class="td-image"><a href="{$product.link}" title="{$product.name}" target="_blank"><img src="{$product.image}" alt="{$product.name}" /></a></td>
		<td class="td-name"><a href="{$product.link}" title="{$product.name}" target="_blank">{$product.name}</a><br/>
			{foreach from=$product.attributes item=attribute name=attribute}
			<em>{$attribute.group_name}:{$attribute.name}</em><br/>
			{/foreach}
		</td>
		<td class="td-price">{displayPrice price=$product.price}</td>
		<td class="td-quantity">
		<span class="skin-select skin">
			<span class="select-content"><span>{$product.quantity}</span></span>
			<select data-nofirst="true" class="skin shopping_cart_form_submit" autocomplete="off" name="quantity[{$product.id_cart_product}][quantity]">
			 {section start=1 loop=6 name=quantityLoop}
			  <option value="{$smarty.section.quantityLoop.index}" {if $smarty.section.quantityLoop.index==$product.quantity}selected="selected"{/if}>{$smarty.section.quantityLoop.index}</option>
			  {/section}
			</select>
		</span>
		</td>
		<td class="td-total"><strong>{displayPrice price=$product.total}</strong></td>
		<td class="td-action"><a href="javascript:;" class="cart_quantity_delete" data-id="{$product.id_cart_product}">删除</a></td>
	</tr>
	{/foreach}
	<tr class="basket-footer">
		<td><input type="checkbox" name="check-all"> 全选</td>
		<td>删除选中</td>
		<td colspan="4" class="price-sum">
			<div>
				<span class="txt">总价（不含运费）：</span>
				<span class="price total-price">{displayPrice price=$cart_total + $cart_shipping - $cart_discount}</span>
				<br>
				<span class="txt">已节省：</span>
				<span class="price total-discount-price">- {displayPrice price=$cart_discount}</span>
			</div>
		</td>
		<td class="td-action checkout"><a href="{$link->getPage('CheckoutView')}">去结算</a></td>
	</tr>
</table>

<div class="panier-resume cart-total">
	<form method="post" action="{$link->getPage('CheckoutView')}" name="checkout_form" id="checkout_form">
	<div class="memo" id="information">
		<label>Leave a message:</label>
		<textarea placeholder="Information.(optional)" autocomplete="off" class="memo-input {if strlen($cart_msg)<5}memo-close{/if}" name="msg">{if $cart_msg}{$cart_msg}{/if}</textarea>
		<div class="msg hidden">
			<p class="error">Enter a maximum of 500 characters.</p>
		</div>
	</div>
	</form>
	<div class="panier-promo">
	  <p class="panier-resume-titre">
		<label for="panier-promo-checkbox">
		<input type="checkbox" id="panier-promo-checkbox" autocomplete="off">
		<span> <i class="checkbox"></i> Enter a promo code </span> </label>
		<i class="icon-info tool"> <span class="tip pos-b-l"><span>Tick the box if you have a promo code</span></span></i></p>
	    <div class="panier-resume-bloc hidden">
		  <input type="text" data-required-message="Please enter your promo code" value="" class="parsley-validated">
		  <button data-clickndelay="10" data-clicknwait="promocode" class="button" id="validateCode">OK</button>
		  <div class="clear"></div>
		  <p class="warring icon-cancel-2 hidden">This code does not exist</p>
		  <p class="loader hidden"><img src="{$img_dir}loader.gif" /></p>
	    </div>
		<div class="promocode-total {if $cart_discount==0}hidden{/if}">
			<div class="panier-resume-titre">
				<span>Promo code</span>
				<strong>-{displayPrice price=$cart_discount}</strong>
			</div>
		</div>
	</div>
	<div class="panier-livraison">
	{if $cart_shipping==0}
		<p class="panier-resume-titre">
			<label class="icon-checkmark">Shipping</label>
			<strong class="free">FREE</strong>
		</p>
		{else}
		<p class="panier-resume-titre">
			<label>Shipping</label>
			<strong>{displayPrice price=$cart_shipping}</strong>
		</p>
		<p style="color: rgb(102, 102, 102); font-size: 11px; padding-left: 15px;">Remaining amount to be added to your cart in order to obtain free shipping:{displayPrice price=$enjoy_free_shipping-$cart_total}</p>
		{/if}
	</div>
</div>
<script language="javascript">
$(".check_out").click(function(){
	$("#checkout_form").submit();
})
$("#validateCode").click(function(){
	$(".panier-resume-bloc p.loader").removeClass("hidden");
	$(".promocode-total").addClass("hidden");
	$(".panier-resume-bloc p.warring").addClass("hidden");
	$.ajax({
		url: ajax_dir,
		cache: false,
		data: "validatedPromocode=true&code="+$(".parsley-validated").val(),
		dataType: "json",
		success: function(data)
			{
				$(".panier-resume-bloc p.loader").addClass("hidden");
				if(data.status=="NO"){
					$(".panier-resume-bloc p.warring").removeClass("hidden");
				}else{
					$(".promocode-total strong").html(data.discount);
					$(".promocode-total").removeClass("hidden");
					$(".panier-total strong").html(data.total);
				}
			}
		});
})
</script>
{else}
<h2 class="tc-standard">购物车为空...</h2>
<div class="box-style">
  <div class="bd">
    <ul class="spacer-list no txt-14">
      <li>你可能会喜欢? <a href="{$link->getPage('SaleView')}" class="all no"><strong>这些商品...</strong></a> </li>
      <li>去我收藏过的商品里看看? <a href="{$link->getPage('WishView')}" class="all no"><strong>点击这里!</strong></a> </li>
    </ul>
  </div>
</div>
{/if}
</div>