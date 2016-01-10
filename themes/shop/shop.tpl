<ul>
{foreach from=$products item=product name=product}
	<li>
		<a href="{$product.link}" title="{$product.name}"><img src="{$product.image}" alt="{$product.name}" /></a>
		<a href="{$product.link}" title="{$product.name}">{$product.name}</a>
		<div class="info">
			<span class="price">{displayPrice price=$product.price}</span>
		</div>
	</li>
{/foreach}
</ul>