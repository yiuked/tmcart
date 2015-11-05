<!--head-->
<link href="<?php echo $_tmconfig['tm_js_dir']?>jquery/ui/themes/base/jquery.ui.theme.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?php echo $_tmconfig['tm_js_dir']?>jquery/ui/themes/base/jquery.ui.slider.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?php echo BOOTSTRAP_CSS;?>bootstrap-datetimepicker.min.css" rel="stylesheet" />
<link href="<?php echo BOOTSTRAP_CSS;?>bootstrap-tagsinput.css" rel="stylesheet" />
<link href="<?php echo $_tmconfig['tm_js_dir']?>jquery/plugins/treeview-categories/jquery.treeview-categories.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?php echo $_tmconfig['tm_js_dir']?>jquery/plugins/ajaxfileupload/jquery.ajaxfileupload.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="<?php echo $_tmconfig['tm_js_dir']?>kindeditor/kindeditor-min.js"></script>
<script type="text/javascript" src="<?php echo $_tmconfig['tm_js_dir']?>kindeditor/lang/zh_CN.js"></script>
<script type="text/javascript" src="<?php echo $_tmconfig['tm_js_dir']?>jquery/ui/jquery.ui.core.min.js"></script>
<script type="text/javascript" src="<?php echo $_tmconfig['tm_js_dir']?>jquery/ui/jquery.ui.widget.min.js"></script>
<script type="text/javascript" src="<?php echo $_tmconfig['tm_js_dir']?>jquery/ui/jquery.ui.mouse.min.js"></script>
<script type="text/javascript" src="<?php echo $_tmconfig['tm_js_dir']?>jquery/ui/jquery.ui.slider.min.js"></script>
<script type="text/javascript" src="<?php echo BOOTSTRAP_JS;?>bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="<?php echo BOOTSTRAP_JS;?>bootstrap-datetimepicker.zh-CN.js"></script>
<script type="text/javascript" src="<?php echo BOOTSTRAP_JS;?>bootstrap-tagsinput.min.js"></script>
<script type="text/javascript" src="<?php echo $_tmconfig['tm_js_dir']?>jquery/ui/jquery.ui.progressbar.min.js"></script>
<script type="text/javascript" src="<?php echo $_tmconfig['tm_js_dir']?>jquery/plugins/ajaxfileupload/jquery.ajaxfileupload.js"></script>
<script type="text/javascript" src="<?php echo $_tmconfig['tm_js_dir']?>fileuploader.js"></script>
<script type="text/javascript" src="<?php echo $_tmconfig['tm_js_dir']?>jquery/jquery.tablednd_0_5.js"></script>
<!--//head-->
<div class="col-md-12">
<?php
$adminBrand = new AdminBreadcrumb();
$adminBrand->add('product','商品');
echo $adminBrand->last('商品编辑');

if(isset($_POST['sveProduct']) && Tools::getRequest('sveProduct')=='add')
{
	$product = new Product();
	$product->copyFromPost();
	if($product->add())
		if(!$product->updateCategories($_POST['categoryBox']) OR !$product->updateTags($_POST['tags']) OR !$product->updateAttribute($_POST['attribute_items']))
			$product->_errors = '添加产品内容时发生了一个错误';
	
	if(is_array($product->_errors) AND count($product->_errors)>0){
		$errors = $product->_errors;
	}else{
		$_GET['id'] = $product->id;
		echo '<div class="conf">添加产品成功</div>';
	}
}

if(isset($_GET['id'])){
	$id  = (int)$_GET['id'];
	$obj = new Product($id);
	$images = Image::getImages($id);
}

if(isset($_POST['sveProduct']) && Tools::getRequest('sveProduct')=='edit')
{
	if(Validate::isLoadedObject($obj)){
		$obj->copyFromPost();
		if($obj->update()){
			if(!$obj->updateCategories($_POST['categoryBox']) OR !$obj->updateTags($_POST['tags']) OR !$obj->updateAttribute($_POST['attribute_items']))
				$obj->_errors = '更新产品内容时发生了一个错误';
		}
	}
	if(is_array($obj->_errors) AND count($obj->_errors)>0){
		$errors = $obj->_errors;
	}else{
		echo '<div class="alert alert-success" role="alert">更新产品内容成功</div>';
	}

}
require_once(_TM_ADMIN_DIR_.'/errors.php');
?>

<div class="action-group">
	<div class="btn-group pull-right" role="group">
	  <a href="<?php echo $link->getPage('ProductView',$obj->id);?>"  class="btn btn-warning" target="_blank">
		  <span aria-hidden="true" class="glyphicon glyphicon-eye-open"></span> 浏览</a>
		<a href="index.php?rule=product"  class="btn btn-primary"><span aria-hidden="true" class="glyphicon glyphicon-level-up"></span> 返回</a>
	</div>
	
	<div class="btn-group save-group pull-right" role="group">
		<a href="javascript:void(0)"  class="btn btn-success" id="desc-product-save"><span aria-hidden="true" class="glyphicon glyphicon-floppy-saved"></span> 保存</a>
	</div>
	<div class="clearfix"></div>
</div>
<script language="javascript">
	$("#desc-product-save").click(function(){
		$("#product_form").submit();
	})

	KindEditor.ready(function(K) {
	var editor1 = K.create('textarea[name="description"]', {
		cssPath : '../js/kindeditor/plugins/code/prettify.css',
		uploadJson : '../js/kindeditor/php/upload_json.php',
		fileManagerJson : '../js/kindeditor/php/file_manager_json.php',
		allowFileManager : true,
		afterCreate: function () {
			this.sync();
		},
		afterBlur: function () {
			this.sync();
		}
	});
});
$(document).ready(function(){
	currentId = $(".productTabs a.selected").attr('id').substr(5);
	$('.product-tab-content').hide();
	$("#product-tab-content-"+currentId).show();
	
	$(".tab-page").click(function(e){
		// currentId is the current product tab id
		currentId = $(".productTabs a.selected").attr('id').substr(5);
		// id is the wanted producttab id
		id = $(this).attr('id').substr(5);
		
		$('#tab_key').val(id);
		
		if ($(this).attr("id") != $(".productTabs a.selected").attr('id'))
		{
			$(".tab-page").removeClass('selected');
			$("#product-tab-content-"+currentId).hide();
			$(this).addClass('selected');
			$("#product-tab-content-"+id).show();
		}
		return false;
	});
});
</script>
<div class="panel">
	<div class="productTabs">
		<ul id="product_tab">
			<li class="tab-row"><a id="link-Base" class="tab-page <?php if(!isset($_POST['tab_key']) || (isset($_POST['tab_key']) && $_POST['tab_key']=='Base')){echo "selected";}?>" href="#">基本信息</a></li>
			<li class="tab-row"><a id="link-SEO"  class="tab-page <?php if(isset($_POST['tab_key']) && $_POST['tab_key']=='SEO'){echo "selected";}?>" href="#">SEO</a></li>
			<li class="tab-row"><a id="link-Category"  class="tab-page <?php if(isset($_POST['tab_key']) && $_POST['tab_key']=='Category'){echo "selected";}?>" href="#">分类</a></li>
			<li class="tab-row"><a id="link-Atrribute" class="tab-page <?php if(isset($_POST['tab_key']) && $_POST['tab_key']=='Atrribute'){echo "selected";}?>" href="#">属性</a></li>
			<li class="tab-row"><a id="link-Image" class="tab-page <?php if(isset($_POST['tab_key']) && $_POST['tab_key']=='Image'){echo "selected";}?>" href="#">产品图片</a></li>
		</ul>
	</div>
	<form enctype="multipart/form-data" method="post" action="index.php?rule=product_edit<?php echo isset($id)?'&id='.$id:''?>" class="defaultForm" id="product_form" name="example">
		<div id="tabPane1" class="tab-pane">
			<input type="hidden" value="<?php echo isset($id)?'edit':'add'?>" name="sveProduct" />
			<input type="hidden" value="<?php echo isset($_POST['tab_key'])?$_POST['tab_key']:'Base'?>" name="tab_key" id="tab_key" />
			<div id="product-tab-content-Base" class=" product-tab-content" style="display: block;">
				<div class="row">
					<div class="col-md-6 form-horizontal">
						<div class="form-group">
							<label for="name" class="col-sm-2 control-label">产品名</label>
							<div class="col-sm-10">
								<input type="text" value="<?php echo isset($obj)?$obj->name:Tools::getRequest('name');?>" id="name" class="form-control" name="name" size="60" onkeyup="if (isArrowKey(event)) return ;copy2friendlyURL();" onchange="copy2friendlyURL();">
							</div>
						</div>
						<div class="form-group">
							<label for="ean13" class="col-sm-2 control-label">产品编号</label>
							<div class="col-sm-2">
								<input type="text" value="<?php echo isset($obj)?$obj->ean13:Tools::getRequest('ean13');?>"  name="ean13" class="form-control" >
							</div>
						</div>
						<div class="form-group">
							<label for="quantity" class="col-sm-2 control-label">库存</label>
							<div class="col-sm-2">
								<input type="text" value="<?php echo isset($obj)?$obj->quantity:(Tools::getRequest('quantity')?Tools::getRequest('quantity'):0);?>"  name="quantity" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label for="price" class="col-sm-2 control-label">价格</label>
							<div class="col-sm-2">
								<input type="text" value="<?php echo isset($obj)?$obj->price:(Tools::getRequest('price')?Tools::getRequest('price'):0);?>"  name="price" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label for="special_price" class="col-sm-2 control-label">官方标价</label>
							<div class="col-sm-2">
								<input type="text" value="<?php echo isset($obj)?$obj->special_price:(Tools::getRequest('special_price')?Tools::getRequest('special_price'):0);?>"  name="special_price" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label for="time" class="col-sm-2 control-label">促销时间</label>
							<div class="col-sm-6">
								<div id="datepicker" class="input-daterange input-group">
									<input type="text" name="from_date" class="tmdatatimepicker input-sm form-control">
									<span class="input-group-addon">到</span>
									<input type="text" name="to_date" class="tmdatatimepicker input-sm form-control">
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6 form-horizontal">
						<div class="form-group">
							<label for="time" class="col-sm-2 control-label">产品状态</label>
							<div class="col-sm-6">
								<div class="btn-group" data-toggle="buttons">
									<label class="btn btn-grey enabled<?php echo isset($obj)&&$obj->active==1?' active':(Tools::getRequest('active')==1?' active':'');?>">
										<input type="radio" name="active" value="1" autocomplete="off" >启用
									</label>
									<label class="btn btn-grey">
										<input type="radio" name="active" value="0" autocomplete="off">关闭
									</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="time" class="col-sm-2 control-label">新产品</label>
							<div class="col-sm-6">
								<div class="btn-group" data-toggle="buttons">
									<label class="btn btn-grey enabled<?php echo isset($obj)&&$obj->is_new==1?' active':(Tools::getRequest('is_new')==1?' active':'');?>">
										<input type="radio" name="is_new" value="1" autocomplete="off" checked>是
									</label>
									<label class="btn btn-grey">
										<input type="radio" name="is_new" value="0" autocomplete="off">否
									</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="time" class="col-sm-2 control-label">热销产品</label>
							<div class="col-sm-6">
								<div class="btn-group" data-toggle="buttons">
									<label class="btn btn-grey enabled<?php echo isset($obj)&&$obj->is_sale==1?' active':(Tools::getRequest('is_sale')==1?' active':'');?>">
										<input type="radio" name="is_sale" value="1" autocomplete="off" checked>是
									</label>
									<label class="btn btn-grey">
										<input type="radio" name="is_sale" value="0" autocomplete="off">否
									</label>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="time" class="col-sm-2 control-label">推荐产品</label>
							<div class="col-sm-6">
								<div class="btn-group" data-toggle="buttons">
									<label class="btn btn-grey enabled<?php echo isset($obj)&&$obj->is_top==1?' active':(Tools::getRequest('is_top')==1?' active':'');?>">
										<input type="radio" name="is_top" value="1" autocomplete="off" checked>是
									</label>
									<label class="btn btn-grey">
										<input type="radio" name="is_top" value="0" autocomplete="off">否
									</label>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12 form-horizontal">
						<div class="form-group">
							<label for="time" class="col-md-1 control-label">内容描述</label>
							<div class="col-md-10">
								<textarea name="description" class="description" style="width:700px;height:300px;visibility:hidden;"><?php echo isset($obj->description)?$obj->description:Tools::getRequest('description');?></textarea>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div id="product-tab-content-SEO" class="product-tab-content" style=" display:none">
				<div class="row">
					<div class="col-md-10 form-horizontal">
						<div class="form-group">
							<label for="tags" class="col-sm-2 control-label">Tag标签</label>
							<div class="col-sm-10">
								<div class="tagify-container">
									<input type="text" value="<?php echo isset($obj)?(Tag::tagToString($obj->id)):Tools::getRequest('tags');?>" class="form-control" data-role="tagsinput" name="tags" >
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="meta_title" class="col-sm-2 control-label">Meta Title</label>
							<div class="col-sm-10">
								<input type="text" value="<?php echo isset($obj)?$obj->meta_title:Tools::getRequest('meta_title');?>" class="form-control" name="meta_title" >
							</div>
						</div>
						<div class="form-group">
							<label for="meta_keywords" class="col-sm-2 control-label">Meta Keywords</label>
							<div class="col-sm-10">
								<input type="text" value="<?php echo isset($obj)?$obj->meta_keywords:Tools::getRequest('meta_keywords');?>" class="form-control" name="meta_keywords" >
							</div>
						</div>
						<div class="form-group">
							<label for="meta_description" class="col-sm-2 control-label">Meta Description</label>
							<div class="col-sm-10">
								<input type="text" value="<?php echo isset($obj)?$obj->meta_description:Tools::getRequest('meta_description');?>" class="form-control" name="meta_description" >
							</div>
						</div>
						<div class="form-group">
							<label for="rewrite" class="col-sm-2 control-label">Url Rewrite</label>
							<div class="col-sm-10">
								<input type="text" value="<?php echo isset($obj)?$obj->rewrite:Tools::getRequest('rewrite');?>" class="form-control" name="rewrite" id="rewrite" onkeyup="if (isArrowKey(event)) return ;generateFriendlyURL();" onchange="generateFriendlyURL();">
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<div id="product-tab-content-Category" class="product-tab-content" style=" display:none">
				<div class="row">
					<div class="col-md-10 form-horizontal">
						<div class="form-group">
							<label for="categoryBox" class="col-sm-2 control-label">关联分类</label>
							<div class="col-sm-10">
								<?php
								$trads = array(
									'Home' 		=> '根分类',
									'selected' 	=> '选择',
									'Collapse All' => '关闭',
									'Expand All' 	=> '展开',
									'Check All'	=> '全选',
									'Uncheck All'	=> '全不选'
								);
								if (!isset($obj))
								{
									$categoryBox = Tools::getRequest('categoryBox')?Tools::getRequest('categoryBox'):array();
								}
								else
								{
									if (Tools::isSubmit('categoryBox'))
										$categoryBox = Tools::getRequest('categoryBox');
									else
										$categoryBox = Product::getProductCategoriesFullId($obj->id);
								}
								echo Helper::renderAdminCategorieTree($trads,$categoryBox, 'categoryBox', false,'Tree');
								?>
								<a href="index.php?rule=category_edit" class="btn btn-link bt-icon confirm_leave">
									<span class="glyphicon glyphicon-plus"></span> 创建一个新分类 <span class="glyphicon glyphicon-new-window"></span>
								</a>
							</div>
						</div>
						<?php
						if (!isset($obj))
						{
							$selectedCat = Category::getCategoryInformations(Tools::getRequest('categoryBox'));
						}
						else
						{
							if (Tools::isSubmit('categoryBox'))
								$selectedCat = Category::getCategoryInformations(Tools::getRequest('categoryBox'));
							else
								$selectedCat = Product::getProductCategoriesFull($obj->id);
						}
						?>
						<div class="form-group">
							<label for="id_category_default" class="col-sm-2 control-label">默认分类</label>
							<div class="col-sm-10">
								<select name="id_category_default" class="form-control" id="id_category_default" <?php if(!$selectedCat || count($selectedCat)==0){echo 'style="display:none"';}?>>
									<?php
									if(count($selectedCat)>0)
										foreach($selectedCat as $cat){?>
											<option value="<?php echo $cat['id_category'];?>" <?php  echo isset($obj)&&$obj->id_category_default==$cat['id_category']?'selected="selected"':'';?>><?php echo $cat['name'];?></option>
										<?php }?>
								</select>
								<p class="text-muted" id="no_default_category">默认分类需要先选择关联分类.</p>
							</div>
						</div>
						<?php
						$brandData = Brand::getEntity();
						if($brandData){
						$brands = $brandData['entitys'];
						?>
						<div class="form-group">
							<label for="categoryBox" class="col-sm-2 control-label">品牌</label>
							<div class="col-sm-10">
								<select name="id_brand" class="form-control" id="id_brand">
									<?php
									foreach($brands as $brand){ ?>
											<option value="<?php echo $brand['id_brand'];?>" <?php  echo isset($obj)&&$obj->id_brand==$brand['id_brand']?'selected="selected"':'';?>><?php echo $brand['name'];?></option>
										<?php }?>
								</select>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
		  </div>
		  
		  <div id="product-tab-content-Atrribute" class="product-tab-content" style=" display:none">
			<div class="row">
				<div class="col-md-10 form-horizontal">
					<div class="form-group">
						<label for="categoryBox" class="col-sm-2 control-label">商品属性</label>
						<div class="col-sm-10">
							<div class="col-xs-6">
								<input type="hidden" value="" id="itemsInput" name="attribute_items">
								<?php $attributeGroup = AttributeGroup::getEntitys();?>
								<p>可选属性</p>
								<select id="availableItems" class="form-control" multiple="multiple" style="height: 260px;">
									<?php foreach($attributeGroup['entitys'] as $group){?>
										<optgroup id="<?php echo $group['id_attribute_group'];?>" label="<?php echo $group['name'];?>" name="<?php echo $group['id_attribute_group'];?>">
											<?php
											$attributegroup = new AttributeGroup((int)($group['id_attribute_group']));
											$attributes = $attributegroup->getAttributes();
											foreach($attributes as $attribute){
												?>
												<option value="<?php echo $attribute['id_attribute'];?>"><?php echo $attribute['name'];?></option>
											<?php }?>
										</optgroup>
									<?php }?>
								</select><br/>
								<a class="btn btn-default btn-block" id="addItem" href="#">添加到 <span aria-hidden="true" class="glyphicon glyphicon-arrow-right"></span></a>
							</div>
							<div class="col-xs-6">
								<?php
								$groups = array();
								if(isset($obj))
									$groups = Product::getAttributeAndGrop($obj->id);
								?>
								<p>已选属性</p>
								<select id="items" multiple="multiple" class="form-control" style="height: 260px;">
									<?php foreach($groups as $group){?>
									<optgroup id="<?php echo $group['id_attribute_group'];?>" label="<?php echo $group['name'];?>" name="<?php echo $group['id_attribute_group'];?>">
										<?php foreach($group['attributes'] as $attribute){?>
											<option value="<?php echo $attribute['id_attribute'];?>"><?php echo $attribute['name'];?></option>
										<?php }?>
										<?php }?>
									</optgroup>
								</select><br/>
								<a class="btn btn-default btn-block" id="removeItem" href="#"><span aria-hidden="true" class="glyphicon glyphicon-arrow-left"></span> 删除</a>
							</div>
						</div>
					</div>
					<script type="text/javascript">
					$(document).ready(function(){
						$("#addItem").click(add);
						$("#availableItems").dblclick(add);
						$("#removeItem").click(remove);
						$("#items").dblclick(remove);
						function add()
						{
							$("#availableItems option:selected").each(function(i){
								$("#items").append("<option value=\""+$(this).val()+"\">"+$(this).text()+"</option>");
								$(this).remove();
							});
							serialize();
							return false;
						}
						function remove()
						{
							$("#items option:selected").each(function(i){
								$("#availableItems").append("<option value=\"" + $(this).val() + "\">" + $(this).text() + "</option>");
								$(this).remove();
							});
							serialize();
							return false;
						}
						function serialize()
						{
							var options = "";
							$("#items option").each(function(i){
								options += $(this).val()+",";
							});
							$("#itemsInput").val(options.substr(0, options.length - 1));
						}
					});
				</script>
				</div>
			</div>
		  </div>

		  
		  <div id="product-tab-content-Image" class="product-tab-content" style=" display:none">
			<div class="separation"></div>
			

<?php if(isset($id) && isset($obj)){ ?>
	<table cellpadding="5" style="width:100%">
		<tr>
			<td class="col-left"><label class="file_upload_label">图片：</label></td>
			<td style="padding-bottom:5px;">
				<div id="file-uploader">
					<noscript>
						<p>请启用Javascript,否则无法上传图片.</p>
					</noscript>
				</div>
				<div id="progressBarImage" class="progressBarImage"></div>
				<div id="showCounter" style="display:none;"><span id="imageUpload">0</span><span id="imageTotal">0</span></div>
					<p class="preference_description" style="clear: both;">
						支持格式: JPG, GIF, PNG. 单个文件大小不超过2M.
					</p>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align:center;">
				<input type="hidden" name="resizer" value="auto" />
			</td>
		</tr>
		<tr><td colspan="2" style="padding-bottom:10px;"><div class="separation"></div></td></tr>
		<tr>
			<td colspan="2">
				<table cellspacing="0" cellpadding="0" class="table tableDnD" id="imageTable">
						<thead>
						<tr class="nodrag nodrop"> 
							<th style="width: 100px;">图片</th>
							<th>排序</th>
							<th>封面</th>
							<th>操作</th>
						</tr>
						</thead>
						<tbody id="imageList">
						</tbody>
				</table>
			</td>
		</tr>
	</table>

	<table id="lineType" style="display:none;">
		<tr id="image_id">
			<td style="padding: 4px;">
				<a href="<?php echo $_tmconfig['pro_dir']; ?>image_path.jpg">
					<img src="<?php echo $_tmconfig['pro_dir']; ?>en-default-small.jpg" alt="image_id" title="image_id" />
				</a>
			</td>
			<td id="td_image_id" class="pointer dragHandle center positionImage">
				image_position
			</td>
			<td class="center cover"><a href="#">
				<img class="covered" src="<?php echo $_tmconfig['ico_dir'];?>blank.gif" alt="e" /></a>
			</td>
			<td class="center">
				<a href="#" class="delete_product_image" >
					<img src="<?php echo $_tmconfig['ico_dir'];?>delete.gif" alt="删除" title="删除" />
				</a>
			</td>
		</tr>
	</table>

	<script type="text/javascript">
		var upbutton = '上传图片';
		var success_add =  '图片上传成功';
		var id_tmp = 0;

		//Ready Function
		$(document).ready(function(){
			<?php 
				 foreach($images as $r){
				 	$image = new Image($r['id_image']);
				 	echo 'imageLine('.$image->id.', "'.$image->getExistingImgPath().'", '.$image->position.', "'.(($image->cover)?'enabled':'forbbiden').'");';
				 }	
			?>

			$('.tmdatatimepicker').datetimepicker({
				language: 'zh-CN',
				container: '.container-fluid',
				format: 'yyyy-mm-dd hh:ii'
			});

			$("#imageTable").tableDnD(
			{
				onDrop: function(table, row) {
				current = $(row).attr("id");
				stop = false;
				image_up = "{";
				$("#imageList").find("tr").each(function(i) {
					$("#td_" +  $(this).attr("id")).html(i + 1);
					if (!stop || (i + 1) == 2)
						image_up += '"' + $(this).attr("id") + '" : ' + (i + 1) + ',';
				});
				image_up = image_up.slice(0, -1);
				image_up += "}";
				updateImagePosition(image_up);
				}
			});
			var filecheck = 1;
			var uploader = new qq.FileUploader(
			{
				element: document.getElementById("file-uploader"),
				action: "public/ajax-img.php",
				debug: false,
				params: {
					id_product : <?php echo $id;?>,
					id_category : <?php echo $obj->id_category_default;?>,
					action : 'addImage',
					ajax: 1
				},
				onComplete: function(id, fileName, responseJSON)
				{
					var percent = ((filecheck * 100) / nbfile);
					$("#progressBarImage").progressbar({value: percent});
					if (percent != 100)
					{
						$("#imageUpload").html(parseInt(filecheck));
						$("#imageTotal").html(" / " + parseInt(nbfile) + " {/literal}{l s='Images'}{literal}");
						$("#progressBarImage").show();
						$("#showCounter").show();
					}
					else
					{
						$("#progressBarImage").progressbar({value: 0});
						$("#progressBarImage").hide();
						$("#showCounter").hide();
						nbfile = 0;
						filecheck = 0;
					}
					if (responseJSON.status == 'ok')
					{
						cover = "forbbiden";
						if (responseJSON.cover == "1")
							cover = "enabled";
						imageLine(responseJSON.id, responseJSON.path, responseJSON.position, cover)
						$("#imageTable tr:last").after(responseJSON.html);
						$("#countImage").html(parseInt($("#countImage").html()) + 1);
						$("#img" + id).remove();
						$("#imageTable").tableDnDUpdate();
						showSuccessMessage(responseJSON.name + " " + success_add);
					}
					else
						showErrorMessage(responseJSON.error);
					filecheck++;
				},
				onSubmit: function(id, filename)
				{
					$("#imageTable").show();
					$("#listImage").append("<li id='img"+id+"'><div class=\"float\" >" + filename + "</div></div><a style=\"margin-left:10px\"href=\"javascript:delQueue(" + id +");\"><img src=\"<?php echo $_tmconfig['ico_dir'];?>disabled.gif\" alt=\"\" border=\"0\"></a><p class=\"errorImg\"></p></li>");
				}
			});

			/**
			 * on success function 
			 */
			function afterDeleteProductImage(data)
			{
				data = $.parseJSON(data);
				if (data)
				{
					cover = 0;
					id = data.content.id;
					if(data.status == 'ok')
					{
						if ($("#" + id).find(".covered").attr("src") == "<?php echo $_tmconfig['ico_dir'];?>enabled.gif")
							cover = 1;
						$("#" + id).remove();
					}
					if (cover)
						$("#imageTable tr").eq(1).find(".covered").attr("src", "<?php echo $_tmconfig['ico_dir'];?>enabled.gif");
					$("#countImage").html(parseInt($("#countImage").html()) - 1);
					refreshImagePositions($("#imageTable"));
					
					showSuccessMessage(data.confirmations);

				}
			}

			$('.delete_product_image').off().on('click', function(e)
			{
				e.preventDefault();
				id = $(this).parent().parent().attr('id');
				if (confirm("你确定？"))
				doAdminAjax({
						"action":"deleteProductImage",
						"id_image":id,
						"id_product" : <?php echo $id;?>,
						"id_category" : <?php echo $obj->id_category_default;?>,
						"ajax" : 1 },'public/ajax-img.php', afterDeleteProductImage
				);
			});
			
			$('.covered').off().on('click', function(e)
			{
				e.preventDefault();
				id = $(this).parent().parent().parent().attr('id');
				$("#imageList .cover img").each( function(i){
					$(this).attr("src", $(this).attr("src").replace("enabled", "forbbiden"));
				});
				$(this).attr("src", $(this).attr("src").replace("forbbiden", "enabled"));

				$(this).parent().parent().parent().children('td input').attr('check', true);
				doAdminAjax({
					"action":"UpdateCover",
					"id_image":id,
					"id_product" : <?php echo $id;?>,
					"ajax" : 1 },'public/ajax-img.php'
				);
				
			});
			
			$('.image_shop').off().on('click', function()
			{
				active = false;
				if ($(this).attr("checked"))
					active = true;
				id = $(this).parent().parent().attr('id');
				id_shop = $(this).attr("id").replace(id, "");
				doAdminAjax(
				{
					"action":"UpdateProductImageShopAsso",
					"id_image":id,
					"active":active,
					"tab" : "AdminProducts",
					"ajax" : 1 
				});
			});
			
			//function	
			function updateImagePosition(json)
			{
				doAdminAjax(
				{
					"action":"updateImagePosition",
					"json":json,
					"tab" : "AdminProducts",
					"ajax" : 1
				});
	
			}
			
			function delQueue(id)
			{
				$("#img" + id).fadeOut("slow");
				$("#img" + id).remove();
			}
			
			function imageLine(id, path, position, cover)
			{
				line = $("#lineType").html();
				line = line.replace(/image_id/g, id);
			    line = line.replace(/en-default/g, path);
			    line = line.replace(/image_path/g, path);
				line = line.replace(/image_position/g, position);
				line = line.replace(/blank/g, cover);
				line = line.replace("<tbody>", "");
				line = line.replace("</tbody>", "");
				$("#imageList").append(line);
			}
		});
	</script>
<?php }?>

			
		  </div>
		</div>
	</form>
</div>
</div>