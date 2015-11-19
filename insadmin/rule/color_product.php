<?php
$colors 	= Color::getEntitys();
if (isset($errors)) {
	UIAdminAlerts::MError($errors);
}

$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '颜色',  'href' => 'index.php?rule=color'));
$breadcrumb->add(array('title' => '关联', 'active' => true));
$bread = $breadcrumb->draw();

$btn_group = array(
	array('type' => 'a', 'title' => '返回', 'href' => 'index.php?rule=color', 'class' => 'btn-primary', 'icon' => 'level-up') ,
);
echo UIViewBlock::area(array('bread' => $bread, 'btn_groups' => $btn_group), 'breadcrumb');
?>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				关联
			</div>
			<div class="panel-body">
				<table class="table_grid" name="list_table" width="100%">
				<tr>
				<td>
					<table class="table" width="100%" cellpadding="0" cellspacing="0" id="order">
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
					<button type="button" id="addAllToProduct" class="btn btn-success"><span class="glyphicon glyphicon-save"></span> 全部添加到选中颜色</button>
					<button type="button" id="loadMoreProducts" class="btn btn-success"><span class="glyphicon glyphicon-repeat"></span> 加载更多产品</button>
				</div>
			</div>
		</div>
	</div>
</div>
<script language="javascript">
$(document).ready(function(){
	$(".color_item").click(function(){
		$(this).find("input").attr("checked",true);	
	})
	$(document).on("click", ".color_product_item", function(){
		addToColor($(this));
	});
	
	$("#loadMoreProducts").click(function(){
		loadColorPoducts();
	})
	
	$("#addAllToProduct").click(function(){
		if(confirm("确定继续"))
			addAllToProduct();
	})
});

function loadColorPoducts()
{
	var page 		= $("#page").val();
	$.ajax({
		url: 'public/ajax_color.php',
		cache: false,
		data: "action=loadmoreproduct&p="+page,
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
function addToColor(obj)
{
	var id_color 	= $("input[name='productColor']:checked").val();
	var id_product  = obj.attr("id")
	$.ajax({
		url: 'public/ajax_color.php',
		cache: false,
		data: "action=addtocolor&id_color="+id_color+"&id_product="+id_product,
		dataType: "json",
		success: function(data)
			{
				if(data.status=='YES'){
					obj.remove();
				}
			}
		}); 	
}

function addAllToProduct()
{
	var id_color 	= $("input[name='productColor']:checked").val();
	$(".color_product_item").each(function(){
		var id_product  = $(this).attr("id")
		var obj = $(this);
		$.ajax({
			url: 'public/ajax_color.php',
			cache: false,
			data: "action=addtocolor&id_color="+id_color+"&id_product="+id_product,
			dataType: "json",
			success: function(data)
				{
					if(data.status=='YES'){
						obj.remove();
					}
				}
			}); 	
	});
}
</script>