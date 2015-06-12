<?php /* Smarty version Smarty-3.1.12, created on 2014-12-26 17:02:43
         compiled from "D:\wamp\www\red\shoes\modules\block\cmsblock\cmsblock.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12122549d24333116e0-79464439%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5ee9ef8f7a68947183e424e6aa5a501f4f4e9261' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\modules\\block\\cmsblock\\cmsblock.tpl',
      1 => 1418192461,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12122549d24333116e0-79464439',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_549d24333aec01_66570311',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_549d24333aec01_66570311')) {function content_549d24333aec01_66570311($_smarty_tpl) {?><div class="product-list-filter facets-container">
	<div class="section actif">
		<h3 class="filter-title"><a href="#"><span>Contact Us</span></a></h3>
		<ul class="bluemenu">
			<li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('CMSView',142);?>
" title="About Us">About Us</a></li>
			<li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('MyordersView');?>
" title="Order Tracking">Order Tracking</a></li>
			<li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('CMSView',146);?>
" title="Shipping & Returns">Shipping & Returns</a></li>
			<li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('CMSView',145);?>
" title="Frequently Asked Questions">Frequently Asked Questions</a></li>
			<li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('CMSView',147);?>
" title="Privacy Policy">Privacy Policy</a></li>
			<li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('ContactView');?>
" title="Contact Us">Contact Us</a></li>
		</ul>
 	</div>
</div><?php }} ?>