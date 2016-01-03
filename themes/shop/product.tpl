<div class="container">
	<div id="main_columns">
		<div id="pb-left-column">
			<div id="image-block">
				<span id="view_full_size">
					<img height="300" width="300" id="bigpic" alt="{$entity->name}" title="{$entity->name}" src="{$link->getImageLink($entity->id_image, 'large')}" style="display: inline;">
				</span>
			</div>
			{if $images}
			<div class="iosSlider small-slider">
				<div class="slider-style slider-style-thumbs">
					<div class="slider">
						{foreach from=$images item=image name=image}
						<div class="item item1">
						<a href="{$link->getImageLink($image.id_image,'large')}" {if $smarty.foreach.image.first}class="shown"{/if} title="{$entity->name}-{$image.id_image}" onclick="return false">
							<img src="{$link->getImageLink($image.id_image,'small')}" alt="{$entity->name}-{$image.id_image}" title="{$entity->name}-{$image.id_image}" />
						</a>
						</div>
						{/foreach}
					</div>
				</div>
				{if count($images)>7}
				<div class="controls-direction thumbs-control">
					<span class="prev">Prev</span>
					<span class="next">Next</span>
				</div>
				{/if}
			</div>
			{/if}
		</div>

		<div id="pb-right-column" class="pt-standard" itemtype="http://schema.org/Product" itemscope="">
			<div class="inner-aside-product">
				<form action="{$link->getPage('CartView')}" method="post" class="add_to_cart_form">
				<h1 class="prodTitle" itemprop="name">{stripslashes($entity->name)}</h1>
				{if $entity->orders>0}
					<div itemtype="http://schema.org/AggregateRating" itemscope="" itemprop="aggregateRating" class="product-star-order">
						 <span class="product-star" id="product-star">
							 <span class="ui-rating star-block" title="Average Star Rating: {$feedback.state.average} out of 5">
								<ul class="rate txt-16">
								   <li><span class="icon-star"><span>1</span></span></li>
								   <li><span class="icon-star"><span>2</span></span></li>
								   <li><span class="icon-star"><span>3</span></span></li>
								   <li><span class="icon-star"><span>4</span></span></li>
								   <li><span class="icon-star"><span>5</span></span></li>
								</ul>
								<ul class="rate txt-16 active" style="width:{$feedback.state.total_pt}%;">
								   <li><span class="icon-star"><span>1</span></span></li>
								   <li><span class="icon-star"><span>2</span></span></li>
								   <li><span class="icon-star"><span>3</span></span></li>
								   <li><span class="icon-star"><span content="{$feedback.state.average}" itemprop="ratingValue">{$feedback.state.average}</span></span></li>
								   <li><span class="icon-star"><span itemprop="reviewCount">{$feedback.state.times}</span></span></li>
								</ul>
							 </span>
							 <b>{$feedback.state.five_pt+$feedback.state.four_pt}%</b> enjoyed! ({$feedback.state.times|intval} votes)
						 </span>
						 <span class="orders-count">
							<b>{$entity->orders}</b> orders
						  </span>
						  <div class="clear"></div>
					</div>
					{/if}
					{if $entity->old_price > 0}
					<div class="row-panel">
						<h3 class="title-panel">Retail Price:</h3>
						<div class="panel">
							<del class="original-price notranslate">
								US <span id="sku-price">{displayPrice price=$entity->old_price}</span>
								/  Pair </del>
							<span class="unit-disc sub-info"></span>
						</div>
					</div>
					{/if}
					<div class="row-panel">
						<h3 class="title-panel">Discount Price:</h3>
						<div class="panel">
							<div class="current-price">
							  <div itemtype="http://schema.org/Offer" itemscope="" itemprop="offers">
								<b> <span content="USD" itemprop="priceCurrency">US </span><span itemprop="price" id="sku-price">{displayPrice price=$entity->price}</span> </b> /  Pair
							  </div>
							</div>
						</div>
					</div>

				  <input type="hidden" name="id_product" value="{$entity->id}" />
				  {foreach from=$groups name=group item=group}
				  <div class="hide">
					<input type="hidden" name="id_attributes[]" class="id_attribute_group" id="id_attribute_group_{$group.id_attribute_group}" value="" />
				  </div>
				  <div class="row-panel no">
					<h3 class="title-panel">{$group.name}:</h3>
					<div class="panel">
						<span class="skin-select skin">
							<span class="select-content" id="group-id-{$group.id_attribute_group}"><span>Select your size</span></span>
							<select name="group" id="group_{$group.id_attribute_group}" class="attribute_group skin">
							  <option value="NULL">Select your size</option>
							  {foreach from=$group.attributes item=attribute name=attribute}
							  <option value="{$attribute.id_attribute}" {if Tools::getRequest('id_attributes') AND in_array($attribute.id_attribute,Tools::getRequest('id_attributes'))}selected="selected"{/if}>
							  {$attribute.name}
							  </option>
							 {/foreach}
							</select>
							<span class="sub-dd">
								<ul class="list-item">
								  {foreach from=$group.attributes item=attribute name=attribute}
								   <li{if Tools::getRequest('id_attributes') AND in_array($attribute.id_attribute,Tools::getRequest('id_attributes'))}class="active"{/if}>
									<a class="shoesize" rel="{$attribute.id_attribute}" href="#"><span> {$attribute.name} </span></a>
								   </li>
								  {/foreach}
								</ul>
							</span>
						</span>
						<p><a href="{$link->getPage('CMSView',144)}" target="_blank" class="all no">See size guide</a></p>
					</div>
				  </div>
				  {/foreach}
				  <div class="row-panel">
					<h3 class="title-panel">Quantity:</h3>
					<div class="panel"><input type="text" size="4" name="quantity" value="1" id="quantity" /></div>
				  </div>
					<a href="#" name="addToCart" id="add_to_cart" class="button full big pink">
						<input type="hidden" name="addToCart" value="addToCart" />
						<span class="icon-basket uno">Add to basket</span>
					</a>
					<div class="mise-en-avant">
					  <p style="text-align:center"><strong style="color:red;">New Year Discount <br>
						5% off orders over 150$ <br>
						10% off orders over 200$</strong><br>
					</div>
					<div class="secondary-actions">
					  <div class="fav-placeholder tool full">
						<a id="add-to-favoris" href="javascript:void(0)" onclick="addWish($(this),{$entity->id})" class="button small full white{if in_array($entity->id,$wish_array)} on{/if}">
							<span class="icon-heart-2"> Add to My Wish list </span></a>
					  </div>
					</div>
				</form>
				<div class="clear"></div>
			</div>
		</div>
		<div class="clear"></div>
		<div class="productTabs">
			<ul id="product_tab">
				<li class="tab-row selected"><a href="javascript:void(0)" class="tab-page" id="link-details">Product Details</a></li>
				<li class="tab-row"><a href="javascript:void(0)" class="tab-page" id="link-feedback">Feedback({$feedback.rows|count})</a></li>
				<li class="tab-row"><a href="javascript:void(0)" class="tab-page" id="link-shipping">Shipping & Payment</a></li>
			</ul>
		</div>
		<div id="tabPane" class="tab-pane">
			<div id="product-tab-content-details" class="product-tab-content" style="display:block">
				<div id="product_description">
					{stripslashes($entity->description)}
					<br/>
				</div>
			</div>
			<div id="product-tab-content-feedback" class="product-tab-content">
					{include file="$tpl_dir./block/feedback.tpl"}
			</div>
			<div id="product-tab-content-shipping" class="product-tab-content">
				<div class="ui-box-body">
				  <dl class="ui-attr-list">
					<dt>Unit Type:</dt>
					<dd>piece</dd>
				  </dl>
				  <dl class="ui-attr-list">
					<dt>Package Weight:</dt>
					<dd rel="1.000" class="pnl-packaging-weight">1.000kg (2.20lb.)</dd>
				  </dl>
				  <dl class="ui-attr-list">
					<dt>Package Size:</dt>
					<dd rel="36|10|26" class="pnl-packaging-size">36cm x 10cm x 26cm (14.17in x 3.94in x 10.24in)</dd>
				  </dl>
				</div>
			</div>
		</div>
		<div class="exp-pdp-section-divider"></div>
		{if $products}
		<section class="iosSlider main-slider">
			<h2 class="pt-standard"><span>What about…</span></h2>
			<div class="slider-style slider-style-aslo">
				<div class="slider">
					{foreach from=$products item=product name=product}
					<div class="item item1">
						<a href="{$product.link}" title="{$product.name}">
							<div class="img-content"><img src="{$product.image_home}" alt="{$product.name}" /></div>
							<strong class="brand">{$product.brand}</strong>
							<span class="model">{$product.name}</span>
							<strong class="price"><i>{displayPrice price=$product.price}</i></strong>
						</a>
					</div>
					{/foreach}
				</div>
			</div>
			{if count($products)>4}
			<div class="controls-direction aslo-control">
				<span class="prev">Prev</span>
				<span class="next">Next</span>
			</div>
			{/if}
		</section>
		<br>
		{/if}
	</div>
</div>