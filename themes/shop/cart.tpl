<div class="container">
{if $cart_quantity>0}
<ul id="order_step" class="step">
	<li class="current"><span><i>01</i><strong>购物车</strong></span></li>
	<li class="todo"><span><i>02</i><strong>登录/注册</strong></span></li>
	<li class="todo"><span><i>03</i><strong>核对定单</strong></span></li>
	<li class="todo"><span><i>04</i><strong>支付</strong></span></li>
</ul>
<h2>购物车 <small> <span class="cart-total-quantity">{$cart_quantity}</span> 件商品</small></h2>
<table class="table cart-table">
	<tr class="cart-header">
		<th class="th-select"><input type="checkbox" name="check-all" class="check-all" data-name="id_cart_product"> 全选</th>
		<th class="th-image"></th>
		<th class="th-name">商品</th>
		<th class="th-price">单价</th>
		<th class="th-quantity" width="100">数量</th>
		<th class="th-total" width="150">小计</th>
		<th class="th-action">操作</th>
	</tr>
	{foreach from=$cart_products item=product name=product}
	<tr class="item">
		<td class="td-select"><input type="checkbox" name="id_cart_product" value="{$product.id_cart_product}"></td>
		<td class="td-image"><a href="{$product.link}" title="{$product.name}" target="_blank"><img src="{$product.image}" alt="{$product.name}" /></a></td>
		<td class="td-name"><a href="{$product.link}" title="{$product.name}" target="_blank">{$product.name}</a><br/>
			{foreach from=$product.attributes item=attribute name=attribute}
			<em>{$attribute.group_name}:{$attribute.name}</em><br/>
			{/foreach}
		</td>
		<td class="td-price">{displayPrice price=$product.price}</td>
		<td class="td-quantity">
			<div class="input-group spinner">
				<div class="input-group-addon"><a href="javascript:;" class="minus{if $product.quantity <= 1} disable{/if}" data-id="{$product.id_cart_product}"> - </a></div>
				<input type="text" class="form-control input-sm" value="{$product.quantity}">
				<div class="input-group-addon"><a href="javascript:;" class="plus" data-id="{$product.id_cart_product}"> + </a></div>
			</div>
		</td>
		<td class="td-total"><strong>{displayPrice price=$product.total}</strong></td>
		<td class="td-action"><a href="javascript:;" class="cart_quantity_delete" data-id="{$product.id_cart_product}">删除</a></td>
	</tr>
	{/foreach}
	<tr class="basket-footer">
		<td><input type="checkbox" name="check-all" class="check-all" data-name="id_cart_product"> 全选</td>
		<td><a href="javascript:;" class="cart-selected-delete">删除选中</a></td>
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