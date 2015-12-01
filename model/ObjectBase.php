<?php
abstract class ObjectBase{
	/** @var integer Object id */
	public $id;

	/** @var integer lang id */
	protected $fields = array();
	
	/** @var array */
	public $_errors = array();
	
	/** @var string SQL Table name */
	protected $table = NULL;

	/** @var string SQL Table identifier */
	protected $identifier = NULL;
	
	public function __construct($id = NULL)
	{	
		
		if ($id)
		{
			$result = Db::getInstance()->getRow('
				SELECT * FROM `'.DB_PREFIX.$this->table.'`  WHERE `'.$this->identifier.'` = '.(int)($id));

			if ($result)
			{
				$this->id = (int)($id);
				if (isset($this->identifier)) {
					$this->{$this->identifier} = (int)$id;
				}
				foreach($this->fields as $key => $more){
					if (array_key_exists($key, $result)) {
						$this->{$key} = $result[$key];
					}
				}
			}
		}
	}
	
	public function load()
	{
		if($this->id)
		{
			$result = Db::getInstance()->getRow('
				SELECT * FROM `'.DB_PREFIX.$this->table.'`  WHERE `'.$this->identifier.'` = '.(int)($this->id));

			if ($result)
			{
				if (isset($this->identifier)) {
					$this->{$this->identifier} = (int)$this->id;
				}
				foreach($this->fields as $key => $more){
					if (array_key_exists($key, $result)) {
						$this->{$key} = $result[$key];
					}
				}
			}
		}
	}
	
	/**
	 * Status several categories from database
	 *
	 * return boolean Status result
	 */
	public function statusSelection($ids,$action)
	{
		if (!Validate::isTableOrIdentifier($this->identifier) OR !Validate::isTableOrIdentifier($this->table))
			die('Fatal error:Object not exist!');

		return Db::getInstance()->exec('
			UPDATE `' . DB_PREFIX . $this->table .'`
			SET `active`= ' . (int)$action . '
			WHERE `' . $this->identifier . '` IN(' . implode(',', array_map('intval',$ids)) . ')');
	}
	
	/**
	 * Delete several categories from database
	 *
	 * return boolean Deletion result
	 */
	public function deleteSelection($ids)
	{
		$return = 1;
		foreach ($ids AS $id)
		{
			$obj_name = get_class($this);
			$obj = new $obj_name;
			$obj->id = $id;
			$obj->load();
			$return &= $obj->delete();
		}
		return $return;
	}
	
	/**
	 * Copy datas from $_POST to object
	 *
	 * @param object &$object Object
	 * @param string $table Object table
	 */
	public function copyFromPost()
	{
		/* Classical fields */
		foreach ($this->fields AS $key => $more) {
			if (array_key_exists($key, $_POST))
			{
				/* Do not take care of password field if empty */
				if ($key == 'passwd' AND empty($_POST[$key])) {
					continue;
				}
				/* Automatically encrypt password in MD5 */
				if ($key == 'passwd' AND !empty($_POST[$key])) {
					$this->{$key} = Tools::encrypt($_POST[$key]);
				} else {
					$this->{$key} = $_POST[$key];
				}
			} elseif (isset($this->{$key}) && !empty($this->{$key}) && $this->{$key} != null){
				continue;
			} else {
				$this->{$key} = '';
			}
		}
	}

	public function validation()
	{
		//Field Required
		$fields = array();

		foreach($this->fields as $key => $more){
			if (isset($this->{$key})) {
				if (isset($more['required']) && $more['required']) {
					if(empty(trim($this->{$key}))) {
						$this->_errors[] =  $key .' is required ';
					}
				}
				if (isset($more['size']) && Tools::strlen($this->{$key}) > $more['size']) {
					$this->_errors[] =  $key .' lenght overflow '.$more['size'];
				}
				$validate = new Validate();
				if (isset($more['type'])) {
					if (!method_exists($validate, $more['type'])) {
						$this->_errors[] =  $key .' validation function not found '.$more['type'];
					}elseif (!empty(trim($this->{$key})) && !call_user_func(array('Validate', $more['type']), $this->{$key})){
						$this->_errors[] = $key . ' Content has not allowed characters';
					} else {
						switch ($more['type']) {
							case 'isInt':
								$fields[$key] = intval($this->{$key});
								break;
							case 'isFloat';
								$fields[$key] = floatval($this->{$key});
								break;
							case 'isCleanHtml';
								$fields[$key] = pSQL($this->{$key}, true);
								break;
							default:
								$fields[$key] = pSQL($this->{$key});
								break;
						}
					}
				} else {
					$this->_errors[] = $key . ' type is not set';
				}
			}
		}
		return $fields;
	}

	/**
	 * 添加对象到数据库
	 * @return bool
	 */
	public function add()
	{		
		$fields = $this->validation();

		if(count($this->_errors)>0 AND is_array($this->_errors))
			return false;
			
		/* Automatically fill dates */
		if (array_key_exists('add_date', $fields) AND empty(trim($fields['add_date']))){
			$this->add_date 	= date('Y-m-d H:i:s');
			$fields['add_date']	= $this->add_date;
		}
		if (array_key_exists('upd_date', $fields) AND empty(trim($fields['upd_date']))){
			$this->upd_date = date('Y-m-d H:i:s');
			$fields['upd_date']	= $this->upd_date;
		}


		/* Database insertion */
		$result = Db::getInstance()->insert(DB_PREFIX.$this->table, $fields);
		
		if (!$result)
			return false;
			
		$this->id = Db::getInstance()->Insert_ID();
		$this->identifier = $this->id;
		
		if (array_key_exists('rewrite', $fields)){
			$rule = new Rule();
			$rule->entity    = pSQL(get_class($this));
			$rule->view_name = Tools::getRequest('view_name') ? Tools::getRequest('view_name'):pSQL(get_class($this).'View');
			$rule->id_entity = (int) $this->id;
			$rule->rule_link = strtolower(pSQL($this->rewrite));
			$rule->add();
		}
		
		return $result;
	}
	
	/**
	 * Update current object to database
	 *
	 * @param bool $null_values
	 * @return boolean Update result
	 */
	public function update()
	{

		$fields = $this->validation();
		if(count($this->_errors)>1 AND is_array($this->_errors))
			return false;

		// Automatically fill dates
		if (array_key_exists('upd_date', $fields) AND (empty($fields['upd_date']) || $fields['upd_date'] == null)){
			$this->upd_date = date('Y-m-d H:i:s');
			$fields['upd_date']	= $this->upd_date;
		}

		$result = Db::getInstance()->update(DB_PREFIX.$this->table, $fields, '`'.pSQL($this->identifier).'` = '.(int)($this->id));

		if ($result === false)
			return false;

		if (array_key_exists('rewrite', $fields)){
			$rule = Rule::loadRule(array(
							'entity' => pSQL(get_class($this)),
							'id_entity' => (int) $this->id
					));
			if(Validate::isLoadedObject($rule)){
				$rule->rule_link = strtolower(pSQL($this->rewrite));
				$rule->view_name = Tools::getRequest('view_name')?Tools::getRequest('view_name'):pSQL(get_class($this).'View');
				$rule->update();
			}else{
				$rule = new Rule();
				$rule->entity    = pSQL(get_class($this));
				$rule->view_name = Tools::getRequest('view_name')?Tools::getRequest('view_name'):pSQL(get_class($this).'View');
				$rule->id_entity = (int) $this->id;
				$rule->rule_link = strtolower(pSQL($this->rewrite));
				$rule->add();
			}
		}
		
		return true;
	}
	
	/**
	 * Delete current object from database
	 *
	 * return boolean Deletion result
	 */
	public function delete()
	{
	 	if (!Validate::isTableOrIdentifier($this->identifier) OR !Validate::isTableOrIdentifier($this->table))
	 		die(Tools::displayError());

		/* Database deletion */
		$result = Db::getInstance()->exec('DELETE FROM `'.pSQL(DB_PREFIX.$this->table).'` WHERE `'.pSQL($this->identifier).'` = '.(int)($this->id));
		if (!$result)
			return false;

		if (key_exists('rewrite', $this)){
			$rule = Rule::loadRule(array(
							'entity' => pSQL(get_class($this)),
							'id_entity' => (int) $this->id
					));
			if(Validate::isLoadedObject($rule)){
				$rule->delete();
			}
		}

		return $result;
	}

	/**
	 * Toggle object status in database
	 *
	 * return boolean Update result
	 */
	public function toggle($key = 'active')
	{
		if (!Validate::isTableOrIdentifier($this->identifier) OR !Validate::isTableOrIdentifier($this->table))
			die('Fatal error:Object not exist!');

		/* Object must have a variable called 'active' */
		elseif (!isset($this->active))
			die('Fatal error:No field \'active\'');

		/* Update active status on object */
		$this->active = $this->active > 0 ? 0 : 1;

		/* Change status to active/inactive */
		return Db::getInstance()->exec('
		UPDATE `'.pSQL(DB_PREFIX.$this->table).'`
		SET `active` = '.$this->active.'
		WHERE `'.pSQL($this->identifier).'` = '.(int)($this->id));
	}
	
}

?>