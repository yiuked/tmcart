<?php 
class Carrier extends ObjectBase{
	protected $fields 			= array('name','logo','description','shipping','active');
	protected $fieldsRequired	= array('name');
	protected $fieldsSize 		= array('name' => 56, 'description' => 256);
	protected $fieldsValidate	= array(
		'active'=> 'isBool',
		'name' => 'isName', 
		'shipping' => 'isPrice', 
		'description' => 'isMessage');
	
	protected $identifier 		= 'id_carrier';
	protected $table			= 'carrier';
	public 	  $img_dir;
	
	public function __construct($id = NULL)
	{
		parent::__construct($id);
		$this->img_dir = _TM_IMG_DIR.'car/';
	}
	
	public function getFields()
	{
		parent::validation();
		if (isset($this->id))
			$fields['id_carrier'] = (int)($this->id);
		$fields['name'] = pSQL($this->name);
		$fields['logo'] = pSQL($this->logo);
		$fields['description'] = pSQL($this->description);
		$fields['shipping'] = floatval($this->shipping);
		$fields['active'] = isset($this->active);
		return $fields;
	}
	
	public function updateCarrierLogo()
	{
		$allowedExtensions 	= array('jpg','png','gif');
		$filename 			= $this->id.'-'.$_FILES['logo']['name'];
		$pathinfo 			= pathinfo($filename);
		$ext 				= $pathinfo['extension'];
		$tmpName			= $this->img_dir.$filename;
		if(in_array(strtolower($ext),$allowedExtensions))
			!move_uploaded_file($_FILES['logo']['tmp_name'], $tmpName);
		Db::getInstance()->Execute('UPDATE `'._DB_PREFIX_.'carrier` SET `logo`="'.pSQL($filename).'" WHERE `id_carrier`='.(int)($this->id));
	}
	
	public static function getEntity($active = true,$p=1,$limit=50,$orderBy = NULL,$orderWay = NULL,$filter=array())
	{
	 	if (!Validate::isBool($active))
	 		die(Tools::displayError());

		$where = '';
		if(!empty($filter['id_carrier']) && Validate::isInt($filter['id_carrier']))
			$where .= ' AND a.`id_carrier`='.intval($filter['id_carrier']);
		if(!empty($filter['name']) && Validate::isCatalogName($filter['name']))
			$where .= ' AND a.`name` LIKE "%'.pSQL($filter['name']).'%"';
		if(!empty($filter['active']) && Validate::isInt($filter['active']))
			$where .= ' AND a.`active`='.((int)($filter['active'])==1?'1':'0');
		if(!empty($filter['shipping']) && Validate::isPrice($filter['shipping']))
			$where .= ' AND a.`shipping`='.($filter['shipping']);
		if(!empty($filter['description']) && Validate::isInt($filter['description']))
			$where .= ' AND a.`description` LIKE "%'.pSQL($filter['description']).'%"';
		
		if(!is_null($orderBy) AND !is_null($orderWay))
		{
			$postion = 'ORDER BY '.pSQL($orderBy).' '.pSQL($orderWay);
		}else{
			$postion = 'ORDER BY `id_carrier` DESC';
		}

		$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'._DB_PREFIX_.'carrier` a
				WHERE 1 '.($active?' AND a.`active`=1 ':'').'
				'.$where);
		if($total==0)
			return false;

		$result = Db::getInstance()->ExecuteS('SELECT a.* FROM `'._DB_PREFIX_.'carrier` a
				WHERE 1 '.($active?' AND a.`active`=1 ':'').'
				'.$where.'
				'.$postion.'
				LIMIT '.(($p-1)*$limit).','.(int)$limit);
		$rows   = array(
				'total' => $total['total'],
				'entitys'  => $result);
		return $rows;
	}
}
?>