<?php /* Smarty version Smarty-3.1.12, created on 2015-12-22 13:52:35
         compiled from "D:\wamp\www\red\shoes\themes\shop\cart.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13715549a679f58f126-20984040%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5457143d89ebc00a09604dc6c2095c1032608ad4' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\themes\\shop\\cart.tpl',
      1 => 1450763552,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13715549a679f58f126-20984040',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_549a679f7bef35_03433237',
  'variables' => 
  array (
    'cart_quantity' => 0,
    'success' => 0,
    'link' => 0,
    'cart_products' => 0,
    'product' => 0,
    'img_dir' => 0,
    'attribute' => 0,
    'coupons' => 0,
    'coupon' => 0,
    'cart_total' => 0,
    'cart_msg' => 0,
    'cart_discount' => 0,
    'cart_shipping' => 0,
    'enjoy_free_shipping' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_549a679f7bef35_03433237')) {function content_549a679f7bef35_03433237($_smarty_tpl) {?><div id="main_columns">
<?php if ($_smarty_tpl->tpl_vars['cart_quantity']->value>0){?>
<ul id="order_step" class="step">
	<li class="current"><span><i>01</i><strong>Summary</strong></span></li>
	<li class="todo"><span><i>02</i><strong>Sign in/Login</strong></span></li>
	<li class="todo"><span><i>03</i><strong>Delivery</strong></span></li>
	<li class="todo"><span><i>04</i><strong>Payment</strong></span></li>
</ul>
<h2 class="tc-standard">Your Shopping Cart</h2>
<br/>
<?php if (isset($_smarty_tpl->tpl_vars['success']->value)){?><div class="success"><?php echo $_smarty_tpl->tpl_vars['success']->value;?>
</div><?php }?>
<form method="post" action="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('CartView');?>
" name="shopping_cart_form" class="shopping_cart_form">
<table width="100%" class="cart" cellspacing="0" cellpadding="0" border="0">
	<tr class="basket-header">
		<th class="th-delete"></th>
		<th class="th-image"></th>
		<th class="th-name">Product</th>
		<th class="th-price">Unit price</th>
		<th class="th-quantity">Quantity</th>
		<th class="th-total">Total</th>
	</tr>
	<?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['product']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cart_products']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value){
$_smarty_tpl->tpl_vars['product']->_loop = true;
?>
	<tr class="item">
		<td class="td-delete"><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('CartView');?>
?delete=<?php echo $_smarty_tpl->tpl_vars['product']->value['id_cart_product'];?>
" class="cart_quantity_delete" rel="nofollow"><img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
btn_trash.gif" alt="delete" /></a></td>
		<td class="td-image"><a href="<?php echo $_smarty_tpl->tpl_vars['product']->value['link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>
" target="_blank"><img src="<?php echo $_smarty_tpl->tpl_vars['product']->value['image'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>
" /></a></td>
		<td class="td-name"><a href="<?php echo $_smarty_tpl->tpl_vars['product']->value['link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>
" target="_blank"><?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>
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
		</td>
		<td class="td-price"><?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['product']->value['price']),$_smarty_tpl);?>
</td>
		<td class="td-quantity">
		<span class="skin-select skin">
			<span class="select-content"><span><?php echo $_smarty_tpl->tpl_vars['product']->value['quantity'];?>
</span></span>
			<select data-nofirst="true" class="skin shopping_cart_form_submit" autocomplete="off" name="quantity[<?php echo $_smarty_tpl->tpl_vars['product']->value['id_cart_product'];?>
][quantity]">
			 <?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['start'] = (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['loop'] = is_array($_loop=6) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['name'] = 'quantityLoop';
$_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['step'] = 1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['total']);
?>
			  <option value="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['quantityLoop']['index'];?>
" <?php if ($_smarty_tpl->getVariable('smarty')->value['section']['quantityLoop']['index']==$_smarty_tpl->tpl_vars['product']->value['quantity']){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['quantityLoop']['index'];?>
</option>
			  <?php endfor; endif; ?>
			</select>
			<span class="sub-dd">
				<ul class="list-item">
				<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['start'] = (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['loop'] = is_array($_loop=6) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['name'] = 'quantityLoop';
$_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['step'] = 1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['quantityLoop']['total']);
?>
				  <li<?php if ($_smarty_tpl->getVariable('smarty')->value['section']['quantityLoop']['index']==$_smarty_tpl->tpl_vars['product']->value['quantity']){?> class="active"<?php }?>>
				  	<a class="shoesize " rel="<?php echo $_smarty_tpl->getVariable('smarty')->value['section']['quantityLoop']['index'];?>
" href="#"><span><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['quantityLoop']['index'];?>
</span></a>
				  </li>
				 <?php endfor; endif; ?>
				</ul>
			</span>
		</span>
		</td>
		<td class="td-total"><strong><?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['product']->value['total']),$_smarty_tpl);?>
</strong></td>
	</tr>
	<?php } ?>
	<tr class="basket-footer">
		<td colspan="7"><p align="right"><input type="hidden" value="Update Shopping Cart" class="btn" name="cart_update" /></p></td>
	</tr>
</table>
</form>
<br/>
<div class="clear"></div>
<?php if (isset($_smarty_tpl->tpl_vars['coupons']->value)){?>
<div class="panier-resume coupons">
	<table>
		<tr>
			<th>Code</th>
			<th>Save</th>
			<th>Conditions</th>
		</tr>
		<?php  $_smarty_tpl->tpl_vars['coupon'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['coupon']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['coupons']->value['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['coupon']->key => $_smarty_tpl->tpl_vars['coupon']->value){
$_smarty_tpl->tpl_vars['coupon']->_loop = true;
?>
		<tr>
			<td><?php echo $_smarty_tpl->tpl_vars['coupon']->value['code'];?>
</td>
			<td>
				<?php if ($_smarty_tpl->tpl_vars['coupon']->value['off']>0){?>
				<?php echo $_smarty_tpl->tpl_vars['coupon']->value['off'];?>
%
				<?php }else{ ?>
				-<?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['coupon']->value['amount']),$_smarty_tpl);?>

				<?php }?>
			</td>
			<td><?php echo $_smarty_tpl->tpl_vars['coupon']->value['code'];?>
</td>
			<td>
			<?php if ($_smarty_tpl->tpl_vars['coupon']->value['total_over']>0){?>
				<?php if ($_smarty_tpl->tpl_vars['cart_total']->value>$_smarty_tpl->tpl_vars['coupon']->value['total_over']){?>
				YES
				<?php }else{ ?>
				NO(<?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['coupon']->value['total_over']-$_smarty_tpl->tpl_vars['cart_total']->value),$_smarty_tpl);?>
)
				<?php }?>
			<?php }else{ ?>
				<?php if ($_smarty_tpl->tpl_vars['cart_quantity']->value>$_smarty_tpl->tpl_vars['coupon']->value['quantity_over']){?>
				YES
				<?php }else{ ?>
				NO(<?php echo $_smarty_tpl->tpl_vars['coupon']->value['quantity_over']-$_smarty_tpl->tpl_vars['cart_quantity']->value;?>
items)
				<?php }?>
			<?php }?>
			</td>
		</tr>
		<?php } ?>
	</table>
</div>
<?php }?>
<div class="panier-resume cart-total">
	<form method="post" action="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('CheckoutView');?>
" name="checkout_form" id="checkout_form">
	<div class="memo" id="information">
		<label>Leave a message:</label>
		<textarea placeholder="Information.(optional)" autocomplete="off" class="memo-input <?php if (strlen($_smarty_tpl->tpl_vars['cart_msg']->value)<5){?>memo-close<?php }?>" name="msg"><?php if ($_smarty_tpl->tpl_vars['cart_msg']->value){?><?php echo $_smarty_tpl->tpl_vars['cart_msg']->value;?>
<?php }?></textarea>
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
		  <p class="loader hidden"><img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
loader.gif" /></p>
	    </div>
		<div class="promocode-total <?php if ($_smarty_tpl->tpl_vars['cart_discount']->value==0){?>hidden<?php }?>">
			<div class="panier-resume-titre">
				<span>Promo code</span>
				<strong>-<?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['cart_discount']->value),$_smarty_tpl);?>
</strong>
			</div>
		</div>
	</div>
	<div class="panier-livraison">
	<?php if ($_smarty_tpl->tpl_vars['cart_shipping']->value==0){?>
		<p class="panier-resume-titre">
			<label class="icon-checkmark">Shipping</label>
			<strong class="free">FREE</strong>
		</p>
		<?php }else{ ?>
		<p class="panier-resume-titre">
			<label>Shipping</label>
			<strong><?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['cart_shipping']->value),$_smarty_tpl);?>
</strong>
		</p>
		<p style="color: rgb(102, 102, 102); font-size: 11px; padding-left: 15px;">Remaining amount to be added to your cart in order to obtain free shipping:<?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['enjoy_free_shipping']->value-$_smarty_tpl->tpl_vars['cart_total']->value),$_smarty_tpl);?>
</p>
		<?php }?>
	</div>
	<div class="panier-total panier-resume-titre">
		<span>Total</span>
		<strong><?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['cart_total']->value+$_smarty_tpl->tpl_vars['cart_shipping']->value-$_smarty_tpl->tpl_vars['cart_discount']->value),$_smarty_tpl);?>
</strong>
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
<?php }else{ ?>
<h2 class="tc-standard">Your basket is empty...</h2>
<div class="box-style">
  <div class="bd">
    <ul class="spacer-list no txt-14">
      <li>Looking for the hottest styles? <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('SaleView');?>
" class="all no"><strong>This way for inspiration...</strong></a> </li>
      <li>Already added items to your favourites? <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('WishView');?>
" class="all no"><strong>See them here!</strong></a> </li>
    </ul>
  </div>
</div>
<?php }?>
</div><?php }} ?>