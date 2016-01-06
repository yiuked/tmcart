<?php /* Smarty version Smarty-3.1.12, created on 2016-01-05 14:50:59
         compiled from "D:\wamp\www\red\shoes\modules\block\viewed\viewed.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2757554992dd2377f67-64002052%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9c6c3044253598d916743f11299960a6fc8b4c03' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\modules\\block\\viewed\\viewed.tpl',
      1 => 1451976642,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2757554992dd2377f67-64002052',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_54992dd23fa518_48440495',
  'variables' => 
  array (
    'vieweds' => 0,
    'viewed' => 0,
    'wish_array' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54992dd23fa518_48440495')) {function content_54992dd23fa518_48440495($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['vieweds']->value){?>
<div class="container">
	<div class="full-block full-slider">
		<h3 class="block-title">浏览过的产商品</h3>
		<div class="content">
			<div id="viewed-product" class="carousel slide" data-ride="carousel">
				<!-- Indicators -->
				<ol class="carousel-indicators">
					<li data-target="#viewed-product" data-slide-to="0"></li>
				<?php  $_smarty_tpl->tpl_vars['viewed'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['viewed']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['vieweds']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['viewed']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['viewed']->iteration=0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['viewed']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['viewed']->key => $_smarty_tpl->tpl_vars['viewed']->value){
$_smarty_tpl->tpl_vars['viewed']->_loop = true;
 $_smarty_tpl->tpl_vars['viewed']->iteration++;
 $_smarty_tpl->tpl_vars['viewed']->last = $_smarty_tpl->tpl_vars['viewed']->iteration === $_smarty_tpl->tpl_vars['viewed']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['viewed']['iteration']++;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['viewed']['last'] = $_smarty_tpl->tpl_vars['viewed']->last;
?>
					<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['viewed']['iteration']%5==0&&$_smarty_tpl->getVariable('smarty')->value['foreach']['viewed']['last']==false){?>
						<li data-target="#viewed-product" data-slide-to="<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['viewed']['iteration']/5;?>
" class="active"></li>
					<?php }?>
				<?php } ?>
				</ol>
				<!-- Wrapper for slides -->
				<div class="carousel-inner" role="listbox">
					<div class="item active">
					<ul class="product-list">
					<?php  $_smarty_tpl->tpl_vars['viewed'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['viewed']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['vieweds']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['viewed']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['viewed']->iteration=0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['viewed']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['viewed']->key => $_smarty_tpl->tpl_vars['viewed']->value){
$_smarty_tpl->tpl_vars['viewed']->_loop = true;
 $_smarty_tpl->tpl_vars['viewed']->iteration++;
 $_smarty_tpl->tpl_vars['viewed']->last = $_smarty_tpl->tpl_vars['viewed']->iteration === $_smarty_tpl->tpl_vars['viewed']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['viewed']['iteration']++;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['viewed']['last'] = $_smarty_tpl->tpl_vars['viewed']->last;
?>
						<li>
							<a data-id="<?php echo $_smarty_tpl->tpl_vars['viewed']->value['id_product'];?>
" href="javascript:void(0)" data-toggle="tooltip" data-placement="bottom" title="点击收藏该商品" class="wish <?php if (in_array($_smarty_tpl->tpl_vars['viewed']->value['id_product'],$_smarty_tpl->tpl_vars['wish_array']->value)){?>on<?php }?>">
								<span class="glyphicon glyphicon-heart" aria-hidden="true"></span>
							</a>
							<?php if ($_smarty_tpl->tpl_vars['viewed']->value['is_new']){?>
								<span class="label label-success new">新品上架</span>
							<?php }?>
							<a href="<?php echo $_smarty_tpl->tpl_vars['viewed']->value['link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['viewed']->value['name'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['viewed']->value['image_home'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['viewed']->value['name'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['viewed']->value['name'];?>
" /></a>
							<div class="price align_center">
								<span class="now-price"><?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['viewed']->value['price']),$_smarty_tpl);?>
</span>
								<span class="old-price"><?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['viewed']->value['old_price']),$_smarty_tpl);?>
</span>
							</div>
							<h2 class="product-name"><a href="<?php echo $_smarty_tpl->tpl_vars['viewed']->value['link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['viewed']->value['name'];?>
"><?php echo $_smarty_tpl->tpl_vars['viewed']->value['name'];?>
</a></h2>
						</li>
						<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['viewed']['iteration']%5==0&&$_smarty_tpl->getVariable('smarty')->value['foreach']['viewed']['last']==false){?>
						</ul></div>
						<div class="item">
							<ul class="product-list">
						<?php }?>
					<?php } ?>
					</ul>
					</div>
				</div>
				<!-- Controls -->
				<a class="left carousel-control" href="#viewed-product" role="button" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="right carousel-control" href="#viewed-product" role="button" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
		</div>
	</div>
</div>
<?php }?><?php }} ?>