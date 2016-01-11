<?php /* Smarty version Smarty-3.1.12, created on 2016-01-11 16:10:16
         compiled from "D:\wamp\www\red\shoes\themes\shop\my-feedback.tpl" */ ?>
<?php /*%%SmartyHeaderCode:28965562e8a3407b33-71139097%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '792aafac7af14107de8b1257a4b8a28fbb12861f' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\themes\\shop\\my-feedback.tpl',
      1 => 1452499700,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '28965562e8a3407b33-71139097',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_5562e8a35c5b18_62366757',
  'variables' => 
  array (
    'DISPLAY_LEFT' => 0,
    'success' => 0,
    'products' => 0,
    'product' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5562e8a35c5b18_62366757')) {function content_5562e8a35c5b18_62366757($_smarty_tpl) {?><div class="container">
	<div class="row">
		<div class="col-md-2">
			<?php echo $_smarty_tpl->tpl_vars['DISPLAY_LEFT']->value;?>

		</div>
		<div class="col-md-10">
			<?php echo $_smarty_tpl->getSubTemplate (((string)$_smarty_tpl->tpl_vars['tpl_dir']->value)."./block/errors.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

			<?php if ($_smarty_tpl->tpl_vars['success']->value){?>
			<div class="success">Your feedback has been submitted, but you feedback information may not be displayed right away!</div>
			<?php }?>
			<h2>My Feedback</h2>
			<p style="padding-top:5px;margin:0px">
				<span class="signatureRequired">PLEASE NOTE: </span> Only pay successful products allowed to feedback.
			</p>
			<?php if (count($_smarty_tpl->tpl_vars['products']->value)>0){?>
			<div class="feedback-form">
			<form action="" method="post" name="form1">
				<div class="form-row form-rating-row">
					<label>Rating</label>
					<input type="radio" name="rating" value="1" <?php if (isset($_POST['rating'])&&$_POST['rating']==1){?>checked<?php }?>>
					<div class="feedback-star star-block">
						<ul class="rate txt-16">
						   <li><span class="icon-star"><span>1</span></span></li>
						   <li><span class="icon-star"><span>2</span></span></li>
						   <li><span class="icon-star"><span>3</span></span></li>
						   <li><span class="icon-star"><span>4</span></span></li>
						   <li><span class="icon-star"><span>5</span></span></li>
						</ul>
						<ul class="rate txt-16 active" style="width:20%">
						   <li><span class="icon-star"><span>1</span></span></li>
						   <li><span class="icon-star"><span>2</span></span></li>
						   <li><span class="icon-star"><span>3</span></span></li>
						   <li><span class="icon-star"><span>4</span></span></li>
						   <li><span class="icon-star"><span>5</span></span></li>
						</ul>
					</div>
					<input type="radio" name="rating" value="2" <?php if (isset($_POST['rating'])&&$_POST['rating']==2){?>checked<?php }?>>
					<div class="feedback-star star-block">
						<ul class="rate txt-16">
						   <li><span class="icon-star"><span>1</span></span></li>
						   <li><span class="icon-star"><span>2</span></span></li>
						   <li><span class="icon-star"><span>3</span></span></li>
						   <li><span class="icon-star"><span>4</span></span></li>
						   <li><span class="icon-star"><span>5</span></span></li>
						</ul>
						<ul class="rate txt-16 active" style="width:40%">
						   <li><span class="icon-star"><span>1</span></span></li>
						   <li><span class="icon-star"><span>2</span></span></li>
						   <li><span class="icon-star"><span>3</span></span></li>
						   <li><span class="icon-star"><span>4</span></span></li>
						   <li><span class="icon-star"><span>5</span></span></li>
						</ul>
					</div>
					<input type="radio" name="rating" value="3" <?php if (isset($_POST['rating'])&&$_POST['rating']==3){?>checked<?php }?>>
					<div class="feedback-star star-block">
						<ul class="rate txt-16">
						   <li><span class="icon-star"><span>1</span></span></li>
						   <li><span class="icon-star"><span>2</span></span></li>
						   <li><span class="icon-star"><span>3</span></span></li>
						   <li><span class="icon-star"><span>4</span></span></li>
						   <li><span class="icon-star"><span>5</span></span></li>
						</ul>
						<ul class="rate txt-16 active" style="width:60%">
						   <li><span class="icon-star"><span>1</span></span></li>
						   <li><span class="icon-star"><span>2</span></span></li>
						   <li><span class="icon-star"><span>3</span></span></li>
						   <li><span class="icon-star"><span>4</span></span></li>
						   <li><span class="icon-star"><span>5</span></span></li>
						</ul>
					</div>
					<input type="radio" name="rating" value="4" <?php if (isset($_POST['rating'])&&$_POST['rating']==4){?>checked<?php }?>>
					<div class="feedback-star star-block">
						<ul class="rate txt-16">
						   <li><span class="icon-star"><span>1</span></span></li>
						   <li><span class="icon-star"><span>2</span></span></li>
						   <li><span class="icon-star"><span>3</span></span></li>
						   <li><span class="icon-star"><span>4</span></span></li>
						   <li><span class="icon-star"><span>5</span></span></li>
						</ul>
						<ul class="rate txt-16 active" style="width:80%">
						   <li><span class="icon-star"><span>1</span></span></li>
						   <li><span class="icon-star"><span>2</span></span></li>
						   <li><span class="icon-star"><span>3</span></span></li>
						   <li><span class="icon-star"><span>4</span></span></li>
						   <li><span class="icon-star"><span>5</span></span></li>
						</ul>
					</div>
					<input type="radio" name="rating" value="5" <?php if (isset($_POST['rating'])&&$_POST['rating']==5){?>checked<?php }?>>
					<div class="feedback-star star-block">
						<ul class="rate txt-16">
						   <li><span class="icon-star"><span>1</span></span></li>
						   <li><span class="icon-star"><span>2</span></span></li>
						   <li><span class="icon-star"><span>3</span></span></li>
						   <li><span class="icon-star"><span>4</span></span></li>
						   <li><span class="icon-star"><span>5</span></span></li>
						</ul>
						<ul class="rate txt-16 active" style="width:100%">
						   <li><span class="icon-star"><span>1</span></span></li>
						   <li><span class="icon-star"><span>2</span></span></li>
						   <li><span class="icon-star"><span>3</span></span></li>
						   <li><span class="icon-star"><span>4</span></span></li>
						   <li><span class="icon-star"><span>5</span></span></li>
						</ul>
					</div>
				</div>
				<div class="form-row form-select-row">
					<label>Select Product</label>
					<select class="form-select" name="data">
					<?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['product']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['products']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value){
$_smarty_tpl->tpl_vars['product']->_loop = true;
?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['product']->value['data'];?>
" <?php if (isset($_POST['data'])&&$_POST['data']==$_smarty_tpl->tpl_vars['product']->value['data']){?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>
</option>
					<?php } ?>
					</select>
				</div>
				<div class="form-row form-textarea-row">
					<label>Feedback</label>
					<textarea name="feedback" cols="100" id="feedback" rows="5"><?php if (isset($_POST['feedback'])){?><?php echo $_POST['feedback'];?>
<?php }?></textarea>
				</div>
				<div class="form-row form-submit-row">
					<input type="submit" class="button big pink" value="Submit" name="submit" onclick="return formCheck()" >
				</div>
				</form>
			</div>
			<?php }else{ ?>
			<p>No product need feedback</p>
			<?php }?>
		</div>
	</div>
</div>
<script>

function formCheck(){
	var ratingNumber = parseInt($('input:radio:checked').val());
	if(isNaN(ratingNumber) || ratingNumber==0){
		alert('Pls rating!');
		return false;
	}
	return true;
}

</script><?php }} ?>