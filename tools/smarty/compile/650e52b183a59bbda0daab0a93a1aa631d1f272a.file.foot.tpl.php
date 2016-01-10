<?php /* Smarty version Smarty-3.1.12, created on 2016-01-08 13:47:44
         compiled from "/Users/apple/Documents/httpd/red/shoes/themes/shop/block/foot.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1912484779568f4d8092f125-93535433%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '650e52b183a59bbda0daab0a93a1aa631d1f272a' => 
    array (
      0 => '/Users/apple/Documents/httpd/red/shoes/themes/shop/block/foot.tpl',
      1 => 1452229588,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1912484779568f4d8092f125-93535433',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'link' => 0,
    'shop_name' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_568f4d8094a9b1_44474524',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_568f4d8094a9b1_44474524')) {function content_568f4d8094a9b1_44474524($_smarty_tpl) {?><div class="row">
	<div class="col-md-3">
		<h3>客户服务</h3>
		<ul>
			<li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('ContactView');?>
">联系我们</a></li>
			<li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('MyordersView');?>
">定单查询</a></li>
			<li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('CMSView',145);?>
">常见问题</a></li>
		</ul>
	</div>
	<div class="col-md-3">
		<h3>特色服务</h3>
		<ul>
			<li><span>全网最低价</span></li>
			<li><span>免配送费</span></li>
			<li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('SaleView');?>
">畅销产品</a></li>
		</ul>
	</div>
	<div class="col-md-3">
		<h3>关于我们</h3>
		<ul>
			<li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('CMSView',142);?>
">关于我们</a></li>
			<li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('LoginView');?>
">免费注册</a></li>
			<li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('CMSView',149);?>
">优惠码</a></li>
		</ul>
	</div>
	<div class="col-md-3">
		<h3>客服电话</h3>
		<p class="txt-14"> <span class="staticTel">+86 1234-1234567</span><br><span class="staticTel">+86 5678-1234567</span></p>
		<h4>By e-mail</h4>
		<a href="mailto:service@examples.com" class="all txt-14">service@examples.com</a>
	</div>
</div>

<div class="our-partners">
	<h3>合作伙伴</h3>
	<ul class="inline">
	  <li><a href="http://www.aliplay.com">支付宝</a></li>
	  <li><a href="http://wx.qq.com">微信</a></li>
	  <li><a href="http://www.unionpay.com">中国银联</a></li>
		<li><a href="http://www.baidu.com">百度</a></li>
		<li><a href="http://www.baidu.com">中国邮政EMS</a></li>
		<li><a href="http://www.sto.cn">申通快递</a></li>
	</ul>
</div>
<div class="copyrignt">
  <span>&copy; 2015 <?php echo $_smarty_tpl->tpl_vars['shop_name']->value;?>
, Inc. All Rights Reserved</span>
</div>
<?php }} ?>