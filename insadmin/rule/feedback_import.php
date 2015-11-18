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
<link href="<?php echo BOOTSTRAP_CSS;?>bootstrap-datetimepicker.min.css" rel="stylesheet" />
<script type="text/javascript" src="<?php echo BOOTSTRAP_JS;?>bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="<?php echo BOOTSTRAP_JS;?>bootstrap-datetimepicker.zh-CN.js"></script>
<script language="javascript">
$(document).ready(function(){
	$('.tmdatatimepicker').datetimepicker({
		language: 'zh-CN',
		container: '.container-fluid',
		format: 'yyyy-mm-dd hh:ii'
	});
})
</script>
<?php
$breadcrumb = new UIAdminBreadcrumb();
$breadcrumb->home();
$breadcrumb->add(array('title' => '产品反馈', 'href' => 'index.php?rule=feedback'));
$breadcrumb->add(array('title' => '导入', 'active' => true));
$bread = $breadcrumb->draw();
echo UIViewBlock::area(array('bread' => $bread), 'breadcrumb');
?>

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">导入反馈</div>
			<div class="panel-body">
				<div class="col-md-10 form-horizontal">
					<form enctype="multipart/form-data" method="post" action="index.php?rule=feedback_import" class="defaultForm" id="import_form" name="import_form">
						<div class="form-group">
							<label for="time" class="col-md-2 control-label">开始时间</label>
							<div class="col-md-6" id="datepicker">
								<input type="text" class="tmdatatimepicker form-control" value="<?php echo Tools::getRequest('from_date');?>"  name="from_date" >
								<p class="text-info">评论开始的时间</p>
							</div>
						</div>
						<div class="form-group">
							<label for="time" class="col-md-2 control-label">ID号</label>
							<div class="col-md-6">
								<input type="text" value="<?php echo Tools::getRequest('ali_productid');?>" name="ali_productid" class="form-control" />
								<p class="text-info">逗号分隔多个ID</p>
							</div>
						</div>
						<div class="form-group">
							<div class="col-md-6 col-md-offset-2">
								<button type="submit" class="btn btn-success" name="importFeedback"><span class="glyphicon glyphicon-save"></span> 导入</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

