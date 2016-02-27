<div class="container">
	<div class="row">
		<div class="col-md-2">
			{$DISPLAY_LEFT}
		</div>
		<div class="col-md-10">
			<h2>关注商品</h2>
			{if $products && count($products) > 0}
			<div class="product-list">
				<ul>
					{foreach from=$products item=product name=product}
						<li>
							<a data-id="{$product.id_product}" href="javascript:void(0)" data-toggle="tooltip" data-placement="bottom" title="点击收藏该商品" class="wish {if in_array($product.id_product,$wish_array)}on{/if}">
								<span class="glyphicon glyphicon-heart" aria-hidden="true"></span>
							</a>
							{if $product.is_new}
								<span class="label label-success new">新品上架</span>
							{/if}
							<a href="{$product.link}" title="{$product.name}"><img src="{$product.image_home}" alt="{$product.name}" title="{$product.name}" /></a>
							<div class="price align_center">
								<span class="old-price">{displayPrice price=$product.old_price}</span>
								<span class="now-price">{displayPrice price=$product.price}</span>
							</div>
							<h2 class="product-name"><a href="{$product.link}" title="{$product.name}">{$product.name}</a></h2>
						</li>
					{/foreach}
				</ul>
			</div>
			{/if}
		</div>
	</div>
</div>