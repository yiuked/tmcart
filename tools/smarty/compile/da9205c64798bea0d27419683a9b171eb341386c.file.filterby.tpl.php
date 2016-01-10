<?php /* Smarty version Smarty-3.1.12, created on 2015-11-03 22:50:01
         compiled from "D:\wamp\www\red\shoes\modules\block\filterby\filterby.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3195154992dda014257-52474051%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'da9205c64798bea0d27419683a9b171eb341386c' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\modules\\block\\filterby\\filterby.tpl',
      1 => 1446561897,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3195154992dda014257-52474051',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_54992dda377b48_25502518',
  'variables' => 
  array (
    'filter' => 0,
    'styles' => 0,
    'style' => 0,
    'ags' => 0,
    'id_parent_path' => 0,
    'view_name' => 0,
    'colors' => 0,
    'color' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54992dda377b48_25502518')) {function content_54992dda377b48_25502518($_smarty_tpl) {?><div class="product-list-filter">
<div class="header off">
	<h2 <?php if (count($_smarty_tpl->tpl_vars['filter']->value)){?>data-count="<?php echo count($_smarty_tpl->tpl_vars['filter']->value);?>
"<?php }?>><strong>Filter by</strong></h2>
	<ul class="filter-resume">
		<?php if (count($_smarty_tpl->tpl_vars['filter']->value)){?>
		<?php if (isset($_smarty_tpl->tpl_vars['filter']->value['color'])){?>
		<li><strong>Color: <?php echo $_smarty_tpl->tpl_vars['filter']->value['color']['name'];?>
</strong><a href="?" class="icon-cancel-2"></a></li>
		<?php }?>
		<li class="resetFilter"><a href="?"><strong>Delete selection</strong><i class="icon-cancel-2"></i></a></li>
		<?php }?>
	</ul>
</div>
<?php if ($_smarty_tpl->tpl_vars['styles']->value){?>
<div class="section actif">
  <h3 class="filter-title"><a href="javascript:void(0)"><span>Style</span></a></h3>
  <ul class="filter">
  	<?php  $_smarty_tpl->tpl_vars['style'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['style']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['styles']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['style']->key => $_smarty_tpl->tpl_vars['style']->value){
$_smarty_tpl->tpl_vars['style']->_loop = true;
?>
    <li class="shopstyle-bloc"><a title="<?php echo $_smarty_tpl->tpl_vars['style']->value['name'];?>
" href="<?php echo $_smarty_tpl->tpl_vars['style']->value['link'];?>
<?php echo $_smarty_tpl->tpl_vars['ags']->value;?>
<?php if (isset($_smarty_tpl->tpl_vars['style']->value['color'])){?>id_color=<?php echo $_smarty_tpl->tpl_vars['style']->value['color']['path'];?>
<?php }?>">
		<i class="icon-radio<?php if (isset($_smarty_tpl->tpl_vars['id_parent_path']->value)&&strpos($_smarty_tpl->tpl_vars['id_parent_path']->value,$_smarty_tpl->tpl_vars['style']->value['id_category'])){?>-checked<?php }?>"></i><span><?php echo $_smarty_tpl->tpl_vars['style']->value['name'];?>
</span></a>
	</li>
	<?php } ?>
  </ul>
</div>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['view_name']->value=='index'){?>
<?php if ($_smarty_tpl->tpl_vars['colors']->value){?>
<div class="section actif">
  <h3 class="filter-title"><a href="javascript:void(0)"><span>Colour</span></a></h3>
  <ul class="list-shopcolor">
  	<?php  $_smarty_tpl->tpl_vars['color'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['color']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['colors']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['color']->key => $_smarty_tpl->tpl_vars['color']->value){
$_smarty_tpl->tpl_vars['color']->_loop = true;
?>
    <li class="shopcolor-bloc">
		<a title="<?php echo $_smarty_tpl->tpl_vars['color']->value['name'];?>
" href="<?php echo $_smarty_tpl->tpl_vars['color']->value['link'];?>
" <?php if (isset($_smarty_tpl->tpl_vars['filter']->value['color'])&&in_array($_smarty_tpl->tpl_vars['color']->value['id_color'],$_smarty_tpl->tpl_vars['filter']->value['color']['id'])){?>class="active"<?php }?>>
		<span style="background:<?php echo $_smarty_tpl->tpl_vars['color']->value['code'];?>
"><?php echo $_smarty_tpl->tpl_vars['color']->value['name'];?>
</span></a>
	</li>
	<?php } ?>
  </ul>
</div>
<?php }?>
<?php }else{ ?>
<?php if ($_smarty_tpl->tpl_vars['colors']->value){?>
<div class="section actif">
  <h3 class="filter-title"><a href="javascript:void(0)"><span>Colour</span></a></h3>
  <ul class="list-shopcolor">
  	<?php  $_smarty_tpl->tpl_vars['color'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['color']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['colors']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['color']->key => $_smarty_tpl->tpl_vars['color']->value){
$_smarty_tpl->tpl_vars['color']->_loop = true;
?>
    <li class="shopcolor-bloc">
		<a title="<?php echo $_smarty_tpl->tpl_vars['color']->value['name'];?>
" href="?id_color=<?php if (isset($_smarty_tpl->tpl_vars['filter']->value['color'])){?><?php echo $_smarty_tpl->tpl_vars['filter']->value['color']['path'];?>
<?php }?><?php echo $_smarty_tpl->tpl_vars['color']->value['id_color'];?>
" <?php if (isset($_smarty_tpl->tpl_vars['filter']->value['color'])&&in_array($_smarty_tpl->tpl_vars['color']->value['id_color'],$_smarty_tpl->tpl_vars['filter']->value['color']['id'])){?>class="active"<?php }?>>
		<span style="background:<?php echo $_smarty_tpl->tpl_vars['color']->value['code'];?>
"><?php echo $_smarty_tpl->tpl_vars['color']->value['name'];?>
</span></a>
	</li>
	<?php } ?>
  </ul>
</div>
<?php }?>
<?php }?>
</div>
<?php }} ?>