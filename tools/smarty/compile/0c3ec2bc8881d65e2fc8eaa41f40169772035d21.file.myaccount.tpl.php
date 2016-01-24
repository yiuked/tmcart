<?php /* Smarty version Smarty-3.1.12, created on 2016-01-24 10:57:31
         compiled from "/Users/apple/Documents/httpd/red/shoes/modules/block/myaccount/myaccount.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4034963305693a9d388a624-08549044%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0c3ec2bc8881d65e2fc8eaa41f40169772035d21' => 
    array (
      0 => '/Users/apple/Documents/httpd/red/shoes/modules/block/myaccount/myaccount.tpl',
      1 => 1453604206,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4034963305693a9d388a624-08549044',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_5693a9d38ed504_44950056',
  'variables' => 
  array (
    'link' => 0,
    'exit' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5693a9d38ed504_44950056')) {function content_5693a9d38ed504_44950056($_smarty_tpl) {?><div class="list-group">
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
	<a class="list-group-item" href="<?php echo $_smarty_tpl->tpl_vars['exit']->value;?>
" title="注销">注销</a>
</div><?php }} ?>