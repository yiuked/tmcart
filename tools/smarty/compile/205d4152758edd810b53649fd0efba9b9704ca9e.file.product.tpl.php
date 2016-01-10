<?php /* Smarty version Smarty-3.1.12, created on 2016-01-08 13:48:00
         compiled from "/Users/apple/Documents/httpd/red/shoes/themes/shop/product.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2041234348568f4d907e6746-30464151%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '205d4152758edd810b53649fd0efba9b9704ca9e' => 
    array (
      0 => '/Users/apple/Documents/httpd/red/shoes/themes/shop/product.tpl',
      1 => 1452229589,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2041234348568f4d907e6746-30464151',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'entity' => 0,
    'link' => 0,
    'images' => 0,
    'image' => 0,
    'feedback' => 0,
    'groups' => 0,
    'group' => 0,
    'attribute' => 0,
    'products' => 0,
    'product' => 0,
    'wish_array' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_568f4d909234a6_55520707',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_568f4d909234a6_55520707')) {function content_568f4d909234a6_55520707($_smarty_tpl) {?><div class="container">
	<div id="main_columns">
		<div id="pb-left-column">
			<div id="image-block">
				<span id="view_full_size">
					<img height="300" width="300" id="bigpic" alt="<?php echo $_smarty_tpl->tpl_vars['entity']->value->name;?>
" title="<?php echo $_smarty_tpl->tpl_vars['entity']->value->name;?>
" src="<?php echo $_smarty_tpl->tpl_vars['link']->value->getImageLink($_smarty_tpl->tpl_vars['entity']->value->id_image,'large');?>
" data-toggle="modal" data-target=".big-img-modal-lg">
				</span>
			</div>
			<div class="modal fade big-img-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title"><?php echo $_smarty_tpl->tpl_vars['entity']->value->name;?>
</h4>
						</div>
						<div id="big-img-slider" class="carousel slide" data-ride="carousel" data-interval="false">
							<div class="carousel-inner" role="listbox">
									<?php  $_smarty_tpl->tpl_vars['image'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['image']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['images']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['image']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['image']->iteration=0;
 $_smarty_tpl->tpl_vars['image']->index=-1;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['image']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['image']->key => $_smarty_tpl->tpl_vars['image']->value){
$_smarty_tpl->tpl_vars['image']->_loop = true;
 $_smarty_tpl->tpl_vars['image']->iteration++;
 $_smarty_tpl->tpl_vars['image']->index++;
 $_smarty_tpl->tpl_vars['image']->first = $_smarty_tpl->tpl_vars['image']->index === 0;
 $_smarty_tpl->tpl_vars['image']->last = $_smarty_tpl->tpl_vars['image']->iteration === $_smarty_tpl->tpl_vars['image']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['image']['first'] = $_smarty_tpl->tpl_vars['image']->first;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['image']['iteration']++;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['image']['last'] = $_smarty_tpl->tpl_vars['image']->last;
?>
									<div class="item <?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['image']['iteration']==1){?>active<?php }?>">
										<img src="<?php echo $_smarty_tpl->tpl_vars['link']->value->getImageLink($_smarty_tpl->tpl_vars['image']->value['id_image']);?>
" alt="<?php echo $_smarty_tpl->tpl_vars['entity']->value->name;?>
-<?php echo $_smarty_tpl->tpl_vars['image']->value['id_image'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['entity']->value->name;?>
-<?php echo $_smarty_tpl->tpl_vars['image']->value['id_image'];?>
" />
									</div>
									<?php } ?>
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
			<?php if ($_smarty_tpl->tpl_vars['images']->value){?>
			<div id="thumbs-list" class="carousel slide" data-ride="carousel" data-interval="false">
				<div class="carousel-inner" role="listbox">
					<div class="item active">
						<?php  $_smarty_tpl->tpl_vars['image'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['image']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['images']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['image']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['image']->iteration=0;
 $_smarty_tpl->tpl_vars['image']->index=-1;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['image']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['image']->key => $_smarty_tpl->tpl_vars['image']->value){
$_smarty_tpl->tpl_vars['image']->_loop = true;
 $_smarty_tpl->tpl_vars['image']->iteration++;
 $_smarty_tpl->tpl_vars['image']->index++;
 $_smarty_tpl->tpl_vars['image']->first = $_smarty_tpl->tpl_vars['image']->index === 0;
 $_smarty_tpl->tpl_vars['image']->last = $_smarty_tpl->tpl_vars['image']->iteration === $_smarty_tpl->tpl_vars['image']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['image']['first'] = $_smarty_tpl->tpl_vars['image']->first;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['image']['iteration']++;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['image']['last'] = $_smarty_tpl->tpl_vars['image']->last;
?>
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
						<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['image']['iteration']%6==0&&$_smarty_tpl->getVariable('smarty')->value['foreach']['image']['last']==false){?>
						</div>
						<div class="item">
						<?php }?>
						<?php } ?>
					</div>
				</div>
				<?php if (count($_smarty_tpl->tpl_vars['images']->value)>6){?>
				<a class="left carousel-control" href="#thumbs-list" role="button" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
					<span class="sr-only">上一页</span>
				</a>
				<a class="right carousel-control" href="#thumbs-list" role="button" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
					<span class="sr-only">下一页</span>
				</a>
				<?php }?>
			</div>
			<?php }?>
		</div>

		<div id="pb-right-column" >
				<form action="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('CartView');?>
" method="post" class="form-horizontal add_to_cart_form">
					<input type="hidden" name="id_product" value="<?php echo $_smarty_tpl->tpl_vars['entity']->value->id;?>
" />
					<h1><?php echo stripslashes($_smarty_tpl->tpl_vars['entity']->value->name);?>
</h1>
					<?php if ($_smarty_tpl->tpl_vars['entity']->value->orders>0){?>
					<div class="product-star-order">
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
					<?php if ($_smarty_tpl->tpl_vars['entity']->value->old_price>0){?>
					<div class="form-group">
						<label for="old-price" class="col-sm-2 control-label">价格</label>
						<div class="col-sm-10">
							<span class="old-price"><?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['entity']->value->old_price),$_smarty_tpl);?>
</span>
						</div>
					</div>
					<?php }?>
					<div class="form-group">
						<label for="now-price" class="col-sm-2 control-label">销售价</label>
						<div class="col-sm-10">
							<span class="now-price"><?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['entity']->value->price),$_smarty_tpl);?>
</span>
						</div>
					</div>
					<?php  $_smarty_tpl->tpl_vars['group'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['group']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['groups']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['group']->key => $_smarty_tpl->tpl_vars['group']->value){
$_smarty_tpl->tpl_vars['group']->_loop = true;
?>
					<div class="form-group">
						<label for="id_attribute_group_<?php echo $_smarty_tpl->tpl_vars['group']->value['id_attribute_group'];?>
" class="col-sm-2 control-label"><?php echo $_smarty_tpl->tpl_vars['group']->value['name'];?>
</label>
						<div class="col-sm-10 attrbiute-radio">
							<input type="hidden" name="id_attributes[]" class="id_attribute_group" value="<?php if (Tools::P('id_attributes')&&in_array($_smarty_tpl->tpl_vars['attribute']->value['id_attribute'],Tools::P('id_attributes'))){?><?php echo Tools::P('id_attributes');?>
<?php }?>" />
							<?php  $_smarty_tpl->tpl_vars['attribute'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['attribute']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['group']->value['attributes']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['attribute']->key => $_smarty_tpl->tpl_vars['attribute']->value){
$_smarty_tpl->tpl_vars['attribute']->_loop = true;
?>
								<div class="item<?php if (Tools::getRequest('id_attributes')&&in_array($_smarty_tpl->tpl_vars['attribute']->value['id_attribute'],Tools::getRequest('id_attributes'))){?> selected<?php }?>" data-id_attribute="<?php echo $_smarty_tpl->tpl_vars['attribute']->value['id_attribute'];?>
" ><b></b><a href="javascript:void(0);"><?php echo $_smarty_tpl->tpl_vars['attribute']->value['name'];?>
</a></div>
							<?php } ?>
						</div>
					</div>
					<?php } ?>

					<div class="form-group">
						<label for="quantity" class="col-sm-2 control-label">数量</label>
						<div class="col-sm-2">
							<input type="text" size="4" name="quantity" value="1" id="quantity" class="form-control" />
						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-offset-2">
							<button type="submit" class="btn btn-pink" name="addToCart" id="add_to_cart"><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> 加入购物车</button>
							<button type="button" class="btn btn-warning" id="add-to-wish"><span aria-hidden="true" class="glyphicon glyphicon-heart"></span> 收藏</button>
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
					<div role="tabpanel" class="tab-pane active" id="tab-description"><?php echo stripslashes($_smarty_tpl->tpl_vars['entity']->value->description);?>
</div>
					<div role="tabpanel" class="tab-pane" id="tab-feedback"><?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./block/feedback.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</div>
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
		<?php if ($_smarty_tpl->tpl_vars['products']->value){?>
		<div class="full-block full-slider">
			<h3 class="block-title">您可能喜欢...</h3>
			<div class="content">
				<div id="also-product" class="carousel slide" data-ride="carousel">
					<ol class="carousel-indicators">
						<li data-target="#also-product" data-slide-to="0"></li>
						<?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['product']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['products']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['product']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['product']->iteration=0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['product']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value){
$_smarty_tpl->tpl_vars['product']->_loop = true;
 $_smarty_tpl->tpl_vars['product']->iteration++;
 $_smarty_tpl->tpl_vars['product']->last = $_smarty_tpl->tpl_vars['product']->iteration === $_smarty_tpl->tpl_vars['product']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['product']['iteration']++;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['product']['last'] = $_smarty_tpl->tpl_vars['product']->last;
?>
							<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['product']['iteration']%5==0&&$_smarty_tpl->getVariable('smarty')->value['foreach']['product']['last']==false){?>
								<li data-target="#also-product" data-slide-to="<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['product']['iteration']/5;?>
" class="active"></li>
							<?php }?>
						<?php } ?>
					</ol>
					<div class="carousel-inner" role="listbox">
						<div class="item active">
							<ul class="product-list">
								<?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['product']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['products']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['product']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['product']->iteration=0;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['product']['iteration']=0;
foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value){
$_smarty_tpl->tpl_vars['product']->_loop = true;
 $_smarty_tpl->tpl_vars['product']->iteration++;
 $_smarty_tpl->tpl_vars['product']->last = $_smarty_tpl->tpl_vars['product']->iteration === $_smarty_tpl->tpl_vars['product']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['product']['iteration']++;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['product']['last'] = $_smarty_tpl->tpl_vars['product']->last;
?>
								<li>
									<a data-id="<?php echo $_smarty_tpl->tpl_vars['product']->value['id_product'];?>
" href="javascript:void(0)" data-toggle="tooltip" data-placement="bottom" title="点击收藏该商品" class="wish <?php if (in_array($_smarty_tpl->tpl_vars['product']->value['id_product'],$_smarty_tpl->tpl_vars['wish_array']->value)){?>on<?php }?>">
										<span class="glyphicon glyphicon-heart" aria-hidden="true"></span>
									</a>
									<?php if ($_smarty_tpl->tpl_vars['product']->value['is_new']){?>
										<span class="label label-success new">新品上架</span>
									<?php }?>
									<a href="<?php echo $_smarty_tpl->tpl_vars['product']->value['link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>
"><img src="<?php echo $_smarty_tpl->tpl_vars['product']->value['image_home'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>
" /></a>
									<div class="price align_center">
										<span class="now-price"><?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['product']->value['price']),$_smarty_tpl);?>
</span>
										<span class="old-price"><?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['product']->value['old_price']),$_smarty_tpl);?>
</span>
									</div>
									<h2 class="product-name"><a href="<?php echo $_smarty_tpl->tpl_vars['product']->value['link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>
"><?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>
</a></h2>
								</li>
								<?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['product']['iteration']%5==0&&$_smarty_tpl->getVariable('smarty')->value['foreach']['product']['last']==false){?>
							</ul></div>
						<div class="item">
							<ul class="product-list">
								<?php }?>
								<?php } ?>
							</ul>
						</div>
					</div>
					<?php if (count($_smarty_tpl->tpl_vars['products']->value)>4){?>
					<a class="left carousel-control" href="#also-product" role="button" data-slide="prev">
						<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
						<span class="sr-only">上一页</span>
					</a>
					<a class="right carousel-control" href="#also-product" role="button" data-slide="next">
						<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
						<span class="sr-only">下一页</span>
					</a>
					<?php }?>
				</div>
			</div>
		</div>
		<?php }?>
		<!-- end also product -->
	</div>
</div><?php }} ?>