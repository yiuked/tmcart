<!--head-->
<link href="<?php echo $_tmconfig['tm_js_dir']?>jquery/ui/themes/base/jquery.ui.theme.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?php echo $_tmconfig['tm_js_dir']?>jquery/ui/themes/base/jquery.ui.datepicker.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?php echo $_tmconfig['tm_js_dir']?>jquery/ui/themes/base/jquery.ui.slider.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?php echo $_tmconfig['tm_js_dir']?>jquery/plugins/timepicker/jquery-ui-timepicker-addon.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?php echo $_tmconfig['tm_js_dir']?>jquery/ui/themes/base/jquery.ui.datepicker.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?php echo $_tmconfig['tm_js_dir']?>jquery/plugins/treeview-categories/jquery.treeview-categories.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?php echo $_tmconfig['tm_js_dir']?>jquery/plugins/timepicker/jquery-ui-timepicker-addon.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?php echo $_tmconfig['tm_js_dir']?>jquery/plugins/ajaxfileupload/jquery.ajaxfileupload.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?php echo $_tmconfig['tm_js_dir']?>jquery/plugins/fancybox/jquery.fancybox.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="<?php echo $_tmconfig['tm_js_dir']?>kindeditor/kindeditor-min.js"></script>
<script type="text/javascript" src="<?php echo $_tmconfig['tm_js_dir']?>kindeditor/lang/zh_CN.js"></script>
<script type="text/javascript" src="<?php echo $_tmconfig['tm_js_dir']?>jquery/ui/jquery.ui.core.min.js"></script>
<script type="text/javascript" src="<?php echo $_tmconfig['tm_js_dir']?>jquery/ui/jquery.ui.widget.min.js"></script>
<script type="text/javascript" src="<?php echo $_tmconfig['tm_js_dir']?>jquery/ui/jquery.ui.mouse.min.js"></script>
<script type="text/javascript" src="<?php echo $_tmconfig['tm_js_dir']?>jquery/ui/jquery.ui.slider.min.js"></script>
<script type="text/javascript" src="<?php echo $_tmconfig['tm_js_dir']?>jquery/ui/jquery.ui.datepicker.min.js"></script>
<script type="text/javascript" src="<?php echo $_tmconfig['tm_js_dir']?>jquery/ui/i18n/jquery.ui.datepicker-zh-CN.js"></script>
<script type="text/javascript" src="<?php echo $_tmconfig['tm_js_dir']?>jquery/ui/jquery.ui.progressbar.min.js"></script>
<script type="text/javascript" src="<?php echo $_tmconfig['tm_js_dir']?>jquery/plugins/timepicker/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript" src="<?php echo $_tmconfig['tm_js_dir']?>jquery/plugins/ajaxfileupload/jquery.ajaxfileupload.js"></script>
<script type="text/javascript" src="<?php echo $_tmconfig['tm_js_dir']?>fileuploader.js"></script>
<script type="text/javascript" src="<?php echo $_tmconfig['tm_js_dir']?>jquery/jquery.tablednd_0_5.js"></script>
<script type="text/javascript" src="<?php echo $_tmconfig['tm_js_dir']?>jquery/plugins/fancybox/jquery.fancybox.js"></script>
<!--//head-->
<?php
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
		echo '<div class="conf">更新产品内容成功</div>';
	}
	
}
require_once(_TM_ADMIN_DIR_.'/errors.php');
?>
<div class="path_bar">
  <div class="path_title">
    <h3> 
		<span style="font-weight: normal;" id="current_obj">
		<span class="breadcrumb item-1 ">商品<img src="<?php echo $_tmconfig['tm_img_dir'];?>admin/separator_breadcrum.png" style="margin-right:5px" alt="&gt;"> </span>
		<span class="breadcrumb item-2 ">编辑 </span> </span> 
	</h3>
    <div class="cc_button">
      <ul>
	    <?php if(isset($obj)){?>
		<li> <a title="Save" href="<?php echo $link->getPage('ProductView',$obj->id);?>" class="toolbar_btn" target="_blank" id="desc-product-view"> <span class="process-icon-view "></span>
          <div>浏览</div>
          </a> </li>
		 <?php }?>
        <li> <a title="Save" href="#" class="toolbar_btn" id="desc-product-save"> <span class="process-icon-save "></span>
          <div>保存</div>
          </a> </li>
        <li> <a title="Back to list" href="index.php?rule=product" class="toolbar_btn" id="desc-product-back"> <span class="process-icon-back "></span>
          <div>返回列表</div>
          </a> </li>
      </ul>
    </div>
  </div>
</div>
<script language="javascript">
	$("#desc-product-save").click(function(){
		$("#product_form").submit();
	})
	$(function() {
		if ($(".datepicker").length > 0)
				$('.datepicker').datetimepicker({
					prevText: '',
					nextText: '',
					dateFormat: 'yy-mm-dd',

					// Define a custom regional settings in order to use PrestaShop translation tools
					currentText: '现在',
					closeText: '完成',
					ampm: false,
					amNames: ['AM', 'A'],
					pmNames: ['PM', 'P'],
					timeFormat: 'hh:mm:ss tt',
					timeSuffix: '',
					timeOnlyTitle: '选择时间',
					timeText: '时间',
					hourText: '小时',
					minuteText: '分钟',
				});
	});
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
<div class="mianForm">
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
				<h4>基本信息</h4>
				<div class="separation"></div>
				<table cellpadding="5" style="width: 50%; float: left; margin-right: 20px; border-right: 1px solid #CCCCCC;">
					<tr>
						<td class="col-left"><label>产品名: </label></td>
						<td>
							<div style="display:block; float: left;">
							<input type="text" value="<?php echo isset($obj)?$obj->name:Tools::getRequest('name');?>" id="name" name="name" size="60" onkeyup="if (isArrowKey(event)) return ;copy2friendlyURL();" onchange="copy2friendlyURL();">
							<sup>*</sup>
							<span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span>
						</div>
						</td>
					</tr>
					<tr>
						<td class="col-left"><label>产品编号: </label></td>
						<td>
							<div style="display:block; float: left;">
							<input type="text" value="<?php echo isset($obj)?$obj->ean13:Tools::getRequest('ean13');?>"  name="ean13" size="20">
							<sup>*</sup>
							<span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span>
						</div>
						</td>
					</tr>
					<tr>
						<td class="col-left"><label>库存: </label></td>
						<td>
							<div style="display:block; float: left;">
							<input type="text" value="<?php echo isset($obj)?$obj->quantity:(Tools::getRequest('quantity')?Tools::getRequest('quantity'):0);?>"  name="quantity" size="20">
							<sup>*</sup>
							<span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span>
						</div>
						</td>
					</tr>
					<tr>
						<td class="col-left"><label>价格: </label></td>
						<td>
							<div style="display:block; float: left;">
							<input type="text" value="<?php echo isset($obj)?$obj->price:(Tools::getRequest('price')?Tools::getRequest('price'):0);?>"  name="price" size="20">
							<sup>*</sup>
							<span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span>
						</div>
						</td>
					</tr>
					<tr>
						<td class="col-left"><label>官方标价: </label></td>
						<td>
							<div style="display:block; float: left;">
							<input type="text" value="<?php echo isset($obj)?$obj->special_price:(Tools::getRequest('special_price')?Tools::getRequest('special_price'):0);?>"  name="special_price" size="20">						
							<span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span>
						</div>
						</td>
					</tr>
					<tr>
						<td class="col-left"><label>促销日期: </label></td>
						<td>
							<div style="display:block; float: left; padding:0" class="margin-form">
							起于
							<input type="text" class="text_input_sort datepicker" value="<?php echo isset($obj)?$obj->from_date:Tools::getRequest('from_date');?>"  name="from_date">&nbsp;
							终于
							<input type="text" class="text_input_sort datepicker" value="<?php echo isset($obj)?$obj->to_date:Tools::getRequest('to_date');?>"  name="to_date">
							<span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span>
						</div>
						</td>
					</tr>
				</table>
				<table cellpadding="5" style="width: 40%; float: left; margin-left: 10px;">
					<tr>
						<td class="col-left"><label>产品状态: </label></td>
						<td style="padding-bottom:5px;">
							<ul class="listForm">
								<li>
									<input type="radio" checked="checked" value="1" id="active_on" name="active">
									<label class="radioCheck" for="active_on">启用</label>
								</li>
								<li>
									<input type="radio" value="0" id="active_off" name="active">
									<label class="radioCheck" for="active_off">关闭</label>
								</li>
							</ul>
						</td>
					</tr>
					<tr>
						<td class="col-left"><label>新产品: </label></td>
						<td style="padding-bottom:5px;">
							<ul class="listForm">
								<li>
									<input type="radio" value="1" id="is_new_on" name="is_new">
									<label class="radioCheck" for="is_new_on">是</label>
								</li>
								<li>
									<input type="radio" value="0" id="is_new_off" name="is_new">
									<label class="radioCheck" for="is_new_off">否</label>
								</li>
							</ul>
						</td>
					</tr>
					<tr>
						<td class="col-left"><label>热销产品: </label></td>
						<td style="padding-bottom:5px;">
							<ul class="listForm">
								<li>
									<input type="radio" value="1" id="is_sale_on" name="is_sale">
									<label class="radioCheck" for="is_sale_on">是</label>
								</li>
								<li>
									<input type="radio" value="0" id="is_sale_off" name="is_sale">
									<label class="radioCheck" for="is_sale_off">否</label>
								</li>
							</ul>
						</td>
					</tr>
					<tr>
						<td class="col-left"><label>推荐产品: </label></td>
						<td style="padding-bottom:5px;">
							<ul class="listForm">
								<li>
									<input type="radio" value="1" id="is_top_on" name="is_top">
									<label class="radioCheck" for="is_top_on">是</label>
								</li>
								<li>
									<input type="radio" value="0" id="is_top_off" name="is_top">
									<label class="radioCheck" for="is_top_off">否</label>
								</li>
							</ul>
						</td>
					</tr>
				</table>
				<div class="clear"></div>
				<div class="separation"></div>
				<table cellspacing="0" cellpadding="5" border="0">
					<td class="col-left" valign="top"><label>内容描述: </label></td>
					<td>
						<div style="display:block; float: left;">
							<textarea name="description" class="description" style="width:700px;height:300px;visibility:hidden;"><?php echo isset($obj->description)?$obj->description:Tools::getRequest('description');?></textarea>
						</div>
					</td>
				</table>
				
			</div>
			
			<div id="product-tab-content-SEO" class="product-tab-content" style=" display:none">
				<h4>SEO</h4>
				<div class="separation"></div>
				<table cellspacing="0" cellpadding="5" border="0">
				 <tr>
					<td class="col-left" valign="top"><label>Tab 标签: </label></td>
					<td>
					<div style="display:block; float: left;">
						<input type="text" class="text_input" value="<?php echo isset($obj)?(Tag::tagToString($obj->id)):Tools::getRequest('tags');?>"  name="tags">
						<span name="help_box" class="hint" style="display: none;">以","号分隔<span class="hint-pointer">&nbsp;</span></span>
					</div>
					</td>
				</tr><tr>
					<td class="col-left" valign="top"><label>Meta Title: </label></td>
					<td>
					<div style="display:block; float: left;">
						<input type="text" class="text_input" value="<?php echo isset($obj)?$obj->meta_title:Tools::getRequest('meta_title');?>"  name="meta_title">
						<span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span>
					</div>
					</td>
				</tr><tr>
					<td class="col-left" valign="top"><label>Meta Keywords: </label></td>
					<td>
					<div style="display:block; float: left;">
						<input type="text" class="text_input" value="<?php echo isset($obj)?$obj->meta_title:Tools::getRequest('meta_title');?>"  name="meta_title">
						<span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span>
					</div>
					</td>
				</tr><tr>
					<td class="col-left" valign="top"><label>Meta Description: </label></td>
					<td>
					<div style="display:block; float: left;">
						<textarea name="meta_description" cols="80"><?php echo isset($obj)?$obj->meta_description:Tools::getRequest('meta_description');?></textarea>
						<span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span>
					</div>
					</td>
				</tr><tr>
					<td class="col-left" valign="top"><label>Url Rewrite: </label></td>
					<td>
					<div style="display:block; float: left;">
						<input type="text" class="text_input" value="<?php echo isset($obj)?$obj->rewrite:Tools::getRequest('rewrite');?>"  name="rewrite" id="rewrite" onkeyup="if (isArrowKey(event)) return ;generateFriendlyURL();" onchange="generateFriendlyURL();">
						<sup>*</sup>
						<p class="preference_description">只能包含数字,字母及"-"<span class="hint-pointer">&nbsp;</span></p>
					</div>
					</td>
				 </tr>
				</table>			
			</div>
			
			<div id="product-tab-content-Category" class="product-tab-content" style=" display:none">
				<h4>分类</h4>
				<div class="separation"></div>
				<label>关联分类：</label>
				<div class="margin-form">
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
			 	<br>
				 <a href="index.php?rule=category_edit" class="button bt-icon confirm_leave">
					<img title="添加分类" alt="添加分类" src="<?php echo $_tmconfig['tm_img_dir'];?>icon/add.gif" style="vertical-align: bottom;">
					<span>添加分类</span>
				</a>
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
			<label>默认分类: </label>
			<div class="margin-form">
				<div style="display:block; float: left;">
					<select name="id_category_default" id="id_category_default" <?php if(!$selectedCat || count($selectedCat)==0){echo 'style="display:none"';}?>>
					<?php
					  if(count($selectedCat)>0)
						foreach($selectedCat as $cat){?>
						<option value="<?php echo $cat['id_category'];?>" <?php  echo isset($obj)&&$obj->id_category_default==$cat['id_category']?'selected="selected"':'';?>><?php echo $cat['name'];?></option>
					<?php }?>
					</select>
					<div style="display:block;" id="no_default_category">默认分类需要先选择关联分类.</div>
				</div>
				<sup>*</sup>
				<div class="clear"></div>
			</div>
			<?php
				$brandData = Brand::getEntity();
				if($brandData){
				$brands = $brandData['entitys'];
			?>
			<label>品牌: </label>
			<div class="margin-form">
				<div style="display:block; float: left;">
					<?php
						foreach($brands as $brand){?>
						<input type="radio" name="id_brand" value="<?php echo $brand['id_brand'];?>" <?php  echo isset($obj)&&$obj->id_brand==$brand['id_brand']?'checked':'';?> /><?php echo $brand['name'];?><br>
					<?php }?>
				</div>
				<div class="clear"></div>
			</div>
			<?php
				}
			?>
		  </div>
		  
		  <div id="product-tab-content-Atrribute" class="product-tab-content" style=" display:none">
		  	<h4>属性</h4>
			<div class="separation"></div>
			 <table cellspacing="0" cellpadding="5" border="0">
				 <tr>
					<td class="col-left" valign="top">
				 <input type="hidden" value="" id="itemsInput" name="attribute_items">
				  <?php $attributeGroup = AttributeGroup::getEntitys();?>
				  <select id="availableItems" class="" multiple="multiple" style="width: 300px; height: 260px;">
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
				  </select><br/><br/>
				  <a style="border: 1px solid rgb(170, 170, 170); margin: 2px; padding: 2px; text-align: center; display: block; text-decoration: none; background-color: rgb(250, 250, 250); color: rgb(18, 52, 86);" id="addItem" href="#">添加到 >></a>
					</td>
					<td>
					<?php
						$groups = array();
						if(isset($obj))	
							$groups = Product::getAttributeAndGrop($obj->id);
					?>
					<select id="items" multiple="multiple" style="width: 300px; height: 260px;">
						<?php foreach($groups as $group){?>
						<optgroup id="<?php echo $group['id_attribute_group'];?>" label="<?php echo $group['name'];?>" name="<?php echo $group['id_attribute_group'];?>">
						<?php foreach($group['attributes'] as $attribute){?>
						<option value="<?php echo $attribute['id_attribute'];?>"><?php echo $attribute['name'];?></option>
						<?php }?>
						<?php }?>
						</optgroup>
					</select><br/><br/>
					<a style="border: 1px solid rgb(170, 170, 170); margin: 2px; padding: 2px; text-align: center; display: block; text-decoration: none; background-color: rgb(250, 250, 250); color: rgb(18, 52, 86);" id="removeItem" href="#"><< 删除</a>
						<script type="text/javascript">
						$(document).ready(function(){
							$("#addItem").click(add);
							$("#availableItems").dblclick(add);
							$("#removeItem").click(remove);
							$("#items").dblclick(remove);
							function add()
							{
								$("#availableItems option:selected").each(function(i){
									var val = $(this).val();
									var text = $(this).text();
									text = text.replace(/(^\s*)|(\s*$)/gi,"");
									if (val == "PRODUCT")
									{
										val = prompt("Set ID product");
										if (val == null || val == "" || isNaN(val))
											return;
										text = "Product ID "+val;
										val = "PRD"+val;
									}
									$("#items").append("<option value=\""+val+"\">"+text+"</option>");
								});
								serialize();
								return false;
							}
							function remove()
							{
								$("#items option:selected").each(function(i){
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
					</td>
				</tr>
				</table>
		  </div>
		  
		  <div id="product-tab-content-Image" class="product-tab-content" style=" display:none">
		  	<h4>产品图片</h4>
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
				<a href="<?php echo $_tmconfig['pro_dir']; ?>image_path.jpg" class="fancybox">
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

			$('.delete_product_image').die().live('click', function(e)
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
			
			$('.covered').die().live('click', function(e)
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
			
			$('.image_shop').die().live('click', function()
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
			$('.fancybox').fancybox();
		});
	</script>
<?php }?>

			
		  </div>
		</div>
	</form>
</div>
