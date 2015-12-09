<?php

if(intval(Tools::getRequest('delete'))>0){
	$object = new Cart(intval(Tools::getRequest('delete')));
	if(Validate::isLoadedObject($object)){
		$object->delete();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		echo '<div class="conf">删除对象成功</div>';
	}
}elseif(Tools::isSubmit('subDelete')){
	$select_cat = Tools::getRequest('categoryBox');
	$cart	= new Cart();
		if($cart->deleteSelection($select_cat))
			echo '<div class="conf">删除对象成功</div>';

}elseif(intval(Tools::getRequest('toggleStatus'))>0){
	$object = new Cart(intval(Tools::getRequest('toggleStatus')));
	if(Validate::isLoadedObject($object)){
		$object->toggleStatus();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		echo '<div class="conf">更新对象状态成功</div>';
	}
}

$table = new UIAdminTable('cart',  'Cart', 'id_cart');
$table->header = array(
	array('sort' => false ,'isCheckAll' => 'orderBox[]'),
	array('name' => 'id_cart', 'title' => 'ID', 'width'=> '80px', 'filter' => 'string'),
	array('name' => 'name', 'title' => '用户', 'filter' => 'string'),
	array('sort' => false ,'name' => 'total_display', 'title' => '金额', 'width'=> '80px'),
	array('name' => 'carrier', 'title' => '物流', 'filter' => 'string'),
	array('sort' => 'shipping' ,'name' => 'shipping_display', 'title' => '运费'),
	array('sort' => 'status' ,'name' => 'status_label', 'title' => '状态', 'color' => true),
	array('name' => 'add_date', 'title' => '添加时间'),
	array('sort' => false , 'title' => '操作',  'class' => 'text-right',  'isAction'=> array( 'edit', 'delete')),
);
$filter = $table->initFilter();

$orderBy 	= isset($_GET['orderby']) ? Tools::G('orderby') : 'id_cart';
$orderWay 	= isset($_GET['orderway']) ? Tools::G('orderway') : 'desc';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::G('p') ? (Tools::G('p') == 0 ? 1 : Tools::G('p')) : 1;

$result  	= Cart::getEntity($p, $limit, $orderBy, $orderWay, $filter);

if (isset($errors)) {
	UIAdminAlerts::MError($errors);
}

$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '购物车', 'active' => true));
$bread = $breadcrumb->draw();
echo UIViewBlock::area(array('bread' => $bread), 'breadcrumb');
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				定单
			</div>
			<div class="panel-body">
			<form class="form" method="post" action="index.php?rule=cart">
				<?php
				//config table options
				$table->data = $result['entitys'];
				echo $table->draw();
				?>
				<div class="row">
					<div class="col-md-4">
						<div class="btn-group" role="group" >
							<button type="submit" class="btn btn-default" onclick="return confirm('你确定要删除选中项目?');" name="subDelete">批量删除</button>
							<button type="submit" class="btn btn-default" name="subActiveON">批量启用</button>
							<button type="submit" class="btn btn-default" name="subActiveOFF">批量关闭</button>
						</div>
					</div>
					<div class="col-md-6">
						<?php
						$pagination = new UIAdminPagination($result['total'],$limit);
						echo $pagination->draw();
						?>
					</div>
				</div>
			</form>
			</div>
		</div>
	</div>
</div>