<?php /* Smarty version Smarty-3.1.12, created on 2015-12-22 17:12:40
         compiled from "D:\wamp\www\red\shoes\themes\shop\address.tpl" */ ?>
<?php /*%%SmartyHeaderCode:24072549d22fbdac715-83683463%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3f1f235b31b903d93976c7f427f12f6d34a2033b' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\themes\\shop\\address.tpl',
      1 => 1450775558,
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
    'link' => 0,
    'address' => 0,
    'countrys' => 0,
    'country' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_549d22fc0bb305_00772505')) {function content_549d22fc0bb305_00772505($_smarty_tpl) {?><div id="main_columns" class="custom">
<div class="back-arrow"><i class="icon-arrow-left"></i><strong><a href="javascript:history.back();">Back</a></strong></div>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./block/errors.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="box-style">
	<h2>收货地址</h2>
	<form method="post" action="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('AddresssView');?>
" class="form-horizontal">
		<div class="form-group">
			<label for="name" class="col-sm-2 control-label">收货人</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" name="name" value="<?php if (isset($_POST['name'])){?><?php echo $_POST['name'];?>
<?php }elseif(isset($_smarty_tpl->tpl_vars['address']->value->name)){?><?php echo $_smarty_tpl->tpl_vars['address']->value->name;?>
<?php }?>" placeholder="收货人">
			</div>
		</div>
		<div class="form-group">
			<label for="name" class="col-sm-2 control-label">地址</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" name="address" value="<?php if (isset($_POST['address'])){?><?php echo $_POST['address'];?>
<?php }elseif(isset($_smarty_tpl->tpl_vars['address']->value->address)){?><?php echo $_smarty_tpl->tpl_vars['address']->value->address;?>
<?php }?>" placeholder="地址">
			</div>
		</div>
		<div class="form-group">
			<label for="name" class="col-sm-2 control-label">详细地址</label>
			<div class="col-sm-8">
				<input type="text" class="form-control" name="address2" value="<?php if (isset($_POST['address2'])){?><?php echo $_POST['address2'];?>
<?php }elseif(isset($_smarty_tpl->tpl_vars['address']->value->address2)){?><?php echo $_smarty_tpl->tpl_vars['address']->value->address2;?>
<?php }?>" placeholder="详细地址">
			</div>
		</div>
		<div class="form-group">
			<label for="name" class="col-sm-2 control-label">城市</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" name="city" value="<?php if (isset($_POST['city'])){?><?php echo $_POST['city'];?>
<?php }elseif(isset($_smarty_tpl->tpl_vars['address']->value->city)){?><?php echo $_smarty_tpl->tpl_vars['address']->value->city;?>
<?php }?>" placeholder="城市">
			</div>
		</div>
		<div class="form-group">
			<label for="name" class="col-sm-2 control-label">邮编</label>
			<div class="col-sm-2">
				<input type="text" class="form-control" name="postcode" value="<?php if (isset($_POST['postcode'])){?><?php echo $_POST['postcode'];?>
<?php }elseif(isset($_smarty_tpl->tpl_vars['address']->value->postcode)){?><?php echo $_smarty_tpl->tpl_vars['address']->value->postcode;?>
<?php }?>" placeholder="邮编">
			</div>
		</div>
		<div class="form-group">
			<label for="name" class="col-sm-2 control-label">联系电话</label>
			<div class="col-sm-4">
				<input type="text" class="form-control" name="phone" value="<?php if (isset($_POST['phone'])){?><?php echo $_POST['phone'];?>
<?php }elseif(isset($_smarty_tpl->tpl_vars['address']->value->phone)){?><?php echo $_smarty_tpl->tpl_vars['address']->value->phone;?>
<?php }?>" placeholder="联系电话">
			</div>
		</div>
		<div class="form-group" id="contains_states" style="display: none;">
			<label for="name" class="col-sm-2 control-label">省份</label>
			<div class="col-sm-4">
				<select id="id_state" name="id_state"></select>
			</div>
		</div>
		<div class="form-group">
			<label for="name" class="col-sm-2 control-label">国家</label>
			<div class="col-sm-4">
				<select id="id_country" name="id_country" style="margin-right:15px">
					<option value="NULL">--choose--</option>
					<?php  $_smarty_tpl->tpl_vars['country'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['country']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['countrys']->value['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
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
		<div class="form-group">
			<div class="col-sm-4 col-sm-offset-2">
				<input type="hidden" value="<?php if (isset($_smarty_tpl->tpl_vars['address']->value->id)){?><?php echo $_smarty_tpl->tpl_vars['address']->value->id;?>
<?php }?>" />
				<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-save"></span> 保存</button>
			</div>
		</div>
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