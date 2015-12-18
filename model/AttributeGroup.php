<?php 
class AttributeGroup extends ObjectBase{

	const GROUP_TYPE_SELECT = 1;
	const GROUP_TYPE_RADIO = 2;
	const GROUP_TYPE_CHECKBOX = 3;

	protected $fields	= array(
		'name' => array(
			'required' => true,
			'size' => 56,
			'type' => 'isGenericName',
		),
		'group_type' => array(
			'required' => true,
			'type' => 'isInt',
		),
		'position' => array(
			'type' => 'isInt',
		),
	);

	protected $identifier 		= 'id_attribute_group';
	protected $table			= 'attribute_group';
	
	public function add()
	{
		$this->position = $this->getLastPosition();
		return parent::add();
	}
	
	public function delete()
	{
		if(parent::delete())
		{
			$ret = true;
			$attributes = $this->getAttributes();
			foreach($attributes as $attribute){
				$attr = new Attribute((int)($attribute['id_attribute']));
				$ret &= $attr->delete();
			}
			return $ret;
		}
	} 
	
	public static function loadData($p = 1, $limit = 50, $orderBy = NULL, $orderWay = NULL, $filter = array())
	{

		$where = '';
		if(!empty($filter['id_attribute_group']) && Validate::isInt($filter['id_attribute_group']))
			$where .= ' AND a.`id_attribute_group`='.intval($filter['id_attribute_group']);
		if(!empty($filter['name']) && Validate::isCatalogName($filter['name']))
			$where .= ' AND a.`name` LIKE "%'.pSQL($filter['name']).'%"';
		
		if(!is_null($orderBy) AND !is_null($orderWay))
		{
			$postion = 'ORDER BY '.pSQL($orderBy).' '.pSQL($orderWay);
		}else{
			$postion = 'ORDER BY `position` ASC';
		}

		$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'.DB_PREFIX.'attribute_group` a
				WHERE 1 '.$where);
		if($total==0)
			return false;

		$result = Db::getInstance()->getAll('SELECT a.* FROM `'.DB_PREFIX.'attribute_group` a
				WHERE 1 '.$where.'
				'.$postion.'
				LIMIT '.(($p-1)*$limit).','.(int)$limit);
		$rows   = array(
				'total' => $total['total'],
				'items'  => $result);
		return $rows;
	}
	
	public function getAttributes()
	{
		return Db::getInstance()->getAll('
				   SELECT * FROM `'.DB_PREFIX.'attribute`
				   WHERE `id_attribute_group`='.(int)($this->id).'
				   ORDER BY position ASC
		');
	}

	public static function getAttributeAndGrop()
	{
		$attributes = array();
		$result = Db::getInstance()->getAll('SELECT a.id_attribute,a.`name`,a.id_attribute_group,g.`name` AS g_name
			FROM '.DB_PREFIX.'attribute AS a
			LEFT JOIN '.DB_PREFIX.'attribute_group AS g ON a.id_attribute_group = g.id_attribute_group
			ORDER BY a.position ASC');
		if(!$result)
			return $attributes;

		foreach($result as $row){
			$attributes[$row['id_attribute_group']]['id_attribute_group'] = $row['id_attribute_group'];
			$attributes[$row['id_attribute_group']]['name'] = $row['g_name'];
			$attributes[$row['id_attribute_group']]['attributes'][$row['id_attribute']]['id_attribute'] = $row['id_attribute'];
			$attributes[$row['id_attribute_group']]['attributes'][$row['id_attribute']]['id_attribute_group'] = $row['id_attribute_group'];
			$attributes[$row['id_attribute_group']]['attributes'][$row['id_attribute']]['name'] = $row['name'];
		}
		return 	$attributes;
	}
}
?>