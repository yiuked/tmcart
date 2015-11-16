<?php
$id 		= Tools::getRequest('id')?Tools::getRequest('id'):1;
$category 	= new Category($id);
$filter		= array();

if(intval(Tools::getRequest('delete'))>0){
	$object = new Category(intval(Tools::getRequest('delete')));
	if(Validate::isLoadedObject($object)){
		$object->delete();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		echo '<div class="conf">删除分类成功</div>';
	}
}elseif(Tools::isSubmit('subDelete')){
	$select_cat = Tools::getRequest('categoryBox');
	if(Validate::isLoadedObject($category) AND is_array($select_cat)){
		$category->deleteSelection($select_cat);
	}
	
	if(is_array($category->_errors) AND count($category->_errors)>0){
		$errors = $category->_errors;
	}else{
		echo '<div class="conf">删除分类成功</div>';
	}
}elseif(intval(Tools::getRequest('toggleStatus'))>0){
	$object = new Category(intval(Tools::getRequest('toggleStatus')));
	if(Validate::isLoadedObject($object)){
		$object->toggleStatus();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		echo '<div class="conf">更新分类状态成功</div>';
	}
}elseif(Tools::isSubmit('subActiveON') OR Tools::isSubmit('subActiveOFF')){
	$select_cat = Tools::getRequest('categoryBox');
	$action		= Tools::isSubmit('subActiveON')?1:0;
	$object		= new Category();
	if(is_array($select_cat)){
		if($object->statusSelection($select_cat,$action))
			echo '<div class="conf">更新分类状态成功</div>';
	}
}elseif (isset($_GET['position'])){
	if (!Validate::isLoadedObject($object = new Category((int)(Tools::getRequest('id_category_to_move')))))
		$errors[] = '无法输入对象';
	if (!$object->updatePosition((int)(Tools::getRequest('way')), (int)(Tools::getRequest('position'))))
		$errors[] = '更新排序失败';
	else {
		echo '<div class="conf">更新排序成功</div>';
	}
}

$table = new UIAdminDndTable('category',  'Category', 'id_category');
$table->parent = 'id_parent';
$table->child = true;
$table->header = array(
	array('sort' => false ,'isCheckAll' => 'categoryBox[]'),
	array('name' => 'id_category','title' => 'ID','filter' => 'string'),
	array('name' => 'name','title' => '名称','filter' => 'string'),
	array('name' => 'active','title' => '状态','filter' => 'bool'),
	array('name' => 'position','title' => '排序'),
	array('name' => 'add_date','title' => '添加时间'),
	array('sort' => false ,'title' => '操作', 'class' => 'text-right', 'isAction'=> array('view', 'edit', 'delete')),
);
$filter = $table->initFilter();

$orderBy 	= isset($_GET['orderby']) ? Tools::G('orderby') : 'position';
$orderWay 	= isset($_GET['orderway']) ? Tools::G('orderway') : 'asc';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::G('p') ? (Tools::G('p') == 0 ? 1 : Tools::G('p')) : 1;

$result  	= $category->getSubCategories(false,$limit,$p,$orderBy,$orderWay,$filter);
$catBar = $category->getCatBar($category->id);
krsort($catBar);
require_once(_TM_ADMIN_DIR_.'/errors.php');
?>
<script type="text/javascript" src="../js/jquery/jquery.tablednd_0_5.js"></script>
<script type="text/javascript">
	var token = '1f0af725a0585d7827c059999fd2d35e';
	var come_from = 'cms_category';
	var alternate = '0';
</script>
<script src="../js/admin/dnd.js" type="text/javascript"></script>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="col-md-6">
					<?php
					$breadcrumb = new UIAdminBreadcrumb();
					$breadcrumb->home();
					$breadcrumb->add(array('title' => '分类', 'active' => true));
					echo $breadcrumb->draw();
					?>
				</div>
				<div class="col-md-6">
					<?php if ((int)$id > 1){?>
					<div class="btn-group pull-right" role="group">
						<a href="index.php?rule=category&id=<?php echo $category->id_parent; ?>"  class="btn btn-primary"><span aria-hidden="true" class="glyphicon glyphicon-level-up"></span> 上级</a>
					</div>
					<?php }?>
					<div class="btn-group save-group pull-right" role="group">
						<a href="index.php?rule=category_edit"  class="btn btn-success" id="submit-form"><span aria-hidden="true" class="glyphicon glyphicon-plus"></span> 新分类</a>
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
			<?php
				$catalogPath = new UIAdminBreadcrumb();
				foreach ($catBar as $Bar) {
					if ($category->id == $Bar['id_category']) {
						$catalogPath->add(array('title' => $category->name, 'active' => true));
					} else {
						$catalogPath->add(array('href' => 'index.php?rule=category&id=' . $Bar['id_category'], 'title' => $Bar['name']));
					}
				}
				echo $catalogPath->draw();
			?>
			</div>
			<div class="panel-body">
				<form class="form-inline" method="post" action="<?php echo Helper::urlByRule(array('id' => $id)); ?>">
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