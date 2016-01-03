$(document).ready(function(){
	if($("#left_columns").length>0){
		var leftHeight = $("#left_columns").css("height");
		var mainHeight = $("#main_columns_two").css("height");
		if(parseInt(leftHeight)>parseInt(mainHeight)){
			$("#main_columns_two").css("height",leftHeight);
		}
	}
	$(".memo-input").focus(function(){
		if($(this).hasClass("memo-close"))
			$(this).removeClass("memo-close")
	})
	$(".memo-input").blur(function(){
		if($(this).val().length==0)
			$(this).addClass("memo-close")				   
	})
	$(".memo-input").change(function(){
		if($(this).val().length>500){
			$("#information").find(".msg").removeClass("hidden");
			return false;
		}else{
			$("#information").find(".msg").addClass("hidden");
		}
	})
	$(".icon-info.tool").click(function(event){
		$(this).toggleClass("on");
		event.stopPropagation();
	})
	$(document).click(function (event) { $(".icon-info.tool").removeClass("on");});  
	$("#panier-promo-checkbox").click(function(){
		$(".panier-resume-bloc").toggleClass("hidden");
	})
	$(".skin-select .select-content").click(function(){
		$(this).removeAttr("style");
		$(this).parent().addClass("active");
	})
	$(".skin-select .sub-dd li").click(function(){
		var root = $(this).parent().parent().parent();
		var id	 = $(this).children("a").attr("rel");
		root.removeClass("active");
		root.children(".select-content").html($(this).children().html());
		root.children("select").val(id);
		root.children("select").trigger("change");
	})
	$(".shopping_cart_form_submit").change(function(){
		$(".shopping_cart_form").submit();
	})
	$("a.fav").click(function(){
		addWish($(this),$(this).attr("data-id"));
	})
})
function addWish(obj,id_product)
{
	$.ajax({
		url: ajax_dir,
		cache: false,
		data: "action=add_wish&id_product="+id_product,
		dataType: "json",
		success: function(data)
			{
				if(data.status=="YES"){
					if(data.action=="+"){
						obj.addClass("on")
					}else{
						obj.removeClass("on")
					}
					$(".likes .icon").html(data.count);
				}
			}
		}); 
}
function navCartPrev(obj)
{
	var nextBtn = obj.parent();
	var bdUl	= nextBtn.next().find("ul");
	var bdUltop	= parseInt(bdUl.css("top"));
	var newTop	= "0px";
	if(bdUltop>-1800){
		newTop	= (bdUltop-300)+'px';
	}
	bdUl.animate({top:newTop});
}
function qantityReduce(obj){
	var quantity_input = obj.next();
	if(quantity_input.val()>0)
		quantity_input.val(parseInt(quantity_input.val())-1)
}
function qantityAdd(obj){
	var quantity_input = obj.prev();
	quantity_input.val(parseInt(quantity_input.val())+1)
}
function callbackSliderChanged(args) {
	$(args.sliderContainerObject).next('.paging').children('.box').removeClass('selected');
	$(args.sliderContainerObject).next('.paging').children('.box:eq(' + (args.currentSlideNumber - 1) + ')').addClass('selected');
	
}

function callbackSliderLoadedChanged(args) {
	$(args.sliderContainerObject).next('.paging').children('.box').removeClass('selected');
	$(args.sliderContainerObject).next('.paging').children('.box:eq(' + (args.currentSlideNumber - 1) + ')').addClass('selected');
}
String.prototype.trim = function(){
	return this.replace(/(^\s*)|(\s*$)/g, "");
}
function checkRequiredInfo(id){
	var val = $("#"+id).val();
	if(val == null || val.trim() == ""){
		return false;
	}
	return true;
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

/**
 * hover 延时处理
 */
(function($){
	$.fn.hoverDelay = function(options){
		var defaults = {
			hoverDuring: 200,
			outDuring: 200,
			hoverEvent: function(){
				$.noop();
			},
			outEvent: function(){
				$.noop();
			}
		};
		var sets = $.extend(defaults,options || {});
		var hoverTimer, outTimer;
		return $(this).each(function(){
			$(this).hover(function(){
				clearTimeout(outTimer);
				hoverTimer = setTimeout(sets.hoverEvent, sets.hoverDuring);
			},function(){
				clearTimeout(hoverTimer);
				outTimer = setTimeout(sets.outEvent, sets.outDuring);
			});
		});
	}
})(jQuery);

/**
 * 提示标签
 */
$(function () {
	$('[data-toggle="tooltip"]').tooltip()
})