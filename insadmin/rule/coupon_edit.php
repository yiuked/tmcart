<?php
if(isset($_POST['sveCoupon']) && Tools::getRequest('sveCoupon')=='add')
{
	$coupon = new Coupon();
	$coupon->copyFromPost();
	$coupon->add();
	
	if(is_array($coupon->_errors) AND count($coupon->_errors)>0){
		$errors = $coupon->_errors;
	}else{
		$_GET['id']	= $coupon->id;
		echo '<div class="conf">创建对象成功</div>';
	}
}

if(isset($_GET['id'])){
	$id  = (int)$_GET['id'];
	$obj = new Coupon($id);
}

if(isset($_POST['sveCoupon']) && Tools::getRequest('sveCoupon')=='edit')
{
	if(Validate::isLoadedObject($obj)){
		$obj->copyFromPost();
		$obj->update();
	}
	
	if(is_array($obj->_errors) AND count($obj->_errors)>0){
		$errors = $obj->_errors;
	}else{
		echo '<div class="conf">更新对象成功</div>';
	}
}
require_once(_TM_ADMIN_DIR_.'/errors.php');
?>

<div class="path_bar">
  <div class="path_title">
    <h3> <span style="font-weight: normal;" id="current_obj"> <span class="breadcrumb item-1 ">编辑促销码</span> </h3>
    <div class="cc_button">
      <ul>
        <li> <a title="Save" href="#" class="toolbar_btn" id="desc-base-save"> <span class="process-icon-save "></span>
          <div>保存</div>
          </a> </li>
        <li> <a title="Back to list" href="javascript:history.back();" class="toolbar_btn" id="desc-base-back"> <span class="process-icon-back "></span>
          <div>返回列表</div>
          </a> </li>
      </ul>
    </div>
  </div>
</div>
<script language="javascript">
	$("#desc-base-save").click(function(){
		$("#coupon_form").submit();
	})
</script>
<div class="mianForm">
  <form enctype="multipart/form-data" method="post" action="index.php?rule=coupon_edit<?php echo isset($id)?'&id='.$id:''?>" class="defaultForm admincmscontent" id="coupon_form" name="example">
    <fieldset>
    <legend> <img alt="促销码" src="<?php echo $_tmconfig['ico_dir'];?>category.png">促销码</legend>
    <label>用户ID:</label>
    <div class="margin-form">
      <input type="text" name="id_user" value="<?php echo (int)(isset($obj)?$obj->id_user:Tools::getRequest('id_user'));?>">
	  <p class="preference_description">如果为0则表示任何用户都可使用该促销码</p>
	  <div class="clear"></div>
    </div>
    <label>代码码:</label>
    <div class="margin-form">
      <input type="text" name="code" value="<?php echo isset($obj)?$obj->code:Tools::getRequest('code');?>">
	  <div class="clear"></div>
    </div>
    <label>优惠幅度:</label>
    <div class="margin-form">
      <input type="text" name="off" value="<?php echo (int)(isset($obj)?$obj->off:Tools::getRequest('off'));?>" size="10">
	   <p class="preference_description">按百分比优惠，0-100间的整数，表示优惠x%,如果为0则以优惠金额为参照</p>
	  <div class="clear"></div>
    </div>
    <label>优惠金额:</label>
    <div class="margin-form">
	  <input type="text" name="amount" value="<?php echo isset($obj)?$obj->amount:Tools::getRequest('amount');?>" size="10">
	   <p class="preference_description">按指定金额进行优惠，如果为0则使用优惠幅度.</p>
	  <div class="clear"></div>
    </div>
    <label>使用次数:</label>
    <div class="margin-form">
	  <input type="text" name="use" value="<?php echo (int)(isset($obj)?$obj->use:Tools::getRequest('use'));?>" size="10">
	    <p class="preference_description">如果为0则表不限制优惠码的使用次数.</p>
	  <div class="clear"></div>
    </div>
    <label>产品金额超过:</label>
    <div class="margin-form">
	  <input type="text" name="total_over" value="<?php echo isset($obj)?$obj->total_over:Tools::getRequest('total_over');?>" size="10">
	   <p class="preference_description">促销码使用条件，如果为0，则表示金额无条件限制.</p>
	  <div class="clear"></div>
    </div>
    <label>产品数量超过:</label>
    <div class="margin-form">
	  <input type="text" name="quantity_over" value="<?php echo (int)(isset($obj)?$obj->quantity_over:Tools::getRequest('quantity_over'));?>" size="10">
	    <p class="preference_description">促销码使用条件，如果为0，则表示数量无条件限制.</p>
	  <div class="clear"></div>
    </div>
	<label>状态: </label>
	<div class="margin-form">
		<input type="radio" checked="checked" value="1" id="active_on" name="active">
		<label for="active_on" class="t">
			<img title="Enabled" alt="Enabled" src="<?php echo $_tmconfig['tm_img_dir'];?>icon/enabled.gif">
		</label>
		<input type="radio" value="0" id="active_off" name="active">
		<label for="active_off" class="t">
			<img title="Disabled" alt="Disabled" src="<?php echo $_tmconfig['tm_img_dir'];?>icon/disabled.gif">
		</label>
	</div>
    <input type="hidden" value="<?php echo isset($id)?'edit':'add'?>"  name="sveCoupon">
    </fieldset>
  </form>
</div>
