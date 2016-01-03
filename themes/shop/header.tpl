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
<link href="{$tm_css_dir}bootstrap.min.css" rel="stylesheet" type="text/css" media="all" />
<link href="{$css_dir}global.css" rel="stylesheet" type="text/css" media="all" />
{if $css_file}
{foreach from=$css_file item=css name=css}<link href="{$css}" rel="stylesheet" type="text/css" media="all" />{/foreach}
{/if}
<script type="text/javascript" src="{$tm_js_dir}jquery/jquery.min.js"></script>
<script type="text/javascript" src="{$tm_js_dir}bootstrap.min.js"></script>
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
	{include file="$tpl_dir./block/top_men.tpl"}
 	<div id="header">
		<div class="container">
		  <div class="row">
				{if $view_name=='index'}
				<h1 class="col-md-3 logo"><a href="{$root_dir}" title="{$shop_name}">{$shop_name}</a></h1>
				{else}
				<div class="col-md-3 logo"><a href="{$root_dir}" title="{$shop_name}" >{$shop_name}</a></div>
				{/if}
				<div id="search" class="col-md-6">
					  <form role="search" method="get" action="{$link->getPage('SearchView')}">
						<input type="text" placeholder="雪地靴 羽绒服" name="s" value="{if isset($query)}{$query}{/if}">
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
					<div class="dropdown cart">
						<a href="{$link->getPage('CartView')}" class="cart-btn">
							<span aria-hidden="true" class="glyphicon glyphicon-shopping-cart"></span> 我的购物车
							{if $cart_quantity > 0}
							<span class="badge"> {$cart_quantity} </span>
							{/if}
						</a>
						{if $view_name!='cart'}
							<div class="menu">
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
													<b>{displayPrice price=$cat_product.price}</b><br>
													<b>x {$cat_product.quantity}</b><br>
													<a href="{$link->getPage('CartView')}?delete={$cat_product.id_cart_product}" class="cart_quantity_delete" rel="nofollow">删除</a>
												</td>
											</tr>
										{/foreach}
									</table>
									<p>共 <span class="productPrice">{$cart_quantity}</span> 件商品 总金额 <span class="productPrice">{displayPrice price=$cart_total}</span> <a href="{$link->getPage('CartView')}" class="btn btn-pink btn-xs">去购物车</a></p>

								{else}
									购物车为空
								{/if}
							</div>
						{/if}
					</div>
				</div>
		  </div>
		</div>
		{include file="$tpl_dir./block/top_navigation.tpl"}
	</div>
	<div id="columns">
	{$SECATION_HEAD}