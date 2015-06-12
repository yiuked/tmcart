<?php
$filter	 = $cookie->getFilter('rule',array('id_rule','entity','id_entity','rule_link'));
if(Tools::isSubmit('submitResetRule')){
	$cookie->unsetFilter('rule',array('id_rule','entity','id_entity','rule_link'));
	$filter = array();
}

$orderBy 	= $cookie->getPost('ruleOrderBy') ? $cookie->getPost('ruleOrderBy') : 'id_rule';
$orderWay 	= $cookie->getPost('ruleOrderWay') ? $cookie->getPost('ruleOrderWay') : 'ASC';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::getRequest('rulePage') ? Tools::getRequest('rulePage'):1;

$result  	= Rule::getRule(false,$p,$limit,$orderBy,$orderWay,$filter);

require_once(dirname(__FILE__).'/../errors.php');
?>
<script type="text/javascript" src="../js/jquery/jquery.tablednd_0_5.js"></script>
<script type="text/javascript">
	var token = '1f0af725a0585d7827c059999fd2d35e';
	var come_from = 'rule';
	var alternate = '0';
</script>
<script src="../js/admin/dnd.js" type="text/javascript"></script>
<div class="path_bar">
	<div class="path_title">
		<h3> 
			<span style="font-weight: normal;" id="current_obj">
			<span class="breadcrumb item-1 ">路由管理</span> 
		</h3>
		<div class="cc_button">
		  <ul>
			<li><a title="Back to list" href="index.php?rule=rule_check" class="toolbar_btn" id="desc-product-tools"> <span class="process-icon-tools"></span>
			  <div>相关设置</div>
			  </a> </li>
		  </ul>
		</div>
	</div>
</div>
<form class="form" method="post" action="index.php?rule=rule">
<table class="table_grid" name="list_table" width="100%">
<tr>
<td style="vertical-align: bottom;">
<span style="float: left;">
	<?php
		echo Helper::renderAdminPagaNation($result['total'],$limit,$p,'rulePage');
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
	<input type="submit" class="button" value="重置" name="submitResetRule">
</span>
</td>
</tr>
<tr><td>
<div class="mianColForm">
	<table class="tableList table tableDnD" width="100%" cellpadding="0" cellspacing="0" id="rule">
	<thead>
		<tr>
			<th>
				id_rule
				<a href="index.php?rule=rule&ruleOrderBy=id_rule&ruleOrderWay=desc" >
					<?php if(isset($orderBy) && $orderBy=='id_rule' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up.gif">
					<?php } ?>
				</a>
				<a href="index.php?rule=rule&ruleOrderBy=id_rule&ruleOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='id_rule' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down.gif">
					<?php } ?>
				</a>
			</th>
			<th>
				entity
				<a href="index.php?rule=rule&ruleOrderBy=entity&ruleOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='entity' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=rule&ruleOrderBy=entity&ruleOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='entity' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down.gif">
					<?php } ?>
			</th>
			<th>
				id_entity
				<a href="index.php?rule=rule&ruleOrderBy=id_entity&ruleOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='id_entity' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=rule&ruleOrderBy=id_entity&ruleOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='id_entity' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down.gif">
					<?php } ?>
				</a> 
			</th>
			<th>
				路由地址
				<a href="index.php?rule=rule&ruleOrderBy=rule_link&ruleOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='rule_link' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=rule&ruleOrderBy=rule_link&ruleOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='rule_link' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down.gif">
					<?php } ?>
				</a> 
			</th>
		</tr>
		<tr style="height: 35px;" class="nodrag nodrop filter row_hover">
		  <td class="center"><input type="text" style="width:40px" value="<?php echo isset($filter['id_rule'])?$filter['id_rule']:'';?>" name="ruleFilter_id_rule" class="filter"></td>
		  <td><input type="text" value="<?php echo isset($filter['entity'])?$filter['entity']:'';?>" name="ruleFilter_entity" class="filter"></td>
		  <td class="center"><input type="text" value="<?php echo isset($filter['id_entity'])?$filter['id_entity']:'';?>" name="ruleFilter_id_entity" class="filter"></td>
		  <td align="left"><input type="text" style="width:300px" value="<?php echo isset($filter['url_link'])?$filter['url_link']:'';?>" name="ruleFilter_url_link" class="filter"></td>
		</tr>
	   </thead>
		<?php 
		if(is_array($result['rules']) && count($result['rules'])>0){
		foreach($result['rules'] as $key => $row){?>
		<tr class="<?php echo ($key%2?'alt_row':''); ?> row" id="tr_<?php echo $row['id_rule'];?>">
			<td class="pointer"><?php echo $row['id_rule'];?></td>
			<td class="pointer"><?php echo $row['entity'];?></td>
			<td class="pointer"><?php echo $row['id_entity'];?></td>
			<td class="pointer"><?php echo $row['rule_link'];?></td>
		</tr>
		<?php }
			}else{
		?>
		<tr><td colspan="4" align="center">暂无分类</td></tr>
		<?php }?>
	</table>
</div>
</td></tr>
<tr><td>
</td></tr>
</table>
</form>