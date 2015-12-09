<?php 
class Carrier extends ObjectBase{
	protected $fields = array(
		'name' => array(
			'type' => 'isName',
			'size' => '56',
			'required' => true,
		),
		'id_image' => array(
			'type' => 'isInt',
		),
		'description' => array(
			'type' => 'isMessage',
		),
		'shipping' => array(
			'type' => 'isPrice',
		),
		'active' => array(
			'type' => 'isInt',
		),
	);

	protected $identifier 		= 'id_carrier';
	protected $table			= 'carrier';

	/**
	 * 更新LOGO
	 *
	 * @return bool
	 */
	public function updateLogo()
	{
		if (!isset($_FILES['qqfile'])) {
			return true;
		}

		$uploader = new FileUploader();
		$result = $uploader->handleUpload('brand');
		if (isset($result['success'])) {
			if ($this->id_image > 0 ) {
				$image = new Image($this->id_image);
				if (Validate::isLoadedObject($image)) {
					$image->delete();
				}
			}
			$this->id_image = $result['success']['id_image'];
			return $this->update();
		}
		return false;
	}

	/**
	 * 重载品牌数组
	 * @param $result
	 * @return mixd
	 */
	public static function reLoad($result) {
		if (!is_array($result) || !$result) {
			return false;
		}

		foreach($result as &$row) {
			$row['image_small'] = Image::getImageLink($row['id_image'], 'small');
		}

		return $result;
	}
	
	public static function getEntity($p=1, $limit=50, $orderBy = NULL, $orderWay = NULL, $filter=array())
	{

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

		$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'.DB_PREFIX.'carrier` a
				WHERE 1
				'.$where);
		if($total == 0)
			return false;

		$result = Db::getInstance()->getAll('SELECT a.* FROM `'.DB_PREFIX.'carrier` a
				WHERE 1
				'.$where.'
				'.$postion.'
				LIMIT '.(($p - 1) * $limit) . ','.(int) $limit);
		$rows   = array(
				'total' => $total['total'],
				'entitys'  => self::reLoad($result));
		return $rows;
	}
}
?>