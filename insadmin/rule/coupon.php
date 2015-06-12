<?php

if(intval(Tools::getRequest('delete'))>0){
	$object = new Coupon(intval(Tools::getRequest('delete')));
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
	$coupon	= new Coupon();
		if($coupon->deleteSelection($select_cat))
			echo '<div class="conf">删除对象成功</div>';

}elseif(intval(Tools::getRequest('toggleStatus'))>0){
	$object = new Coupon(intval(Tools::getRequest('toggleStatus')));
	if(Validate::isLoadedObject($object)){
		$object->toggleStatus();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		echo '<div class="conf">更新分类状态成功</div>';
	}
}

$filter	 = $cookie->getFilter('coupon',array('id_coupon','id_user','off','amount','use','active'));
if(Tools::isSubmit('submitResetCoupon')){
	$cookie->unsetFilter('coupon',array('id_coupon','id_user','off','amount','use','active'));
	$filter = array();
}

$orderBy 	= $cookie->getPost('couponOrderBy') ? $cookie->getPost('couponOrderBy') : 'id_coupon';
$orderWay 	= $cookie->getPost('couponOrderWay') ? $cookie->getPost('couponOrderWay') : 'ASC';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::getRequest('couponPage') ? Tools::getRequest('couponPage'):1;

$result  	= Coupon::getEntity(false,$p,$limit,$orderBy,$orderWay,$filter);

require_once(dirname(__FILE__).'/../errors.php');
?>
<script type="text/javascript" src="../js/jquery/jquery.tablednd_0_5.js"></script>
<script type="text/javascript">
	var token = '1f0af725a0585d7827c059999fd2d35e';
	var come_from = 'coupon';
	var alternate = '0';
</script>
<script src="../js/admin/dnd.js" type="text/javascript"></script>
<div class="path_bar">
	<div class="path_title">
		<h3> 
			<span style="font-weight: normal;" id="current_obj">
			<span class="breadcrumb item-1 ">促销码</span></span>
		</h3>
		<div class="cc_button">
		<ul>
        <li><a title="添加促销码" href="index.php?rule=coupon_edit" class="toolbar_btn" id="add_brand">
				<span class="process-icon-new "></span>
				<div>添加促销码</div>
			</a></li>
      </ul>
		</div>
	</div>
</div>
<form class="form" method="post" action="index.php?rule=coupon">
<table class="table_grid" name="list_table" width="100%">
<tr>
<td style="vertical-align: bottom;">
<span style="float: left;">
	<?php
		echo Helper::renderAdminPagaNation($result['total'],$limit,$p,'couponPage');
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
	<input type="submit" class="button" value="重置" name="submitResetCoupon">
</span>
</td>
</tr>
<tr><td>
<div class="mianColForm">
	<table class="tableList table tableDnD" width="100%" cellpadding="0" cellspacing="0" id="coupon">
	<thead>
		<tr>
			<th><input type="checkbox" name="checkme" onclick="checkDelBoxes(this.form, 'categoryBox[]', this.checked)" ></th>
			<th>
				编号
				<a href="index.php?rule=coupon&couponOrderBy=id_coupon&couponOrderWay=desc" >
					<?php if(isset($orderBy) && $orderBy=='id_coupon' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a>
				<a href="index.php?rule=coupon&couponOrderBy=id_coupon&couponOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='id_coupon' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
				</a>
			</th>
			<th>
				客户
				<a href="index.php?rule=coupon&couponOrderBy=id_user&couponOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='id_user' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=coupon&couponOrderBy=id_user&couponOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='id_user' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
				</a>
			</th>
			<th>
				促销码
				<a href="index.php?rule=coupon&couponOrderBy=code&couponOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='code' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=coupon&couponOrderBy=code&couponOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='code' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
			    </a>
			</th>
			<th>
				优惠幅度
				<a href="index.php?rule=coupon&couponOrderBy=off&couponOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='off' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=coupon&couponOrderBy=off&couponOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='off' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
			    </a>
			</th>
			<th>
				优惠金额
				<a href="index.php?rule=coupon&couponOrderBy=amount&couponOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='amount' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=coupon&couponOrderBy=amount&couponOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='amount' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
			    </a>
			</th>
			<th>
				使用次数
				<a href="index.php?rule=coupon&couponOrderBy=use&couponOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='use' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=coupon&couponOrderBy=use&couponOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='use' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
				</a> 
			</th>
			<th>
				状态
				<a href="index.php?rule=coupon&couponOrderBy=active&couponOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='active' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=coupon&couponOrderBy=active&couponOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='active' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down.gif">
					<?php } ?>
				</a> 
			</th>
			<th>
				添加日期
				<a href="index.php?rule=coupon&couponOrderBy=add_date&couponOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='add_date' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=coupon&couponOrderBy=add_date&couponOrderWay=asc">
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
		  <td><input type="text" value="<?php echo isset($filter['id_coupon'])?$filter['id_coupon']:'';?>" name="couponFilter_id_coupon" class="filter" size="6"></td>
		  <td><input type="text" value="<?php echo isset($filter['id_user'])?$filter['id_user']:'';?>" name="couponFilter_id_user" class="filter"></td>
		  <td><input type="text" value="<?php echo isset($filter['code'])?$filter['code']:'';?>" name="couponFilter_code" class="filter"></td>
		  <td><input type="text" value="<?php echo isset($filter['off'])?$filter['off']:'';?>" name="couponFilter_off" class="filter"></td>
		  <td><input type="text" value="<?php echo isset($filter['amount'])?$filter['amount']:'';?>" name="couponFilter_id_amount" class="filter"></td>
		  <td><input type="text" value="<?php echo isset($filter['use'])?$filter['use']:'';?>" name="couponFilter_use" class="filter"></td>
		  <td>
		  	<select name="couponFilter_active" onChange="$('#submitFilterButton').focus();$('#submitFilterButton').click();">
			  <option value="">--</option>
			  <option value="1" <?php if(isset($filter['active']) && $filter['active']==1){echo "selected";}?>>Yes</option>
			  <option value="0" <?php if(isset($filter['active']) && $filter['active']==2){echo "selected";}?>>No</option>
			</select>
		  </td>
		  <td>--</td>
		  <td align="right">--</td>
		</tr>
	   </thead>
		<?php 
		if(is_array($result['entitys']) && count($result['entitys'])>0){
		foreach($result['entitys'] as $key => $row){?>
		<tr class="<?php echo ($key%2?'alt_row':''); ?> row" id="tr_<?php echo $row['id_coupon'];?>">
			<td><input type="checkbox" name="categoryBox[]" value="<?php echo $row['id_coupon'];?>" ></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=coupon_edit&id=<?php echo $row['id_coupon'];?>'"><?php echo $row['id_coupon'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=coupon_edit&id=<?php echo $row['id_coupon'];?>'"><?php echo $row['id_user'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=coupon_edit&id=<?php echo $row['id_coupon'];?>'"><?php echo $row['code'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=coupon_edit&id=<?php echo $row['id_coupon'];?>'"><?php echo $row['off'];?>%</td>
			<td class="pointer" onclick="document.location = 'index.php?rule=coupon_edit&id=<?php echo $row['id_coupon'];?>'"><?php echo $row['amount'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=coupon_edit&id=<?php echo $row['id_coupon'];?>'"><?php echo $row['use'];?></td>
			<td class="pointer"><a href="index.php?rule=coupon&toggleStatus=<?php echo $row['id_coupon'];?>">
				<img src="<?php echo $_tmconfig['tm_img_dir'].'/icon/'.($row['active']?'enabled.gif':'disabled.gif');?>" alt="<?php echo $row['active']?'开启':'关闭';?>"/></a></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=coupon_edit&id=<?php echo $row['id_coupon'];?>'"><?php echo $row['add_date'];?></td>
			<td align="right">
				<a href="index.php?rule=coupon_edit&id=<?php echo $row['id_coupon'];?>"><img alt="编辑" src="<?php echo $_tmconfig['ico_dir'];?>edit.gif"></a> 
				<a onclick="return confirm('你确定要删除？')" href="index.php?rule=coupon&delete=<?php echo $row['id_coupon'];?>"><img alt="删除" src="<?php echo $_tmconfig['ico_dir'];?>delete.gif"></a>
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