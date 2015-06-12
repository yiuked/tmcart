<?php
if(isset($_POST['sveUser']) && Tools::getRequest('sveUser')=='add')
{
	$user = new User();
	if(Tools::getRequest('passwd')!=Tools::getRequest('passwd_conf')){
		$user->_errors[] = '两次输入的密码不一样！';
	}elseif(User::userExists(Tools::getRequest('email'))){
		$user->_errors[] = '邮箱地址已存在！';
	}else{
		$user->copyFromPost();
		$user->add();
	}
	
	if(is_array($user->_errors) AND count($user->_errors)>0){
		$errors = $user->_errors;
	}else{
		$_GET['id']	= $user->id;
		echo '<div class="conf">创建用户成功</div>';
	}
}

if(isset($_GET['id'])){
	$id  = (int)$_GET['id'];
	$obj = new User($id);
}

if(isset($_POST['sveUser']) && Tools::getRequest('sveUser')=='edit')
{
	  if(Tools::getRequest('email')!=$obj->email && User::userExists(Tools::getRequest('email'))){
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
		<span class="breadcrumb item-1 ">用户<img src="<?php echo $_tmconfig['tm_img_dir'];?>admin/separator_breadcrum.png" style="margin-right:5px" alt="&gt;"> </span>
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
		$("#user_form").submit();
	})
</script>
<div class="mianForm">
		  <fieldset>
  			<legend> <img alt="CMS 分类" src="<?php echo $_tmconfig['ico_dir'];?>category.png">用户</legend>
			<form enctype="multipart/form-data" method="post" action="index.php?rule=user_edit<?php echo isset($id)?'&id='.$id:''?>" class="defaultForm" id="user_form" name="example">
			<label>姓: </label>
			<div class="margin-form">
				<div style="display:block; float: left;">
					<input type="text" value="<?php echo isset($obj)?$obj->first_name:Tools::getRequest('first_name');?>"  name="first_name">
					<span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span>
				</div>
				<sup>*</sup>
				<div class="clear"></div>
			</div>
			<label>名: </label>
			<div class="margin-form">
				<div style="display:block; float: left;">
					<input type="text" value="<?php echo isset($obj)?$obj->last_name:Tools::getRequest('last_name');?>"  name="last_name">
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
					<input type="text" value="<?php echo isset($obj)?$obj->email:Tools::getRequest('email');?>"  name="email">
					<span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span>
				</div>
				<div class="clear"></div>
			</div>
			<label>密码: </label>
			<div class="margin-form">
				<div style="display:block; float: left;">
					<input type="password" value=""  name="passwd">
					<span name="help_box" class="hint" style="display: none;">不能包含以下字符: &lt;&gt;;=#{}<span class="hint-pointer">&nbsp;</span></span>
					<p class="preference_description">用户密码要求5位数以上</p>
				</div>
				
				<div class="clear"></div>
			</div>
			<input type="hidden" value="<?php echo isset($id)?'edit':'add'?>"  name="sveUser">
			</form>
			<?php
			if(isset($obj)){
			$carts  = $obj->getCarts();
			$orders = $obj->getOrders();
			$contacts = $obj->getContacts();
			?>
			<h3>购物车(<?php echo count($carts);?>)</h3>
			<table class="tableList table" cellpadding="0" cellspacing="0" width="60%">
				<tr>
					<th>id_cart</th>
					<th>添加时间</th>
				</tr>
				<?php 
				if($carts){
				foreach($carts as $cart){
				?>
				<tr>
					<td class="pointer" onclick="document.location = 'index.php?rule=cart_edit&id=<?php echo $cart['id_cart'];?>'"><?php echo $cart['id_cart'];?></td>
					<td class="pointer" onclick="document.location = 'index.php?rule=cart_edit&id=<?php echo $cart['id_cart'];?>'"><?php echo $cart['add_date'];?></td>
				</tr>
				<?php
				}
				}
				?>
			</table>
			<h3>定单(<?php echo count($orders);?>)</h3>
			<table class="tableList table" cellpadding="0" cellspacing="0" width="60%">
				<tr>
					<th>id_order</th>
					<th>id_cart</th>
					<th>添加时间</th>
					<th>支付状态</th>
				</tr>
				<?php 
				if($orders){
				foreach($orders as $order){
				?>
				<tr>
					<td class="pointer" onclick="document.location = 'index.php?rule=order_edit&id=<?php echo $order->id;?>'"><?php echo $order->id;?></td>
					<td class="pointer" onclick="document.location = 'index.php?rule=order_edit&id=<?php echo $order->id;?>'"><?php echo $order->id_cart;?></td>
					<td class="pointer" onclick="document.location = 'index.php?rule=order_edit&id=<?php echo $order->id;?>'"><?php echo $order->add_date;?></td>
					<td class="pointer" onclick="document.location = 'index.php?rule=order_edit&id=<?php echo $order->id;?>'">
					<span class="color_field" style="background-color:<?php echo $order->order_status->color;?>;color:white"><?php echo $order->order_status->name;?></span>
					</td>
				</tr>
				<?php
				}
				}
				?>
			</table>
			<h3>留言(<?php echo count($contacts);?>)</h3>
			<table class="tableList table" cellpadding="0" cellspacing="0" width="60%">
				<tr>
					<th>id_contact</th>
					<th>添加时间</th>
				</tr>
				<?php 
				if($contacts){
				foreach($contacts as $contact){
				?>
				<tr>
					<td class="pointer" onclick="document.location = 'index.php?rule=contact_edit&id=<?php echo $contact['id_contact'];?>'"><?php echo $contact['id_contact'];?></td>
					<td class="pointer" onclick="document.location = 'index.php?rule=contact_edit&id=<?php echo $contact['id_contact'];?>'"><?php echo $contact['add_date'];?></td>
				</tr>
				<?php
				}
				}
				?>
			</table>
			<?php
			}
			?>
		  </fieldset>
	
</div>
