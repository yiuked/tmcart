<?php /* Smarty version Smarty-3.1.12, created on 2015-08-07 09:34:03
         compiled from "D:\wamp\www\red\shoes\themes\shop\block\foot.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2318154992dd248c3b9-97088008%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '117fbccc8b7326ee27c267236fba3d363b776fdc' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\themes\\shop\\block\\foot.tpl',
      1 => 1435895024,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2318154992dd248c3b9-97088008',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_54992dd2542b65_27359381',
  'variables' => 
  array (
    'link' => 0,
    'shop_name' => 0,
    'img_dir' => 0,
    'root_dir' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54992dd2542b65_27359381')) {function content_54992dd2542b65_27359381($_smarty_tpl) {?><div class="pt-standard footer-center">
  <div class="inner">
	<div role="navigation" class="nav secondary">
	  <div class="col">
		<h3>Your questions</h3>
		<ul>
		  <li> <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('ContactView');?>
">Contact customer service</a> </li>
		  <li> <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('MyordersView');?>
">Track your order</a> </li>
		  <li> <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('CMSView',145);?>
">FAQ</a> </li>
		</ul>
		<h3 class="skip-default">Our guides</h3>
		<ul class="skip-default">
		  <li> <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('CMSView',144);?>
">Shoes Size guide</a> </li>
		  <li> <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('CMSView',148);?>
">Clothing Size guide</a> </li>
		</ul>
	  </div>
	  <div class="col skip-default">
		<h3>What's <?php echo $_smarty_tpl->tpl_vars['shop_name']->value;?>
 all about?</h3>
		<ul>
		  <li><span>The lowest price,save 60% off</span></li>
		  <li><span>Free Shipping</span></li>
		  <li> <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('SaleView');?>
">Hot sale products</a> </li>
		  <li><span>Express dispatch</span></li>
		</ul>
	  </div>
	  <div class="col skip-default">
		<h3>The <?php echo $_smarty_tpl->tpl_vars['shop_name']->value;?>
 world</h3>
		<ul>
		  <li> <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('CMSView',142);?>
">Who are we?</a> </li>
		  <li> <a href="/">Our awards</a> </li>
		  <li> <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('LoginView');?>
">Join us</a> </li>
		  <li> <a href="/">Affiliate programme</a> </li>
		  <li> <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('CMSView',149);?>
">Promo code</a> </li>
		</ul>
	  </div>
	</div>
	<div class="customer-service">
	  <h3>Need help?</h3>
	  <p class="txt-14">We'll answer your questions! <br>
		Our customer service team is here Monday-Friday from 9 a.m. to 12 p.m. and from 1 p.m. to 5 p.m.</p>
	  <div class="col">
		<h4>Call us at</h4>
		<p class="txt-14"> <span class="staticTel">+44 (0)5.23.05.67.39<br>
		  </span> <a href="tel:+44 (0)5.23.05.67.39" class="call">+44 (0)5.23.05.67.39</a> <span class="txt-12">(toll-free)</span> </p>
	  </div>
	  <div class="col">
		<h4>By e-mail</h4>
		<a href="mailto:smilecustomerservices@hotmail.com" class="all txt-14"><img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
email.png" style="vertical-align: text-bottom;"></a> </div>
	</div>
	 <div class="clear"></div>
  </div>
</div>
<div class="pt-standard footer-bottom skip-content">
<div class="inner">
	<h3>Our partners</h3>
	<ul>
	  <li class="partners-trusted-shops partner-icon">Trustedshop</li>
	  <li class="partners-mastercard-securecode partner-icon">Mastercard SecureCode</li>
	  <li class="partners-verified-by-visa partner-icon">Verified by Visa</li>
	</ul>
	<h3 style="margin-left: 35px;">Our transport providers</h3>
	<ul>
	  <li class="partners-ups-en partner-icon">UPS</li>
	  <li class="partners-hermes partner-icon">Hermes</li>
	</ul>
	<div class="clear"></div>
</div>
</div>
<div class="copyrignt">
  <span>&copy; 2015 <?php echo $_smarty_tpl->tpl_vars['shop_name']->value;?>
, Inc. All Rights Reserved</span>
  <ul class="floatr">
	<li><a href="<?php echo $_smarty_tpl->tpl_vars['root_dir']->value;?>
">*Current offer conditions</a></li>
	<li><a href="<?php echo $_smarty_tpl->tpl_vars['root_dir']->value;?>
">Terms and conditions</a></li>
	<li><a href="<?php echo $_smarty_tpl->tpl_vars['root_dir']->value;?>
">Privacy information</a></li>
  </ul>
</div>
<?php }} ?>