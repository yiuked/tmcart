<div id="main_columns_two" class="custom">
<h2>My Orders</h2>
{if $orders}
<table border="0" cellpadding="0" cellspacing="0" width="100%" class="table">
	<tr>
		<th>Reference</th>
		<th>Status</th>
		<th>Shipping</th>
		<th>Track Number</th>
		<th>Total</th>
		<th>Time</th>
		<th>Action</th>
	</tr>
	{foreach from=$orders item=order name=order}
	<tr>
		<td>{$order->reference}</td>
		<td><span style="background-color:{$order->order_status->color};color:white" class="color_field">{$order->order_status->name}</span></td>
		<td>{$order->carrier->name}</td>
		<td>{$order->track_number}</td>
		<td>{displayPrice price=$order->amount}</td>
		<td>{$order->add_date}</td>
		<td><a href="?reference={$order->reference}">details</a></td>
	</tr>
	{/foreach}
</table>
{if isset($h_order)}
<div style=" clear:both;" class="order_product">
  <fieldset class="small" style="width: 98%; ">
  <legend><img src="{$ico_dir}cart.gif" alt="Products">Products</legend>
  <table cellspacing="0" cellpadding="0" style="width: 100%;" class="table" id="orderProducts">
    <tbody>
      <tr>
        <th>Image</th>
        <th>Proudct</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Total</th>
      </tr>
	{foreach from=$products item=product name=product}
	<tr class="item">
		<td><a href="{$product.link}" title="{$product.name}" target="_blank"><img src="{$product.image}" alt="{$product.name}" /></a></td>
		<td class="td-name"><a href="{$product.link}" title="{$product.name}" target="_blank">{$product.name}</a><br/>
			{foreach from=$product.attributes item=attribute name=attribute}
			<em>{$attribute.group_name}:{$attribute.name}</em><br/>
			{/foreach}
		</td>
		<td class="td-price">{displayPrice price=$product.price}</td>
		<td class="td-quantity">{$product.quantity}</td>
		<td class="td-total">{displayPrice price=$product.total}</td>
	</tr>
	{/foreach}
    </tbody>
  </table>
  <div style="float:right; margin-top: 20px;">
    <table cellspacing="0" cellpadding="0" width="450px;" class="table" style="border-radius:0px;">
      <tbody>
        <tr id="total_products">
          <td width="150px;"><b>Item Total</b></td>
          <td align="right" class="amount">{displayPrice price=$h_order->product_total}</td>
          <td class="partial_refund_fields current-edit" style="display:none;">&nbsp;</td>
        </tr>
        <tr id="total_shipping">
          <td><b>Shipping</b></td>
          <td align="right" class="amount">{displayPrice price=$h_order->shipping_total}</td>
          <td class="partial_refund_fields current-edit" style="display:none;">£
            <input type="text" size="3" name="partialRefundShippingCost" value="0"></td>
        </tr>
        <tr style="font-size: 20px" id="total_order">
          <td style="font-size: 20px">Total</td>
          <td align="right" class="amount" style="font-size: 20px">{displayPrice price=$h_order->amount}</td>
          <td class="partial_refund_fields current-edit" style="display:none;">&nbsp;</td>
        </tr>
      </tbody>
    </table>
  </div>
  </fieldset>
</div>
{/if}

{else}
<p class="warning">You have not placed any orders.</p>
{/if}
</div>