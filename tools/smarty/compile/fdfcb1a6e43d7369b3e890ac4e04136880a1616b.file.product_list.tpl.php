<?php /* Smarty version Smarty-3.1.12, created on 2016-02-26 22:03:24
         compiled from "D:\wamp\www\red\shoes\themes\shop\block\product_list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3003456d05b2c666e60-18441436%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fdfcb1a6e43d7369b3e890ac4e04136880a1616b' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\themes\\shop\\block\\product_list.tpl',
      1 => 1452398898,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3003456d05b2c666e60-18441436',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'products' => 0,
    'product' => 0,
    'wish_array' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_56d05b2c7ca638_47783875',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56d05b2c7ca638_47783875')) {function content_56d05b2c7ca638_47783875($_smarty_tpl) {?><div class="product-list">
	<ul>
		<?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['product']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['products']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value){
$_smarty_tpl->tpl_vars['product']->_loop = true;
?>
			<li>
				<a data-id="<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product'];?>
" href="javascript:void(0)" data-toggle="tooltip" data-placement="bottom" title="点击收藏该商品" class="wish <?php if (in_array($_smarty_tpl->tpl_vars['product']->value['id_product'],$_smarty_tpl->tpl_vars['wish_array']->value)){?>on<?php }?>">
					<span class="glyphicon glyphicon-heart" aria-hidden="true"></span>
				</a>
				<?php if ($_smarty_tpl->tpl_vars['product']->value['is_new']){?>
					<span class="label label-success new">新品上架</span>
				<?php }?>
				<a href="<?php echo $_smarty_tpl->tpl_vars['product']->value['link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['product']->value['image_home'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>
" /></a>
				<div class="price align_center">
					<span class="old-price"><?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['product']->value['old_price']),$_smarty_tpl);?>
</span>
					<span class="now-price"><?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['product']->value['price']),$_smarty_tpl);?>
</span>
				</div>
				<h2 class="product-name"><a href="<?php echo $_smarty_tpl->tpl_vars['product']->value['link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>
"><?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>
</a></h2>
			</li>
		<?php } ?>
	</ul>
</div>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./block/pagination.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>