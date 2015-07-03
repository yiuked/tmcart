<?php /* Smarty version Smarty-3.1.12, created on 2015-06-27 10:33:47
         compiled from "D:\wamp\www\red\shoes\themes\shop\join.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18896549a67a9f40155-48991427%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '771d3ef65ee40e3f89d6eb881a2e8102c8a49456' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\themes\\shop\\join.tpl',
      1 => 1432093754,
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
    'countrys' => 0,
    'country' => 0,
    'id_default_country' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_549a67aa1c17c9_84632260')) {function content_549a67aa1c17c9_84632260($_smarty_tpl) {?><div id="main_columns">
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./block/errors.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php if ($_smarty_tpl->tpl_vars['step']->value==2){?>
<ul id="order_step" class="step">
	<li class="done"><span><i>01</i><strong>Summary</strong></span></li>
	<li class="current"><span><i>02</i><strong>Sign in/Login</strong></span></li>
	<li class="todo"><span><i>03</i><strong>Delivery</strong></span></li>
	<li class="todo"><span><i>04</i><strong>Payment</strong></span></li>
</ul>
<?php }?>
<div class="box-style">
	<form action="" method="post" class="bd">
	  <div class="row">
		<h2>Create a new account</h2>
		<h3>Account settings</h3>
	  </div>
	  <div class="ck_customer">
		<div class="formField">
		  <div class="labelDiv"><span class="requiredRed">* </span>Email:</div>
		  <div class="inputDiv"><input type="text" value="<?php if (isset($_POST['email'])){?><?php echo $_POST['email'];?>
<?php }?>" name="email" id="email" class="text" size="50"></div>
		  <div style="text-align:left;font-size:10px;color:#949494; padding-left:100px;" class="input">Your email address will be your username for login.&nbsp;&nbsp;</div>
		</div>
		<div class="formField">
		  <div class="labelDiv"><span class="requiredRed">* </span>Password:</div>
		  <div class="inputDiv"><input type="password" value="<?php if (isset($_POST['country'])){?><?php echo $_POST['country'];?>
<?php }?>" name="passwd" id="passwd" class="text" ></div>
		  <div style="font-size:9px;color:#949494;padding-left:100px;" class="input">Passwords must be between 5-10 characters.</div>
		</div>
	  </div>
	
	  <div class="ck_address">
		<h3>Your Shipping Address</h3> 
		<div class="formField">
		  <div class="labelDiv"><span class="requiredRed">* </span>First Name: </div>
		  <div class="inputDiv">
			<input type="text" class="" id="first_name" value="<?php if (isset($_POST['first_name'])){?><?php echo $_POST['first_name'];?>
<?php }?>" maxlength="40" size="30" name="first_name">
		  </div>
		</div>
		<div class="formField">
		  <div class="labelDiv"><span class="requiredRed">* </span>Last Name:</div>
		  <div class="inputDiv">
			<input type="text" id="last_name" value="<?php if (isset($_POST['last_name'])){?><?php echo $_POST['last_name'];?>
<?php }?>" maxlength="40" size="30" name="last_name">
		  </div>
		</div>
		<div class="formField">
		  <div class="labelDiv"><span class="requiredRed">* </span>Address:</div>
		  <div class="inputDiv">
			<input type="text" id="address" value="<?php if (isset($_POST['address'])){?><?php echo $_POST['address'];?>
<?php }?>" maxlength="100" size="60" name="address">
		  </div>
		</div>
		<div class="formField">
		  <div class="labelDiv">Address 2:</div>
		  <div class="inputDiv">
			<input type="text" id="address2" value="<?php if (isset($_POST['address'])){?><?php echo $_POST['address'];?>
<?php }?>" maxlength="100" size="60" name="address2">
		  </div>
		</div>
		<div class="formField">
		  <div class="labelDiv"><span class="requiredRed">* </span>City:</div>
		  <div class="inputDiv">
			<input type="text" id="city" value="<?php if (isset($_POST['city'])){?><?php echo $_POST['city'];?>
<?php }?>" maxlength="40" size="40" name="city">
		  </div>
		</div>
		<div class="formField">
		  <div class="labelDiv"><span class="requiredRed">* </span>Post Code:</div>
		  <div class="inputDiv">
			<input type="text" value="<?php if (isset($_POST['postcode'])){?><?php echo $_POST['postcode'];?>
<?php }?>" name="postcode" id="postcode" class="text" >
		  </div>
		</div>
		<div class="formField" id="contains_states" style="display: none;">
		  <div class="labelDiv"><span class="requiredRed">* </span>State:</div>
		  <div class="inputDiv">
			<select id="id_state" name="id_state">
			</select>
		  </div>
		</div>
		<div class="formField left">
		  <div class="labelDiv"><span class="requiredRed">* </span>Country:</div>
		  <div class="inputDiv">
			  <select id="id_country" name="id_country" style="margin-right:15px">
				<option value="NULL">--choose--</option>
				<?php  $_smarty_tpl->tpl_vars['country'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['country']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['countrys']->value['entitys']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
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
		<div class="formField">
		  <div class="labelDiv"><span class="requiredRed">* </span>Phone:</div>
		  <div class="inputDiv">
			<input type="text" value="<?php if (isset($_POST['phone'])){?><?php echo $_POST['phone'];?>
<?php }?>" name="phone" id="phone" class="text" >
		  </div>
		</div>
	  </div>
	  <p class="submit">
		<input type="submit" name="CreateUser" value="Submit" class="form-send button big east pink collapse" />
	  </p>
	</form>
 </div>
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