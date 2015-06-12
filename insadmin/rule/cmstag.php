<?php

if(intval(Tools::getRequest('delete'))>0){
	$object = new CMSTag(intval(Tools::getRequest('delete')));
	if(Validate::isLoadedObject($object)){
		$object->delete();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		echo '<div class="conf">删除标签成功</div>';
	}
}elseif(Tools::isSubmit('subDelete')){
	$select_cat = Tools::getRequest('categoryBox');
	$cmstag	= new CMSTag();
		if($cmstag->deleteSelection($select_cat))
			echo '<div class="conf">删除标签成功</div>';

}elseif(intval(Tools::getRequest('toggleStatus'))>0){
	$object = new CMSTag(intval(Tools::getRequest('toggleStatus')));
	if(Validate::isLoadedObject($object)){
		$object->toggleStatus();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		echo '<div class="conf">更新标签成功</div>';
	}
}

$filter	 = $cookie->getFilter('cmstag',array('id_cms_tag','name','rewrite'));
if(Tools::isSubmit('submitResetCmsTag')){
	$cookie->unsetFilter('cmstag',array('id_cms_tag','name','rewrite'));
	$filter = array();
}

$orderBy 	= $cookie->getPost('cmstagOrderBy') ? $cookie->getPost('cmstagOrderBy') : 'id_cms_tag';
$orderWay 	= $cookie->getPost('cmstagOrderWay') ? $cookie->getPost('cmstagOrderWay') : 'ASC';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::getRequest('cmstagPage') ? Tools::getRequest('cmstagPage'):1;

$result  	= CMSTag::getTags($p,$limit,$orderBy,$orderWay,$filter);

require_once(_TM_ADMIN_DIR_.'/errors.php');
?>
<script type="text/javascript" src="../js/jquery/jquery.tablednd_0_5.js"></script>
<script type="text/javascript">
	var token = '1f0af725a0585d7827c059999fd2d35e';
	var come_from = 'emstag';
	var alternate = '0';
</script>
<script src="../js/admin/dnd.js" type="text/javascript"></script>
<div class="path_bar">
	<div class="path_title">
		<h3> 
			<span style="font-weight: normal;" id="current_obj">
			<span class="breadcrumb item-1 ">CMS标签</span> 
		</h3>
		<div class="cc_button">
			<ul>
			<li><a title="添加内容" href="index.php?rule=cmstag_edit" class="toolbar_btn" id="add_cmstag_new">
					<span class="process-icon-new "></span>
					<div>添加内容</div>
				</a></li>
			</ul>
		</div>
	</div>
</div>
<form class="form" method="post" action="index.php?rule=cmstag">
<table class="table_grid" name="list_table" width="100%">
<tr>
<td style="vertical-align: bottom;">
<span style="float: left;">
	<?php
		echo Helper::renderAdminPagaNation($result['total'],$limit,$p,'emstagPage');
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
	<input type="submit" class="button" value="重置" name="submitResetCmsTag">
</span>
</td>
</tr>
<tr><td>
<div class="mianColForm">
	<table class="tableList table tableDnD" width="100%" cellpadding="0" cellspacing="0" id="emstag">
	<thead>
		<tr>
			<th><input type="checkbox" name="checkme" onclick="checkDelBoxes(this.form, 'categoryBox[]', this.checked)" ></th>
			<th>
				编号
				<a href="index.php?rule=cmstag&cmstagOrderBy=id_cms_tag&cmstagOrderWay=desc" >
					<?php if(isset($orderBy) && $orderBy=='id_cms_tag' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up.gif">
					<?php } ?>
				</a>
				<a href="index.php?rule=cmstag&cmstagOrderBy=id_cms_tag&cmstagOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='id_cms_tag' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down.gif">
					<?php } ?>
				</a>
			</th>
			<th>
				Tag名称
				<a href="index.php?rule=cmstag&cmstagOrderBy=name&cmstagOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='name' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=cmstag&cmstagOrderBy=name&cmstagOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='name' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down.gif">
					<?php } ?>
			</th>
			<th>
				Ulr Rewirte
				<a href="index.php?rule=cmstag&cmstagOrderBy=rewrite&cmstagOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='rewrite' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=cmstag&cmstagOrderBy=rewrite&cmstagOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='rewrite' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down.gif">
					<?php } ?>
			</th>
			<th>
				更新时间
				<a href="index.php?rule=cmstag&cmstagOrderBy=upd_date&cmstagOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='upd_date' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=cmstag&cmstagOrderBy=upd_date&cmstagOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='upd_date' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down.gif">
					<?php } ?>
			</th>
			<th align="right" >操作</th>
		</tr>
		<tr style="height: 35px;" class="nodrag nodrop filter row_hover">
		  <td class="center"> -- </td>
		  <td class="center"><input type="text" style="width:40px" value="<?php echo isset($filter['id_cms_tag'])?$filter['id_cms_tag']:'';?>" name="cmstagFilter_id_cms_tag" class="filter"></td>
		  <td><input type="text" value="<?php echo isset($filter['name'])?$filter['name']:'';?>" name="cmstagFilter_name" class="filter"></td>
		  <td class="center"><input type="text" value="<?php echo isset($filter['rewrite'])?$filter['rewrite']:'';?>" name="cmstagFilter_rewrite" class="filter"></td>
		  <td align="left">--</td>
		  <td align="right">--</td>
		</tr>
	   </thead>
		<?php 
		if(is_array($result['tags']) && count($result['tags'])>0){
		foreach($result['tags'] as $key => $row){?>
		<tr class="<?php echo ($key%2?'alt_row':''); ?> row" id="tr_<?php echo $row['id_cms_tag'];?>">
			<td><input type="checkbox" name="categoryBox[]" value="<?php echo $row['id_cms_tag'];?>" ></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=cmstag_edit&id=<?php echo $row['id_cms_tag'];?>'"><?php echo $row['id_cms_tag'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=cmstag_edit&id=<?php echo $row['id_cms_tag'];?>'"><?php echo $row['name'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=cmstag_edit&id=<?php echo $row['id_cms_tag'];?>'"><?php echo $row['rewrite'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=cmstag_edit&id=<?php echo $row['id_cms_tag'];?>'"><?php echo $row['upd_date'];?></td>
			<td align="right">
				<a target="_blank" href="<?php echo Tools::getLink($row['rewrite']);?>"><img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/details.gif"></a> 
				<a href="index.php?rule=cmstag_edit&id=<?php echo $row['id_cms_tag'];?>"><img alt="编辑" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/edit.gif"></a> 
				<a onclick="return confirm('你确定要删除？')" href="index.php?rule=cmstag&delete=<?php echo $row['id_cms_tag'];?>"><img alt="删除" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/delete.gif"></a>
			</td>
		</tr>
		<?php }
			}else{
		?>
		<tr><td colspan="5" align="center">暂无标签</td></tr>
		<?php }?>
	</table>
</div>
</td></tr>
<tr><td>
<p>
	<input type="submit" onclick="return confirm('你确定要删除选中项目?');" value="删除选中项目" name="subDelete" class="button">
</p>
</td></tr>
</table>
</form>