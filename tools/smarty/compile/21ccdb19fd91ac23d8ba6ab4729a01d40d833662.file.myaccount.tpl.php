<?php /* Smarty version Smarty-3.1.12, created on 2014-12-25 15:53:40
         compiled from "D:\wamp\www\red\shoes\modules\block\myaccount\myaccount.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2563549bc284e0de63-40214919%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '21ccdb19fd91ac23d8ba6ab4729a01d40d833662' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\modules\\block\\myaccount\\myaccount.tpl',
      1 => 1418196381,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2563549bc284e0de63-40214919',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_549bc284ea6c06_36031924',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_549bc284ea6c06_36031924')) {function content_549bc284ea6c06_36031924($_smarty_tpl) {?><div id="myacount_block_left" class="product-list-filter facets-container">
	<div class="section actif">
		<h3 class="filter-title"><a href="#"><span>My Account</span></a></h3>
		<ul class="bluemenu">
			<li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('MyordersView');?>
" title="My Orders">My Orders</a></li>
			<li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('MyaddressesView');?>
" title="My Addresses">My Addresses</a></li>
			<li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('WishView');?>
" title="Wish Products">Wish Products</a></li>
			<li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('MyfeedbackView');?>
" title="My Addresses">My Feedbacks</a></li>
			<li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('MyAlertView');?>
" title="My Alert">My Alerts</a></li>
			<li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('UserView');?>
" title="Account Information">Account Information</a></li>
			<li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('MyaccountView');?>
?mylogout" title="Logout">Logout</a></li>
		</ul>
 	</div>
</div><?php }} ?>