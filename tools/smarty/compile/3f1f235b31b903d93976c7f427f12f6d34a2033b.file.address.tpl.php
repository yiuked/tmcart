<?php /* Smarty version Smarty-3.1.12, created on 2015-05-24 13:40:56
         compiled from "D:\wamp\www\red\shoes\themes\shop\address.tpl" */ ?>
<?php /*%%SmartyHeaderCode:24072549d22fbdac715-83683463%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3f1f235b31b903d93976c7f427f12f6d34a2033b' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\themes\\shop\\address.tpl',
      1 => 1419833731,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '24072549d22fbdac715-83683463',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_549d22fc0bb305_00772505',
  'variables' => 
  array (
    'address' => 0,
    'countrys' => 0,
    'country' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_549d22fc0bb305_00772505')) {function content_549d22fc0bb305_00772505($_smarty_tpl) {?><div id="main_columns" class="custom">
<div class="back-arrow"><i class="icon-arrow-left"></i><strong><a href="javascript:history.back();">Back</a></strong></div>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./block/errors.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="box-style">
<form action="" method="post" name="eidtAddress" id="editAddress" class="bd">
<div style="padding:15px 0px 15px 0px;">
        <h2>Your Shipping Address</h2>
  		<div style="clear:both;"></div>
		<p style="padding:5px 0px 0px 25px;margin:0px">  
	  <span class="signatureRequired">PLEASE NOTE: SIGNATURE REQUIRED</span>. The accurate delivery address. 
	 </p>
</div>
  <div class="ck_address">
    <div class="formField">
	   <div class="labelDiv"><span class="requiredRed">* </span>First Name: </div>       
	   <div class="inputDiv"> <input type="text" class="" id="first_name" value="<?php if (isset($_POST['first_name'])){?><?php echo $_POST['first_name'];?>
<?php }elseif(isset($_smarty_tpl->tpl_vars['address']->value->first_name)){?><?php echo $_smarty_tpl->tpl_vars['address']->value->first_name;?>
<?php }?>" maxlength="40" size="30" name="first_name"></div>         
    </div>
	<div class="formField">
		<div class="labelDiv"><span class="requiredRed">* </span>Last Name:</div>  
		<div class="inputDiv"><input type="text" id="last_name" value="<?php if (isset($_POST['last_name'])){?><?php echo $_POST['last_name'];?>
<?php }elseif(isset($_smarty_tpl->tpl_vars['address']->value->last_name)){?><?php echo $_smarty_tpl->tpl_vars['address']->value->last_name;?>
<?php }?>" maxlength="40" size="30" name="last_name"></div>
	</div>
	<div class="formField">
		<div class="labelDiv"><span class="requiredRed">* </span>Address:</div>  
		<div class="inputDiv"><input type="text" id="address" value="<?php if (isset($_POST['address'])){?><?php echo $_POST['address'];?>
<?php }elseif(isset($_smarty_tpl->tpl_vars['address']->value->address)){?><?php echo $_smarty_tpl->tpl_vars['address']->value->address;?>
<?php }?>" maxlength="100" size="60" name="address"></div>
	</div>
	<div class="formField">
		<div class="labelDiv">Address 2:</div>  
		<div class="inputDiv"><input type="text" id="address2" value="<?php if (isset($_POST['address2'])){?><?php echo $_POST['address2'];?>
<?php }elseif(isset($_smarty_tpl->tpl_vars['address']->value->address2)){?><?php echo $_smarty_tpl->tpl_vars['address']->value->address2;?>
<?php }?>" maxlength="100" size="60" name="address2">	</div>
	</div>
	<div class="formField">
		<div class="labelDiv"><span class="requiredRed">* </span>City:</div>  
		<div class="inputDiv"><input type="text" id="city" value="<?php if (isset($_POST['city'])){?><?php echo $_POST['city'];?>
<?php }elseif(isset($_smarty_tpl->tpl_vars['address']->value->city)){?><?php echo $_smarty_tpl->tpl_vars['address']->value->city;?>
<?php }?>" maxlength="40" size="40" name="city"></div>
	</div>  
	 <div class="formField">
	 	<div class="labelDiv"><span class="requiredRed">* </span>Post Code:</div>
		<div class="inputDiv">
		<input type="text" value="<?php if (isset($_POST['postcode'])){?><?php echo $_POST['postcode'];?>
<?php }elseif(isset($_smarty_tpl->tpl_vars['address']->value->postcode)){?><?php echo $_smarty_tpl->tpl_vars['address']->value->postcode;?>
<?php }?>" name="postcode" id="postcode" class="text" >
		</div>
	  </div>
	<div class="formField" id="contains_states" style="display: none;">
		<div class="labelDiv"><span class="requiredRed">* </span>State:</div>
		<div class="inputDiv">
		<select id="id_state" name="id_state"></select>
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
" <?php if (isset($_POST['id_country'])){?><?php if ($_POST['id_country']==$_smarty_tpl->tpl_vars['country']->value['id_country']){?>selected="selected"<?php }?><?php }else{ ?><?php if (isset($_smarty_tpl->tpl_vars['address']->value)&&$_smarty_tpl->tpl_vars['address']->value->country->id==$_smarty_tpl->tpl_vars['country']->value['id_country']){?>selected="selected"<?php }?><?php }?>><?php echo $_smarty_tpl->tpl_vars['country']->value['name'];?>
</option>
		<?php } ?>
	   </select>
	   </div>
	  </div>
	  <div class="formField">
	  	<div class="labelDiv"><span class="requiredRed">* </span>Phone:</div>
		<div class="inputDiv">
		<input type="text" value="<?php if (isset($_POST['phone'])){?><?php echo $_POST['phone'];?>
<?php }elseif(isset($_smarty_tpl->tpl_vars['address']->value->phone)){?><?php echo $_smarty_tpl->tpl_vars['address']->value->phone;?>
<?php }?>" name="phone" id="phone" class="text" >
		</div>
	  </div>
	</div>
  <p class="submit">
  	<input type="hidden" value="<?php if (isset($_smarty_tpl->tpl_vars['address']->value->id)){?><?php echo $_smarty_tpl->tpl_vars['address']->value->id;?>
<?php }?>" />
	<input type="submit" class="form-send button big east pink collapse" value="Submit" name="saveAddress">
  </p>
</form>
</div>
</div>
<script type="text/javascript">
var ajaxLink = "<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('AjaxView');?>
";
<?php if (isset($_smarty_tpl->tpl_vars['address']->value)&&$_smarty_tpl->tpl_vars['address']->value->country->need_state){?>
var secat_id = <?php echo $_smarty_tpl->tpl_vars['address']->value->state->id;?>
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