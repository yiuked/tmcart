function str2url(str,encoding,ucfirst)
{
	str = str.toUpperCase();
	str = str.toLowerCase();

	str = str.replace(/[\u0105\u0104\u00E0\u00E1\u00E2\u00E3\u00E4\u00E5]/g,'a');
	str = str.replace(/[\u00E7\u010D\u0107\u0106]/g,'c');
	str = str.replace(/[\u010F]/g,'d');
	str = str.replace(/[\u00E8\u00E9\u00EA\u00EB\u011B\u0119\u0118]/g,'e');
	str = str.replace(/[\u00EC\u00ED\u00EE\u00EF]/g,'i');
	str = str.replace(/[\u0142\u0141]/g,'l');
	str = str.replace(/[\u00F1\u0148]/g,'n');
	str = str.replace(/[\u00F2\u00F3\u00F4\u00F5\u00F6\u00F8\u00D3]/g,'o');
	str = str.replace(/[\u0159]/g,'r');
	str = str.replace(/[\u015B\u015A\u0161]/g,'s');
	str = str.replace(/[\u00DF]/g,'ss');
	str = str.replace(/[\u0165]/g,'t');
	str = str.replace(/[\u00F9\u00FA\u00FB\u00FC\u016F]/g,'u');
	str = str.replace(/[\u00FD\u00FF]/g,'y');
	str = str.replace(/[\u017C\u017A\u017B\u0179\u017E]/g,'z');
	str = str.replace(/[\u00E6]/g,'ae');
	str = str.replace(/[\u0153]/g,'oe');
	str = str.replace(/[\u013E\u013A]/g,'l');
	str = str.replace(/[\u0155]/g,'r');

	str = str.replace(/[^a-z0-9\s\'\.\:\/\[\]-]/g,'');
	str = str.replace(/[\s\'\:\/\[\]-]+/g,' ');
	str = str.replace(/[ ]/g,'-');
	str = str.replace(/[\/]/g,'-');

	if (ucfirst == 1) {
		c = str.charAt(0);
		str = c.toUpperCase()+str.slice(1);
	}

	return str;
}
function copy2friendlyURL()
{
	$('#rewrite').val(str2url($('#name').val().replace(/^[0-9]+\./, ''), 'UTF-8'));
}
function generateFriendlyURL()
{
	$('#rewrite').val(str2url($('#rewrite').val().replace(/^[0-9]+\./, ''), 'UTF-8'));
}
function isArrowKey(k_ev)
{
	var unicode=k_ev.keyCode? k_ev.keyCode : k_ev.charCode;
	if (unicode >= 37 && unicode <= 40)
		return true;

}
var helpboxes = false;
if (typeof helpboxes != 'undefined' && helpboxes)
{
	$(function()
	{
		if ($('input'))
		{
			//Display by rollover
			$('input').mouseover(function() {
			$(this).parent().find('.hint:first').css('display', 'block');
			});
			$('input').mouseout(function() { $(this).parent().find('.hint:first').css('display', 'none'); });

			//display when you press the tab key
			$('input').keydown(function (e) {
				if ( e.keyCode === 9 ){
					$('input').focus(function() { $(this).parent().find('.hint:first').css('display', 'block'); });
					$('input').blur(function() { $(this).parent().find('.hint:first').css('display', 'none'); });
				}
			});
		}
		if ($('select'))
		{
			//Display by rollover
			$('select').mouseover(function() {
			$(this).parent().find('.hint:first').css('display', 'block');
			});
			$('select').mouseout(function() { $(this).parent().find('.hint:first').css('display', 'none'); });

			//display when you press the tab key
			$('select').keydown(function (e) {
				if ( e.keyCode === 9 ){
					$('select').focus(function() { $(this).parent().find('.hint:first').css('display', 'block'); });
					$('select').blur(function() { $(this).parent().find('.hint:first').css('display', 'none'); });
				}
			});
		}
		if ($('span.title_box'))
		{
			//Display by rollover
			$('span.title_box').mouseover(function() {
				//get reference to the hint box
				var parent = $(this).parent();
				var box = parent.find('.hint:first');

				if (box.length > 0)
				{
					//gets parent position
					var left_position = parent.offset().left;

					//gets width of the box
					var box_width = box.width();

					//gets width of the screen
					var document_width = $(document).width();

					//changes position of the box if needed
					if (document_width < (left_position + box_width))
						box.css('margin-left', '-' + box_width + 'px');

					//shows the box
					box.css('display', 'block');
				}
			});
			$('span.title_box').mouseout(function() { $(this).parent().find('.hint:first').css('display', 'none'); });
		}
	});
}

/** display a success message in a #ajax_confirmation container
 * @param string msg string to display
 */
function showSuccessMessage(msg, delay)
{
	if (!delay)
		delay = 3000;
	$("#ajax_confirmation")
		.html("<div class=\"conf\">"+msg+"</div>").show().delay(delay).fadeOut("slow");
}/** display a success message in a #ajax_confirmation container
 * @param string msg string to display
 */
function showSuccessMessage(msg, delay)
{
	if (!delay)
		delay = 3000;
	$("#ajax_confirmation")
		.html("<div class=\"conf\">"+msg+"</div>").show().delay(delay).fadeOut("slow");
}
function doAdminAjax(data,url,success_func, error_func)
{
	$.ajax(
	{
		url : url,
		data : data,
		success : function(data){
			if (success_func)
				return success_func(data);

			data = $.parseJSON(data);
			if(data.confirmations.length != 0)
				showSuccessMessage(data.confirmations);
			else
				showErrorMessage(data.error);
		},
		error : function(data){
			if (error_func)
				return error_func(data);

			alert("[TECHNICAL ERROR]");
		}
	});
}

/**
 * Update the product image list position buttons
 *
 * @param DOM table imageTable
 */
function refreshImagePositions(imageTable)
{
	var reg = /_[0-9]$/g;
	var up_reg  = new RegExp("imgPosition=[0-9]+&");

	imageTable.find("tbody tr").each(function(i,el) {
		$(el).find("td.positionImage").html(i + 1);
	});
	imageTable.find("tr td.dragHandle a:hidden").show();
	imageTable.find("tr td.dragHandle:first a:first").hide();
	imageTable.find("tr td.dragHandle:last a:last").hide();
}
function display_details(id)
{
	var details_tab     = $('#details_tab_'+id);
	var details_content = $('#details_content_'+id);
	var details_img		= details_tab.find('img');
			
	details_content.toggle('slow',function(){
						if(details_img.attr('src').indexOf('more')>0){
							var new_src = details_img.attr('src').replace('more','less');
						}else if(details_img.attr('src').indexOf('less')>0){
							var new_src = details_img.attr('src').replace('less','more');
						}
						 details_img.attr('src',new_src);
							}
		);
}
function setToggle(e,object,key,id)
{
	$.ajax({
		url: 'public/ajax.php',
		cache: false,
		data: "toggle=" + object + "&key=" + key + "&id=" + id,
		dataType: "json",
		success: function(data)
		{
			if (data.status == 'YES') {
				if (e.attr('class').indexOf('ok') > 0 ) {
					e.attr('class', e.attr('class').replace('ok', 'remove'))
				} else {
					e.attr('class', e.attr('class').replace('remove', 'ok'))
				}
			}
		}
	});
};

$(document).ready(function(){
	/*
	* the class name must eq check-all,data-name is other checkbox name value"
	* eg.<input type="checkbox" class="check-all" data-name="product[]">
	* */
	$(".check-all").click(function(){
		var allCheck = $(this).prop("checked");
		$("input[name='"+$(this).data("name")+"']").each(function(){
			$(this).prop("checked",allCheck);
		})
	})
})
