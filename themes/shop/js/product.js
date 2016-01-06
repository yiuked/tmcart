function displayImage(domAAroundImgThumb)
{
    if (domAAroundImgThumb.attr('href'))
    {
        var newSrc = domAAroundImgThumb.attr('href').replace('thickbox','large');
        if ($('#bigpic').attr('src') != newSrc)
        {
			$('#bigpic').attr('src', newSrc).show();
        }
        $('#thumbs-list .item a').removeClass('shown');
        $(domAAroundImgThumb).addClass('shown');
    }
}

$(document).ready(function(){
	$('#thumbs-list .item a').click(
		function(){displayImage($(this));}
	);
	$('.attribute_group').each(function(){
			var currid	   = $(this).attr('id').replace('group_','');
			$('#id_attribute_group_'+currid).val($(this).val());
	})
	
	$('.attrbiute-radio .item').click(function(){
		$('.attrbiute-radio .item').removeClass('selected');
		$(this).addClass('selected');
		$(this).parent().children('.id_attribute_group').val($(this).data('id_attribute'));
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
})