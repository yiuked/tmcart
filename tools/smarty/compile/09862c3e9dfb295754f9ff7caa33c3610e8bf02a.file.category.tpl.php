<?php /* Smarty version Smarty-3.1.12, created on 2015-11-13 23:27:21
         compiled from "D:\wamp\www\red\shoes\themes\shop\category.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1981354992dda6e60f3-36407533%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '09862c3e9dfb295754f9ff7caa33c3610e8bf02a' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\themes\\shop\\category.tpl',
      1 => 1446561897,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1981354992dda6e60f3-36407533',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_54992dda6f93e1_59988549',
  'variables' => 
  array (
    'name' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54992dda6f93e1_59988549')) {function content_54992dda6f93e1_59988549($_smarty_tpl) {?><div id="main_columns_two">
<div class="list-entete">
    <div class="inner-list-entete">
    	<div><h1><?php echo $_smarty_tpl->tpl_vars['name']->value;?>
</h1></div>
    </div>
</div>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./block/product_list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</div><?php }} ?>