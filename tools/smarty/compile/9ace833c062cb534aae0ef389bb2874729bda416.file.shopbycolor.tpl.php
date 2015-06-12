<?php /* Smarty version Smarty-3.1.12, created on 2015-01-24 12:11:52
         compiled from "D:\wamp\www\red\shoes\modules\block\shopbycolor\shopbycolor.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1754554c31b88221b08-32477045%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9ace833c062cb534aae0ef389bb2874729bda416' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\modules\\block\\shopbycolor\\shopbycolor.tpl',
      1 => 1416900032,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1754554c31b88221b08-32477045',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'colors' => 0,
    'color' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_54c31b8827ee67_71595534',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54c31b8827ee67_71595534')) {function content_54c31b8827ee67_71595534($_smarty_tpl) {?><section class="actif">
  <h3 class="filter-title"><a href="javascript:void(0)"><span>Colour</span></a></h3>
  <ul class="list-shopcolor">
  	<?php  $_smarty_tpl->tpl_vars['color'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['color']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['colors']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['color']->key => $_smarty_tpl->tpl_vars['color']->value){
$_smarty_tpl->tpl_vars['color']->_loop = true;
?>
    <li class="shopcolor-bloc"><a title="<?php echo $_smarty_tpl->tpl_vars['color']->value['name'];?>
" href="<?php echo $_smarty_tpl->tpl_vars['color']->value['link'];?>
"><span style="background:<?php echo $_smarty_tpl->tpl_vars['color']->value['code'];?>
"><?php echo $_smarty_tpl->tpl_vars['color']->value['name'];?>
</span></a></li>
	<?php } ?>
  </ul>
</section>
<?php }} ?>