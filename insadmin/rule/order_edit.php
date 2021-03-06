<?php

if(isset($_GET['id'])){
	$id  = (int)$_GET['id'];
	$obj = new Order($id);
}
if(Tools::isSubmit('orderStatusUpdate')){
	$obj->id_order_status = (int)(Tools::getRequest('id_order_status'));
	if(strlen(trim(Tools::getRequest('track_number')))>0){
		$obj->track_number =  Tools::getRequest('track_number');
		Alert::send($obj->id_user,"Your order:#".sprintf("%09d",intval($obj->id))." has been shipped.");
	}
	$obj->update();
	$obj->order_status = new OrderStatus((int)($obj->id_order_status));
}

$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '定单 #'.sprintf("%09d",$id), 'active' => true));
$bread = $breadcrumb->draw();
$btn_group = array(
	array('type' => 'button', 'title' => '提交到定单系统', 'id'=>'send-to-order-system',  'class' => 'btn-success', 'icon' => 'wrench') ,
	array('type' => 'a', 'title' => '预览', 'href' => 'index.php?rule=order_view&id=' . $obj->id,  'class' => 'btn-warning', 'icon' => 'eye-open') ,
	array('type' => 'a', 'title' => '返回', 'href' => 'index.php?rule=order',  'class' => 'btn-primary', 'icon' => 'level-up') ,
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');
?>

<div class="order_base_info">
	<div style="width: 49%; float:left;">
		<fieldset class="small">
			<legend><img src="<?php echo $_tmconfig['ico_dir'];?>tab-customers.gif">用户</legend>
			<span style="font-weight: bold; font-size: 14px;"><a href="index.php?rule=user_edit&id=<?php echo $obj->join('User', 'id_user')->id;?>">
				<?php echo $obj->join('User', 'id_user')->name;?></a></span> (#<?php echo sprintf("%09d",$id);?>)<br>
			(<a href="mailto:<?php echo $obj->join('User', 'id_user')->email;?>"><?php echo $obj->join('User', 'id_user')->email;?></a>)<br><br>
		</fieldset>
		<fieldset class="small">
			<legend><img src="<?php echo $_tmconfig['ico_dir'];?>delivery.gif">配送地址</legend>
			<div style="float: right">
				<a href="index.php?rule=address_edit&id=<?php echo $obj->join('Address', 'id_address')->id;?>"><img src="<?php echo $_tmconfig['ico_dir'];?>edit.gif"></a>
			</div>
			<?php echo $obj->join('Address', 'id_address')->name;?><br/>
			<?php echo $obj->join('Address', 'id_address')->address;?><br/>
			<?php echo $obj->join('Address', 'id_address')->postcode.' '.$obj->join('Address', 'id_address')->city.' '.($obj->join('Address', 'id_address')->join('Country', 'id_country')->need_state ? $obj->join('Address', 'id_address')->join('State', 'id_state')->name : '');?><br/>
			<?php echo $obj->join('Address', 'id_address')->join('Country', 'id_country')->name;?><br/>
			<?php echo $obj->join('Address', 'id_address')->phone;?>
		</fieldset>
	</div>
	<div style="width: 49%; float:right;">
		<fieldset class="small">
			<?php 
				$order_stauts = OrderStatus::loadData();
			?>
			<legend><img src="<?php echo $_tmconfig['ico_dir'];?>details.gif">定单状态</legend>
			<form action="" method="post" name="order_status">
				<p><b>当前状态:</b><span style="background-color:<?php echo $obj->join('OrderStatus', 'id_order_status')->color;?>;color:white" class="color_field"><?php echo $obj->join('OrderStatus', 'id_order_status')->name;?></span></p>
				<p><b>更新状态为:</b>
				<select id="id_order_status" name="id_order_status">
					<?php foreach($order_stauts['items'] as $status){?>
					<option value="<?php echo $status['id_order_status'];?>" <?php if($status['id_order_status']==$obj->join('OrderStatus', 'id_order_status')->id){?>selected="selected"<?php }?>><?php echo $status['name'];?></option>
					<?php }?>
				</select></p>
				<p><b>物流单号:</b>
				<input name="track_number" id="track_number" type="text" value="<?php echo $obj->track_number;?>"></p>
				<p><input type="submit" name="orderStatusUpdate" value="更新" class="button"/></p>
			</form>
		</fieldset>
	</div>
</div>
<div class="order_product" style=" clear:both;">
<?php
	$products = $obj->join('Cart', 'id_cart')->getProducts();
?>
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
			<?php } ?>
		</table>
		<div style="float:right; margin-top: 20px;">
			<table cellspacing="0" cellpadding="0" width="450px;" style="border-radius:0px;" class="table">
			  <tbody>
				<tr id="total_products">
				  <td width="150px;"><b>产品小计</b></td>
				  <td align="right" class="amount"><?php echo Tools::displayPrice($obj->product_total);?></td>
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
				  <td><b>运费</b></td>
				  <td align="right" class="amount"><?php echo Tools::displayPrice($obj->shipping_total);?></td>
				  <td style="display:none;" class="partial_refund_fields current-edit">£
					<input type="text" value="0" name="partialRefundShippingCost" size="3"></td>
				</tr>
				<tr id="total_order" style="font-size: 20px">
				  <td style="font-size: 20px">总计</td>
				  <td align="right" style="font-size: 20px" class="amount"><?php echo Tools::displayPrice($obj->amount);?></td>
				  <td style="display:none;" class="partial_refund_fields current-edit">&nbsp;</td>
				</tr>
			  </tbody>
			</table>
		</div>
	</fieldset>
</div>
<script>
$(document).ready(function(){
	$("#send-to-order-system").click(function(){
		var id_order = $(this).attr("data-id"); 
		$('.cc_button li.status').html('<img src="<?php echo $_tmconfig['ico_dir'];?>loader.gif" />提交中...')
		$.ajax({
			url: 'public/ajax_sendorder.php',
			cache: false,
			data: "sendorder=true&id_order="+id_order,
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