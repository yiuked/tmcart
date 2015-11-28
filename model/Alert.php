<?php
class Alert extends ObjectBase
{
	protected 	$fields 			= array('id_user','content','is_read','add_date');
 	protected 	$fieldsRequired 	= array('id_user', 'content');
	
	protected 	$table = 'alert';
	protected 	$identifier = 'id_alert';

	public function getFields()
	{
		parent::validation();
		if (isset($this->id))
			$fields['id_alert'] = (int)($this->id);
		$fields['id_user'] = (int)($this->id_user);
		$fields['is_read'] = (int)($this->is_read);
		$fields['content'] = pSQL($this->content);
		$fields['add_date'] = pSQL($this->add_date);
		return $fields;
	}
	
	public static function send($id_user,$content)
	{
		$alert = new Alert();
		$alert->id_user = (int)$id_user;
		$alert->is_read = 0;
		$alert->content = pSQL($content);
		$alert->add_date = "";
		return $alert->add();
	}
	
	public static function alerts($id_user)
	{
		$result = Db::getInstance()->getAll('SELECT * FROM '.DB_PREFIX.'alert
				  WHERE id_user='.(int)($id_user).' ORDER BY id_alert DESC');
		if(!$result)
			return 0;
		return $result;
	}
	
	public static function getAlertSumByUser()
	{
		global $cookie;
		$array = array(
				'count'=>0
				);
		if(isset($cookie->id_user)&&$cookie->id_user>0){
			$result = Db::getInstance()->getValue('SELECT count(*) FROM '.DB_PREFIX.'alert WHERE is_read=0 AND id_user='.intval($cookie->id_user));
			if($result)
			{
				$array['count'] = (int)($result);
			}
		}
		return $array;
	}
}