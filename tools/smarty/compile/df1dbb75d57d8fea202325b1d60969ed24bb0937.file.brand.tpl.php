<?php /* Smarty version Smarty-3.1.12, created on 2014-12-24 15:09:45
         compiled from "D:\wamp\www\red\shoes\themes\shop\brand.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2713549a66b9deed23-19130567%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'df1dbb75d57d8fea202325b1d60969ed24bb0937' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\themes\\shop\\brand.tpl',
      1 => 1418625811,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2713549a66b9deed23-19130567',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'entity' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_549a66b9e33cc8_54720211',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_549a66b9e33cc8_54720211')) {function content_549a66b9e33cc8_54720211($_smarty_tpl) {?><div id="main_columns_two">
<div class="list-entete">
    <div class="inner-list-entete">
    	<div><h1><?php echo $_smarty_tpl->tpl_vars['entity']->value->name;?>
</h1></div>
		<p><?php echo $_smarty_tpl->tpl_vars['entity']->value->description;?>
</p>
    </div>
</div>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./block/product_list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</div><?php }} ?>