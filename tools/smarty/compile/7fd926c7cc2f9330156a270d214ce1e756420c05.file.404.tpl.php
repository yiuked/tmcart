<?php /* Smarty version Smarty-3.1.12, created on 2014-12-25 12:08:07
         compiled from "D:\wamp\www\red\shoes\themes\shop\404.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1337854992dd28f8895-18560534%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7fd926c7cc2f9330156a270d214ce1e756420c05' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\themes\\shop\\404.tpl',
      1 => 1419480479,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1337854992dd28f8895-18560534',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_54992dd29306c4_82669138',
  'variables' => 
  array (
    'link' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54992dd29306c4_82669138')) {function content_54992dd29306c4_82669138($_smarty_tpl) {?><h2 class="tc-standard">404 Not Found</h2>
<div class="box-style">
  <div class="bd">
    <ul class="spacer-list no txt-14">
      <li>Looking for the hottest styles? <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('SaleView');?>
" class="all no"><strong>This way for inspiration...</strong></a> </li>
      <li>Already added items to your favourites? <a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('WishView');?>
" class="all no"><strong>See them here!</strong></a> </li>
    </ul>
  </div>
</div><?php }} ?>