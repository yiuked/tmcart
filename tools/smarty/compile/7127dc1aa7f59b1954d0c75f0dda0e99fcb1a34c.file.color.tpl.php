<?php /* Smarty version Smarty-3.1.12, created on 2015-01-24 12:11:52
         compiled from "D:\wamp\www\red\shoes\themes\shop\color.tpl" */ ?>
<?php /*%%SmartyHeaderCode:734354c31b88a3e528-41695506%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7127dc1aa7f59b1954d0c75f0dda0e99fcb1a34c' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\themes\\shop\\color.tpl',
      1 => 1410770962,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '734354c31b88a3e528-41695506',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'BREADCRUMB' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_54c31b88a5d0a1_31380041',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54c31b88a5d0a1_31380041')) {function content_54c31b88a5d0a1_31380041($_smarty_tpl) {?><div id="main_columns_two">
<?php echo $_smarty_tpl->tpl_vars['BREADCRUMB']->value;?>

<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./block/product_list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</div><?php }} ?>