<?php /* Smarty version Smarty-3.1.12, created on 2016-01-11 15:54:39
         compiled from "D:\wamp\www\red\shoes\themes\shop\my-addresses.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7196549d1916465eb2-06024798%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '24c8ab453b1dc5977f180e53d210e6480990191d' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\themes\\shop\\my-addresses.tpl',
      1 => 1452498724,
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
    'DISPLAY_LEFT' => 0,
    'link' => 0,
    'addresses' => 0,
    'address' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_549d1916522bf7_40366534')) {function content_549d1916522bf7_40366534($_smarty_tpl) {?><div class="container">
	<div class="row">
		<div class="col-md-2">
		<?php echo $_smarty_tpl->tpl_vars['DISPLAY_LEFT']->value;?>

		</div>
		<div class="col-md-10">
			<h2>收货地址</h2>
			<div class="row">
				<div class="col-md-12">
					<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('AddressView');?>
" class="btn btn-success btn-xs" ><span class="glyphicon glyphicon-plus"></span> 新增收货地址</a>
					<span>您已创建 <?php echo count($_smarty_tpl->tpl_vars['addresses']->value);?>
 个收货地址，最多可创建10个</span>
				</div>
				<div class="col-md-12 address-list">
					<?php  $_smarty_tpl->tpl_vars['address'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['address']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['addresses']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['address']->key => $_smarty_tpl->tpl_vars['address']->value){
$_smarty_tpl->tpl_vars['address']->_loop = true;
?>
						<div class="address-item">
							<div class="head">
								<h3>
									<b><?php echo $_smarty_tpl->tpl_vars['address']->value->name;?>
</b>
									<?php if ($_smarty_tpl->tpl_vars['address']->value->is_default){?>
										<small class="label label-success">默认地址</small>
									<?php }?>
								</h3>
								<div class="extra">
									<a href="#none" data-toggle="modal" data-target=".delete-address-modal"><span aria-hidden="true" class="glyphicon glyphicon-remove"></span></a>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="content">
								<div class="row">
									<div class="col-sm-2 key">收货人</div>
									<div class="col-sm-8 value"><?php echo $_smarty_tpl->tpl_vars['address']->value->name;?>
</div>
								</div>
								<div class="row">
									<div class="col-sm-2 key">国家</div>
									<div class="col-sm-8 value"><?php echo $_smarty_tpl->tpl_vars['address']->value->join('Country','id_country')->name;?>
</div>
								</div>
								<div class="row">
									<div class="col-sm-2 key">省份</div>
									<div class="col-sm-8 value"><?php echo $_smarty_tpl->tpl_vars['address']->value->join('State','id_state')->name;?>
</div>
								</div>
								<div class="row">
									<div class="col-sm-2 key">城市</div>
									<div class="col-sm-8 value"><?php echo $_smarty_tpl->tpl_vars['address']->value->city;?>
</div>
								</div>
								<div class="row">
									<div class="col-sm-2 key">地址</div>
									<div class="col-sm-8 value"><?php echo $_smarty_tpl->tpl_vars['address']->value->address;?>
</div>
								</div>
								<div class="row">
									<div class="col-sm-2 key">详细地址</div>
									<div class="col-sm-8 value"><?php echo $_smarty_tpl->tpl_vars['address']->value->address2;?>
</div>
								</div>
								<div class="row">
									<div class="col-sm-2 key">电话</div>
									<div class="col-sm-8 value"><?php echo $_smarty_tpl->tpl_vars['address']->value->phone;?>
</div>
									<div class="col-sm-2 other">
										<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('AddressView',$_smarty_tpl->tpl_vars['address']->value->id_address);?>
">编辑</a>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
				<div class="col-md-12">
					<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('AddressView');?>
" class="btn btn-success btn-xs" ><span class="glyphicon glyphicon-plus"></span> 新增收货地址</a>
					<span>您已创建<?php echo count($_smarty_tpl->tpl_vars['addresses']->value);?>
个收货地址，最多可创建10个</span>
				</div>
			</div>
		</div>
	</div>

</div>
<div class="modal fade delete-address-modal">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">删除</h4>
			</div>
			<div class="modal-body">
				<p>您确定要删除该收货地址吗？</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default btn-xs" data-dismiss="modal">取消</button>
				<button type="button" class="btn btn-primary btn-xs">确定</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal --><?php }} ?>