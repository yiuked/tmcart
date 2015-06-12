<?php /* Smarty version Smarty-3.1.12, created on 2014-12-24 15:13:46
         compiled from "D:\wamp\www\red\shoes\themes\shop\block\errors.tpl" */ ?>
<?php /*%%SmartyHeaderCode:32201549a67aa1f3a12-47673069%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0ccae469326ccaf49268a6aed5263545ecd3841a' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\themes\\shop\\block\\errors.tpl',
      1 => 1358825986,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '32201549a67aa1f3a12-47673069',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'errors' => 0,
    'error' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_549a67aa21d828_63668498',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_549a67aa21d828_63668498')) {function content_549a67aa21d828_63668498($_smarty_tpl) {?><?php if (isset($_smarty_tpl->tpl_vars['errors']->value)&&$_smarty_tpl->tpl_vars['errors']->value){?>
	<div class="error">
		ERROR    
		<ol>
		<?php  $_smarty_tpl->tpl_vars['error'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['error']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['errors']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['error']->key => $_smarty_tpl->tpl_vars['error']->value){
$_smarty_tpl->tpl_vars['error']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['error']->key;
?>
			<li><?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</li>
		<?php } ?>
		</ol>
	</div>
<?php }?><?php }} ?>