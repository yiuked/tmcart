{if $vieweds}
<div class="container">
	<div class="full-block full-slider">
		<h3 class="block-title">浏览过的产商品</h3>
		<div class="content">
			<div id="viewed-product" class="carousel slide" data-ride="carousel">
				<!-- Indicators -->
				<ol class="carousel-indicators">
					<li data-target="#viewed-product" data-slide-to="0"></li>
				{foreach from=$vieweds item=viewed name=viewed}
					{if $smarty.foreach.viewed.iteration % 5 == 0 && $smarty.foreach.viewed.last == false}
						<li data-target="#viewed-product" data-slide-to="{$smarty.foreach.viewed.iteration / 5}" class="active"></li>
					{/if}
				{/foreach}
				</ol>
				<!-- Wrapper for slides -->
				<div class="carousel-inner" role="listbox">
					<div class="item active">
					<ul class="product-list">
					{foreach from=$vieweds item=viewed name=viewed}
						<li>
							<a data-id="{$viewed.id_product}" href="javascript:void(0)" data-toggle="tooltip" data-placement="{if $smarty.foreach.viewed.iteration % 5 == 1}right{else}bottom{/if}" title="点击收藏该商品" class="wish {if in_array($viewed.id_product,$wish_array)}on{/if}">
								<span class="glyphicon glyphicon-heart" aria-hidden="true"></span>
							</a>
							{if $viewed.is_new}
								<span class="label label-success new">新品上架</span>
							{/if}
							<a href="{$viewed.link}" title="{$viewed.name}"><img src="{$viewed.image_home}" alt="{$viewed.name}" title="{$viewed.name}" /></a>
							<div class="price align_center">
								<span class="now-price">{displayPrice price=$viewed.price}</span>
								<span class="old-price">{displayPrice price=$viewed.old_price}</span>
							</div>
							<h2 class="product-name"><a href="{$viewed.link}" title="{$viewed.name}">{$viewed.name}</a></h2>
						</li>
						{if $smarty.foreach.viewed.iteration % 5 == 0 && $smarty.foreach.viewed.last == false}
						</ul></div>
						<div class="item">
							<ul class="product-list">
						{/if}
					{/foreach}
					</ul>
					</div>
				</div>
				<!-- Controls -->
				<a class="left carousel-control" href="#viewed-product" role="button" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="right carousel-control" href="#viewed-product" role="button" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
		</div>
	</div>
</div>
{/if}