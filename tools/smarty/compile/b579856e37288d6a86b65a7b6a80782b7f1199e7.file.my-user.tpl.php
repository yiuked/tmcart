<?php /* Smarty version Smarty-3.1.12, created on 2016-01-11 16:05:06
         compiled from "D:\wamp\www\red\shoes\themes\shop\my-user.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3192056936212ae1d08-35661800%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b579856e37288d6a86b65a7b6a80782b7f1199e7' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\themes\\shop\\my-user.tpl',
      1 => 1452499505,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3192056936212ae1d08-35661800',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_56936212bd0196_17848363',
  'variables' => 
  array (
    'DISPLAY_LEFT' => 0,
    'success' => 0,
    'link' => 0,
    'user' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56936212bd0196_17848363')) {function content_56936212bd0196_17848363($_smarty_tpl) {?><div class="container">
  <div class="row">
    <div class="col-md-2">
      <?php echo $_smarty_tpl->tpl_vars['DISPLAY_LEFT']->value;?>

    </div>
    <div class="col-md-10">
      <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./block/errors.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

      <?php if (isset($_smarty_tpl->tpl_vars['success']->value)){?><div class="success"><?php echo $_smarty_tpl->tpl_vars['success']->value;?>
</div><?php }?>
      <form method="post" action="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('UserView');?>
" class="form-horizontal">
        <div class="form-group">
          <label for="email" class="col-sm-2 control-label">邮箱</label>
          <div class="col-sm-6">
            <input type="email" name="email" class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['user']->value->email;?>
" placeholder="邮箱">
          </div>
        </div>
        <div class="form-group">
          <label for="name" class="col-sm-2 control-label">昵称</label>
          <div class="col-sm-6">
            <input type="text" class="form-control" name="name" value="<?php if (isset($_POST['name'])){?><?php echo $_POST['name'];?>
<?php }elseif(isset($_smarty_tpl->tpl_vars['user']->value->name)){?><?php echo $_smarty_tpl->tpl_vars['user']->value->name;?>
<?php }?>" placeholder="昵称">
          </div>
        </div>
        <div class="form-group">
          <label for="old_passwd" class="col-sm-2 control-label">原密码</label>
          <div class="col-sm-6">
            <input type="password" class="form-control" name="old_passwd" value="" placeholder="原密码">
          </div>
        </div>
        <div class="form-group">
          <label for="passwd" class="col-sm-2 control-label">新密码</label>
          <div class="col-sm-6">
            <input type="password" class="form-control" name="passwd" value="" placeholder="新密码">
          </div>
        </div>
        <div class="form-group">
          <label for="confirmation" class="col-sm-2 control-label">确认密码</label>
          <div class="col-sm-6">
            <input type="password" class="form-control" name="confirmation" value="" placeholder="确认密码">
          </div>
        </div>
        <div class="form-group">
          <div class="col-sm-6 col-sm-offset-2">
            <button type="submit" class="btn btn-success">保存</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div><?php }} ?>