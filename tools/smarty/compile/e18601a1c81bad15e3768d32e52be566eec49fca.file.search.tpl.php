<?php /* Smarty version Smarty-3.1.12, created on 2014-12-29 16:11:47
         compiled from "D:\wamp\www\red\shoes\themes\shop\search.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5153549cdbb01f1907-01124916%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e18601a1c81bad15e3768d32e52be566eec49fca' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\themes\\shop\\search.tpl',
      1 => 1419840703,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5153549cdbb01f1907-01124916',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_549cdbb022f1f8_34059555',
  'variables' => 
  array (
    'total' => 0,
    'query' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_549cdbb022f1f8_34059555')) {function content_549cdbb022f1f8_34059555($_smarty_tpl) {?><?php if (isset($_smarty_tpl->tpl_vars['total']->value)&&$_smarty_tpl->tpl_vars['total']->value>0){?>
  <div class="h_title" style="margin-top:20px;">YOUR SEARCH RESULTS FOR: <?php echo $_smarty_tpl->tpl_vars['query']->value;?>
 </div>
  <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./block/product_list.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }else{ ?>
	<h2 class="tc-standard">Sorry, your search for "<?php echo $_smarty_tpl->tpl_vars['query']->value;?>
" produced no results.</h2>
	<div class="box-style">
	  <div class="bd">
	   <div> Would you like to search again using a different spelling or fewer search terms? </div>
		<ul class="spacer-list no txt-14">
		  <li>Looking for the hottest styles? <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('SaleView');?>
" class="all no"><strong>This way for inspiration...</strong></a> </li>
		  <li>Already added items to your favourites? <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('WishView');?>
" class="all no"><strong>See them here!</strong></a> </li>
		</ul>
	  </div>
	</div>
<?php }?>
<?php }} ?>