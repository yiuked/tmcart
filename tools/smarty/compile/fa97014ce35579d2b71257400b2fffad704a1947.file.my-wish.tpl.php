<?php /* Smarty version Smarty-3.1.12, created on 2016-01-11 16:02:25
         compiled from "D:\wamp\www\red\shoes\themes\shop\my-wish.tpl" */ ?>
<?php /*%%SmartyHeaderCode:65956934ec1405e31-49438995%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fa97014ce35579d2b71257400b2fffad704a1947' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\themes\\shop\\my-wish.tpl',
      1 => 1452499333,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '65956934ec1405e31-49438995',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_56934ec1561909_98086209',
  'variables' => 
  array (
    'DISPLAY_LEFT' => 0,
    'products' => 0,
    'product' => 0,
    'wish_array' => 0,
    'img_dir' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56934ec1561909_98086209')) {function content_56934ec1561909_98086209($_smarty_tpl) {?><div class="container">
	<div class="row">
		<div class="col-md-2">
			<?php echo $_smarty_tpl->tpl_vars['DISPLAY_LEFT']->value;?>

		</div>
		<div class="col-md-10">
			<h2>关注商品</h2>
			<?php if ($_smarty_tpl->tpl_vars['products']->value&&count($_smarty_tpl->tpl_vars['products']->value)>0){?>
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
						<div class="price align_center"><strong><?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['product']->value['price']),$_smarty_tpl);?>
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
			<?php }?>
		</div>
	</div>
</div><?php }} ?>