<header>
  <h2>Wish list</h2>
  <p>
	<strong>You can delete an item by clicking the pink heart on the thumbnail</strong>
  </p>
</header>
{if $products&&count($products)>0}
<div id="product_list">
	<ul>
		{foreach from=$products item=product name=product}
		<li>
			<a data-id="{$product.id_product}" href="javascript:void(0)" class="fav icon-link tool {if in_array($product.id_product,$wish_array)}on{/if}"><i class="icon-heart-2 txt-24">
                    </i><span class="tip"><span>Add to my wish list</span></span></a>
			{if $product.is_new}
			<div class="productBugNew"><img border="0" alt="" src="{$img_dir}bug_new.gif"></div>
			{/if}
			<a href="{$product.link}" title="{$product.name}"><img src="{$product.image_home}" alt="{$product.name}" title="{$product.name}" /></a>
			<div class="productName">
				<h2><a href="{$product.link}" title="{$product.name}">{$product.name}</a></h2>
			</div>
			<div class="price align_center"><strong>{displayPrice price=$product.price}</strong></div>
			{if $product.price_save_off>0}
			<div class="discount">
				<span class="rate">{$product.price_save_off}</span>
			</div>
			{/if}
		</li>
		{/foreach}
	</ul>
</div>
{/if}