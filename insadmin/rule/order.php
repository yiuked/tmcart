<?php

if(intval(Tools::getRequest('delete'))>0){
	$object = new Order(intval(Tools::getRequest('delete')));
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
	$order	= new Order();
		if($order->deleteSelection($select_cat))
			echo '<div class="conf">删除对象成功</div>';

}elseif(intval(Tools::getRequest('toggleStatus'))>0){
	$object = new Order(intval(Tools::getRequest('toggleStatus')));
	if(Validate::isLoadedObject($object)){
		$object->toggleStatus();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		echo '<div class="conf">更新对象状态成功</div>';
	}
}

$filter	 = $cookie->getFilter('order',array('id_order','name','carrier','amount','payment','status'));
if(Tools::isSubmit('submitResetOrder')){
	$cookie->unsetFilter('order',array('id_order','name','carrier','amount','payment','status'));
	$filter = array();
}

$orderBy 	= $cookie->getPost('orderOrderBy') ? $cookie->getPost('orderOrderBy') : 'id_order';
$orderWay 	= $cookie->getPost('orderOrderWay') ? $cookie->getPost('orderOrderWay') : 'DESC';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::getRequest('orderPage') ? Tools::getRequest('orderPage'):1;

$result  	= Order::getEntity(false,$p,$limit,$orderBy,$orderWay,$filter);

require_once(dirname(__FILE__).'/../errors.php');
?>
<script type="text/javascript" src="../js/jquery/jquery.tablednd_0_5.js"></script>
<script type="text/javascript">
	var token = '1f0af725a0585d7827c059999fd2d35e';
	var come_from = 'order';
	var alternate = '0';
</script>
<script src="../js/admin/dnd.js" type="text/javascript"></script>
<div class="path_bar">
	<div class="path_title">
		<h3> 
			<span style="font-weight: normal;" id="current_obj">
			<span class="breadcrumb item-1 ">客户定单</span> 
		</h3>
		<div class="cc_button">
		  <ul>
			<li><a title="定单提交设置" href="index.php?rule=sendorder" class="toolbar_btn" id="desc-product-tools"> <span class="process-icon-tools"></span>
			  <div>定单提交设置</div>
			  </a> </li>
		  </ul>
		</div>
	</div>
</div>
<form class="form" method="post" action="index.php?rule=order">
<table class="table_grid" name="list_table" width="100%">
<tr>
<td style="vertical-align: bottom;">
<span style="float: left;">
	<?php
		echo Helper::renderAdminPagaNation($result['total'],$limit,$p,'orderPage');
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
	<table class="tableList table tableDnD" width="100%" cellpadding="0" cellspacing="0" id="order">
	<thead>
		<tr>
			<th><input type="checkbox" name="checkme" onclick="checkDelBoxes(this.form, 'categoryBox[]', this.checked)" ></th>
			<th>
				编号
				<a href="index.php?rule=order&orderOrderBy=id_order&orderOrderWay=desc" >
					<?php if(isset($orderBy) && $orderBy=='id_order' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a>
				<a href="index.php?rule=order&orderOrderBy=id_order&orderOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='id_order' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
				</a>
			</th>
			<th>
				编号
				<a href="index.php?rule=order&orderOrderBy=id_cart&orderOrderWay=desc" >
					<?php if(isset($orderBy) && $orderBy=='id_cart' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a>
				<a href="index.php?rule=order&orderOrderBy=id_cart&orderOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='id_cart' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
				</a>
			</th>
			<th>
				客户
				<a href="index.php?rule=order&orderOrderBy=first_name&orderOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='first_name' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=order&orderOrderBy=first_name&orderOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='first_name' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
			</th>
			<th>总额</th>
			<th>
				配送
				<a href="index.php?rule=order&orderOrderBy=id_carrier&orderOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='id_carrier' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=order&orderOrderBy=id_carrier&orderOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='id_carrier' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
				</a> 
			</th>
			<th>
				支付方式
				<a href="index.php?rule=order&orderOrderBy=payment&orderOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='payment' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=order&orderOrderBy=payment&orderOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='payment' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
				</a> 
			</th>
			<th>
				状态
				<a href="index.php?rule=order&orderOrderBy=status&orderOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='status' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=order&orderOrderBy=status&orderOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='status' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
				</a> 
			</th>
			<th>
				日期
				<a href="index.php?rule=order&orderOrderBy=add_date&orderOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='add_date' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=order&orderOrderBy=add_date&orderOrderWay=asc">
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
		  <td class="center"><input type="text" style="width:40px" value="<?php echo isset($filter['id_order'])?$filter['id_order']:'';?>" name="orderFilter_id_order" class="filter"></td>
		  <td class="center"><input type="text" style="width:40px" value="<?php echo isset($filter['id_cart'])?$filter['id_cart']:'';?>" name="orderFilter_id_cart" class="filter"></td>
		  <td><input type="text" value="<?php echo isset($filter['name'])?$filter['name']:'';?>" name="orderFilter_name" class="filter"></td>
		  <td><input type="text" value="<?php echo isset($filter['amount'])?$filter['amount']:'';?>" name="orderFilter_amount" class="filter"></td>
		  <td><input type="text" value="<?php echo isset($filter['carrier'])?$filter['carrier']:'';?>" name="orderFilter_carrier" class="filter"></td>
		  <td><input type="text" value="<?php echo isset($filter['payment'])?$filter['payment']:'';?>" name="orderFilter_payment" class="filter"></td>
		  <td><input type="text" value="<?php echo isset($filter['status'])?$filter['status']:'';?>" name="orderFilter_status" class="filter"></td>
		  <td>--</td>
		  <td align="right">--</td>
		</tr>
	   </thead>
		<?php 
		if(is_array($result['entitys']) && count($result['entitys'])>0){
		foreach($result['entitys'] as $key => $row){?>
		<tr class="<?php echo ($key%2?'alt_row':''); ?> row" id="tr_<?php echo $row['id_order'];?>">
			<td><input type="checkbox" name="categoryBox[]" value="<?php echo $row['id_order'];?>" ></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=order_edit&id=<?php echo $row['id_order'];?>'"><?php echo $row['id_order'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=order_edit&id=<?php echo $row['id_order'];?>'"><?php echo $row['id_cart'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=order_edit&id=<?php echo $row['id_order'];?>'"><?php echo $row['first_name'].' '.$row['last_name'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=order_edit&id=<?php echo $row['id_order'];?>'"><b><?php echo Tools::displayPrice($row['amount']);?></b></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=order_edit&id=<?php echo $row['id_order'];?>'"><?php echo $row['carrier'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=order_edit&id=<?php echo $row['id_order'];?>'"><?php echo $row['id_module'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=order_edit&id=<?php echo $row['id_order'];?>'">
				<span class="color_field" style="background-color:<?php echo $row['color'];?>;color:white"><?php echo $row['status'];?></span></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=order_edit&id=<?php echo $row['id_order'];?>'"><?php echo $row['add_date'];?></td>
			<td align="right">
				<a href="index.php?rule=order_edit&id=<?php echo $row['id_order'];?>"><img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>details.gif"></a> 
				<a onclick="return confirm('你确定要删除？')" href="index.php?rule=order&delete=<?php echo $row['id_order'];?>"><img alt="删除" src="<?php echo $_tmconfig['ico_dir'];?>delete.gif"></a>
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
<p><input type="submit" onclick="return confirm('你确定要删除选中项目?');" value="删除选中项目" name="subDelete" class="button"></p>
</td></tr>
</table>
</form>