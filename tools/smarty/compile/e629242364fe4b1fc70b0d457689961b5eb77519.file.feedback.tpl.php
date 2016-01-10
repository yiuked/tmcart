<?php /* Smarty version Smarty-3.1.12, created on 2016-01-08 13:48:00
         compiled from "/Users/apple/Documents/httpd/red/shoes/themes/shop/block/feedback.tpl" */ ?>
<?php /*%%SmartyHeaderCode:399605257568f4d9093e4e3-78874485%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e629242364fe4b1fc70b0d457689961b5eb77519' => 
    array (
      0 => '/Users/apple/Documents/httpd/red/shoes/themes/shop/block/feedback.tpl',
      1 => 1452229588,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '399605257568f4d9093e4e3-78874485',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'feedback' => 0,
    'row' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_568f4d9099f6c1_86321259',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_568f4d9099f6c1_86321259')) {function content_568f4d9099f6c1_86321259($_smarty_tpl) {?><?php if ($_smarty_tpl->tpl_vars['feedback']->value['state']['times']>0){?>
<div id="transction-feedback">
	<div class="feedback-head">
	  <div class="f-rating">
		<dl class="rate-aver">
		  <dd class="star-view star-block">
			<ul class="rate txt-30">
			   <li><span class="icon-star"><span>1</span></span></li>
			   <li><span class="icon-star"><span>2</span></span></li>
			   <li><span class="icon-star"><span>3</span></span></li>
			   <li><span class="icon-star"><span>4</span></span></li>
			   <li><span class="icon-star"><span>5</span></span></li>
			</ul>
			<ul class="rate txt-30 active" style="width:<?php echo $_smarty_tpl->tpl_vars['feedback']->value['state']['total_pt'];?>
%">
			   <li><span class="icon-star"><span>1</span></span></li>
			   <li><span class="icon-star"><span>2</span></span></li>
			   <li><span class="icon-star"><span>3</span></span></li>
			   <li><span class="icon-star"><span>4</span></span></li>
			   <li><span class="icon-star"><span>5</span></span></li>
			</ul>
		  </dd>
		  <dt>Average Star Rating:<br>
		  <span class="fwB"><b class="c-org"><?php echo $_smarty_tpl->tpl_vars['feedback']->value['state']['average'];?>
</b> out of 5(<?php echo $_smarty_tpl->tpl_vars['feedback']->value['state']['times'];?>
 Ratings)</span></dt>
		</dl>
	  </div>
	  <div class="f-rating-more">
		<div class="legend">Feedback Rating for This Product</div>
		<table class="rate-data">
		  <tbody>
			<tr>
			  <td rowspan="2"><b>Positive</b> (<?php echo $_smarty_tpl->tpl_vars['feedback']->value['state']['five_pt']+$_smarty_tpl->tpl_vars['feedback']->value['state']['four_pt'];?>
%)</td>
			  <td><span class="left">5 Stars (<?php echo $_smarty_tpl->tpl_vars['feedback']->value['state']['five_star'];?>
)</span>
				<div class="ratebar ratebar-s"><span style="width:<?php echo $_smarty_tpl->tpl_vars['feedback']->value['state']['five_pt'];?>
%;"></span></div></td>
			</tr>
			<tr>
			  <td><span class="left">4 Stars (<?php echo $_smarty_tpl->tpl_vars['feedback']->value['state']['four_star'];?>
) </span>
				<div class="ratebar ratebar-s"><span style="width:<?php echo $_smarty_tpl->tpl_vars['feedback']->value['state']['four_pt'];?>
%;"></span></div></td>
			</tr>
			<tr>
			  <td><b>Neutral</b> (<?php echo $_smarty_tpl->tpl_vars['feedback']->value['state']['three_pt'];?>
%) </td>
			  <td><span class="left">3 Stars (<?php echo $_smarty_tpl->tpl_vars['feedback']->value['state']['three_star'];?>
) </span>
				<div class="ratebar ratebar-s"><span style="width:<?php echo $_smarty_tpl->tpl_vars['feedback']->value['state']['three_pt'];?>
%;"></span></div></td>
			</tr>
			<tr>
			  <td rowspan="2"><b>Negative</b> (<?php echo $_smarty_tpl->tpl_vars['feedback']->value['state']['one_pt']+$_smarty_tpl->tpl_vars['feedback']->value['state']['two_pt'];?>
)</td>
			  <td><span class="left">2 Stars (<?php echo $_smarty_tpl->tpl_vars['feedback']->value['state']['two_star'];?>
) </span>
				<div class="ratebar ratebar-s"><span style="width:<?php echo $_smarty_tpl->tpl_vars['feedback']->value['state']['two_pt'];?>
%;"></span></div></td>
			</tr>
			<tr>
			  <td><span class="left">1 Stars (<?php echo $_smarty_tpl->tpl_vars['feedback']->value['state']['one_star'];?>
) </span>
				<div class="ratebar ratebar-s"><span style="width:<?php echo $_smarty_tpl->tpl_vars['feedback']->value['state']['one_pt'];?>
%;"></span></div></td>
			</tr>
		  </tbody>
		</table>
	  </div>
	  <div class="note"><span class="t">Note:</span><span class="c">All information displayed is based on feedback received for this product over the past 6 months.</span></div>
	  <div class="clear"></div>
	</div>
	<div class="rating-detail">
		<table width="100%" class="rating-table widthfixed">
		  <thead>
			<tr>
			  <th class="th3">Buyer</th>
			  <th class="th2">Transaction Details</th>
			  <th class="th4">Feedback</th>
			</tr>
		  </thead>
		  <tbody>
		  <?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['row']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['feedback']->value['rows']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
$_smarty_tpl->tpl_vars['row']->_loop = true;
?>
			<tr>
			  <td class="td3"><span memberid="138132537" class="name vip-level"> <?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
. </span> <span class="state"><b class="css_flag css_<?php echo $_smarty_tpl->tpl_vars['row']->value['flag_code'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['row']->value['flag_code'];?>
"></b></span></td>
			  <td class="td4"><br>
				<div class="total-price"> <span class="price">US <?php echo Tools::displayPriceSmarty(array('price'=>$_smarty_tpl->tpl_vars['row']->value['unit_price']),$_smarty_tpl);?>
 </span> x <span><?php echo $_smarty_tpl->tpl_vars['row']->value['quantity'];?>
 piece</span> </div></td>
			  <td class="td2">
			  	<div class="feedback-star star-block">
					<ul class="rate txt-16">
					   <li><span class="icon-star"><span>1</span></span></li>
					   <li><span class="icon-star"><span>2</span></span></li>
					   <li><span class="icon-star"><span>3</span></span></li>
					   <li><span class="icon-star"><span>4</span></span></li>
					   <li><span class="icon-star"><span>5</span></span></li>
					</ul>
					<ul class="rate txt-16 active" style="width:<?php echo $_smarty_tpl->tpl_vars['row']->value['rating']/5*100;?>
%">
					   <li><span class="icon-star"><span>1</span></span></li>
					   <li><span class="icon-star"><span>2</span></span></li>
					   <li><span class="icon-star"><span>3</span></span></li>
					   <li><span class="icon-star"><span>4</span></span></li>
					   <li><span class="icon-star"><span>5</span></span></li>
					</ul>
				</div>
				<div class="feedback-date"><?php echo $_smarty_tpl->tpl_vars['row']->value['add_date'];?>
</div>
				<div class="feedback"> <span><?php echo $_smarty_tpl->tpl_vars['row']->value['feedback'];?>
</span> </div>
			  </td>
			</tr>
		  <?php } ?>
		  </tbody>
		</table>
	</div>
</div>
<?php }else{ ?>
<div class="no-feedback">No&nbsp;Feedback.</div>
<?php }?><?php }} ?>