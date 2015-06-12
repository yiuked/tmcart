<?php /* Smarty version Smarty-3.1.12, created on 2015-01-24 11:49:58
         compiled from "D:\wamp\www\red\shoes\themes\shop\block\top_navigation.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7914549ccc0131d161-68950197%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f53de8738a85f109548a18788cd67595de8a6e3a' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\themes\\shop\\block\\top_navigation.tpl',
      1 => 1422071395,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7914549ccc0131d161-68950197',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_549ccc013577f0_36691478',
  'variables' => 
  array (
    'link' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_549ccc013577f0_36691478')) {function content_549ccc013577f0_36691478($_smarty_tpl) {?><nav id="navigation">
  <ul class="nav">
	<li class="nav-tab">
		<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('CategoryView',57);?>
" title="Daffodile">Daffodile</a>
	</li>
	<li class="nav-tab">
		<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('CategoryView',65);?>
" title="Pumps">Pumps</a>
	</li>
	<li class="nav-tab">
		<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('CategoryView',53);?>
" title="Bianca">Bianca</a>
	</li>
	<li class="nav-tab">
		<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('CategoryView',60);?>
" title="Men Sneakers">Men Sneakers</a>
	</li>
	<li class="nav-tab">
		<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('CategoryView',70);?>
" title="Women Sneakers">Women Sneakers</a>
	</li>
	<li class="nav-tab"><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('SaleView');?>
" title="Sale"><font color="#ea3e3b">Sale</font></a></li>
  </ul>
</nav><?php }} ?>