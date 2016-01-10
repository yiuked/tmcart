<?php /* Smarty version Smarty-3.1.12, created on 2016-01-08 13:47:44
         compiled from "/Users/apple/Documents/httpd/red/shoes/themes/shop/footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1107709634568f4d809214e3-89646800%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '70c6bae73fbdce5c34489ee98c5ab6e152cb1b22' => 
    array (
      0 => '/Users/apple/Documents/httpd/red/shoes/themes/shop/footer.tpl',
      1 => 1452229588,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1107709634568f4d809214e3-89646800',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'FOOT_BLOCK' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_568f4d8092c3b7_51586656',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_568f4d8092c3b7_51586656')) {function content_568f4d8092c3b7_51586656($_smarty_tpl) {?>			</div>
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