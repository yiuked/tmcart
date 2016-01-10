<div class="navigation">
	<div class="container">
		<div class="nav">
			<ul class="inline">
				{if $view_name == 'index'}
				<li class="all">
					<a href="{$link->getPage('CategoryView',57)}" title="所有商品分类">所有商品分类</a>
					<div class="categories">

					</div>
				</li>
				{/if}
				<li class="nav-item"><a href="{$link->getPage('CategoryView',57)}" title="首页">首页</a></li>
				<li class="nav-item"><a href="{$link->getPage('CategoryView',57)}" title="活动预告">活动预告</a></li>
				<li class="nav-item"><a href="{$link->getPage('CategoryView',53)}" title="限时活动">限时活动</a></li>
				<li class="nav-item"><a href="{$link->getPage('CategoryView',60)}" title="特价商品">特价商品</a></li>
				<li class="nav-item"><a href="{$link->getPage('CategoryView',70)}" title="最新上架s">最新上架</a></li>
				<li class="nav-item"><a href="{$link->getPage('SaleView')}" title="热卖商品">热卖商品</a></li>
				<li class="nav-item"><a href="{$link->getPage('SaleView')}" title="新闻动态">新闻动态</a></li>
			</ul>
			<s class="nav-indicator" style=""></s>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$(".nav-indicator").css({
			"left":$(".nav-item a").eq(0).position().left + "px",
			"width":$(".nav-item a").eq(0).width() + 12 + "px"
		})
		$(".nav-item a").each(function(){
			var that = $(this);
			var left = $(this).position().left;
			var width = $(this).width();
			that.hoverDelay({
				hoverEvent: function(){
					$(".nav-indicator").animate({
						left: left +'px',
						width: width + 12 +'px'
					});
				}
			})
		})
	});
</script>