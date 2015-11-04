<?php /* Smarty version Smarty-3.1.12, created on 2015-11-03 22:50:02
         compiled from "D:\wamp\www\red\shoes\modules\block\homeslider\homeslider.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2956054992dd21c7d55-59677037%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5370c62552c93a5767c93e1bbba3c61f9d0cc148' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\modules\\block\\homeslider\\homeslider.tpl',
      1 => 1446561897,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2956054992dd21c7d55-59677037',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_54992dd221c4a1_34293503',
  'variables' => 
  array (
    'img_dir' => 0,
    'shop_name' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54992dd221c4a1_34293503')) {function content_54992dd221c4a1_34293503($_smarty_tpl) {?><div class="home-page-slider">
	<div class="iosSlider full-slider home-slider">
		<div class="slider-style slider-style-home">
			<div class="slider">
				<div class="item item1">
					<div class="bg-img"><img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
banner/home-slider1.jpg"></div>
					<a style="background: url(<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
pattern_vp.png)" href="#" class="vp-2-brands">
					<div class="inner">
					  <div class="wrapper"> <strong style="color:#ea3e3b">- New Year Discount -</strong>
						<h2 class="small-title">Up to 70% off</h2>
						<p class="info"></p>
						<div class="button east">Shop now</div>
					  </div>
					</div>
					</a>
				</div>
				<div class="item item1">
					<div class="bg-img"><img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
banner/home-slider2.jpg"></div>
					<a style="background: url(<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
fete_pattern.jpg)" href="#">
					<div class="inner">
					  <div class="wrapper"> <strong class="status new">Inspiration</strong>
						<h2 class="small-title">Men's sneakers<br></h2>
						<div class="button east">Shop now</div>
					  </div>
					</div>
					</a>
				</div>
				<div class="item item1">
					<div class="bg-img"><img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
banner/home-slider3.jpg"></div>
					<a style="background: url(<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
pattern-stripes-pink.png)" href="#">
					<div class="inner">
					  <div class="wrapper">
						<strong class="status new">Fashion</strong>
						<h2 class="small-title">Women's Pumps</h2>
						<div class="button east">Shop now</div>
					  </div>
					</div>
					</a>
				</div>
			</div>
		</div>
		<div class="paging">
			<div class="box"><span>1</span></div>
			<div class="box"><span>2</span></div>
			<div class="box"><span>3</span></div>
		</div>
	</div>
</div>
<script>
$(document).ready(function(){
	$('.slider-style-home').iosSlider({
		desktopClickDrag: true,
		snapToChildren: true,
		infiniteSlider: true,
		navSlideSelector: $('.home-slider .paging .box'),
		onSliderLoaded: callbackSliderLoadedChanged,
		onSlideChange: callbackSliderChanged,
	});
})
</script>
<section class="about-us">
<div class="pt-standard">
  <div class="inner" align="center">
	<h2><span><?php echo $_smarty_tpl->tpl_vars['shop_name']->value;?>
</span> Christian louboutin shoes shop online!</h2>
	<div class="mask-text">
	  <p class="txt-14"> One of those iconic red soles and peek you trot style, you know.Slide a pair of high heels or sling standing in a red handbag from Christian louboutin, perfect finish any ensemble.Both classic and avant-garde (think edge, crystal and peak), it is still necessary the epitome of style. </p>
  </div>
</div>
</section><?php }} ?>