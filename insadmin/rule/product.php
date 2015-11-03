<?php
$id_category 	= Tools::getRequest('id_category',1);
$category 			= new Category($id_category);
$filter		= array();
if(intval(Tools::getRequest('delete'))>0){
	$object = new Product(intval(Tools::getRequest('delete')));
	if(Validate::isLoadedObject($object)){
		$object->delete();
	}
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		echo '<div class="conf">删除分类成功</div>';
	}
}elseif(Tools::isSubmit('subDelete')){
	$select_cat = Tools::getRequest('productBox');
	$product		= new Product();
	if(is_array($select_cat)){
		if($product->deleteSelection($select_cat))
			echo '<div class="conf">删除分类成功</div>';
	}
}elseif(Tools::isSubmit('subActiveON') OR Tools::isSubmit('subActiveOFF')){
	$select_cat = Tools::getRequest('productBox');
	$action		= Tools::isSubmit('subActiveON')?1:0;
	$object		= new Product();
	if(is_array($select_cat)){
		if($object->statusSelection($select_cat,$action))
			echo '<div class="conf">更新分类状态成功</div>';
	}
}

$filter	 = $cookie->getFilter('product',array('id_product','title','rewrite','active','is_top'));
if(Tools::isSubmit('submitResetProduct')){
	$cookie->unsetFilter('product',array('id_product','title','rewrite','active','is_top'));
	$filter = array();
}
$filter['id_category'] = isset($_GET['id_category'])?intval($_GET['id_category']):1;
if(isset($_GET['id_brand']))
	$filter['id_brand'] = intval($_GET['id_brand']);

$orderBy 	= $cookie->getPost('productOrderBy') ? $cookie->getPost('productOrderBy') : 'id_product';
$orderWay 	= $cookie->getPost('productOrderWay') ? $cookie->getPost('productOrderWay') : 'ASC';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::getRequest('p') ? (Tools::getRequest('p')==0?1:Tools::getRequest('p')):1;

$result  	= Product::getProducts(false,$p,$limit,$orderBy,$orderWay,$filter);

require_once(_TM_ADMIN_DIR_.'/errors.php');
?>
<script type="text/javascript" src="<?php echo $_tmconfig['tm_js_dir']?>jquery/jquery.tablednd_0_5.js"></script>
<script src="<?php echo $_tmconfig['tm_js_dir']?>admin/dnd.js" type="text/javascript"></script>
<div class="col-md-12 col-md-offset-2">
	<ol class="breadcrumb">
		<li><a href="index.php">后台首页</a></li>
		<li><a href="index.php?rule=product">商品</a></li>
		<li class="active">商品管理</li>
	</ol>
</div>
<div class="col-md-12 action-group">
	<div class="btn-group pull-right" role="group">
		<a href="index.php?rule=product_edit"  class="btn btn-success"><span aria-hidden="true" class="glyphicon glyphicon-plus"></span> 添加商品</a>
	</div>
</div>
<div class="clearfix"></div>
<div class="col-md-2 sidebar">
	<script type="text/javascript">
		$(document).ready(function(){
			var base_url = 'index.php?rule=product';
			// Load category products page when category is clicked
			$('#categories-treeview :input').on('click', function(){
				var brand_value = '';
				if($("input[name='id_brands'][checked]").val()>0){
					brand_value = '&id_brand='+$("input[name='id_brands'][checked]").val();
				}
				if (this.value !== "")
					location.href = base_url + '&id_category=' + parseInt(this.value)+brand_value;
				else
					location.href = base_url;
			});
			$(".form").keypress(function(e) {
				if (e.which == 13) {
					return false;
				}
			});
		});
		function ajaxToggle (obj,key,value)
		{
			$.ajax({
				url: 'public/ajax.php',
				cache: false,
				data: "toggle=product&key="+key+"&value="+value,
				dataType: "json",
				success: function(data)
				{
					if(data.status=='YES'){
						if(obj.src.indexOf('enabled')>0){
							obj.src = obj.src.replace('enabled','disabled');
						}else{
							obj.src = obj.src.replace('disabled','enabled');
						}
					}
				}
			});
		};
	</script>
	<ul class="list-group brand-group">
		<li class="list-group-item active">检索分类</li>
		<li class="list-group-item">
		<?php
		$trads = array(
			'Home' => '根分类',
			'selected' => '选择',
			'Collapse All' => '关闭',
			'Expand All' => '展开'
		);
		echo Helper::renderAdminCategorieTree($trads, array(Tools::getRequest('id_category')?Tools::getRequest('id_category'):1), 'categoryBox', true,'Tree');
		?>
		</li>
	</ul>
	<br>
	<ul class="list-group brand-group">
		<li class="list-group-item active">检索品牌</li>
		<li class="list-group-item">
			<a href="?rule=product&id_category=<?php echo Tools::getRequest('id_category')?Tools::getRequest('id_category'):1;?>">
				<input type="radio" class="id_brands" name="id_brands" value="0" <?php if(Tools::getRequest('id_brand')==0){echo "checked";}?>/></a> 所有品牌
		</li>
		<?php
		$brands = Brand::getEntity();
		if($brands){
			foreach($brands['entitys'] as $brand){
				?>
				<li class="list-group-item"><a href="?rule=product&id_category=<?php echo Tools::getRequest('id_category')?Tools::getRequest('id_category'):1;?>&id_brand=<?php echo $brand["id_brand"];?>">
						<input type="radio" class="id_brands" name="id_brands" value="<?php echo $brand["id_brand"];?>" <?php if(Tools::getRequest('id_brand')==$brand["id_brand"]){echo "checked";}?>/></a> <?php echo $brand["name"];?></li>
				<?php
			}
		}
		?>
	</ul>
</div>
<div class="col-md-10 col-md-offset-2">
	<form class="form" method="post" action="index.php?rule=product">
		<table class="table table-bordered" width="100%">
			<thead>
			<tr>
				<th><input type="checkbox" name="checkme" data-name="productBox[]" class="check-all" ></th>
				<th>
					<a href="index.php?rule=product&productOrderBy=id_product&productOrderWay=desc" >
						<span aria-hidden="true" class="glyphicon glyphicon-sort-by-order-alt"></span>
					</a>
					编号
					<a href="index.php?rule=product&productOrderBy=id_product&productOrderWay=asc">
						<span aria-hidden="true" class="glyphicon glyphicon-sort-by-order"></span>
					</a>
				</th>
				<th>图片</th>
				<th width="20%">
					<a href="index.php?rule=product&productOrderBy=name&productOrderWay=desc">
						<span aria-hidden="true" class="glyphicon glyphicon-sort-by-order-alt"></span>
					</a>
					产品名
					<a href="index.php?rule=product&productOrderBy=name&productOrderWay=asc">
						<span aria-hidden="true" class="glyphicon glyphicon-sort-by-order"></span>
					</a>
				</th>
				<th>
					<a href="index.php?rule=product&productOrderBy=quantity&productOrderWay=desc">
						<span aria-hidden="true" class="glyphicon glyphicon-sort-by-order-alt"></span>
					</a>
					库存
					<a href="index.php?rule=product&productOrderBy=quantity&productOrderWay=asc">
						<span aria-hidden="true" class="glyphicon glyphicon-sort-by-order"></span>
					</a>
				</th>
				<th>
					<a href="index.php?rule=product&productOrderBy=price&productOrderWay=desc">
						<span aria-hidden="true" class="glyphicon glyphicon-sort-by-order-alt"></span>
					</a>
					价格
					<a href="index.php?rule=product&productOrderBy=price&productOrderWay=asc">
						<span aria-hidden="true" class="glyphicon glyphicon-sort-by-order"></span>
					</a>
				</th>
				<th>
					<a href="index.php?rule=product&productOrderBy=special_price&productOrderWay=desc">
						<span aria-hidden="true" class="glyphicon glyphicon-sort-by-order-alt"></span>
					</a>
					官方标价
					<a href="index.php?rule=product&productOrderBy=special_price&productOrderWay=asc">
						<span aria-hidden="true" class="glyphicon glyphicon-sort-by-order"></span>
					</a>
				</th>
				<th>
					<a href="index.php?rule=product&productOrderBy=active&productOrderWay=desc">
						<span aria-hidden="true" class="glyphicon glyphicon-sort-by-order-alt"></span>
					</a>
					状态
					<a href="index.php?rule=product&productOrderBy=active&productOrderWay=asc">
						<span aria-hidden="true" class="glyphicon glyphicon-sort-by-order"></span>
					</a>
					</a>
				</th>
				<th>
					<a href="index.php?rule=product&productOrderBy=in_stock&productOrderWay=desc">
						<span aria-hidden="true" class="glyphicon glyphicon-sort-by-order-alt"></span>
					</a>
					允许购买
					<a href="index.php?rule=product&productOrderBy=in_stock&productOrderWay=asc">
						<span aria-hidden="true" class="glyphicon glyphicon-sort-by-order"></span>
					</a>
				</th>
				<th>
					<a href="index.php?rule=product&productOrderBy=is_new&productOrderWay=desc">
						<span aria-hidden="true" class="glyphicon glyphicon-sort-by-order-alt"></span>
					</a>
					新产品
					<a href="index.php?rule=product&productOrderBy=is_new&productOrderWay=asc">
						<span aria-hidden="true" class="glyphicon glyphicon-sort-by-order"></span>
					</a>
				</th>
				<th>
					<a href="index.php?rule=product&productOrderBy=is_sale&productOrderWay=desc">
						<span aria-hidden="true" class="glyphicon glyphicon-sort-by-order-alt"></span>
					</a>
					热销品
					<a href="index.php?rule=product&productOrderBy=is_sale&productOrderWay=asc">
						<span aria-hidden="true" class="glyphicon glyphicon-sort-by-order"></span>
					</a>
				</th>
				<th>
					<a href="index.php?rule=product&productOrderBy=is_top&productOrderWay=desc">
						<span aria-hidden="true" class="glyphicon glyphicon-sort-by-order-alt"></span>
					</a>
					推荐
					<a href="index.php?rule=product&productOrderBy=is_top&productOrderWay=asc">
						<span aria-hidden="true" class="glyphicon glyphicon-sort-by-order"></span>
					</a>
				</th>
				<th align="right" >操作</th>
			</tr>
			<tr>
				<td class="center"> -- </td>
				<td class="center"><input type="text" style="width:50px" value="<?php echo isset($filter['id_product'])?$filter['id_product']:'';?>" name="productFilter_id_product" class="filter"></td>
				<td class="center"> -- </td>
				<td><input type="text" value="<?php echo isset($filter['name'])?$filter['name']:'';?>" name="productFilter_name" class="filter"></td>
				<td class="center"> -- </td>
				<td><input type="text" value="<?php echo isset($filter['price'])?$filter['price']:'';?>" name="productFilter_price" class="filter" size="10"></td>
				<td><input type="text" value="<?php echo isset($filter['special_price'])?$filter['special_price']:'';?>" name="productFilter_special_price" class="filter" size="10"></td>
				<td class="center">
					<select name="productFilter_active" onChange="$('#submitFilterButtonProduct').focus();$('#submitFilterButtonProduct').click();">
						<option value="">--</option>
						<option value="1" <?php if(isset($filter['active']) && $filter['active']==1){echo "selected";}?>>Yes</option>
						<option value="2" <?php if(isset($filter['active']) && $filter['active']==2){echo "selected";}?>>No</option>
					</select>
				</td>
				<td class="center">
					<select name="productFilter_in_stock" onChange="$('#submitFilterButtonProduct').focus();$('#submitFilterButtonProduct').click();">
						<option value="">--</option>
						<option value="1" <?php if(isset($filter['in_stock']) && $filter['in_stock']==1){echo "selected";}?>>Yes</option>
						<option value="2" <?php if(isset($filter['in_stock']) && $filter['in_stock']==2){echo "selected";}?>>No</option>
					</select>
				</td>
				<td>
					<select name="productFilter_is_new" onChange="$('#submitFilterButtonProduct').focus();$('#submitFilterButtonProduct').click();">
						<option value="">--</option>
						<option value="1" <?php if(isset($filter['is_new']) && $filter['is_new']==1){echo "selected";}?>>Yes</option>
						<option value="2" <?php if(isset($filter['is_new']) && $filter['is_new']==2){echo "selected";}?>>No</option>
					</select>
				</td>
				<td>
					<select name="productFilter_is_sale" onChange="$('#submitFilterButtonProduct').focus();$('#submitFilterButtonProduct').click();">
						<option value="">--</option>
						<option value="1" <?php if(isset($filter['is_sale']) && $filter['is_sale']==1){echo "selected";}?>>Yes</option>
						<option value="2" <?php if(isset($filter['is_sale']) && $filter['is_sale']==2){echo "selected";}?>>No</option>
					</select>
				</td>
				<td>
					<select name="productFilter_is_top" onChange="$('#submitFilterButtonProduct').focus();$('#submitFilterButtonProduct').click();">
						<option value="">--</option>
						<option value="1" <?php if(isset($filter['is_top']) && $filter['is_top']==1){echo "selected";}?>>Yes</option>
						<option value="2" <?php if(isset($filter['is_top']) && $filter['is_top']==2){echo "selected";}?>>No</option>
					</select>
				</td>
				<td align="right">
					<div class="btn-group" role="group">
						<button class="btn btn-primary btn-xs" type="submit">查询</button>
						<button type="submit" class="btn btn-default btn-xs" name="submitResetProduct">重置</button>
					</div>
				</td>
			</tr>
			</thead>
			<?php
			if(is_array($result['entitys']) && count($result['entitys'])>0){
				foreach($result['entitys'] as $key => $row){?>
					<tr id="tr_<?php echo $row['id_product'].'_'.$row['id_category_default'];?>">
						<td><input type="checkbox" name="productBox[]" value="<?php echo $row['id_product'];?>" ></td>
						<td class="pointer" onclick="document.location = 'index.php?rule=product_edit&id=<?php echo $row['id_product'];?>'"><?php echo $row['id_product'];?></td>
						<td class="pointer" onclick="document.location = 'index.php?rule=product_edit&id=<?php echo $row['id_product'];?>'"><?php echo $row['id_image_default']?'<img src="'.$row['image_small'].'">':'--'?></td>
						<td class="pointer" onclick="document.location = 'index.php?rule=product_edit&id=<?php echo $row['id_product'];?>'"><?php echo $row['name'];?></td>
						<td class="pointer" onclick="document.location = 'index.php?rule=product_edit&id=<?php echo $row['id_product'];?>'"><?php echo $row['quantity'];?></td>
						<td><input type="text" name="change_price_<?php echo $row['id_product'];?>" value="<?php echo $row['price'];?>" class="price_value" size="10"/></td>
						<td><input type="text" name="change_special_price_<?php echo $row['id_product'];?>" value="<?php echo $row['special_price'];?>" class="special_price_value" size="10"/></td>
						<td class="pointer text-center">
							<span onclick="ajaxToggle(this,'active',<?php echo $row['id_product'];?>)" class="glyphicon glyphicon-<?php echo ($row['active']?'ok':'remove');?> active-toggle"></span>
						</td>
						<td class="pointer text-center">
							<span onclick="ajaxToggle(this,'in_stock',<?php echo $row['id_product'];?>)" class="glyphicon glyphicon-<?php echo ($row['in_stock']?'ok':'remove');?> active-toggle"></span>
						</td>
						<td class="pointer text-center">
							<span onclick="ajaxToggle(this,'is_new',<?php echo $row['id_product'];?>)" class="glyphicon glyphicon-<?php echo ($row['is_new']?'ok':'remove');?> active-toggle"></span>
						</td>
						<td class="pointer text-center">
							<span onclick="ajaxToggle(this,'is_sale',<?php echo $row['id_product'];?>)" class="glyphicon glyphicon-<?php echo ($row['is_sale']?'ok':'remove');?> active-toggle"></span>
						</td>
						<td class="pointer text-center">
							<span onclick="ajaxToggle(this,'is_top',<?php echo $row['id_product'];?>)" class="glyphicon glyphicon-<?php echo ($row['is_top']?'ok':'remove');?> active-toggle"></span>
						</td>
						<td align="right">
							<div class="btn-group">
								<a target="_blank" href="<?php echo Tools::getLink($row['rewrite']);?>" aria-label="Left Align" class="btn btn-default"><span aria-hidden="true" title="预览" class="glyphicon glyphicon-file"></span></a>
								<a href="index.php?rule=product_edit&id=<?php echo $row['id_product'];?>" aria-label="Center Align" class="btn btn-default"><span aria-hidden="true" title="编辑" class="glyphicon glyphicon-edit"></span></a>
								<a onclick="return confirm('你确定要删除？')" href="index.php?rule=product&delete=<?php echo $row['id_product'];?>" aria-label="Justify" class="btn btn-default"><span aria-hidden="true" title="删除"  class="glyphicon glyphicon-trash"></span></a>
							</div>
						</td>
					</tr>
				<?php }
			}else{
				?>
				<tr><td colspan="5" align="center">暂无内容</td></tr>
			<?php }?>
		</table>
<!--
		<span>
			<input type="submit" class="button" value="检索" name="submitFilter" id="submitFilterButtonProduct">
			<input type="submit" class="button" value="重置" name="submitResetProduct">
		</span>
		-->
			<div class="btn-group" role="group" >
				<button type="submit" class="btn btn-default" onclick="return confirm('你确定要删除选中项目?');" name="subDelete">批量删除</button>
				<button type="submit" class="btn btn-default" name="subActiveON">批量启用</button>
				<button type="submit" class="btn btn-default" name="subActiveOFF">批量关闭</button>
			</div>


			<nav>
				<div class="page-number pull-left">
					<span class="page-number-title pull-left">共 <strong><?php echo $result['total'];?></strong> 个产品,每页显示</span>
					<select onchange="submit()" name="pagination" class="form-control page-number-select pull-left">
						<option value="20" <?php if($limit==20){echo 'selected="selected"';}?>>20</option>
						<option value="50" <?php if($limit==50){echo 'selected="selected"';}?>>50</option>
						<option value="100" <?php if($limit==100){echo 'selected="selected"';}?>>100</option>
						<option value="300" <?php if($limit==300){echo 'selected="selected"';}?>>300</option>
					</select>
				</div>
				<?php
				echo Helper::renderAdminPagination($result['total'],$limit);
				?>
			</nav>
		</form>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$(".price_value").change(function(){
			var id_product = $(this).attr("name").replace("change_price_","");
			changePrice(id_product,$(this).val(),"YES");
		})
	});
	function changePrice(id_product,value,type)
	{
		$.ajax({
			url: 'public/ajax.php',
			cache: false,
			data: "action=changePrice&id_product="+id_product+"&value="+value+"&type="+type,
			dataType: "json",
			success: function(data)
				{

				}
			}); 	
	}; 
</script>