<?php

if(intval(Tools::getRequest('delete'))>0){
	$object = new Paylog(intval(Tools::getRequest('delete')));
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
	$paylog	= new Paylog();
		if($paylog->deleteSelection($select_cat))
			echo '<div class="conf">删除对象成功</div>';

}

$filter	 = $cookie->getFilter('paylog',array('id_pay','id_user','off','amount','use','active'));
if(Tools::isSubmit('submitResetPaylog')){
	$cookie->unsetFilter('paylog',array('id_pay','id_user','off','amount','use','active'));
	$filter = array();
}

$orderBy 	= $cookie->getPost('paylogOrderBy') ? $cookie->getPost('paylogOrderBy') : 'id_pay';
$orderWay 	= $cookie->getPost('paylogOrderWay') ? $cookie->getPost('paylogOrderWay') : 'DESC';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::getRequest('paylogPage') ? Tools::getRequest('paylogPage'):1;

$result  	= Paylog::getEntity(false,$p,$limit,$orderBy,$orderWay,$filter);

require_once(dirname(__FILE__).'/../errors.php');
?>
<script type="text/javascript" src="../js/jquery/jquery.tablednd_0_5.js"></script>
<script type="text/javascript">
	var token = '1f0af725a0585d7827c059999fd2d35e';
	var come_from = 'paylog';
	var alternate = '0';
</script>
<script src="../js/admin/dnd.js" type="text/javascript"></script>
<div class="path_bar">
	<div class="path_title">
		<h3> 
			<span style="font-weight: normal;" id="current_obj">
			<span class="breadcrumb item-1 ">支付日志</span></span>
		</h3>
	</div>
</div>
<form class="form" method="post" action="index.php?rule=paylog">
<table class="table_grid" name="list_table" width="100%">
<tr>
<td style="vertical-align: bottom;">
<span style="float: left;">
	<?php
		echo Helper::renderAdminPagaNation($result['total'],$limit,$p,'paylogPage');
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
	<input type="submit" class="button" value="重置" name="submitResetPaylog">
</span>
</td>
</tr>
<tr><td>
<div class="mianColForm">
	<table class="tableList table tableDnD" width="100%" cellpadding="0" cellspacing="0" id="paylog">
	<thead>
		<tr>
			<th><input type="checkbox" name="checkme" onclick="checkDelBoxes(this.form, 'categoryBox[]', this.checked)" ></th>
			<th>
				编号
				<a href="index.php?rule=paylog&paylogOrderBy=id_pay&paylogOrderWay=desc" >
					<?php if(isset($orderBy) && $orderBy=='id_pay' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a>
				<a href="index.php?rule=paylog&paylogOrderBy=id_pay&paylogOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='id_pay' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
				</a>
			</th>
			<th>
				id_cart
				<a href="index.php?rule=paylog&paylogOrderBy=id_user&paylogOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='id_user' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=paylog&paylogOrderBy=id_user&paylogOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='id_user' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
				</a>
			</th>
			<th>
				code
				<a href="index.php?rule=paylog&paylogOrderBy=code&paylogOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='code' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=paylog&paylogOrderBy=code&paylogOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='code' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
			    </a>
			</th>
			<th>
				msg
				<a href="index.php?rule=paylog&paylogOrderBy=off&paylogOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='off' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=paylog&paylogOrderBy=off&paylogOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='off' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
			    </a>
			</th>
			<th>
				添加日期
				<a href="index.php?rule=paylog&paylogOrderBy=add_date&paylogOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='add_date' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=paylog&paylogOrderBy=add_date&paylogOrderWay=asc">
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
		  <td><input type="text" value="<?php echo isset($filter['id_pay'])?$filter['id_pay']:'';?>" name="paylogFilter_id_pay" class="filter" size="6"></td>
		  <td><input type="text" value="<?php echo isset($filter['id_user'])?$filter['id_cart']:'';?>" name="paylogFilter_id_cart" class="filter"></td>
		  <td><input type="text" value="<?php echo isset($filter['code'])?$filter['code']:'';?>" name="paylogFilter_code" class="filter"></td>
		  <td><input type="text" value="<?php echo isset($filter['off'])?$filter['msg']:'';?>" name="paylogFilter_msg" class="filter"></td>
		  <td>--</td>
		  <td align="right">--</td>
		</tr>
	   </thead>
		<?php 
		if(is_array($result['entitys']) && count($result['entitys'])>0){
		foreach($result['entitys'] as $key => $row){?>
		<tr class="<?php echo ($key%2?'alt_row':''); ?> row" id="tr_<?php echo $row['id_pay'];?>">
			<td><input type="checkbox" name="categoryBox[]" value="<?php echo $row['id_pay'];?>" ></td>
			<td class="pointer"><?php echo $row['id_pay'];?></td>
			<td class="pointer"><?php echo $row['id_cart'];?></td>
			<td class="pointer"><?php echo $row['code'];?></td>
			<td class="pointer"><?php echo $row['msg'];?></td>
			<td class="pointer"><?php echo $row['add_date'];?></td>
			<td align="right">
				<a onclick="return confirm('你确定要删除？')" href="index.php?rule=paylog&delete=<?php echo $row['id_pay'];?>">
				<img alt="删除" src="<?php echo $_tmconfig['ico_dir'];?>delete.gif"></a>
			</td>
		</tr>
		<?php }
			}else{
		?>
		<tr><td colspan="6" align="center">暂无日志</td></tr>
		<?php }?>
	</table>
</div>
</td></tr>
<tr><td>
<p><input type="submit" onclick="return confirm('你确定要删除选中项目?');" value="删除选中项目" name="subDelete" class="button"></p>
</td></tr>
</table>
</form>