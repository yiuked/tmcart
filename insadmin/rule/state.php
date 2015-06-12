<?php

if(intval(Tools::getRequest('delete'))>0){
	$object = new State(intval(Tools::getRequest('delete')));
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
	$state	= new State();
		if($state->deleteSelection($select_cat))
			echo '<div class="conf">删除对象成功</div>';

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
	$object		= new State();
	if(is_array($select_cat)){
		if($object->statusSelection($select_cat,$action))
			echo '<div class="conf">更新对象成功</div>';
	}
}

$filter	 = $cookie->getFilter('state',array('id_state','id_country','name','iso_code','active'));
if(Tools::isSubmit('submitResetState')){
	$cookie->unsetFilter('state',array('id_state','id_country','name','iso_code','active'));
	$filter = array();
}

$orderBy 	= $cookie->getPost('stateOrderBy') ? $cookie->getPost('stateOrderBy') : 'id_state';
$orderWay 	= $cookie->getPost('stateOrderWay') ? $cookie->getPost('stateOrderWay') : 'ASC';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::getRequest('statePage') ? Tools::getRequest('statePage'):1;

$result  	= State::getEntity(false,$p,$limit,$orderBy,$orderWay,$filter);

require_once(dirname(__FILE__).'/../errors.php');
?>
<script type="text/javascript" src="../js/jquery/jquery.tablednd_0_5.js"></script>
<script type="text/javascript">
	var token = '1f0af725a0585d7827c059999fd2d35e';
	var come_from = 'state';
	var alternate = '0';
</script>
<script src="../js/admin/dnd.js" type="text/javascript"></script>
<div class="path_bar">
	<div class="path_title">
		<h3> 
			<span style="font-weight: normal;" id="current_obj">
			<span class="breadcrumb item-1 ">州/省</span></span>
		</h3>
		<div class="cc_button">
			<ul>
			<li><a title="添加" href="index.php?rule=state_edit" class="toolbar_btn" id="add_product_new">
					<span class="process-icon-new "></span>
					<div>添加</div>
				</a></li>
			</ul>
		</div>
	</div>
</div>
<form class="form" method="post" action="index.php?rule=state">
<table class="table_grid" name="list_table" width="100%">
<tr>
<td style="vertical-align: bottom;">
<span style="float: left;">
	<?php
		echo Helper::renderAdminPagaNation($result['total'],$limit,$p,'statePage');
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
	<table class="tableList table tableDnD" width="100%" cellpadding="0" cellspacing="0" id="state">
	<thead>
		<tr>
			<th><input type="checkbox" name="checkme" onclick="checkDelBoxes(this.form, 'categoryBox[]', this.checked)" ></th>
			<th>
				编号
				<a href="index.php?rule=state&stateOrderBy=id_state&stateOrderWay=desc" >
					<?php if(isset($orderBy) && $orderBy=='id_state' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a>
				<a href="index.php?rule=state&stateOrderBy=id_state&stateOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='id_state' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
				</a>
			</th>
			<th>
				ISO Code
				<a href="index.php?rule=state&stateOrderBy=iso_code&stateOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='iso_code' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=state&stateOrderBy=iso_code&stateOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='iso_code' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
				</a>
			</th>
			<th>
				国家
				<a href="index.php?rule=state&stateOrderBy=id_country&stateOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='id_country' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=state&stateOrderBy=id_country&stateOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='id_country' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
				</a> 
			</th>
			<th>
				州/省
				<a href="index.php?rule=state&stateOrderBy=name&stateOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='name' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=state&stateOrderBy=name&stateOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='name' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
				</a> 
			</th>
			<th>
				状态
				<a href="index.php?rule=state&stateOrderBy=active&stateOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='active' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=state&stateOrderBy=active&stateOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='active' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
				</a> 
			</th>
			<th style="text-align:right">操作</th>
		</tr>
		<tr style="height: 35px;" class="nodrag nodrop filter row_hover">
		  <td class="center"> -- </td>
		  <td class="center"><input type="text" style="width:40px" value="<?php echo isset($filter['id_state'])?$filter['id_state']:'';?>" name="stateFilter_id_state" class="filter"></td>
		  <td><input type="text" value="<?php echo isset($filter['iso_code'])?$filter['iso_code']:'';?>" name="stateFilter_iso_code" class="filter"></td>
		  <td><input type="text" value="<?php echo isset($filter['id_country'])?$filter['id_country']:'';?>" name="stateFilter_id_country" class="filter"></td>
		  <td><input type="text" value="<?php echo isset($filter['name'])?$filter['name']:'';?>" name="stateFilter_name" class="filter"></td>
		  <td><select name="stateFilter_active" onChange="$('#submitFilterButton').focus();$('#submitFilterButton').click();">
				  <option value="">--</option>
				  <option value="1" <?php if(isset($filter['active']) && $filter['active']==1){echo "selected";}?>>Yes</option>
				  <option value="2" <?php if(isset($filter['active']) && $filter['active']==2){echo "selected";}?>>No</option>
				</select></td>
		  <td align="right">--</td>
		</tr>
	   </thead>
		<?php 
		if(is_array($result['entitys']) && count($result['entitys'])>0){
		foreach($result['entitys'] as $key => $row){?>
		<tr class="<?php echo ($key%2?'alt_row':''); ?> row" id="tr_<?php echo $row['id_state'];?>">
			<td><input type="checkbox" name="categoryBox[]" value="<?php echo $row['id_state'];?>" ></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=state_edit&id=<?php echo $row['id_state'];?>'"><?php echo $row['id_state'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=state_edit&id=<?php echo $row['id_state'];?>'"><?php echo $row['iso_code'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=state_edit&id=<?php echo $row['id_state'];?>'"><?php echo $row['id_country'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=state_edit&id=<?php echo $row['id_state'];?>'"><?php echo $row['name'];?></td>
			<td><a href="index.php?rule=state&toggleStatus=<?php echo $row['id_state'];?>">
				<img src="<?php echo $_tmconfig['ico_dir'].($row['active']?'enabled.gif':'disabled.gif');?>" alt="<?php echo $row['active']?'开启':'关闭';?>"/></a></td>
			<td align="right">
				<a href="index.php?rule=state_edit&id=<?php echo $row['id_state'];?>"><img alt="编辑" src="<?php echo $_tmconfig['ico_dir'];?>edit.gif"></a> 
				<a onclick="return confirm('你确定要删除？')" href="index.php?rule=state&id=<?php echo $row['id_state'];?>"><img alt="删除" src="<?php echo $_tmconfig['ico_dir'];?>delete.gif"></a>
			</td>
		</tr>
		<?php }
			}else{
		?>
		<tr><td colspan="7" align="center">暂无留言</td></tr>
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