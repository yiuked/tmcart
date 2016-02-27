<?php /* Smarty version Smarty-3.1.12, created on 2016-02-26 22:03:01
         compiled from "D:\wamp\www\red\shoes\themes\shop\footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2535656d05b15661c25-67167330%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c38511cfac4399a1d09c8b30546a46c3a65477e7' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\themes\\shop\\footer.tpl',
      1 => 1452398898,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2535656d05b15661c25-67167330',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'FOOT_BLOCK' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_56d05b156a42b8_24403748',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56d05b156a42b8_24403748')) {function content_56d05b156a42b8_24403748($_smarty_tpl) {?>			</div>
			<?php if (isset($_smarty_tpl->tpl_vars['FOOT_BLOCK']->value)){?>
			<?php echo $_smarty_tpl->tpl_vars['FOOT_BLOCK']->value;?>

			<?php }?>
			<div id="footer">
				<div class="container">
					<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./block/foot.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

				</div>
			</div>
	</body>
</html><?php }} ?>