<div class="product_list">
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
					<span class="now_price">{displayPrice price=$product.price}</span>
					<span class="old_price">{displayPrice price=$product.old_price}</span>
				</div>
				<h2 class="product-name"><a href="{$product.link}" title="{$product.name}">{$product.name}</a></h2>
			</li>
		{/foreach}
	</ul>
</div>
{include file="$tpl_dir./block/pagination.tpl"}