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
$p			= Tools::getRequest('productPage') ? (Tools::getRequest('productPage')==0?1:Tools::getRequest('productPage')):1;

$result  	= Product::getProducts(false,$p,$limit,$orderBy,$orderWay,$filter);

require_once(_TM_ADMIN_DIR_.'/errors.php');
?>
<script type="text/javascript" src="<?php echo $_tmconfig['tm_js_dir']?>jquery/jquery.tablednd_0_5.js"></script>
<script src="<?php echo $_tmconfig['tm_js_dir']?>admin/dnd.js" type="text/javascript"></script>
<div class="path_bar">
	<div class="path_title">
		<h3> 
			<span style="font-weight: normal;" id="current_obj">
			<span class="breadcrumb item-1 ">分类 <img src="<?php echo $_tmconfig['tm_img_dir'];?>admin/separator_breadcrum.png" style="margin-right:5px" alt="&gt;"> </span> 
			<span class="breadcrumb item-2 ">产品</span> </span> 
		</h3>
		<div class="cc_button">
			<ul>
			<li><a title="添加内容" href="index.php?rule=product_edit" class="toolbar_btn" id="add_product_new">
					<span class="process-icon-new "></span>
					<div>添加内容</div>
				</a></li>
			</ul>
		</div>
	</div>
</div>
<table width="100%">
	<tr>
	<td valign="top" width="15%">
	<div class="leftColForm">
		<script type="text/javascript">
			$(document).ready(function(){
				var base_url = 'index.php?rule=product';
				// Load category products page when category is clicked
				$('#categories-treeview :input').live('click', function(){
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
		<h3>检索分类</h3>
				<?php
				$trads = array(
					 'Home' => '根分类', 
					 'selected' => '选择', 
					 'Collapse All' => '关闭', 
					 'Expand All' => '展开'
				);
				echo Helper::renderAdminCategorieTree($trads, array(Tools::getRequest('id_category')?Tools::getRequest('id_category'):1), 'categoryBox', true,'Tree');
			 ?>
		  <br>
		  <h3>检索品牌</h3>
		  <ul class="filetree">
		  <li><a href="?rule=product&id_category=<?php echo Tools::getRequest('id_category')?Tools::getRequest('id_category'):1;?>">
			<input type="radio" class="id_brands" name="id_brands" value="0" <?php if(Tools::getRequest('id_brand')==0){echo "checked";}?>/></a>所有品牌</li>
		  <?php
		  $brands = Brand::getEntity();
		  if($brands){
		  foreach($brands['entitys'] as $brand){
		  ?>
		  	<li><a href="?rule=product&id_category=<?php echo Tools::getRequest('id_category')?Tools::getRequest('id_category'):1;?>&id_brand=<?php echo $brand["id_brand"];?>">
			<input type="radio" class="id_brands" name="id_brands" value="<?php echo $brand["id_brand"];?>" <?php if(Tools::getRequest('id_brand')==$brand["id_brand"]){echo "checked";}?>/></a><?php echo $brand["name"];?></li>
		  <?php
		  }
		  }
		  ?>
		  </ul>
	 </div>
	</td>
	<td width="80%"><form class="form" method="post" action="index.php?rule=product">
	<table class="table_grid" name="list_table" width="100%">
	<tr>
	<td style="vertical-align: bottom;">
	<span style="float: left;">
		<?php
			echo Helper::renderAdminPagaNation($result['total'],$limit,$p,'productPage');
		?>
		| Display
		<select onchange="submit()" name="pagination">
				<option value="20" <?php if($limit==20){echo 'selected="selected"';}?>>20</option>
				<option value="50" <?php if($limit==50){echo 'selected="selected"';}?>>50</option>
				<option value="100" <?php if($limit==100){echo 'selected="selected"';}?>>100</option>
				<option value="300" <?php if($limit==300){echo 'selected="selected"';}?>>300</option>
		</select>
		/ <?php echo $result['total'];?> 条记录
	</span>
	<span style="float: right;">
		<input type="submit" class="button" value="检索" name="submitFilter" id="submitFilterButtonProduct">
		<input type="submit" class="button" value="重置" name="submitResetProduct">
	</span>
	</td>
	</tr>
	<tr><td>
	<div class="mianColForm">
		<table class="tableList table tableDnD" width="100%" cellpadding="0" cellspacing="0" id="product_category">
		<thead>
			<tr>
				<th><input type="checkbox" name="checkme" onclick="checkDelBoxes(this.form, 'productBox[]', this.checked)" ></th>
				<th>
					编号<br/>
					<a href="index.php?rule=product&productOrderBy=id_product&productOrderWay=desc" >
						<?php if(isset($orderBy) && $orderBy=='id_product' && isset($orderWay) && $orderWay=='desc'){ ?>
						<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
						<?php }else{ ?>
						<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
						<?php } ?>
					</a>
					<a href="index.php?rule=product&productOrderBy=id_product&productOrderWay=asc">
						<?php if(isset($orderBy) && $orderBy=='id_product' && isset($orderWay) && $orderWay=='asc'){ ?>
						<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
						<?php }else{ ?>
						<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
						<?php } ?>
					</a>
				</th>
				<th>图片</th>
				<th width="20%">
					产品名<br/>
					<a href="index.php?rule=product&productOrderBy=name&productOrderWay=desc">
						<?php if(isset($orderBy) && $orderBy=='name' && isset($orderWay) && $orderWay=='desc'){ ?>
						<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
						<?php }else{ ?>
						<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
						<?php } ?>
					</a> 
					<a href="index.php?rule=product&productOrderBy=name&productOrderWay=asc">
						<?php if(isset($orderBy) && $orderBy=='name' && isset($orderWay) && $orderWay=='asc'){ ?>
						<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
						<?php }else{ ?>
						<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
						<?php } ?>
				</th>
				<th>
					库存<br/>
					<a href="index.php?rule=product&productOrderBy=quantity&productOrderWay=desc">
						<?php if(isset($orderBy) && $orderBy=='quantity' && isset($orderWay) && $orderWay=='desc'){ ?>
						<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
						<?php }else{ ?>
						<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
						<?php } ?>
					</a> 
					<a href="index.php?rule=product&productOrderBy=quantity&productOrderWay=asc">
						<?php if(isset($orderBy) && $orderBy=='quantity' && isset($orderWay) && $orderWay=='asc'){ ?>
						<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
						<?php }else{ ?>
						<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
						<?php } ?>
				</th>
				<th>
					价格<br/>
					<a href="index.php?rule=product&productOrderBy=price&productOrderWay=desc">
						<?php if(isset($orderBy) && $orderBy=='price' && isset($orderWay) && $orderWay=='desc'){ ?>
						<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
						<?php }else{ ?>
						<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
						<?php } ?>
					</a> 
					<a href="index.php?rule=product&productOrderBy=price&productOrderWay=asc">
						<?php if(isset($orderBy) && $orderBy=='price' && isset($orderWay) && $orderWay=='asc'){ ?>
						<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
						<?php }else{ ?>
						<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
						<?php } ?>
				</th>
				<th>
					官方标价<br/>
					<a href="index.php?rule=product&productOrderBy=special_price&productOrderWay=desc">
						<?php if(isset($orderBy) && $orderBy=='special_price' && isset($orderWay) && $orderWay=='desc'){ ?>
						<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
						<?php }else{ ?>
						<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
						<?php } ?>
					</a> 
					<a href="index.php?rule=product&productOrderBy=special_price&productOrderWay=asc">
						<?php if(isset($orderBy) && $orderBy=='special_price' && isset($orderWay) && $orderWay=='asc'){ ?>
						<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
						<?php }else{ ?>
						<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
						<?php } ?>
				</th>
				<th width="20%">
					URL<br/>
					<a href="index.php?rule=product&productOrderBy=rewrite&productOrderWay=desc">
						<?php if(isset($orderBy) && $orderBy=='rewrite' && isset($orderWay) && $orderWay=='desc'){ ?>
						<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
						<?php }else{ ?>
						<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
						<?php } ?>
					</a> 
					<a href="index.php?rule=product&productOrderBy=rewrite&productOrderWay=asc">
						<?php if(isset($orderBy) && $orderBy=='rewrite' && isset($orderWay) && $orderWay=='asc'){ ?>
						<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
						<?php }else{ ?>
						<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
						<?php } ?>
					</a> 
				</th>
				<th>
					状态<br/>
					<a href="index.php?rule=product&productOrderBy=active&productOrderWay=desc">
						<?php if(isset($orderBy) && $orderBy=='active' && isset($orderWay) && $orderWay=='desc'){ ?>
						<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
						<?php }else{ ?>
						<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
						<?php } ?>
					</a> 
					<a href="index.php?rule=product&productOrderBy=active&productOrderWay=asc">
						<?php if(isset($orderBy) && $orderBy=='active' && isset($orderWay) && $orderWay=='asc'){ ?>
						<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
						<?php }else{ ?>
						<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
						<?php } ?>
					</a> 
				</th>
				<th>
					允许购买<br/>
					<a href="index.php?rule=product&productOrderBy=in_stock&productOrderWay=desc">
						<?php if(isset($orderBy) && $orderBy=='in_stock' && isset($orderWay) && $orderWay=='desc'){ ?>
						<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
						<?php }else{ ?>
						<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
						<?php } ?>
					</a> 
					<a href="index.php?rule=product&productOrderBy=in_stock&productOrderWay=asc">
						<?php if(isset($orderBy) && $orderBy=='in_stock' && isset($orderWay) && $orderWay=='asc'){ ?>
						<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
						<?php }else{ ?>
						<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
						<?php } ?>
					</a> 
				</th>
				<th>
					新产品<br/>
					<a href="index.php?rule=product&productOrderBy=is_new&productOrderWay=desc">
						<?php if(isset($orderBy) && $orderBy=='is_new' && isset($orderWay) && $orderWay=='desc'){ ?>
						<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
						<?php }else{ ?>
						<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
						<?php } ?>
					</a> 
					<a href="index.php?rule=product&productOrderBy=is_new&productOrderWay=asc">
						<?php if(isset($orderBy) && $orderBy=='is_new' && isset($orderWay) && $orderWay=='asc'){ ?>
						<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
						<?php }else{ ?>
						<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
						<?php } ?>
					</a> 
				</th>
				<th>
					热销品<br/>
					<a href="index.php?rule=product&productOrderBy=is_sale&productOrderWay=desc">
						<?php if(isset($orderBy) && $orderBy=='is_sale' && isset($orderWay) && $orderWay=='desc'){ ?>
						<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
						<?php }else{ ?>
						<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
						<?php } ?>
					</a> 
					<a href="index.php?rule=product&productOrderBy=is_sale&productOrderWay=asc">
						<?php if(isset($orderBy) && $orderBy=='is_sale' && isset($orderWay) && $orderWay=='asc'){ ?>
						<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
						<?php }else{ ?>
						<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
						<?php } ?>
					</a> 
				</th>
				<th>
					推荐<br/>
					<a href="index.php?rule=product&productOrderBy=is_top&productOrderWay=desc">
						<?php if(isset($orderBy) && $orderBy=='is_top' && isset($orderWay) && $orderWay=='desc'){ ?>
						<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
						<?php }else{ ?>
						<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
						<?php } ?>
					</a> 
					<a href="index.php?rule=product&productOrderBy=is_top&productOrderWay=asc">
						<?php if(isset($orderBy) && $orderBy=='is_top' && isset($orderWay) && $orderWay=='asc'){ ?>
						<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
						<?php }else{ ?>
						<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
						<?php } ?>
					</a> 
				</th>
				<th align="right" >操作</th>
			</tr>
			<tr style="height: 35px;" class="nodrag nodrop filter row_hover">
			  <td class="center"> -- </td>
			  <td class="center"><input type="text" style="width:30px" value="<?php echo isset($filter['id_product'])?$filter['id_product']:'';?>" name="productFilter_id_product" class="filter"></td>
			  <td class="center"> -- </td>
			  <td><input type="text" value="<?php echo isset($filter['name'])?$filter['name']:'';?>" name="productFilter_name" class="filter"></td>
			  <td class="center"> -- </td>
			  <td><input type="text" value="<?php echo isset($filter['price'])?$filter['price']:'';?>" name="productFilter_price" class="filter"></td>
			  <td><input type="text" value="<?php echo isset($filter['special_price'])?$filter['special_price']:'';?>" name="productFilter_special_price" class="filter"></td>
			  <td class="center"><input type="text" value="<?php echo isset($filter['rewrite'])?$filter['rewrite']:'';?>" name="productFilter_rewrite" class="filter"></td>
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
			  <td align="right">--</td>
			</tr>
		   </thead>
			<?php 
			if(is_array($result['entitys']) && count($result['entitys'])>0){
			foreach($result['entitys'] as $key => $row){?>
			<tr class="<?php echo ($key%2?'alt_row':''); ?> row" id="tr_<?php echo $row['id_product'].'_'.$row['id_category_default'];?>">
				<td><input type="checkbox" name="productBox[]" value="<?php echo $row['id_product'];?>" ></td>
				<td class="pointer" onclick="document.location = 'index.php?rule=product_edit&id=<?php echo $row['id_product'];?>'"><?php echo $row['id_product'];?></td>
				<td class="pointer" onclick="document.location = 'index.php?rule=product_edit&id=<?php echo $row['id_product'];?>'"><?php echo $row['id_image_default']?'<img src="'.$row['image_small'].'">':'--'?></td>
				<td class="pointer" onclick="document.location = 'index.php?rule=product_edit&id=<?php echo $row['id_product'];?>'"><?php echo $row['name'];?></td>
				<td class="pointer" onclick="document.location = 'index.php?rule=product_edit&id=<?php echo $row['id_product'];?>'"><?php echo $row['quantity'];?></td>
				<td><input type="text" name="change_price_<?php echo $row['id_product'];?>" value="<?php echo $row['price'];?>" class="price_value" size="10"/></td>
				<td><input type="text" name="change_special_price_<?php echo $row['id_product'];?>" value="<?php echo $row['special_price'];?>" class="special_price_value" size="10"/></td>
				<td class="pointer" onclick="document.location = 'index.php?rule=product_edit&id=<?php echo $row['id_product'];?>'"><?php echo $row['rewrite'];?></td>
				<td class="pointer">
				<img onclick="ajaxToggle(this,'active',<?php echo $row['id_product'];?>)" src="<?php echo $_tmconfig['ico_dir'].($row['active']?'enabled':'disabled');?>.gif" alt="<?php echo $row['active']?'开启':'关闭';?>"/></td>
				<td class="pointer">
				<img onclick="ajaxToggle(this,'in_stock',<?php echo $row['id_product'];?>)" src="<?php echo $_tmconfig['ico_dir'].($row['in_stock']?'enabled':'disabled');?>.gif" alt="<?php echo $row['in_stock']?'是':'否';?>"/></td>
				<td class="pointer">
				<img onclick="ajaxToggle(this,'is_new',<?php echo $row['id_product'];?>)" src="<?php echo $_tmconfig['ico_dir'].($row['is_new']?'enabled':'disabled');?>.gif" alt="<?php echo $row['is_new']?'是':'否';?>"/></a></td>
				<td class="pointer">
				<img onclick="ajaxToggle(this,'is_sale',<?php echo $row['id_product'];?>)" src="<?php echo $_tmconfig['ico_dir'].($row['is_sale']?'enabled':'disabled');?>.gif" alt="<?php echo $row['is_sale']?'是':'否';?>"/></a></td>
				<td class="pointer">
				<img onclick="ajaxToggle(this,'is_top',<?php echo $row['id_product'];?>)" src="<?php echo $_tmconfig['ico_dir'].($row['is_top']?'enabled':'disabled');?>.gif" alt="<?php echo $row['is_top']?'是':'否';?>"/></a></td>
				<td align="right">
					<a target="_blank" href="<?php echo Tools::getLink($row['rewrite']);?>"><img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>details.gif"></a> 
					<a href="index.php?rule=product_edit&id=<?php echo $row['id_product'];?>"><img alt="编辑" src="<?php echo $_tmconfig['ico_dir'];?>edit.gif"></a> 
					<a onclick="return confirm('你确定要删除？')" href="index.php?rule=product&delete=<?php echo $row['id_product'];?>"><img alt="删除" src="<?php echo $_tmconfig['ico_dir'];?>delete.gif"></a>
				</td>
			</tr>
			<?php }
				}else{
			?>
			<tr><td colspan="6" align="center">暂无内容</td></tr>
			<?php }?>
		</table>
	</div>
	</td></tr>
	<tr><td>
	<p>
		<input type="submit" onclick="return confirm('你确定要删除选中项目?');" value="批量删除" name="subDelete" class="button">
		<input type="submit" value="批量启用" name="subActiveON" class="button">
		<input type="submit" value="批量关闭" name="subActiveOFF" class="button">
	</p>
	</td></tr>
	</table>
	</form></td>
	</tr>
</table>
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