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

if(isset($_POST['sveCMS']) && Tools::getRequest('sveCMS')=='add')
{
	$cms = new CMS();
	$cms->copyFromPost();
	if($cms->add())
		if(!$cms->updateCategories($_POST['categoryBox']) OR !$cms->updateTags($_POST['tags']))
			$cms->_errors = '添加CMS内容时发生了一个错误';
	
	if(is_array($cms->_errors) AND count($cms->_errors)>0){
		$errors = $cms->_errors;
	}else{
		$_GET['id'] = $cms->id;
		echo '<div class="conf">创建CMS内容成功</div>';
	}
}

if(isset($_GET['id'])){
	$id  = (int)$_GET['id'];
	$obj = new CMS($id);
}

if(isset($_POST['sveCMS']) && Tools::getRequest('sveCMS')=='edit')
{
	if(Validate::isLoadedObject($obj)){
		$obj->copyFromPost();
		if($obj->update())
			if(!$obj->updateCategories($_POST['categoryBox']) OR !$obj->updateTags($_POST['tags']))
				$obj->_errors = '更新CMS内容时发生了一个错误';
	}
	if(is_array($obj->_errors) AND count($obj->_errors)>0){
		$errors = $obj->_errors;
	}else{
		echo '<div class="conf">更新CMS内容成功</div>';
	}
	
}
require_once(_TM_ADMIN_DIR_.'/errors.php');
?>
<div class="path_bar">
  <div class="path_title">
    <h3> 
		<span style="font-weight: normal;" id="current_obj">
		<span class="breadcrumb item-1 ">CMS<img src="<?php echo $_tmconfig['tm_img_dir'];?>admin/separator_breadcrum.png" style="margin-right:5px" alt="&gt;"> </span>
		<span class="breadcrumb item-1 ">内容<img src="<?php echo $_tmconfig['tm_img_dir'];?>admin/separator_breadcrum.png" style="margin-right:5px" alt="&gt;"> </span> 
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
		$("#cms_form").submit();
	})
</script>
<div class="mianForm">
	<form enctype="multipart/form-data" method="post" action="index.php?rule=cms_edit<?php echo isset($id)?'&id='.$id:''?>" class="defaultForm admincmscontent" id="cms_form" name="example">
		  <fieldset>
  			<legend> <img alt="CMS 分类" src="<?php echo $_tmconfig['ico_dir'];?>category.png">内容</legend>
			<label>标题: </label>
			<div class="margin-form">
				<div style="display:block; float: left;">
					<input type="text" class="text_input" value="<?php echo isset($obj)?$obj->title:Tools::getRequest('title');?>"  name="title">
					<span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span>
				</div>
				<sup>*</sup>
				<div class="clear"></div>
			</div>
			<label>状态: </label>
			<div class="margin-form">
					<input type="radio" value="1" id="active_on" name="active" <?php  echo isset($obj)&&$obj->active==1?'checked="checked"':''; ?>>
					<label for="active_on" class="t">
						<img title="Enabled" alt="Enabled" src="<?php echo $_tmconfig['ico_dir'];?>enabled.gif">
					</label>
					<input type="radio" value="0" id="active_off" name="active" <?php  echo isset($obj)&&$obj->active==0?'checked="checked"':''; ?>>
					<label for="active_off" class="t">
						<img title="Disabled" alt="Disabled" src="<?php echo $_tmconfig['ico_dir'];?>disabled.gif">
					</label>
			</div>
			<label>置顶: </label>
			<div class="margin-form">
					<input type="radio" value="1" id="is_top_on" name="is_top" <?php  echo isset($obj)&&$obj->is_top==1?'checked="checked"':''; ?>>
					<label for="is_top_on" class="t">
						<img title="Enabled" alt="Enabled" src="<?php echo $_tmconfig['ico_dir'];?>enabled.gif">
					</label>
					<input type="radio" value="0" id="is_top_off" name="is_top" checked="checked" <?php  echo isset($obj)&&$obj->active==0?'checked="checked"':''; ?>>
					<label for="is_top_off" class="t">
						<img title="Disabled" alt="Disabled" src="<?php echo $_tmconfig['ico_dir'];?>disabled.gif">
					</label>
			</div>
			<label>一个单独的页面: </label>
			<div class="margin-form">
					<input type="radio" value="1" id="is_page_on" name="is_page" checked="checked">
					<label for="is_page_on" class="t">
						<img title="Enabled" alt="Enabled" src="<?php echo $_tmconfig['ico_dir'];?>enabled.gif">
					</label>
					<input type="radio" value="0" id="is_page_off" name="is_page" <?php  echo isset($obj)&&$obj->is_page==0?'checked="checked"':''; ?>>
					<label for="is_page_off" class="t">
						<img title="Disabled" alt="Disabled" src="<?php echo $_tmconfig['ico_dir'];?>disabled.gif">
					</label>
			</div>
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
						$categoryBox = CMS::getCMSCategoriesFullId($obj->id);
				}
				echo Helper::renderAdminCategorieTree($trads,$categoryBox, 'categoryBox', false,'CMSTree');
			 ?>
			 	<br>
				 <a href="index.php?rule=cmscategory" class="button bt-icon confirm_leave">
					<img title="Create new category" alt="Create new category" src="<?php echo $_tmconfig['ico_dir'];?>add.gif">
					<span>添加分类</span>
				</a>
			</div>
			<?php
				if (!isset($obj))
				{
					$selectedCat = CMSCategory::getCategoryInformations(Tools::getRequest('categoryBox'));
				}
				else
				{
					if (Tools::isSubmit('categoryBox'))
						$selectedCat = CMSCategory::getCategoryInformations(Tools::getRequest('categoryBox'));
					else
						$selectedCat = CMS::getCMSCategoriesFull($obj->id);
				}
			?>
			<label>默认分类: </label>
			<div class="margin-form">
				<div style="display:block; float: left;">
					<select name="id_category_default" id="id_category_default" <?php if(count($selectedCat)==0){echo 'style="display:none"';}?>>
					<?php
					  if(count($selectedCat)>0)
						foreach($selectedCat as $cat){?>
						<option value="<?php echo $cat['id_cms_category'];?>" <?php  echo isset($obj)&&$obj->id_category_default==$cat['id_cms_category']?'selected="selected"':'';?>><?php echo $cat['name'];?></option>
					<?php }?>
					</select>
					<div style="display:block;" id="no_default_category">默认分类需要先选择关联分类.</div>
				</div>
				<sup>*</sup>
				<div class="clear"></div>
			</div>
			<label>Tab 标签: </label>
			<div class="margin-form">
				<div style="display:block; float: left;">
					<input type="text" class="text_input" value="<?php echo isset($obj)?(CMSTag::CMSTagToString($obj->id)):Tools::getRequest('tags');?>"  name="tags">
					<span name="help_box" class="hint" style="display: none;">以","号分隔<span class="hint-pointer">&nbsp;</span></span>
				</div>
				<div class="clear"></div>
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
					<input type="text" class="text_input" value="<?php echo isset($obj)?$obj->rewrite:Tools::getRequest('rewrite');?>"  name="rewrite">
					<span name="help_box" class="hint" style="display: none;">只能包含数字,字母及"-"<span class="hint-pointer">&nbsp;</span></span>
				</div>
				<sup>*</sup>
				<div class="clear"></div>
			</div>
		<script>
			KindEditor.ready(function(K) {
				var editor1 = K.create('textarea[name="content"]', {
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
					<textarea name="content" style="width:800px;height:400px;visibility:hidden;"><?php echo isset($obj)?$obj->content:Tools::getRequest('content');?></textarea>
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
			<input type="hidden" value="<?php echo isset($id)?'edit':'add'?>"  name="sveCMS">
		  </fieldset>
	</form>
</div>
