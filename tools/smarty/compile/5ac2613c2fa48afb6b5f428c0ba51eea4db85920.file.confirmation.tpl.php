<?php /* Smarty version Smarty-3.1.12, created on 2015-05-20 10:57:44
         compiled from "D:\wamp\www\red\shoes\modules\payment\sht\confirmation.tpl" */ ?>
<?php /*%%SmartyHeaderCode:27657555bf828c00fa3-09506943%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5ac2613c2fa48afb6b5f428c0ba51eea4db85920' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\modules\\payment\\sht\\confirmation.tpl',
      1 => 1425013576,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '27657555bf828c00fa3-09506943',
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
  'unifunc' => 'content_555bf828c4b723_61516191',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555bf828c4b723_61516191')) {function content_555bf828c4b723_61516191($_smarty_tpl) {?><p>Your order on' <span class="bold"><?php echo $_smarty_tpl->tpl_vars['shop_name']->value;?>
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