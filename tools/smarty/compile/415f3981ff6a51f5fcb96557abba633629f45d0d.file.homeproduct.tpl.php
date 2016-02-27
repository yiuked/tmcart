<?php /* Smarty version Smarty-3.1.12, created on 2016-02-26 22:03:01
         compiled from "D:\wamp\www\red\shoes\modules\block\homeproduct\homeproduct.tpl" */ ?>
<?php /*%%SmartyHeaderCode:194556d05b152a0c47-15524125%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '415f3981ff6a51f5fcb96557abba633629f45d0d' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\modules\\block\\homeproduct\\homeproduct.tpl',
      1 => 1452398898,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '194556d05b152a0c47-15524125',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'link' => 0,
    'products' => 0,
    'product' => 0,
    'wish_array' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_56d05b153f4a13_40493228',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56d05b153f4a13_40493228')) {function content_56d05b153f4a13_40493228($_smarty_tpl) {?><div class="container">
	<div class="full-block home-product-block">
		<div class="block-title">
			<div class="title">推荐产品 <small>买新奇，买低价</small></div>
			<a class="more" href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('SaleView');?>
" class="all">更多<span aria-hidden="true" class="glyphicon glyphicon-menu-right"></span></a>
			<ul class="inline pull-right">
				<li><a href="#">单鞋</a></li>
				<li class="spacer"></li>
				<li><a href="#">松糕鞋</a></li>
				<li class="spacer"></li>
				<li><a href="#">运动鞋</a></li>
				<li class="spacer"></li>
				<li><a href="#">靴子</a></li>
				<li class="spacer"></li>
				<li><a href="#">雪地靴</a></li>
			</ul>
		</div>

		<div class="content">
			<ul class="product-list">
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
	</div>
</div><?php }} ?>