{if $vieweds}
<div class="iosSlider main-slider">
	<h3 class="pt-standard"><span>Recently viewed</span></h3>
	<div class="slider-style slider-style-viewed">
		<div class="slider">
			{foreach from=$vieweds item=viewed name=viewed}
			<div class="item item1">
				<a href="{$viewed.link}" title="{$viewed.name}">
					<div class="img-content"><img src="{$viewed.image_home}" alt="{$viewed.name}" /></div>
					<strong class="brand">{$viewed.brand}</strong>
					<span class="model">{$viewed.name}</span>
					<strong class="price"><i>{displayPrice price=$viewed.price}</i></strong>
				</a>
			</div>
			{/foreach}
		</div>
	</div>
	{if count($vieweds)>4}
	<div class="controls-direction viewed-control">
		<span class="prev">Prev</span>
		<span class="next">Next</span>
	</div>
	{/if}
</div>
{/if}
<script>
$(document).ready(function(){
	$('.slider-style-viewed').iosSlider({
		desktopClickDrag: true,
		snapToChildren: true,
		infiniteSlider: true,
		navNextSelector: '.viewed-control .next',
		navPrevSelector: '.viewed-control .prev'
	});
})
</script>