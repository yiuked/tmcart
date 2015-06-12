<?php
$colors 	= Color::getEntitys();
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
			<span class="breadcrumb item-1 ">取消产品颜色</span></span>
		</h3>
		<div class="cc_button">
		  <ul>
			<li> <a title="Back to list" href="index.php?rule=color" class="toolbar_btn" id="desc-product-back"> <span class="process-icon-back "></span>
			  <div>返回列表</div>
			  </a> </li>
		  </ul>
		</div>
	</div>
</div>
<table class="table_grid" name="list_table" width="100%">
<tr>
<td>
	<table class="tableList table tableDnD" width="100%" cellpadding="0" cellspacing="0" id="order">
	<thead>
		<tr>
			<th width="10%">颜色</th>
			<th>产品</th>
		</tr>
	   </thead>
	   <tr>
		   <td id="color_block" valign="top">
		   <ul>
			<?php 
			if(is_array($colors) && count($colors)>0){
			foreach($colors as $key => $row){?>
			<li class="color_item">
				<span class="color_field_big" style="background-color:<?php echo $row['code'];?>;"></span>
				<input type="radio" name="productColor" value="<?php echo $row['id_color'];?>" />
			</li>
			<?php }
				}
			?>
			</ul>
			</td>
		   <td id="product_block"></td>
	   </tr>
	</table>
</td></tr>
</table>
<div align="center">
	<input type="hidden" value="0" name="page" id="page" />
	<input type="button" id="loadMoreProducts" name="loadMoreProducts" value="加载更多产品" class="button">
</div>
<script language="javascript">
$(document).ready(function(){
	$(".color_item").click(function(){
		$("#page").val(0);
		$("#product_block").html("")
		$(this).find("input").attr("checked",true);	
		loadColorPoducts();
	})
	$(".color_product_item").live("click",function(){
		deleteToColor($(this));
	});
	
	$("#loadMoreProducts").click(function(){
		loadColorPoducts();
	})
});

function loadColorPoducts()
{
	var page 		= $("#page").val();
	var id_color 	= $("input[name='productColor']:checked").val();
	$.ajax({
		url: 'public/ajax_color.php',
		cache: false,
		data: "action=loadproductwithcolor&id_color="+id_color+"&p="+page,
		dataType: "json",
		success: function(data)
			{
				if(data.status=='YES'){
					$("#product_block").append(data.html);
					$("#page").val(parseInt(page)+1);
				}
			}
		}); 	
}
function deleteToColor(obj)
{
	var id_color 	= $("input[name='productColor']:checked").val();
	var id_product  = obj.attr("id")
	$.ajax({
		url: 'public/ajax_color.php',
		cache: false,
		data: "action=deletetocolor&id_color="+id_color+"&id_product="+id_product,
		dataType: "json",
		success: function(data)
			{
				if(data.status=='YES'){
					obj.remove();
				}
			}
		}); 	
}
</script>