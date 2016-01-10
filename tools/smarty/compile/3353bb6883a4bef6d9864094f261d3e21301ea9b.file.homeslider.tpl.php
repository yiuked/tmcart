<?php /* Smarty version Smarty-3.1.12, created on 2016-01-08 13:47:44
         compiled from "/Users/apple/Documents/httpd/red/shoes/modules/block/homeslider/homeslider.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1666175338568f4d8077dc67-27144886%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3353bb6883a4bef6d9864094f261d3e21301ea9b' => 
    array (
      0 => '/Users/apple/Documents/httpd/red/shoes/modules/block/homeslider/homeslider.tpl',
      1 => 1452229588,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1666175338568f4d8077dc67-27144886',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'module_dir' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_568f4d8078af73_19876034',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_568f4d8078af73_19876034')) {function content_568f4d8078af73_19876034($_smarty_tpl) {?><div class="container">
	<div id="home-page-slider" class="carousel slide" data-ride="carousel">
		<!-- Indicators -->
		<ol class="carousel-indicators">
			<li data-target="#home-page-slider" data-slide-to="0" class="active"></li>
			<li data-target="#home-page-slider" data-slide-to="1"></li>
			<li data-target="#home-page-slider" data-slide-to="2"></li>
		</ol>

		<!-- Wrapper for slides -->
		<div class="carousel-inner" role="listbox">
			<div class="item active">
				<img src="<?php echo $_smarty_tpl->tpl_vars['module_dir']->value;?>
images/home-slider1.jpg" alt="...">
				<div class="carousel-caption">
					...
				</div>
			</div>
			<div class="item">
				<img src="<?php echo $_smarty_tpl->tpl_vars['module_dir']->value;?>
images/home-slider2.jpg" alt="...">
				<div class="carousel-caption">
					...
				</div>
			</div>
			<div class="item">
				<img src="<?php echo $_smarty_tpl->tpl_vars['module_dir']->value;?>
images/home-slider3.jpg" alt="...">
				<div class="carousel-caption">
					...
				</div>
			</div>
		</div>
		<!-- Controls -->
		<a class="left carousel-control" href="#home-page-slider" role="button" data-slide="prev">
			<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
		<a class="right carousel-control" href="#home-page-slider" role="button" data-slide="next">
			<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
	</div>
	<div class="home-page-banner">
		<div>
			<a href="/advantages#free_delivery">
				<span aria-hidden="true" class="glyphicon glyphicon-gift"></span>
          		<span><strong>新年礼物</strong> <span>精致礼盒包装</span></span>
			</a>
		</div>
		<div>
			<a href="/advantages#free_delivery">
				<span aria-hidden="true" class="glyphicon glyphicon-piggy-bank"></span>
				<span><strong>省省省</strong> <span>要网购不败家</span></span>
			</a>
		</div>
		<div>
			<a href="/advantages#free_delivery">
				<span aria-hidden="true" class="glyphicon glyphicon-plane"></span>
				<span><strong>全场包邮</strong> <span>免费运费啦!</span></span>
			</a>
		</div>
	</div>
</div><?php }} ?>