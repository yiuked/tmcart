<?php /* Smarty version Smarty-3.1.12, created on 2015-12-22 12:21:53
         compiled from "D:\wamp\www\red\shoes\modules\block\myaccount\myaccount.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2563549bc284e0de63-40214919%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '21ccdb19fd91ac23d8ba6ab4729a01d40d833662' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\modules\\block\\myaccount\\myaccount.tpl',
      1 => 1450758109,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2563549bc284e0de63-40214919',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_549bc284ea6c06_36031924',
  'variables' => 
  array (
    'link' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_549bc284ea6c06_36031924')) {function content_549bc284ea6c06_36031924($_smarty_tpl) {?><div class="list-group">
	<a href="#" class="list-group-item disabled">个人中心</a>
	<a class="list-group-item" href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('MyordersView');?>
" title="定单管理">定单管理</a>
	<a class="list-group-item" href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('MyaddressesView');?>
" title="收货地址">收货地址</a>
	<a class="list-group-item" href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('MyWishView');?>
" title="关注商品">关注商品</a>
	<a class="list-group-item" href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('MyfeedbackView');?>
" title="商品评价">商品评价</a>
	<a class="list-group-item" href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('MyAlertView');?>
" title="站内信息">站内信息</a>
	<a class="list-group-item" href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('UserView');?>
" title="账户信息">账户信息</a>
	<a class="list-group-item" href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('MyaccountView');?>
?mylogout" title="注销">注销</a>
</div><?php }} ?>