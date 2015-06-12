<?php

if(intval(Tools::getRequest('delete'))>0){
	$object = new Carrier(intval(Tools::getRequest('delete')));
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
	$carrier	= new Carrier();
		if($carrier->deleteSelection($select_cat))
			echo '<div class="conf">删除对象成功</div>';

}elseif(intval(Tools::getRequest('toggleStatus'))>0){
	$object = new Carrier(intval(Tools::getRequest('toggleStatus')));
	if(Validate::isLoadedObject($object)){
		$object->toggleStatus();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		echo '<div class="conf">更新对象状态成功</div>';
	}
}

$filter	 = $cookie->getFilter('carrier',array('id_carrier','name','logo','descriptoin','shipping','active'));
if(Tools::isSubmit('submitResetCarrier')){
	$cookie->unsetFilter('carrier',array('id_carrier','name','logo','descriptoin','shipping','active'));
	$filter = array();
}

$orderBy 	= $cookie->getPost('carrierOrderBy') ? $cookie->getPost('carrierOrderBy') : 'id_carrier';
$orderWay 	= $cookie->getPost('carrierOrderWay') ? $cookie->getPost('carrierOrderWay') : 'ASC';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::getRequest('carrierPage') ? Tools::getRequest('carrierPage'):1;

$result  	= Carrier::getEntity(false,$p,$limit,$orderBy,$orderWay,$filter);

if(isset($_POST['setDefaultCarrierID']))
{
	if($def_carrier_id = Tools::getRequest('TM_DEFAULT_CARRIER_ID'))
		Configuration::updateValue('TM_DEFAULT_CARRIER_ID',$def_carrier_id);
	if($enjoy_freeshipping = Tools::getRequest('ENJOY_FREE_SHIPPING'))
		Configuration::updateValue('ENJOY_FREE_SHIPPING',$enjoy_freeshipping);
	echo '<div class="conf">更新成功</div>';
}

require_once(dirname(__FILE__).'/../errors.php');
?>
<script type="text/javascript" src="../js/jquery/jquery.tablednd_0_5.js"></script>
<script type="text/javascript">
	var token = '1f0af725a0585d7827c059999fd2d35e';
	var come_from = 'carrier';
	var alternate = '0';
</script>
<script src="../js/admin/dnd.js" type="text/javascript"></script>
<div class="path_bar">
	<div class="path_title">
		<h3> 
			<span style="font-weight: normal;" id="current_obj">
			<span class="breadcrumb item-1 ">物流</span> 
		</h3>
		<div class="cc_button">
		<ul>
        <li><a title="添加物流" href="index.php?rule=carrier_edit" class="toolbar_btn" id="add_carrier">
				<span class="process-icon-new "></span>
				<div>添加物流</div>
			</a></li>
      </ul>
		</div>
	</div>
</div>
<form class="form" method="post" action="index.php?rule=carrier">
<table class="table_grid" name="list_table" width="100%">
<tr>
<td style="vertical-align: bottom;">
<span style="float: left;">
	<?php
		echo Helper::renderAdminPagaNation($result['total'],$limit,$p,'carrierPage');
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
	<table class="tableList table tableDnD" width="100%" cellpadding="0" cellspacing="0" id="carrier">
	<thead>
		<tr>
			<th><input type="checkbox" name="checkme" onclick="checkDelBoxes(this.form, 'categoryBox[]', this.checked)" ></th>
			<th>
				编号
				<a href="index.php?rule=carrier&carrierOrderBy=id_carrier&carrierOrderWay=desc" >
					<?php if(isset($orderBy) && $orderBy=='id_carrier' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a>
				<a href="index.php?rule=carrier&carrierOrderBy=id_carrier&carrierOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='id_carrier' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
				</a>
			</th>
			<th>
				配送商
				<a href="index.php?rule=carrier&carrierOrderBy=name&carrierOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='name' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=carrier&carrierOrderBy=name&carrierOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='name' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
			</th>
			<th>
				LOGO
				<a href="index.php?rule=carrier&carrierOrderBy=logo&carrierOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='logo' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=carrier&carrierOrderBy=logo&carrierOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='logo' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
			</th>
			<th>
				描述
				<a href="index.php?rule=carrier&carrierOrderBy=description&carrierOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='description' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=carrier&carrierOrderBy=description&carrierOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='description' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
				</a> 
			</th>
			<th>
			运费
				<a href="index.php?rule=carrier&carrierOrderBy=shipping&carrierOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='shipping' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=carrier&carrierOrderBy=shipping&carrierOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='shipping' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
				</a> 
			</th>
			<th>
				状态
				<a href="index.php?rule=carrier&carrierOrderBy=active&carrierOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='active' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=carrier&carrierOrderBy=active&carrierOrderWay=asc">
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
		  <td class="center"><input type="text" style="width:40px" value="<?php echo isset($filter['id_carrier'])?$filter['id_carrier']:'';?>" name="carrierFilter_id_carrier" class="filter"></td>
		  <td><input type="text" value="<?php echo isset($filter['name'])?$filter['name']:'';?>" name="carrierFilter_name" class="filter"></td>
		  <td class="center"><input type="text" value="<?php echo isset($filter['logo'])?$filter['logo']:'';?>" name="carrierFilter_logo" class="filter"></td>
		  <td class="center"><input type="text" value="<?php echo isset($filter['description'])?$filter['description']:'';?>" name="carrierFilter_description" class="filter"></td>
		  <td class="center"><input type="text" value="<?php echo isset($filter['shipping'])?$filter['shipping']:'';?>" name="carrierFilter_shipping" class="filter"></td>
		  <td class="center">
		  	<select name="carrierFilter_active" onChange="$('#submitFilterButton').focus();$('#submitFilterButton').click();">
			  <option value="">--</option>
			  <option value="1" <?php if(isset($filter['active']) && $filter['active']==1){echo "selected";}?>>Yes</option>
			  <option value="2" <?php if(isset($filter['active']) && $filter['active']==2){echo "selected";}?>>No</option>
			</select>
		  </td>
		  <td align="right">--</td>
		</tr>
	   </thead>
		<?php 
		if(is_array($result['entitys']) && count($result['entitys'])>0){
		foreach($result['entitys'] as $key => $row){?>
		<tr class="<?php echo ($key%2?'alt_row':''); ?> row" id="tr_<?php echo $row['id_carrier'];?>">
			<td><input type="checkbox" name="categoryBox[]" value="<?php echo $row['id_carrier'];?>" ></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=carrier_edit&id=<?php echo $row['id_carrier'];?>'"><?php echo $row['id_carrier'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=carrier_edit&id=<?php echo $row['id_carrier'];?>'"><?php echo $row['name'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=carrier_edit&id=<?php echo $row['id_carrier'];?>'"><img src="<?php echo $_tmconfig['car_dir'].$row['logo'];?>" alt="<?php echo $row['name'];?>"></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=carrier_edit&id=<?php echo $row['id_carrier'];?>'"><?php echo $row['description'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=carrier_edit&id=<?php echo $row['id_carrier'];?>'"><?php echo $row['shipping'];?></td>
			<td><a href="index.php?rule=carrier&toggleStatus=<?php echo $row['id_carrier'];?>"><img src="<?php echo $_tmconfig['tm_img_dir'].'/icon/'.($row['active']?'enabled.gif':'disabled.gif');?>" alt="<?php echo $row['active']?'开启':'关闭';?>"/></a></td>
			<td align="right">
				<a href="index.php?rule=carrier_edit&id=<?php echo $row['id_carrier'];?>"><img alt="编辑" src="<?php echo $_tmconfig['ico_dir'];?>edit.gif"></a> 
				<a onclick="return confirm('你确定要删除？')" href="index.php?rule=carrier&delete=<?php echo $row['id_carrier'];?>"><img alt="删除" src="<?php echo $_tmconfig['ico_dir'];?>delete.gif"></a>
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
<p><input type="submit" onclick="return confirm('你确定要删除选中项目?');" value="删除选中项目" name="subDelete" class="button"></p>
</td></tr>
</table>
</form>
<br>
<form class="defaultForm admincmscontent" action="index.php?rule=carrier" method="post" >
  <fieldset class="small">
  <legend> <img src="<?php echo $_tmconfig['ico_dir'];?>edit.gif" alt="设置">默认物流</legend>
  <div id="conf_id_TM_DEFAULT_CARRIER_ID" style="clear: both; padding-top:15px;">
    <label class="conf_title">默认物流:</label>
    <div class="margin-form">
      <select name="TM_DEFAULT_CARRIER_ID" id="TM_DEFAULT_CARRIER_ID">
        <option value="NULL">--选择--</option>
		<?php
		foreach($result['entitys'] as $row){
		?>
        <option value="<?php echo $row['id_carrier'];?>" <?php echo Configuration::get('TM_DEFAULT_CARRIER_ID')==$row['id_carrier']?'selected':'';?>><?php echo $row['name'];?></option>
		<?php
		}
		?>
      </select>
      <div class="clear"></div>
    </div>
	<div id="conf_id_ENJOY_FREE_SHIPPING" style="clear: both; padding-top:15px;">
		<label class="conf_title">满多少金额免运费:</label>
		<div class="margin-form">
		  <input type="text" value="<?php echo Configuration::get('ENJOY_FREE_SHIPPING')>0?Configuration::get('ENJOY_FREE_SHIPPING'):150;?>" name="ENJOY_FREE_SHIPPING">
		</div>
	</div>
	<div class="margin-form">
		<input type="submit" class="button" name="setDefaultCarrierID" value="更新">
	</div>
  </div>
  </fieldset>
</form>
