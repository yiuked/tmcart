<?php /* Smarty version Smarty-3.1.12, created on 2015-09-11 16:33:38
         compiled from "D:\wamp\www\red\shoes\modules\payment\neworder\confirmation.tpl" */ ?>
<?php /*%%SmartyHeaderCode:503255f291e22f6719-70581898%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3923ce2fbf8ba5e1552faa3c95b99b7f4140d746' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\modules\\payment\\neworder\\confirmation.tpl',
      1 => 1439179110,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '503255f291e22f6719-70581898',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'shop_name' => 0,
    'link' => 0,
    'root_dir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_55f291e2342a18_28507789',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55f291e2342a18_28507789')) {function content_55f291e2342a18_28507789($_smarty_tpl) {?><p>Your order on' <span class="bold"><?php echo $_smarty_tpl->tpl_vars['shop_name']->value;?>
</span> is complete.
	<br />
	You have chosen the creditcar method.
	<br /><span class="bold">Your order will be sent very soon.
	<br />For any questions or for further information, please contact our <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('ContactView');?>
" class="all"><strong>customer support</strong></a>
</p>
<br><br />
<p><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('MyordersView');?>
" class="all">See my orders</a></p>
<p><a href="<?php echo $_smarty_tpl->tpl_vars['root_dir']->value;?>
" class="all">Continue shoppping</a></p><?php }} ?>