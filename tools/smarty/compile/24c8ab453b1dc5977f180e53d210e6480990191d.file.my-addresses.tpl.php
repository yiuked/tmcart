<?php /* Smarty version Smarty-3.1.12, created on 2014-12-26 16:57:29
         compiled from "D:\wamp\www\red\shoes\themes\shop\my-addresses.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7196549d1916465eb2-06024798%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '24c8ab453b1dc5977f180e53d210e6480990191d' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\themes\\shop\\my-addresses.tpl',
      1 => 1419581817,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7196549d1916465eb2-06024798',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_549d1916522bf7_40366534',
  'variables' => 
  array (
    'address' => 0,
    'link' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_549d1916522bf7_40366534')) {function content_549d1916522bf7_40366534($_smarty_tpl) {?><div id="main_columns_two" class="custom">
<h2>My Addresses</h2>
<fieldset id="p-address">
<table cellpadding="0" cellspacing="0" width="100%">
	<tr>
		<td style="padding:5px;">
		<?php if ($_smarty_tpl->tpl_vars['address']->value){?>
		<p class="addressItme">
			<strong><?php echo $_smarty_tpl->tpl_vars['address']->value->first_name;?>
 <?php echo $_smarty_tpl->tpl_vars['address']->value->last_name;?>
</strong><br>
			<?php echo $_smarty_tpl->tpl_vars['address']->value->address;?>
<br>
			<?php echo $_smarty_tpl->tpl_vars['address']->value->address2;?>
<br>
			<?php echo $_smarty_tpl->tpl_vars['address']->value->postcode;?>
 <?php echo $_smarty_tpl->tpl_vars['address']->value->city;?>
 <?php if ($_smarty_tpl->tpl_vars['address']->value->country->need_state){?> <?php echo $_smarty_tpl->tpl_vars['address']->value->state->name;?>
<?php }?> <br>
			<?php echo $_smarty_tpl->tpl_vars['address']->value->country->name;?>
<br>
			<?php echo $_smarty_tpl->tpl_vars['address']->value->phone;?>
<br>
			<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('AddressView');?>
?id_address=<?php echo $_smarty_tpl->tpl_vars['address']->value->id;?>
" class="all"><strong>Change address</strong></a>
		</p>
		<?php }else{ ?>
		<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('AddressView');?>
" class="all"><strong>Add address</strong></a>
		<?php }?>
		</td>
	</tr>
</table>
</fieldset>
<br/>
</div>
<?php }} ?>