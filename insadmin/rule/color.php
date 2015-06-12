<?php
if(intval(Tools::getRequest('delete'))>0){
	$object = new Color(intval(Tools::getRequest('delete')));
	if(Validate::isLoadedObject($object)){
		$object->delete();
	}
	
	if(is_array($object->_errors) AND count($object->_errors)>0){
		$errors = $object->_errors;
	}else{
		echo '<div class="conf">删除颜色成功</div>';
	}
}elseif(Tools::isSubmit('subDelete')){
	$select_cat = Tools::getRequest('categoryBox');
	$color	= new Color();
		if($color->deleteSelection($select_cat))
			echo '<div class="conf">删除管理员成功</div>';

}

$colors = Color::getEntitys();

require_once(dirname(__FILE__).'/../errors.php');
?>
<script type="text/javascript" src="../js/jquery/jquery.tablednd_0_5.js"></script>
<script type="text/javascript">
	var token = '1f0af725a0585d7827c059999fd2d35e';
	var come_from = 'color';
	var alternate = '0';
</script>
<div class="path_bar">
	<div class="path_title">
		<h3> 
			<span style="font-weight: normal;" id="current_obj">
			<span class="breadcrumb item-1 ">颜色管理</span></span>
		</h3>
		<div class="cc_button">
		<ul>
			<li><a title="产品颜色管理" href="index.php?rule=color_cannel_product" class="toolbar_btn" id="color_product_onepage">
				<span class="process-icon-tools"></span>
				<div>取消产品颜色</div>
			</a></li>
			<li><a title="产品颜色管理" href="index.php?rule=color_product" class="toolbar_btn" id="color_product_onepage">
				<span class="process-icon-tools"></span>
				<div>产品颜色管理</div>
			</a></li>
        	<li><a title="添加颜色" href="index.php?rule=color_edit" class="toolbar_btn" id="add_onepage">
				<span class="process-icon-new"></span>
				<div>添加颜色</div>
			</a></li>
      	</ul>
		</div>
	</div>
</div>
<form class="form" method="post" action="index.php?rule=color">
<table class="table_grid" name="list_table" width="100%">
<tr><td>
<div class="mianColForm">
	<table class="tableList table tableDnD" width="40%" cellpadding="0" cellspacing="0" id="order">
	<thead>
		<tr>
			<th><input type="checkbox" name="checkme" onclick="checkDelBoxes(this.form, 'categoryBox[]', this.checked)" ></th>
			<th>编号</th>
			<th>名称</th>
			<th>颜色</th>
			<th align="right" >操作</th>
		</tr>
	   </thead>
		<?php 
		if(is_array($colors) && count($colors)>0){
		foreach($colors as $key => $row){?>
		<tr class="<?php echo ($key%2?'alt_row':''); ?> row" id="tr_<?php echo $row['id_color'];?>">
			<td><input type="checkbox" name="categoryBox[]" value="<?php echo $row['id_color'];?>" ></td>
			<td><?php echo $row['id_color'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=color_edit&id=<?php echo $row['id_color'];?>'"><?php echo $row['name'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=color_edit&id=<?php echo $row['id_color'];?>'">
				<span class="color_field" style="border:3px solid #333;background-color:<?php echo $row['code'];?>;color:white"><?php echo $row['code'];?></span></td>
			<td align="right">
				<a href="index.php?rule=color_edit&id=<?php echo $row['id_color'];?>"><img alt="编辑" src="<?php echo $_tmconfig['ico_dir'];?>edit.gif"></a>
				<a onclick="return confirm('你确定要删除？')" href="index.php?rule=color&delete=<?php echo $row['id_color'];?>"><img alt="删除" src="<?php echo $_tmconfig['ico_dir'];?>delete.gif"></a>
			</td>
		</tr>
		<?php }
			}else{
		?>
		<tr><td colspan="6" align="center">暂无颜色</td></tr>
		<?php }?>
	</table>
</div>
</td></tr>
<tr><td>
<p><input type="submit" onclick="return confirm('你确定要删除选中项目?');" value="删除选中项目" name="subDelete" class="button"></p>
</td></tr>
</table>
</form>