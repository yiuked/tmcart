<?php

if (intval(Tools::getRequest('delete'))>0 && Tools::getRequest('entity')=='group') {
	$object = new AttributeGroup(intval(Tools::getRequest('delete')));
	if(Validate::isLoadedObject($object)){
		$object->delete();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		echo '<div class="conf">删除对象成功</div>';
	}
} elseif(intval(Tools::getRequest('delete'))>0 && Tools::getRequest('entity')=='attribute') {
	$object = new Attribute(intval(Tools::getRequest('delete')));
	if(Validate::isLoadedObject($object)){
		$object->delete();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		echo '<div class="conf">删除对象成功</div>';
	}
} elseif(Tools::isSubmit('attributeDelete')) {
	$select_cat = Tools::getRequest('attribute');
	$attributegroup	= new Attribute();
		if($attributegroup->deleteSelection($select_cat))
			echo '<div class="conf">删除对象成功</div>';
}

$result  	= AttributeGroup::loadData();

if (isset($errors)) {
	UIAdminAlerts::MError($errors);
}

$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '属性', 'active' => true));
$bread = $breadcrumb->draw();

$btn_group = array(
	array('type' => 'a', 'title' => '添加属性组', 'href' => 'index.php?rule=attribute_group_edit', 'class' => 'btn-success', 'icon' => 'plus') ,
	array('type' => 'a', 'title' => '添加属值', 'id' => 'save-address', 'href' => 'index.php?rule=attribute_edit', 'class' => 'btn-success', 'icon' => 'plus') ,
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');
?>
<script type="text/javascript" src="<?php echo $_tmconfig['tm_js_dir']?>jquery/jquery.tablednd_0_5.js"></script>
<script src="<?php echo $_tmconfig['tm_js_dir']?>admin/dnd.js" type="text/javascript"></script>
<form class="form" method="post" action="index.php?rule=attribute_group">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">属性组</div>
				<div class="panel-body">
					<table class="table" width="100%" id="attributeGroup">
						<thead>
							<tr>
								<th>编号</th>
								<th width="80%">名称</th>
								<th>排序</th>
								<th class="text-right" >操作</th>
							</tr>
					   </thead>
					<?php
					if(is_array($result['itmes']) && count($result['itmes'])>0){
					foreach($result['itmes'] as $key => $row){
						$attributeGroup = new AttributeGroup($row['id_attribute_group']);
						$attributes = $attributeGroup->getAttributes();
					?>
					<tr id="tr_<?php echo $row['id_attribute_group'];?>">
						<td><?php echo $row['id_attribute_group'];?></td>
						<td><?php echo $row['name'];?> <span class="badge"><?php echo count($attributes); ?></span></td>
						<td><?php echo $row['position'];?></td>
						<td align="right">
							<div class="btn-group">
								<a href="index.php?rule=attribute_group_edit&id=<?php echo $row['id_attribute_group'];?>" class="btn btn-default" ><span class="glyphicon glyphicon-edit" title="编辑"></span> 编辑</a>
								<a href="index.php?rule=attribute_group&entity=group&delete=<?php echo $row['id_attribute_group'];?>" class="btn btn-default" onclick="return confirm(\'你确定要删除？\')"><span class="glyphicon glyphicon-trash" title="删除" aria-hidden="true"></span> 删除</a>
								<a data-toggle="collapse" href="#attribute_list_<?php echo $row['id_attribute_group'];?>" class="btn btn-default collapsed" ><span class="glyphicon glyphicon-plus" title="展开"></span> 展开</a>
							</div>
						</td>
					</tr>
					<?php
						if($attributes){
					?>
					<tr id="attribute_list_<?php echo $row['id_attribute_group'];?>" class="collapse"><td colspan="5">
						<table width="60%" class="table tableDnD" cellpadding="0" cellspacing="0" id="attribute_<?php echo $row['id_attribute_group'];?>">
							<thead>
							<tr>
								<th><input type="checkbox" name="checkme" data-name="attribute[]" class="check-all" ></th>
								<th>编号</th>
								<th width="80%">属性值</th>
								<th>排序</th>
								<th class="text-right" >操作</th>
							</tr>
							</thead>
						  <?php foreach($attributes as $key => $row){ ?>
						  <tr id="tr_<?php echo $row['id_attribute_group'].'_'.$row['id_attribute'].'_'.(int)$row['position'];?>">
								<td><input type="checkbox" name="attribute[]" value="<?php echo $row['id_attribute'];?>" ></td>
								<td><?php echo $row['id_attribute'];?></td>
								<td><?php echo $row['name'];?></td>
								<td class="pointer dragHandle center" id="td_<?php echo $row['id_attribute'];?>">
								<a href="index.php?rule=attribute_group&id_attribute=<?php echo $row['id_attribute'];?>&way=1&position=<?php echo $row['position']+1;?>" <?php if($key+1==count($attributes)){ echo 'style="display:none"'; }?>>
								<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down.gif"></a>
								<a href="index.php?rule=attribute_group&id_attribute=<?php echo $row['id_attribute'];?>&way=0&position=<?php echo $row['position']-1;?>" <?php if($key==0){ echo 'style="display:none"'; }?>>
									<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up.gif"></a>
								</td>
								<td align="right">
									<div class="btn-group">
										<a href="index.php?rule=attribute_edit&id=<?php echo $row['id_attribute'];?>" class="btn btn-default" ><span class="glyphicon glyphicon-edit" title="编辑"></span> 编辑</a>
										<a href="index.php?rule=attribute_group&entity=attribute&delete=<?php echo $row['id_attribute'];?>" class="btn btn-default" onclick="return confirm(\'你确定要删除？\')"><span class="glyphicon glyphicon-trash" title="删除" aria-hidden="true"></span> 删除</a>
									</div>
								</td>
						  </tr>
						  <?php }?>
						</table>
							<button type="button" onclick="return confirm('你确定要删除选中项目?');"  name="attributeDelete" class="btn btn-danger">
								<span aria-hidden="true" class="glyphicon glyphicon-minus"></span> 删除选中属性</button>
						</td>
					</tr>
					<?php }?>
			<?php }
				}else{
			?>
			<tr><td colspan="5" align="center">暂无分类</td></tr>
			<?php }?>
		</table>
				</div>
			</div>
		</div>
	</div>
</form>