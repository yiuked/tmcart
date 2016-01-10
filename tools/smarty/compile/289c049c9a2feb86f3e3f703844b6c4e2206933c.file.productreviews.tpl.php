<?php /* Smarty version Smarty-3.1.12, created on 2015-01-24 12:11:52
         compiled from "D:\wamp\www\red\shoes\modules\block\productreviews\productreviews.tpl" */ ?>
<?php /*%%SmartyHeaderCode:731054c31b882e25f1-81450338%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '289c049c9a2feb86f3e3f703844b6c4e2206933c' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\modules\\block\\productreviews\\productreviews.tpl',
      1 => 1411873066,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '731054c31b882e25f1-81450338',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'img_dir' => 0,
    'feedbacks' => 0,
    'feedback' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_54c31b88371f05_24584573',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54c31b88371f05_24584573')) {function content_54c31b88371f05_24584573($_smarty_tpl) {?><?php if (!is_callable('smarty_modifier_truncate')) include 'D:\\wamp\\www\\red\\shoes\\tools\\smarty\\plugins\\modifier.truncate.php';
?><div id="color_block_left" class="block">
  <h4>Product reviews</h4>
  <div class="block_content">
  <a class="vert-car-nav prev"><span onclick="navCartPrev($(this))"><img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
np.png"></span></a>
  <div class="bd">
		<ul class="vertical-carousel" style="top: 0px;">
	  	<?php  $_smarty_tpl->tpl_vars['feedback'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['feedback']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['feedbacks']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['feedback']->key => $_smarty_tpl->tpl_vars['feedback']->value){
$_smarty_tpl->tpl_vars['feedback']->_loop = true;
?>
			<li>
				<div class="feedback_content"><?php echo $_smarty_tpl->tpl_vars['feedback']->value['feedback'];?>
</div>
				<div class="rate-history">
					<span class="rate-title">Rating:</span>
					<span class="star star-s" title="Star Rating: <?php echo $_smarty_tpl->tpl_vars['feedback']->value['rating'];?>
 out of 5"> 
						<span class="rate-percent" style="width: <?php echo $_smarty_tpl->tpl_vars['feedback']->value['rating']/5*100;?>
%;"></span>
					</span>
				</div>
				<p class="review-name"><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['feedback']->value['name'],50,"...");?>
<a href="<?php echo $_smarty_tpl->tpl_vars['feedback']->value['link'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['feedback']->value['name'];?>
"><strong>show more</strong></a></p>
			</li>
		<?php } ?>
		</ul>
  </div>
  </div>
</div>
<br/>
<?php }} ?>