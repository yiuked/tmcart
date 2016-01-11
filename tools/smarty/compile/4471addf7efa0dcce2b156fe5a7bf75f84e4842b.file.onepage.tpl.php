<?php /* Smarty version Smarty-3.1.12, created on 2016-01-11 14:01:33
         compiled from "D:\wamp\www\red\shoes\themes\shop\block\onepage.tpl" */ ?>
<?php /*%%SmartyHeaderCode:469454b8df9014a788-63244910%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4471addf7efa0dcce2b156fe5a7bf75f84e4842b' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\themes\\shop\\block\\onepage.tpl',
      1 => 1452492090,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '469454b8df9014a788-63244910',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_54b8df90477216_05289135',
  'variables' => 
  array (
    'link' => 0,
    'address' => 0,
    'carriers' => 0,
    'carrier' => 0,
    'cart' => 0,
    'products' => 0,
    'product' => 0,
    'attribute' => 0,
    'shipping' => 0,
    'discount' => 0,
    'total' => 0,
    'payments' => 0,
    'payment' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54b8df90477216_05289135')) {function content_54b8df90477216_05289135($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_truncate')) include 'D:\\wamp\\www\\red\\shoes\\tools\\smarty\\plugins\\modifier.truncate.php';
if (!is_callable('smarty_modifier_escape')) include 'D:\\wamp\\www\\red\\shoes\\tools\\smarty\\plugins\\modifier.escape.php';
?><ul id="order_step" class="step">
	<li class="done"><span><i>01</i><strong>购物车</strong></span></li>
	<li class="done"><span><i>02</i><strong>注册/登录</strong></span></li>
	<li class="current"><span><i>03</i><strong>配送</strong></span></li>
	<li class="todo"><span><i>04</i><strong>支付</strong></span></li>
</ul>
<div class="box-style">
<form action="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('ConfirmOrderView');?>
" method="post" class="bd" id="order-confrim">
<div class="row">
	<h2>支付</h2>
	<div class="txt-22"><p>请确认您的定单信息后继续支付.</p></div>
</div>
<fieldset id="p-address">
	<legend>收货地址</legend>
	<p class="selectedAddress">
        <strong><?php echo $_smarty_tpl->tpl_vars['address']->value->name;?>
</strong><br>
		<?php echo $_smarty_tpl->tpl_vars['address']->value->address;?>
<?php if ($_smarty_tpl->tpl_vars['address']->value->address2){?> <?php echo $_smarty_tpl->tpl_vars['address']->value->address2;?>
<?php }?><br>
		<?php echo $_smarty_tpl->tpl_vars['address']->value->postcode;?>
 <?php echo $_smarty_tpl->tpl_vars['address']->value->city;?>
 <?php if ($_smarty_tpl->tpl_vars['address']->value->join('Country','id_country')->need_state){?> <?php echo $_smarty_tpl->tpl_vars['address']->value->join('State','id_state')->name;?>
<?php }?> <br>
		<?php echo $_smarty_tpl->tpl_vars['address']->value->join('Country','id_country')->name;?>
<br>
		<?php echo $_smarty_tpl->tpl_vars['address']->value->phone;?>
<br>
        <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('AddressView',$_smarty_tpl->tpl_vars['address']->value->id,"referer=CheckoutView");?>
" class="all"><strong>编辑</strong></a>
    </p>
</fieldset>
<br/>
<?php if (count($_smarty_tpl->tpl_vars['carriers']->value['items'])>1){?>
<fieldset id="p-carrier">
	<legend>Delivery methods</legend>
	<ul id="carrier-list" class="carrier-list">
	<?php  $_smarty_tpl->tpl_vars['carrier'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['carrier']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['carriers']->value['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['carrier']->key => $_smarty_tpl->tpl_vars['carrier']->value){
$_smarty_tpl->tpl_vars['carrier']->_loop = true;
?>
		<li>
			<input type="radio" name="id_carrier" value="<?php echo $_smarty_tpl->tpl_vars['carrier']->value['id_carrier'];?>
" class="carrier_list" id="id_address_<?php echo $_smarty_tpl->tpl_vars['carrier']->value['id_carrier'];?>
" <?php if ($_smarty_tpl->tpl_vars['cart']->value->id_carrier==$_smarty_tpl->tpl_vars['carrier']->value['id_carrier']){?>checked="checked"<?php }?>/>
			<label for="id_carrier_<?php echo $_smarty_tpl->tpl_vars['carrier']->value['id_carrier'];?>
"><strong><?php echo $_smarty_tpl->tpl_vars['carrier']->value['name'];?>
</strong> <span><?php echo $_smarty_tpl->tpl_vars['carrier']->value['description'];?>
</span></label>
			<font color="#f60">(<?php if ($_smarty_tpl->tpl_vars['carrier']->value['shipping']>0){?>+<?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['carrier']->value['shipping']),$_smarty_tpl);?>
<?php }else{ ?>Free Shipping<?php }?>)</font>
		</li>
	<?php } ?>
	</ul>
</fieldset>
<br/>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['products']->value){?>
<div class="cart_block">
	<table width="100%">
		<?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['product']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['products']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value){
$_smarty_tpl->tpl_vars['product']->_loop = true;
?>
		<tr>
			<td style="padding:5px"><a href="<?php echo $_smarty_tpl->tpl_vars['product']->value['link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>
" target="_blank"><img src="<?php echo $_smarty_tpl->tpl_vars['product']->value['image'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>
" /></a></td>
			<td valign="top"><a href="<?php echo $_smarty_tpl->tpl_vars['product']->value['link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>
" target="_blank"><?php echo smarty_modifier_escape(smarty_modifier_truncate($_smarty_tpl->tpl_vars['product']->value['name'],50,'...'), 'html', 'UTF-8');?>
</a><br/>
				<?php  $_smarty_tpl->tpl_vars['attribute'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['attribute']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['product']->value['attributes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['attribute']->key => $_smarty_tpl->tpl_vars['attribute']->value){
$_smarty_tpl->tpl_vars['attribute']->_loop = true;
?>
				<em><?php echo $_smarty_tpl->tpl_vars['attribute']->value['group_name'];?>
:<?php echo $_smarty_tpl->tpl_vars['attribute']->value['name'];?>
</em><br/>
				<?php } ?>
				Quantity:<?php echo $_smarty_tpl->tpl_vars['product']->value['quantity'];?>

			</td>
			<td align="right"><strong><?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['product']->value['total']),$_smarty_tpl);?>
</strong></td>
		</tr>
		<?php } ?>
	</table>
</div>
<?php }?>
<div class="panier-resume">
<div class="panier-livraison" <?php if ($_smarty_tpl->tpl_vars['cart']->value->id_carrier==0){?>style="display:none"<?php }?>>
	<p class="panier-resume-titre">
	<?php $_smarty_tpl->tpl_vars["shipping"] = new Smarty_variable($_smarty_tpl->tpl_vars['cart']->value->getShippingTotal(), null, 0);?>
	<?php if ($_smarty_tpl->tpl_vars['shipping']->value==0){?>
		<label class="icon-checkmark">Shipping</label>
		<strong class="free">FREE</strong>
	<?php }else{ ?>
		<label>Shipping</label>
		<strong><?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['shipping']->value),$_smarty_tpl);?>
</strong>
	<?php }?>
	</p>
</div>
<?php if ($_smarty_tpl->tpl_vars['discount']->value>0){?>
<div class="panier-promo">
	<div class="promocode-total">
		<div class="panier-resume-titre">
			<span>Promo code</span>
			<strong>-<?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['discount']->value),$_smarty_tpl);?>
</strong>
		</div>
	</div>
</div>
<?php }?>
<div class="panier-total panier-resume-titre">
	<span>Total</span>
	<strong id="a_total"><?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['total']->value-$_smarty_tpl->tpl_vars['discount']->value),$_smarty_tpl);?>
</strong>
</div>
</div>
<br/>
<div class="tabs">
<?php  $_smarty_tpl->tpl_vars['payment'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['payment']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['payments']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['payment']->key => $_smarty_tpl->tpl_vars['payment']->value){
$_smarty_tpl->tpl_vars['payment']->_loop = true;
?>
<?php echo $_smarty_tpl->tpl_vars['payment']->value;?>

<?php } ?>
</div>
</form>
</div>
<script type="text/javascript">
var ajaxLink = "<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('AjaxView');?>
";
var id_cart  = <?php echo $_smarty_tpl->tpl_vars['cart']->value->id;?>


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

</script><?php }} ?>