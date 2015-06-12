<?php

if(intval(Tools::getRequest('delete'))>0){
	$object = new Feedback(intval(Tools::getRequest('delete')));
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
	$feedbacks	= new Feedback();
		if($feedbacks->deleteSelection($select_cat))
			echo '<div class="conf">删除对象成功</div>';

}elseif(Tools::isSubmit('subShowProductPage')){
	$select_cat = Tools::getRequest('categoryBox');
	$feedbacks	= new Feedback();
		if($feedbacks->statusSelection($select_cat,true))
			echo '<div class="conf">启用对象成功</div>';

}

$filter	 = $cookie->getFilter('feedback',array('id_feedback','name','id_product','flag_code','rating'));
if(Tools::isSubmit('submitResetFeedback')){
	$cookie->unsetFilter('feedback',array('id_feedback','name','feedback','city','id_state','id_country'));
	$filter = array();
}

$orderBy 	= $cookie->getPost('feedbackOrderBy') ? $cookie->getPost('feedbackOrderBy') : 'id_feedback';
$orderWay 	= $cookie->getPost('feedbackOrderWay') ? $cookie->getPost('feedbackOrderWay') : 'ASC';
$limit		= $cookie->getPost('pagination') ? $cookie->getPost('pagination') : '50';
$p			= Tools::getRequest('feedbackPage') ? Tools::getRequest('feedbackPage'):1;

$result  	= Feedback::getEntity(false,$p,$limit,$orderBy,$orderWay,$filter);

require_once(dirname(__FILE__).'/../errors.php');
?>
<script type="text/javascript" src="../js/jquery/jquery.tablednd_0_5.js"></script>
<script type="text/javascript">
	var token = '1f0af725a0585d7827c059999fd2d35e';
	var come_from = 'feedback';
	var alternate = '0';
</script>
<script src="../js/admin/dnd.js" type="text/javascript"></script>
<div class="path_bar">
	<div class="path_title">
		<h3> 
			<span style="font-weight: normal;" id="current_obj">
			<span class="breadcrumb item-1 ">客户反馈信息</span></span>
		</h3>
		<div class="cc_button">
			<ul>
			<li><a title="批量导入反馈" href="index.php?rule=feedback_import" class="toolbar_btn" id="feedback_import">
					<span class="process-icon-new "></span>
					<div>批量导入反馈</div>
				</a></li>
		  </ul>
		</div>
	</div>
</div>
<form class="form" method="post" action="index.php?rule=feedback">
<table class="table_grid" name="list_table" width="100%">
<tr>
<td style="vertical-align: bottom;">
<span style="float: left;">
	<?php
		echo Helper::renderAdminPagaNation($result['total'],$limit,$p,'feedbackPage');
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
	<input type="submit" class="button" value="重置" name="submitResetFeedback">
</span>
</td>
</tr>
<tr><td>
<div class="mianColForm">
	<table class="tableList table tableDnD" width="100%" cellpadding="0" cellspacing="0" id="feedback">
	<thead>
		<tr>
			<th><input type="checkbox" name="checkme" onclick="checkDelBoxes(this.form, 'categoryBox[]', this.checked)" ></th>
			<th>
				编号
				<a href="index.php?rule=feedback&feedbackOrderBy=id_feedback&feedbackOrderWay=desc" >
					<?php if(isset($orderBy) && $orderBy=='id_feedback' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a>
				<a href="index.php?rule=feedback&feedbackOrderBy=id_feedback&feedbackOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='id_feedback' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
				</a>
			</th>
			<th>
				客户
				<a href="index.php?rule=feedback&feedbackOrderBy=name&feedbackOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='name' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=feedback&feedbackOrderBy=name&feedbackOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='name' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
				</a>
			</th>
			<th>
				国家简称
				<a href="index.php?rule=feedback&feedbackOrderBy=flag_code&feedbackOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='flag_code' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=feedback&feedbackOrderBy=flag_code&feedbackOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='flag_code' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
			    </a>
			</th>
			<th>
				产品ID
				<a href="index.php?rule=feedback&feedbackOrderBy=id_product&feedbackOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='id_product' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=feedback&feedbackOrderBy=id_product&feedbackOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='id_product' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
			    </a>
			</th>
			<th>
				评分
				<a href="index.php?rule=feedback&feedbackOrderBy=rating&feedbackOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='rating' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=feedback&feedbackOrderBy=rating&feedbackOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='rating' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
			    </a>
			</th>
			<th>
				内容
				<a href="index.php?rule=feedback&feedbackOrderBy=feedback&feedbackOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='feedback' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=feedback&feedbackOrderBy=feedback&feedbackOrderWay=asc">
					<?php if(isset($orderBy) && $orderBy=='feedback' && isset($orderWay) && $orderWay=='asc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>down.gif">
					<?php } ?>
				</a> 
			</th>
			<th>
				日期
				<a href="index.php?rule=feedback&feedbackOrderBy=add_date&feedbackOrderWay=desc">
					<?php if(isset($orderBy) && $orderBy=='add_date' && isset($orderWay) && $orderWay=='desc'){ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up_d.gif">
					<?php }else{ ?>
					<img alt="预览" src="<?php echo $_tmconfig['ico_dir'];?>up.gif">
					<?php } ?>
				</a> 
				<a href="index.php?rule=feedback&feedbackOrderBy=add_date&feedbackOrderWay=asc">
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
		  <td><input type="text" value="<?php echo isset($filter['id_feedback'])?$filter['id_feedback']:'';?>" name="feedbackFilter_id_feedback" class="filter" size="6"></td>
		  <td><input type="text" value="<?php echo isset($filter['name'])?$filter['name']:'';?>" name="feedbackFilter_name" class="filter"></td>
		  <td><input type="text" value="<?php echo isset($filter['flag_code'])?$filter['flag_code']:'';?>" name="feedbackFilter_feedback" class="filter"></td>
		  <td><input type="text" value="<?php echo isset($filter['id_product'])?$filter['id_product']:'';?>" name="feedbackFilter_city" class="filter"></td>
		  <td><input type="text" value="<?php echo isset($filter['rating'])?$filter['rating']:'';?>" name="feedbackFilter_id_state" class="filter"></td>
		  <td>--</td>
		  <td>--</td>
		  <td align="right">--</td>
		</tr>
	   </thead>
		<?php 
		if(is_array($result['entitys']) && count($result['entitys'])>0){
		foreach($result['entitys'] as $key => $row){?>
		<tr class="<?php echo ($key%2?'alt_row':''); ?> row" id="tr_<?php echo $row['id_feedback'];?>">
			<td><input type="checkbox" name="categoryBox[]" value="<?php echo $row['id_feedback'];?>" ></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=feedback_edit&id=<?php echo $row['id_feedback'];?>'"><?php echo $row['id_feedback'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=feedback_edit&id=<?php echo $row['id_feedback'];?>'"><?php echo $row['name'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=feedback_edit&id=<?php echo $row['id_feedback'];?>'"><?php echo $row['flag_code'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=feedback_edit&id=<?php echo $row['id_feedback'];?>'"><?php echo $row['id_product'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=feedback_edit&id=<?php echo $row['id_feedback'];?>'"><?php echo $row['rating'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=feedback_edit&id=<?php echo $row['id_feedback'];?>'"><?php echo $row['feedback'];?></td>
			<td class="pointer" onclick="document.location = 'index.php?rule=feedback_edit&id=<?php echo $row['id_feedback'];?>'"><?php echo $row['add_date'];?></td>
			<td align="right">
				<a href="index.php?rule=feedback_edit&id=<?php echo $row['id_feedback'];?>"><img alt="编辑" src="<?php echo $_tmconfig['ico_dir'];?>edit.gif"></a> 
				<a onclick="return confirm('你确定要删除？')" href="index.php?rule=feedback&delete=<?php echo $row['id_feedback'];?>"><img alt="删除" src="<?php echo $_tmconfig['ico_dir'];?>delete.gif"></a>
			</td>
		</tr>
		<?php }
			}else{
		?>
		<tr><td colspan="6" align="center">暂无反馈信息</td></tr>
		<?php }?>
	</table>
</div>
</td></tr>
<tr><td>
<p>
<input type="submit" onclick="return confirm('你确定在产品页显示?');" value="在产品页显示" name="subShowProductPage" class="button">
<input type="submit" onclick="return confirm('你确定要删除选中项目?');" value="删除选中项目" name="subDelete" class="button">
</p>
</td></tr>
</table>
</form>