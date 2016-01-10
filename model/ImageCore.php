<?php
class ImageCore{

	function cacheImage($image, $cacheImage, $size, $imageType = 'jpg', $disableCache = false)
	{
		if (file_exists($image))
		{
			if (!file_exists(_PS_TMP_IMG_DIR_.$cacheImage))
			{
				$infos = getimagesize($image);
	
				$memory_limit = Tools::getMemoryLimit();
				// memory_limit == -1 => unlimited memory
				if (function_exists('memory_get_usage') && (int)$memory_limit != -1)
				{
					$current_memory = memory_get_usage();
					
					// Evaluate the memory required to resize the image: if it's too much, you can't resize it.
					if (($infos[0] * $infos[1] * $infos['bits'] * (isset($infos['channels']) ? ($infos['channels'] / 8) : 1) + pow(2, 16)) * 1.8 + $current_memory > $memory_limit - 1024 * 1024)
						return false;
				}
	
				$x = $infos[0];
				$y = $infos[1];
				$max_x = ((int)$size)*3;
	
				/* Size is already ok */
				if ($y < $size && $x <= $max_x )
					copy($image, _PS_TMP_IMG_DIR_.$cacheImage);
	
				/* We need to resize */
				else
				{
					$ratioX = $x / ($y / $size);
					if($ratioX > $max_x)
					{
						$ratioX = $max_x;
						$size = $y / ($x / $max_x);
					}
				
					imageResize($image, _PS_TMP_IMG_DIR_.$cacheImage, $ratioX, $size, 'jpg');
				}
			}
			return '<img src="'._PS_TMP_IMG_.$cacheImage.($disableCache ? '?time='.time() : '').'" alt="" class="imgm" />';
		}
		return '';
	}
	
	/**
	  * Check image upload
	  *
	  * @param array $file Upload $_FILE value
	  * @param integer $maxFileSize Maximum upload size
	  */
	function checkImage($file, $maxFileSize)
	{
		if ($file['size'] > $maxFileSize)
			return Tools::displayError('Image is too large').' ('.($file['size'] / 1000).Tools::displayError('KB').'). '.Tools::displayError('Maximum allowed:').' '.($maxFileSize / 1000).Tools::displayError('KB');
		if (!isPicture($file))
			return Tools::displayError('Image format not recognized, allowed formats are: .gif, .jpg, .png');
		if ($file['error'])
			return Tools::displayError('Error while uploading image; please change your server\'s settings.').'('.Tools::displayError('Error code: ').$file['error'].')';
		return false;
	}
	
	
	
	function checkImageUploadError($file)
	{
		if ($file['error'])
		{
			switch ($file['error'])
			{
				case 1:
					return Tools::displayError('The file is too large.');
					break;
	
			 case 2:
					return Tools::displayError('The file is too large.');
					break;
	
				case 3:
					return Tools::displayError('The file was partialy uploaded');
					break;
	
				case 4:
					return Tools::displayError('The file is empty');
					break;
			}
		}
	}
	
	/**
	  * Check image MIME type
	  *
	  * @param string $file $_FILE of the current file
	  * @param array $types Allowed MIME types
	  */
	function isPicture($file, $types = NULL)
	{
		/* Detect mime content type */
		$mimeType = false;
		if (!$types)
			$types = array('image/gif', 'image/jpg', 'image/jpeg', 'image/pjpeg', 'image/png', 'image/x-png');
	
		/* Try 4 different methods to determine the mime type */
		if (function_exists('finfo_open'))
		{
			$const = defined('FILEINFO_MIME_TYPE') ? FILEINFO_MIME_TYPE : FILEINFO_MIME;
			$finfo = finfo_open($const);
			 $mimeType = finfo_file($finfo, $file['tmp_name']);
			finfo_close($finfo);
		}
		elseif (function_exists('mime_content_type'))
			$mimeType = mime_content_type($file['tmp_name']);
		elseif (function_exists('exec'))
		{
			$mimeType = trim(exec('file -b --mime-type '.escapeshellarg($file['tmp_name'])));
			if (!$mimeType)
				$mimeType = trim(exec('file --mime '.escapeshellarg($file['tmp_name'])));
			if (!$mimeType)
				$mimeType = trim(exec('file -bi '.escapeshellarg($file['tmp_name'])));
		}
		if (empty($mimeType) OR $mimeType == 'regular file' OR $mimeType == 'text/plain')
			$mimeType = $file['type'];
	
		/* For each allowed MIME type, we are looking for it inside the current MIME type */
		foreach ($types AS $type)
			if (strstr($mimeType, $type))
				return true;
	
		return false;
	}
	
	/**
	  * Check icon upload
	  *
	  * @param array $file Upload $_FILE value
	  * @param integer $maxFileSize Maximum upload size
	  */
	function checkIco($file, $maxFileSize)
	{
		if ($file['size'] > $maxFileSize)
			return Tools::displayError('Image is too large').' ('.($file['size'] / 1000).'ko). '.Tools::displayError('Maximum allowed:').' '.($maxFileSize / 1000).'ko';
		if (substr($file['name'], -4) != '.ico')
			return Tools::displayError('Image format not recognized, allowed formats are: .ico');
		if ($file['error'])
			return Tools::displayError('Error while uploading image; please change your server\'s settings.');
		return false;
	}
	
	/**
	  * Resize, cut and optimize image
	  *
	  * @param array $sourceFile Image object from $_FILE
	  * @param string $destFile Destination filename
	  * @param integer $destWidth Desired width (optional)
	  * @param integer $destHeight Desired height (optional)
	  *
	  * @return boolean Operation result
	  */
	static function imageResize($sourceFile, $destFile, $destWidth = NULL, $destHeight = NULL, $fileType = 'jpg')
	{
		if (!file_exists($sourceFile))
			return false;
		list($sourceWidth, $sourceHeight, $type, $attr) = getimagesize($sourceFile);
		
		if (!$sourceWidth)
			return false;
		if ($destWidth == NULL) $destWidth = $sourceWidth;
		if ($destHeight == NULL) $destHeight = $sourceHeight;
	
		$sourceImage = self::createSrcImage($type, $sourceFile);
	
		$widthDiff = $destWidth / $sourceWidth;
		$heightDiff = $destHeight / $sourceHeight;
	
		if ($widthDiff > 1 AND $heightDiff > 1)
		{
			$nextWidth = $sourceWidth;
			$nextHeight = $sourceHeight;
		}
		else
		{
			if ($widthDiff > $heightDiff)
			{
				$nextHeight = $destHeight;
				$nextWidth = round(($sourceWidth * $nextHeight) / $sourceHeight);

			}
			else
			{
				$nextWidth = $destWidth;
				$nextHeight = round($sourceHeight * $destWidth / $sourceWidth);
			}
		}
	
		$destImage = imagecreatetruecolor($destWidth, $destHeight);
	
		// If image is a PNG and the output is PNG, fill with transparency. Else fill with white background.
		if ($fileType == 'png' && $type == IMAGETYPE_PNG)
		{
			imagealphablending($destImage, false);
			imagesavealpha($destImage, true);	
			$transparent = imagecolorallocatealpha($destImage, 255, 255, 255, 127);
			imagefilledrectangle($destImage, 0, 0, $destWidth, $destHeight, $transparent);
		}else
		{
			$white = imagecolorallocate($destImage, 255, 255, 255);
			imagefilledrectangle($destImage, 0, 0, $destWidth, $destHeight, $white);
		}
		
		imagecopyresampled($destImage, $sourceImage, (int)(($destWidth - $nextWidth) / 2), (int)(($destHeight - $nextHeight) / 2), 0, 0, $nextWidth, $nextHeight, $sourceWidth, $sourceHeight);
	
		return (self::returnDestImage($fileType, $destImage, $destFile));
	}
	
	/**
	  * Cut image
	  *
	  * @param array $srcFile Image object from $_FILE
	  * @param string $destFile Destination filename
	  * @param integer $destWidth Desired width (optional)
	  * @param integer $destHeight Desired height (optional)
	  *
	  * @return boolean Operation result
	  */
	function imageCut($srcFile, $destFile, $destWidth = NULL, $destHeight = NULL, $fileType = 'jpg', $destX = 0, $destY = 0)
	{
		if (!isset($srcFile['tmp_name']) OR !file_exists($srcFile['tmp_name']))
			return false;
	
		// Source infos
		$srcInfos = getimagesize($srcFile['tmp_name']);
		$src['width'] = $srcInfos[0];
		$src['height'] = $srcInfos[1];
		$src['ressource'] = createSrcImage($srcInfos[2], $srcFile['tmp_name']);
	
		// Destination infos
		$dest['x'] = $destX;
		$dest['y'] = $destY;
		$dest['width'] = $destWidth != NULL ? $destWidth : $src['width'];
		$dest['height'] = $destHeight != NULL ? $destHeight : $src['height'];
		$dest['ressource'] = createDestImage($dest['width'], $dest['height']);
	
		$white = imagecolorallocate($dest['ressource'], 255, 255, 255);
		imagecopyresampled($dest['ressource'], $src['ressource'], 0, 0, $dest['x'], $dest['y'], $dest['width'], $dest['height'], $dest['width'], $dest['height']);
		imagecolortransparent($dest['ressource'], $white);
		$return = returnDestImage($fileType, $dest['ressource'], $destFile);
		return	($return);
	}
	
	static function createSrcImage($type, $filename)
	{
		switch ($type)
		{
			case 1:
				return imagecreatefromgif($filename);
				break;
			case 3:
				return imagecreatefrompng($filename);
				break;
			case 2:
			default:
				return imagecreatefromjpeg($filename);
				break;
		}
	}
	
	function createDestImage($width, $height)
	{
		$image = imagecreatetruecolor($width, $height);
		$white = imagecolorallocate($image, 255, 255, 255);
		imagefill($image, 0, 0, $white);
		return $image;
	}
	
	static function returnDestImage($type, $ressource, $filename)
	{
		$flag = false;
		switch ($type)
		{
			case 'gif':
				$flag = imagegif($ressource, $filename);
				break;
			case 'png':
				$flag = imagepng($ressource, $filename, 7);
				break;		
			case 'jpg':
			case 'jpeg':
			default:
				$flag = imagejpeg($ressource, $filename, 90);
				break;
		}
		imagedestroy($ressource);
		@chmod($filename, 0664);
		return $flag;
	}
	
	/**
	  * Delete product or category image
	  *
	  * @param integer $id_item Product or category id
	  * @param integer $id_image Image id
	  * TODO This function will soon be deprecated.
	  */
	function deleteImage($id_item, $id_image = NULL)
	{
		// Category
		if (!$id_image)
		{
			$path = _PS_CAT_IMG_DIR_;
			$table = 'category';
			if (file_exists(_PS_TMP_IMG_DIR_.$table.'_'.$id_item.'.jpg'))
				unlink(_PS_TMP_IMG_DIR_.$table.'_'.$id_item.'.jpg');	
			if (!$id_image AND file_exists($path.$id_item.'.jpg'))
			unlink($path.$id_item.'.jpg');
			
			/* Auto-generated images */
			$imagesTypes = ImageType::getImagesTypes();
			foreach ($imagesTypes AS $k => $imagesType)
				if (file_exists($path.$id_item.'-'.$imagesType['name'].'.jpg'))
					unlink($path.$id_item.'-'.$imagesType['name'].'.jpg');
		}else // Product
		{
			$path = _PS_PROD_IMG_DIR_;
			$table = 'product';
			$image = new Image($id_image);
			$image->id_product = $id_item;	
	
			if (file_exists($path.$image->getExistingImgPath().'.jpg'))
				unlink($path.$image->getExistingImgPath().'.jpg');
				
			/* Auto-generated images */
			$imagesTypes = ImageType::getImagesTypes();
			foreach ($imagesTypes AS $k => $imagesType)
				if (file_exists($path.$image->getExistingImgPath().'-'.$imagesType['name'].'.jpg'))
					unlink($path.$image->getExistingImgPath().'-'.$imagesType['name'].'.jpg');
		}
			
		/* BO "mini" image */
		if (file_exists(_PS_TMP_IMG_DIR_.$table.'_mini_'.$id_item.'.jpg'))
			unlink(_PS_TMP_IMG_DIR_.$table.'_mini_'.$id_item.'.jpg');
		return true;
	}
}