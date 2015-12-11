<?php
$id_cms_category 	= Tools::G('id_cms_category',1);
$category 			= new CMSCategory($id_cms_category);
$filter		= array();

if(intval(Tools::G('delete'))>0){
	$object = new CMS(intval(Tools::G('delete')));
	if(Validate::isLoadedObject($object)){
		$object->delete();
	}
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		UIAdminAlerts::conf('文章已删除');
	}
}elseif(Tools::isSubmit('subDelete')){
	$select_cat = Tools::getRequest('cmsBox');
	$cms		= new CMS();
	if(is_array($select_cat)){
		if($cms->deleteSelection($select_cat))
			UIAdminAlerts::conf('文章已删除');
	}
}elseif(Tools::isSubmit('subActiveON') OR Tools::isSubmit('subActiveOFF')){
	$select_cat = Tools::P('itemBox');
	$action		= Tools::isSubmit('subActiveON')?1:0;
	$object		= new CMS();
	if(is_array($select_cat)){
		if($object->statusSelection($select_cat,$action))
			UIAdminAlerts::conf('文章已更新');
	}
}

$table = new UIAdminTable('cms',  'CMS', 'id_cms');
$table->header = array(
	array(
		'sort' => false ,
		'isCheckAll' => 'itemBox[]',
	),
	array(
		'name' => 'id_cms',
		'title' => 'ID',
		'filter' => 'string'
	),
	array(
		'name' => 'title',
		'title' => '名称',
		'filter' => 'string'
	),
	array(
		'name' => 'rewrite',
		'title' => '静态链接',
		'filter' => 'string'
	),
	array(
		'name' => 'active',
		'title' => '状态',
		'filter' => 'bool'
	),
	array(
		'name' => 'is_top',
		'title' => '置顶',
		'filter' => 'bool'
	),
	array(
		'name' => 'add_date',
		'title' => '添加时间',
	),
	array(
		'sort' => false ,
		'title' => '操作',
		'class' => 'text-right',
		'isAction'=> array('edit', 'view', 'delete')
	),
);

$filter = $table->initFilter();
$filter['id_cms_category'] = isset($_GET['id_cms_category']) ? intval($_GET['id_cms_category']) : 1;
$orderBy 	= isset($_GET['orderby']) ? Tools::G('orderby') : 'id_cms';
$orderWay 	= isset($_GET['orderway']) ? Tools::G('orderway') : 'desc';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::G('p') ? (Tools::G('p') == 0 ? 1 : Tools::G('p')) : 1;

$result  	= CMS::getCMS($p, $limit, $orderBy, $orderWay, $filter);

//导航
$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => 'CMS', 'active' => true));
$bread = $breadcrumb->draw();
$btn_group = array();
$btn_group[] = array('type' => 'a', 'title' => '新文章', 'href' => 'index.php?rule=cms_edit', 'class' => 'btn-success', 'icon' => 'plus');
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group, 'class' => 'col-md-10 col-md-offset-2'), 'breadcrumb');

if (isset($errors)) {
	UIAdminAlerts::MError($errors);
}
?>
<div class="row">
	<div class="col-md-2 sidebar">
		<div class="panel panel-default">
			<div class="panel-heading">检索分类</div>
			<div class="panel-body">
			<script type="text/javascript">
				$(document).ready(function(){
					var base_url = 'index.php?rule=cms';
					// Load category products page when category is clicked
					$(document).on('click','#categories-treeview input', function(){
						if (this.value !== "")
							location.href = base_url + '&id_cms_category=' + parseInt(this.value);
						else
							location.href = base_url;
					});
				});
			</script>
			<?php
				$trads = array(
					 'Home' => '根分类',
					 'selected' => '选择',
					 'Collapse All' => '关闭',
					 'Expand All' => '展开'
				);
				echo Helper::renderAdminCategorieTree($trads, array(Tools::getRequest('id_cms_category')?Tools::getRequest('id_cms_category'):1), 'categoryBox', true,'CMSTree');
			 ?>
		 </div>
		</div>
	</div>
</div>
<?php
$btn_group = array(
	array('type' => 'button', 'title' => '删除选中','confirm' => '确定要删除选中项?', 'name' => 'subDelete', 'btn_type' => 'submit', 'class' => 'btn-danger') ,
	array('type' => 'button', 'title' => '激活选中', 'name' => 'subActiveON',  'btn_type' => 'submit','class' => 'btn-default') ,
	array('type' => 'button', 'title' => '关闭选中', 'name' => 'subActiveOFF', 'btn_type' => 'submit', 'class' => 'btn-default') ,
);
echo UIViewBlock::area(array('title' => '文章', 'table' => $table, 'class' => 'col-md-10 col-md-offset-2', 'result' => $result, 'btn_groups' => $btn_group), 'table');
?>
