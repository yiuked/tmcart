<?php /* Smarty version Smarty-3.1.12, created on 2016-01-08 13:47:44
         compiled from "/Users/apple/Documents/httpd/red/shoes/themes/shop/header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1109522565568f4d805cfe41-93114987%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9445701e012a05c69485e1da8732147dae623789' => 
    array (
      0 => '/Users/apple/Documents/httpd/red/shoes/themes/shop/header.tpl',
      1 => 1452229588,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1109522565568f4d805cfe41-93114987',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'meta' => 0,
    'root_dir' => 0,
    'tm_css_dir' => 0,
    'css_dir' => 0,
    'css_file' => 0,
    'css' => 0,
    'tm_js_dir' => 0,
    'js_dir' => 0,
    'allow_cn' => 0,
    'js_file' => 0,
    'js' => 0,
    'link' => 0,
    'view_name' => 0,
    'shop_name' => 0,
    'query' => 0,
    'cart_quantity' => 0,
    'cart_products' => 0,
    'cat_product' => 0,
    'attribute' => 0,
    'cart_total' => 0,
    'SECATION_HEAD' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_568f4d80709744_68436348',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_568f4d80709744_68436348')) {function content_568f4d80709744_68436348($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_truncate')) include '/Users/apple/Documents/httpd/red/shoes/tools/smarty/plugins/modifier.truncate.php';
if (!is_callable('smarty_modifier_escape')) include '/Users/apple/Documents/httpd/red/shoes/tools/smarty/plugins/modifier.escape.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title><?php echo $_smarty_tpl->tpl_vars['meta']->value['title'];?>
</title>
<meta name="description" content="<?php echo $_smarty_tpl->tpl_vars['meta']->value['description'];?>
" />
<meta name="keywords" content="<?php echo $_smarty_tpl->tpl_vars['meta']->value['keywords'];?>
" />
<meta name="robots" content="index,follow" />
<meta content="IE=Edge" http-equiv="X-UA-Compatible">
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
<link rel="alternate" hreflang="en" href="alternateURL">
<link rel="shortcut icon" type="image/x-icon" href="<?php echo $_smarty_tpl->tpl_vars['root_dir']->value;?>
favicon.ico" />
<link rel="shortcut icon" type="image/gif" href="<?php echo $_smarty_tpl->tpl_vars['root_dir']->value;?>
favicon.gif" />
<link href="<?php echo $_smarty_tpl->tpl_vars['tm_css_dir']->value;?>
bootstrap.min.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?php echo $_smarty_tpl->tpl_vars['css_dir']->value;?>
global.css" rel="stylesheet" type="text/css" media="all" />
<?php if ($_smarty_tpl->tpl_vars['css_file']->value){?>
<?php  $_smarty_tpl->tpl_vars['css'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['css']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['css_file']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['css']->key => $_smarty_tpl->tpl_vars['css']->value){
$_smarty_tpl->tpl_vars['css']->_loop = true;
?><link href="<?php echo $_smarty_tpl->tpl_vars['css']->value;?>
" rel="stylesheet" type="text/css" media="all" /><?php } ?>
<?php }?>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['tm_js_dir']->value;?>
jquery/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['tm_js_dir']->value;?>
bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['js_dir']->value;?>
front.js"></script>
<?php if ($_smarty_tpl->tpl_vars['allow_cn']->value==false){?>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['js_dir']->value;?>
wget.js"></script>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['js_file']->value){?>
<?php  $_smarty_tpl->tpl_vars['js'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['js']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['js_file']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['js']->key => $_smarty_tpl->tpl_vars['js']->value){
$_smarty_tpl->tpl_vars['js']->_loop = true;
?>
<script type="text/javascript" src="<?php echo $_smarty_tpl->tpl_vars['js']->value;?>
"></script>
<?php } ?>
<?php }?>
<script>
	var root_dir = "<?php echo $_smarty_tpl->tpl_vars['root_dir']->value;?>
";
	var ajax_dir = "<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('AjaxView');?>
";
</script>
</head>
<body class="browse <?php echo $_smarty_tpl->tpl_vars['view_name']->value;?>
">
	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./block/top_men.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

 	<div id="header">
		<div class="container">
		  <div class="row">
				<?php if ($_smarty_tpl->tpl_vars['view_name']->value=='index'){?>
				<h1 class="col-md-3 logo"><a href="<?php echo $_smarty_tpl->tpl_vars['root_dir']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['shop_name']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['shop_name']->value;?>
</a></h1>
				<?php }else{ ?>
				<div class="col-md-3 logo"><a href="<?php echo $_smarty_tpl->tpl_vars['root_dir']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['shop_name']->value;?>
" ><?php echo $_smarty_tpl->tpl_vars['shop_name']->value;?>
</a></div>
				<?php }?>
				<div id="search" class="col-md-6">
					  <form role="search" method="get" action="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('SearchView');?>
">
						<input type="text" placeholder="雪地靴 羽绒服" name="s" value="<?php if (isset($_smarty_tpl->tpl_vars['query']->value)){?><?php echo $_smarty_tpl->tpl_vars['query']->value;?>
<?php }?>">
						<button type="submit" class="icon-search">搜 索</button>
					  </form>
						<ul class="inline hot-search">
							<li><a href="">保暖内衣</a></li>
							<li class="spacer"></li>
							<li><a href="">圣诞节礼物</a></li>
							<li class="spacer"></li>
							<li><a href="">电脑</a></li>
							<li class="spacer"></li>
							<li><a href="">手机</a></li>
							<li class="spacer"></li>
							<li><a href="">巧克力</a></li>
						</ul>
				 </div>
				<div class="col-md-3">
					<div class="dropdown cart-block">
						<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('CartView');?>
" class="cart-btn">
							<span aria-hidden="true" class="glyphicon glyphicon-shopping-cart"></span> 我的购物车
							<?php if ($_smarty_tpl->tpl_vars['cart_quantity']->value>0){?>
							<span class="badge"> <?php echo $_smarty_tpl->tpl_vars['cart_quantity']->value;?>
 </span>
							<?php }?>
						</a>
						<div class="menu">
							<?php if ($_smarty_tpl->tpl_vars['cart_quantity']->value>0){?>
								<table>
									<?php  $_smarty_tpl->tpl_vars['cat_product'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cat_product']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cart_products']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cat_product']->key => $_smarty_tpl->tpl_vars['cat_product']->value){
$_smarty_tpl->tpl_vars['cat_product']->_loop = true;
?>
										<tr class="item">
											<td class="td-image"><a href="<?php echo $_smarty_tpl->tpl_vars['cat_product']->value['link'];?>
" target="_blank"><img src="<?php echo $_smarty_tpl->tpl_vars['cat_product']->value['image'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['cat_product']->value['name'];?>
" /></a></td>
											<td class="td-name"><a href="<?php echo $_smarty_tpl->tpl_vars['cat_product']->value['link'];?>
" target="_blank"><?php echo smarty_modifier_escape(smarty_modifier_truncate($_smarty_tpl->tpl_vars['cat_product']->value['name'],50,'...'), 'html', 'UTF-8');?>
</a><br/>
												<?php  $_smarty_tpl->tpl_vars['attribute'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['attribute']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['cat_product']->value['attributes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['attribute']->key => $_smarty_tpl->tpl_vars['attribute']->value){
$_smarty_tpl->tpl_vars['attribute']->_loop = true;
?>
													<em><?php echo $_smarty_tpl->tpl_vars['attribute']->value['group_name'];?>
:<?php echo $_smarty_tpl->tpl_vars['attribute']->value['name'];?>
</em>
												<?php } ?>
											</td>
											<td class="td-price">
												<b><?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['cat_product']->value['price']),$_smarty_tpl);?>
</b><br>
												<b>x <?php echo $_smarty_tpl->tpl_vars['cat_product']->value['quantity'];?>
</b><br>
												<a href="javascript:;" class="cart_quantity_delete" data-id="<?php echo $_smarty_tpl->tpl_vars['cat_product']->value['id_cart_product'];?>
" data-id="nofollow">删除</a>
											</td>
										</tr>
									<?php } ?>
								</table>
								<p>共 <span class="cart-total-quantity"><?php echo $_smarty_tpl->tpl_vars['cart_quantity']->value;?>
</span> 件商品 总金额 <span class="cart-total"><?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['cart_total']->value),$_smarty_tpl);?>
</span> <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('CartView');?>
" class="btn btn-pink btn-xs">去购物车</a></p>

							<?php }else{ ?>
								<p>购物车为空</p>
							<?php }?>
						</div>
					</div>
				</div>
		  </div>
		</div>
		<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./block/top_navigation.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

	</div>
	<div id="columns">
	<?php echo $_smarty_tpl->tpl_vars['SECATION_HEAD']->value;?>
<?php }} ?>