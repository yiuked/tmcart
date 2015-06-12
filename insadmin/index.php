<?php
	ob_start();
	define('_TM_ADMIN_DIR_', getcwd());
	include_once(dirname(__FILE__)."/public/init.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PrestaShop&trade; Administrator</title>
<link type="text/css" rel="stylesheet" href="../css/admin/global.css" />
<script type="text/javascript" src="../js/jquery/jquery-1.7.2.min.js"></script>
<script type="text/javascript" src="../js/admin/global.js"></script>
</head>

<body>
<div class="container">
	<div id="header">
		<h1>TM Shop</h1>
		<span id="employee_links">
			<span class="separator"></span><a id="header_logout" href="login.php?logout"><span>logout</span></a>
		</span>
		<div class="clear"></div>
		<div id="contrl_menu">
			<ul id="nav">
				<li>
					<span class="title">商品</span>
					<ul class="subs">
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
				<li>
					<span class="title">销售</span>
					<ul class="subs">
						<li><a href="index.php?rule=order" title="定单">定单</a></li>
						<li><a href="index.php?rule=cart" title="购物车">购物车</a></li>
						<li><a href="index.php?rule=order_status" title="定单状态">定单状态</a></li>
						<li><a href="index.php?rule=coupon" title="促销码">促销码</a></li>
						<li><a href="index.php?rule=paylog" title="支付日志">支付日志</a></li>
					</ul>
				</li>
				<li>
					<span class="title">用户</span>
					<ul class="subs">
						<li><a href="index.php?rule=user" title="用户">用户</a></li>
						<li><a href="index.php?rule=address" title="地址">地址</a></li>
					</ul>
				</li>
				<li>
					<span class="title">物流</span>
					<ul class="subs">
						<li><a href="index.php?rule=country" title="国家">国家</a></li>
						<li><a href="index.php?rule=state" title="省/州">省/州</a></li>
						<li><a href="index.php?rule=carrier" title="配送方式">配送方式</a></li>
					</ul>
				</li>
				<li>
					<span class="title">CMS</span>
					<ul class="subs">
						<li><a href="index.php?rule=cmscategory" title="CMS分类">CMS分类</a></li>
						<li><a href="index.php?rule=cms" title="内容">内容</a></li>
						<li><a href="index.php?rule=cmscomment" title="评论">访客评论</a></li>
						<li><a href="index.php?rule=cmstag" title="标签">内容标签</a></li>
					</ul>
				</li>
				<li>
					<span class="title">管理员</span>
					<ul class="subs">
						<li><a href="index.php?rule=employee" title="管理员">管理员</a></li>
						<li><a href="index.php?rule=contact" title="游客留言">游客留言</a></li>
					</ul>
				</li>
				<li>
					<span class="title">系统设置</span>
					<ul class="subs">
						<li><a href="index.php?rule=base" title="基本设置">基本设置</a></li>
						<li><a href="index.php?rule=email" title="Email">Email</a></li>
						<li><a href="index.php?rule=currency" title="交易货币">交易货币</a></li>
						<li><a href="index.php?rule=payment" title="交易货币">支付模块</a></li>
						<li><a href="index.php?rule=image_type" title="图片">图片</a></li>
					</ul>
				</li>
				<li>
					<span class="title">SEO</span>
					<ul class="subs">
						<li><a href="index.php?rule=seo_base" title="SEO相关配置">SEO相关配置</a></li>
						<li><a href="index.php?rule=onepage" title="单面管理">单面管理</a></li>
						<li><a href="index.php?rule=rule" title="路由列表">路由列表</a></li>
						<li><a href="index.php?rule=sitemap" title="路由列表">SiteMap</a></li>
						<li><a href="index.php?rule=seo_meta" title="Meta批量管理">Meta批量管理</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
	<div class="pagebody">
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
</div>
</body>
</html>