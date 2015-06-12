<?php

if(isset($_POST['SEOCateMetaUpdate']))
{
	if(count($_POST['categoryBox'])>0){
		SEOHelper::updateCategoryMeta($_POST);
	}
}
require_once(_TM_ADMIN_DIR_.'/errors.php');
?>
<div class="path_bar">
  <div class="path_title">
    <h3> 
		<span style="font-weight: normal;" id="current_obj">
		<span class="breadcrumb item-1 ">Meta批量管理</span><img src="<?php echo $_tmconfig['tm_img_dir'];?>admin/separator_breadcrum.png" style="margin-right:5px" alt="&gt;">
		<span class="breadcrumb item-2 ">分类Meta </span></span> 
	</h3>
	<div class="cc_button">
	  <ul>
		<li><a title="Back to list" href="index.php?rule=seo_meta_product" class="toolbar_btn" id="desc-product-tools"> <span class="process-icon-tools"></span>
		  <div>产品Metat管理</div>
		  </a> </li>
	  </ul>
	</div>
  </div>
</div>
<div class="mianForm">
	<form enctype="multipart/form-data" method="post" action="index.php?rule=seo_meta" class="defaultForm admincmscontent" id="seo_cate_meta_form" name="example">
		  <fieldset class="small">
  			<legend> <img alt="设置" src="<?php echo $_tmconfig['ico_dir'];?>edit.gif">批量更新分类Meta</legend>
			  <div style="clear: both; padding-top:15px;" id="conf_id_TM_SHOP_NAME">
			    <label>Meta title 规则：</label>
				<div class="margin-form">
				<input type="text" name="title" value="<?php echo Tools::getRequest('title')?Tools::getRequest('title'):'';?>" size="100">
				<p class="preference_description">可用参数:C_ID,C_NAME,{关键词1|关键词2|关键词3}</p>
				</div>
			    <label>Meta Keywords 规则：</label>
				<div class="margin-form">
				<input type="text" name="keywords" value="<?php echo Tools::getRequest('keywords')?Tools::getRequest('keywords'):'';?>" size="100">
				<p class="preference_description">可用参数:C_ID,C_NAME,{关键词1|关键词2|关键词3}</p>
				</div>
			    <label>Meta Description 规则：</label>
				<div class="margin-form">
				<input type="text" name="description" value="<?php echo Tools::getRequest('description')?Tools::getRequest('description'):'';?>" size="100">
				<p class="preference_description">可用参数:C_ID,C_NAME,{关键词1|关键词2|关键词3}</p>
				</div>
			    <label>URL Rewrite 规则：</label>
				<div class="margin-form">
				<input type="text" name="rewrite" value="<?php echo Tools::getRequest('rewrite')?Tools::getRequest('rewrite'):'';?>" size="100">
				<p class="preference_description">可用参数:C_ID,C_NAME,{关键词1|关键词2|关键词3}</p>
				</div>
				<label>应用到分类：</label>
				<div class="margin-form">
				<?php
				$cate = array();
				if(isset($_POST['categoryBox'])){
					$cate = Tools::getRequest('categoryBox');
				}
				
				$trads = array(
					 'Home' 		=> '根分类', 
					 'selected' 	=> '选择', 
					 'Collapse All' => '关闭', 
					 'Expand All' 	=> '展开',
					 'Check All'	=> '全选',
					 'Uncheck All'	=> '全不选'
				);
				echo Helper::renderAdminCategorieTree($trads,$cate, 'categoryBox', false,'Tree');
			 ?>
			  </div>
			  <div class="margin-form">
			  	<input type="submit" name="SEOCateMetaUpdate" value="更新Meta" id="SEOCateMetaUpdate" class="button" />
			  </div>
		  </fieldset>
	</form>
</div>
