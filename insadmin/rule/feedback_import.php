<?php
if(Tools::isSubmit('importFeedback'))
{
	//1.通过curl获取反馈数据.
	$ids 	= Tools::getRequest('ali_productid');
	$aliids = explode(",",$ids);
	$feedbacks = array();
	foreach($aliids as $id){
		$src 	= "http://www.aliexpress.com/cross-domain/detailevaluationproduct/index.html?productId=".$id."&type=default&page=1";
		$data = getCurlData($src);

		$feedbacks = array_merge($data->records,$feedbacks);
		if($data->page->total>1){
			for($i=2;$i<=$data->page->total;$i++){
				$src 	  	= "http://www.aliexpress.com/cross-domain/detailevaluationproduct/index.html?productId=".$id."&type=default&page=".$i;
				$pagedata 	= getCurlData($src);
				if(is_array($pagedata->records))
					$feedbacks 	= array_merge($pagedata->records,$feedbacks);
			}
		}
	}

	//2.第二阶段，剔除为空的数据，并将不为空的数据加入到产品中.
	$rating_fields = array("one_star","two_star","three_star","four_star","five_star");
	$products = Db::getInstance()->ExecuteS('SELECT `id_product`,`price` FROM '._DB_PREFIX_.'product ORDER BY orders ASC LIMIT 0,200');
	$productids = array();
	foreach($products as $row)
	{
		$productids[$row["id_product"]] = $row["price"];
	}
	
	foreach($feedbacks as $feed)
	{
		if(strlen($feed->buyerFeedback)==0 || $feed->star<3)
			continue;
		$id_product = array_rand($productids);
		$feedback =  new Feedback();
		$feedback->id_product 	= (int)$id_product;
		$feedback->unit_price 	= (float)$productids[$id_product];
		$feedback->quantity 	= (int)$feed->quantity;
		$feedback->md5_key 		= md5(time());
		$feedback->flag_code 	= strtolower($feed->countryCode);
		$feedback->name	   		= substr($feed->name,0,1)."***".substr($feed->name,-2,2);
		$feedback->feedback		= pSQL($feed->buyerFeedback);
		$feedback->id_user 		= 0;
		$feedback->rating 		= (int)$feed->star;
		$feedback->active 		= 1;
		$feedback->add_date 	= rand_time(Tools::getRequest('from_date'));
		if($feedback->add()){
			$field = pSQL($rating_fields[$feed->star-1]);
			if($feedback->feedbackStateExists($id_product)){
				Db::getInstance()->Execute('UPDATE '._DB_PREFIX_.'feedback_state SET times=times+1,total_rating=total_rating+'.(int)$feedback->rating.",`".$field."`=`".$field."`+1 
				WHERE id_product=".intval($id_product));
			}else{
				Db::getInstance()->Execute('INSERT INTO '._DB_PREFIX_.'feedback_state SET id_product='.intval($id_product).',times=1,total_rating='.(int)$feedback->rating.",`".$field."`=`".$field."`+1");
			}
			Db::getInstance()->Execute('UPDATE '._DB_PREFIX_.'product SET orders=orders+'.rand(3,5).' WHERE id_product='.(int)$id_product);
		}
	}
}

function getCurlData($url)
{
	$ch 	= curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	$output = curl_exec($ch);
	curl_close($ch);
	return json_decode($output);
}
function rand_time($star)
{
	$star = strtotime($star);
	$end  = time();
	return date( "Y-m-d H:m:s", mt_rand($star,$end));
}
require_once(dirname(__FILE__).'/../errors.php');
?>
<link href="<?php echo $_tmconfig['tm_js_dir']?>jquery/ui/themes/base/jquery.ui.theme.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?php echo $_tmconfig['tm_js_dir']?>jquery/ui/themes/base/jquery.ui.slider.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?php echo $_tmconfig['tm_js_dir']?>jquery/ui/themes/base/jquery.ui.datepicker.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?php echo $_tmconfig['tm_js_dir']?>jquery/plugins/timepicker/jquery-ui-timepicker-addon.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?php echo $_tmconfig['tm_js_dir']?>jquery/ui/themes/base/jquery.ui.datepicker.css" rel="stylesheet" type="text/css" media="all" />
<link href="<?php echo $_tmconfig['tm_js_dir']?>jquery/plugins/timepicker/jquery-ui-timepicker-addon.css" rel="stylesheet" type="text/css" media="all" />
<script type="text/javascript" src="<?php echo $_tmconfig['tm_js_dir']?>jquery/ui/jquery.ui.core.min.js"></script>
<script type="text/javascript" src="<?php echo $_tmconfig['tm_js_dir']?>jquery/ui/jquery.ui.widget.min.js"></script>
<script type="text/javascript" src="<?php echo $_tmconfig['tm_js_dir']?>jquery/ui/jquery.ui.mouse.min.js"></script>
<script type="text/javascript" src="<?php echo $_tmconfig['tm_js_dir']?>jquery/ui/jquery.ui.slider.min.js"></script>
<script type="text/javascript" src="<?php echo $_tmconfig['tm_js_dir']?>jquery/ui/jquery.ui.datepicker.min.js"></script>
<script type="text/javascript" src="<?php echo $_tmconfig['tm_js_dir']?>jquery/ui/i18n/jquery.ui.datepicker-zh-CN.js"></script>
<script type="text/javascript" src="<?php echo $_tmconfig['tm_js_dir']?>jquery/plugins/timepicker/jquery-ui-timepicker-addon.js"></script>
<script language="javascript">
$(function() {
	if ($(".datepicker").length > 0)
			$('.datepicker').datetimepicker({
				prevText: '',
				nextText: '',
				dateFormat: 'yy-mm-dd',

				// Define a custom regional settings in order to use PrestaShop translation tools
				currentText: '现在',
				closeText: '完成',
				ampm: false,
				amNames: ['AM', 'A'],
				pmNames: ['PM', 'P'],
				timeFormat: 'hh:mm:ss tt',
				timeSuffix: '',
				timeOnlyTitle: '选择时间',
				timeText: '时间',
				hourText: '小时',
				minuteText: '分钟',
			});
});
</script>
<div class="path_bar">
  <div class="path_title">
    <h3> <span style="font-weight: normal;" id="current_obj"> <span class="breadcrumb item-1 ">数据<img src="<?php echo $_tmconfig['tm_img_dir'];?>admin/separator_breadcrum.png" style="margin-right:5px" alt="&gt;"> </span> <span class="breadcrumb item-2 ">导入</span> </span> </h3>
  </div>
</div>

<div class="mianForm">
  <br/><br/>
  <form enctype="multipart/form-data" method="post" action="index.php?rule=feedback_import" class="defaultForm" id="import_form" name="import_form">
    <fieldset class="small">
    <legend> <img alt="CMS 分类" src="<?php echo $_tmconfig['ico_dir'];?>category.png">导入产品</legend>
	
    <label>开始时间: </label>
    <div class="margin-form">
      <div style="display:block; float: left;">
        <input type="text" class="text_input_sort datepicker" value="<?php echo Tools::getRequest('from_date');?>"  name="from_date">&nbsp;
		<p class="preference_description">评论开始的时间</b></p>
      </div>
      <div class="clear"></div>
    </div>
	
    <label>ID号: </label>
    <div class="margin-form">
      <div style="display:block; float: left;">
		<input type="text" value="<?php echo Tools::getRequest('ali_productid');?>" name="ali_productid" size="60"/>
		<p class="preference_description">逗号分隔多个ID</p>
      </div>
      <div class="clear"></div>
    </div>
	<div class="margin-form">
		<input type="submit" class="button" value="导入" name="importFeedback">
	</div>
    </fieldset>
  </form>
</div>
