<?php

if(intval(Tools::getRequest('delete'))>0){
	$object = new Feedback(intval(Tools::getRequest('delete')));
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
	$feedbacks	= new Feedback();
		if($feedbacks->deleteSelection($select_cat))
			echo '<div class="conf">删除对象成功</div>';

}elseif(Tools::isSubmit('subShowProductPage')){
	$select_cat = Tools::getRequest('categoryBox');
	$feedbacks	= new Feedback();
		if($feedbacks->statusSelection($select_cat,true))
			echo '<div class="conf">启用对象成功</div>';

}

$table = new UIAdminDndTable('feedback',  'Feedback', 'id_feedback');
$table->parent = 'id_parent';
$table->child = true;
$table->header = array(
	array('sort' => false ,'isCheckAll' => 'categoryBox[]'),
	array('name' => 'name','title' => 'ID','filter' => 'string'),
	array('name' => 'flag_code','title' => '国家','filter' => 'string'),
	array('name' => 'id_product','title' => '产品ID','filter' => 'bool'),
	array('name' => 'rating','title' => '评分','filter' => 'bool'),
	array('name' => 'feedback','title' => '内容'),
	array('name' => 'add_date','title' => '时间'),
	array('sort' => false ,'title' => '操作', 'class' => 'text-right', 'isAction'=> array('view', 'edit', 'delete')),
);
$filter = $table->initFilter();
$orderBy 	= isset($_GET['orderby']) ? Tools::G('orderby') : 'position';
$orderWay 	= isset($_GET['orderway']) ? Tools::G('orderway') : 'asc';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::G('p') ? (Tools::G('p') == 0 ? 1 : Tools::G('p')) : 1;

$result  	= Feedback::getEntity(false,$p,$limit,$orderBy,$orderWay,$filter);

require_once(dirname(__FILE__).'/../errors.php');
?>
<?php
$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '客户反馈', 'active' => true));
$bread = $breadcrumb->draw();

$btn_group = array(
	array('type' => 'a', 'title' => '批量导入', 'href' => 'index.php?rule=feedback_import', 'class' => 'btn-primary', 'icon' => 'random') ,
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				反馈列表
			</div>
			<div class="panel-body">
				<form class="form-inline" method="post" action="index.php?rule=feedback">
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