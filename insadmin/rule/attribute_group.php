<?php

if(intval(Tools::getRequest('delete'))>0 && Tools::getRequest('entity')=='group'){
	$object = new AttributeGroup(intval(Tools::getRequest('delete')));
	if(Validate::isLoadedObject($object)){
		$object->delete();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		echo '<div class="conf">删除对象成功</div>';
	}
}elseif(intval(Tools::getRequest('delete'))>0 && Tools::getRequest('entity')=='attribute'){
	$object = new Attribute(intval(Tools::getRequest('delete')));
	if(Validate::isLoadedObject($object)){
		$object->delete();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		echo '<div class="conf">删除对象成功</div>';
	}
}elseif(Tools::isSubmit('attributeGroupDelete')){
	$select_cat = Tools::getRequest('group');
	$attributegroup	= new AttributeGroup();
		if($attributegroup->deleteSelection($select_cat))
			echo '<div class="conf">删除对象成功</div>';
}elseif(Tools::isSubmit('attributeDelete')){
	$select_cat = Tools::getRequest('attribute');
	$attributegroup	= new Attribute();
		if($attributegroup->deleteSelection($select_cat))
			echo '<div class="conf">删除对象成功</div>';
}

$result  	= AttributeGroup::getEntitys();
require_once(dirname(__FILE__).'/../errors.php');
?>
<script type="text/javascript" src="<?php echo $_tmconfig['tm_js_dir']?>jquery/jquery.tablednd_0_5.js"></script>
<script type="text/javascript">
	var token = '1f0af725a0585d7827c059999fd2d35e';
	var come_from = 'attributeGroup';
	var alternate = '0';
</script>
<script src="<?php echo $_tmconfig['tm_js_dir']?>admin/dnd.js" type="text/javascript"></script>
<div class="path_bar">
	<div class="path_title">
		<h3> 
			<span style="font-weight: normal;" id="current_obj">
			<span class="breadcrumb item-1 ">属性</span> 
		</h3>
		<div class="cc_button">
		<ul>
        <li><a title="添加属性" href="index.php?rule=attribute_group_edit" class="toolbar_btn" id="add_employee">
				<span class="process-icon-new "></span>
				<div>添加属性组</div>
			</a></li>
		 <li><a title="添加属性" href="index.php?rule=attribute_edit" class="toolbar_btn" id="add_employee">
				<span class="process-icon-new "></span>
				<div>添加属值</div>
			</a></li>
      </ul>
		</div>
	</div>
</div>
<form class="form" method="post" action="index.php?rule=attribute_group">
<table class="table_grid" name="list_table" width="100%">
<tr>
<td style="vertical-align: bottom;">
<span style="float: right;">
	<input type="submit" class="button" value="检索" name="submitFilter" id="submitFilterButton">
	<input type="submit" class="button" value="重置" name="submitResetAttributeGroup">
</span>
</td>
</tr>
<tr><td>
<div class="mianColForm">
	<table class="tableList table" width="100%" cellpadding="0" cellspacing="0" id="attributeGroup">
	<thead>
		<tr>
			<th><input type="checkbox" name="checkme" onclick="checkDelBoxes(this.form, 'group[]', this.checked)" ></th>
			<th>编号</th>
			<th width="90%">名称</th>
			<th>排序</th>
			<th align="right" >操作</th>
		</tr>
	   </thead>
		<?php 
		if(is_array($result['entitys']) && count($result['entitys'])>0){
		foreach($result['entitys'] as $key => $row){?>
		<tr class="<?php echo ($key%2?'alt_row':''); ?> row" id="tr_<?php echo $row['id_attribute_group'];?>">
			<td><input type="checkbox" name="group[]" value="<?php echo $row['id_attribute_group'];?>" ></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=attribute_group_edit&id=<?php echo $row['id_attribute_group'];?>'"><?php echo $row['id_attribute_group'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=attribute_group_edit&id=<?php echo $row['id_attribute_group'];?>'"><?php echo $row['name'];?></td>
			<td class="pointer" id="td_<?php echo $row['id_attribute_group'];?>">--</td>
			<td align="right">
				<a href="index.php?rule=attribute_group_edit&id=<?php echo $row['id_attribute_group'];?>"><img alt="编辑" src="<?php echo $_tmconfig['ico_dir'];?>edit.gif"></a> 
				<a onclick="return confirm('你确定要删除？')" href="index.php?rule=attribute_group&entity=group&delete=<?php echo $row['id_attribute_group'];?>">
					<img alt="删除" src="<?php echo $_tmconfig['ico_dir'];?>delete.gif"></a>
			<a onclick="display_details('<?php echo $row['id_attribute_group'];?>'); return false" title="Details" id="details_tab_<?php echo $row['id_attribute_group'];?>" class="pointer">
				<img alt="Details" src="<?php echo $_tmconfig['ico_dir'];?>more.png">
			</a>
			</td>
		</tr>
		<?php
			$attributeGroup = new AttributeGroup($row['id_attribute_group']);
			$attributes = $attributeGroup->getAttributes();
			if($attributes){
		?>
		<tr style="display:none" id="details_content_<?php echo $row['id_attribute_group'];?>"><td colspan="5">
			<table width="60%" class="tableList table tableDnD" cellpadding="0" cellspacing="0" id="attribute_<?php echo $row['id_attribute_group'];?>" style="margin:10px">
				<thead>
				<tr>
					<th><input type="checkbox" name="checkme" onclick="checkDelBoxes(this.form, 'attribute[]', this.checked)" ></th>
					<th>编号</th>
					<th width="80%">属性值</th>
					<th>排序</th>
					<th align="right" >操作</th>
				</tr>
				</thead>
			  <?php foreach($attributes as $key => $row){?>
			  <tr id="tr_<?php echo $row['id_attribute_group'].'_'.$row['id_attribute'].'_'.(int)$row['position'];?>">
			  		<td><input type="checkbox" name="attribute[]" value="<?php echo $row['id_attribute'];?>" ></td>
					<td><?php echo $row['id_attribute'];?></td>
					<td><?php echo $row['name'];?></td>
					<td class="pointer dragHandle center" id="td_<?php echo $row['id_attribute'];?>">
					<a href="index.php?rule=attribute_group&id_attribute=<?php echo $row['id_attribute'];?>&way=1&position=<?php echo $row['position']+1;?>" <?php if($key+1==count($attributes)){ echo 'style="display:none"'; }?>>
					<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/down.gif"></a>
					<a href="index.php?rule=attribute_group&id_attribute=<?php echo $row['id_attribute'];?>&way=0&position=<?php echo $row['position']-1;?>" <?php if($key==0){ echo 'style="display:none"'; }?>>
						<img alt="预览" src="<?php echo $_tmconfig['tm_img_dir'];?>/icon/up.gif"></a> 
					</td>
					<td align="right">
						<a href="index.php?rule=attribute_edit&id=<?php echo $row['id_attribute'];?>"><img alt="编辑" src="<?php echo $_tmconfig['ico_dir'];?>edit.gif"></a> 
						<a onclick="return confirm('你确定要删除？')" href="index.php?rule=attribute_group&entity=attribute&delete=<?php echo $row['id_attribute'];?>"><img alt="删除" src="<?php echo $_tmconfig['ico_dir'];?>delete.gif"></a>
					</td>
			  </tr>
			  <?php }?>
			</table>
			<p style="margin:0 10px;">
				<input type="submit" onclick="return confirm('你确定要删除选中项目?');" value="删除选中项目" name="attributeDelete" class="button">
			</p>
			</td>
		</tr>
		<?php }?>
		
		
		<?php }
			}else{
		?>
		<tr><td colspan="5" align="center">暂无分类</td></tr>
		<?php }?>
	</table>
</div>
</td></tr>
<tr><td>
<p>
	<input type="submit" onclick="return confirm('你确定要删除选中项目?');" value="删除选中项目" name="attributeGroupDelete" class="button">
</p>
</td></tr>
</table>
</form>