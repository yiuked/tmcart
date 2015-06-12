<?php

if(intval(Tools::getRequest('delete'))>0){
	$object = new CMSComment(intval(Tools::getRequest('delete')));
	if(Validate::isLoadedObject($object)){
		$object->delete();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		echo '<div class="conf">删除评论成功</div>';
	}
}elseif(Tools::isSubmit('subDelete')){
	$select_cat = Tools::getRequest('categoryBox');
	$cmscomment	= new CMSComment();
		if($cmscomment->deleteSelection($select_cat))
			echo '<div class="conf">删除评论成功</div>';

}elseif(intval(Tools::getRequest('toggleStatus'))>0){
	$object = new CMSComment(intval(Tools::getRequest('toggleStatus')));
	if(Validate::isLoadedObject($object)){
		$object->toggleStatus();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		echo '<div class="conf">更新评论成功</div>';
	}
}

$filter	 = $cookie->getFilter('cmscomment',array('id_cms_comment','name','website','title','email','active'));
if(Tools::isSubmit('submitResetCmsComment')){
	$cookie->unsetFilter('employee',array('id_cms_comment','name','website','title','email','active'));
	$filter = array();
}

$orderBy 	= $cookie->getPost('cmscommentOrderBy') ? $cookie->getPost('cmscommentOrderBy') : 'id_cms_comment';
$orderWay 	= $cookie->getPost('cmscommentOrderWay') ? $cookie->getPost('cmscommentOrderWay') : 'ASC';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::getRequest('cmscommentPage') ? Tools::getRequest('cmscommentPage'):1;

$result  	= CMSComment::getComments(false,$p,$limit,$orderBy,$orderWay,$filter);

require_once(_TM_ADMIN_DIR_.'/errors.php');
?>
<script type="text/javascript" src="../js/jquery/jquery.tablednd_0_5.js"></script>
<script type="text/javascript">
	var token = '1f0af725a0585d7827c059999fd2d35e';
	var come_from = 'employee';
	var alternate = '0';
</script>
<script src="../js/admin/dnd.js" type="text/javascript"></script>
<div class="path_bar">
	<div class="path_title">
		<h3> 
			<span style="font-weight: normal;" id="current_obj">
			<span class="breadcrumb item-1 ">评论</span> 
		</h3>
	</div>
</div>
<form class="form" method="post" action="index.php?rule=cmscomment">
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
	<input type="submit" class="button" value="检索" name="submitFilter" id="submitFilterButton">
	<input type="submit" class="button" value="重置" name="submitResetcategory">
</span>
</td>
</tr>
<tr><td>
<div class="mianColForm">
	<table class="tableList table tableDnD" width="100%" cellpadding="0" cellspacing="0" id="employee">
	<thead>
		<tr>
			<th><input type="checkbox" name="checkme" onclick="checkDelBoxes(this.form, 'categoryBox[]', this.checked)" ></th>
			<th>
				编号
				<a href="index.php?rule=comment&commentOrderBy=id_employee&commentOrderWay=desc" >
					<?php if(isset($orderBy) && $orderBy=='id_employee' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up.gif">
					<?php } ?>
				</a>
				<a href="index.php?rule=comment&commentOrderBy=id_employee&commentOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='id_employee' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down.gif">
					<?php } ?>
				</a>
			</th>
			<th>
				昵称
				<a href="index.php?rule=comment&commentOrderBy=name&commentOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='name' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=comment&commentOrderBy=name&commentOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='name' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down.gif">
					<?php } ?>
			</th>
			<th>
				主题
				<a href="index.php?rule=comment&commentOrderBy=title&commentOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='title' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=comment&commentOrderBy=title&commentOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='title' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down.gif">
					<?php } ?>
			</th>
			<th>
				网址
				<a href="index.php?rule=comment&commentOrderBy=website&commentOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='website' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=comment&commentOrderBy=website&commentOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='website' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down.gif">
					<?php } ?>
			</th>
			<th>
				Email
				<a href="index.php?rule=comment&commentOrderBy=email&commentOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='email' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=comment&commentOrderBy=email&commentOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='email' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down.gif">
					<?php } ?>
				</a> 
			</th>
			<th>
				内容
				<a href="index.php?rule=comment&commentOrderBy=comment&commentOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='comment' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=comment&commentOrderBy=comment&commentOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='comment' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down.gif">
					<?php } ?>
				</a> 
			</th>
			<th>
				状态
				<a href="index.php?rule=employee&commentOrderBy=active&commentOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='active' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=employee&commentOrderBy=active&commentOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='active' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down.gif">
					<?php } ?>
				</a> 
			</th>
			<th>
				评论时间
				<a href="index.php?rule=employee&commentOrderBy=add_date&commentOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='add_date' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=employee&commentOrderBy=add_date&commentOrderWay=asc">
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
		  <td class="center"><input type="text" style="width:40px" value="<?php echo isset($filter['id_employee'])?$filter['id_employee']:'';?>" name="employeeFilter_id_employee" class="filter"></td>
		  <td><input type="text" value="<?php echo isset($filter['name'])?$filter['name']:'';?>" name="employeeFilter_name" class="filter"></td>
		  <td class="center"><input type="text" value="<?php echo isset($filter['title'])?$filter['title']:'';?>" name="commentFilter_title" class="filter"></td>
		  <td class="center"><input type="text" value="<?php echo isset($filter['website'])?$filter['website']:'';?>" name="commentFilter_website" class="filter"></td>
		  <td class="center"><input type="text" value="<?php echo isset($filter['email'])?$filter['email']:'';?>" name="commentFilter_email" class="filter"></td>
		  <td><input type="text" style="width:200px" value="<?php echo isset($filter['comment'])?$filter['comment']:'';?>" name="commentFilter_comment" class="filter"></td>
		  <td class="center">
		  	<select name="commentFilter_active" onChange="$('#submitFilterButton').focus();$('#submitFilterButton').click();">
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
		if(is_array($result['comments']) && count($result['comments'])>0){
		foreach($result['comments'] as $key => $row){?>
		<tr class="<?php echo ($key%2?'alt_row':''); ?> row" id="tr_<?php echo $row['id_cms_comment'];?>">
			<td><input type="checkbox" name="categoryBox[]" value="<?php echo $row['id_cms_comment'];?>" ></td>
			<td class="pointer"><?php echo $row['id_cms_comment'];?></td>
			<td class="pointer"><?php echo $row['name'];?></td>
			<td class="pointer"><?php echo $row['title'];?></td>
			<td class="pointer"><?php echo $row['website'];?></td>
			<td class="pointer"><?php echo $row['email'];?></td>
			<td class="pointer"><?php echo $row['comment'];?></td>
			<td><a href="index.php?rule=cmscomment&toggleStatus=<?php echo $row['id_cms_comment'];?>"><img src="<?php echo $_tmconfig['tm_img_dir'].'/icon/'.($row['active']?'enabled.gif':'disabled.gif');?>" alt="<?php echo $row['active']?'开启':'关闭';?>"/></a></td>
			<td class="pointer"><?php echo $row['add_date'];?></td>
			<td align="right">
				<a onclick="return confirm('你确定要删除？')" href="index.php?rule=comment&delete=<?php echo $row['id_cms_comment'];?>"><img alt="删除" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/delete.gif"></a>
			</td>
		</tr>
		<?php }
			}else{
		?>
		<tr><td colspan="6" align="center">暂无评论</td></tr>
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