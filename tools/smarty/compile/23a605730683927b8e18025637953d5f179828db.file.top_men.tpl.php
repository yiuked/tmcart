<?php /* Smarty version Smarty-3.1.12, created on 2016-01-11 10:37:02
         compiled from "D:\wamp\www\red\shoes\themes\shop\block\top_men.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4057567b5fb395d501-11190934%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '23a605730683927b8e18025637953d5f179828db' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\themes\\shop\\block\\top_men.tpl',
      1 => 1452479819,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4057567b5fb395d501-11190934',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_567b5fb3a01610_75584247',
  'variables' => 
  array (
    'shop_name' => 0,
    'logged' => 0,
    'link' => 0,
    'user_email' => 0,
    'exit' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_567b5fb3a01610_75584247')) {function content_567b5fb3a01610_75584247($_smarty_tpl) {?><div class="top-menu">
    <div class="container">
        <div class="row">
            <div class="col-md-4 user-summary">
                <span>欢迎来到<?php echo $_smarty_tpl->tpl_vars['shop_name']->value;?>
</span>
                <?php if ($_smarty_tpl->tpl_vars['logged']->value){?>
                <a class="tm-email" href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('MyAccountView');?>
" title="账号"><?php echo $_smarty_tpl->tpl_vars['user_email']->value;?>
</a>
                <a class="tm-exit" href="<?php echo $_smarty_tpl->tpl_vars['exit']->value;?>
" title="退出">退出</a>
                <?php }else{ ?>
                <a class="tm-login" href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('LoginView');?>
" title="登录">登录</a>
                <a class="tm-reg" href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('JoinView');?>
" title="注册">注册</a>
                <?php }?>
            </div>
            <div class="col-md-8 user-account">
                <ul class="inline fr">
                    <li><a class="tm-order" href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('MyAccountView');?>
" title="我的定单">我的定单</a></li>
                    <li><a class="tm-wish" href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('MyWishView');?>
" title="我关注的商品"><span aria-hidden="true" class="glyphicon glyphicon-heart before"></span> 我关注的商品</a></li>
                    <li class="spacer"></li>
                    <li>
                        <a class="tm-wechat" href="#done" title="关注微信" >关注我们 <span aria-hidden="true" class="glyphicon glyphicon-menu-down after"></span></a>
                    </li>
                    <li class="spacer"></li>
                    <li class="dropdown customer-service">
                        <a class="tm-order" href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('MyAccountView');?>
">客户服务 <span aria-hidden="true" class="glyphicon glyphicon-menu-down after"></span></a>
                        <div class="menu">
                            <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('ContactView');?>
">联系我们</a>
                            <a href="#">客服邮箱</a>
                            <a href="#">帮助中心</a>
                        </div>
                    </li>
                    <li class="spacer"></li>
                    <li><a class="tm-order" href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('MyAccountView');?>
" title="网站地图">网站地图 <span aria-hidden="true" class="glyphicon glyphicon-menu-down after"></span></a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        $(".tm-wechat").popover({
            trigger:'hover',
            placement: 'bottom',
            html:true,
            content: '<img src="">',
        });
    })
</script><?php }} ?>