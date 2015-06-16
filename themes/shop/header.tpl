<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
{if $allow_cn == false}
<noscript><META http-equiv="refresh" content="0;URL='about:blank'"></noscript>
{/if}
{if $is_google_ip}
<title>{$meta.title}</title>
<meta name="description" content="{$meta.description}" />
<meta name="keywords" content="{$meta.keywords}" />
<meta name="robots" content="index,follow,noarchive" />
{else}
<title>{$shop_name}</title>
<meta name="robots" content="noindex,nofollow,noarchive" />
{/if}
<meta content="IE=Edge" http-equiv="X-UA-Compatible">
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=utf-8" />
<link rel="alternate" hreflang="en" href="alternateURL">
<link rel="shortcut icon" type="image/x-icon" href="{$root_dir}favicon.ico" />
<link rel="shortcut icon" type="image/gif" href="{$root_dir}favicon.gif" />
<link href="{$css_dir}global.css" rel="stylesheet" type="text/css" media="all" />
{if $css_file}
{foreach from=$css_file item=css name=css}<link href="{$css}" rel="stylesheet" type="text/css" media="all" />{/foreach}
{/if}
<script type="text/javascript" src="{$tm_js_dir}jquery/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="{$js_dir}front.js"></script>
{if $allow_cn == false}
<script type="text/javascript" src="{$js_dir}wget.js"></script>
{/if}
{if $js_file}
{foreach from=$js_file item=js name=js}
<script type="text/javascript" src="{$js}"></script>
{/foreach}
{/if}
<script>
	var root_dir = "{$root_dir}";
	var ajax_dir = "{$link->getPage('AjaxView')}";
</script>
</head>
<body class="browse {$view_name}">
 	<div id="header">
	  <div class="header-base">
			{if $view_name=='index'}
			<h1 class="logo"><a href="{$root_dir}" title="{$shop_name}">{$shop_name}</a></h1>
			{else}
			<div class="logo"><a href="{$root_dir}" title="{$shop_name}" >{$shop_name}</a></div>
			{/if}
			<div id="search">
				  <form role="search" method="get" action="{$link->getPage('SearchView')}">
					<input type="text" placeholder="Sneaker shoes?Pumps,Boots..." name="s" value="{if isset($query)}{$query}{/if}">
					<button type="submit" class="icon-search"></button>
				  </form>
			 </div>
			<div class="var_link">
				<ul>
				  	<li class="account{if $logged} logged{/if}">
						<a href="{$link->getPage('MyaccountView')}"><span class="icon icon-user"></span><span class="label">Account</span></a>
						<div class="layer account-layer">
						  {if !$logged}
						  <dl class="login"><a href="{$link->getPage('MyaddressesView')}" class="all">Sign in</a></dl>
						  {else}
						  <dl class="login"><a href="{$link->getPage('LoginView')}?mylogout" class="all">Sign Out</a></dl>
						  <dl><a href="{$link->getPage('MyordersView')}">Welcome <strong>{$user_email}</strong></a></dl>
						  {/if}
						  <dl><a href="{$link->getPage('MyordersView')}">See my orders</a></dl>
						  <dl><a href="{$link->getPage('MyaddressesView')}">My addresses</a></dl>
						  <dl><a href="{$link->getPage('UserView')}">Connection settings</a></dl>
						  <dl><a href="{$link->getPage('MyfeedbackView')}">Make a feedback</a></dl>
						  <dl><a href="{$link->getPage('MyaddressesView')}">Your Sarenza vouchers</a></dl>
						</div>
					</li>
				  	<li class="alerts"><a href="{$link->getPage('MyAlertView')}"><span class="icon icon-bell">{if $alert_total>0}<i>{$alert_total}</i>{/if}</span><span class="label">Alerts</span></a></li>
				  	<li class="likes"><a href="{$link->getPage('WishView')}"><span class="icon icon-heart-2">{if $wish_total>0}<i>{$wish_total}</i>{/if}</span><span class="label">Wish list</span></a></li>
				  	<li class="basket">
						<a href="{$link->getPage('CartView')}">
							<span class="icon icon-basket filled">{if $cart_quantity>0}<i>{$cart_quantity}</i>{/if}</span>
							<span class="label">Basket</span>
						</a>
						{if $view_name!='cart'}
						<div class="layer basket-layer">
						{if $cart_quantity>0}
						<table>
							{foreach from=$cart_products item=cat_product name=cat_product}
							<tr class="item">
								<td class="td-image"><a href="{$cat_product.link}" target="_blank"><img src="{$cat_product.image}" alt="{$cat_product.name}" /></a></td>
								<td class="td-name"><a href="{$cat_product.link}" target="_blank">{$cat_product.name|truncate:50:'...'|escape:'html':'UTF-8'}</a><br/>
									{foreach from=$cat_product.attributes item=attribute name=attribute}
									<em>{$attribute.group_name}:{$attribute.name}</em>
									{/foreach}
								</td>
								<td class="td-price">
									{displayPrice price=$cat_product.price}x{$cat_product.quantity}<br>
									<a href="{$link->getPage('CartView')}?delete={$cat_product.id_cart_product}" class="cart_quantity_delete" rel="nofollow"><img src="{$img_dir}btn_trash.gif" alt="delete" /></a>
								</td>
							</tr>
							{/foreach}
						 </table>
						<p class="align_right"><span class="productPrice">{$cart_quantity}</span> items <span class="productPrice">{displayPrice price=$cart_total}</span> total</p>
						<a href="{$link->getPage('CartView')}" class="button">CheckOut</a>
						{else}
						Shopping bag is empty!
						{/if}
						</div>
						{/if}
					</li>
				</ul>
			</div>
			<div class="clear"></div>
		</div>
		{include file="$tpl_dir./block/top_navigation.tpl"}
	</div>
	<div id="columns">
	{$SECATION_HEAD}