<?php /* Smarty version Smarty-3.1.12, created on 2016-01-11 11:42:25
         compiled from "D:\wamp\www\red\shoes\modules\payment\neworder\payment.tpl" */ ?>
<?php /*%%SmartyHeaderCode:143955c4148fd5f3a6-08464295%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '570ab69f2ab68321b25f857eb9c6d006701ad907' => 
    array (
      0 => 'D:\\wamp\\www\\red\\shoes\\modules\\payment\\neworder\\payment.tpl',
      1 => 1452476964,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '143955c4148fd5f3a6-08464295',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.12',
  'unifunc' => 'content_55c4148fdf8ea9_65299716',
  'variables' => 
  array (
    'paymentid' => 0,
    'module_dir' => 0,
    'cardInputType' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_55c4148fdf8ea9_65299716')) {function content_55c4148fdf8ea9_65299716($_smarty_tpl) {?><div class="tab">
<input type="radio" checked="" name="tabs-1" id="credit_card">
<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['paymentid']->value;?>
" name="paymentid" id="paymentid" />
<label class="tab_label" for="credit_card"><img src="<?php echo $_smarty_tpl->tpl_vars['module_dir']->value;?>
images/logo.png" alt="Visa Card Or Master Card Or JCB Card"></label>
<div class="tab_panel">
  <div class="tab_content">
	<h3 id="autopayheader"> Make Payment With Credit Card </h3>
	<div class="sectioncontent">
		<div class="error" id="create_account_error" style="display:none;margin: 0 0 10px 0;padding: 10px;border: 1px solid #990000;font-size: 13px;
			background: #ffcccc;">
                <ol><li id="create_account_error_msg"></li></ol>
			</div>
		<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['module_dir']->value;?>
"  id="iconPath" />
	<fieldset>
		<table class="tableform" style="width: 49%;padding: 15px 10px;">
			<tr>
				<td style="padding: 10px;">
						<label for="cc_number">Card Number</label>
						<input  type="<?php echo $_smarty_tpl->tpl_vars['cardInputType']->value;?>
" name="neworder_cardNo" value="" id="neworder_cardNo"  maxlength="16"
								   onkeyup="this.value=this.value.replace(/\D/g,''); checkCardType(this,'<?php echo $_smarty_tpl->tpl_vars['module_dir']->value;?>
');"
								   style='background-image:url("<?php echo $_smarty_tpl->tpl_vars['module_dir']->value;?>
images/vmj.png");background-position:right center;background-repeat:no-repeat;
								   padding: 0px 5px;height: 27px;width: 220px;border: 1px solid #CCC;color: #666;background-color: #FFF;margin: 0px;'
								   />
				</td>
			</tr>
			<tr>
				<td style="padding: 10px;"><label for="cc_cscv">Security Code</label>
				<input type="password" value="" name="neworder_cardSecurityCode" id="neworder_cardSecurityCode" style="width:100px;min-width:100px;display: inline;" maxlength="4"  onpate="return false" oncopy="return false">
				<i class="icon-info tool"><span class="tip pos-b-l"><span><img src="<?php echo $_smarty_tpl->tpl_vars['module_dir']->value;?>
images/cvv_demo.gif" alt="cvv demo"></span></span></i>
				<input type="checkbox" value="0" id="codeHandle" onclick="showSecurityCode()" style="width:20px; min-width:20px;display: inline;"><span style="color:#949494; font-weight:normal;">Show security Code</span>
			  </td>
			</tr>	
			<tr>
				<td  style="padding: 10px;">
				<label  style="float:none;" for="neworder_cardExpireMonthSpan">Expiration Date</label>
					<select name="neworder_cardExpireMonth" id="neworder_cardExpireMonth" style="margin: 0px;border: 1px solid #BBBBBB;
					min-height:30px;font: 12px/20px Verdana;color: #666666;min-width:70px;">
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
					<select name="neworder_cardExpireYear"  id="neworder_cardExpireYear" style="margin: 0px;border: 1px solid #BBBBBB;min-width:70px;
					min-height:30px;font: 12px/20px Verdana;color: #666666;">
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
			
			</tr>
			<tr>
				<td colspan="2" id="currenstatus">
					<p class="loader hidden"><img src="<?php echo $_smarty_tpl->tpl_vars['module_dir']->value;?>
images/loader.gif"></p>
					<p class="error hidden"></p>
					<p class="success hidden"></p>
				</td>
			</tr>
			<tr>
				<td  style="padding: 10px;">
				<p class="panier-send panier-send-bottom clear">
					<a class="form-send dbl button big east pink check_out" href="javascript:void(0)" title="Order" id="checkoutCheck">
						   <span>Pay <span class="secure">(<span>100% secured payment</span>)</span></span>
					 </a>
				</p>
		</td>
			</tr>
			<tr>
				<td  style="padding: 10px;">
				<img src="<?php echo $_smarty_tpl->tpl_vars['module_dir']->value;?>
images/certservices.png" alt="CVV2/CSC"/>
				</td>
			</tr>
			</table>
	</fieldset>
	</div>
  </div>
</div>
</div>


<script language="javascript">
var ajaxUrl = "<?php echo $_smarty_tpl->tpl_vars['module_dir']->value;?>
payment.php";

function trim(str){
	return str.replace(/[ ]/g,"");
}
function CardpaySubmit(){
	if(!checkCardNum(trim($("#neworder_cardNo").val()))){
	    $("#neworder_cardNo").focus();
		$("#neworder_cardNo").css("border-color","red");
	    return false;
	}
	$("#neworder_cardNo").css("border-color","#cccccc");
	
	if(!checkCvv(trim($("#neworder_cardSecurityCode").val()))){
	    $("#neworder_cardSecurityCode").focus();
	    $("#neworder_cardSecurityCode").css("border-color","red");
	    return false;
	}
	$("#neworder_cardSecurityCode").css("border-color","#cccccc");

	if(!checkExpdate($("#neworder_cardExpireMonth").val())){
	    $("#neworder_cardExpireMonth").focus();
	    $("#neworder_cardExpireMonth").css("border-color","red");
	    return false;
	}
	$("#neworder_cardExpireMonth").css("border-color","#cccccc");

	if(!checkExpdate($("#neworder_cardExpireYear").val())){
	    $("#neworder_cardExpireYear").focus();
		$("#neworder_cardExpireYear").css("border-color","red");
	    return false;
	}
	$("#neworder_cardExpireYear").css("border-color","#cccccc");

	VlidataTrueContinue();
}

//number
function checkCardNum(cardNumber) {
	if(cardNumber == null || cardNumber == "" || cardNumber.length > 16 || cardNumber.length < 13) {
	    return false;
	}else if(cardNumber.charAt(0) != 3 && cardNumber.charAt(0) != 4 && cardNumber.charAt(0) != 5){
	    return false;
	}else if( cardNumber.charAt(0) == 4 || cardNumber.charAt(0) == 5){
	    return chkCardNum(cardNumber);
	}else {
	    return true;
	}
}

//expdate
function checkExpdate(expdate) {
	if(expdate == null || expdate == "" || expdate.length < 1) {
	    return false;
	}else {
	    return true;
	}
}
//validate CVV
function checkCvv(cvv) {
	if(cvv == null || cvv =="" || cvv.length < 3 || cvv.length > 4 || isNaN(cvv) || !(/^\d{3,4}$/.test(cvv))) {
	    return false;
	}else {
	    return true;
	}
}

function checkCardType(input,path) {  
	var creditcardnumber = input.value;    
	var cardtype = '';

	if (creditcardnumber.length < 2) {
		input.style.backgroundImage='url('+path+'images/vmj.png)';
	}
	else {        
		switch (creditcardnumber.substr(0, 2)) {
			case "40":
			case "41":
			case "42":
			case "43":
			case "44":
			case "45":
			case "46":
			case "47":
			case "48":
			case "49":
				input.style.backgroundImage='url('+path+'images/visa.png)';                
				cardtype= "V";
				break;
			case "51":
			case "52":
			case "53":
			case "54":
			case "55":
				input.style.backgroundImage='url('+path+'images/mastercard.png)'; 
				cardtype = "M";
				break;
			case "35":
				input.style.backgroundImage='url('+path+'images/jcb.png)';
				cardtype = "J";
				break;
			case "34":
			case "37":                            
				cardtype = "A";
				break;
			case "30":
			case "36":
			case "38":
			case "39":
			case "60":
			case "64":
			case "65":                
				cardtype = "D";
				break;
			default:cardtype = "";
		}
	}
}

function VlidataTrueContinue()
{
	$('#checkoutCheck').unbind('click');
	$('#checkoutCheck').removeClass('pink');
	$("#currenstatus .loader").removeClass("hidden");
	$("#currenstatus .error").addClass("hidden");
	$.ajax({
	url: ajaxUrl,
	cache: false,
	type:'post', 
	data: {
			validateCreditCard:"connect",
			neworder_cardNo:$("#neworder_cardNo").val(),
			neworder_cardSecurityCode:$("#neworder_cardSecurityCode").val(),
			neworder_cardExpireMonth:$("#neworder_cardExpireMonth").val(),
			neworder_cardExpireYear:$("#neworder_cardExpireYear").val(),
			neworder_paymentid:$("#paymentid").val(),
	},  
	dataType: "json",
	success: function(data)
		{
			$("#currenstatus .loader").addClass("hidden");
			if(data.isError=="YES"){
				$("#currenstatus .error").text(data.msg);
				$("#currenstatus .error").removeClass("hidden");
				$('#checkoutCheck').addClass('pink');
				$('#checkoutCheck').bind('click', function() {
					   CardpaySubmit();
				});
			}else{
				$("#currenstatus .success").html(data.msg);
				$("#currenstatus .success").removeClass("hidden");
				var timer = setTimeout(function(){
					location.href=data.redirct;
				}, 3000);
			}
		}
	});
}

$(document).ready(function(){
	$(".icon-info .icon").click(function(){
		$(".tip").toggle();
	});
	$('#checkoutCheck').bind('click', function() {
		CardpaySubmit();
	});
});
function showSecurityCode()
{	
	var cvv2Type = $("#neworder_cardSecurityCode").attr("type");
	if(cvv2Type=="password"){
		$("#neworder_cardSecurityCode").replaceWith('<input type="text" value="'+$("#neworder_cardSecurityCode").val()+'" id="neworder_cardSecurityCode" oncopy="return false" onpate="return false" name="neworder_cardSecurityCode" maxlength="4" style="width:100px;min-width:100px;display: inline;">');
	}else{
		$("#neworder_cardSecurityCode").replaceWith('<input type="password" value="'+$("#neworder_cardSecurityCode").val()+'" id="neworder_cardSecurityCode" oncopy="return false" onpate="return false" name="neworder_cardSecurityCode" maxlength="4" style="width:100px;min-width:100px;display: inline;">');
	}
}

/*******************************
**validatevisa or master 
**argas cdi：need validate card
**eg：chkCardNum('4032 9835 3025 2122') return true or false
*******************************/
function chkCardNum(cdi) {
    if (cdi != "" && cdi != null) {
        var cf = sbtString(cdi, " -/abcdefghijklmnopqrstuvwyzABCDEFGHIJLMNOPQRSTUVWYZ|\#()[]{}?%&=!?+*.,;:'");
        var cn = "";
        var clcd = chkLCD(cf);
        var ccck = chkCCCksum(cf, cn);
        var cjd = "INVALID CARD NUMBER"; if (clcd && ccck) { cjd = "This card number appears to be valid."; }
        if (clcd && ccck) {
            return true;
        }
        else {
            return false;
        }
    }
}

function chkCCCksum(cf, cn) {
    var r = false;
    var w = "21";
    var ml = "";
    var j = 1;
    for (var i = 1; i <= cf.length - 1; i++) {
        var m = midS(cf, i, 1) * midS(w, j, 1);
        m = sumDigits(m);
        ml += "" + m;
        j++; if (j > w.length) { j = 1; }
    }
    var ml2 = sumDigits(ml, -1);
    var ml1 = (sumDigits(ml2, -1) * 10 - ml2) % 10;
    if (ml1 == rightS(cf, 1)) { r = true; }
    return r;
}

function chkLCD(cf) {
    var r = false; cf += "";
    var bl = isdiv(cf.length, 2);
    var ctd = 0;
    for (var i = 1; i <= cf.length; i++) {
        var cdg = midS(cf, i, 1);
        if (isdiv(i, 2) != bl) {
            cdg *= 2; if (cdg > 9) { cdg -= 9; }
        }
        ctd += cdg * 1.0;
    }
    if (isdiv(ctd, 10)) { r = true; }
    return r;
}

function rightS(aS, n) {
    aS += "";
    var rS = "";
    if (n >= 1) {
        rS = aS.substring(aS.length - n, aS.length);
    }
    return rS;
}

function midS(aS, n, n2) {
    aS += "";
    var rS = "";
    if (n2 == null || n2 == "") { n2 = aS.length; }
    n *= 1; n2 *= 1;
    if (n < 0) { n++; }
    rS = aS.substring(n - 1, n - 1 + n2);
    return rS;
}

function sbtString(s1, s2) {
    var ous = ""; s1 += ""; s2 += "";
    for (var i = 1; i <= s1.length; i++) {
        var c1 = s1.substring(i - 1, i);
        var c2 = s2.indexOf(c1);
        if (c2 == -1) { ous += c1; }
    }
    return ous;
}


function isdiv(a, b) {
    if (b == null) { b = 2; }
    a *= 1.0; b *= 1.0;
    var r = false;
    if (a / b == Math.floor(a / b)) { r = true; }
    return r;
}

function sumDigits(n, m) {
    if (m == 0 || m == null) { m = 1; }
    n += "";
    if (m > 0) {
        while (n.length > m) {
            var r = 0;
            for (var i = 1; i <= n.length; i++) {
                r += 1.0 * midS(n, i, 1);
            }
            n = "" + r;
        }
    } else {
        for (var j = 1; j <= Math.abs(m); j++) {
            var r = 0;
            for (var i = 1; i <= n.length; i++) {
                r += 1.0 * midS(n, i, 1);
            }
            n = "" + r;
        }
    }
    r = n;
    return r;
}
/*end*/

</script>
<?php }} ?>