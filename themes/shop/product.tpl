<div class="container">
	<div id="main_columns">
		<div id="pb-left-column">
			<div id="image-block">
				<span id="view_full_size">
					<img height="300" width="300" id="bigpic" alt="{$entity->name}" title="{$entity->name}" src="{$link->getImageLink($entity->id_image, 'large')}" data-toggle="modal" data-target=".big-img-modal-lg">
				</span>
			</div>
			<div class="modal fade big-img-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title">{$entity->name}</h4>
						</div>
						<div id="big-img-slider" class="carousel slide" data-ride="carousel" data-interval="false">
							<div class="carousel-inner" role="listbox">
									{foreach from=$images item=image name=image}
									<div class="item {if $smarty.foreach.image.iteration == 1}active{/if}">
										<img src="{$link->getImageLink($image.id_image)}" alt="{$entity->name}-{$image.id_image}" title="{$entity->name}-{$image.id_image}" />
									</div>
									{/foreach}
							</div>
							<a class="left carousel-control" href="#big-img-slider" role="button" data-slide="prev">
								<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
								<span class="sr-only">上一页</span>
							</a>
							<a class="right carousel-control" href="#big-img-slider" role="button" data-slide="next">
								<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
								<span class="sr-only">下一页</span>
							</a>
						</div>
					</div>
				</div>
			</div>
			{if $images}
			<div id="thumbs-list" class="carousel slide" data-ride="carousel" data-interval="false">
				<div class="carousel-inner" role="listbox">
					<div class="item active">
						{foreach from=$images item=image name=image}
							<a href="{$link->getImageLink($image.id_image,'large')}" {if $smarty.foreach.image.first}class="shown"{/if} title="{$entity->name}-{$image.id_image}" onclick="return false">
								<img src="{$link->getImageLink($image.id_image,'small')}" alt="{$entity->name}-{$image.id_image}" title="{$entity->name}-{$image.id_image}" />
							</a>
						{if $smarty.foreach.image.iteration % 6 == 0 && $smarty.foreach.image.last == false}
						</div>
						<div class="item">
						{/if}
						{/foreach}
					</div>
				</div>
				{if count($images) > 6}
				<a class="left carousel-control" href="#thumbs-list" role="button" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
					<span class="sr-only">上一页</span>
				</a>
				<a class="right carousel-control" href="#thumbs-list" role="button" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
					<span class="sr-only">下一页</span>
				</a>
				{/if}
			</div>
			{/if}
		</div>

		<div id="pb-right-column" >
				<form action="{$link->getPage('CartView')}" method="post" class="form-horizontal add_to_cart_form">
					<input type="hidden" name="id_product" value="{$entity->id}" />
					<h1>{stripslashes($entity->name)}</h1>
					{if $entity->orders > 0}
					<div class="product-star-order">
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
					<div class="form-group">
						<label for="old-price" class="col-sm-2 control-label">价格</label>
						<div class="col-sm-10">
							<span class="old-price">{displayPrice price=$entity->old_price}</span>
						</div>
					</div>
					{/if}
					<div class="form-group">
						<label for="now-price" class="col-sm-2 control-label">销售价</label>
						<div class="col-sm-10">
							<span class="now-price">{displayPrice price=$entity->price}</span>
						</div>
					</div>
					{foreach from=$groups name=group item=group}
					<div class="form-group">
						<label for="id_attribute_group_{$group.id_attribute_group}" class="col-sm-2 control-label">{$group.name}</label>
						<div class="col-sm-10 attrbiute-radio">
							<input type="hidden" name="id_attributes[]" class="id_attribute_group" value="{if Tools::P('id_attributes') AND in_array($attribute.id_attribute, Tools::P('id_attributes'))}{Tools::P('id_attributes')}{/if}" />
							{foreach from=$group.attributes item=attribute name=attribute}
								<div class="item{if Tools::getRequest('id_attributes') AND in_array($attribute.id_attribute,Tools::getRequest('id_attributes'))} selected{/if}" data-id_attribute="{$attribute.id_attribute}" ><b></b><a href="javascript:void(0);">{$attribute.name}</a></div>
							{/foreach}
						</div>
					</div>
					{/foreach}

					<div class="form-group">
						<label for="quantity" class="col-sm-2 control-label">数量</label>
						<div class="col-sm-2">
							<input type="text" size="4" name="quantity" value="1" id="quantity" class="form-control" />
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-offset-2">
							<input type="hidden" name="addToCart" value="true">
							<button type="submit" class="btn btn-pink" id="add_to_cart"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> 加入购物车</button>
							<a href="javascript:;" class="btn btn-warning wish" id="add-to-wish" data-id="{$entity->id}"><span aria-hidden="true" class="glyphicon glyphicon-heart"></span> 收藏</a>
						</div>
					</div>
				</form>
		</div>
		<div class="clearfix"></div>
		<!-- product tabbar -->
		<div class="panel panel-default product-tag">
			<div class="panel-body">
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#tab-description" aria-controls="home" role="tab" data-toggle="tab">描述</a></li>
					<li role="presentation"><a href="#tab-feedback" aria-controls="profile" role="tab" data-toggle="tab">评论</a></li>
					<li role="presentation"><a href="#tab-other" aria-controls="messages" role="tab" data-toggle="tab">其它</a></li>
				</ul>
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="tab-description">{stripslashes($entity->description)}</div>
					<div role="tabpanel" class="tab-pane" id="tab-feedback">{include file="$tpl_dir./block/feedback.tpl"}</div>
					<div role="tabpanel" class="tab-pane" id="tab-other">
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
			</div>
		</div>
		<!-- end product tabbar -->
		<!-- also product -->
		{if $products}
		<div class="full-block full-slider">
			<h3 class="block-title">您可能喜欢...</h3>
			<div class="content">
				<div id="also-product" class="carousel slide" data-ride="carousel">
					<ol class="carousel-indicators">
						<li data-target="#also-product" data-slide-to="0"></li>
						{foreach from=$products item=product name=product}
							{if $smarty.foreach.product.iteration % 5 == 0 && $smarty.foreach.product.last == false}
								<li data-target="#also-product" data-slide-to="{$smarty.foreach.product.iteration / 5}" class="active"></li>
							{/if}
						{/foreach}
					</ol>
					<div class="carousel-inner" role="listbox">
						<div class="item active">
							<ul class="product-list">
								{foreach from=$products item=product name=product}
								<li>
									<a data-id="{$product.id_product}" href="javascript:void(0)" data-toggle="tooltip" data-placement="{if $smarty.foreach.product.iteration % 5 == 1}right{else}bottom{/if}" title="点击收藏该商品" class="wish {if in_array($product.id_product,$wish_array)}on{/if}">
										<span class="glyphicon glyphicon-heart" aria-hidden="true"></span>
									</a>
									{if $product.is_new}
										<span class="label label-success new">新品上架</span>
									{/if}
									<a href="{$product.link}" title="{$product.name}"><img src="{$product.image_home}" alt="{$product.name}" title="{$product.name}" /></a>
									<div class="price align_center">
										<span class="now-price">{displayPrice price=$product.price}</span>
										<span class="old-price">{displayPrice price=$product.old_price}</span>
									</div>
									<h2 class="product-name"><a href="{$product.link}" title="{$product.name}">{$product.name}</a></h2>
								</li>
								{if $smarty.foreach.product.iteration % 5 == 0 && $smarty.foreach.product.last == false}
							</ul></div>
						<div class="item">
							<ul class="product-list">
								{/if}
								{/foreach}
							</ul>
						</div>
					</div>
					{if count($products)>4}
					<a class="left carousel-control" href="#also-product" role="button" data-slide="prev">
						<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
						<span class="sr-only">上一页</span>
					</a>
					<a class="right carousel-control" href="#also-product" role="button" data-slide="next">
						<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
						<span class="sr-only">下一页</span>
					</a>
					{/if}
				</div>
			</div>
		</div>
		{/if}
		<!-- end also product -->
	</div>
</div>