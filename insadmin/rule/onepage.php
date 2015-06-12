<?php

if(intval(Tools::getRequest('delete'))>0){
	$object = new Onepage(intval(Tools::getRequest('delete')));
	if(Validate::isLoadedObject($object)){
		$object->delete();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		echo '<div class="conf">删除单页成功</div>';
	}
}elseif(Tools::isSubmit('subDelete')){
	$select_cat = Tools::getRequest('categoryBox');
	$onepage	= new Onepage();
		if($onepage->deleteSelection($select_cat))
			echo '<div class="conf">删除单页成功</div>';

}elseif(intval(Tools::getRequest('toggleStatus'))>0){
	$object = new Onepage(intval(Tools::getRequest('toggleStatus')));
	if(Validate::isLoadedObject($object)){
		$object->toggleStatus();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		echo '<div class="conf">更新单页状态成功</div>';
	}
}

$filter	 = $cookie->getFilter('onepage',array('id_onepage','view_name','meta_title','rewrite'));
if(Tools::isSubmit('submitResetOnepage')){
	$cookie->unsetFilter('onepage',array('id_onepage','view_name','meta_title','rewrite'));
	$filter = array();
}

$orderBy 	= $cookie->getPost('onepageOrderBy') ? $cookie->getPost('onepageOrderBy') : 'id_onepage';
$orderWay 	= $cookie->getPost('onepageOrderWay') ? $cookie->getPost('onepageOrderWay') : 'ASC';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::getRequest('onepagePage') ? Tools::getRequest('onepagePage'):1;

$result  	= Onepage::getPages(false,$p,$limit,$orderBy,$orderWay,$filter);

require_once(dirname(__FILE__).'/../errors.php');
?>
<script type="text/javascript" src="../js/jquery/jquery.tablednd_0_5.js"></script>
<script src="../js/admin/dnd.js" type="text/javascript"></script>
<div class="path_bar">
	<div class="path_title">
		<h3> 
			<span style="font-weight: normal;" id="current_obj">
			<span class="breadcrumb item-1 ">单面</span></span>
		</h3>
		<div class="cc_button">
		<ul>
        <li><a title="添加分类" href="index.php?rule=onepage_edit" class="toolbar_btn" id="add_onepage">
				<span class="process-icon-new "></span>
				<div>添加单页</div>
			</a></li>
      </ul>
		</div>
	</div>
</div>
<form class="form" method="post" action="index.php?rule=onepage">
<table class="table_grid" name="list_table" width="100%">
<tr>
<td style="vertical-align: bottom;">
<span style="float: left;">
	<?php
		echo Helper::renderAdminPagaNation($result['total'],$limit,$p,'onepagePage');
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
	<input type="submit" class="button" value="重置" name="submitResetOnepage">
</span>
</td>
</tr>
<tr><td>
<div class="mianColForm">
	<table class="tableList table tableDnD" width="100%" cellpadding="0" cellspacing="0" id="onepage">
	<thead>
		<tr>
			<th><input type="checkbox" name="checkme" onclick="checkDelBoxes(this.form, 'categoryBox[]', this.checked)" ></th>
			<th>
				编号
				<a href="index.php?rule=onepage&onepageOrderBy=id_onepage&onepageOrderWay=desc" >
					<?php if(isset($orderBy) && $orderBy=='id_onepage' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up.gif">
					<?php } ?>
				</a>
				<a href="index.php?rule=onepage&onepageOrderBy=id_onepage&onepageOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='id_onepage' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down.gif">
					<?php } ?>
				</a>
			</th>
			<th>
				示图名
				<a href="index.php?rule=onepage&onepageOrderBy=view_name&onepageOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='view_name' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=onepage&onepageOrderBy=view_name&onepageOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='view_name' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down.gif">
					<?php } ?>
			</th>
			<th>
				Meta Title
				<a href="index.php?rule=onepage&onepageOrderBy=meta_title&onepageOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='meta_title' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=onepage&onepageOrderBy=meta_title&onepageOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='meta_title' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down.gif">
					<?php } ?>
				</a> 
			</th>
			<th>
				Url Rewrite
				<a href="index.php?rule=onepage&onepageOrderBy=rewrite&onepageOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='rewrite' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=onepage&onepageOrderBy=rewrite&onepageOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='rewrite' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down.gif">
					<?php } ?>
				</a> 
			</th>
			<th>
				添加时间
				<a href="index.php?rule=onepage&onepageOrderBy=add_date&onepageOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='add_date' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=onepage&onepageOrderBy=add_date&onepageOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='add_date' && isset($orderWay) && $orderWay=='asc'){ ?>
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
		  <td class="center"><input type="text" style="width:40px" value="<?php echo isset($filter['id_onepage'])?$filter['id_onepage']:'';?>" name="onepageFilter_id_onepage" class="filter"></td>
		  <td><input type="text" style="width:300px" value="<?php echo isset($filter['name'])?$filter['name']:'';?>" name="onepageFilter_name" class="filter"></td>
		  <td class="center"><input type="text" style="width:200px" value="<?php echo isset($filter['email'])?$filter['email']:'';?>" name="onepageFilter_email" class="filter"></td>
		  <td class="center">
		  	<select name="onepageFilter_active" onChange="$('#submitFilterButton').focus();$('#submitFilterButton').click();">
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
		if(is_array($result['entitys']) && count($result['entitys'])>0){
		foreach($result['entitys'] as $key => $row){?>
		<tr class="<?php echo ($key%2?'alt_row':''); ?> row" id="tr_<?php echo $row['id_onepage'];?>">
			<td><input type="checkbox" name="categoryBox[]" value="<?php echo $row['id_onepage'];?>" ></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=onepage_edit&id=<?php echo $row['id_onepage'];?>'"><?php echo $row['id_onepage'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=onepage_edit&id=<?php echo $row['id_onepage'];?>'"><?php echo $row['view_name'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=onepage_edit&id=<?php echo $row['id_onepage'];?>'"><?php echo $row['meta_title'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=onepage_edit&id=<?php echo $row['id_onepage'];?>'"><?php echo $row['rewrite'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=onepage_edit&id=<?php echo $row['id_onepage'];?>'"><?php echo $row['add_date'];?></td>
			<td align="right">
				<a href="#"><img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/details.gif"></a> 
				<a href="index.php?rule=onepage_edit&id=<?php echo $row['id_onepage'];?>"><img alt="编辑" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/edit.gif"></a> 
				<a onclick="return confirm('你确定要删除？')" href="index.php?rule=onepage&delete=<?php echo $row['id_onepage'];?>"><img alt="删除" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/delete.gif"></a>
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
	<input type="submit" value="启用选中项目" name="subEnabled" class="button">
	<input type="submit" value="关闭选中项目" name="subDisabled" class="button">
</p>
</td></tr>
</table>
</form>