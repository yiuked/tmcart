<div class="container">
	<div class="full-block home-product-block">
		<div class="block-title">
			<div class="title">推荐产品 <small>买新奇，买低价</small></div>
			<a class="more" href="{$link->getPage('SaleView')}" class="all">更多<span aria-hidden="true" class="glyphicon glyphicon-menu-right"></span></a>
			<ul class="inline pull-right">
				<li><a href="#">单鞋</a></li>
				<li class="spacer"></li>
				<li><a href="#">松糕鞋</a></li>
				<li class="spacer"></li>
				<li><a href="#">运动鞋</a></li>
				<li class="spacer"></li>
				<li><a href="#">靴子</a></li>
				<li class="spacer"></li>
				<li><a href="#">雪地靴</a></li>
			</ul>
		</div>

		<div id="product_list">
			<ul>
				{foreach from=$products item=product name=product}
					<li class="col-md-3">
						<a data-id="{$product.id_product}" href="javascript:void(0)" data-toggle="tooltip" data-placement="bottom" title="点击收藏该商品" class="wish {if in_array($product.id_product,$wish_array)}on{/if}">
							<span class="glyphicon glyphicon-heart" aria-hidden="true"></span>
						</a>
						{if $product.is_new}
							<span class="label label-success new">新品上架</span>
						{/if}
						<a href="{$product.link}" title="{$product.name}"><img src="{$product.image_home}" alt="{$product.name}" title="{$product.name}" /></a>
						<div class="price align_center">
							<span class="old_price">{displayPrice price=$product.old_price}</span>
							<span class="now_price">{displayPrice price=$product.price}</span>
						</div>
						<h2 class="product-name"><a href="{$product.link}" title="{$product.name}">{$product.name}</a></h2>
					</li>
				{/foreach}
			</ul>
		</div>
	</div>
</div>