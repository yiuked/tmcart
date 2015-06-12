<?php
if(intval(Tools::getRequest('delete'))>0){
	$object = new Country(intval(Tools::getRequest('delete')));
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
	$country	= new Country();
		if($country->deleteSelection($select_cat))
			echo '<div class="conf">删除对象成功</div>';

}elseif(Tools::getRequest('toggle') && intval(Tools::getRequest('id'))>0){
	$object = new Country((int)(Tools::getRequest('id')));
	if(Validate::isLoadedObject($object)){
		$object->toggle(Tools::getRequest('toggle'));
	}

	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		echo '<div class="conf">更新对象成功</div>';
	}
}elseif(Tools::isSubmit('subActiveON') OR Tools::isSubmit('subActiveOFF')){
	$select_cat = Tools::getRequest('categoryBox');
	$action		= Tools::isSubmit('subActiveON')?1:0;
	$object		= new Country();
	if(is_array($select_cat)){
		if($object->statusSelection($select_cat,$action))
			echo '<div class="conf">更新对象成功</div>';
	}
}

$filter	 = $cookie->getFilter('country',array('id_country','name','iso_code','active','need_state'));
if(Tools::isSubmit('submitResetCountry')){
	$cookie->unsetFilter('country',array('id_country','name','iso_code','active','need_state'));
	$filter = array();
}

$orderBy 	= $cookie->getPost('countryOrderBy') ? $cookie->getPost('countryOrderBy') : 'id_country';
$orderWay 	= $cookie->getPost('countryOrderWay') ? $cookie->getPost('countryOrderWay') : 'ASC';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::getRequest('countryPage') ? Tools::getRequest('countryPage'):1;

$result  	= Country::getEntity(false,$p,$limit,$orderBy,$orderWay,$filter);

require_once(dirname(__FILE__).'/../errors.php');
?>
<script type="text/javascript" src="../js/jquery/jquery.tablednd_0_5.js"></script>
<script type="text/javascript">
	var token = '1f0af725a0585d7827c059999fd2d35e';
	var come_from = 'country';
	var alternate = '0';
</script>
<script src="../js/admin/dnd.js" type="text/javascript"></script>
<div class="path_bar">
	<div class="path_title">
		<h3> 
			<span style="font-weight: normal;" id="current_obj">
			<span class="breadcrumb item-1 ">国家</span></span>
		</h3>
	</div>
</div>
<form class="form" method="post" action="index.php?rule=country">
<table class="table_grid" name="list_table" width="100%">
<tr>
<td style="vertical-align: bottom;">
<span style="float: left;">
	<?php
		echo Helper::renderAdminPagaNation($result['total'],$limit,$p,'countryPage');
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
	<table class="tableList table tableDnD" width="100%" cellpadding="0" cellspacing="0" id="country">
	<thead>
		<tr>
			<th><input type="checkbox" name="checkme" onclick="checkDelBoxes(this.form, 'categoryBox[]', this.checked)" ></th>
			<th>
				编号
				<a href="index.php?rule=country&countryOrderBy=id_country&countryOrderWay=desc" >
					<?php if(isset($orderBy) && $orderBy=='id_country' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a>
				<a href="index.php?rule=country&countryOrderBy=id_country&countryOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='id_country' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
				</a>
			</th>
			<th>
				ISO Code
				<a href="index.php?rule=country&countryOrderBy=iso_code&countryOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='iso_code' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=country&countryOrderBy=iso_code&countryOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='iso_code' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
				</a>
			</th>
			<th>
				国家
				<a href="index.php?rule=country&countryOrderBy=name&countryOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='name' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=country&countryOrderBy=name&countryOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='name' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
				</a> 
			</th>
			<th>
				状态
				<a href="index.php?rule=country&countryOrderBy=active&countryOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='active' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=country&countryOrderBy=active&countryOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='active' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
				</a> 
			</th>
			<th>
				州/省
				<a href="index.php?rule=country&countryOrderBy=need_state&countryOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='need_state' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=country&countryOrderBy=need_state&countryOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='need_state' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
				</a> 
			</th>
			<th>
				排序
				<a href="index.php?rule=country&countryOrderBy=position&countryOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='position' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=country&countryOrderBy=position&countryOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='position' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down.gif">
					<?php } ?>
				</a> 
			</th>
			<th style="text-align:right">操作</th>
		</tr>
		<tr style="height: 35px;" class="nodrag nodrop filter row_hover">
		  <td class="center"> -- </td>
		  <td class="center">
		  	<input type="text" style="width:40px" value="<?php echo isset($filter['id_country'])?$filter['id_country']:'';?>" name="countryFilter_id_country" class="filter"></td>
		  <td><input type="text" value="<?php echo isset($filter['name'])?$filter['name']:'';?>" name="countryFilter_name" class="filter"></td>
		  <td class="center"><input type="text" value="<?php echo isset($filter['carrier_name'])?$filter['carrier_name']:'';?>" name="countryFilter_carrier_name" class="filter"></td>
		  <td><select name="countryFilter_active" onChange="$('#submitFilterButton').focus();$('#submitFilterButton').click();">
				  <option value="">--</option>
				  <option value="1" <?php if(isset($filter['active']) && $filter['active']==1){echo "selected";}?>>Yes</option>
				  <option value="2" <?php if(isset($filter['active']) && $filter['active']==2){echo "selected";}?>>No</option>
				</select></td>
		  <td><select name="countryFilter_need_state" onChange="$('#submitFilterButton').focus();$('#submitFilterButton').click();">
				  <option value="">--</option>
				  <option value="1" <?php if(isset($filter['need_state']) && $filter['need_state']==1){echo "selected";}?>>Yes</option>
				  <option value="2" <?php if(isset($filter['need_state']) && $filter['need_state']==2){echo "selected";}?>>No</option>
				</select></td>
		  <td>--</td>
		  <td align="right">--</td>
		</tr>
	   </thead>
		<?php 
		if(is_array($result['entitys']) && count($result['entitys'])>0){
		foreach($result['entitys'] as $key => $row){?>
		<tr class="<?php echo ($key%2?'alt_row':''); ?> row" id="tr_<?php echo $row['id_country'].'_'.(int)$row['position'];?>">
			<td><input type="checkbox" name="categoryBox[]" value="<?php echo $row['id_country'];?>" ></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=country_edit&id=<?php echo $row['id_country'];?>'"><?php echo $row['id_country'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=country_edit&id=<?php echo $row['id_country'];?>'"><?php echo $row['iso_code'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=country_edit&id=<?php echo $row['id_country'];?>'"><?php echo $row['name'];?></td>
			<td><a href="index.php?rule=country&toggle=active&id=<?php echo $row['id_country'];?>">
				<img src="<?php echo $_tmconfig['ico_dir'].($row['active']?'enabled.gif':'disabled.gif');?>" alt="<?php echo $row['active']?'开启':'关闭';?>"/></a></td>
			<td><a href="index.php?rule=country&toggle=need_state&id=<?php echo $row['id_country'];?>">
				<img src="<?php echo $_tmconfig['ico_dir'].($row['need_state']?'enabled.gif':'disabled.gif');?>" alt="<?php echo $row['need_state']?'开启':'关闭';?>"/></a></td>
			<td class="pointer dragHandle center" id="td_<?php echo $row['id_country'];?>">
					<a href="index.php?rule=country&id_country=<?php echo $row['id_country'];?>&way=1&position=<?php echo $row['position']+1;?>" <?php if($key+1==$result['total']){ echo 'style="display:none"'; }?>>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down.gif"></a>
					<a href="index.php?rule=country&id_country=<?php echo $row['id_country'];?>&way=0&position=<?php echo $row['position']-1;?>" <?php if($key==0){ echo 'style="display:none"'; }?>>
						<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up.gif"></a> 
			</td>
			<td align="right">
				<a href="index.php?rule=country_edit&id=<?php echo $row['id_country'];?>"><img alt="编辑" src="<?php echo $_tmconfig['ico_dir'];?>edit.gif"></a> 
				<a onclick="return confirm('你确定要删除？')" href="index.php?rule=country&id=<?php echo $row['id_country'];?>"><img alt="删除" src="<?php echo $_tmconfig['ico_dir'];?>delete.gif"></a>
			</td>
		</tr>
		<?php }
			}else{
		?>
		<tr><td colspan="8" align="center">暂无留言</td></tr>
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