<?php

if(intval(Tools::getRequest('delete'))>0){
	$object = new Order(intval(Tools::getRequest('delete')));
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
	$order	= new Order();
		if($order->deleteSelection($select_cat))
			echo '<div class="conf">删除对象成功</div>';

}elseif(intval(Tools::getRequest('toggleStatus'))>0){
	$object = new Order(intval(Tools::getRequest('toggleStatus')));
	if(Validate::isLoadedObject($object)){
		$object->toggleStatus();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		echo '<div class="conf">更新对象状态成功</div>';
	}
}

$table = new UIAdminTable('order',  'Order', 'id_order');
$table->header = array(
	array('sort' => false ,'isCheckAll' => 'orderBox[]'),
	array('name' => 'id_order', 'title' => 'ID', 'width'=> '80px', 'filter' => 'string'),
	array('name' => 'reference', 'title' => '引用', 'width'=> '110px', 'filter' => 'string'),
	array('name' => 'name', 'title' => '用户', 'filter' => 'string'),
	array('name' => 'amount', 'title' => '金额', 'width'=> '80px', 'filter' => 'string'),
	array('name' => 'carrier', 'title' => '物流', 'filter' => 'string'),
	array('name' => 'payment', 'title' => '支付', 'filter' => 'string'),
	array('name' => 'status', 'title' => '状态', 'filter' => 'string', 'color' => true),
	array('name' => 'add_date', 'title' => '添加时间'),
	array('sort' => false , 'title' => '操作',  'class' => 'text-right',  'isAction'=> array( 'edit', 'delete')),
);
$filter = $table->initFilter();

$orderBy 	= isset($_GET['orderby']) ? Tools::G('orderby') : 'id_order';
$orderWay 	= isset($_GET['orderway']) ? Tools::G('orderway') : 'desc';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::G('p') ? (Tools::G('p') == 0 ? 1 : Tools::G('p')) : 1;

$result  	= Order::getEntity(false,$p,$limit,$orderBy,$orderWay,$filter);

if (isset($errors)) {
	UIAdminAlerts::MError($errors);
}
?>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="col-md-6">
					<?php
					$breadcrumb = new UIAdminBreadcrumb();
					$breadcrumb->home();
					$breadcrumb->add(array('title' => '定单', 'active' => true));
					echo $breadcrumb->draw();
					?>
				</div>
				<div class="col-md-6">
					<div class="btn-group save-group pull-right" role="group">
						<a href="index.php?rule=sendorder"  class="btn btn-success" id="submit-form"><span aria-hidden="true" class="glyphicon glyphicon-wrench"></span>定单提交配置</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				定单
			</div>
			<div class="panel-body">
				<form class="form" method="post" action="<?php echo Helper::urlByRule()?>">
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