<?php

if(intval(Tools::getRequest('delete'))>0){
	$object = new Brand(intval(Tools::getRequest('delete')));
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
	$brand	= new Brand();
		if($brand->deleteSelection($select_cat))
			echo '<div class="conf">删除对象成功</div>';

}elseif(intval(Tools::getRequest('toggleStatus'))>0){
	$object = new Brand(intval(Tools::getRequest('toggleStatus')));
	if(Validate::isLoadedObject($object)){
		$object->toggleStatus();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		echo '<div class="conf">更新对象状态成功</div>';
	}
}

$table = new UIAdminTable('brand',  'Brand', 'id_brand');
$table->header = array(
	array('sort' => false ,'isCheckAll' => 'brandBox[]'),
	array('name' => 'id_brand','title' => 'ID','filter' => 'string'),
	array('sort' => false ,'name' => 'image_small','isImage' => true,'title' => '图片'),
	array('name' => 'name','title' => '名称','filter' => 'string'),
	array('name' => 'active','title' => '状态','filter' => 'bool'),
	array('sort' => false ,'title' => '操作', 'class' => 'text-right', 'isAction'=> array('edit', 'view', 'delete')),
);
$filter = $table->initFilter();

$orderBy 	= isset($_GET['orderby']) ? Tools::G('orderby') : 'id_brand';
$orderWay 	= isset($_GET['orderway']) ? Tools::G('orderway') : 'asc';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::G('p') ? (Tools::G('p') == 0 ? 1 : Tools::G('p')) : 1;

$result  	= Brand::getEntity($p, $limit, $orderBy, $orderWay, $filter);

require_once(dirname(__FILE__).'/../errors.php');
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="col-md-6">
					<?php
					$breadcrumb = new UIAdminBreadcrumb();
					$breadcrumb->home();
					$breadcrumb->add(array('title' => '品牌', 'active' => true));
					echo $breadcrumb->draw();
					?>
				</div>
				<div class="col-md-6">
					<div class="btn-group save-group pull-right" role="group">
						<a href="index.php?rule=brand_edit"  class="btn btn-success" id="submit-form"><span aria-hidden="true" class="glyphicon glyphicon-plus"></span> 新品牌</a>
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
				品牌
			</div>
			<div class="panel-body">
				<form class="form-inline" method="post" action="index.php?rule=brand">
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