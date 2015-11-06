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

$filter	 = $cookie->getFilter('category',array('id_category','name','rewrite','active'));
if(Tools::isSubmit('submitResetcategory')){
	$cookie->unsetFilter('category',array('id_category','name','rewrite','active'));
	$filter = array();
}

$orderBy 	= $cookie->getPost('categoryOrderBy') ? $cookie->getPost('categoryOrderBy') : 'id_category';
$orderWay 	= $cookie->getPost('categoryOrderWay') ? $cookie->getPost('categoryOrderWay') : 'ASC';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '20';
$p			= Tools::getRequest('employeePage') ? (Tools::getRequest('employeePage')==0?1:Tools::getRequest('employeePage')):1;


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
					echo AdminBreadcrumb::getInstance()->home()
						->add(array('title' => '分类', 'active' => true))
						->generate();
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
				$breadcrumb = AdminBreadcrumb::getInstance();
				foreach ($catBar as $Bar) {
					if ($category->id == $Bar['id_category']) {
						$breadcrumb->add(array('title' => $category->name, 'active' => true));
					} else {
						$breadcrumb->add(array('href' => 'index.php?rule=category&id=' . $Bar['id_category'], 'title' => $Bar['name']));
					}
				}
				echo $breadcrumb->generate();
			?>
			</div>
			<div class="panel-body">
				<form class="form" method="post" action="index.php?rule=category&id=<?php echo $id; ?>">
					<table class="table tableDnD" id="category">
						<thead>
						<tr>
							<th><input type="checkbox" name="checkme" class="check-all" data-name="categoryBox[]" ></th>
							<th>
								<a href="index.php?rule=category&categoryOrderBy=id_category&categoryOrderWay=desc" >
									<span aria-hidden="true" class="glyphicon glyphicon-sort-by-order-alt"></span>
								</a>
								编号
								<a href="index.php?rule=category&categoryOrderBy=id_category&categoryOrderWay=asc">
									<span aria-hidden="true" class="glyphicon glyphicon-sort-by-order"></span>
								</a>
							</th>
							<th>
								<a href="index.php?rule=category&categoryOrderBy=name&categoryOrderWay=desc">
									<span aria-hidden="true" class="glyphicon glyphicon-sort-by-order-alt"></span>
								</a>
								名称
								<a href="index.php?rule=category&categoryOrderBy=name&categoryOrderWay=asc">
									<span aria-hidden="true" class="glyphicon glyphicon-sort-by-order"></span>
								</a>
							</th>
							<th>
								<a href="index.php?rule=category&categoryOrderBy=active&categoryOrderWay=desc">
									<span aria-hidden="true" class="glyphicon glyphicon-sort-by-order-alt"></span>
								</a>
								状态
								<a href="index.php?rule=category&categoryOrderBy=active&categoryOrderWay=asc">
									<span aria-hidden="true" class="glyphicon glyphicon-sort-by-order"></span>
								</a>
							</th>
							<th>
								<a href="index.php?rule=category&categoryOrderBy=position&categoryOrderWay=desc">
									<span aria-hidden="true" class="glyphicon glyphicon-sort-by-order-alt"></span>
								</a>
								排序
								<a href="index.php?rule=category&categoryOrderBy=position&categoryOrderWay=asc">
									<span aria-hidden="true" class="glyphicon glyphicon-sort-by-order"></span>
								</a>
							</th>
							<th class="text-right" >操作</th>
						</tr>
						<tr style="height: 35px;" class="nodrag nodrop filter row_hover">
						  <td class="center"> -- </td>
						  <td class="center"><input type="text" style="width:40px" value="<?php echo isset($filter['id_category'])?$filter['id_category']:'';?>" name="categoryFilter_id_category" class="filter"></td>
						  <td><input type="text" style="width:300px" value="<?php echo isset($filter['name'])?$filter['name']:'';?>" name="categoryFilter_name" class="filter"></td>
						  <td class="center">
							<select name="categoryFilter_active" onChange="$('#submitFilterButtoncategory').focus();$('#submitFilterButtoncategory').click();">
							  <option value="">--</option>
							  <option value="1" <?php if(isset($filter['active']) && $filter['active']==1){echo "selected";}?>>Yes</option>
							  <option value="2" <?php if(isset($filter['active']) && $filter['active']==2){echo "selected";}?>>No</option>
							</select>
						  </td>
						  <td>--</td>
						  <td align="right">
							  <div class="btn-group" role="group">
								  <button class="btn btn-primary btn-xs" type="submit" name="submitFilter" id="submitFilterButtoncategory">查询</button>
								  <button type="submit" class="btn btn-default btn-xs" name="submitResetcategory">重置</button>
							  </div>
						  </td>
						</tr>
						</thead>
						<tbody>
						<?php
						if(is_array($result['entitys']) && count($result['entitys'])>0){
						foreach($result['entitys'] as $key => $row){?>
						<tr id="tr_<?php echo $row['id_parent'].'_'.$row['id_category'].'_'.$row['position'];?>">
							<td><input type="checkbox" name="categoryBox[]" value="<?php echo $row['id_category'];?>" ></td>
							<td class="pointer" onclick="document.location = 'index.php?rule=category&id=<?php echo $row['id_category'];?>'"><?php echo $row['id_category'];?></td>
							<td class="pointer" onclick="document.location = 'index.php?rule=category&id=<?php echo $row['id_category'];?>'"><?php echo $row['name'];?></td>
							<td>
								<span onclick="setToggle($(this),'Category','active',<?php echo $row['id_category'];?>)" class="glyphicon glyphicon-<?php echo ($row['active']?'ok':'remove');?> active-toggle"></span>
							</td>
							<td class="pointer dragHandle center" id="td_<?php echo $row['id_parent'].'_'.$row['id_category'];?>">
									<a href="index.php?rule=category&id_category_parent=<?php echo $row['id_parent'];?>&id_category_to_move=<?php echo $row['id_category'];?>&way=1&position=<?php echo $row['position']+1;?>" <?php if($key+1==$result['total']){ echo 'style="display:none"'; }?>>
										<span aria-hidden="true" class="glyphicon glyphicon-triangle-bottom"></span>
									<a href="index.php?rule=category&id_category_parent=<?php echo $row['id_parent'];?>&id_category_to_move=<?php echo $row['id_category'];?>&way=0&position=<?php echo $row['position']-1;?>" <?php if($key==0){ echo 'style="display:none"'; }?>>
										<span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span>
							</td>
							<td align="right">
								<div class="btn-group">
									<a target="_blank" href="<?php echo Tools::getLink($row['rewrite']);?>" class="btn btn-default"><span aria-hidden="true" title="预览" class="glyphicon glyphicon-file"></span></a>
									<a href="index.php?rule=category_edit&id=<?php echo $row['id_category'];?>" class="btn btn-default"><span aria-hidden="true" title="编辑" class="glyphicon glyphicon-edit"></span></a>
									<a onclick="return confirm('你确定要删除？')" href="index.php?rule=category&delete=<?php echo $row['id_category'];?>" class="btn btn-default"><span aria-hidden="true" title="删除"  class="glyphicon glyphicon-trash"></span></a>
								</div>
							</td>
						</tr>
						<?php }
							}else{
						?>
						<tr><td colspan="6" align="center">暂无分类</td></tr>
						<?php }?>
						</tbody>
					</table>

					<div class="row">
						<div class="col-md-4">
							<div class="btn-group" role="group" >
								<button type="submit" class="btn btn-default" onclick="return confirm('你确定要删除选中项目?');" name="subDelete">批量删除</button>
								<button type="submit" class="btn btn-default" name="subActiveON">批量启用</button>
								<button type="submit" class="btn btn-default" name="subActiveOFF">批量关闭</button>
							</div>
						</div>
						<div class="col-md-6">
							<nav class="page-number">
								<div class="pull-left">
									<span class="page-number-title pull-left">共 <strong><?php echo $result['total'];?></strong> 个分类,每页显示</span>
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
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>