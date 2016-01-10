<?php /* Smarty version Smarty-3.1.12, created on 2015-05-20 10:57:44
         compiled from "D:\wamp\www\red\shoes\themes\shop\payment_result.tpl" */ ?>
<?php /*%%SmartyHeaderCode:28174555bf828c6dd69-57929540%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cdb39683c428e9dc8f46d6d584889b69d4a8959e' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\themes\\shop\\payment_result.tpl',
      1 => 1419218761,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '28174555bf828c6dd69-57929540',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'HOOK_PAYMENT_RESULT' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_555bf828c76ac3_24989392',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_555bf828c76ac3_24989392')) {function content_555bf828c76ac3_24989392($_smarty_tpl) {?><div id="main_columns">
<h2 class="tc-standard">Checkout Result Confirmation</h2>
<div class="box-style">
	<div class="bd">
	<?php echo $_smarty_tpl->tpl_vars['HOOK_PAYMENT_RESULT']->value;?>

	</div>
</div>
</div><?php }} ?>