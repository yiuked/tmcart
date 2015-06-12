<?php
$id_cms_category 	= Tools::getRequest('id_cms_category',1);
$category 			= new CMSCategory($id_cms_category);
$filter		= array();

if(intval(Tools::getRequest('delete'))>0){
	$object = new CMS(intval(Tools::getRequest('delete')));
	if(Validate::isLoadedObject($object)){
		$object->delete();
	}
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		echo '<div class="conf">删除分类成功</div>';
	}
}elseif(Tools::isSubmit('subDelete')){
	$select_cat = Tools::getRequest('cmsBox');
	$cms		= new CMS();
	if(is_array($select_cat)){
		if($cms->deleteSelection($select_cat))
			echo '<div class="conf">删除分类成功</div>';
	}
}elseif(intval(Tools::getRequest('toggleStatus'))>0){
	$object = new CMS(intval(Tools::getRequest('toggleStatus')));
	if(Validate::isLoadedObject($object)){
		$object->toggleStatus();
	}

	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		echo '<div class="conf">更新CMS状态成功</div>';
	}
}elseif(intval(Tools::getRequest('toggleIsTop'))>0){
	$object = new CMS(intval(Tools::getRequest('toggleIsTop')));
	if(Validate::isLoadedObject($object)){
		$object->toggleIsTop();
	}

	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		echo '<div class="conf">更新CMS状态成功</div>';
	}
}elseif(Tools::isSubmit('subActiveON') OR Tools::isSubmit('subActiveOFF')){
	$select_cat = Tools::getRequest('cmsBox');
	$action		= Tools::isSubmit('subActiveON')?1:0;
	$object		= new CMS();
	if(is_array($select_cat)){
		if($object->statusSelection($select_cat,$action))
			echo '<div class="conf">更新分类状态成功</div>';
	}
}

$filter	 = $cookie->getFilter('cms',array('id_cms','title','rewrite','active','is_top'));
if(Tools::isSubmit('submitResetCMS')){
	$cookie->unsetFilter('cms',array('id_cms','title','rewrite','active','is_top'));
	$filter = array();
}
$filter['id_cms_category'] = isset($_GET['id_cms_category'])?intval($_GET['id_cms_category']):1;

$orderBy 	= $cookie->getPost('cmsOrderBy') ? $cookie->getPost('cmsOrderBy') : 'id_cms';
$orderWay 	= $cookie->getPost('cmsOrderWay') ? $cookie->getPost('cmsOrderWay') : 'ASC';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::getRequest('cmsPage') ? (Tools::getRequest('cmsPage')==0?1:Tools::getRequest('cmsPage')):1;

$result  	= CMS::getCMS(false,$p,$limit,$orderBy,$orderWay,$filter);

require_once(_TM_ADMIN_DIR_.'/errors.php');
?>
<script type="text/javascript" src="../js/jquery/jquery.tablednd_0_5.js"></script>
<script type="text/javascript">
	var token = '1f0af725a0585d7827c059999fd2d35e';
	var come_from = 'cms_category';
	var alternate = '0';
</script>
<script src="../js/admin/dnd.js" type="text/javascript"></script>
<div class="path_bar">
	<div class="path_title">
		<h3> 
			<span style="font-weight: normal;" id="current_obj">
			<span class="breadcrumb item-1 ">CMS <img src="<?php echo $_tmconfig['tm_img_dir'];?>admin/separator_breadcrum.png" style="margin-right:5px" alt="&gt;"> </span> 
			<span class="breadcrumb item-2 ">内容</span> </span> 
		</h3>
		<div class="cc_button">
			<ul>
			<li><a title="添加内容" href="index.php?rule=cms_edit" class="toolbar_btn" id="add_cmscategory_new">
					<span class="process-icon-new "></span>
					<div>添加内容</div>
				</a></li>
			</ul>
		</div>
	</div>
</div>
<table width="100%">
	<tr>
	<td valign="top" width="20%">
	<div class="leftColForm">
		<script type="text/javascript">
			$(document).ready(function(){
				var base_url = 'index.php?rule=cms';
				// Load category products page when category is clicked
				$('#categories-treeview :input').live('click', function(){
					if (this.value !== "")
						location.href = base_url + '&id_cms_category=' + parseInt(this.value);
					else
						location.href = base_url;
				});
			});
		</script>
		<h3>检索分类</h3>
				<?php
				$trads = array(
					 'Home' => '根分类', 
					 'selected' => '选择', 
					 'Collapse All' => '关闭', 
					 'Expand All' => '展开'
				);
				echo Helper::renderAdminCategorieTree($trads, array(Tools::getRequest('id_cms_category')?Tools::getRequest('id_cms_category'):1), 'categoryBox', true,'CMSTree');
			 ?>
	 </div>
	</td>
	<td width="80%"><form class="form" method="post" action="index.php?rule=cms">
	<table class="table_grid" name="list_table" width="100%">
	<tr>
	<td style="vertical-align: bottom;">
	<span style="float: left;">
		<?php
			echo Helper::renderAdminPagaNation($result['total'],$limit,$p,'cmsPage');
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
		<input type="submit" class="button" value="检索" name="submitFilter" id="submitFilterButtonCMS">
		<input type="submit" class="button" value="重置" name="submitResetCMS">
	</span>
	</td>
	</tr>
	<tr><td>
	<div class="mianColForm">
		<table class="tableList table tableDnD" width="100%" cellpadding="0" cellspacing="0" id="cms_category">
		<thead>
			<tr>
				<th><input type="checkbox" name="checkme" onclick="checkDelBoxes(this.form, 'cmsBox[]', this.checked)" ></th>
				<th>
					编号
					<a href="index.php?rule=cms&cmsOrderBy=id_cms&cmsOrderWay=desc" >
						<?php if(isset($orderBy) && $orderBy=='id_cms' && isset($orderWay) && $orderWay=='desc'){ ?>
						<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up_d.gif">
						<?php }else{ ?>
						<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up.gif">
						<?php } ?>
					</a>
					<a href="index.php?rule=cms&cmsOrderBy=id_cms&cmsOrderWay=asc">
						<?php if(isset($orderBy) && $orderBy=='id_cms' && isset($orderWay) && $orderWay=='asc'){ ?>
						<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down_d.gif">
						<?php }else{ ?>
						<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down.gif">
						<?php } ?>
					</a>
				</th>
				<th>
					标题
					<a href="index.php?rule=cms&cmsOrderBy=title&cmsOrderWay=desc">
						<?php if(isset($orderBy) && $orderBy=='title' && isset($orderWay) && $orderWay=='desc'){ ?>
						<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up_d.gif">
						<?php }else{ ?>
						<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up.gif">
						<?php } ?>
					</a> 
					<a href="index.php?rule=cms&cmsOrderBy=title&cmsOrderWay=asc">
						<?php if(isset($orderBy) && $orderBy=='title' && isset($orderWay) && $orderWay=='asc'){ ?>
						<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down_d.gif">
						<?php }else{ ?>
						<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down.gif">
						<?php } ?>
				</th>
				<th>
					URL
					<a href="index.php?rule=cms&cmsOrderBy=rewrite&cmsOrderWay=desc">
						<?php if(isset($orderBy) && $orderBy=='rewrite' && isset($orderWay) && $orderWay=='desc'){ ?>
						<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up_d.gif">
						<?php }else{ ?>
						<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up.gif">
						<?php } ?>
					</a> 
					<a href="index.php?rule=cms&cmsOrderBy=rewrite&cmsOrderWay=asc">
						<?php if(isset($orderBy) && $orderBy=='rewrite' && isset($orderWay) && $orderWay=='asc'){ ?>
						<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down_d.gif">
						<?php }else{ ?>
						<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down.gif">
						<?php } ?>
					</a> 
				</th>
				<th>
					状态
					<a href="index.php?rule=cms&cmsOrderBy=active&cmsOrderWay=desc">
						<?php if(isset($orderBy) && $orderBy=='active' && isset($orderWay) && $orderWay=='desc'){ ?>
						<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up_d.gif">
						<?php }else{ ?>
						<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up.gif">
						<?php } ?>
					</a> 
					<a href="index.php?rule=cms&cmsOrderBy=active&cmsOrderWay=asc">
						<?php if(isset($orderBy) && $orderBy=='active' && isset($orderWay) && $orderWay=='asc'){ ?>
						<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down_d.gif">
						<?php }else{ ?>
						<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down.gif">
						<?php } ?>
					</a> 
				</th>
				<th>
					置顶
					<a href="index.php?rule=cms&cmsOrderBy=is_top&cmsOrderWay=desc">
						<?php if(isset($orderBy) && $orderBy=='is_top' && isset($orderWay) && $orderWay=='desc'){ ?>
						<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up_d.gif">
						<?php }else{ ?>
						<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up.gif">
						<?php } ?>
					</a> 
					<a href="index.php?rule=cms&cmsOrderBy=is_top&cmsOrderWay=asc">
						<?php if(isset($orderBy) && $orderBy=='is_top' && isset($orderWay) && $orderWay=='asc'){ ?>
						<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down_d.gif">
						<?php }else{ ?>
						<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down.gif">
						<?php } ?>
					</a> 
				</th>
				<th align="right" >操作</th>
			</tr>
			<tr style="height: 35px;" class="nodrag nodrop filter row_hover">
			  <td class="center"> -- </td>
			  <td class="center"><input type="text" style="width:40px" value="<?php echo isset($filter['id_cms'])?$filter['id_cms']:'';?>" name="cmsFilter_id_cms" class="filter"></td>
			  <td><input type="text" style="width:300px" value="<?php echo isset($filter['title'])?$filter['title']:'';?>" name="cmsFilter_title" class="filter"></td>
			  <td class="center"><input type="text" style="width:200px" value="<?php echo isset($filter['rewrite'])?$filter['rewrite']:'';?>" name="cmsFilter_rewrite" class="filter"></td>
			  <td class="center">
				<select name="cmsFilter_active" onChange="$('#submitFilterButtonCMS').focus();$('#submitFilterButtonCMS').click();">
				  <option value="">--</option>
				  <option value="1" <?php if(isset($filter['active']) && $filter['active']==1){echo "selected";}?>>Yes</option>
				  <option value="2" <?php if(isset($filter['active']) && $filter['active']==2){echo "selected";}?>>No</option>
				</select>
			  </td>
			  <td>
			  	<select name="cmsFilter_is_top" onChange="$('#submitFilterButtonCMS').focus();$('#submitFilterButtonCMS').click();">
				  <option value="">--</option>
				  <option value="1" <?php if(isset($filter['is_top']) && $filter['is_top']==1){echo "selected";}?>>Yes</option>
				  <option value="2" <?php if(isset($filter['is_top']) && $filter['is_top']==2){echo "selected";}?>>No</option>
				</select>
			  </td>
			  <td align="right">--</td>
			</tr>
		   </thead>
			<?php 
			if(is_array($result['cmss']) && count($result['cmss'])>0){
			foreach($result['cmss'] as $key => $row){?>
			<tr class="<?php echo ($key%2?'alt_row':''); ?> row" id="tr_<?php echo $row['id_cms'].'_'.$row['id_category_default'];?>">
				<td><input type="checkbox" name="cmsBox[]" value="<?php echo $row['id_cms'];?>" ></td>
				<td class="pointer" onclick="document.location = 'index.php?rule=cms_edit&id=<?php echo $row['id_cms'];?>'"><?php echo $row['id_cms'];?></td>
				<td class="pointer" onclick="document.location = 'index.php?rule=cms_edit&id=<?php echo $row['id_cms'];?>'"><?php echo $row['title'];?></td>
				<td class="pointer" onclick="document.location = 'index.php?rule=cms_edit&id=<?php echo $row['id_cms'];?>'"><?php echo $row['rewrite'];?></td>
				<td><a href="index.php?rule=cms&toggleStatus=<?php echo $row['id_cms'];?>"><img src="<?php echo $_tmconfig['tm_img_dir'].'/icon/'.($row['active']?'enabled.gif':'disabled.gif');?>" alt="<?php echo $row['active']?'开启':'关闭';?>"/></a></td>
				<td><a href="index.php?rule=cms&toggleIsTop=<?php echo $row['id_cms'];?>"><img src="<?php echo $_tmconfig['tm_img_dir'].'/icon/'.($row['is_top']?'enabled.gif':'disabled.gif');?>" alt="<?php echo $row['is_top']?'是':'否';?>"/></a></td>
				<td align="right">
					<a target="_blank" href="<?php echo Tools::getLink($row['rewrite']);?>"><img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/details.gif"></a> 
					<a href="index.php?rule=cms_edit&id=<?php echo $row['id_cms'];?>"><img alt="编辑" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/edit.gif"></a> 
					<a onclick="return confirm('你确定要删除？')" href="index.php?rule=cms&delete=<?php echo $row['id_cms'];?>"><img alt="删除" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/delete.gif"></a>
				</td>
			</tr>
			<?php }
				}else{
			?>
			<tr><td colspan="6" align="center">暂无内容</td></tr>
			<?php }?>
		</table>
	</div>
	</td></tr>
	<tr><td>
	<p>
		<input type="submit" onclick="return confirm('你确定要删除选中项目?');" value="批量删除" name="subDelete" class="button">
		<input type="submit" value="批量启用" name="subActiveON" class="button">
		<input type="submit" value="批量关闭" name="subActiveOFF" class="button">
	</p>
	</td></tr>
	</table>
	</form></td>
	</tr>
</table>

