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

$filter	 = $cookie->getFilter('brand',array('id_brand','name','logo','descriptoin'));
if(Tools::isSubmit('submitResetBrand')){
	$cookie->unsetFilter('brand',array('id_brand','name','logo','descriptoin'));
	$filter = array();
}

$orderBy 	= $cookie->getPost('brandOrderBy') ? $cookie->getPost('brandOrderBy') : 'id_brand';
$orderWay 	= $cookie->getPost('brandOrderWay') ? $cookie->getPost('brandOrderWay') : 'ASC';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::getRequest('brandPage') ? Tools::getRequest('brandPage'):1;

$result  	= Brand::getEntity(false,$p,$limit,$orderBy,$orderWay,$filter);

require_once(dirname(__FILE__).'/../errors.php');
?>
<script type="text/javascript" src="../js/jquery/jquery.tablednd_0_5.js"></script>
<script type="text/javascript">
	var token = '1f0af725a0585d7827c059999fd2d35e';
	var come_from = 'brand';
	var alternate = '0';
</script>
<script src="../js/admin/dnd.js" type="text/javascript"></script>
<div class="path_bar">
	<div class="path_title">
		<h3> 
			<span style="font-weight: normal;" id="current_obj">
			<span class="breadcrumb item-1 ">品牌</span> 
		</h3>
		<div class="cc_button">
		<ul>
        <li><a title="添加品牌" href="index.php?rule=brand_edit" class="toolbar_btn" id="add_brand">
				<span class="process-icon-new "></span>
				<div>添加品牌</div>
			</a></li>
      </ul>
		</div>
	</div>
</div>
<form class="form" method="post" action="index.php?rule=brand">
<table class="table_grid" name="list_table" width="100%">
<tr>
<td style="vertical-align: bottom;">
<span style="float: left;">
	<?php
		echo Helper::renderAdminPagaNation($result['total'],$limit,$p,'brandPage');
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
	<table class="tableList table tableDnD" width="100%" cellpadding="0" cellspacing="0" id="brand">
	<thead>
		<tr>
			<th><input type="checkbox" name="checkme" onclick="checkDelBoxes(this.form, 'categoryBox[]', this.checked)" ></th>
			<th>
				编号
				<a href="index.php?rule=brand&brandOrderBy=id_brand&brandOrderWay=desc" >
					<?php if(isset($orderBy) && $orderBy=='id_brand' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a>
				<a href="index.php?rule=brand&brandOrderBy=id_brand&brandOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='id_brand' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
				</a>
			</th>
			<th>
				名称
				<a href="index.php?rule=brand&brandOrderBy=name&brandOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='name' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=brand&brandOrderBy=name&brandOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='name' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
			</th>
			<th>LOGO</th>
			<th>描述</th>
			<th align="right" >操作</th>
		</tr>
		<tr style="height: 35px;" class="nodrag nodrop filter row_hover">
		  <td class="center"> -- </td>
		  <td class="center"><input type="text" style="width:40px" value="<?php echo isset($filter['id_brand'])?$filter['id_brand']:'';?>" name="brandFilter_id_brand" class="filter"></td>
		  <td><input type="text" value="<?php echo isset($filter['name'])?$filter['name']:'';?>" name="brandFilter_name" class="filter"></td>
		  <td class="center"><input type="text" value="<?php echo isset($filter['logo'])?$filter['logo']:'';?>" name="brandFilter_logo" class="filter"></td>
		  <td class="center"><input type="text" value="<?php echo isset($filter['description'])?$filter['description']:'';?>" name="brandFilter_description" class="filter"></td>
		  <td align="right">--</td>
		</tr>
	   </thead>
		<?php 
		if(is_array($result['entitys']) && count($result['entitys'])>0){
		foreach($result['entitys'] as $key => $row){?>
		<tr class="<?php echo ($key%2?'alt_row':''); ?> row" id="tr_<?php echo $row['id_brand'];?>">
			<td><input type="checkbox" name="categoryBox[]" value="<?php echo $row['id_brand'];?>" ></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=brand_edit&id=<?php echo $row['id_brand'];?>'"><?php echo $row['id_brand'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=brand_edit&id=<?php echo $row['id_brand'];?>'"><?php echo $row['name'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=brand_edit&id=<?php echo $row['id_brand'];?>'"><img src="<?php echo $_tmconfig['brand_dir'].$row['logo'];?>" alt="<?php echo $row['name'];?>"></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=brand_edit&id=<?php echo $row['id_brand'];?>'"><?php echo $row['description'];?></td>
			<td align="right">
				<a href="index.php?rule=brand_edit&id=<?php echo $row['id_brand'];?>"><img alt="编辑" src="<?php echo $_tmconfig['ico_dir'];?>edit.gif"></a> 
				<a onclick="return confirm('你确定要删除？')" href="index.php?rule=brand&delete=<?php echo $row['id_brand'];?>"><img alt="删除" src="<?php echo $_tmconfig['ico_dir'];?>delete.gif"></a>
			</td>
		</tr>
		<?php }
			}else{
		?>
		<tr><td colspan="6" align="center">暂无品牌</td></tr>
		<?php }?>
	</table>
</div>
</td></tr>
<tr><td>
<p><input type="submit" onclick="return confirm('你确定要删除选中项目?');" value="删除选中项目" name="subDelete" class="button"></p>
</td></tr>
</table>
</form>
