<?php /* Smarty version Smarty-3.1.12, created on 2014-12-29 14:27:21
         compiled from "D:\wamp\www\red\shoes\modules\block\viewed\viewed.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2757554992dd2377f67-64002052%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9c6c3044253598d916743f11299960a6fc8b4c03' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\modules\\block\\viewed\\viewed.tpl',
      1 => 1419834435,
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
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54992dd23fa518_48440495')) {function content_54992dd23fa518_48440495($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['vieweds']->value){?>
<div class="iosSlider main-slider">
	<h3 class="pt-standard"><span>Recently viewed</span></h3>
	<div class="slider-style slider-style-viewed">
		<div class="slider">
			<?php  $_smarty_tpl->tpl_vars['viewed'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['viewed']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['vieweds']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['viewed']->key => $_smarty_tpl->tpl_vars['viewed']->value){
$_smarty_tpl->tpl_vars['viewed']->_loop = true;
?>
			<div class="item item1">
				<a href="<?php echo $_smarty_tpl->tpl_vars['viewed']->value['link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['viewed']->value['name'];?>
">
					<div class="img-content"><img src="<?php echo $_smarty_tpl->tpl_vars['viewed']->value['image_home'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['viewed']->value['name'];?>
" /></div>
					<strong class="brand"><?php echo $_smarty_tpl->tpl_vars['viewed']->value['brand'];?>
</strong>
					<span class="model"><?php echo $_smarty_tpl->tpl_vars['viewed']->value['name'];?>
</span>
					<strong class="price"><i><?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['viewed']->value['price']),$_smarty_tpl);?>
</i></strong>
				</a>
			</div>
			<?php } ?>
		</div>
	</div>
	<?php if (count($_smarty_tpl->tpl_vars['vieweds']->value)>4){?>
	<div class="controls-direction viewed-control">
		<span class="prev">Prev</span>
		<span class="next">Next</span>
	</div>
	<?php }?>
</div>
<?php }?>
<script>
$(document).ready(function(){
	$('.slider-style-viewed').iosSlider({
		desktopClickDrag: true,
		snapToChildren: true,
		infiniteSlider: true,
		navNextSelector: '.viewed-control .next',
		navPrevSelector: '.viewed-control .prev'
	});
})
</script><?php }} ?>