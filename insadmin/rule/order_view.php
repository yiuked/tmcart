<?php
if(isset($_GET['id'])){
	$id  = (int)$_GET['id'];
	$obj = new Order($id);
}else{
die();
}

if(isset($_POST['ORDER_VIEW_REPLACE_STRING'])){
	$filter = $_POST['ORDER_VIEW_REPLACE_STRING'];
	Configuration::updateValue('ORDER_VIEW_REPLACE_STRING',$filter);
}

$isNeed = false;
if($string = Configuration::get('ORDER_VIEW_REPLACE_STRING')){
	$isNeed = explode(',',$string);
}
?>
<style>
.grey{color:grey;}
.block{ display:block;}
.left{ float:left}
.right{ float:right}
.clear{ clear:both}
.alignr{ text-align:right}
.filter{
width:600px;
margin:auto
}
.invoice {
  height: 600px;
  margin: 0 auto;
  width: 600px;
  padding:20px;
}
.page-head{
	font-size:20px;
	border-bottom:4px solid #666;
	margin-bottom:20px;
}
.page-address{
margin-bottom:20px;
font-size:14px;
}
.page-cart{
font-size:14px;
}
.page-cart table th{
background:#333;
color:#fff;
padding:10px 5px;
}
.page-cart table td{
padding: 10px 5px;
}
</style>
<a href="index.php?rule=order_edit&id=<?php echo $obj->id;?>">[back]</a>
<div class="filter">
	<form method="post">
		<input type="text" value="<?php echo $isNeed?$string:'';?>" size="80" name="ORDER_VIEW_REPLACE_STRING" placeholder="过虑不显示的品牌词，多个请用,号分开" />
		<button type="submit">保存</button>
	</form>
</div>
<br><br>
<div class="invoice">
	<div class="page-head grey font20">
		<span class="block right"><?php echo date('m/d/Y',strtotime($obj->add_date));?></span> 
		<span class="block left">Invoice #IN<?php echo sprintf("%06d",$obj->id_cart);?></span>
		<div class="clear"></div>
	</div>
	<div class="page-address">
		<h3 class="grey">Billing & Delivery Address.</h3>
		<div class="address">
		<?php echo $obj->address->first_name.' '.$obj->address->last_name;?><br/>
		<?php echo $obj->address->address;?><br/>
		<?php echo $obj->address->postcode.' '.$obj->address->city.' '.($obj->address->country->need_state?$obj->address->state->name:'');?><br/>
		<?php echo $obj->address->country->name;?><br/>
		<?php echo $obj->address->phone;?>
		</div>
	</div>
	<div class="page-cart">
<?php
	$products = $obj->cart->getProducts();
?>
		<table width="100%" cellspacing="0" cellpadding="0">
			<tr>
				<th>Product</th>
				<th>Unit Price</th>
				<th>Qty</th>
				<th>Total</th>
			</tr>
			<?php foreach($products as $product){?>
			<tr>
				<td><?php echo str_ireplace($isNeed,'',$product['name']);?></td>
				<td><?php echo Tools::displayPrice($product['price']);?></td>
				<td><?php echo $product['quantity'];?></td>
				<td><?php echo Tools::displayPrice($product['total']);?></td>
			</tr>
			<?php }?>
			<tr>
				<td colspan="3" class="alignr">Product Total</td>
				<td><?php echo Tools::displayPrice($obj->product_total);?></td>
			</tr>
			<tr>
				<td colspan="3" class="alignr">Shippint Total</td>
				<td><?php echo Tools::displayPrice($obj->shipping_total);?></td>
			</tr>
			<?php if($obj->discount>0){?>
			<tr>
				<td colspan="3" class="alignr">Discount</td>
				<td>- <?php echo Tools::displayPrice($obj->discount);?></td>
			</tr>
			<?php }?>
			<tr>
				<td colspan="3" class="alignr"><strong>Total</strong></td>
				<td><strong><?php echo Tools::displayPrice($obj->amount);?></strong></td>
			</tr>
		</table>
	</div>
</div>