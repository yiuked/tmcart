<?php /* Smarty version Smarty-3.1.12, created on 2016-02-26 22:03:01
         compiled from "D:\wamp\www\red\shoes\themes\shop\block\top_navigation.tpl" */ ?>
<?php /*%%SmartyHeaderCode:585956d05b150b8757-68601710%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f53de8738a85f109548a18788cd67595de8a6e3a' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\themes\\shop\\block\\top_navigation.tpl',
      1 => 1452398898,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '585956d05b150b8757-68601710',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'view_name' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_56d05b1520c526_88730194',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_56d05b1520c526_88730194')) {function content_56d05b1520c526_88730194($_smarty_tpl) {?><div class="navigation">
	<div class="container">
		<div class="nav">
			<ul class="inline">
				<?php if ($_smarty_tpl->tpl_vars['view_name']->value=='index'){?>
				<li class="all">
					<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('CategoryView',57);?>
" title="所有商品分类">所有商品分类</a>
					<div class="categories">

					</div>
				</li>
				<?php }?>
				<li class="nav-item"><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('CategoryView',57);?>
" title="首页">首页</a></li>
				<li class="nav-item"><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('CategoryView',57);?>
" title="活动预告">活动预告</a></li>
				<li class="nav-item"><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('CategoryView',53);?>
" title="限时活动">限时活动</a></li>
				<li class="nav-item"><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('CategoryView',60);?>
" title="特价商品">特价商品</a></li>
				<li class="nav-item"><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('CategoryView',70);?>
" title="最新上架s">最新上架</a></li>
				<li class="nav-item"><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('SaleView');?>
" title="热卖商品">热卖商品</a></li>
				<li class="nav-item"><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('SaleView');?>
" title="新闻动态">新闻动态</a></li>
			</ul>
			<s class="nav-indicator" style=""></s>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$(".nav-indicator").css({
			"left":$(".nav-item a").eq(0).position().left + "px",
			"width":$(".nav-item a").eq(0).width() + 12 + "px"
		})
		$(".nav-item a").each(function(){
			var that = $(this);
			var left = $(this).position().left;
			var width = $(this).width();
			that.hoverDelay({
				hoverEvent: function(){
					$(".nav-indicator").animate({
						left: left +'px',
						width: width + 12 +'px'
					});
				}
			})
		})
	});
</script><?php }} ?>