<?php

if(intval(Tools::getRequest('delete'))>0){
	$object = new OrderStatus(intval(Tools::getRequest('delete')));
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
	$order	= new OrderStatus();
		if($order->deleteSelection($select_cat))
			echo '<div class="conf">删除对象成功</div>';

}elseif(Tools::getRequest('toggle') && intval(Tools::getRequest('id'))>0){
	$object = new OrderStatus((int)(Tools::getRequest('id')));
	if(Validate::isLoadedObject($object)){
		$object->toggle(Tools::getRequest('toggle'));
	}

	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		echo '<div class="conf">更新对象成功</div>';
	}
}

$filter	 = $cookie->getFilter('order',array('id_order_status','name','carrier_name'));
if(Tools::isSubmit('submitResetOrderStatus')){
	$cookie->unsetFilter('order',array('id_order_status','name','carrier_name'));
	$filter = array();
}

$orderBy 	= $cookie->getPost('orderstatusOrderBy') ? $cookie->getPost('orderstatusOrderBy') : 'id_order_status';
$orderWay 	= $cookie->getPost('orderstatusOrderWay') ? $cookie->getPost('orderstatusOrderWay') : 'ASC';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::getRequest('orderPage') ? Tools::getRequest('orderPage'):1;

$result  	= OrderStatus::getEntity(false,$p,$limit,$orderBy,$orderWay,$filter);

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
			<span class="breadcrumb item-1 ">定单状态</span></span>
		</h3>
		<div class="cc_button">
		<ul>
        	<li><a title="添加定单状态" href="index.php?rule=order_status_edit" class="toolbar_btn" id="add_onepage">
				<span class="process-icon-new"></span>
				<div>添加定单状态</div>
			</a></li>
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
				<a href="index.php?rule=order_status&order_statusOrderBy=id_order_status&order_statusOrderWay=desc" >
					<?php if(isset($orderBy) && $orderBy=='id_order_status' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a>
				<a href="index.php?rule=order_status&order_statusOrderBy=id_order_status&order_statusOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='id_order_status' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
				</a>

			</th>
			<th>
				状态名
				<a href="index.php?rule=order_status&order_statusOrderBy=name&order_statusOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='name' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=order_status&order_statusOrderBy=name&order_statusOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='name' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
			</th>
			<th>发送邮件
				<a href="index.php?rule=order_status&order_statusOrderBy=send_mail&order_statusOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='send_mail' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=order_status&order_statusOrderBy=send_mail&order_statusOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='send_mail' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
			</th>
			<th>
				邮件模板
				<a href="index.php?rule=order_status&order_statusOrderBy=email_tpl&order_statusOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='email_tpl' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=order_status&order_statusOrderBy=email_tpl&order_statusOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='email_tpl' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
				</a> 
			</th>
			<th>
				状态
				<a href="index.php?rule=order_status&order_statusOrderBy=active&order_statusOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='active' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=order_status&order_statusOrderBy=active&order_statusOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='active' && isset($orderWay) && $orderWay=='asc'){ ?>
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
		  <td class="center"><input type="text" style="width:40px" value="<?php echo isset($filter['id_order_status'])?$filter['id_order_status']:'';?>" name="orderFilter_id_order_status" class="filter"></td>
		  <td><input type="text" value="<?php echo isset($filter['name'])?$filter['name']:'';?>" name="orderFilter_name" class="filter"></td>
		  <td>--</td>
		  <td class="center"><input type="text" style="width:200px" value="<?php echo isset($filter['carrier_name'])?$filter['carrier_name']:'';?>" name="orderFilter_carrier_name" class="filter"></td>
		  <td>--</td>
		  <td align="right">--</td>
		</tr>
	   </thead>
		<?php 
		if(is_array($result['entitys']) && count($result['entitys'])>0){
		foreach($result['entitys'] as $key => $row){?>
		<tr class="<?php echo ($key%2?'alt_row':''); ?> row" id="tr_<?php echo $row['id_order_status'];?>">
			<td><input type="checkbox" name="categoryBox[]" value="<?php echo $row['id_order_status'];?>" ></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=order_status_edit&id=<?php echo $row['id_order_status'];?>'"><?php echo $row['id_order_status'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=order_status_edit&id=<?php echo $row['id_order_status'];?>'">
				<span class="color_field" style="background-color:<?php echo $row['color'];?>;color:white"><?php echo $row['name'];?></span></td>
			<td><a href="index.php?rule=order_status&toggle=send_mail&id=<?php echo $row['id_order_status'];?>">
				<img src="<?php echo $_tmconfig['ico_dir'].($row['send_mail']?'enabled.gif':'disabled.gif');?>" alt="<?php echo $row['send_mail']?'开启':'关闭';?>"/></a></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=order_status_edit&id=<?php echo $row['id_order_status'];?>'"><?php echo $row['email_tpl'];?></td>
			<td><a href="index.php?rule=order_status&toggle=active&id=<?php echo $row['id_order_status'];?>">
				<img src="<?php echo $_tmconfig['ico_dir'].($row['active']?'enabled.gif':'disabled.gif');?>" alt="<?php echo $row['active']?'开启':'关闭';?>"/></a></td>
			<td align="right">
				<a href="index.php?rule=order_status_edit&id=<?php echo $row['id_order_status'];?>"><img alt="编辑" src="<?php echo $_tmconfig['ico_dir'];?>edit.gif"></a>
				<a onclick="return confirm('你确定要删除？')" href="index.php?rule=order_status&id=<?php echo $row['id_order_status'];?>"><img alt="删除" src="<?php echo $_tmconfig['ico_dir'];?>delete.gif"></a>
			</td>
		</tr>
		<?php }
			}else{
		?>
		<tr><td colspan="6" align="center">暂无状态</td></tr>
		<?php }?>
	</table>
</div>
</td></tr>
<tr><td>
<p><input type="submit" onclick="return confirm('你确定要删除选中项目?');" value="删除选中项目" name="subDelete" class="button"></p>
</td></tr>
</table>
</form>