<?php

if(intval(Tools::getRequest('delete'))>0){
	$object = new ImageType(intval(Tools::getRequest('delete')));
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
	$image_type	= new ImageType();
		if($image_type->deleteSelection($select_cat))
			echo '<div class="conf">删除对象成功</div>';

}elseif(intval(Tools::getRequest('toggleStatus'))>0){
	$object = new ImageType(intval(Tools::getRequest('toggleStatus')));
	if(Validate::isLoadedObject($object)){
		$object->toggleStatus();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		echo '<div class="conf">更新对象状态成功</div>';
	}
}

$filter	 = $cookie->getFilter('image_type',array('id_image_type','name','height','width','type'));
if(Tools::isSubmit('submitResetImageType')){
	$cookie->unsetFilter('image_type',array('id_image_type','name','height','width','type'));
	$filter = array();
}

$orderBy 	= $cookie->getPost('imageTypeOrderBy') ? $cookie->getPost('imageTypeOrderBy') : 'id_image_type';
$orderWay 	= $cookie->getPost('imageTypeOrderWay') ? $cookie->getPost('imageTypeOrderWay') : 'ASC';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::getRequest('imageTypePage') ? Tools::getRequest('imageTypePage'):1;

$result  	= ImageType::getEntity(false,$p,$limit,$orderBy,$orderWay,$filter);

require_once(dirname(__FILE__).'/../errors.php');
?>
<script type="text/javascript" src="../js/jquery/jquery.tablednd_0_5.js"></script>
<script type="text/javascript">
	var token = '1f0af725a0585d7827c059999fd2d35e';
	var come_from = 'image_type';
	var alternate = '0';
</script>
<script src="../js/admin/dnd.js" type="text/javascript"></script>
<div class="path_bar">
	<div class="path_title">
		<h3> 
			<span style="font-weight: normal;" id="current_obj">
			<span class="breadcrumb item-1 ">图片配置</span> 
		</h3>
		<div class="cc_button">
		<ul>
        <li><a title="添加图片配置" href="index.php?rule=image_type_edit" class="toolbar_btn" id="add_image_type">
				<span class="process-icon-new "></span>
				<div>添加图片配置</div>
			</a></li>
      </ul>
		</div>
	</div>
</div>
<form class="form" method="post" action="index.php?rule=image_type">
<table class="table_grid" name="list_table" width="100%">
<tr>
<td style="vertical-align: bottom;">
<span style="float: left;">
	<?php
		echo Helper::renderAdminPagaNation($result['total'],$limit,$p,'image_typePage');
	?>
	| Display
	<select onchange="submit()" name="pagination">
			<option value="20" <?php if($limit==20){echo 'selected="selected"';}?>>20</option>
			<option value="50" <?php if($limit==50){echo 'selected="selected"';}?>>50</option>
			<option value="100" <?php if($limit==100){echo 'selected="selected"';}?>>100</option>
			<option value="300" <?php if($limit==300){echo 'selected="selected"';}?>>300</option>
	</select>
	/ <?php echo $result['total'];?> 条记录
</span>
<span style="float: right;">
	<input type="submit" class="button" value="检索" name="submitFilter" id="submitFilterButton">
	<input type="submit" class="button" value="重置" name="submitResetcategory">
</span>
</td>
</tr>
<tr><td>
<div class="mianColForm">
	<table class="tableList table tableDnD" width="100%" cellpadding="0" cellspacing="0" id="image_type">
	<thead>
		<tr>
			<th><input type="checkbox" name="checkme" onclick="checkDelBoxes(this.form, 'categoryBox[]', this.checked)" ></th>
			<th>
				编号
				<a href="index.php?rule=image_type&imageTypeOrderBy=id_image_type&imageTypeOrderWay=desc" >
					<?php if(isset($orderBy) && $orderBy=='id_image_type' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a>
				<a href="index.php?rule=image_type&imageTypeOrderBy=id_image_type&imageTypeOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='id_image_type' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
				</a>
			</th>
			<th>
				名称
				<a href="index.php?rule=image_type&imageTypeOrderBy=name&imageTypeOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='name' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=image_type&imageTypeOrderBy=name&imageTypeOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='name' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
			</th>
			<th>
				高
				<a href="index.php?rule=image_type&imageTypeOrderBy=height&imageTypeOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='height' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=image_type&imageTypeOrderBy=height&imageTypeOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='height' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
				</a>
			</th>
			<th>
				宽
				<a href="index.php?rule=image_type&imageTypeOrderBy=width&imageTypeOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='width' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=image_type&imageTypeOrderBy=width&imageTypeOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='width' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
				</a> 
			</th>
			<th>
			应用
				<a href="index.php?rule=image_type&imageTypeOrderBy=type&imageTypeOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='type' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=image_type&imageTypeOrderBy=type&imageTypeOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='type' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
				</a> 
			</th>
			<th align="right" >操作</th>
		</tr>
		<tr style="height: 35px;" class="nodrag nodrop filter row_hover">
		  <td class="center"> -- </td>
		  <td class="center"><input type="text" style="width:40px" value="<?php echo isset($filter['id_image_type'])?$filter['id_image_type']:'';?>" name="image_typeFilter_id_image_type" class="filter"></td>
		  <td><input type="text" value="<?php echo isset($filter['name'])?$filter['name']:'';?>" name="image_typeFilter_name" class="filter"></td>
		  <td class="center"><input type="text" value="<?php echo isset($filter['logo'])?$filter['logo']:'';?>" name="image_typeFilter_logo" class="filter"></td>
		  <td class="center"><input type="text" value="<?php echo isset($filter['description'])?$filter['description']:'';?>" name="image_typeFilter_description" class="filter"></td>
		  <td class="center"><input type="text" value="<?php echo isset($filter['shipping'])?$filter['shipping']:'';?>" name="image_typeFilter_shipping" class="filter"></td>
		  <td align="right">--</td>
		</tr>
	   </thead>
		<?php 
		if(is_array($result['entitys']) && count($result['entitys'])>0){
		foreach($result['entitys'] as $key => $row){?>
		<tr class="<?php echo ($key%2?'alt_row':''); ?> row" id="tr_<?php echo $row['id_image_type'];?>">
			<td><input type="checkbox" name="categoryBox[]" value="<?php echo $row['id_image_type'];?>" ></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=image_type_edit&id=<?php echo $row['id_image_type'];?>'"><?php echo $row['id_image_type'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=image_type_edit&id=<?php echo $row['id_image_type'];?>'"><?php echo $row['name'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=image_type_edit&id=<?php echo $row['id_image_type'];?>'"><?php echo $row['height'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=image_type_edit&id=<?php echo $row['id_image_type'];?>'"><?php echo $row['width'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=image_type_edit&id=<?php echo $row['id_image_type'];?>'"><?php echo $row['type'];?></td>
			<td align="right">
				<a href="index.php?rule=image_type_edit&id=<?php echo $row['id_image_type'];?>"><img alt="编辑" src="<?php echo $_tmconfig['ico_dir'];?>edit.gif"></a> 
				<a onclick="return confirm('你确定要删除？')" href="index.php?rule=image_type&delete=<?php echo $row['id_image_type'];?>"><img alt="删除" src="<?php echo $_tmconfig['ico_dir'];?>delete.gif"></a>
			</td>
		</tr>
		<?php }
			}else{
		?>
		<tr><td colspan="8" align="center">暂无图片配置</td></tr>
		<?php }?>
	</table>
</div>
</td></tr>
<tr><td>
<p><input type="submit" onclick="return confirm('你确定要删除选中项目?');" value="删除选中项目" name="subDelete" class="button"></p>
</td></tr>
</table>
</form>
