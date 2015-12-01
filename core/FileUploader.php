<?php
class FileUploader
{
	protected $allowedExtensions = array();
	protected $file;
	protected $sizeLimit;

	public function __construct(array $allowedExtensions = array('jpeg', 'gif', 'png', 'jpg'), $sizeLimit = 10485760)
	{
		$allowedExtensions = array_map('strtolower', $allowedExtensions);

		$this->allowedExtensions = $allowedExtensions;
		$this->sizeLimit = $sizeLimit;

		if (isset($_FILES['qqfile']))
            $this->file = new QqUploadedFileForm();
        else
            $this->file = false;
	}

	protected function toBytes($str)
	{
		$val = trim($str);
		$last = strtolower($str[strlen($str) - 1]);
		switch ($last)
		{
			case 'g': $val *= 1024;
			case 'm': $val *= 1024;
			case 'k': $val *= 1024;
		}
		return $val;
	}

	/**
	 * Returns array('success'=>true) or array('error'=>'error message')
	 */
	public function handleUpload($type)
	{
		if (!$this->file)
			return array('error' => Tools::displayError('No files were uploaded.'));

		if (empty($type) || !$type)
			return array('error' => Tools::displayError('No files type.'));

		$size = $this->file->getSize();

		if ($size == 0)
			return array('error' => Tools::displayError('File is empty'));
		if ($size > $this->sizeLimit)
			return array('error' => Tools::displayError('File is too large'));

		$pathinfo = pathinfo($this->file->getName());
		$these = implode(', ', $this->allowedExtensions);
		if (!isset($pathinfo['extension']))
			return array('error' => Tools::displayError('File has an invalid extension, it should be one of').$these.'.');
		$ext = $pathinfo['extension'];
		if ($this->allowedExtensions && !in_array(strtolower($ext), $this->allowedExtensions))
			return array('error' => Tools::displayError('File has an invalid extension, it should be one of').$these.'.');

		return $this->file->save($type);

	}
}

class QqUploadedFileForm
{
    /**
     * Save the file to the specified path
     * @return boolean TRUE on success
     */
	public function save($type)
	{
			$image = new Image();
			if (!$image->add())
				return array('error' => Tools::displayError('Error while creating additional image'));
			else
				return $this->copyImage($image->id, $type);

	}

	public function copyImage($id_image, $type = 'product')
	{
		$image = new Image($id_image);
		if (!$new_path = $image->getPathForCreation())
			return array('error' => Tools::displayError('An error occurred during new folder creation'));
		if (!($tmpName = tempnam(_TM_PRO_IMG_DIR, 'PS')) || !move_uploaded_file($_FILES['qqfile']['tmp_name'], $tmpName))
			return array('error' => Tools::displayError('An error occurred during the image upload'));
		elseif (!ImageManager::resize($tmpName, $new_path.'.'.$image->image_format))
			return array('error' => Tools::displayError('An error occurred while copying image.'));
		else{
			$imagesTypes = ImageType::getImagesTypes($type);
			foreach ($imagesTypes as $imageType)
			{
				if (!ImageManager::resize($tmpName, $new_path.'-'.stripslashes($imageType['name']).'.'.$image->image_format, $imageType['width'], $imageType['height'], $image->image_format))
					return array('error' => Tools::displayError('An error occurred while copying image:').' '.stripslashes($imageType['name']));
			}
		}
		unlink($tmpName);

		$img = array('id_image' => $image->id, 'name' => $this->getName());
		return array('success' => $img);
	}

    public function getName()
    {
        return $_FILES['qqfile']['name'];
    }

    public function getSize()
    {
        return $_FILES['qqfile']['size'];
    }
}