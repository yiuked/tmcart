{if $brands&&count($brands)>0}
<div id="brands">
	<ul>
		{foreach from=$brands item=brand name=brandForeach}
		<li>
			<a href="{$link->getLink($brand.rewrite)}" title="{$brand.name}">
				<img border="0" alt="{$brand.name}" src="{$brand_dir}{$brand.logo}">
				<div class="productName">
					<h2>{$brand.name}</h2>
				</div>
			</a>
		</li>
		{/foreach}
	</ul>
</div>
{/if}