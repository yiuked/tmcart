<?php
include_once(dirname(__FILE__)."/init.php");

if(Tools::getRequest('action')=='addImage'){
	ajaxProcessAddImage();
}elseif(Tools::getRequest('action')=='deleteProductImage'){
	ajaxProcessDeleteProductImage();
}elseif(Tools::getRequest('action')=='UpdateCover'){
	ajaxProcessUpdateCover();
}


/* @todo rename to processaddproductimage */
function ajaxProcessAddImage()
{

	$allowedExtensions = array('jpeg', 'gif', 'png', 'jpg');
	$max_image_size    = 2048000;
	// max file size in bytes
	$uploader = new FileUploader($allowedExtensions, $max_image_size);
	
	$result = $uploader->handleUpload();
	if (isset($result['success']))
	{
		$obj = new Image((int)$result['success']['id_image']);

		$json = array(
			'name' => $result['success']['name'],
			'status' => 'ok',
			'id'=>$obj->id,
			'path' => $obj->getExistingImgPath(),
			'position' => $obj->position,
			'cover' => $obj->cover
		);
		@unlink(_TM_TMP_IMG_DIR.'product_'.(int)$obj->id_product.'.jpg');
		@unlink(_TM_TMP_IMG_DIR.'product_mini_'.(int)$obj->id_product.'.jpg');
		die(json_encode($json));
	}
	else
		die(json_encode($result));
}

function ajaxProcessDeleteProductImage()
{
	$res = true;
	/* Delete product image */
	$image = new Image((int)Tools::getRequest('id_image'));
	$res &= $image->delete();


	if (file_exists(_TM_TMP_IMG_DIR.'product_'.$image->id_product.'.jpg'))
		$res &= @unlink(_TM_TMP_IMG_DIR.'product_'.$image->id_product.'.jpg');
	if (file_exists(_TM_TMP_IMG_DIR.'product_mini_'.$image->id_product.'.jpg'))
		$res &= @unlink(_TM_TMP_IMG_DIR.'product_mini_'.$image->id_product.'.jpg');

	if ($res)
		die(json_encode(array(
				'status'=>'ok',
				'confirmations'=>'操作成功！',
				'content'=>array('id'=>$image->id),
		)));
	else
		die(json_encode(array(
				'status'=>'error',
				'confirmations'=>'删除文件失败！'
		)));
}

function ajaxProcessUpdateCover()
{
	Image::deleteCover((int)Tools::getRequest('id_product'));
	$img = new Image((int)Tools::getRequest('id_image'));
	$img->cover = 1;
	$product = new Product((int)($img->id_product));
	$product->id_image_default = (int)Tools::getRequest('id_image');
	$product->update();
	
	@unlink(_TM_TMP_IMG_DIR.'product_'.(int)$img->id_product.'.jpg');
	@unlink(_TM_TMP_IMG_DIR.'product_mini_'.(int)$img->id_product.'.jpg');

	if ($img->update())
		die(json_encode(array(
				'status'=>'ok',
				'confirmations'=>'更新成功！'
		)));
	else
		die(json_encode(array(
				'status'=>'error',
				'confirmations'=>'更新失败！'
		)));
}
?>