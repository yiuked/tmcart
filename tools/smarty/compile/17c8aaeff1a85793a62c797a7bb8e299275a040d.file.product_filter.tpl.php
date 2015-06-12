<?php /* Smarty version Smarty-3.1.12, created on 2014-12-29 15:54:16
         compiled from "D:\wamp\www\red\shoes\themes\shop\block\product_filter.tpl" */ ?>
<?php /*%%SmartyHeaderCode:586754992dda812068-65179926%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '17c8aaeff1a85793a62c797a7bb8e299275a040d' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\themes\\shop\\block\\product_filter.tpl',
      1 => 1419839648,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '586754992dda812068-65179926',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_54992ddac22dd3_55127000',
  'variables' => 
  array (
    'p' => 0,
    'n' => 0,
    'currenN' => 0,
    'total' => 0,
    'this_url' => 0,
    'query' => 0,
    'n_list' => 0,
    'per' => 0,
    'sort' => 0,
    'link' => 0,
    'pages_nb' => 0,
    'showPage' => 0,
    'pageBefor' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54992ddac22dd3_55127000')) {function content_54992ddac22dd3_55127000($_smarty_tpl) {?><script language="javascript">

$(function(){
    $('.dept_select').chosen({disable_search_threshold: 10});
});

</script>
<div class="itemsShown">Items: <strong><?php echo ($_smarty_tpl->tpl_vars['p']->value-1)*$_smarty_tpl->tpl_vars['n']->value;?>
 - <?php if ($_smarty_tpl->tpl_vars['currenN']->value>$_smarty_tpl->tpl_vars['total']->value){?><?php echo $_smarty_tpl->tpl_vars['total']->value;?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['currenN']->value;?>
<?php }?></strong> of <strong><?php echo $_smarty_tpl->tpl_vars['total']->value;?>
</strong></div>
<form action="<?php echo $_smarty_tpl->tpl_vars['this_url']->value;?>
" method="GET">
	<div class="itemCountControls">
		<span class="label">VIEW:</span>
		<?php if (isset($_smarty_tpl->tpl_vars['query']->value)){?>
		<input type="hidden" name="s" value="<?php echo $_smarty_tpl->tpl_vars['query']->value;?>
" />
		<?php }?>
		<select onchange="this.form.submit()" name="resultSize" class="dept_select" style="width:100px;text-align:left;">
			<?php  $_smarty_tpl->tpl_vars['per'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['per']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['n_list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['per']->key => $_smarty_tpl->tpl_vars['per']->value){
$_smarty_tpl->tpl_vars['per']->_loop = true;
?>
			<option <?php if ($_smarty_tpl->tpl_vars['n']->value==$_smarty_tpl->tpl_vars['per']->value){?>selected="selected"<?php }?> value="<?php echo $_smarty_tpl->tpl_vars['per']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['per']->value;?>
 items</option> 
			<?php } ?>
		</select>
	</div>
</form>
<form action="<?php echo $_smarty_tpl->tpl_vars['this_url']->value;?>
" method="GET">
	<div class="sortByControls">
		<span class="label">SORT BY:</span>
		<?php if (isset($_smarty_tpl->tpl_vars['query']->value)){?>
		<input type="hidden" name="s" value="<?php echo $_smarty_tpl->tpl_vars['query']->value;?>
" />
		<?php }?>
		<select onchange="this.form.submit()" name="sort" class="dept_select" style="width:150px;text-align:left;">
		  <option value="newest" <?php if ($_smarty_tpl->tpl_vars['sort']->value=='newest'){?>selected="selected"<?php }?>>Newest</option>
		  <option value="orders" <?php if ($_smarty_tpl->tpl_vars['sort']->value=='orders'){?>selected="selected"<?php }?>>Orders</option>
		  <option value="rental_price_desc" <?php if ($_smarty_tpl->tpl_vars['sort']->value=='rental_price_desc'){?>selected="selected"<?php }?>>Price: high to low</option>
		  <option value="rental_price_asc" <?php if ($_smarty_tpl->tpl_vars['sort']->value=='rental_price_asc'){?>selected="selected"<?php }?>>Price: low to high</option>
		</select>
	</div>
</form>

<?php $_smarty_tpl->tpl_vars["showPage"] = new Smarty_variable("5", null, 0);?>

<?php $_smarty_tpl->tpl_vars["pageBefor"] = new Smarty_variable("3", null, 0);?>
<div class="browsePageControls">
	<span class="label">PAGE:</span>
	<?php if ($_smarty_tpl->tpl_vars['p']->value!=1){?>
	<a class="control prev" href="<?php echo $_smarty_tpl->tpl_vars['link']->value->goPage($_smarty_tpl->tpl_vars['this_url']->value,$_smarty_tpl->tpl_vars['p']->value-1);?>
">&nbsp; &nbsp;</a>
	<?php }else{ ?>
	<span class="control ui-pagination-prev ui-pagination-disabled">&nbsp; &nbsp;</span>
	<?php }?>
	<?php if ($_smarty_tpl->tpl_vars['pages_nb']->value<$_smarty_tpl->tpl_vars['showPage']->value){?>
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['name'] = 'pagination';
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start'] = (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['pages_nb']->value+1) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'] = ((int)1) == 0 ? 1 : (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['loop'];
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['total']);
?>
			<?php if ($_smarty_tpl->tpl_vars['p']->value==$_smarty_tpl->getVariable('smarty')->value['section']['pagination']['index']){?>
			<a class="control pageNum selected" href="<?php echo $_smarty_tpl->tpl_vars['link']->value->goPage($_smarty_tpl->tpl_vars['this_url']->value,$_smarty_tpl->getVariable('smarty')->value['section']['pagination']['index']);?>
"><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['pagination']['index'];?>
</a>
			<?php }else{ ?>
			<a class="control pageNum" href="<?php echo $_smarty_tpl->tpl_vars['link']->value->goPage($_smarty_tpl->tpl_vars['this_url']->value,$_smarty_tpl->getVariable('smarty')->value['section']['pagination']['index']);?>
"><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['pagination']['index'];?>
</a>
			<?php }?>
		<?php endfor; endif; ?>
	<?php }elseif($_smarty_tpl->tpl_vars['p']->value<=($_smarty_tpl->tpl_vars['pageBefor']->value+1)){?>
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['name'] = 'pagination';
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start'] = (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['showPage']->value+1) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'] = ((int)1) == 0 ? 1 : (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['loop'];
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['total']);
?>
			<?php if ($_smarty_tpl->tpl_vars['p']->value==$_smarty_tpl->getVariable('smarty')->value['section']['pagination']['index']){?>
			<a class="control pageNum selected" href="<?php echo $_smarty_tpl->tpl_vars['link']->value->goPage($_smarty_tpl->tpl_vars['this_url']->value,$_smarty_tpl->getVariable('smarty')->value['section']['pagination']['index']);?>
"><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['pagination']['index'];?>
</a>
			<?php }else{ ?>
			<a class="control pageNum" href="<?php echo $_smarty_tpl->tpl_vars['link']->value->goPage($_smarty_tpl->tpl_vars['this_url']->value,$_smarty_tpl->getVariable('smarty')->value['section']['pagination']['index']);?>
"><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['pagination']['index'];?>
</a>
			<?php }?>
		<?php endfor; endif; ?>
	<?php }elseif($_smarty_tpl->tpl_vars['pages_nb']->value-$_smarty_tpl->tpl_vars['p']->value<=$_smarty_tpl->tpl_vars['pageBefor']->value){?>
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['name'] = 'pagination';
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start'] = (int)$_smarty_tpl->tpl_vars['pages_nb']->value-$_smarty_tpl->tpl_vars['showPage']->value+1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['pages_nb']->value+1) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'] = ((int)1) == 0 ? 1 : (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['loop'];
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['total']);
?>
			<?php if ($_smarty_tpl->tpl_vars['p']->value==$_smarty_tpl->getVariable('smarty')->value['section']['pagination']['index']){?>
			<a class="control pageNum selected" href="<?php echo $_smarty_tpl->tpl_vars['link']->value->goPage($_smarty_tpl->tpl_vars['this_url']->value,$_smarty_tpl->getVariable('smarty')->value['section']['pagination']['index']);?>
"><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['pagination']['index'];?>
</a>
			<?php }else{ ?>
			<a class="control pageNum" href="<?php echo $_smarty_tpl->tpl_vars['link']->value->goPage($_smarty_tpl->tpl_vars['this_url']->value,$_smarty_tpl->getVariable('smarty')->value['section']['pagination']['index']);?>
"><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['pagination']['index'];?>
</a>
			<?php }?>
		<?php endfor; endif; ?>
	<?php }else{ ?>
		<?php if (isset($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination'])) unset($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['name'] = 'pagination';
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start'] = (int)$_smarty_tpl->tpl_vars['p']->value-$_smarty_tpl->tpl_vars['pageBefor']->value;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['loop'] = is_array($_loop=$_smarty_tpl->tpl_vars['p']->value+$_smarty_tpl->tpl_vars['showPage']->value-$_smarty_tpl->tpl_vars['pageBefor']->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'] = ((int)1) == 0 ? 1 : (int)1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['loop'];
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start'] < 0)
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start'] = max($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'] > 0 ? 0 : -1, $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['loop'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start']);
else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start'] = min($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['loop'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['loop']-1);
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['total'] = min(ceil(($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'] > 0 ? $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['loop'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start'] : $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start']+1)/abs($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'])), $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['max']);
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['pagination']['total']);
?>
			<?php if ($_smarty_tpl->tpl_vars['p']->value==$_smarty_tpl->getVariable('smarty')->value['section']['pagination']['index']){?>
			<a class="control pageNum selected" href="<?php echo $_smarty_tpl->tpl_vars['link']->value->goPage($_smarty_tpl->tpl_vars['this_url']->value,$_smarty_tpl->getVariable('smarty')->value['section']['pagination']['index']);?>
"><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['pagination']['index'];?>
</a>
			<?php }else{ ?>
			<a class="control pageNum" href="<?php echo $_smarty_tpl->tpl_vars['link']->value->goPage($_smarty_tpl->tpl_vars['this_url']->value,$_smarty_tpl->getVariable('smarty')->value['section']['pagination']['index']);?>
"><?php echo $_smarty_tpl->getVariable('smarty')->value['section']['pagination']['index'];?>
</a>
			<?php }?>
		<?php endfor; endif; ?>	
	<?php }?>

	<?php if ($_smarty_tpl->tpl_vars['pages_nb']->value>1&&$_smarty_tpl->tpl_vars['p']->value!=$_smarty_tpl->tpl_vars['pages_nb']->value){?>
	<a class="control next" href="<?php echo $_smarty_tpl->tpl_vars['link']->value->goPage($_smarty_tpl->tpl_vars['this_url']->value,$_smarty_tpl->tpl_vars['p']->value+1);?>
">&nbsp; &nbsp;</a>
	<?php }else{ ?>
	<span class="control ui-pagination-next ui-pagination-disabled">&nbsp; &nbsp;</span>
	<?php }?>
	
	<div class="ui-pagination-goto">
		<input type="hidden" id="max-page-nb" class="max-page-nb" value="<?php echo $_smarty_tpl->tpl_vars['pages_nb']->value;?>
" />
		<label for="" class="ui-label">
			Go to Page
			<input type="text" class="ui-textfield ui-textfield-system" maxlength="3" id="pagination-bottom-input">
		</label>
		<input type="button" value="Go" id="pagination-bottom-goto">
	</div>
</div><?php }} ?>