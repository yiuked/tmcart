<?php /* Smarty version Smarty-3.1.12, created on 2015-11-03 22:50:02
         compiled from "D:\wamp\www\red\shoes\modules\block\homeproduct\homeproduct.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2721754992dd223b893-95276049%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '415f3981ff6a51f5fcb96557abba633629f45d0d' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\modules\\block\\homeproduct\\homeproduct.tpl',
      1 => 1446561897,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2721754992dd223b893-95276049',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_54992dd22d0994_23450145',
  'variables' => 
  array (
    'link' => 0,
    'products' => 0,
    'product' => 0,
    'wish_array' => 0,
    'img_dir' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54992dd22d0994_23450145')) {function content_54992dd22d0994_23450145($_smarty_tpl) {?><section class="align_center">
  <h2 class="pt-standard"><span>Most popular</span></h2>
  <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('SaleView');?>
" class="all">All bestsellers</a>
	<div id="product_list">
		<ul>
			<?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['product']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['products']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value){
$_smarty_tpl->tpl_vars['product']->_loop = true;
?>
			<li>
				<a data-id="<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product'];?>
" href="javascript:void(0)" class="fav icon-link tool <?php if (in_array($_smarty_tpl->tpl_vars['product']->value['id_product'],$_smarty_tpl->tpl_vars['wish_array']->value)){?>on<?php }?>"><i class="icon-heart-2 txt-24">
						</i><span class="tip"><span>Add to my wish list</span></span></a>
				<?php if ($_smarty_tpl->tpl_vars['product']->value['is_new']){?>
				<div class="productBugNew"><img border="0" alt="" src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
bug_new.gif"></div>
				<?php }?>
				<a href="<?php echo $_smarty_tpl->tpl_vars['product']->value['link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['product']->value['image_home'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>
" /></a>
				<div class="productName">
					<h2><a href="<?php echo $_smarty_tpl->tpl_vars['product']->value['link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>
"><?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>
</a></h2>
				</div>
				<div class="price align_center"><span class="list_retail_price"><?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['product']->value['special_price']),$_smarty_tpl);?>
</span><strong><?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['product']->value['price']),$_smarty_tpl);?>
</strong></div>
				<?php if ($_smarty_tpl->tpl_vars['product']->value['price_save_off']>0){?>
				<div class="discount">
					<span class="rate"><?php echo $_smarty_tpl->tpl_vars['product']->value['price_save_off'];?>
</span>
				</div>
				<?php }?>
			</li>
			<?php } ?>
		</ul>
	</div>
</section><?php }} ?>