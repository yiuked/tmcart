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
	$(".cart_quantity_delete").click(function(){
		Cart.removeItem($(this).data("id"), $(this));
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
var Cart = {
	removeItem: function(id, e){
		$.ajax({
			 url: ajax_dir,
			 cache: false,
			 data: "c=Cart&m=removeItem&id=" + id,
			 dataType: "json",
			 success: function(data) {
				 if (data.status == 'yes') {
					 e.parent().parent().remove();
					 $(".cart-block .badge").text(data.cart_quantity)
					 $(".cart-total-quantity").text(data.cart_quantity)
					 $(".cart-total").html(data.cart_total);
				 }
			 }
		 });
	}
};
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