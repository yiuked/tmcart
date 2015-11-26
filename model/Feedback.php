<?php 
class Feedback extends ObjectBase{
	protected $fields 			= array('id_user','id_product','unit_price','quantity','md5_key','rating','name','flag_code','feedback','active','add_date');
	protected $fieldsRequired	= array('id_product','rating','name','flag_code','feedback','unit_price','quantity','md5_key');
	protected $fieldsSize 		= array('feedback' => 256);
	protected $fieldsValidate	= array(
		'active'=> 'isBool',
		'feedback' => 'isGenericName');
	
	protected $identifier 		= 'id_feedback';
	protected $table			= 'feedback';
	
	public function getFields()
	{
		if (isset($this->id))
			$fields['id_feedback'] 	= (int)($this->id);
		$fields['id_user'] 			= (int)($this->id_user);
		$fields['id_product'] 		= (int)($this->id_product);
		$fields['rating'] 			= (int)($this->rating);
		$fields['unit_price'] 		= (float)($this->unit_price);
		$fields['quantity'] 		= (int)($this->quantity);
		$fields['name'] 			= pSQL($this->name);
		$fields['flag_code']		= pSQL($this->flag_code);
		$fields['feedback'] 		= pSQL($this->feedback);
		$fields['md5_key'] 			= pSQL($this->md5_key);
		$fields['active'] 			= (int)($this->active);
		$fields['add_date'] 		= pSQL($this->add_date);
		parent::validation();
		return $fields;
	}
	
	public function statusSelection($ids,$action)
	{
		$rating_fields = array("one_star","two_star","three_star","four_star","five_star");
		parent::statusSelection($ids,$action);
		$result = Db::getInstance()->ExecuteS('SELECT * FROM '._DB_PREFIX_.'feedback WHERE id_feedback IN('.pSQL(implode(',',$ids)).')');
		foreach($result as $row){
			$field = pSQL($rating_fields[$row["rating"]-1]);
			if($this->feedbackStateExists($row['id_product'])){
				Db::getInstance()->Execute('UPDATE '._DB_PREFIX_.'feedback_state SET times=times+1,total_rating=total_rating+'.(int)$row["rating"].",`".$field."`=`".$field."`+1 
				WHERE id_product=".intval($row['id_product']));
			}else{
				Db::getInstance()->Execute('INSERT INTO '._DB_PREFIX_.'feedback_state SET id_product='.intval($row['id_product']).',times=1,total_rating='.(int)$row["rating"].",`".$field."`=`".$field."`+1");
			}
		}
		return true;
	}
	
	public static function getEntity($active = true,$p=1,$limit=50,$orderBy = NULL,$orderWay = NULL,$filter=array())
	{
	 	if (!Validate::isBool($active))
	 		die(Tools::displayError());

		$where = '';
		if(!empty($filter['id_feedback']) && Validate::isInt($filter['id_feedback']))
			$where .= ' AND a.`id_feedback`='.intval($filter['id_feedback']);
		if(!empty($filter['name']) && Validate::isInt($filter['name']))
			$where .= ' AND a.`name`='.intval($filter['name']);
		if(!empty($filter['id_product']) && Validate::isInt($filter['id_product']))
			$where .= ' AND a.`id_product`='.intval($filter['id_product']);
		if(!empty($filter['rating']) && Validate::isInt($filter['rating']))
			$where .= ' AND a.`rating`='.intval($filter['rating']);
		if(!empty($filter['flag_code']) && Validate::isCatalogName($filter['flag_code']))
			$where .= ' AND a.`flag_code` ="'.pSQL($filter['flag_code']).'"';
		
		if(!is_null($orderBy) AND !is_null($orderWay))
		{
			$postion = 'ORDER BY '.pSQL($orderBy).' '.pSQL($orderWay);
		}else{
			$postion = 'ORDER BY `id_feedback` DESC';
		}

		$total  = Db::getInstance()->getValue('SELECT count(*) AS total FROM `'._DB_PREFIX_.'feedback` a
				WHERE a.`active`='.($active?'1':'0').'
				'.$where);
		if($total==0)
			return false;

		$result = Db::getInstance()->ExecuteS('SELECT a.* FROM `'._DB_PREFIX_.'feedback` a
				WHERE a.`active`='.($active?'1':'0').'
				'.$where.'
				'.$postion.'
				LIMIT '.(($p-1)*$limit).','.(int)$limit);
		$rows   = array(
				'total' => $total['total'],
				'entitys'  => $result);
		return $rows;
	}
	
	public function feedbackStateExists($id_product)
	{
		$total = Db::getInstance()->getValue('SELECT COUNT(*) AS total FROM `'._DB_PREFIX_.'feedback_state` WHERE id_product='.intval($id_product));

		if($total==0)
			return false;
		return true;
	}
	
	static public function haveFeedbackWithUser($id_user)
	{
		$result = Db::getInstance()->ExecuteS('SELECT md5_key FROM `'._DB_PREFIX_.'feedback` WHERE id_user='.intval($id_user));
		$product_ids = array();
		if($result)
			foreach($result as $row)
				$product_ids[]=$row['md5_key'];
		$product_ids = array_unique($product_ids);
		return $product_ids; 
	}
	
	static public function feedbackWithProdict($id_product)
	{
		$state  = Db::getInstance()->getRow('SELECT * FROM `'._DB_PREFIX_.'feedback_state` WHERE id_product='.intval($id_product));
		if($state){
			$state['average'] 	= round($state['total_rating']/$state['times'],2);
			$state['total_pt'] 	= round($state['average']/5,4)*100;
			$state['five_pt'] 	= round($state['five_star']/$state['times'],4)*100;
			$state['four_pt'] 	= round($state['four_star']/$state['times'],4)*100;
			$state['three_pt'] 	= round($state['three_star']/$state['times'],4)*100;
			$state['two_pt'] 	= round($state['two_star']/$state['times'],4)*100;
			$state['one_pt'] 	= round($state['one_star']/$state['times'],4)*100;
		}
		$result = Db::getInstance()->ExecuteS('SELECT * FROM `'._DB_PREFIX_.'feedback` WHERE active=1 AND id_product='.intval($id_product));
		$feedbacks = array();
		$feedbacks['state'] = $state;
		$feedbacks['rows']	= $result;
		return $feedbacks;
	}
}
?>