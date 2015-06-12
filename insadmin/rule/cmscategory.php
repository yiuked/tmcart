<?php
$id 		= Tools::getRequest('id')?Tools::getRequest('id'):1;
$category 	= new CMSCategory($id);
$filter		= array();

if(intval(Tools::getRequest('delete'))>0){
	$object = new CMSCategory(intval(Tools::getRequest('delete')));
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
	$object = new CMSCategory(intval(Tools::getRequest('toggleStatus')));
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
	$object		= new CMSCategory();
	if(is_array($select_cat)){
		if($object->statusSelection($select_cat,$action))
			echo '<div class="conf">更新分类状态成功</div>';
	}
}elseif (isset($_GET['position'])){
	if (!Validate::isLoadedObject($object = new CMSCategory((int)(Tools::getRequest('id_category_to_move')))))
		$errors[] = '无法输入对象';
	if (!$object->updatePosition((int)(Tools::getRequest('way')), (int)(Tools::getRequest('position'))))
		$errors[] = '更新排序失败';
	else {
		echo '<div class="conf">更新排序成功</div>';
	}
}

$filter	 = $cookie->getFilter('cmscategory',array('id_cms_category','name','rewrite','active'));
if(Tools::isSubmit('submitResetcategory')){
	$cookie->unsetFilter('cmscategory',array('id_cms_category','name','rewrite','active'));
	$filter = array();
}

$orderBy 	= $cookie->getPost('cmsCategoryOrderBy') ? $cookie->getPost('cmsCategoryOrderBy') : 'id_cms_category';
$orderWay 	= $cookie->getPost('cmsCategoryOrderWay') ? $cookie->getPost('cmsCategoryOrderWay') : 'ASC';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '20';
$p			= Tools::getRequest('employeePage') ? (Tools::getRequest('catalogPage')==0?1:Tools::getRequest('catalogPage')):1;


$result  	= $category->getSubCMSCategories(false,$limit,$p,$orderBy,$orderWay,$filter);

$catBar = $category->getCatBar($category->id_parent);
require_once(_TM_ADMIN_DIR_.'/errors.php');
?>
<script type="text/javascript" src="../js/jquery/jquery.tablednd_0_5.js"></script>
<script type="text/javascript">
	var token = '1f0af725a0585d7827c059999fd2d35e';
	var come_from = 'cms_category';
	var alternate = '0';
</script>
<script src="../js/admin/dnd.js" type="text/javascript"></script>
<div class="path_bar">
	<div class="path_title">
		<h3> 
			<span style="font-weight: normal;" id="current_obj">
			<span class="breadcrumb item-1 ">CMS <img src="<?php echo $_tmconfig['tm_img_dir'];?>admin/separator_breadcrum.png" style="margin-right:5px" alt="&gt;"> </span> 
			<span class="breadcrumb item-2 ">分类</span> </span> 
		</h3>
		<div class="cc_button">
		<ul>
        <li><a title="添加分类" href="index.php?rule=cmscategory_edit" class="toolbar_btn" id="add_cmscategory_new">
				<span class="process-icon-new "></span>
				<div>添加分类</div>
			</a></li>
		<?php if((int)$id>1){?>
        <li> <a title="Back to list" href="index.php?rule=cmscategory&id=<?php echo $category->id_parent; ?>" class="toolbar_btn" id="desc-product-back"> <span class="process-icon-back "></span>
          <div>返回列表</div>
          </a> </li>
		  <?php }?>
      </ul>
		</div>
	</div>
</div>
<?php 
if(is_array($catBar) && count($catBar)>0){
krsort($catBar);
?>
<div class="cat_bar">
	<?php foreach($catBar as $Bar){?>
		<?php if($Bar['id_cms_category']==1){?>
		<a title="Home" href="index.php?rule=cmscategory"><img alt="" src="<?php echo $_tmconfig['tm_img_dir'];?>icon/home.gif"></a><a title="Home" href="index.php?rule=cmscategory">根分类</a> &gt;
		<?php }else{?> 
		<a title="Modify" href="index.php?rule=cmscategory&id=<?php echo $Bar['id_cms_category'];?>"><img alt="" src="<?php echo $_tmconfig['tm_img_dir'];?>icon/edit.gif"> <?php echo $Bar['name'];?></a>  &gt;
		<?php }?>
	<?php }?>
	<?php echo $category->name;?>
</div>
<?php }?>
<form class="form" method="post" action="index.php?rule=cmscategory&id=<?php echo $id; ?>">
<table class="table_grid" name="list_table" width="100%">
<tr>
<td style="vertical-align: bottom;">
<span style="float: left;">
	<?php
		echo Helper::renderAdminPagaNation($result['total'],$limit,$p,'employeePage');
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
	<input type="submit" class="button" value="检索" name="submitFilter" id="submitFilterButtoncategory">
	<input type="submit" class="button" value="重置" name="submitResetcategory">
</span>
</td>
</tr>
<tr><td>
<div class="mianColForm">
	<table class="tableList table tableDnD" width="100%" cellpadding="0" cellspacing="0" id="cms_category">
	<thead>
		<tr>
			<th><input type="checkbox" name="checkme" onclick="checkDelBoxes(this.form, 'categoryBox[]', this.checked)" ></th>
			<th>
				编号
				<a href="index.php?rule=cmscategory&cmsCategoryOrderBy=id_cms_category&cmsCategoryOrderWay=desc" >
					<?php if(isset($orderBy) && $orderBy=='id_cms_category' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up.gif">
					<?php } ?>
				</a>
				<a href="index.php?rule=cmscategory&cmsCategoryOrderBy=id_cms_category&cmsCategoryOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='id_cms_category' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down.gif">
					<?php } ?>
				</a>
			</th>
			<th>
				名称
				<a href="index.php?rule=cmscategory&cmsCategoryOrderBy=name&cmsCategoryOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='name' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=cmscategory&cmsCategoryOrderBy=name&cmsCategoryOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='name' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down.gif">
					<?php } ?>
			</th>
			<th>
				URL
				<a href="index.php?rule=cmscategory&cmsCategoryOrderBy=rewrite&cmsCategoryOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='rewrite' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=cmscategory&cmsCategoryOrderBy=rewrite&cmsCategoryOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='rewrite' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down.gif">
					<?php } ?>
				</a> 
			</th>
			<th>
				状态
				<a href="index.php?rule=cmscategory&cmsCategoryOrderBy=active&cmsCategoryOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='active' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=cmscategory&cmsCategoryOrderBy=active&cmsCategoryOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='active' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down.gif">
					<?php } ?>
				</a> 
			</th>
			<th>
				排序
				<a href="index.php?rule=cmscategory&cmsCategoryOrderBy=position&cmsCategoryOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='position' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=cmscategory&cmsCategoryOrderBy=position&cmsCategoryOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='position' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down.gif">
					<?php } ?>
				</a> 
			</th>
			<th align="right" >操作</th>
		</tr>
		<tr style="height: 35px;" class="nodrag nodrop filter row_hover">
		  <td class="center"> -- </td>
		  <td class="center"><input type="text" style="width:40px" value="<?php echo isset($filter['id_cms_category'])?$filter['id_cms_category']:'';?>" name="cmscategoryFilter_id_cms_category" class="filter"></td>
		  <td><input type="text" style="width:300px" value="<?php echo isset($filter['name'])?$filter['name']:'';?>" name="cmscategoryFilter_name" class="filter"></td>
		  <td class="center"><input type="text" style="width:200px" value="<?php echo isset($filter['rewrite'])?$filter['rewrite']:'';?>" name="cmscategoryFilter_rewrite" class="filter"></td>
		  <td class="center">
		  	<select name="cmscategoryFilter_active" onChange="$('#submitFilterButtoncategory').focus();$('#submitFilterButtoncategory').click();">
			  <option value="">--</option>
			  <option value="1" <?php if(isset($filter['active']) && $filter['active']==1){echo "selected";}?>>Yes</option>
			  <option value="2" <?php if(isset($filter['active']) && $filter['active']==2){echo "selected";}?>>No</option>
			</select>
		  </td>
		  <td>--</td>
		  <td align="right">--</td>
		</tr>
	   </thead>
		<?php 
		if(is_array($result['list']) && count($result['list'])>0){
		foreach($result['list'] as $key => $row){?>
		<tr class="<?php echo ($key%2?'alt_row':''); ?> row" id="tr_<?php echo $row['id_parent'].'_'.$row['id_cms_category'].'_'.$row['position'];?>">
			<td><input type="checkbox" name="categoryBox[]" value="<?php echo $row['id_cms_category'];?>" ></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=cmscategory&id=<?php echo $row['id_cms_category'];?>'"><?php echo $row['id_cms_category'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=cmscategory&id=<?php echo $row['id_cms_category'];?>'"><?php echo $row['name'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=cmscategory&id=<?php echo $row['id_cms_category'];?>'"><?php echo $row['rewrite'];?></td>
			<td><a href="index.php?rule=cmscategory&toggleStatus=<?php echo $row['id_cms_category'];?>"><img src="<?php echo $_tmconfig['tm_img_dir'].'/icon/'.($row['active']?'enabled.gif':'disabled.gif');?>" alt="<?php echo $row['active']?'开启':'关闭';?>"/></a></td>
			<td class="pointer dragHandle center" id="td_<?php echo $row['id_parent'].'_'.$row['id_cms_category'];?>">
					<a href="index.php?rule=cmscategory&id_category_parent=<?php echo $row['id_parent'];?>&id_category_to_move=<?php echo $row['id_cms_category'];?>&way=1&position=<?php echo $row['position']+1;?>" <?php if($key+1==$result['total']){ echo 'style="display:none"'; }?>>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down.gif"></a>
					<a href="index.php?rule=cmscategory&id_category_parent=<?php echo $row['id_parent'];?>&id_category_to_move=<?php echo $row['id_cms_category'];?>&way=0&position=<?php echo $row['position']-1;?>" <?php if($key==0){ echo 'style="display:none"'; }?>>
						<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up.gif"></a> 
			</td>
			<td align="right">
				<a href="#"><img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/details.gif"></a> 
				<a href="index.php?rule=cmscategory_edit&id=<?php echo $row['id_cms_category'];?>"><img alt="编辑" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/edit.gif"></a> 
				<a onclick="return confirm('你确定要删除？')" href="index.php?rule=cmscategory&delete=<?php echo $row['id_cms_category'];?>"><img alt="删除" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/delete.gif"></a>
			</td>
		</tr>
		<?php }
			}else{
		?>
		<tr><td colspan="6" align="center">暂无分类</td></tr>
		<?php }?>
	</table>
</div>
</td></tr>
<tr><td>
<p>
	<input type="submit" onclick="return confirm('你确定要删除选中项目?');" value="删除选中项目" name="subDelete" class="button">
	<input type="submit" value="批量启用" name="subActiveON" class="button">
	<input type="submit" value="批量关闭" name="subActiveOFF" class="button">
</p>
</td></tr>
</table>
</form>