function displayImage(domAAroundImgThumb)
{
    if (domAAroundImgThumb.attr('href'))
    {
        var newSrc = domAAroundImgThumb.attr('href').replace('thickbox','large');
        if ($('#bigpic').attr('src') != newSrc)
        {
			$('#bigpic').attr('src', newSrc).show();
        }
        $('.slider-style-thumbs a').removeClass('shown');
        $(domAAroundImgThumb).addClass('shown');
    }
}

function PreviewImg(imgFile){
	var slider ='<section class="iosSlider full-slider big-imagg-slider">';	
		slider +='	<div class="slider-style slider-style-image">';
		slider +='		<div class="slider">';
		$(".slider-style-thumbs").find("img").each(function(){
			slider +='		<div class="item item1"><img src="'+$(this).attr("src").replace("-small","")+'"></div>';
		})				
		slider +='		</div>';
		slider +='	</div>';
		slider +='	<div class = "paging">';
		$(".slider-style-thumbs").find("img").each(function(){
					slider +='		<div class="box"><img src="'+$(this).attr("src")+'"></div>';
		})
		slider +='	</div>';
		slider +='	<div class="controls-direction image-control">';
		slider +='		<span class="prev">Prev</span>';
		slider +='		<span class="next">Next</span>';
		slider +='	</div>';
		slider +='</section>';
	
	  var image=new Image();
      image.src=imgFile;
	  image.onload=function(){
		var html  = '<div id="bigpic_show">';
			html += '<div class="center_image" style="width:100%;height:100%">';
			html += '<a class="button close-modal">Close<i class="icon-cancel-2"></i></a>';
			html += slider+'</div></div>';
		$("body").append(html);
	  	$('.slider-style-image').iosSlider({
			desktopClickDrag: true,
			snapToChildren: true,
			infiniteSlider: true,
			navSlideSelector: $('.big-imagg-slider .paging .box'),
			onSliderLoaded: callbackSliderLoadedChanged,
			onSlideChange: callbackSliderChanged,
			navNextSelector: '.image-control .next',
			navPrevSelector: '.image-control .prev'
		});
	  }
}
$(document).ready(function(){
	$('.slider-style-thumbs').iosSlider({
		desktopClickDrag: true,
		snapToChildren: true,
		infiniteSlider: true,
		navNextSelector: '.thumbs-control .next',
		navPrevSelector: '.thumbs-control .prev'
	});
	$('.slider-style-aslo').iosSlider({
		desktopClickDrag: true,
		snapToChildren: true,
		infiniteSlider: true,
		navNextSelector: '.aslo-control .next',
		navPrevSelector: '.aslo-control .prev'
	});
	$('#bigpic').click(function(){
		if($("#bigpic_show").length>0){
			$("#bigpic_show_src").attr('src',$(this).attr('src').replace("-large",""))
			$("#bigpic_show").show();
		}
		else
			PreviewImg($(this).attr('src').replace("-large",""));
	})
	$("#bigpic_show .close-modal").on("click",function(){
	  $("#bigpic_show").hide();
	});

	$('.slider-style-thumbs a').click(
		function(){displayImage($(this));}
	);
	$('.attribute_group').each(function(){
			var currid	   = $(this).attr('id').replace('group_','');
			$('#id_attribute_group_'+currid).val($(this).val());
	})
	
	$('.attribute_group').change(function(){
		var currid	   = $(this).attr('id').replace('group_','');
		$('#id_attribute_group_'+currid).val($(this).val());
	})
	$('.tab-row').click(function(){
			var tabid = $(this).find("a").attr("id").replace("link-","");
			if($("#product-tab-content-"+tabid).hasClass("selected")==false)
			{
				$(".product-tab-content").hide();
				$("#product-tab-content-"+tabid).show();
				$('.tab-row').removeClass("selected");
				$(this).addClass("selected");
			}
	})
	$("#add_to_cart").click(function(){
		var allowToCart = true;
		$(".id_attribute_group").each(function(){
			if($(this).val()=="NULL")
			{
				var id = parseInt($(this).attr("id").replace("id_attribute_group_",""));
				$("#group-id-"+id).css("border-color","red");
				allowToCart = false;
			}
		})
		if(allowToCart){
			$(".add_to_cart_form").submit();
		}
	})
	var p = $("#product_tab").offset().top;
  	$(window).scroll(function () {
		var d = $(document).scrollTop();
		if(d>=p){
			if(!$(".productTabs").hasClass("tab_fixed"))
				$(".productTabs").addClass("tab_fixed");
		}
		if(d<p){
			if($(".productTabs").hasClass("tab_fixed"))
				$(".productTabs").removeClass("tab_fixed");
		}
  	})
})