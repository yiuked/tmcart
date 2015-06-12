<?php /* Smarty version Smarty-3.1.12, created on 2014-12-26 17:02:43
         compiled from "D:\wamp\www\red\shoes\themes\shop\cms.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17803549d24333fd626-36029834%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b32d7e7fb557a785e2f0092863bf0ea21a465526' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\themes\\shop\\cms.tpl',
      1 => 1418107272,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17803549d24333fd626-36029834',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'entity' => 0,
    'tags' => 0,
    'comments_nb' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_549d2433468659_14012186',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_549d2433468659_14012186')) {function content_549d2433468659_14012186($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['entity']->value){?>
<div id="main_columns_two">
  <article id="post-<?php echo $_smarty_tpl->tpl_vars['entity']->value->id;?>
" class="post">
<?php if (!$_smarty_tpl->tpl_vars['entity']->value->is_page){?>
    <div class="meta"><?php echo $_smarty_tpl->tpl_vars['entity']->value->add_date;?>
 <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./block/cms_tag.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('node'=>$_smarty_tpl->tpl_vars['tags']->value), 0);?>
</div>
    <div class="commentcount"> <a title="<?php echo $_smarty_tpl->tpl_vars['entity']->value->title;?>
" href="#comments">我要评论(<?php echo $_smarty_tpl->tpl_vars['comments_nb']->value;?>
)</a></div>
<?php }?>
    <h2><span><?php echo $_smarty_tpl->tpl_vars['entity']->value->title;?>
</span></h2>
    <div class="entry"><?php echo $_smarty_tpl->tpl_vars['entity']->value->content;?>
</div>
    <footer class="metabottom">
	
	</footer>
    <div class="nr_clear"></div>
  </article>
</div>
<?php }?>
<?php if (!$_smarty_tpl->tpl_vars['entity']->value->is_page){?>
<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./block/cms_comment.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }?><?php }} ?>