<?php
require_once(dirname(__FILE__).'/../errors.php');
?>

<div class="path_bar">
  <div class="path_title">
    <h3> <span style="font-weight: normal;" id="current_obj"> <span class="breadcrumb item-1 ">路由设置<img src="<?php echo $_tmconfig['tm_img_dir'];?>admin/separator_breadcrum.png" style="margin-right:5px" alt="&gt;"> </span> <span class="breadcrumb item-2 ">设置</span> </span> </h3>
    <div class="cc_button">
      <ul>
        <li> <a title="Back to list" href="index.php?rule=rule" class="toolbar_btn" id="desc-product-back"> <span class="process-icon-back "></span>
          <div>返回列表</div>
          </a> </li>
      </ul>
    </div>
  </div>
</div>
<div class="mianForm">
  <form enctype="multipart/form-data" method="post" action="index.php?rule=rule_check" class="defaultForm admincmscontent" id="rule_id_form" name="example">
    <fieldset>
    <legend> <img alt="CMS 分类" src="<?php echo $_tmconfig['ico_dir'];?>category.png">设置</legend>
		<label>启用ID： </label>
		<div class="margin-form">
		  <input type="radio" value="1" id="active_on" name="active">
		  <label for="active_on" class="t"><img title="Enabled" alt="Enabled" src="<?php echo $_tmconfig['ico_dir'];?>enabled.gif"> </label>
		  <input type="radio" value="0" id="active_off" name="active" <?php echo isset($obj)?($obj->active==0?'checked="checked"':''):'';?>>
		  <label for="active_off" class="t"><img title="Disabled" alt="Disabled" src="<?php echo $_tmconfig['ico_dir'];?>disabled.gif"> </label>
		  <p class="preference_description">由于所有页面均在根目录下，需要保证URL惟一，如果网站产品有URL有重复时，选择此项可提高地址惟一性.</p>
		</div>
		<label>应用到： </label>
		<div class="margin-form">
		  <input type="checkbox" value="Product" name="aby_to">
		  <label for="active_on" class="t">产品页</label>
		  <input type="checkbox" value="Category" name="aby_to">
		  <label for="active_on" class="t">产品分类页</label>
		  <input type="checkbox" value="Tag" name="aby_to">
		  <label for="active_on" class="t">产品标签页</label><br/>
		  <input type="checkbox" value="CMS" name="aby_to">
		  <label for="active_on" class="t">CMS页</label>
		  <input type="checkbox" value="CMSCategory" name="aby_to">
		  <label for="active_on" class="t">CMS分类</label>
		  <input type="checkbox" value="CMSTag" name="aby_to">
		  <label for="active_on" class="t">CMS标签页</label>
		</div>
		<div class="margin-form"><input type="submit" class="button" name="ruleCheckID" value="生成"></div>
    </fieldset>
  </form>
</div>
