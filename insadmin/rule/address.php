<?php

if(intval(Tools::getRequest('delete'))>0){
	$object = new Address(intval(Tools::getRequest('delete')));
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
	$address	= new Address();
		if($address->deleteSelection($select_cat))
			echo '<div class="conf">删除对象成功</div>';

}

$filter	 = $cookie->getFilter('address',array('id_address','name','address','city','id_state','id_country'));
if(Tools::isSubmit('submitResetAddress')){
	$cookie->unsetFilter('address',array('id_address','name','address','city','id_state','id_country'));
	$filter = array();
}

$orderBy 	= $cookie->getPost('addressOrderBy') ? $cookie->getPost('addressOrderBy') : 'id_address';
$orderWay 	= $cookie->getPost('addressOrderWay') ? $cookie->getPost('addressOrderWay') : 'ASC';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::getRequest('addressPage') ? Tools::getRequest('addressPage'):1;

$result  	= Address::getEntity(false,$p,$limit,$orderBy,$orderWay,$filter);

require_once(dirname(__FILE__).'/../errors.php');
?>
<script type="text/javascript" src="../js/jquery/jquery.tablednd_0_5.js"></script>
<script type="text/javascript">
	var token = '1f0af725a0585d7827c059999fd2d35e';
	var come_from = 'address';
	var alternate = '0';
</script>
<script src="../js/admin/dnd.js" type="text/javascript"></script>
<div class="path_bar">
	<div class="path_title">
		<h3> 
			<span style="font-weight: normal;" id="current_obj">
			<span class="breadcrumb item-1 ">客户地址</span></span>
		</h3>
	</div>
</div>
<form class="form" method="post" action="index.php?rule=address">
<table class="table_grid" name="list_table" width="100%">
<tr>
<td style="vertical-align: bottom;">
<span style="float: left;">
	<?php
		echo Helper::renderAdminPagaNation($result['total'],$limit,$p,'addressPage');
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
	<input type="submit" class="button" value="重置" name="submitResetAddress">
</span>
</td>
</tr>
<tr><td>
<div class="mianColForm">
	<table class="tableList table tableDnD" width="100%" cellpadding="0" cellspacing="0" id="address">
	<thead>
		<tr>
			<th><input type="checkbox" name="checkme" onclick="checkDelBoxes(this.form, 'categoryBox[]', this.checked)" ></th>
			<th>
				编号
				<a href="index.php?rule=address&addressOrderBy=id_address&addressOrderWay=desc" >
					<?php if(isset($orderBy) && $orderBy=='id_address' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a>
				<a href="index.php?rule=address&addressOrderBy=id_address&addressOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='id_address' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
				</a>
			</th>
			<th>
				客户
				<a href="index.php?rule=address&addressOrderBy=first_name&addressOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='first_name' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=address&addressOrderBy=first_name&addressOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='first_name' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
				</a>
			</th>
			<th>
				地址
				<a href="index.php?rule=address&addressOrderBy=address&addressOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='address' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=address&addressOrderBy=address&addressOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='address' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
			    </a>
			</th>
			<th>
				城市
				<a href="index.php?rule=address&addressOrderBy=city&addressOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='city' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=address&addressOrderBy=city&addressOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='city' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
			    </a>
			</th>
			<th>
				省/州
				<a href="index.php?rule=address&addressOrderBy=id_state&addressOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='id_state' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=address&addressOrderBy=id_state&addressOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='id_state' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
			    </a>
			</th>
			<th>
				国家
				<a href="index.php?rule=address&addressOrderBy=id_country&addressOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='id_country' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=address&addressOrderBy=id_country&addressOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='id_country' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
				</a> 
			</th>
			<th>
				日期
				<a href="index.php?rule=address&addressOrderBy=add_date&addressOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='add_date' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=address&addressOrderBy=add_date&addressOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='add_date' && isset($orderWay) && $orderWay=='asc'){ ?>
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
		  <td><input type="text" value="<?php echo isset($filter['id_address'])?$filter['id_address']:'';?>" name="addressFilter_id_address" class="filter" size="6"></td>
		  <td><input type="text" value="<?php echo isset($filter['name'])?$filter['name']:'';?>" name="addressFilter_name" class="filter"></td>
		  <td><input type="text" value="<?php echo isset($filter['address'])?$filter['address']:'';?>" name="addressFilter_address" class="filter"></td>
		  <td><input type="text" value="<?php echo isset($filter['city'])?$filter['city']:'';?>" name="addressFilter_city" class="filter"></td>
		  <td><input type="text" value="<?php echo isset($filter['state'])?$filter['state']:'';?>" name="addressFilter_id_state" class="filter"></td>
		  <td><input type="text" value="<?php echo isset($filter['id_country'])?$filter['id_country']:'';?>" name="addressFilter_id_country" class="filter"></td>
		  <td>--</td>
		  <td align="right">--</td>
		</tr>
	   </thead>
		<?php 
		if(is_array($result['entitys']) && count($result['entitys'])>0){
		foreach($result['entitys'] as $key => $row){?>
		<tr class="<?php echo ($key%2?'alt_row':''); ?> row" id="tr_<?php echo $row['id_address'];?>">
			<td><input type="checkbox" name="categoryBox[]" value="<?php echo $row['id_address'];?>" ></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=address_edit&id=<?php echo $row['id_address'];?>'"><?php echo $row['id_address'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=address_edit&id=<?php echo $row['id_address'];?>'"><?php echo $row['first_name'].' '.$row['last_name'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=address_edit&id=<?php echo $row['id_address'];?>'"><?php echo $row['address'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=address_edit&id=<?php echo $row['id_address'];?>'"><?php echo $row['city'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=address_edit&id=<?php echo $row['id_address'];?>'"><?php echo $row['id_state'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=address_edit&id=<?php echo $row['id_address'];?>'"><?php echo $row['id_country'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=address_edit&id=<?php echo $row['id_address'];?>'"><?php echo $row['add_date'];?></td>
			<td align="right">
				<a href="index.php?rule=address_edit&id=<?php echo $row['id_address'];?>"><img alt="编辑" src="<?php echo $_tmconfig['ico_dir'];?>edit.gif"></a> 
				<a onclick="return confirm('你确定要删除？')" href="index.php?rule=address&delete=<?php echo $row['id_address'];?>"><img alt="删除" src="<?php echo $_tmconfig['ico_dir'];?>delete.gif"></a>
			</td>
		</tr>
		<?php }
			}else{
		?>
		<tr><td colspan="6" align="center">暂无留言</td></tr>
		<?php }?>
	</table>
</div>
</td></tr>
<tr><td>
<p><input type="submit" onclick="return confirm('你确定要删除选中项目?');" value="删除选中项目" name="subDelete" class="button"></p>
</td></tr>
</table>
</form>