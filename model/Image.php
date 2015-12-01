<?php
class Image extends ObjectBase
{
	protected $fields = array(
		'add_date' => array(
			'type' => 'isDate'
		)
	);
	/** @var string image extension */
	public $image_format = 'jpg';

	/** @var string path to index.php file to be copied to new image folders */
	public $source_index;

	/** @var string image folder */
	protected $folder;

	/** @var string image path without extension */
	protected $existing_path;

	/** @var int access rights of created folders (octal) */
	protected static $access_rights = 0775;
	
	protected $identifier 		= 'id_image';
	protected $table			= 'image';

	protected static $_cacheGetSize = array();

	public function __construct($id = null)
	{
		parent::__construct($id);
		$this->image_dir = _TM_PRO_IMG_DIR;
		$this->source_index = _TM_PRO_IMG_DIR.'index.php';
	}

	public function delete()
	{
		if (!parent::delete())
			return false;

		if (!$this->deleteImage())
			return false;

		return true;
	}

	/**
	 * 取得一张图片的HTTP访问链接
	 *
	 * @param $id_image
	 * @param $type
	 * @return bool|string
	 */
	public static function getImageLink($id_image,$type)
	{
		if(!$id_image)
			return false;
		$image = new Image((int)($id_image));
		if($image->getExistingImgPath())
			return _TM_PRO_URL.$image->getExistingImgPath().'-'.$type.'.jpg';
	}
	
	/**
	 * Return Images
	 *
	 * @return array Images
	 */
	public static function getAllImages()
	{
		return Db::getInstance()->getAll('
		SELECT `id_image`
		FROM `'.DB_PREFIX.'image`');
	}

	public static function getSize($type)
	{
		if (!isset(self::$_cacheGetSize[$type]) || self::$_cacheGetSize[$type] === null)
			self::$_cacheGetSize[$type] = Db::getInstance()->getRow('
				SELECT `width`, `height`
				FROM '.DB_PREFIX.'image_type
				WHERE `name` = \''.pSQL($type).'\'
			');
	 	return self::$_cacheGetSize[$type];
	}

	/**
	 * Clear all images in tmp dir
	 */
	public static function clearTmpDir()
	{
		foreach (scandir(_TM_TMP_IMG_DIR) as $d)
			if (preg_match('/(.*)\.jpg$/', $d))
				unlink(_TM_TMP_IMG_DIR.$d);
	}

	/**
	 * Delete the product image from disk and remove the containing folder if empty
	 * Handles both legacy and new image filesystems
	 */
	public function deleteImage($force_delete = false)
	{
		if (!$this->id)
			return false;

		// Delete base image
		if (file_exists($this->image_dir.$this->getExistingImgPath().'.'.$this->image_format))
			unlink($this->image_dir.$this->getExistingImgPath().'.'.$this->image_format);
		else
			return false;

		$files_to_delete = array();

		// Delete auto-generated images
		$image_types = ImageType::getImagesTypes();
		foreach ($image_types as $image_type)
		{
			$files_to_delete[] = $this->image_dir.$this->getExistingImgPath().'-'.$image_type['name'].'.'.$this->image_format;
		}
		// Delete watermark image
		$files_to_delete[] = $this->image_dir.$this->getExistingImgPath().'-watermark.'.$this->image_format;
		// delete index.php
		$files_to_delete[] = $this->image_dir.$this->getImgFolder().'index.php';

		foreach ($files_to_delete as $file)
			if (file_exists($file) && !@unlink($file))
				return false;

		// Can we delete the image folder?
		if (is_dir($this->image_dir.$this->getImgFolder()))
		{
			$delete_folder = true;
			foreach (scandir($this->image_dir.$this->getImgFolder()) as $file)
				if (($file != '.' && $file != '..'))
				{
					$delete_folder = false;
					break;
				}
		}
		if (isset($delete_folder) && $delete_folder)
			@rmdir($this->image_dir.$this->getImgFolder());

		return true;
	}

	/**
	 * 删除指定路径下的所有文件与目录
	 *
	 * @param string $path folder containing the product images to delete
	 * @param string $format image format
	 * @return bool success
	 */
	public static function deleteAllImages($path, $format = 'jpg')
	{
		if (!$path || !$format || !is_dir($path))
			return false;
		foreach (scandir($path) as $file)
		{
			if (preg_match('/^[0-9]+(\-(.*))?\.'.$format.'$/', $file))
				unlink($path.$file);
			else if (is_dir($path.$file) && (preg_match('/^[0-9]$/', $file)))
				Image::deleteAllImages($path.$file.'/', $format);
		}

		// Can we remove the image folder?
		if (is_numeric(basename($path)))
		{
			$remove_folder = true;
			foreach (scandir($path) as $file)
				if (($file != '.' && $file != '..' && $file != 'index.php'))
				{
					$remove_folder = false;
					break;
				}

			if ($remove_folder)
			{
				// we're only removing index.php if it's a folder we want to delete
				if (file_exists($path.'index.php'))
					@unlink ($path.'index.php');
				@rmdir($path);
			}
		}

		return true;
	}

	/**
	 * 判断图片是否存
	 *
	 * @ returns string image path
	 */
	public function getExistingImgPath()
	{
		if (!$this->id)
			return false;

		if (!$this->existing_path)
		{
			$this->existing_path = $this->getImgPath();
		}

		return $this->existing_path;
	}

	/**
	 * 获取图片文件夹
	 *
	 * @return string path to folder
	 */
	public function getImgFolder()
	{
		if (!$this->id)
			return false;

		if (!$this->folder){
			$folders = str_split((string)$this->id);
			$this->folder = implode('/', $folders).'/';
		}

		return $this->folder;
	}

	/**
	 * 创建图片文件夹
	 *
	 * @return bool success
	 */
	public function createImgFolder()
	{
		if (!$this->id)
			return false;

		if (!file_exists(_TM_PRO_IMG_DIR.$this->getImgFolder()))
		{
			// Apparently sometimes mkdir cannot set the rights, and sometimes chmod can't. Trying both.
			$success = @mkdir(_TM_PRO_IMG_DIR.$this->getImgFolder(), self::$access_rights, true)
						|| @chmod(_TM_PRO_IMG_DIR.$this->getImgFolder(), self::$access_rights);

			// Create an index.php file in the new folder
			if ($success
				&& !file_exists(_TM_PRO_IMG_DIR.$this->getImgFolder().'index.php')
				&& file_exists($this->source_index))
				return @copy($this->source_index, _TM_PRO_IMG_DIR.$this->getImgFolder().'index.php');
		}
		return true;
	}

	/**
	 * 取得图片路径
	 *
	 * @return string path
	 */
	public function getImgPath()
	{
		if (!$this->id)
			return false;

		$path = $this->getImgFolder().$this->id;
		return $path;
	}

	/**
	 * 初始化图片路径 - 获取图片绝对路径，以及创建图片所需要的目录
	 * @return bool|string
	 */
	public function getPathForCreation()
	{
		if (!$this->id)
			return false;

		$path = $this->getImgPath();
		$this->createImgFolder();

		return _TM_PRO_IMG_DIR.$path;
	}
}
