<?php

if(intval(Tools::getRequest('delete'))>0){
	$object = new Cart(intval(Tools::getRequest('delete')));
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
	$cart	= new Cart();
		if($cart->deleteSelection($select_cat))
			echo '<div class="conf">删除对象成功</div>';

}elseif(intval(Tools::getRequest('toggleStatus'))>0){
	$object = new Cart(intval(Tools::getRequest('toggleStatus')));
	if(Validate::isLoadedObject($object)){
		$object->toggleStatus();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		echo '<div class="conf">更新对象状态成功</div>';
	}
}

$filter	 = $cookie->getFilter('cart',array('id_cart','name','carrier_name'));
if(Tools::isSubmit('submitResetCart')){
	$cookie->unsetFilter('cart',array('id_cart','name','carrier_name'));
	$filter = array();
}

$orderBy 	= $cookie->getPost('cartOrderBy') ? $cookie->getPost('cartOrderBy') : 'id_cart';
$orderWay 	= $cookie->getPost('cartOrderWay') ? $cookie->getPost('cartOrderWay') : 'ASC';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::getRequest('cartPage') ? Tools::getRequest('cartPage'):1;

$result  	= Cart::getEntity(false,$p,$limit,$orderBy,$orderWay,$filter);

require_once(dirname(__FILE__).'/../errors.php');
?>
<script type="text/javascript" src="../js/jquery/jquery.tablednd_0_5.js"></script>
<script type="text/javascript">
	var token = '1f0af725a0585d7827c059999fd2d35e';
	var come_from = 'cart';
	var alternate = '0';
</script>
<script src="../js/admin/dnd.js" type="text/javascript"></script>
<div class="path_bar">
	<div class="path_title">
		<h3> 
			<span style="font-weight: normal;" id="current_obj">
			<span class="breadcrumb item-1 ">购物车</span> 
		</h3>
	</div>
</div>
<form class="form" method="post" action="index.php?rule=cart">
<table class="table_grid" name="list_table" width="100%">
<tr>
<td style="vertical-align: bottom;">
<span style="float: left;">
	<?php
		echo Helper::renderAdminPagaNation($result['total'],$limit,$p,'cartPage');
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
	<table class="tableList table tableDnD" width="100%" cellpadding="0" cellspacing="0" id="cart">
	<thead>
		<tr>
			<th><input type="checkbox" name="checkme" onclick="checkDelBoxes(this.form, 'categoryBox[]', this.checked)" ></th>
			<th>
				编号
				<a href="index.php?rule=cart&cartOrderBy=id_cart&cartOrderWay=desc" >
					<?php if(isset($orderBy) && $orderBy=='id_cart' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a>
				<a href="index.php?rule=cart&cartOrderBy=id_cart&cartOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='id_cart' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
				</a>
			</th>
			<th>
				客户
				<a href="index.php?rule=cart&cartOrderBy=first_name&cartOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='first_name' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=cart&cartOrderBy=first_name&cartOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='first_name' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
			</th>
			<th>总额</th>
			<th>
				配送
				<a href="index.php?rule=cart&cartOrderBy=id_carrier&cartOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='id_carrier' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=cart&cartOrderBy=id_carrier&cartOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='id_carrier' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
				</a> 
			</th>
			<th>
				状态
				<a href="index.php?rule=cart&cartOrderBy=status&cartOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='status' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=cart&cartOrderBy=status&cartOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='status' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
				</a> 
			</th>
			<th>
				日期
				<a href="index.php?rule=cart&cartOrderBy=add_date&cartOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='add_date' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=cart&cartOrderBy=add_date&cartOrderWay=asc">
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
		  <td class="center"><input type="text" style="width:40px" value="<?php echo isset($filter['id_cart'])?$filter['id_cart']:'';?>" name="cartFilter_id_cart" class="filter"></td>
		  <td><input type="text" value="<?php echo isset($filter['name'])?$filter['name']:'';?>" name="cartFilter_name" class="filter"></td>
		  <td>--</td>
		  <td class="center"><input type="text" style="width:200px" value="<?php echo isset($filter['carrier_name'])?$filter['carrier_name']:'';?>" name="cartFilter_carrier_name" class="filter"></td>
		  <td>--</td>
		  <td align="right">--</td>
		</tr>
	   </thead>
		<?php 
		if(is_array($result['entitys']) && count($result['entitys'])>0){
		foreach($result['entitys'] as $key => $row){?>
		<tr class="<?php echo ($key%2?'alt_row':''); ?> row" id="tr_<?php echo $row['id_cart'];?>">
			<td><input type="checkbox" name="categoryBox[]" value="<?php echo $row['id_cart'];?>" ></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=cart_edit&id=<?php echo $row['id_cart'];?>'"><?php echo $row['id_cart'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=cart_edit&id=<?php echo $row['id_cart'];?>'"><?php echo $row['first_name'].' '.$row['last_name'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=cart_edit&id=<?php echo $row['id_cart'];?>'"><b><?php echo Tools::displayPrice($row['total']);?></b></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=cart_edit&id=<?php echo $row['id_cart'];?>'"><?php echo $row['carrier_name'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=cart_edit&id=<?php echo $row['id_cart'];?>'"><?php echo $row['status'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=cart_edit&id=<?php echo $row['id_cart'];?>'"><?php echo $row['add_date'];?></td>
			<td align="right">
				<a href="index.php?rule=cart_edit&id=<?php echo $row['id_cart'];?>"><img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>details.gif"></a> 
				<a onclick="return confirm('你确定要删除？')" href="index.php?rule=cart&id=<?php echo $row['id_cart'];?>"><img alt="删除" src="<?php echo $_tmconfig['ico_dir'];?>delete.gif"></a>
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