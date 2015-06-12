<?php

if(intval(Tools::getRequest('delete'))>0){
	$object = new Currency(intval(Tools::getRequest('delete')));
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
	$currency	= new Currency();
		if($currency->deleteSelection($select_cat))
			echo '<div class="conf">删除对象成功</div>';

}elseif(intval(Tools::getRequest('toggleStatus'))>0){
	$object = new Currency(intval(Tools::getRequest('toggleStatus')));
	if(Validate::isLoadedObject($object)){
		$object->toggleStatus();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		echo '<div class="conf">更新对象状态成功</div>';
	}
}

if(Tools::isSubmit('setCurrency'))
{
	if($id_currency_default = Tools::getRequest('ID_CURRENCY_DEFAULT'))
		Configuration::updateValue('ID_CURRENCY_DEFAULT',$id_currency_default);
	echo '<div class="conf">更新成功</div>';
}

$filter	 = $cookie->getFilter('currency',array('id_currency','name','conversion_rate','iso_code','sign','active'));
if(Tools::isSubmit('submitResetCurrency')){
	$cookie->unsetFilter('currency',array('id_currency','name','conversion_rate','iso_code','sign','active'));
	$filter = array();
}

$orderBy 	= $cookie->getPost('currencyOrderBy') ? $cookie->getPost('currencyOrderBy') : 'id_currency';
$orderWay 	= $cookie->getPost('currencyOrderWay') ? $cookie->getPost('currencyOrderWay') : 'ASC';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::getRequest('currencyPage') ? Tools::getRequest('currencyPage'):1;

$result  	= Currency::getEntity(false,$p,$limit,$orderBy,$orderWay,$filter);

require_once(dirname(__FILE__).'/../errors.php');
?>
<script type="text/javascript" src="../js/jquery/jquery.tablednd_0_5.js"></script>
<script type="text/javascript">
	var token = '1f0af725a0585d7827c059999fd2d35e';
	var come_from = 'currency';
	var alternate = '0';
</script>
<script src="../js/admin/dnd.js" type="text/javascript"></script>
<div class="path_bar">
	<div class="path_title">
		<h3> 
			<span style="font-weight: normal;" id="current_obj">
			<span class="breadcrumb item-1 ">货币</span> 
		</h3>
		<div class="cc_button">
		<ul>
        <li><a title="添加货币" href="index.php?rule=currency_edit" class="toolbar_btn" id="add_currency">
				<span class="process-icon-new "></span>
				<div>添加货币</div>
			</a></li>
      </ul>
		</div>
	</div>
</div>
<form class="form" method="post" action="index.php?rule=currency">
<table class="table_grid" name="list_table" width="100%">
<tr>
<td style="vertical-align: bottom;">
<span style="float: left;">
	<?php
		echo Helper::renderAdminPagaNation($result['total'],$limit,$p,'currencyPage');
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
	<table class="tableList table tableDnD" width="100%" cellpadding="0" cellspacing="0" id="currency">
	<thead>
		<tr>
			<th><input type="checkbox" name="checkme" onclick="checkDelBoxes(this.form, 'categoryBox[]', this.checked)" ></th>
			<th>
				编号
				<a href="index.php?rule=currency&currencyOrderBy=id_currency&currencyOrderWay=desc" >
					<?php if(isset($orderBy) && $orderBy=='id_currency' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a>
				<a href="index.php?rule=currency&currencyOrderBy=id_currency&currencyOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='id_currency' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
				</a>
			</th>
			<th>
				货币
				<a href="index.php?rule=currency&currencyOrderBy=name&currencyOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='name' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=currency&currencyOrderBy=name&currencyOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='name' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
			</th>
			<th>
				汇率
				<a href="index.php?rule=currency&currencyOrderBy=conversion_rate&currencyOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='conversion_rate' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=currency&currencyOrderBy=conversion_rate&currencyOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='conversion_rate' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
			</th>
			<th>
				ISO 代码
				<a href="index.php?rule=currency&currencyOrderBy=iso_code&currencyOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='iso_code' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=currency&currencyOrderBy=iso_code&currencyOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='iso_code' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
				</a> 
			</th>
			<th>
			货币符号
				<a href="index.php?rule=currency&currencyOrderBy=sign&currencyOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='sign' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=currency&currencyOrderBy=sign&currencyOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='sign' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
				</a> 
			</th>
			<th>
				状态
				<a href="index.php?rule=currency&currencyOrderBy=active&currencyOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='active' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=currency&currencyOrderBy=active&currencyOrderWay=asc">
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
		  <td class="center"><input type="text" style="width:40px" value="<?php echo isset($filter['id_currency'])?$filter['id_currency']:'';?>" name="currencyFilter_id_currency" class="filter"></td>
		  <td><input type="text" value="<?php echo isset($filter['name'])?$filter['name']:'';?>" name="currencyFilter_name" class="filter"></td>
		  <td class="center"><input type="text" value="<?php echo isset($filter['conversion_rate'])?$filter['conversion_rate']:'';?>" name="currencyFilter_conversion_rate" class="filter"></td>
		  <td class="center"><input type="text" value="<?php echo isset($filter['iso_code'])?$filter['iso_code']:'';?>" name="currencyFilter_iso_code" class="filter"></td>
		  <td class="center"><input type="text" value="<?php echo isset($filter['sign'])?$filter['sign']:'';?>" name="currencyFilter_sign" class="filter"></td>
		  <td class="center">
		  	<select name="currencyFilter_active" onChange="$('#submitFilterButton').focus();$('#submitFilterButton').click();">
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
		<tr class="<?php echo ($key%2?'alt_row':''); ?> row" id="tr_<?php echo $row['id_currency'];?>">
			<td><input type="checkbox" name="categoryBox[]" value="<?php echo $row['id_currency'];?>" ></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=currency_edit&id=<?php echo $row['id_currency'];?>'"><?php echo $row['id_currency'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=currency_edit&id=<?php echo $row['id_currency'];?>'"><?php echo $row['name'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=currency_edit&id=<?php echo $row['id_currency'];?>'"><?php echo $row['conversion_rate'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=currency_edit&id=<?php echo $row['id_currency'];?>'"><?php echo $row['iso_code'];?>(<?php echo $row['iso_code_num'];?>)</td>
			<td class="pointer" onclick="document.location = 'index.php?rule=currency_edit&id=<?php echo $row['id_currency'];?>'"><?php echo $row['sign'];?></td>
			<td><a href="index.php?rule=currency&toggleStatus=<?php echo $row['id_currency'];?>"><img src="<?php echo $_tmconfig['tm_img_dir'].'/icon/'.($row['active']?'enabled.gif':'disabled.gif');?>" alt="<?php echo $row['active']?'开启':'关闭';?>"/></a></td>
			<td align="right">
				<a href="index.php?rule=currency_edit&id=<?php echo $row['id_currency'];?>"><img alt="编辑" src="<?php echo $_tmconfig['ico_dir'];?>edit.gif"></a> 
				<a onclick="return confirm('你确定要删除？')" href="index.php?rule=currency&delete=<?php echo $row['id_currency'];?>"><img alt="删除" src="<?php echo $_tmconfig['ico_dir'];?>delete.gif"></a>
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

<form name="example" id="set_currency_form" class="defaultForm" action="index.php?rule=currency" method="post" >
  <fieldset class="small">
  <legend><img src="<?php echo $_tmconfig['ico_dir'];?>tab-tools.gif" alt="SiteMap">默认货币</legend>
	<label>默认货币： </label>
    <div class="margin-form">
      <select size="5" id="format" class="" name="ID_CURRENCY_DEFAULT" style="width:100px">
	  <?php foreach($result['entitys'] as $key => $row){ ?>
        <option value="<?php echo $row['id_currency']; ?>" <?php echo Configuration::get('ID_CURRENCY_DEFAULT')==$row['id_currency']?'selected="selected"':'';?>><?php echo $row['name']; ?></option>
	  <?php }?>
      </select>
      <sup>*</sup>
      <p class="preference_description">此设置将用于所有价格显示</p>
    </div>
	<div class="margin-form">
  		<input type="submit" class="button" name="setCurrency" value="保存">
	</div>
  </fieldset>
</form>
