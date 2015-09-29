<div id="main_columns">
{if $cart_quantity>0}
<ul id="order_step" class="step">
	<li class="current"><span><i>01</i><strong>Summary</strong></span></li>
	<li class="todo"><span><i>02</i><strong>Sign in/Login</strong></span></li>
	<li class="todo"><span><i>03</i><strong>Delivery</strong></span></li>
	<li class="todo"><span><i>04</i><strong>Payment</strong></span></li>
</ul>
<h2 class="tc-standard">Your Shopping Cart</h2>
<br/>
{if isset($success)}<div class="success">{$success}</div>{/if}
<form method="post" action="{$link->getPage('CartView')}" name="shopping_cart_form" class="shopping_cart_form">
<table width="100%" class="cart" cellspacing="0" cellpadding="0" border="0">
	<tr class="basket-header">
		<th class="th-delete"></th>
		<th class="th-image"></th>
		<th class="th-name">Product</th>
		<th class="th-price">Unit price</th>
		<th class="th-quantity">Quantity</th>
		<th class="th-total">Total</th>
	</tr>
	{foreach from=$cart_products item=product name=product}
	<tr class="item">
		<td class="td-delete"><a href="{$link->getPage('CartView')}?delete={$product.id_cart_product}" class="cart_quantity_delete" rel="nofollow"><img src="{$img_dir}btn_trash.gif" alt="delete" /></a></td>
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
			<span class="sub-dd">
				<ul class="list-item">
				{section start=1 loop=6 name=quantityLoop}
				  <li{if $smarty.section.quantityLoop.index==$product.quantity} class="active"{/if}>
				  	<a class="shoesize " rel="{$smarty.section.quantityLoop.index}" href="#"><span>{$smarty.section.quantityLoop.index}</span></a>
				  </li>
				 {/section}
				</ul>
			</span>
		</span>
		</td>
		<td class="td-total"><strong>{displayPrice price=$product.total}</strong></td>
	</tr>
	{/foreach}
	<tr class="basket-footer">
		<td colspan="7"><p align="right"><input type="hidden" value="Update Shopping Cart" class="btn" name="cart_update" /></p></td>
	</tr>
</table>
</form>
<br/>
<div class="clear"></div>
{if isset($coupons)}
<div class="panier-resume coupons">
	<table>
		<tr>
			<th>Code</th>
			<th>Save</th>
			<th>Conditions</th>
		</tr>
		{foreach from=$coupons.entitys item=coupon name=coupon}
		<tr>
			<td>{$coupon.code}</td>
			<td>
				{if $coupon.off>0}
				{$coupon.off}%
				{else}
				-{displayPrice price=$coupon.amount}
				{/if}
			</td>
			<td>{$coupon.code}</td>
			<td>
			{if $coupon.total_over>0}
				{if $cart_total>$coupon.total_over}
				YES
				{else}
				NO({displayPrice price=$coupon.total_over-$cart_total})
				{/if}
			{else}
				{if $cart_quantity>$coupon.quantity_over}
				YES
				{else}
				NO({$coupon.quantity_over-$cart_quantity}items)
				{/if}
			{/if}
			</td>
		</tr>
		{/foreach}
	</table>
</div>
{/if}
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
	<div class="panier-total panier-resume-titre">
		<span>Total</span>
		<strong>{displayPrice price=$cart_total+$cart_shipping-$cart_discount}</strong>
	</div>
	<div class="clear"></div>
	<p class="panier-send panier-send-bottom">
		<a title="Order" href="#" class="form-send dbl button big east pink check_out">
               <span>Order <span class="secure">(<span>100% secured payment</span>)</span></span>
         </a>
    </p>
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
<h2 class="tc-standard">Your basket is empty...</h2>
<div class="box-style">
  <div class="bd">
    <ul class="spacer-list no txt-14">
      <li>Looking for the hottest styles? <a href="{$link->getPage('SaleView')}" class="all no"><strong>This way for inspiration...</strong></a> </li>
      <li>Already added items to your favourites? <a href="{$link->getPage('WishView')}" class="all no"><strong>See them here!</strong></a> </li>
    </ul>
  </div>
</div>
{/if}
</div>