<?php /* Smarty version Smarty-3.1.12, created on 2015-11-14 21:33:30
         compiled from "D:\wamp\www\red\shoes\themes\shop\product.tpl" */ ?>
<?php /*%%SmartyHeaderCode:314454993646aabd45-87107133%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '12b2f12fe072bf938e38c7714e413f78f80e0733' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\themes\\shop\\product.tpl',
      1 => 1446561898,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '314454993646aabd45-87107133',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_54993646dc93c4_18968588',
  'variables' => 
  array (
    'entity' => 0,
    'link' => 0,
    'images' => 0,
    'image' => 0,
    'root_dir' => 0,
    'feedback' => 0,
    'groups' => 0,
    'group' => 0,
    'attribute' => 0,
    'wish_array' => 0,
    'products' => 0,
    'product' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54993646dc93c4_18968588')) {function content_54993646dc93c4_18968588($_smarty_tpl) {?><div id="main_columns">
	<div id="pb-left-column">
		<div id="image-block"> 
			<span id="view_full_size">
				<img height="300" width="300" id="bigpic" alt="<?php echo $_smarty_tpl->tpl_vars['entity']->value->name;?>
" title="<?php echo $_smarty_tpl->tpl_vars['entity']->value->name;?>
" src="<?php echo $_smarty_tpl->tpl_vars['link']->value->getImageLink($_smarty_tpl->tpl_vars['entity']->value->id_image_default,'large');?>
" style="display: inline;">
			</span>
		</div>
		<?php if ($_smarty_tpl->tpl_vars['images']->value){?>
		<div class="iosSlider small-slider">
			<div class="slider-style slider-style-thumbs">
				<div class="slider">
					<?php  $_smarty_tpl->tpl_vars['image'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['image']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['images']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['image']->index=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['image']->key => $_smarty_tpl->tpl_vars['image']->value){
$_smarty_tpl->tpl_vars['image']->_loop = true;
 $_smarty_tpl->tpl_vars['image']->index++;
 $_smarty_tpl->tpl_vars['image']->first = $_smarty_tpl->tpl_vars['image']->index === 0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['image']['first'] = $_smarty_tpl->tpl_vars['image']->first;
?>
					<div class="item item1">
					<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getImageLink($_smarty_tpl->tpl_vars['image']->value['id_image'],'large');?>
" <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['image']['first']){?>class="shown"<?php }?> title="<?php echo $_smarty_tpl->tpl_vars['entity']->value->name;?>
-<?php echo $_smarty_tpl->tpl_vars['image']->value['id_image'];?>
" onclick="return false">
						<img src="<?php echo $_smarty_tpl->tpl_vars['link']->value->getImageLink($_smarty_tpl->tpl_vars['image']->value['id_image'],'small');?>
" alt="<?php echo $_smarty_tpl->tpl_vars['entity']->value->name;?>
-<?php echo $_smarty_tpl->tpl_vars['image']->value['id_image'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['entity']->value->name;?>
-<?php echo $_smarty_tpl->tpl_vars['image']->value['id_image'];?>
" />
					</a>
					</div>
					<?php } ?>
				</div>
			</div>
			<?php if (count($_smarty_tpl->tpl_vars['images']->value)>7){?>
			<div class="controls-direction thumbs-control">
				<span class="prev">Prev</span>
				<span class="next">Next</span>
			</div>
			<?php }?>
		</div>
		<?php }?>
	</div>
	
	<div id="pb-right-column" class="pt-standard" itemtype="http://schema.org/Product" itemscope="">
		<div class="inner-aside-product">
			<form action="<?php echo $_smarty_tpl->tpl_vars['root_dir']->value;?>
cart.html" method="post" class="add_to_cart_form">
			<h1 class="prodTitle" itemprop="name"><?php echo stripslashes($_smarty_tpl->tpl_vars['entity']->value->name);?>
</h1>
			<?php if ($_smarty_tpl->tpl_vars['entity']->value->orders>0){?>
				<div itemtype="http://schema.org/AggregateRating" itemscope="" itemprop="aggregateRating" class="product-star-order">
					 <span class="product-star" id="product-star">
						 <span class="ui-rating star-block" title="Average Star Rating: <?php echo $_smarty_tpl->tpl_vars['feedback']->value['state']['average'];?>
 out of 5">
							<ul class="rate txt-16">
							   <li><span class="icon-star"><span>1</span></span></li>
							   <li><span class="icon-star"><span>2</span></span></li>
							   <li><span class="icon-star"><span>3</span></span></li>
							   <li><span class="icon-star"><span>4</span></span></li>
							   <li><span class="icon-star"><span>5</span></span></li>
							</ul>
							<ul class="rate txt-16 active" style="width:<?php echo $_smarty_tpl->tpl_vars['feedback']->value['state']['total_pt'];?>
%;">
							   <li><span class="icon-star"><span>1</span></span></li>
							   <li><span class="icon-star"><span>2</span></span></li>
							   <li><span class="icon-star"><span>3</span></span></li>
							   <li><span class="icon-star"><span content="<?php echo $_smarty_tpl->tpl_vars['feedback']->value['state']['average'];?>
" itemprop="ratingValue"><?php echo $_smarty_tpl->tpl_vars['feedback']->value['state']['average'];?>
</span></span></li>
							   <li><span class="icon-star"><span itemprop="reviewCount"><?php echo $_smarty_tpl->tpl_vars['feedback']->value['state']['times'];?>
</span></span></li>
							</ul>
						 </span>
						 <b><?php echo $_smarty_tpl->tpl_vars['feedback']->value['state']['five_pt']+$_smarty_tpl->tpl_vars['feedback']->value['state']['four_pt'];?>
%</b> enjoyed! (<?php echo intval($_smarty_tpl->tpl_vars['feedback']->value['state']['times']);?>
 votes)
					 </span>
					 <span class="orders-count">
						<b><?php echo $_smarty_tpl->tpl_vars['entity']->value->orders;?>
</b> orders
					  </span>
					  <div class="clear"></div>
				</div>
				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['entity']->value->special_price>0){?>
				<div class="row-panel">
					<h3 class="title-panel">Retail Price:</h3>
					<div class="panel">
						<del class="original-price notranslate">
							US <span id="sku-price"><?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['entity']->value->special_price),$_smarty_tpl);?>
</span>
							/  Pair </del>
						<span class="unit-disc sub-info"></span>
					</div>
				</div>
				<?php }?>
				<div class="row-panel">
					<h3 class="title-panel">Discount Price:</h3>
					<div class="panel">
						<div class="current-price">
						  <div itemtype="http://schema.org/Offer" itemscope="" itemprop="offers"> 
							<b> <span content="USD" itemprop="priceCurrency">US </span><span itemprop="price" id="sku-price"><?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['entity']->value->price),$_smarty_tpl);?>
</span> </b> /  Pair 
						  </div>
						</div>
					</div>
				</div>

			  <input type="hidden" name="id_product" value="<?php echo $_smarty_tpl->tpl_vars['entity']->value->id;?>
" />
			  <?php  $_smarty_tpl->tpl_vars['group'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['group']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['groups']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['group']->key => $_smarty_tpl->tpl_vars['group']->value){
$_smarty_tpl->tpl_vars['group']->_loop = true;
?>
			  <div class="hide">
				<input type="hidden" name="id_attributes[]" class="id_attribute_group" id="id_attribute_group_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_attribute_group'];?>
" value="" />
			  </div>
			  <div class="row-panel no">
				<h3 class="title-panel"><?php echo $_smarty_tpl->tpl_vars['group']->value['name'];?>
:</h3>
				<div class="panel">
					<span class="skin-select skin">
						<span class="select-content" id="group-id-<?php echo $_smarty_tpl->tpl_vars['group']->value['id_attribute_group'];?>
"><span>Select your size</span></span>
						<select name="group" id="group_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_attribute_group'];?>
" class="attribute_group skin">
						  <option value="NULL">Select your size</option>
						  <?php  $_smarty_tpl->tpl_vars['attribute'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['attribute']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['group']->value['attributes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['attribute']->key => $_smarty_tpl->tpl_vars['attribute']->value){
$_smarty_tpl->tpl_vars['attribute']->_loop = true;
?>
						  <option value="<?php echo $_smarty_tpl->tpl_vars['attribute']->value['id_attribute'];?>
" <?php if (Tools::getRequest('id_attributes')&&in_array($_smarty_tpl->tpl_vars['attribute']->value['id_attribute'],Tools::getRequest('id_attributes'))){?>selected="selected"<?php }?>>
						  <?php echo $_smarty_tpl->tpl_vars['attribute']->value['name'];?>

						  </option>
						 <?php } ?>
						</select>
						<span class="sub-dd">
							<ul class="list-item">
							  <?php  $_smarty_tpl->tpl_vars['attribute'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['attribute']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['group']->value['attributes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['attribute']->key => $_smarty_tpl->tpl_vars['attribute']->value){
$_smarty_tpl->tpl_vars['attribute']->_loop = true;
?>
							   <li<?php if (Tools::getRequest('id_attributes')&&in_array($_smarty_tpl->tpl_vars['attribute']->value['id_attribute'],Tools::getRequest('id_attributes'))){?>class="active"<?php }?>>
								<a class="shoesize" rel="<?php echo $_smarty_tpl->tpl_vars['attribute']->value['id_attribute'];?>
" href="#"><span> <?php echo $_smarty_tpl->tpl_vars['attribute']->value['name'];?>
 </span></a>
							   </li>
							  <?php } ?>
							</ul>
						</span>
					</span>
					<p><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('CMSView',144);?>
" target="_blank" class="all no">See size guide</a></p>
				</div>
			  </div>
			  <?php } ?>
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
					<a id="add-to-favoris" href="javascript:void(0)" onclick="addWish($(this),<?php echo $_smarty_tpl->tpl_vars['entity']->value->id;?>
)" class="button small full white<?php if (in_array($_smarty_tpl->tpl_vars['entity']->value->id,$_smarty_tpl->tpl_vars['wish_array']->value)){?> on<?php }?>">
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
			<li class="tab-row"><a href="javascript:void(0)" class="tab-page" id="link-feedback">Feedback(<?php echo count($_smarty_tpl->tpl_vars['feedback']->value['rows']);?>
)</a></li>
			<li class="tab-row"><a href="javascript:void(0)" class="tab-page" id="link-shipping">Shipping & Payment</a></li>
		</ul>
	</div>
	<div id="tabPane" class="tab-pane">
		<div id="product-tab-content-details" class="product-tab-content" style="display:block">
			<div id="product_description">
				<?php echo stripslashes($_smarty_tpl->tpl_vars['entity']->value->description);?>

				<br/>
			</div>
		</div>
		<div id="product-tab-content-feedback" class="product-tab-content">
				<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./block/feedback.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

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
	<?php if ($_smarty_tpl->tpl_vars['products']->value){?>
	<section class="iosSlider main-slider">
		<h2 class="pt-standard"><span>What about…</span></h2>
		<div class="slider-style slider-style-aslo">
			<div class="slider">
				<?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['product']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['products']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value){
$_smarty_tpl->tpl_vars['product']->_loop = true;
?>
				<div class="item item1">
					<a href="<?php echo $_smarty_tpl->tpl_vars['product']->value['link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>
">
						<div class="img-content"><img src="<?php echo $_smarty_tpl->tpl_vars['product']->value['image_home'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>
" /></div>
						<strong class="brand"><?php echo $_smarty_tpl->tpl_vars['product']->value['brand'];?>
</strong>
						<span class="model"><?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>
</span>
						<strong class="price"><i><?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['product']->value['price']),$_smarty_tpl);?>
</i></strong>
					</a>
				</div>
				<?php } ?>
			</div>
		</div>
		<?php if (count($_smarty_tpl->tpl_vars['products']->value)>4){?>
		<div class="controls-direction aslo-control">
			<span class="prev">Prev</span>
			<span class="next">Next</span>
		</div>
		<?php }?>
	</section>
	<br>
	<?php }?>
</div><?php }} ?>