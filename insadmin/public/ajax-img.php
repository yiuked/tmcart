<?php
include_once(dirname(__FILE__) . "/../config/init.php");

if(Tools::getRequest('action') == 'addImage'){
	ajaxProcessAddImage();
}elseif(Tools::getRequest('action') == 'deleteProductImage'){
	ajaxProcessDeleteProductImage();
}elseif(Tools::getRequest('action') == 'UpdateCover'){
	ajaxProcessUpdateCover();
}elseif(Tools::getRequest('action') == 'updateImagePosition') {
	ajaxProcessUpdatePosition();
}


/**
 * 上传图片并更新排序
 */
function ajaxProcessAddImage()
{
	// max file size in bytes
	$uploader = new FileUploader();
	$result = $uploader->handleUpload(ImageType::IMAGE_PRDOCUT);
	if (isset($result['success']))
	{
		$image = $result['success'];
		$row['id_product'] = Tools::Q('id_product');
		$row['id_image'] = (int) $image['id_image'];
		$row['position'] = (int) Product::getImageLastPosition($row['id_product']);
		if ($row['position'] == 1) {
			$row['cover'] = 1;
		} else {
			$row['cover'] = 0;
		}
		Db::getInstance()->insert(DB_PREFIX . 'product_to_image', $row);
		$json = array(
			'status' => 'ok',
			'id' => $row['id_image'],
			'path' => Image::getImageLink($row['id_image'] ,'small'),
			'position' => $row['position'],
			'cover' => $row['cover']
		);
		die(json_encode($json));
	}
	else
		die(json_encode($result));
}

/**
 * 删除图片并更新排序
 * */
function ajaxProcessDeleteProductImage()
{
	$res = true;
	/* Delete product image */
	$id_image = (int) Tools::Q('id_image');
	$id_product = (int) Tools::Q('id_product');
	$image = new Image($id_image);
	if ($image->delete()) {
		if( Db::getInstance()->exec('DELETE FROM ' . DB_PREFIX . 'product_to_image WHERE id_image='.$id_image)){
			// update positions
			$result = Db::getInstance()->getAll('
			SELECT *
			FROM `' . DB_PREFIX . 'product_to_image`
			WHERE `id_product` = ' . $id_product .'
			ORDER BY `position`
			');
			$i = 1;
			if ($result) {
				foreach ($result as $row) {
					if ($row['id_image'] == $id_image && $row['cover'] == 1 && $i == 1) {
						$row['cover'] = 1;
					}
					$row['position'] = $i++;
					Db::getInstance()->update(DB_PREFIX . 'product_to_image', $row, '`id_image` = ' . (int)$row['id_image'], 1);
				}
			}
		} else {
			$res &= false;
		}
	} else {
		$res &= false;
	}

	if ($res)
		die(json_encode(array(
				'status'=>'ok',
				'confirmations'=>'操作成功！',
				'content'=>array('id' => $image->id),
		)));
	else
		die(json_encode(array(
				'status'=>'error',
				'confirmations'=>'删除文件失败！'
		)));
}

/**
 * 更新产品默认图片
 */
function ajaxProcessUpdateCover()
{
	$id_image = (int) Tools::Q('id_image');
	$id_product = (int) Tools::Q('id_product');
	$product = new Product($id_product);
	if (false !== Db::getInstance()->exec('UPDATE '.DB_PREFIX . 'product_to_image SET cover=0 WHERE id_image='. (int) $product->id_image)) {
		if (false !== Db::getInstance()->exec('UPDATE '.DB_PREFIX . 'product_to_image SET cover=1 WHERE id_image='. (int) $id_image)) {
			$product->id_image = $id_image;
			if ($product->update()) {
				die(json_encode(array(
					'status'=>'ok',
					'confirmations'=>'更新成功！'
				)));
			}
		}
	}
	die(json_encode(array(
			'status'=>'error',
			'confirmations'=>'更新失败！'
	)));
}

/**
 * 更新排序
 */
function ajaxProcessUpdatePosition()
{
	$json = json_decode($_GET['json'],true);

	$isOk = true;
	foreach ($json as $id_image => $position) {
		if (false === Db::getInstance()->exec('UPDATE '.DB_PREFIX . 'product_to_image SET position=' . (int) $position .' WHERE id_image='. (int) $id_image)) {
			$isOk &= false;
		}
	}

	if ($isOk) {
		die(json_encode(array(
			'status'=>'ok',
			'confirmations'=>'更新成功！'
		)));
	} else {
		die(json_encode(array(
			'status'=>'error',
			'confirmations'=>'更新失败！'
		)));
	}
}