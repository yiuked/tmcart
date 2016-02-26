<?php /* Smarty version Smarty-3.1.12, created on 2016-01-22 19:32:23
         compiled from "D:\wamp\www\red\shoes\themes\shop\cart.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13715549a679f58f126-20984040%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5457143d89ebc00a09604dc6c2095c1032608ad4' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\themes\\shop\\cart.tpl',
      1 => 1453462153,
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
    'cart_products' => 0,
    'product' => 0,
    'attribute' => 0,
    'cart_total' => 0,
    'cart_shipping' => 0,
    'cart_discount' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_549a679f7bef35_03433237')) {function content_549a679f7bef35_03433237($_smarty_tpl) {?><div class="container">
<?php if ($_smarty_tpl->tpl_vars['cart_quantity']->value>0){?>
<ul id="order_step" class="step">
	<li class="current"><span><i>01</i><strong>购物车</strong></span></li>
	<li class="todo"><span><i>02</i><strong>登录/注册</strong></span></li>
	<li class="todo"><span><i>03</i><strong>核对定单</strong></span></li>
	<li class="todo"><span><i>04</i><strong>支付</strong></span></li>
</ul>
<h2>购物车 <small> <span class="cart-total-quantity"><?php echo $_smarty_tpl->tpl_vars['cart_quantity']->value;?>
</span> 件商品</small></h2>
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
	<?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['product']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cart_products']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value){
$_smarty_tpl->tpl_vars['product']->_loop = true;
?>
	<tr class="item">
		<td class="td-select"><input type="checkbox" name="id_cart_product" value="<?php echo $_smarty_tpl->tpl_vars['product']->value['id_cart_product'];?>
"></td>
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
			<div class="input-group spinner">
				<div class="input-group-addon"><a href="javascript:;" class="minus<?php if ($_smarty_tpl->tpl_vars['product']->value['quantity']<=1){?> disable<?php }?>" data-id="<?php echo $_smarty_tpl->tpl_vars['product']->value['id_cart_product'];?>
"> - </a></div>
				<input type="text" class="form-control input-sm" value="<?php echo $_smarty_tpl->tpl_vars['product']->value['quantity'];?>
">
				<div class="input-group-addon"><a href="javascript:;" class="plus" data-id="<?php echo $_smarty_tpl->tpl_vars['product']->value['id_cart_product'];?>
"> + </a></div>
			</div>
		</td>
		<td class="td-total"><strong><?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['product']->value['total']),$_smarty_tpl);?>
</strong></td>
		<td class="td-action"><a href="javascript:;" class="cart_quantity_delete" data-id="<?php echo $_smarty_tpl->tpl_vars['product']->value['id_cart_product'];?>
">删除</a></td>
	</tr>
	<?php } ?>
	<tr class="basket-footer">
		<td><input type="checkbox" name="check-all" class="check-all" data-name="id_cart_product"> 全选</td>
		<td><a href="javascript:;" class="cart-selected-delete">删除选中</a></td>
		<td colspan="4" class="price-sum">
			<div>
				<span class="txt">总价（不含运费）：</span>
				<span class="price total-price"><?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['cart_total']->value+$_smarty_tpl->tpl_vars['cart_shipping']->value-$_smarty_tpl->tpl_vars['cart_discount']->value),$_smarty_tpl);?>
</span>
				<br>
				<span class="txt">已节省：</span>
				<span class="price total-discount-price">- <?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['cart_discount']->value),$_smarty_tpl);?>
</span>
			</div>
		</td>
		<td class="td-action checkout"><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('CheckoutView');?>
">去结算</a></td>
	</tr>
</table>
<?php }else{ ?>
<h2 class="tc-standard">购物车为空...</h2>
<div class="box-style">
  <div class="bd">
    <ul class="spacer-list no txt-14">
      <li>你可能会喜欢? <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('SaleView');?>
" class="all no"><strong>这些商品...</strong></a> </li>
      <li>去我收藏过的商品里看看? <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('WishView');?>
" class="all no"><strong>点击这里!</strong></a> </li>
    </ul>
  </div>
</div>
<?php }?>
</div><?php }} ?>