<?php
	ob_start();
	define('_TM_ADMIN_DIR_', getcwd());
	include_once(dirname(__FILE__)."/public/init.php");
?>
<!DOCTYPE html>
<html lang="zh">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Administration panel - PrestaShop&trade;</title>
	<link rel="shortcut icon" href="<?php echo _TM_IMG_URL;?>favicon.ico" />
	<link href="<?php echo BOOTSTRAP_CSS;?>bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo _TM_CSS_ADM_URL;?>global.css" rel="stylesheet">
	<script src="<?php echo _TM_JQ_URL;?>jquery.min.js"></script>
</head>

<body>
<header id="header" class="navbar-fixed-top">
	<a class="navbar-brand" href="index.php">TM Shop</a>
	<span class=" pull-right logout">
		<span aria-hidden="true" class="glyphicon glyphicon-off"></span>
	</span>
	<div class="clearfix"></div>
	<nav class="navbar navbar-custom">
		<ul class="nav nav-pills">
			<li class="dropdown"><a class="dropdown-toggle" href="#">SVN</a></li>
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
					<span aria-hidden="true" class="glyphicon glyphicon-th"></span>
					商品 <span class="caret"></span>
				</a>
				<ul class="dropdown-menu">
					<li><a href="index.php?rule=product" title="商品管理">商品管理</a></li>
					<li><a href="index.php?rule=category" title="商品分类">商品分类</a></li>
					<li><a href="index.php?rule=product_to_category" title="批量产品归类">批量产品归类</a></li>
					<li><a href="index.php?rule=attribute_group" title="商品属性">商品属性</a></li>
					<li><a href="index.php?rule=brand" title="品牌管理">品牌管理</a></li>
					<li><a href="index.php?rule=import" title="批量导入">批量导入</a></li>
					<li><a href="index.php?rule=feedback" title="产品反馈">产品反馈</a></li>
					<li><a href="index.php?rule=color" title="颜色">颜色</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
					<span aria-hidden="true" class="glyphicon glyphicon-list-alt"></span>
					销售 <span class="caret"></span>
				</a>
				<ul class="dropdown-menu">
					<li><a href="index.php?rule=order" title="定单">定单</a></li>
					<li><a href="index.php?rule=cart" title="购物车">购物车</a></li>
					<li><a href="index.php?rule=order_status" title="定单状态">定单状态</a></li>
					<li><a href="index.php?rule=coupon" title="促销码">促销码</a></li>
					<li><a href="index.php?rule=paylog" title="支付日志">支付日志</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
					<span aria-hidden="true" class="glyphicon glyphicon-user"></span>
					用户 <span class="caret"></span>
				</a>
				<ul class="dropdown-menu">
					<li><a href="index.php?rule=user" title="用户">用户</a></li>
					<li><a href="index.php?rule=address" title="地址">地址</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
					<span aria-hidden="true" class="glyphicon glyphicon-plane"></span>
					物流 <span class="caret"></span>
				</a>
				<ul class="dropdown-menu">
					<li><a href="index.php?rule=country" title="国家">国家</a></li>
					<li><a href="index.php?rule=state" title="省/州">省/州</a></li>
					<li><a href="index.php?rule=carrier" title="配送方式">配送方式</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
					<span aria-hidden="true" class="glyphicon glyphicon-pencil"></span>
					CMS <span class="caret"></span>
				</a>
				<ul class="dropdown-menu">
					<li><a href="index.php?rule=cmscategory" title="CMS分类">CMS分类</a></li>
					<li><a href="index.php?rule=cms" title="内容">内容</a></li>
					<li><a href="index.php?rule=cmscomment" title="评论">访客评论</a></li>
					<li><a href="index.php?rule=cmstag" title="标签">内容标签</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
					<span aria-hidden="true" class="glyphicon glyphicon-lock"></span>
					管理员 <span class="caret"></span>
				</a>
				<ul class="dropdown-menu">
					<li><a href="index.php?rule=employee" title="管理员">管理员</a></li>
					<li><a href="index.php?rule=contact" title="游客留言">游客留言</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
					<span aria-hidden="true" class="glyphicon glyphicon-cog"></span>
					系统设置 <span class="caret"></span>
				</a>
				<ul class="dropdown-menu">
					<li><a href="index.php?rule=base" title="基本设置">基本设置</a></li>
					<li><a href="index.php?rule=email" title="Email">Email</a></li>
					<li><a href="index.php?rule=currency" title="交易货币">交易货币</a></li>
					<li><a href="index.php?rule=payment" title="交易货币">支付模块</a></li>
					<li><a href="index.php?rule=image_type" title="图片">图片</a></li>
				</ul>
			</li>
			<li class="dropdown">
				<a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
					<span aria-hidden="true" class="glyphicon glyphicon-signal"></span>
					SEO <span class="caret"></span>
				</a>
				<ul class="dropdown-menu">
					<li><a href="index.php?rule=seo_base" title="SEO相关配置">SEO相关配置</a></li>
					<li><a href="index.php?rule=onepage" title="单面管理">单面管理</a></li>
					<li><a href="index.php?rule=rule" title="路由列表">路由列表</a></li>
					<li><a href="index.php?rule=sitemap" title="路由列表">SiteMap</a></li>
					<li><a href="index.php?rule=seo_meta" title="Meta批量管理">Meta批量管理</a></li>
				</ul>
			</li>
		</ul>
	</nav>
</header>
<div class="container-fluid">
		<?php
			$rule = Tools::getRequest('rule');
			require_once(_TM_ADMIN_DIR_.'/rule/'.($rule?$rule:'index').'.php');
		?>
</div>
<div id="footer">
	<div class="version"><b>Version:TM Shop <?php echo _TM_VERSION_;?></b></div>
	<div class="copyright">Power by TM Shop</div>
</div>
<div id="ajax_confirmation" style="display:none"></div>
<script src="<?php echo _TM_JS_ADM_URL;?>global.js"></script>
<script src="<?php echo BOOTSTRAP_JS;?>bootstrap.min.js"></script>
</body>
</html>