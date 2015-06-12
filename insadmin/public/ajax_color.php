<?php
include_once(dirname(__FILE__)."/init.php");
if(isset($_GET['action'])&&$_GET['action']=='loadmoreproduct')
{
	$products  = Db::getInstance()->ExecuteS('SELECT p.id_product,i.id_image FROM '._DB_PREFIX_.'product AS p 
											Left Join '._DB_PREFIX_.'image AS i ON p.id_product = i.id_product 
											WHERE i.cover = 1 AND p.id_color=0
											LIMIT '.(100*$_GET['p']).',100');
	if($products){
		$html = "";
		foreach($products as $row){
			$html .= '<div class="color_product_item" id="'.$row['id_product'].'">';
			$html .= '	<img src="'.Image::getImageLink($row['id_image'],'home').'" title="'.$row['id_product'].'">';
			$html .= '</div>';
		}
		die(json_encode(array("status"=>"YES","html"=>$html)));
	}else{
		die(json_encode(array("status"=>"NO","error"=>"没有产品了")));
	}
}
if(isset($_GET['action'])&&$_GET['action']=='addtocolor')
{
	$id_color  = (int)$_GET['id_color'];
	$id_product= (int)$_GET['id_product']; 

	$ret = Db::getInstance()->Execute('UPDATE '._DB_PREFIX_.'product SET `id_color`='.$id_color.' WHERE `id_product`='.$id_product);
	if($ret)
		die(json_encode(array("status"=>"YES")));
	else
	die(json_encode(array("status"=>"NO","error"=>"添加到颜色失败!")));
}

if(isset($_GET['action'])&&$_GET['action']=='loadproductwithcolor')
{
	$id_color  = (int)$_GET['id_color'];
	$products  = Db::getInstance()->ExecuteS('SELECT p.id_product,i.id_image FROM '._DB_PREFIX_.'product p
											Left Join '._DB_PREFIX_.'image AS i ON p.id_product = i.id_product 
											WHERE i.cover = 1 AND p.id_color = '.$id_color.'
											LIMIT '.(100*$_GET['p']).',100');
	if($products){
		$html = "";
		foreach($products as $row){
			$html .= '<div class="color_product_item" id="'.$row['id_product'].'">';
			$html .= '	<img src="'.Image::getImageLink($row['id_image'],'home').'" title="'.$row['id_product'].'">';
			$html .= '</div>';
		}
		die(json_encode(array("status"=>"YES","html"=>$html)));
	}else{
		die(json_encode(array("status"=>"NO","error"=>"没有产品了")));
	}
}

if(isset($_GET['action'])&&$_GET['action']=='deletetocolor')
{
	$id_color  = (int)$_GET['id_color'];
	$id_product= (int)$_GET['id_product']; 

	$ret = Db::getInstance()->Execute('UPDATE '._DB_PREFIX_.'product SET id_color=0 WHERE `id_product`='.$id_product);
	if($ret)
		die(json_encode(array("status"=>"YES")));
	else
		die(json_encode(array("status"=>"NO","error"=>"取消颜色失败!")));
}
?>