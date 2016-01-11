<?php /* Smarty version Smarty-3.1.12, created on 2016-01-11 15:57:00
         compiled from "D:\wamp\www\red\shoes\themes\shop\my-alerts.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10657549d234c4a9bb0-66263235%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ad0c56ab670a4fc2cb206d08b07f1dc284e5237c' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\themes\\shop\\my-alerts.tpl',
      1 => 1452499001,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10657549d234c4a9bb0-66263235',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_549d234c52b486_89939323',
  'variables' => 
  array (
    'DISPLAY_LEFT' => 0,
    'alerts' => 0,
    'alert' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_549d234c52b486_89939323')) {function content_549d234c52b486_89939323($_smarty_tpl) {?><div class="container">
	<div class="row">
		<div class="col-md-2">
			<?php echo $_smarty_tpl->tpl_vars['DISPLAY_LEFT']->value;?>

		</div>
		<div class="col-md-10">
			<div class="list-style">
				<ul>
				<?php if ($_smarty_tpl->tpl_vars['alerts']->value){?>
					<?php  $_smarty_tpl->tpl_vars['alert'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['alert']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['alerts']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['alert']->key => $_smarty_tpl->tpl_vars['alert']->value){
$_smarty_tpl->tpl_vars['alert']->_loop = true;
?>
					<li class="alert-item" <?php if (!$_smarty_tpl->tpl_vars['alert']->value['is_read']){?>data-id="<?php echo $_smarty_tpl->tpl_vars['alert']->value['id_alert'];?>
"<?php }?> onclick="location.href='?id_alert=<?php echo $_smarty_tpl->tpl_vars['alert']->value['id_alert'];?>
'">
						<?php if (!$_smarty_tpl->tpl_vars['alert']->value['is_read']){?><strong><?php echo $_smarty_tpl->tpl_vars['alert']->value['content'];?>
</strong><?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['alert']->value['content'];?>
<?php }?><span class="floatr"><?php echo $_smarty_tpl->tpl_vars['alert']->value['add_date'];?>
</span>
					</li>
					<?php } ?>
				<?php }?>
				</ul>
			</div>
		</div>
	</div>
</div><?php }} ?>