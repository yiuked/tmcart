<?php /* Smarty version Smarty-3.1.12, created on 2016-01-11 09:58:35
         compiled from "D:\wamp\www\red\shoes\themes\shop\footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2026054992dd2460b76-78610863%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c38511cfac4399a1d09c8b30546a46c3a65477e7' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\themes\\shop\\footer.tpl',
      1 => 1452476965,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2026054992dd2460b76-78610863',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_54992dd2481503_78429828',
  'variables' => 
  array (
    'FOOT_BLOCK' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54992dd2481503_78429828')) {function content_54992dd2481503_78429828($_smarty_tpl) {?>			</div>
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