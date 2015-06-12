<?php /* Smarty version Smarty-3.1.12, created on 2015-05-26 11:01:15
         compiled from "D:\wamp\www\red\shoes\themes\shop\contact.tpl" */ ?>
<?php /*%%SmartyHeaderCode:926354ba0945d7b2f2-59199524%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '87eb5ad1d7788ed267a5f36c1d09665c1eeea81f' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\themes\\shop\\contact.tpl',
      1 => 1432609268,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '926354ba0945d7b2f2-59199524',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_54ba0945e24168_29018793',
  'variables' => 
  array (
    'link' => 0,
    'root_dir' => 0,
    'success' => 0,
    'logged' => 0,
    'tools_dir' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54ba0945e24168_29018793')) {function content_54ba0945e24168_29018793($_smarty_tpl) {?><div id="main_columns_two">
	<h3 class="subheading"><span class="whitebg">Contact Us</span></h3>
	<span class="formLabel">
		   <strong> We're here to help </strong>
	</span>
    <p class="comment-notes">Your satisfaction is important to us. Use the links below to email us your questions about online orders, returns & exchanges and more. </p>
	<br>
	<span class="formLabel"><strong> Order Questions </strong></span>
	<div class="show_url">
		<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('MyfeedbackView');?>
">How can I review my order?</a><br>
		<a href="<?php echo $_smarty_tpl->tpl_vars['link']->value->getPage('MyordersView');?>
">How can I track my package?</a><br>
	</div>
	<br><br>
	<span class="formLabel">
		   <strong>Other order questions</strong>
	</span>
  <div id="respond" class="respond" style="background:none; margin:0; padding:0;">
    <form id="commentform" method="post" action="<?php echo $_smarty_tpl->tpl_vars['root_dir']->value;?>
contact.html">
	  <?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./block/errors.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

	  <?php if ($_smarty_tpl->tpl_vars['success']->value){?><div class="success"><?php echo $_smarty_tpl->tpl_vars['success']->value;?>
</div><?php }?>
	  <?php if (!$_smarty_tpl->tpl_vars['logged']->value){?>
      <p class="comment-form-author">
        <label for="author">Name:</label>
        <input type="text" aria-required="true" size="30" value="<?php if (!$_smarty_tpl->tpl_vars['success']->value&&isset($_POST['name'])){?>$smarty.post.name<?php }?>" name="name" id="name">
      </p>
      <p class="comment-form-email">
        <label for="email">E-mail:</label>
        <input type="text" aria-required="true" size="30" value="<?php if (!$_smarty_tpl->tpl_vars['success']->value&&isset($_POST['email'])){?><?php echo $_POST['email'];?>
<?php }?>" name="email" id="email">
      </p>
	  <?php }?>
      <p class="comment-form-url">
        <label for="url">Title:</label>
        <input type="text" size="30" value="<?php if (!$_smarty_tpl->tpl_vars['success']->value&&isset($_POST['subject'])){?><?php echo $_POST['subject'];?>
<?php }?>" name="subject" id="subject">
      </p>
      <p class="comment-form-comment">
        <label for="comment">Enter your comments:</label>
        <textarea aria-required="true" rows="5" cols="45" name="content" id="content"><?php if (!$_smarty_tpl->tpl_vars['success']->value&&isset($_POST['content'])){?><?php echo $_POST['content'];?>
<?php }?></textarea>
      </p>
	  <p class="comment-form-validate_code">
        <label for="url">Enter Confirmation code:</label>
        <input type="text" size="8" value="" name="validate_code" id="validate_code">
		<img src="<?php echo $_smarty_tpl->tpl_vars['tools_dir']->value;?>
code/img.php" onclick="javascript:this.src='<?php echo $_smarty_tpl->tpl_vars['tools_dir']->value;?>
code/img.php?tm='+Math.random();" />
      </p>
      <p class="form-allowed-tags">You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: <code>&lt;a href="" title=""&gt; &lt;abbr title=""&gt; &lt;acronym title=""&gt; &lt;b&gt; &lt;blockquote cite=""&gt; &lt;cite&gt; &lt;code&gt; &lt;del datetime=""&gt; &lt;em&gt; &lt;i&gt; &lt;q cite=""&gt; &lt;strike&gt; &lt;strong&gt; </code></p>
      <p class="form-submit">
		<input type="submit" value="Send My Message" name="contactUs" id="contactUs" class="button pink">
      </p>
    </form>
  </div>
  <!-- #respond -->
</div><?php }} ?>