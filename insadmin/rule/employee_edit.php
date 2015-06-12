<?php
if(isset($_POST['sveEmployee']) && Tools::getRequest('sveEmployee')=='add')
{
	$employee = new Employee();
	if(Tools::getRequest('passwd')!=Tools::getRequest('passwd_conf')){
		$employee->_errors[] = '两次输入的密码不一样！';
	}elseif(Employee::employeeExists(Tools::getRequest('email'))){
		$employee->_errors[] = '邮箱地址已存在！';
	}else{
		$employee->copyFromPost();
		$employee->add();
	}
	
	if(is_array($employee->_errors) AND count($employee->_errors)>0){
		$errors = $employee->_errors;
	}else{
		$_GET['id']	= $employee->id;
		echo '<div class="conf">创建管理员成功</div>';
	}
}

if(isset($_GET['id'])){
	$id  = (int)$_GET['id'];
	$obj = new Employee($id);
}

if(isset($_POST['sveEmployee']) && Tools::getRequest('sveEmployee')=='edit')
{

	  if(Tools::getRequest('passwd')!=Tools::getRequest('passwd_conf')){
			$obj->_errors[] = '两次输入的密码不一样！';
	  }elseif(Tools::getRequest('email')!=$obj->email && Employee::employeeExists(Tools::getRequest('email'))){
			$obj->_errors[] = '邮箱地址已存在！';
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
require_once(dirname(__FILE__).'/../errors.php');
?>
<div class="path_bar">
  <div class="path_title">
    <h3> 
		<span style="font-weight: normal;" id="current_obj">
		<span class="breadcrumb item-1 ">管理员<img src="<?php echo $_tmconfig['tm_img_dir'];?>admin/separator_breadcrum.png" style="margin-right:5px" alt="&gt;"> </span>
		<span class="breadcrumb item-2 ">编辑 </span> </span> 
	</h3>
    <div class="cc_button">
      <ul>
        <li> <a title="Save" href="#" class="toolbar_btn" id="emploay-save"> <span class="process-icon-save "></span>
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
	$("#emploay-save").click(function(){
		$("#employee_form").submit();
	})
</script>
<div class="mianForm">
	<form enctype="multipart/form-data" method="post" action="index.php?rule=employee_edit<?php echo isset($id)?'&id='.$id:''?>" class="defaultForm admincmscontent" id="employee_form" name="example">
		  <fieldset>
  			<legend> <img alt="CMS 分类" src="<?php echo $_tmconfig['ico_dir'];?>category.png">管理员</legend>
			<label>昵称: </label>
			<div class="margin-form">
				<div style="display:block; float: left;">
					<input type="text" class="text_input" value="<?php echo isset($obj)?$obj->name:Tools::getRequest('name');?>"  name="name">
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
			<label>邮箱: </label>
			<div class="margin-form">
				<div style="display:block; float: left;">
					<input type="text" class="text_input" value="<?php echo isset($obj)?$obj->email:Tools::getRequest('email');?>"  name="email">
					<span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span>
				</div>
				<div class="clear"></div>
			</div>
			<label>密码: </label>
			<div class="margin-form">
				<div style="display:block; float: left;">
					<input type="password" class="text_input" value=""  name="passwd">
					<span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span>
				</div>
				<div class="clear"></div>
			</div>
			<label>确认密码: </label>
			<div class="margin-form">
				<div style="display:block; float: left;">
					<input type="password" class="text_input" value=""  name="passwd_conf">
					<span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span>
				</div>
				<div class="clear"></div>
			</div>
			<input type="hidden" value="<?php echo isset($id)?'edit':'add'?>"  name="sveEmployee">
		  </fieldset>
	</form>
</div>
