<?php

if(intval(Tools::getRequest('delete'))>0){
	$object = new User(intval(Tools::getRequest('delete')));
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
	$user	= new User();
	if($user->deleteSelection($select_cat))
		echo '<div class="conf">删除对象成功</div>';

}elseif(intval(Tools::getRequest('toggleStatus'))>0){
	$object = new User(intval(Tools::getRequest('toggleStatus')));
	if(Validate::isLoadedObject($object)){
		$object->toggleStatus();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		echo '<div class="conf">更新对象状态成功</div>';
	}
}

$filter	 = $cookie->getFilter('user',array('id_user','name','email','active'));
if(Tools::isSubmit('submitResetUser')){
	$cookie->unsetFilter('user',array('id_user','name','email','active'));
	$filter = array();
}

$orderBy 	= $cookie->getPost('userOrderBy') ? $cookie->getPost('userOrderBy') : 'id_user';
$orderWay 	= $cookie->getPost('userOrderWay') ? $cookie->getPost('userOrderWay') : 'ASC';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::getRequest('userPage') ? Tools::getRequest('userPage'):1;

$result  	= User::getEntitys(false,$p,$limit,$orderBy,$orderWay,$filter);

require_once(dirname(__FILE__).'/../errors.php');
?>
<script type="text/javascript" src="../js/jquery/jquery.tablednd_0_5.js"></script>
<script type="text/javascript">
	var token = '1f0af725a0585d7827c059999fd2d35e';
	var come_from = 'user';
	var alternate = '0';
</script>
<script src="../js/admin/dnd.js" type="text/javascript"></script>
<div class="path_bar">
	<div class="path_title">
		<h3> 
			<span style="font-weight: normal;" id="current_obj">
			<span class="breadcrumb item-1 ">用户</span></span> 
		</h3>
		<div class="cc_button">
		<ul>
        <li><a title="添加用户" href="index.php?rule=user_edit" class="toolbar_btn" id="add_user">
				<span class="process-icon-new "></span>
				<div>添加用户</div>
			</a></li>
      </ul>
		</div>
	</div>
</div>
<form class="form" method="post" action="index.php?rule=user">
<table class="table_grid" name="list_table" width="100%">
<tr>
<td style="vertical-align: bottom;">
<span style="float: left;">
	<?php
		echo Helper::renderAdminPagaNation($result['total'],$limit,$p,'userPage');
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
	<table class="tableList table tableDnD" width="100%" cellpadding="0" cellspacing="0" id="user">
	<thead>
		<tr>
			<th><input type="checkbox" name="checkme" onclick="checkDelBoxes(this.form, 'categoryBox[]', this.checked)" ></th>
			<th>
				编号
				<a href="index.php?rule=user&userOrderBy=id_user&userOrderWay=desc" >
					<?php if(isset($orderBy) && $orderBy=='id_user' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a>
				<a href="index.php?rule=user&userOrderBy=id_user&userOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='id_user' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
				</a>
			</th>
			<th>
				昵称
				<a href="index.php?rule=user&userOrderBy=name&userOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='name' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=user&userOrderBy=name&userOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='name' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
			</th>
			<th>
				Email
				<a href="index.php?rule=user&userOrderBy=email&userOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='email' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=user&userOrderBy=email&userOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='email' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
				</a> 
			</th>
			<th>
				状态
				<a href="index.php?rule=user&userOrderBy=active&userOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='active' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=user&userOrderBy=active&userOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='active' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
				</a> 
			</th>
			<th>
				最后登录
				<a href="index.php?rule=user&userOrderBy=last_date&userOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='last_date' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=user&userOrderBy=last_date&userOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='last_date' && isset($orderWay) && $orderWay=='asc'){ ?>
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
		  <td class="center"><input type="text" style="width:40px" value="<?php echo isset($filter['id_user'])?$filter['id_user']:'';?>" name="userFilter_id_user" class="filter"></td>
		  <td><input type="text" style="width:300px" value="<?php echo isset($filter['name'])?$filter['name']:'';?>" name="userFilter_name" class="filter"></td>
		  <td class="center"><input type="text" style="width:200px" value="<?php echo isset($filter['email'])?$filter['email']:'';?>" name="userFilter_email" class="filter"></td>
		  <td class="center">
		  	<select name="userFilter_active" onChange="$('#submitFilterButton').focus();$('#submitFilterButton').click();">
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
		<tr class="<?php echo ($key%2?'alt_row':''); ?> row" id="tr_<?php echo $row['id_user'];?>">
			<td><input type="checkbox" name="categoryBox[]" value="<?php echo $row['id_user'];?>" ></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=user_edit&id=<?php echo $row['id_user'];?>'"><?php echo $row['id_user'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=user_edit&id=<?php echo $row['id_user'];?>'"><?php echo $row['first_name'].' '.$row['last_name'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=user_edit&id=<?php echo $row['id_user'];?>'"><?php echo $row['email'];?></td>
			<td><a href="index.php?rule=user&toggleStatus=<?php echo $row['id_user'];?>"><img src="<?php echo $_tmconfig['tm_img_dir'].'/icon/'.($row['active']?'enabled.gif':'disabled.gif');?>" alt="<?php echo $row['active']?'开启':'关闭';?>"/></a></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=user_edit&id=<?php echo $row['id_user'];?>'"><?php echo $row['upd_date'];?></td>
			<td align="right">
				<a href="#"><img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>details.gif"></a> 
				<a href="index.php?rule=user_edit&id=<?php echo $row['id_user'];?>"><img alt="编辑" src="<?php echo $_tmconfig['ico_dir'];?>edit.gif"></a> 
				<a onclick="return confirm('你确定要删除？')" href="index.php?rule=user&delete=<?php echo $row['id_user'];?>"><img alt="删除" src="<?php echo $_tmconfig['ico_dir'];?>delete.gif"></a>
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