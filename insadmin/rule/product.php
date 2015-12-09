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

$table = new UIAdminTable('product',  'Product', 'id_product');
$table->header = array(
	array(
		'sort' => false ,
		'isCheckAll' => 'productBox[]',
	),
	array(
		'name' => 'id_product',
		'title' => 'ID',
		'width'=> '80px',
		'filter' => 'string'
	),
	array(
		'sort' => false ,
		'name' => 'image_small',
		'isImage' => true,
		'title' => '图片'
	),
	array(
		'name' => 'name',
		'title' => '名称',
		'filter' => 'string'
	),
	array(
		'name' => 'quantity',
		'title' => '库存'
	),
	array(
		'name' => 'price',
		'title' => '现价',
		'width'=> '80px',
		'filter' => 'string'
	),
	array(
		'name' => 'special_price',
		'title' => '原价',
		'width'=> '80px',
		'filter' => 'string'
	),
	array(
		'name' => 'active',
		'title' => '状态',
		'filter' => 'bool'
	),
	array(
		'name' => 'in_stock',
		'title' => '购买',
		'filter' => 'bool'
	),
	array(
		'name' => 'is_new',
		'title' => '新品',
		'filter' => 'bool'
	),
	array(
		'name' => 'is_sale',
		'title' => '热销',
		'filter' => 'bool'
	),
	array(
		'name' => 'is_top',
		'title' => '推荐',
		'filter' => 'bool'
	),
	array(
		'sort' => false ,
		'title' => '操作',
		'class' => 'text-right',
		'isAction'=> array('edit', 'view', 'delete')
	),
);
$filter = $table->initFilter();
$filter['id_category'] = isset($_GET['id_category'])?intval($_GET['id_category']):1;
if(isset($_GET['id_brand']))
	$filter['id_brand'] = intval($_GET['id_brand']);

$orderBy 	= isset($_GET['orderby']) ? Tools::G('orderby') : 'id_product';
$orderWay 	= isset($_GET['orderway']) ? Tools::G('orderway') : 'desc';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::G('p') ? (Tools::G('p') == 0 ? 1 : Tools::G('p')) : 1;

$result  	= Product::getProducts($p, $limit, $orderBy, $orderWay, $filter);
if (isset($errors)) {
	UIAdminAlerts::MError($errors);
}

//导航
$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '商品', 'active' => true));
$bread = $breadcrumb->draw();
$btn_group = array(
	array('type' => 'a', 'title' => '新产品', 'href' => 'index.php?rule=product_edit', 'class' => 'btn-success', 'icon' => 'plus')
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group, 'class' => 'col-md-10 col-md-offset-2'), 'breadcrumb');
?>

<div class="col-md-2 sidebar">
	<div class="panel panel-default">
		<div class="panel-body">
			<script type="text/javascript">
				$(document).ready(function(){
					var base_url = 'index.php?rule=product';
					// Load category products page when category is clicked
					$(document).on('click','#categories-treeview input', function(){
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
	</div>
</div>
<?php
//生成表格
$btn_groups = array(
	array('type' => 'button', 'title' => '删除选中', 'confirm' => '确定要删除选中项?', 'name' => 'subDelete', 'btn_type' => 'submit', 'class' => 'btn-default'),
	array('type' => 'button', 'title' => '激活选中',  'name' => 'subActiveON', 'btn_type' => 'submit', 'class' => 'btn-default'),
	array('type' => 'button', 'title' => '关闭选中',  'name' => 'subActiveOFF', 'btn_type' => 'submit', 'class' => 'btn-default'),
);
echo UIViewBlock::area(array('title' => '产品列表', 'table' => $table, 'result' => $result, 'limit' => $limit, 'btn_groups' => $btn_groups, 'class' => 'col-md-10 col-md-offset-2'), 'table');
?>