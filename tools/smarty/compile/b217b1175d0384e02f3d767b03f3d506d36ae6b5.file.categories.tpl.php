<?php /* Smarty version Smarty-3.1.12, created on 2014-12-26 11:53:19
         compiled from "D:\wamp\www\red\shoes\modules\block\categories\categories.tpl" */ ?>
<?php /*%%SmartyHeaderCode:25224549cdbafe0dbf1-49252428%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b217b1175d0384e02f3d767b03f3d506d36ae6b5' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\modules\\block\\categories\\categories.tpl',
      1 => 1413344708,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '25224549cdbafe0dbf1-49252428',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'blockCategTree' => 0,
    'id_parent_path' => 0,
    'child' => 0,
    'node' => 0,
    'threeNode' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_549cdbaff25da7_51815433',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_549cdbaff25da7_51815433')) {function content_549cdbaff25da7_51815433($_smarty_tpl) {?><div id="categories_block_left" class="block">
  <h4>Categories</h4>
  <div class="block_content">
		<ul class="level1_menu">
	  	<?php  $_smarty_tpl->tpl_vars['child'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['child']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['blockCategTree']->value['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['child']->key => $_smarty_tpl->tpl_vars['child']->value){
$_smarty_tpl->tpl_vars['child']->_loop = true;
?>
			<li class="level1_items<?php if (isset($_smarty_tpl->tpl_vars['id_parent_path']->value)&&strpos($_smarty_tpl->tpl_vars['id_parent_path']->value,$_smarty_tpl->tpl_vars['child']->value['id'])){?> selected<?php }?>">
				<span class="level1-name"><?php echo $_smarty_tpl->tpl_vars['child']->value['name'];?>
</span>
				<?php if ($_smarty_tpl->tpl_vars['child']->value['children']){?>
					<div class="level2_box">
						<ul class="level2_menu">
							<?php  $_smarty_tpl->tpl_vars['node'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['node']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['child']->value['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['node']->key => $_smarty_tpl->tpl_vars['node']->value){
$_smarty_tpl->tpl_vars['node']->_loop = true;
?>
								<li class="level2_items<?php if (isset($_smarty_tpl->tpl_vars['id_parent_path']->value)&&strpos($_smarty_tpl->tpl_vars['id_parent_path']->value,$_smarty_tpl->tpl_vars['node']->value['id'])){?> selected<?php }?>">
									<a class="level2_a" title="<?php echo $_smarty_tpl->tpl_vars['node']->value['name'];?>
" href="<?php echo $_smarty_tpl->tpl_vars['node']->value['link'];?>
"><?php echo $_smarty_tpl->tpl_vars['node']->value['name'];?>
</a><?php if (count($_smarty_tpl->tpl_vars['node']->value['children'])>0){?><span class="node-icon"></span><?php }?>
									<?php if ($_smarty_tpl->tpl_vars['node']->value['children']){?>
										<div class="level3_box">
											<ul class="level3_menu">
												<?php  $_smarty_tpl->tpl_vars['threeNode'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['threeNode']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['node']->value['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['threeNode']->key => $_smarty_tpl->tpl_vars['threeNode']->value){
$_smarty_tpl->tpl_vars['threeNode']->_loop = true;
?>
													<li class="level3_items<?php if (isset($_smarty_tpl->tpl_vars['id_parent_path']->value)&&strpos($_smarty_tpl->tpl_vars['id_parent_path']->value,$_smarty_tpl->tpl_vars['threeNode']->value['id'])){?> selected<?php }?>">
														<a class="level3_a" title="<?php echo $_smarty_tpl->tpl_vars['threeNode']->value['name'];?>
" href="<?php echo $_smarty_tpl->tpl_vars['threeNode']->value['link'];?>
"><?php echo $_smarty_tpl->tpl_vars['threeNode']->value['name'];?>
</a>
													</li>
												<?php } ?>
											</ul>
										</div>
									<?php }?>
								</li>
							<?php } ?>
						</ul>
					</div>
				<?php }?>
			</li>
		<?php } ?>
		</ul>
  </div>
</div>
<script>

$(document).ready(function(){
	$(".level1-name").click(function(){
		if($(this).parent().hasClass("selected")){
			$(this).parent().removeClass("selected")
		}else{
			$(".level1-name").parent().removeClass("selected");
			$(this).parent().addClass("selected")
		}
	})
	$(".node-icon").click(function(){
		if($(this).parent().hasClass("selected")){
			$(this).parent(".level2_items").removeClass("selected");
		}else{
			$(".node-icon").parent(".level2_items").removeClass("selected");
			$(this).parent().addClass("selected")
		}
		event.stopPropagation();
	})
})

</script>
<?php }} ?>