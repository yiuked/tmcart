<!--head-->
<link type="text/css" rel="stylesheet" href="../themes/default/default.css" />
<link type="text/css" href="../js/jquery/ui/themes/base/jquery.ui.theme.css" rel="stylesheet"  media="all" />
<link type="text/css" href="../js/jquery/ui/themes/base/jquery.ui.theme.css" rel="stylesheet"  media="all" />
<script type="text/javascript" src="../js/kindeditor/kindeditor-min.js"></script>
<script type="text/javascript" src="../js/kindeditor/lang/zh_CN.js"></script>
<script type="text/javascript" src="../js/jquery/ui/jquery.ui.core.min.js"></script>
<script type="text/javascript" src="../js/jquery/ui/jquery.ui.datepicker.min.js"></script>
<script type="text/javascript" src="../js/jquery/ui/i18n/jquery.ui.datepicker-en.js"></script>
<!--//head-->
<?php
if(isset($_POST['sveCategory']) && Tools::getRequest('sveCategory')=='add')
{
	$cmscategory = new Category();
	$cmscategory->copyFromPost();
	$cmscategory->add();
	
	if(is_array($cmscategory->_errors) AND count($cmscategory->_errors)>0){
		$errors = $cmscategory->_errors;
	}else{
		$_GET['id']	= $cmscategory->id;
		echo '<div class="conf">创建分类成功</div>';
	}
}

if(isset($_GET['id'])){
	$id  = (int)$_GET['id'];
	$obj = new Category($id);
}

if(isset($_POST['sveCategory']) && Tools::getRequest('sveCategory')=='edit')
{

  if(Tools::getRequest('id_parent')==$obj->id){
  		$obj->_errors[] = '父分类不能为当前分类！';
  }elseif(Validate::isLoadedObject($obj)){
  		$obj->copyFromPost();
		$obj->update();
}
	

	if(is_array($obj->_errors) AND count($obj->_errors)>0){
		$errors = $obj->_errors;
	}else{
		echo '<div class="conf">更新分类成功</div>';
	}
 
}
require_once(_TM_ADMIN_DIR_.'/errors.php');
?>
<div class="path_bar">
  <div class="path_title">
    <h3> 
		<span style="font-weight: normal;" id="current_obj">
		<span class="breadcrumb item-1 ">CMS<img src="<?php echo $_tmconfig['tm_img_dir'];?>admin/separator_breadcrum.png" style="margin-right:5px" alt="&gt;"> </span>
		<span class="breadcrumb item-1 ">分类<img src="<?php echo $_tmconfig['tm_img_dir'];?>admin/separator_breadcrum.png" style="margin-right:5px" alt="&gt;"> </span> 
		<span class="breadcrumb item-2 ">编辑 </span> </span> 
	</h3>
    <div class="cc_button">
      <ul>
        <li> <a title="Save" href="#" class="toolbar_btn" id="desc-product-save"> <span class="process-icon-save "></span>
          <div>保存</div>
          </a> </li>
        <li> <a title="Back to list" href="javascript:history.back();" class="toolbar_btn" id="desc-product-back"> <span class="process-icon-back "></span>
          <div>返回列表</div>
          </a> </li>
      </ul>
    </div>
  </div>
</div>
<script language="javascript">
	$("#desc-product-save").click(function(){
		$("#cms_category_form").submit();
	})
</script>
<div class="mianForm">
	<form enctype="multipart/form-data" method="post" action="index.php?rule=category_edit<?php echo isset($id)?'&id='.$id:''?>" class="defaultForm admincmscontent" id="cms_category_form" name="example">
		  <fieldset>
  			<legend> <img alt="CMS 分类" src="<?php echo $_tmconfig['tm_img_dir'];?>icon/category.png">分类</legend>
			<label>分类名: </label>
			<div class="margin-form">
				<div style="display:block; float: left;">
					<input type="text" class="text_input" value="<?php echo isset($obj)?$obj->name:Tools::getRequest('name');?>"  name="name" id="name" onkeyup="if (isArrowKey(event)) return ;copy2friendlyURL();" onchange="copy2friendlyURL();">
					<span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span>
				</div>
				<sup>*</sup>
				<div class="clear"></div>
			</div>
			<label>状态: </label>
			<div class="margin-form">
					<input type="radio" checked="checked" value="1" id="active_on" name="active">
					<label for="active_on" class="t">
						<img title="Enabled" alt="Enabled" src="<?php echo $_tmconfig['ico_dir'];?>enabled.gif">
					</label>
					<input type="radio" value="0" id="active_off" name="active">
					<label for="active_off" class="t">
						<img title="Disabled" alt="Disabled" src="<?php echo $_tmconfig['ico_dir'];?>disabled.gif">
					</label>
			</div>
			<label>所属分类：</label>
				<div class="margin-form">
				<?php
				$trads = array(
					 'Home' => '根分类', 
					 'selected' => '选择', 
					 'Collapse All' => '关闭', 
					 'Expand All' => '展开'
				);
				echo Helper::renderAdminCategorieTree($trads, array(isset($obj)?$obj->id_parent:1), 'id_parent', true,'Tree');
			 ?>
			 
			 
			</div>
			<label>Meta Title: </label>
			<div class="margin-form">
				<div style="display:block; float: left;">
					<input type="text" class="text_input" value="<?php echo isset($obj)?$obj->meta_title:Tools::getRequest('meta_title');?>"  name="meta_title">
					<span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span>
				</div>
				<div class="clear"></div>
			</div>
			<label>Meta Keywords: </label>
			<div class="margin-form">
				<div style="display:block; float: left;">
					<input type="text" class="text_input" value="<?php echo isset($obj)?$obj->meta_keywords:Tools::getRequest('meta_keywords');?>"  name="meta_keywords">
					<span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span>
				</div>
				<div class="clear"></div>
			</div>
			<label>Meta Description: </label>
			<div class="margin-form">
				<div style="display:block; float: left;">
					<input type="text" class="text_input" value="<?php echo isset($obj)?$obj->meta_description:Tools::getRequest('meta_description');?>"  name="meta_description">
					<span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span>
				</div>
				<div class="clear"></div>
			</div>
			<label>友好URL链接: </label>
			<div class="margin-form">
				<div style="display:block; float: left;">
					<input type="text" class="text_input" value="<?php echo isset($obj)?$obj->rewrite:Tools::getRequest('rewrite');?>"  id="rewrite" name="rewrite" onkeyup="if (isArrowKey(event)) return ;generateFriendlyURL();" onchange="generateFriendlyURL();">
					<span name="help_box" class="hint" style="display: none;">只能包含数字,字母及"-"<span class="hint-pointer">&nbsp;</span></span>
				</div>
				<sup>*</sup>
				<div class="clear"></div>
			</div>
		<script>
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
		</script>
			<label>内容描述: </label>
			<div class="margin-form">
				<div style="display:block; float: left;">
					<textarea name="description" style="width:800px;height:400px;visibility:hidden;"><?php echo isset($obj)?$obj->description:Tools::getRequest('description');?></textarea>
				</div>
				<div class="clear"></div>
			</div>
		<script type="text/javascript">
			$(function() {
				if ($(".datepicker").length > 0)
					$(".datepicker").datepicker({
						prevText: '',
						nextText: '',
						dateFormat: 'yy-mm-dd'
					});
			});
		</script>
			<label>添加时间: </label>
			<div class="margin-form">
				<div style="display:block; float: left;">
					<input type="text" class="text_input_sort datepicker" value="<?php echo isset($obj)?$obj->add_date:Tools::getRequest('add_date');?>"  name="add_date">
				</div>
				<div class="clear"></div>
			</div>
			<label>修改时间: </label>
			<div class="margin-form">
				<div style="display:block; float: left;">
					<input type="text" class="text_input_sort datepicker" value="<?php echo isset($obj)?$obj->upd_date:Tools::getRequest('upd_date');?>"  name="upd_date">
				</div>
				<div class="clear"></div>
			</div>
			<input type="hidden" value="<?php echo isset($id)?'edit':'add'?>"  name="sveCategory">
		  </fieldset>
	</form>
</div>
