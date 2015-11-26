<?php
class Import{
	public $csv_file;
	public $allFields = array('brand','quantity','price','old_price','ean13','description','name','image','option','category');
	public $limit	  = '|||';

	public function vlidateFile($csv_file)
	{
		if(file_exists($csv_file)){
			$this->csv_file = $csv_file;
			return true;
		}else
			return	false;
	}
	
	public function start()
	{
		$fp = fopen($this->csv_file,'r');
		$y=0;
		while($prodcut = fgetcsv($fp)){
			if($y==0){
				$y++;
				continue;
			}
			$y++;
			$fields 		= array_combine($this->allFields,$prodcut);

			$fields['id_brand'] = $this->loadBrand($fields['brand']);
			if($id_category = $this->loadCategory($fields['category'])){
				if($id_product = $this->loadProduct($id_category,$fields)){
					$this->loadImage($id_product,$fields['image']);
					$this->loadAttribute($id_product,$fields['option']);
				}
			}
			echo "[".$y."-OK]";
		}
	}
	
	public function loadAttribute($id_product,$option){
	    if(strlen($option)==0)
            return;
		$attributeArr = explode($this->limit,$option);
		$id_attributes = array();
		foreach($attributeArr as $k=>$v){
			//1.判断属性是否存
			$id_attributes[] = $this->_attributeExists($v);
		}
		$product = new Product((int)($id_product));
		$product->updateAttribute($id_attributes);
	}

    private function _attributeExists($v){
    	$v = explode(":",$v);
        $result = Db::getInstance()->getRow(
            'SELECT `id_attribute` FROM '._DB_PREFIX_.'attribute WHERE `name`="'.pSQL($v[1]).'"');
        if(isset($result['id_attribute'])){
        	return $result['id_attribute'];
        }else{
        	$attribute = new Attribute();
			$attribute->id_attribute_group = $v[0];
			$attribute->name = $v[1];
			$attribute->add();
			
        	return $attribute->id;
        }
    }
	
	public function loadImage($id_product,$images)
    {
        $images_array 	= $this->imagesToArray($images);
		$images_id 		= array();
		$product		= new Product($id_product);
		$image_types 	= ImageType::getImagesTypes('product');
		
        if ($images_array)
            foreach ($images_array as $img)
            {
                if (file_exists(_TM_ROOT_DIR_.$img['url']))
                {
                    //ajout de l'image au produit
                    $image = new Image();
                    $image->id_product = intval($product->id);
                    $image->position = Image::getHighestPosition($product->id) + 1;
                    if (!intval($product->id_image_default))
                        $image->cover = 1;
					else
						$image->cover = 0;
                    $image->legend = 0;
                    $image->add();
					if($image->cover)
						$product->id_image_default = (int)($image->id);
                    $id_image = $image->id;
                    $images_id[] = $id_image;
					$path = $image->getPathForCreation();

                    //echo $imgDir.$img['url'];
                    @copy(_TM_ROOT_DIR_.$img['url'], $path.'.jpg');
                    
                    foreach ($image_types AS $k=>$image_type)
						ImageManager::resize(_TM_ROOT_DIR_.$img['url'], $path.'-'.stripslashes($image_type['name']).'.jpg', $image_type['width'], $image_type['height']);
                    //@unlink($tmpName);
                }else{
					$this->_output .= '<div class="alert error">Image not exists!</div>';
				}
				$product->update();
            }
        return $images_id;
     }
	 
	 public function getImageName($option)
    {
        $tok = strtok($option, "/");
        $name = "";
        while ($tok !== false)
        {
            $name = $tok;
            $tok = strtok("/");
        }
        $name = trim($name, ".jpg");
        return $name;
    }

	public function imagesToArray($images)
    {
        $imagesarray = array();
        $urls = explode($this->limit, $images);
		$urls = array_unique($urls);
        foreach ($urls as $url)
        {
            $name = trim($this->getImageName($url));
            $imagesarray[] = array("name"=>$name, "url"=>trim($url));
        }
        return $imagesarray;
    }
	
	public function loadProduct($id_category,$fields)
	{
		$product = new Product();
		$product->copyFromPost();
		$product->id_category_default 	=  (int)end($id_category);
		$product->id_brand 				=  (int)$fields['id_brand'];
		$product->price 				=  (float)$fields['price'];
		$product->special_price			=  (float)$fields['old_price'];
		$product->ean13 				=   pSQL($fields['ean13']);
		$product->weight 				=  1;
		$product->in_stock 				=  1;
		$product->quantity 				=  (float)$fields['quantity'];
		$product->name 					=   pSQL($fields['name']);
		$product->rewrite				=   pSQL(preg_replace("/[^-0-9a-zA-Z]+/","",str_replace(' ','-',trim($fields['name']))));
		$product->description			=	pSQL($fields['description'],true);
		$product->active				= 1;
		if($product->add()){
			$product->updateCategories($id_category);
			return (int)($product->id);
		}else{
			print_r($product->_errors);
		}
	}
	
    public function loadBrand($str_brand)
    {
		$id_brand = 0;
		if(!$result = $this->_brandExists($str_brand)){
			$brand = new Brand();
			$brand->copyFromPost();
			$brand->name        = pSQL($str_brand);
			$brand->rewrite 	= "brand-".pSQL(preg_replace("/[^-0-9a-zA-Z]+/","",str_replace(' ','-',trim($str_brand))));
			$brand->add();
			$id_brand = $brand->id;
		}else{
		   $id_brand = $result; 
		}
        return $id_brand;
    }

    public function loadCategory($str_category)
    {
        $categoryArr = explode($this->limit,$str_category);
        array_pop($categoryArr);
        array_shift($categoryArr);
        $id_parent = 1;
		$category_paths = array();
        foreach($categoryArr as $name){
            if(!$result = $this->_catelogExists($name,$id_parent)){
                $category = new Category();
				$category->copyFromPost();
				$category->name         = pSQL($name);
				$category->active       = 1;
                $category->id_parent    = (int)($id_parent);
                $category->rewrite 		= pSQL(preg_replace("/[^-0-9a-zA-Z]+/","",str_replace(' ','-',trim($name))));
				$category->add();
                $id_parent = $category->id;
                unset($category);
            }else{
               $id_parent = $result; 
            }
			$category_paths[] = $id_parent;
        }
        return $category_paths;
    }

	private function _brandExists($name){
        $result = Db::getInstance()->getRow(
           'SELECT id_brand
			FROM '._DB_PREFIX_.'brand
			WHERE `name`="'.pSQL($name).'"');
        return isset($result['id_brand'])?$result['id_brand']:0;
    }

    private function _catelogExists($name,$id_parent){
        $result = Db::getInstance()->getRow(
           'SELECT c.id_category
			FROM '._DB_PREFIX_.'category AS c
			WHERE c.`name`="'.pSQL($name).'" AND c.`id_parent`='.intval($id_parent));
        return isset($result['id_category'])?$result['id_category']:0;
    }
	
	private function _checkImage($img,$size=400)
	{
		$img = _TM_ROOT_DIR_.$img;
		if(file_exists($img)){
			echo $img;
			$as =  getimagesize($img);
			if(($as[0]+$as[1])>=$size)
				return true;
		}
		return false;
	}
}
?>