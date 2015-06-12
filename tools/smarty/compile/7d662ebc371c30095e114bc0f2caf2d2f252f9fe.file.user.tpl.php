<?php /* Smarty version Smarty-3.1.12, created on 2015-05-25 17:17:27
         compiled from "D:\wamp\www\red\shoes\themes\shop\user.tpl" */ ?>
<?php /*%%SmartyHeaderCode:249055562e8a7c32228-72736409%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7d662ebc371c30095e114bc0f2caf2d2f252f9fe' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\themes\\shop\\user.tpl',
      1 => 1418028321,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '249055562e8a7c32228-72736409',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'success' => 0,
    'link' => 0,
    'user' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_5562e8a7d0f8f5_58151021',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5562e8a7d0f8f5_58151021')) {function content_5562e8a7d0f8f5_58151021($_smarty_tpl) {?><div id="main_columns_two" class="custom">
	<h2>Your personal information</h2>
  	<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./block/errors.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

	<?php if (isset($_smarty_tpl->tpl_vars['success']->value)){?><div class="success"><?php echo $_smarty_tpl->tpl_vars['success']->value;?>
</div><?php }?>
    <form style="width:380px;" method="post" action="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('UserView');?>
" name="joinCommit" id="joinCommit">
      <input type="hidden" id="joinCommit_prevLocation" value="Bam1" name="prevLocation">
      <div class="formField">
        <div class="label">Email Address:</div>
        <div class="input"><?php echo $_smarty_tpl->tpl_vars['user']->value->email;?>
</div>
      </div>
	  <div class="formField">
        <div class="label"><span class="requiredRed">*</span> First name:</div>
        <div class="input">
          <input type="text" id="first_name" value="<?php if (isset($_POST['first_name'])){?><?php echo $_POST['first_name'];?>
<?php }elseif(isset($_smarty_tpl->tpl_vars['user']->value->first_name)){?><?php echo $_smarty_tpl->tpl_vars['user']->value->first_name;?>
<?php }?>" maxlength="75" name="first_name" size="30">
        </div>
      </div>
      <div class="formField">
        <div class="label"><span class="requiredRed">*</span> Last name:</div>
        <div class="input">
          <input type="text" id="last_name" value="<?php if (isset($_POST['last_name'])){?><?php echo $_POST['last_name'];?>
<?php }elseif(isset($_smarty_tpl->tpl_vars['user']->value->last_name)){?><?php echo $_smarty_tpl->tpl_vars['user']->value->last_name;?>
<?php }?>" maxlength="75" name="last_name" size="30">
        </div>
      </div>
      <div class="formField">
        <div class="label"><span class="requiredRed">*</span>Current Password:</div>
        <div class="input">
          <input type="password" id="old_passwd" name="old_passwd" size="30">
        </div>
      </div>
      <div class="formField">
        <div class="label">New Password:</div>
        <div class="input">
          <input type="password" id="passwd" name="passwd" size="30">
        </div>
      </div>
      <div class="formField">
        <div class="label">Confirmation:</div>
        <div class="input">
          <input type="password" id="confirmation" name="confirmation" size="30">
        </div>
      </div>
      <div style="height:40px;" class="formField">
        <div style="padding:10px 0px 10px 0px; text-align: left;" class="input">
          <input type="submit" value="Submit" name="joinCommit" id="joinCommit" class="form-send button big east pink collapse">
        </div>
      </div>
    </form>
</div><?php }} ?>