<?php /* Smarty version Smarty-3.1.12, created on 2016-01-11 15:59:30
         compiled from "D:\wamp\www\red\shoes\themes\shop\my-orders.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2691654c3123315e939-90220538%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3477a758ecf800871dfbb193267430941a87287c' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\themes\\shop\\my-orders.tpl',
      1 => 1452499111,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2691654c3123315e939-90220538',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_54c312333c1078_72216633',
  'variables' => 
  array (
    'DISPLAY_LEFT' => 0,
    'orders' => 0,
    'order' => 0,
    'h_order' => 0,
    'ico_dir' => 0,
    'products' => 0,
    'product' => 0,
    'attribute' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54c312333c1078_72216633')) {function content_54c312333c1078_72216633($_smarty_tpl) {?><div class="container">
  <div class="row">
    <div class="col-md-2">
      <?php echo $_smarty_tpl->tpl_vars['DISPLAY_LEFT']->value;?>

    </div>
    <div class="col-md-10">
      <?php if ($_smarty_tpl->tpl_vars['orders']->value){?>
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
	<?php  $_smarty_tpl->tpl_vars['order'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['order']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['orders']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['order']->key => $_smarty_tpl->tpl_vars['order']->value){
$_smarty_tpl->tpl_vars['order']->_loop = true;
?>
	<tr>
		<td><?php echo $_smarty_tpl->tpl_vars['order']->value->reference;?>
</td>
		<td><span style="background-color:<?php echo $_smarty_tpl->tpl_vars['order']->value->order_status->color;?>
;color:white" class="color_field"><?php echo $_smarty_tpl->tpl_vars['order']->value->order_status->name;?>
</span></td>
		<td><?php echo $_smarty_tpl->tpl_vars['order']->value->carrier->name;?>
</td>
		<td><?php echo $_smarty_tpl->tpl_vars['order']->value->track_number;?>
</td>
		<td><?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['order']->value->amount),$_smarty_tpl);?>
</td>
		<td><?php echo $_smarty_tpl->tpl_vars['order']->value->add_date;?>
</td>
		<td><a href="?reference=<?php echo $_smarty_tpl->tpl_vars['order']->value->reference;?>
">details</a></td>
	</tr>
	<?php } ?>
</table>
<?php if (isset($_smarty_tpl->tpl_vars['h_order']->value)){?>
<div style=" clear:both;" class="order_product">
  <fieldset class="small" style="width: 98%; ">
  <legend><img src="<?php echo $_smarty_tpl->tpl_vars['ico_dir']->value;?>
cart.gif" alt="Products">Products</legend>
  <table cellspacing="0" cellpadding="0" style="width: 100%;" class="table" id="orderProducts">
    <tbody>
      <tr>
        <th>Image</th>
        <th>Proudct</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Total</th>
      </tr>
	<?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['product']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['products']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value){
$_smarty_tpl->tpl_vars['product']->_loop = true;
?>
	<tr class="item">
		<td><a href="<?php echo $_smarty_tpl->tpl_vars['product']->value['link'];?>
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
		<td class="td-quantity"><?php echo $_smarty_tpl->tpl_vars['product']->value['quantity'];?>
</td>
		<td class="td-total"><?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['product']->value['total']),$_smarty_tpl);?>
</td>
	</tr>
	<?php } ?>
    </tbody>
  </table>
  <div style="float:right; margin-top: 20px;">
    <table cellspacing="0" cellpadding="0" width="450px;" class="table" style="border-radius:0px;">
      <tbody>
        <tr id="total_products">
          <td width="150px;"><b>Item Total</b></td>
          <td align="right" class="amount"><?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['h_order']->value->product_total),$_smarty_tpl);?>
</td>
          <td class="partial_refund_fields current-edit" style="display:none;">&nbsp;</td>
        </tr>
        <tr id="total_shipping">
          <td><b>Shipping</b></td>
          <td align="right" class="amount"><?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['h_order']->value->shipping_total),$_smarty_tpl);?>
</td>
          <td class="partial_refund_fields current-edit" style="display:none;">£
            <input type="text" size="3" name="partialRefundShippingCost" value="0"></td>
        </tr>
        <tr style="font-size: 20px" id="total_order">
          <td style="font-size: 20px">Total</td>
          <td align="right" class="amount" style="font-size: 20px"><?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['h_order']->value->amount),$_smarty_tpl);?>
</td>
          <td class="partial_refund_fields current-edit" style="display:none;">&nbsp;</td>
        </tr>
      </tbody>
    </table>
  </div>
  </fieldset>
</div>
<?php }?>

<?php }else{ ?>
<p class="warning">You have not placed any orders.</p>
<?php }?>
    </div>
  </div>
</div><?php }} ?>