<?php
if(intval(Tools::getRequest('delete'))>0){
	$object = new Color(intval(Tools::getRequest('delete')));
	if(Validate::isLoadedObject($object)){
		$object->delete();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		echo '<div class="conf">删除颜色成功</div>';
	}
}elseif(Tools::isSubmit('subDelete')){
	$select_cat = Tools::getRequest('categoryBox');
	$color	= new Color();
	if($color->deleteSelection($select_cat)){
		echo '<div class="conf">删除管理员成功</div>';
	}
}

$table = new UIAdminDndTable('color',  'Color', 'id_color');
$table->header = array(
	array('sort' => false ,'isCheckAll' => 'colorBox[]'),
	array('name' => 'id_color','title' => 'ID'),
	array('name' => 'name','title' => '名称'),
	array('name' => 'code','title' => '颜色','color' => true),
	array('name' => 'position','title' => '排序'),
	array('sort' => false ,'title' => '操作', 'class' => 'text-right', 'isAction'=> array('view', 'edit', 'delete')),
);
$result = Color::getEntitys();

require_once(dirname(__FILE__).'/../errors.php');
?>
<script type="text/javascript" src="../js/jquery/jquery.tablednd_0_5.js"></script>
<script src="../js/admin/dnd.js" type="text/javascript"></script>
<?php
$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '颜色', 'active' => true));
$bread = $breadcrumb->draw();

$btn_group = array(
	array('type' => 'a', 'title' => '取消颜色', 'href' => 'index.php?rule=color_cannel_product', 'class' => 'btn-primary', 'icon' => 'level-up') ,
	array('type' => 'a', 'title' => '产品颜色', 'href' => 'index.php?rule=color_product', 'class' => 'btn-primary', 'icon' => 'level-up') ,
	array('type' => 'a', 'title' => '新颜色', 'href' => 'index.php?rule=color_edit', 'class' => 'btn-success', 'icon' => 'plus') ,
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				颜色
			</div>
			<div class="panel-body">
				<form class="form" method="post" action="index.php?rule=color">
					<?php
					$table->data = $result;
					echo $table->draw();
					?>
				</form>
			</div>
		</div>
	</div>
</div>
