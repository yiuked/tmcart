<?php

if(isset($_GET['id'])){
	$id  = (int)$_GET['id'];
	$obj = new Cart($id);
}

$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '购物车', 'href' => 'index.php?rule=cart'));
$breadcrumb->add(array('title' => '详情', 'active' => true));
$bread = $breadcrumb->draw();
$btn_group = array(
	array('type' => 'a', 'title' => '返回', 'href' => 'index.php?rule=cart', 'class' => 'btn-primary', 'icon' => 'level-up') ,
	array('type' => 'button', 'title' => '生成定单', 'id' => 'send-to-order', 'class' => 'btn-success', 'icon' => 'save') ,
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');
//echo sprintf("%09d",$id);
?>

<?php 
if(isset($obj->user)){
?>
<div class="order_base_info">
	<div style="width: 49%; float:left;">
		<fieldset class="small">
			<legend><img src="<?php echo $_tmconfig['ico_dir'];?>tab-customers.gif">用户</legend>
			<span style="font-weight: bold; font-size: 14px;"><a href="index.php?rule=user_edit&id=<?php echo $obj->user->id;?>">
				<?php echo $obj->user->first_name.' '.$obj->user->last_name;?></a></span> (#<?php echo sprintf("%09d",$id);?>)<br>
			(<a href="mailto:<?php echo $obj->user->email;?>"><?php echo $obj->user->email;?></a>)<br><br>
		</fieldset>
		<?php 
		if(isset($obj->address)){
		?>
		<fieldset class="small">
			<legend><img src="<?php echo $_tmconfig['ico_dir'];?>delivery.gif">配送地址</legend>
			<div style="float: right">
				<a href="index.php?rule=address_edit&id=<?php echo $obj->address->id;?>"><img src="<?php echo $_tmconfig['ico_dir'];?>edit.gif"></a>
			</div>
			<?php echo $obj->address->first_name.' '.$obj->address->last_name;?><br/>
			<?php echo $obj->address->address;?><br/>
			<?php echo $obj->address->postcode.' '.$obj->address->city.' '.($obj->address->id_state>0?$obj->address->state->name:"");?><br/>
			<?php echo $obj->address->country->name;?><br/>
			<?php echo $obj->address->phone;?>
		</fieldset>
		<?php
		}
		?>
	</div>
</div>
<?php
}
?>
<div class="order_product" style=" clear:both;">
	<fieldset style="width: 98%; " class="small">
		<legend><img alt="Products" src="<?php echo $_tmconfig['ico_dir'];?>cart.gif">Products</legend>
		<table id="orderProducts" class="table" cellspacing="0" cellpadding="0" style="width: 100%;">
			<tr>
				<th>图片</th>
				<th>产品</th>
				<th>单价</th>
				<th>数量</th>
				<th>总额</th>
			</tr>
			<?php
			$products = $obj->getProducts();
			if (is_array($products) && count($products) > 0) {
			?>
			<?php foreach($products as $product){?>
			<tr>
				<td><img src="<?php echo $product['image'];?>" title="<?php echo $product['name'];?>"></td>
				<td>
					<a href="<?php echo $product['link'];?>"><?php echo $product['name'];?></a><br>
					<?php foreach($product['attributes'] as $attribute){?>
					<em><?php echo $attribute['group_name'].':'.$attribute['name'] ?></em><br/>
					<?php }?>
				</td>
				<td><?php echo Tools::displayPrice($product['price']);?></td>
				<td><?php echo $product['quantity'];?></td>
				<td><?php echo Tools::displayPrice($product['total']);?></td>
			</tr>
				<?php }?>
			<?php }?>
		</table>
		<div style="float:right; margin-top: 20px;">
			<table cellspacing="0" cellpadding="0" width="450px;" style="border-radius:0px;" class="table">
			  <tbody>
				<tr id="total_products">
				  <td width="150px;"><b>产品小计</b></td>
				  <td align="right" class="amount"><?php echo Tools::displayPrice($obj->getProductTotal());?></td>
				  <td style="display:none;" class="partial_refund_fields current-edit">&nbsp;</td>
				</tr>
				<?php if($obj->discount>0){?>
				<tr id="total_discounts">
				  <td><b>优惠</b></td>
				  <td align="right" class="amount"><?php echo Tools::displayPrice($obj->discount);?></td>
				  <td style="display:none;" class="partial_refund_fields current-edit">&nbsp;</td>
				</tr>
				<?php }?>
				<tr id="total_shipping">
				  <td><b>运费</b>(<?php echo isset($obj->carrier)?$obj->carrier->name:'No choice'?>)</td>
				  <td align="right" class="amount"><?php echo Tools::displayPrice($obj->getShippingTotal());?></td>
				  <td style="display:none;" class="partial_refund_fields current-edit">£
					<input type="text" value="0" name="partialRefundShippingCost" size="3"></td>
				</tr>
				<tr id="total_order" style="font-size: 20px">
				  <td style="font-size: 20px">总计</td>
				  <td align="right" style="font-size: 20px" class="amount"><?php echo Tools::displayPrice($obj->getOrderTotal());?></td>
				  <td style="display:none;" class="partial_refund_fields current-edit">&nbsp;</td>
				</tr>
			  </tbody>
			</table>
		</div>
	</fieldset>
</div>

<script>
$(document).ready(function(){
	$("#send-to-order").click(function(){
		var id_cart = $(this).attr("data-id");
		$('.cc_button li.status').html('<img src="<?php echo $_tmconfig['ico_dir'];?>loader.gif" />提交中...')
		$.ajax({
			url: 'public/ajax_sendorder.php',
			cache: false,
			data: "carttoorder=true&id_cart="+id_cart,
			dataType: "json",
			success: function(data)
				{
					if(data.hasErrors)
						$('.cc_button li.status').html('<font color="red">'+data.msg+'</font>')
					else
						$('.cc_button li.status').html('<font color="green">提交成功!</font>')
				}
			});
		})
})
</script>