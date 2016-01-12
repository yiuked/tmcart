<?php /* Smarty version Smarty-3.1.12, created on 2016-01-11 21:10:30
         compiled from "/Users/apple/Documents/httpd/red/shoes/themes/shop/block/errors.tpl" */ ?>
<?php /*%%SmartyHeaderCode:550654425693a9c68c2b25-74027717%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1626229233f727c83ce6a458628757ec80058228' => 
    array (
      0 => '/Users/apple/Documents/httpd/red/shoes/themes/shop/block/errors.tpl',
      1 => 1452229588,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '550654425693a9c68c2b25-74027717',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'errors' => 0,
    'k' => 0,
    'error' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_5693a9c68db406_55102559',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5693a9c68db406_55102559')) {function content_5693a9c68db406_55102559($_smarty_tpl) {?><?php if (isset($_smarty_tpl->tpl_vars['errors']->value)&&$_smarty_tpl->tpl_vars['errors']->value){?>
	<div class="alert alert-danger" role="alert">
		错误
		<ol>
		<?php  $_smarty_tpl->tpl_vars['error'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['error']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['errors']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['error']->key => $_smarty_tpl->tpl_vars['error']->value){
$_smarty_tpl->tpl_vars['error']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['error']->key;
?>
			<li><?php echo $_smarty_tpl->tpl_vars['k']->value;?>
-<?php echo $_smarty_tpl->tpl_vars['error']->value;?>
</li>
		<?php } ?>
		</ol>
	</div>
<?php }?><?php }} ?>