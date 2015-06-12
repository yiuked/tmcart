<?php /* Smarty version Smarty-3.1.12, created on 2014-12-24 15:09:43
         compiled from "D:\wamp\www\red\shoes\themes\shop\brands.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18400549a66b72d85e7-53452475%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4091b86d166650e27a121a9756ea3d621b972b46' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\themes\\shop\\brands.tpl',
      1 => 1418624568,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18400549a66b72d85e7-53452475',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'brands' => 0,
    'brand' => 0,
    'link' => 0,
    'brand_dir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_549a66b7360d67_60278100',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_549a66b7360d67_60278100')) {function content_549a66b7360d67_60278100($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['brands']->value&&count($_smarty_tpl->tpl_vars['brands']->value)>0){?>
<div id="brands">
	<ul>
		<?php  $_smarty_tpl->tpl_vars['brand'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['brand']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['brands']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['brand']->key => $_smarty_tpl->tpl_vars['brand']->value){
$_smarty_tpl->tpl_vars['brand']->_loop = true;
?>
		<li>
			<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getLink($_smarty_tpl->tpl_vars['brand']->value['rewrite']);?>
" title="<?php echo $_smarty_tpl->tpl_vars['brand']->value['name'];?>
">
				<img border="0" alt="<?php echo $_smarty_tpl->tpl_vars['brand']->value['name'];?>
" src="<?php echo $_smarty_tpl->tpl_vars['brand_dir']->value;?>
<?php echo $_smarty_tpl->tpl_vars['brand']->value['logo'];?>
">
				<div class="productName">
					<h2><?php echo $_smarty_tpl->tpl_vars['brand']->value['name'];?>
</h2>
				</div>
			</a>
		</li>
		<?php } ?>
	</ul>
</div>
<?php }?><?php }} ?>