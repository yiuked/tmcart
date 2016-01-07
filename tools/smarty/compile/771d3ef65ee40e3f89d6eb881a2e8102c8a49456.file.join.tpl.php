<?php /* Smarty version Smarty-3.1.12, created on 2016-01-07 15:52:06
         compiled from "D:\wamp\www\red\shoes\themes\shop\join.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18896549a67a9f40155-48991427%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '771d3ef65ee40e3f89d6eb881a2e8102c8a49456' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\themes\\shop\\join.tpl',
      1 => 1452153124,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18896549a67a9f40155-48991427',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_549a67aa1c17c9_84632260',
  'variables' => 
  array (
    'step' => 0,
    'address' => 0,
    'countrys' => 0,
    'country' => 0,
    'id_default_country' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_549a67aa1c17c9_84632260')) {function content_549a67aa1c17c9_84632260($_smarty_tpl) {?><div class="container">
	<h3>新用户</h3>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./block/errors.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php if ($_smarty_tpl->tpl_vars['step']->value==2){?>
<ul id="order_step" class="step">
	<li class="done"><span><i>01</i><strong>Summary</strong></span></li>
	<li class="current"><span><i>02</i><strong>Sign in/Login</strong></span></li>
	<li class="todo"><span><i>03</i><strong>Delivery</strong></span></li>
	<li class="todo"><span><i>04</i><strong>Payment</strong></span></li>
</ul>
<?php }?>
<form id="join-form" action="" method="post" class="form-horizontal">

	<div class="form-group">
	  <label for="email" class="col-sm-2 control-label">邮箱</label>
	  <div class="col-sm-5">
		  <input type="text" class="form-control" name="email" value="<?php if (isset($_POST['email'])){?><?php echo $_POST['email'];?>
<?php }elseif(isset($_smarty_tpl->tpl_vars['address']->value->email)){?><?php echo $_smarty_tpl->tpl_vars['address']->value->email;?>
<?php }?>" placeholder="邮箱地址" >
	  </div>
	</div>
	<div class="form-group">
	  <label for="password" class="col-sm-2 control-label">密码</label>
	  <div class="col-sm-5">
			  <input type="password" class="form-control" name="passwd" value="" >
	  </div>
	</div>
	<div class="form-group">
	  <label for="confirmPasswd" class="col-sm-2 control-label">确认密码</label>
	  <div class="col-sm-5">
		  <input type="password" class="form-control" name="confirmPasswd" value="" >
	  </div>
	</div>


	<h3>默认收货地址</h3>
	<div class="form-group">
		  <label for="name" class="col-sm-2 control-label">收货人</label>
		  <div class="col-sm-5">
			  <input type="text" class="form-control" name="name" value="<?php if (isset($_POST['name'])){?><?php echo $_POST['name'];?>
<?php }elseif(isset($_smarty_tpl->tpl_vars['address']->value->name)){?><?php echo $_smarty_tpl->tpl_vars['address']->value->name;?>
<?php }?>" placeholder="如.张三">
		  </div>
	 </div>
	<div class="form-group">
	  <label for="address" class="col-sm-2 control-label">地址</label>
	  <div class="col-sm-5">
		  <input type="text" class="form-control" name="address" value="<?php if (isset($_POST['address'])){?><?php echo $_POST['address'];?>
<?php }elseif(isset($_smarty_tpl->tpl_vars['address']->value->address)){?><?php echo $_smarty_tpl->tpl_vars['address']->value->address;?>
<?php }?>" placeholder="如.白云区建设路">
	  </div>
	</div>
	<div class="form-group">
	  <label for="address2" class="col-sm-2 control-label">详细地址</label>
	  <div class="col-sm-5">
		  <input type="text" class="form-control" name="address2" value="<?php if (isset($_POST['address2'])){?><?php echo $_POST['address2'];?>
<?php }elseif(isset($_smarty_tpl->tpl_vars['address']->value->address2)){?><?php echo $_smarty_tpl->tpl_vars['address']->value->address2;?>
<?php }?>" placeholder="如.2栋3单元">
	  </div>
	</div>
	<div class="form-group">
	  <label for="city" class="col-sm-2 control-label">城市</label>
	  <div class="col-sm-5">
		  <input type="text" class="form-control" name="city" value="<?php if (isset($_POST['city'])){?><?php echo $_POST['city'];?>
<?php }elseif(isset($_smarty_tpl->tpl_vars['address']->value->city)){?><?php echo $_smarty_tpl->tpl_vars['address']->value->city;?>
<?php }?>" placeholder="如.北京">
	  </div>
	</div>
	<div class="form-group">
	  <label for="postcode" class="col-sm-2 control-label">邮编</label>
	  <div class="col-sm-5">
		  <input type="text" class="form-control" name="postcode" value="<?php if (isset($_POST['postcode'])){?><?php echo $_POST['postcode'];?>
<?php }elseif(isset($_smarty_tpl->tpl_vars['address']->value->postcode)){?><?php echo $_smarty_tpl->tpl_vars['address']->value->postcode;?>
<?php }?>" placeholder="000000">
	  </div>
	</div>
	<div class="form-group" style="display: none;">
	  <label for="postcode" class="col-sm-2 control-label">省份</label>
	  <div class="col-sm-5">
		  <select id="id_state" name="id_state" class="form-control">
		  </select>
	  </div>
	</div>
	<div class="form-group">
	  <label for="postcode" class="col-sm-2 control-label">国家</label>
	  <div class="col-sm-5">
		  <select id="id_country" name="id_country" class="form-control">
			  <option value="">--选择国家--</option>
			  <?php  $_smarty_tpl->tpl_vars['country'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['country']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['countrys']->value['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['country']->key => $_smarty_tpl->tpl_vars['country']->value){
$_smarty_tpl->tpl_vars['country']->_loop = true;
?>
				  <option value="<?php echo $_smarty_tpl->tpl_vars['country']->value['id_country'];?>
" <?php if (isset($_POST['id_country'])){?><?php if ($_POST['id_country']==$_smarty_tpl->tpl_vars['country']->value['id_country']){?>selected="selected"<?php }?><?php }else{ ?><?php if ($_smarty_tpl->tpl_vars['id_default_country']->value==$_smarty_tpl->tpl_vars['country']->value['id_country']){?>selected="selected"<?php }?><?php }?>><?php echo $_smarty_tpl->tpl_vars['country']->value['name'];?>
</option>
			  <?php } ?>
		  </select>
	  </div>
	</div>
	<div class="form-group">
	  <label for="phone" class="col-sm-2 control-label">手机</label>
	  <div class="col-sm-5">
		  <input type="text" class="form-control" name="phone" value="<?php if (isset($_POST['phone'])){?><?php echo $_POST['phone'];?>
<?php }elseif(isset($_smarty_tpl->tpl_vars['address']->value->phone)){?><?php echo $_smarty_tpl->tpl_vars['address']->value->phone;?>
<?php }?>" placeholder="+86.">
	  </div>
	</div>
	<div class="form-group">
		<div class="col-sm-5 col-sm-offset-2">
			<input type="submit" name="CreateUser" value="注册" class="btn btn-success" />
		</div>
	</div>
</form>
</div>
<script type="text/javascript">
var ajaxLink = "<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('AjaxView');?>
";
<?php if (isset($_POST['id_state'])){?>
var secat_id = <?php echo $_POST['id_state'];?>
;
<?php }else{ ?>
var secat_id = 0;
<?php }?>

	$(document).ready(function(){
		$('#join-form').bootstrapValidator({
			feedbackIcons: {
				valid: 'glyphicon glyphicon-ok',
				invalid: 'glyphicon glyphicon-remove',
				validating: 'glyphicon glyphicon-refresh'
			},
			fields: {
				email: {
					validators: {
						notEmpty: {
							message: '邮箱地址不能为空'
						},
						remote: {
						 url: ajax_dir,
						 name: 'existsEmail',
						 message: '这个邮箱地址已被注册'
						 },
						emailAddress: {
							message: '这不是一个正确的邮箱地址'
						}
					}
				},
				passwd: {
					validators: {
						notEmpty: {
							message: '密码不能为空'
						},
						stringLength: {
							min: 6,
							max: 30,
							message: '密码必须是6-30位由字母和数字组成'
						}
					}
				},
				confirmPasswd: {
					validators: {
						notEmpty: {
							message: '确认密码不能为空'
						},
						identical: {
							field: 'passwd',
							message: '确认密码与原密码不一致'
						}
					}
				},
				name: {
					validators: {
						notEmpty: {
							message: '收件人不能为空'
						},
					}
				},
				address: {
					validators: {
						notEmpty: {
							message: '地址不能为空'
						},
					}
				},
				city: {
					validators: {
						notEmpty: {
							message: '城市不能为空'
						},
					}
				},
				postcode: {
					validators: {
						notEmpty: {
							message: '邮编不能为空'
						},
					}
				},
				'id_country': {
					validators: {
						notEmpty: {
							message: '请选择收货人所在国家'
						},
					}
				},
				phone: {
					validators: {
						notEmpty: {
							message: '手机号码不能为空'
						},
						regexp: {
							regexp: /(^(\d{3,4}-)?\d{7,8})$|(13[0-9]{9})/,
							message: '这不是一个有效的手机号码'
						},
					}
				},
			}
		})


			ajaxStates ();
			$('#id_country').change(function() {
				ajaxStates ();
				});
			function ajaxStates ()
			{
				$.ajax({
					url: ajaxLink,
					cache: false,
					data: "ajaxStates=1&id_country="+$('#id_country').val()+"&id_state="+$('#id_state').val(),
					success: function(html)
						{
							if (html == 'false')
							{
								$("#contains_states").fadeOut();
								$('#id_state option[value=0]').attr("selected", "selected");
							}
							else
							{
								$("#id_state").html(html);
								$("#contains_states").fadeIn();
								$('#id_state option[value='+secat_id+']').attr("selected", "selected");
							}
						}
					}); 	
			  }; 
		}); 

</script><?php }} ?>