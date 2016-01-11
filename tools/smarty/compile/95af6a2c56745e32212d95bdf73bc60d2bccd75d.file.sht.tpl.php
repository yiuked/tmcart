<?php /* Smarty version Smarty-3.1.12, created on 2016-01-11 12:37:21
         compiled from "D:\wamp\www\red\shoes\modules\payment\sht\sht.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1282454b8df8fe25946-28122168%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '95af6a2c56745e32212d95bdf73bc60d2bccd75d' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\modules\\payment\\sht\\sht.tpl',
      1 => 1452476964,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1282454b8df8fe25946-28122168',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_54b8df90066bd0_39424115',
  'variables' => 
  array (
    'paymentid' => 0,
    'module_dir' => 0,
    'address' => 0,
    'user_email' => 0,
    'countrys' => 0,
    'country' => 0,
    'img_dir' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_54b8df90066bd0_39424115')) {function content_54b8df90066bd0_39424115($_smarty_tpl) {?><div class="tab">
<input type="radio" checked="" name="tabs-1" id="credit_card">
<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['paymentid']->value;?>
" name="paymentid" id="paymentid" />
<label class="tab_label" for="credit_card"><img src="<?php echo $_smarty_tpl->tpl_vars['module_dir']->value;?>
visa.gif" alt="visa"></label>
<div class="tab_panel">
  <div class="tab_content">
	<h3 id="autopayheader"> Make Payment With Visa Credit Card </h3>
	<div class="sectioncontent">
	  <form id="cc_form" method="POST">
		<table class="tableform floatr" style="width:50%">
			<tr>
			  <td><label for="cc_name">Billing First Name</label>
				<input type="text" autocomplete="off" value="<?php echo $_smarty_tpl->tpl_vars['address']->value->first_name;?>
" name="firstname" id="firstname" onblur="checkFirstName();">
			  </td>
			  <td><label for="cc_address">Billing Last Name</label>
				<input type="text" value="<?php echo $_smarty_tpl->tpl_vars['address']->value->last_name;?>
" name="lastname" id="lastname" onblur="checkLastName();">
			  </td>
			</tr>
			<tr>
			  <td><label for="cc_name">Email</label>
				<input type="text" autocomplete="off" value="<?php echo $_smarty_tpl->tpl_vars['user_email']->value;?>
" name="email" id="email" onblur="checkEmail();">
			  </td>
			  <td><label for="cc_address">Billing Address</label>
				<input type="text" value="<?php echo $_smarty_tpl->tpl_vars['address']->value->address;?>
 <?php echo $_smarty_tpl->tpl_vars['address']->value->address2;?>
" name="address" id="address" onblur="checkAddress();">
			  </td>
			</tr>
			<tr>
			  <td><label for="cc_zip">Billing City</label>
				<input type="text" value="<?php echo $_smarty_tpl->tpl_vars['address']->value->city;?>
" name="city" id="city" onblur="checkCity();">
			  </td>
			  <td><label for="cc_zip">Billing Postal Code</label>
				<input type="text" value="<?php echo $_smarty_tpl->tpl_vars['address']->value->postcode;?>
" name="zipcode" id="zipcode" onblur="checkZipCode();">
			  </td>
			</tr>
			<tr>
			  <td><label for="cc_cscv">Billing State<span class="txt-14">(optional)</span></label>
				<input type="text" value="<?php if ($_smarty_tpl->tpl_vars['address']->value->country->need_state){?> <?php echo $_smarty_tpl->tpl_vars['address']->value->state->name;?>
<?php }?>" name="state" id="state">
			  </td>
			  <td><label for="cc_cscv">Billing Phone</label>
				<input type="text" value="<?php if ($_smarty_tpl->tpl_vars['address']->value->phone){?> <?php echo $_smarty_tpl->tpl_vars['address']->value->phone;?>
<?php }?>" name="phone" id="phone" onblur="checkPhone();"></td>
			</tr>
			<tr>
			  <td colspan="2"><label for="cc_country" style="display:block;">Billing Country</label>
				<select tabindex="" name="country" onchange="checkCountry();" id="country">
				  <?php  $_smarty_tpl->tpl_vars['country'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['country']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['countrys']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['country']->key => $_smarty_tpl->tpl_vars['country']->value){
$_smarty_tpl->tpl_vars['country']->_loop = true;
?>
				  <?php if ($_smarty_tpl->tpl_vars['country']->value==''){?>
				  <option value="">----------</option>
				  <?php }else{ ?>
				  <option value="<?php echo $_smarty_tpl->tpl_vars['country']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['address']->value->country->name==$_smarty_tpl->tpl_vars['country']->value){?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['country']->value;?>
</option>
				  <?php }?>
				  <?php } ?>
				</select>
			  </td>
			</tr>
		</table>
		<table class="tableform floatl" style="width:50%">
			<tr>
			  <td><label for="cc_number">Card Number</label>
				<input type="text" autocomplete="off" value="" name="cardnum" id="cardnum" maxlength="16"  onblur="checkCardNum();">
			  </td>
			  <td></td>
			</tr>
			<tr>
			  <td><label for="cc_mm" style="display:block;">Expiration Date</label>
				 <select id="month" name="month" onblur="checkCMDate()" style="width:80px; min-width:80px; display:inline;">
					<option value="">MM</option>
					<option value="01">01</option>
					<option value="02">02</option>
					<option value="03">03</option>
					<option value="04">04</option>
					<option value="05">05</option>
					<option value="06">06</option>
					<option value="07">07</option>
					<option value="08">08</option>
					<option value="09">09</option>
					<option value="10">10</option>
					<option value="11">11</option>
					<option value="12">12</option>
				</select>
				<select id="year" name="year" onblur="checkCYDate()" style="width:100px; min-width:100px;display:inline;">
					<option value="">YYYY</option>
					<option value="2015">2015</option>
					<option value="2016">2016</option>
					<option value="2017">2017</option>
					<option value="2018">2018</option>
					<option value="2019">2019</option>
					<option value="2020">2020</option>
					<option value="2021">2021</option>
					<option value="2022">2022</option>
					<option value="2023">2023</option>
					<option value="2024">2024</option>
					<option value="2025">2025</option>
					<option value="2026">2026</option>
					<option value="2027">2027</option>
					<option value="2028">2028</option>
					<option value="2029">2029</option>
					<option value="2030">2030</option>
					<option value="2031">2031</option>
				</select>
			  </td>
			  <td></td>
			</tr>
			<tr>
			  <td><label for="cc_cscv">Security Code</label>
				<input type="password" value="" name="cvv2" id="cvv2" onblur="checkCvv2();" style="width:100px; min-width:100px;display: inline;" maxlength="3">
				<i class="icon-info tool"> <span class="tip pos-b-l"><span><img src="<?php echo $_smarty_tpl->tpl_vars['module_dir']->value;?>
cvv_demo.gif" alt="cvv demo"></span></span></i>
				<input type="checkbox" value="0" id="codeHandle" onclick="showSecurityCode()" style="width:20px; min-width:20px;display: inline;"><span style="color:#949494; font-weight:normal;">Show security Code</span>
			  </td>
			  <td></td>
			</tr>
			<tr>
			  <td><label for="cc_cscv">IssuingBank</label>
				<input type="text" value="" name="cardbank" id="cardbank" onblur="checkCardBank();">
			  </td>
			  <td></td>
			</tr>
			<tr>
				<td colspan="2" id="paystatus">
					<p class="loader hidden"><img src="<?php echo $_smarty_tpl->tpl_vars['img_dir']->value;?>
loader.gif"></p>
					<p class="warring icon-cancel-2 hidden"></p>
					<p class="conf icon-checkmark hidden"></p>
				</td>
			</tr>
			<tr><td colspan="2">
				<p class="panier-send panier-send-bottom clear">
					<a class="form-send dbl button big east pink check_out" href="javascript:void(0)" title="Order" id="checkoutCheck">
						   <span>Pay <span class="secure">(<span>100% secured payment</span>)</span></span>
					 </a>
				</p>
			</td></tr>
		</table>
	  </form>
	</div>
  </div>
</div>
</div>
<script type="text/javascript">
var ajaxUrl = "<?php echo $_smarty_tpl->tpl_vars['module_dir']->value;?>
pay.php";

function setError(id, isOK){
	var obj = $("#"+id);
	if(obj == undefined){
		alert(id);
	}
	if(isOK)
		obj.css("border-color","#cccccc");
	else
		obj.css("border-color","red");
}
function checkCardNum(){
	var cardnum = $("#cardnum").val();
	var cardPattern = /^\d{13,}$/;

	if(cardPattern.test(cardnum) && chkCardNum(cardnum)){
		setError('cardnum', true);
		return true;
	}else{
		setError('cardnum', false);
		return false;
	}
}
function checkCMDate(){
	var flag = checkRequiredInfo('month');
	setError('month', flag);
	return flag;
}
function checkCYDate(){
	var flag = checkRequiredInfo('year');
	setError('year', flag);
	return flag;
}
function checkCvv2(){
	var cvv2 = $('#cvv2').val();
	if(cvv2.trim() == ""){
		setError('cvv2', false);
		return false;
	}
	if(/^\d{3}$/.test(cvv2)){
		setError('cvv2', true);
		return true;
	}else{
		setError('cvv2', false);
		return false;
	}
}
function checkCardBank(){
	var flag = checkRequiredInfo('cardbank');
	setError('cardbank', flag);
	return flag;
}
function checkFirstName(){
	var flag = checkRequiredInfo('firstname');
	setError('firstname', flag);
	return flag;
}
function checkLastName(){
	var flag = checkRequiredInfo('lastname');
	setError('lastname', flag);
	return flag;
}
function checkEmail(){
	var email = $("#email").val();
	var myReg = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/
	var flag = myReg.test(email);
	setError("email", flag);
	return flag;
}
function checkPhone(){
	var flag = checkRequiredInfo('phone');
	setError('phone', flag);
	return flag;  
}
function checkZipCode(){
	var flag = checkRequiredInfo('zipcode');
	setError('zipcode', flag);
	return flag;
}

function checkAddress(){
	var flag = checkRequiredInfo('address');
	setError('address', flag);
	return flag;
}
function checkCity(){
	var flag = checkRequiredInfo('city');
	setError('city', flag);
	return flag;
}
function checkCountry(){
	var flag = checkRequiredInfo('country');
	setError('country', flag);
	return flag;
}
function checkoutCheck()
{
	var a = checkCardNum();
	var b = checkCMDate();
	var c = checkCYDate();
	var d = checkCvv2();
	var e = checkCardBank();
	var f = checkFirstName();
	var g = checkLastName();
	var h = checkEmail();
	var i = checkPhone();
	var j = checkZipCode();
	var k = checkAddress();
	var m = checkCity();
	var l = checkCountry();
	if(a && b && c && d && e && f && g && h && i && j && k && m && l){
		$('#checkoutCheck').unbind('click');
		$('#checkoutCheck').removeClass('pink');
		$("#paystatus .loader").removeClass("hidden");
		$("#paystatus .warring").addClass("hidden");
		$.ajax({
		url: ajaxUrl,
		cache: false,
		type:'post', 
		data: {
				validateCreditCard:"connect",
				cardnum:$("#cardnum").val(),
				year:$("#year").val(),
				month:$("#month").val(),
				cvv2:$("#cvv2").val(),
				email:$("#email").val(),
				cardbank:$("#cardbank").val(),
				firstname:$("#firstname").val(),
				lastname:$("#lastname").val(),
				address:$("#address").val(),
				city:$("#city").val(),
				zipcode:$("#zipcode").val(),
				state:$("#state").val(),
				country:$("#country").val(),
				phone:$("#phone").val(),
				paymentid:$("#paymentid").val(),
	    },  
		dataType: "json",
		success: function(data)
			{
				$("#paystatus .loader").addClass("hidden");
				if(data.isError=="YES"){
					$('#checkoutCheck').addClass('pink');
					$('#checkoutCheck').bind('click', function() {
						   checkoutCheck();
					});
					$("#paystatus .warring").text(data.msg);
					$("#paystatus .warring").removeClass("hidden");
				}else{
					$("#paystatus .conf").html(data.msg);
					$("#paystatus .conf").removeClass("hidden");
					var timer = setTimeout(function(){
						location.href=data.redirct;
					}, 3000);
				}
			}
		});
	}
}
function showSecurityCode()
{	
	var cvv2Type = $("#cvv2").attr("type");
	if(cvv2Type=="password"){
		$("#cvv2").replaceWith('<input type="text" value="'+$("#cvv2").val()+'" name="cvv2" id="cvv2" onblur="checkCvv2();" maxlength="3" style="width:100px; min-width:100px;display: inline;">');
	}else{
		$("#cvv2").replaceWith('<input type="password" value="'+$("#cvv2").val()+'" name="cvv2" id="cvv2" onblur="checkCvv2();" maxlength="3" style="width:100px; min-width:100px;display: inline;">');
	}
}
$(document).ready(function(){
	$('#checkoutCheck').bind('click', function() {
		   checkoutCheck();
	});
})

</script><?php }} ?>