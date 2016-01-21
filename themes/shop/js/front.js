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

	/**
	 * 删除购物车产品
	 */
	$(".cart_quantity_delete").click(function(){
		Cart.removeItem($(this).data("id"), $(this).parent().parent());
	})

	/**
	 * 增加购物车商品数量
	 */
	$(".td-quantity .plus").click(function(){
		if ($(this).hasClass("disable")) {
			return;
		}
		Cart.plusItem($(this).data("id"), $(this).parent().parent().parent().parent());
	})

	/**
	 * 减少购物车商品数量
	 */
	$(".td-quantity .minus").click(function(){
		if ($(this).hasClass("disable")) {
			return;
		}
		Cart.minusItem($(this).data("id"), $(this).parent().parent().parent().parent());
	})

	/**
	 * 全选按钮的class值为check-all，且必须设置data-name属性，其值为子选项的name值
	 * 例:<input type="checkbox" class="check-all" data-name="product[]">
	 * */
	$(".check-all").click(function(){
		var allCheck = $(this).prop("checked");
		$("input[name='"+$(this).data("name")+"']").each(function(){
			$(this).prop("checked",allCheck);
		})
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

/**
 * 购物车类，用于处理ajax购物车请求
 */
var Cart = {
	/**
	 * 删除购物车产品
	 * @param Int id 需要删除的id_cart_product
	 * @param Object e 调用该方法的tr行
	 */
	removeItem: function(id, e) {
		$.ajax({
			 url: ajax_dir,
			 cache: false,
			 data: "c=Cart&m=removeItem&id=" + id,
			 dataType: "json",
			 success: function(data) {
				 if (data.status == 'yes') {
					 e.remove();
					 $(".cart-block .badge").text(data.cart_quantity)
					 $(".cart-total-quantity").text(data.cart_quantity)
					 $(".cart-total").html(data.cart_total);
					 $(".basket-footer .total-price").html(data.cart_total);
				 }
			 }
		 });
	},
	/**
	 * 增加购物车商品数量
	 */
	minusItem: function(id, e) {
		$.ajax({
			url: ajax_dir,
			cache: false,
			data: "c=Cart&m=minusItem&id=" + id,
			dataType: "json",
			success: function(data) {
				if (data.status == 'yes') {
					if (data.item.quantity <= 1) {
						e.find(".td-quantity .minus").addClass("disable");
					}
					e.find(".td-total strong").html(data.item.total);
					e.find(".td-quantity input").val(data.item.quantity);
					$(".cart-block .badge").text(data.cart_quantity)
					$(".cart-total-quantity").text(data.cart_quantity)
					$(".cart-total").html(data.cart_total);
					$(".basket-footer .total-price").html(data.cart_total);
				}
			}
		});
	},
	/**
	 * 增加购物车商品数量
	 */
	plusItem: function(id, e) {
		$.ajax({
			url: ajax_dir,
			cache: false,
			data: "c=Cart&m=plusItem&id=" + id,
			dataType: "json",
			success: function(data) {
				if (data.status == 'yes') {
					if (data.item.quantity > 1) {
						if (e.find(".td-quantity .minus").hasClass('disable')) {
							e.find(".td-quantity .minus").removeClass('disable');
						}
					}
					e.find(".td-total strong").html(data.item.total);
					e.find(".td-quantity input").val(data.item.quantity);
					$(".cart-block .badge").text(data.cart_quantity)
					$(".cart-total-quantity").text(data.cart_quantity)
					$(".cart-total").html(data.cart_total);
					$(".basket-footer .total-price").html(data.cart_total);
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