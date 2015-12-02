<?php 
class Feedback extends ObjectBase{

	protected $fields = array(
		'id_user' => array('type' => 'isInt'),
		'id_product' => array('type' => 'isInt'),
		'rating' => array('type' => 'isInt'),
		'unit_price' => array('type' => 'isPrice'),
		'quantity' => array('type' => 'isInt'),
		'name' => array('type' => 'isName'),
		'flag_code' => array('type' => 'isLanguageIsoCode'),
		'feedback' => array('type' => 'isMessage'),
		'md5_key' => array('type' => 'isMd5'),
		'active' => array('type' => 'isInt'),
		'add_date' => array('type' => 'isDate'),
	);
	
	public function statusSelection($ids,$action)
	{
		$rating_fields = array("one_star","two_star","three_star","four_star","five_star");
		parent::statusSelection($ids,$action);
		$result = Db::getInstance()->getAll('SELECT * FROM '.DB_PREFIX.'feedback WHERE id_feedback IN('.pSQL(implode(',',$ids)).')');
		foreach($result as $row){
			$field = pSQL($rating_fields[$row["rating"]-1]);
			if($this->feedbackStateExists($row['id_product'])){
				Db::getInstance()->exec('UPDATE '.DB_PREFIX.'feedback_state SET times=times+1,total_rating=total_rating+'.(int)$row["rating"].",`".$field."`=`".$field."`+1
				WHERE id_product=".intval($row['id_product']));
			}else{
				Db::getInstance()->exec('INSERT INTO '.DB_PREFIX.'feedback_state SET id_product='.intval($row['id_product']).',times=1,total_rating='.(int)$row["rating"].",`".$field."`=`".$field."`+1");
			}
		}
		return true;
	}
	
	public static function getEntity($p=1, $limit=50, $orderBy = NULL, $orderWay = NULL, $filter=array())
	{
		$where = '';
		if(!empty($filter['id_feedback']))
			$where .= ' AND a.`id_feedback`='.intval($filter['id_feedback']);
		if(!empty($filter['name']))
			$where .= ' AND a.`name`='.intval($filter['name']);
		if(!empty($filter['id_product']))
			$where .= ' AND a.`id_product`='.intval($filter['id_product']);
		if(!empty($filter['active']))
			$where .= ' AND a.`active`='.intval($filter['active']);
		if(!empty($filter['rating']))
			$where .= ' AND a.`rating`='.intval($filter['rating']);
		if(!empty($filter['flag_code']))
			$where .= ' AND a.`flag_code` ="'.pSQL($filter['flag_code']).'"';
		
		if(!is_null($orderBy) AND !is_null($orderWay))
		{
			$postion = 'ORDER BY '.pSQL($orderBy).' '.pSQL($orderWay);
		}else{
			$postion = 'ORDER BY `id_feedback` DESC';
		}

		$total  = Db::getInstance()->getValue('SELECT count(*) AS total FROM `'.DB_PREFIX.'feedback` a
				WHERE 1
				'.$where);
		if($total == 0)
			return false;

		$result = Db::getInstance()->getAll('SELECT a.* FROM `'.DB_PREFIX.'feedback` a
				WHERE 1
				'.$where.'
				'.$postion.'
				LIMIT '.(($p-1)*$limit).','.(int)$limit);
		$rows   = array(
				'total' => $total,
				'entitys'  => $result);
		return $rows;
	}
	
	public function feedbackStateExists($id_product)
	{
		$total = Db::getInstance()->getValue('SELECT COUNT(*) AS total FROM `'.DB_PREFIX.'feedback_state` WHERE id_product='.intval($id_product));

		if($total==0)
			return false;
		return true;
	}
	
	static public function haveFeedbackWithUser($id_user)
	{
		$result = Db::getInstance()->getAll('SELECT md5_key FROM `'.DB_PREFIX.'feedback` WHERE id_user='.intval($id_user));
		$product_ids = array();
		if($result)
			foreach($result as $row)
				$product_ids[]=$row['md5_key'];
		$product_ids = array_unique($product_ids);
		return $product_ids; 
	}
	
	static public function feedbackWithProdict($id_product)
	{
		$state  = Db::getInstance()->getRow('SELECT * FROM `'.DB_PREFIX.'feedback_state` WHERE id_product='.intval($id_product));
		if($state){
			$state['average'] 	= round($state['total_rating']/$state['times'],2);
			$state['total_pt'] 	= round($state['average']/5,4)*100;
			$state['five_pt'] 	= round($state['five_star']/$state['times'],4)*100;
			$state['four_pt'] 	= round($state['four_star']/$state['times'],4)*100;
			$state['three_pt'] 	= round($state['three_star']/$state['times'],4)*100;
			$state['two_pt'] 	= round($state['two_star']/$state['times'],4)*100;
			$state['one_pt'] 	= round($state['one_star']/$state['times'],4)*100;
		}
		$result = Db::getInstance()->getAll('SELECT * FROM `'.DB_PREFIX.'feedback` WHERE active=1 AND id_product='.intval($id_product));
		$feedbacks = array();
		$feedbacks['state'] = $state;
		$feedbacks['rows']	= $result;
		return $feedbacks;
	}
}
?>