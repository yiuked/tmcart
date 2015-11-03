<?php /* Smarty version Smarty-3.1.12, created on 2015-11-03 22:50:01
         compiled from "D:\wamp\www\red\shoes\themes\shop\header.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2377154992dd1dbaf44-85901661%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '953c26c15bd3a6145c0fbe2558028ba04b5049bc' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\themes\\shop\\header.tpl',
      1 => 1446561898,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2377154992dd1dbaf44-85901661',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_54992dd2161aa5_89058516',
  'variables' => 
  array (
    'allow_cn' => 0,
    'is_google_ip' => 0,
    'meta' => 0,
    'shop_name' => 0,
    'root_dir' => 0,
    'css_dir' => 0,
    'css_file' => 0,
    'css' => 0,
    'tm_js_dir' => 0,
    'js_dir' => 0,
    'js_file' => 0,
    'js' => 0,
    'link' => 0,
    'view_name' => 0,
    'query' => 0,
    'logged' => 0,
    'user_email' => 0,
    'alert_total' => 0,
    'wish_total' => 0,
    'cart_quantity' => 0,
    'cart_products' => 0,
    'cat_product' => 0,
    'attribute' => 0,
    'img_dir' => 0,
    'cart_total' => 0,
    'SECATION_HEAD' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54992dd2161aa5_89058516')) {function content_54992dd2161aa5_89058516($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_truncate')) include 'D:\\wamp\\www\\red\\shoes\\tools\\smarty\\plugins\\modifier.truncate.php';
if (!is_callable('smarty_modifier_escape')) include 'D:\\wamp\\www\\red\\shoes\\tools\\smarty\\plugins\\modifier.escape.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<?php if ($_smarty_tpl->tpl_vars['allow_cn']->value==false){?>
<noscript><META http-equiv="refresh" content="0;URL='about:blank'"></noscript>
<?php }?>
<?php if ($_smarty_tpl->tpl_vars['is_google_ip']->value){?>
<title><?php echo $_smarty_tpl->tpl_vars['meta']->value['title'];?>
</title>
<meta name="description" content="<?php echo $_smarty_tpl->tpl_vars['meta']->value['description'];?>
" />
<meta name="keywords" content="<?php echo $_smarty_tpl->tpl_vars['meta']->value['keywords'];?>
" />
<meta name="robots" content="index,follow,noarchive" />
<?php }else{ ?>
<title><?php echo $_smarty_tpl->tpl_vars['shop_name']->value;?>
</title>
<meta name="robots" content="noindex,nofollow,noarchive" />
<?php }?>
<meta content="IE=Edge" http-equiv="X-UA-Compatible">
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
<link rel="alternate" hreflang="en" href="alternateURL">
<link rel="shortcut icon" type="image/x-icon" href="<?php echo $_smarty_tpl->tpl_vars['root_dir']->value;?>
favicon.ico" />
<link rel="shortcut icon" type="image/gif" href="<?php echo $_smarty_tpl->tpl_vars['root_dir']->value;?>
favicon.gif" />
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
jquery/jquery-1.7.2.min.js"></script>
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
 	<div id="header">
	  <div class="header-base">
			<?php if ($_smarty_tpl->tpl_vars['view_name']->value=='index'){?>
			<h1 class="logo"><a href="<?php echo $_smarty_tpl->tpl_vars['root_dir']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['shop_name']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['shop_name']->value;?>
</a></h1>
			<?php }else{ ?>
			<div class="logo"><a href="<?php echo $_smarty_tpl->tpl_vars['root_dir']->value;?>
" title="<?php echo $_smarty_tpl->tpl_vars['shop_name']->value;?>
" ><?php echo $_smarty_tpl->tpl_vars['shop_name']->value;?>
</a></div>
			<?php }?>
			<div id="search">
				  <form role="search" method="get" action="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('SearchView');?>
">
					<input type="text" placeholder="Sneaker shoes?Pumps,Boots..." name="s" value="<?php if (isset($_smarty_tpl->tpl_vars['query']->value)){?><?php echo $_smarty_tpl->tpl_vars['query']->value;?>
<?php }?>">
					<button type="submit" class="icon-search"></button>
				  </form>
			 </div>
			<div class="var_link">
				<ul>
				  	<li class="account<?php if ($_smarty_tpl->tpl_vars['logged']->value){?> logged<?php }?>">
						<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('MyaccountView');?>
"><span class="icon icon-user"></span><span class="label">Account</span></a>
						<div class="layer account-layer">
						  <?php if (!$_smarty_tpl->tpl_vars['logged']->value){?>
						  <dl class="login"><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('MyaddressesView');?>
" class="all">Sign in</a></dl>
						  <?php }else{ ?>
						  <dl class="login"><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('LoginView');?>
?mylogout" class="all">Sign Out</a></dl>
						  <dl><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('MyordersView');?>
">Welcome <strong><?php echo $_smarty_tpl->tpl_vars['user_email']->value;?>
</strong></a></dl>
						  <?php }?>
						  <dl><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('MyordersView');?>
">See my orders</a></dl>
						  <dl><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('MyaddressesView');?>
">My addresses</a></dl>
						  <dl><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('UserView');?>
">Connection settings</a></dl>
						  <dl><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('MyfeedbackView');?>
">Make a feedback</a></dl>
						  <dl><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('MyaddressesView');?>
">Your Sarenza vouchers</a></dl>
						</div>
					</li>
				  	<li class="alerts"><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('MyAlertView');?>
"><span class="icon icon-bell"><?php if ($_smarty_tpl->tpl_vars['alert_total']->value>0){?><i><?php echo $_smarty_tpl->tpl_vars['alert_total']->value;?>
</i><?php }?></span><span class="label">Alerts</span></a></li>
				  	<li class="likes"><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('WishView');?>
"><span class="icon icon-heart-2"><?php if ($_smarty_tpl->tpl_vars['wish_total']->value>0){?><i><?php echo $_smarty_tpl->tpl_vars['wish_total']->value;?>
</i><?php }?></span><span class="label">Wish list</span></a></li>
				  	<li class="basket">
						<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('CartView');?>
">
							<span class="icon icon-basket filled"><?php if ($_smarty_tpl->tpl_vars['cart_quantity']->value>0){?><i><?php echo $_smarty_tpl->tpl_vars['cart_quantity']->value;?>
</i><?php }?></span>
							<span class="label">Basket</span>
						</a>
						<?php if ($_smarty_tpl->tpl_vars['view_name']->value!='cart'){?>
						<div class="layer basket-layer">
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
									<?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['cat_product']->value['price']),$_smarty_tpl);?>
x<?php echo $_smarty_tpl->tpl_vars['cat_product']->value['quantity'];?>
<br>
									<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('CartView');?>
?delete=<?php echo $_smarty_tpl->tpl_vars['cat_product']->value['id_cart_product'];?>
" class="cart_quantity_delete" rel="nofollow"><img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
btn_trash.gif" alt="delete" /></a>
								</td>
							</tr>
							<?php } ?>
						 </table>
						<p class="align_right"><span class="productPrice"><?php echo $_smarty_tpl->tpl_vars['cart_quantity']->value;?>
</span> items <span class="productPrice"><?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['cart_total']->value),$_smarty_tpl);?>
</span> total</p>
						<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('CartView');?>
" class="button">CheckOut</a>
						<?php }else{ ?>
						Shopping bag is empty!
						<?php }?>
						</div>
						<?php }?>
					</li>
				</ul>
			</div>
			<div class="clear"></div>
		</div>
		<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./block/top_navigation.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

	</div>
	<div id="columns">
	<?php echo $_smarty_tpl->tpl_vars['SECATION_HEAD']->value;?>
<?php }} ?>