<?php
if($id = Tools::getRequest('install')){
	$module = new Module((int)($id));
	$module->toggleStatus();
	echo '<div class="conf">操作成功</div>';
}
$payments = Module::getModulesByType('payment');

/** 输出错误信息 */
if (isset($errors)) {
	UIAdminAlerts::MError($errors);
}

/** 导航 */
$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '系统设置', 'active' => true));
$breadcrumb->add(array('title' => '支付模块', 'active' => true));
$bread = $breadcrumb->draw();
echo UIViewBlock::area(array('bread' => $bread), 'breadcrumb');

?>
<form class="form" method="post" action="index.php?rule=currency">
<table class="table_grid" name="list_table" width="100%">
<tr><td>
<div class="mianColForm">
	<table class="tableList table tableDnD" width="100%" cellpadding="0" cellspacing="0" id="currency">
	<thead>
		<tr>
			<th>LOGO</th>
			<th>名称</th>
			<th>描述</th>
			<th>操作</th>
		</tr>
	   </thead>
		<?php 
		foreach($payments as $key => $row){?>
		<tr class="row">
			<td class="pointer" ><img src="<?php echo $_tmconfig['pay_dir'].$key.'/logo.png';?>" /></td>
			<td class="pointer" ><?php echo $row['name'];?> <?php if($row['active']){?><span class="setup">已启用</span><?php }else{?><span class="setup non-install">未启用</span><?php }?></td>
			<td class="pointer" ><?php echo $row['description'];?></td>
			<td align="right">
				<?php if($row['active']){?>
				<a class="button" href="index.php?rule=payment&install=<?php echo $row['id'];?>">卸载</a>
				<a class="button" href="index.php?rule=payment_edit&id=<?php echo $row['id'];?>">配置</a>
				<?php }else{?>
				<a class="button" href="index.php?rule=payment&install=<?php echo $row['id'];?>">安装</a>
				<?php }?>
			</td>
		</tr>
		<?php }
		?>
	</table>
</div>
</td></tr>
</table>
</form>
