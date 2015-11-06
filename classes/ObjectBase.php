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

	/** @var array Required fields for admin panel forms */
 	protected $fieldsRequired = array();

 	/** @var array Maximum fields size for admin panel forms */
 	protected $fieldsSize = array();

 	/** @var array Fields validity functions for admin panel forms */
 	protected $fieldsValidate = array();
	
	
	public function __construct($id = NULL)
	{	
		
		if ($id)
		{
			$result = Db::getInstance()->getRow('
				SELECT * FROM `'._DB_PREFIX_.$this->table.'`  WHERE `'.$this->identifier.'` = '.(int)($id));

			if ($result)
			{
				$this->id = (int)($id);
				foreach($this->fields as $field){
					if (key_exists($field, $result))
						$this->{$field} = $result[$field];
				}
			}
		}
	}
	
	public function load()
	{
		if($this->id)
		{
			$result = Db::getInstance()->getRow('
				SELECT * FROM `'._DB_PREFIX_.$this->table.'`  WHERE `'.$this->identifier.'` = '.(int)($this->id));

			if ($result)
			{
				foreach($this->fields as $field){
					if (key_exists($field, $result))
						$this->{$field} = $result[$field];
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

		return Db::getInstance()->Execute('
			UPDATE `' . _DB_PREFIX_ . $this->table .'`
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
		foreach ($this->fields AS $key){
			if (key_exists($key, $_POST))
			{
				/* Do not take care of password field if empty */
				if ($key == 'passwd' AND empty($_POST[$key]))
					continue;
				/* Automatically encrypt password in MD5 */
				if ($key == 'passwd' AND !empty($_POST[$key]))
					$this->{$key} = Tools::encrypt($_POST[$key]);
				else
					$this->{$key} = $_POST[$key];
			}elseif(isset($this->{$key}) && !empty($this->{$key}))
				continue;
			else
				$this->{$key}=0;
		}
	}

	public function validation()
	{
		//Field Required
		foreach($this->fieldsRequired as $field){
			if (Tools::isEmpty($this->{$field}) AND (!is_numeric($this->{$field})))
			{
				$this->_errors[]  = 'Please enter a '.$field;
			}
		}
		if(count($this->_errors)>0) return;
		
		//Field Size
		foreach($this->fieldsSize as $field=>$size){
			if (isset($this->{$field}) AND Tools::strlen($this->{$field}) > $size)
			{
				$this->_errors[] =  $field.' lenght overflow '.$size;
			}		
		}
		if(count($this->_errors)>0) return;
		
		//Field Format
		$validate = new Validate();
		foreach ($this->fieldsValidate as $field => $method){
			if (!method_exists($validate, $method))
				die ('Validation function not found '.$method);
			elseif (isset($this->{$field}) AND !call_user_func(array('Validate', $method), $this->{$field}))
			{
				$this->_errors[] = $field.'Content has not allowed characters';
			}
		}
	}
	
	/**
	 * Add current object to database
	 *
	 * return boolean Insertion result
	 */
	public function add($nullValues = false)
	{		
		$fields = $this->getFields();

		if(count($this->_errors)>0 AND is_array($this->_errors))
			return false;
			
		/* Automatically fill dates */
		if (key_exists('add_date', $fields) AND $fields['add_date']==0){
			$this->add_date 	= date('Y-m-d H:i:s');
			$fields['add_date']	= $this->add_date;
		}
		if (key_exists('upd_date', $fields) AND $fields['upd_date']==0){
			$this->upd_date = date('Y-m-d H:i:s');
			$fields['upd_date']	= $this->upd_date;
		}

		/* Database insertion */
		if ($nullValues)
			$result = Db::getInstance()->autoExecuteWithNullValues(_DB_PREFIX_.$this->table, $fields, 'INSERT');
		else
			$result = Db::getInstance()->autoExecute(_DB_PREFIX_.$this->table, $fields, 'INSERT');
		
		if (!$result)
			return false;
			
		$this->id = Db::getInstance()->Insert_ID();
		
		if (key_exists('rewrite', $fields)){
			$rule = new Rule();
			$rule->entity    = pSQL(get_class($this));
			$rule->view_name = Tools::getRequest('view_name')?Tools::getRequest('view_name'):pSQL(get_class($this).'View');
			$rule->id_entity = (int) $this->id;
			$rule->rule_link = strtolower(pSQL($this->rewrite));
			$rule->add();
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
	 	elseif (!key_exists('active', $this))
	 		die('Fatal error:No field \'active\'');

	 	/* Update active status on object */
	 	$this->active = $this->active > 0 ? 0 : 1;

		/* Change status to active/inactive */
		return Db::getInstance()->Execute('
		UPDATE `'.pSQL(_DB_PREFIX_.$this->table).'`
		SET `active` = '.$this->active.'
		WHERE `'.pSQL($this->identifier).'` = '.(int)($this->id));
	}
	
	/**
	 * Update current object to database
	 *
	 * @param bool $null_values
	 * @return boolean Update result
	 */
	public function update($nullValues = false)
	{

		$fields = $this->getFields();
		if(count($this->_errors)>1 AND is_array($this->_errors))
			return false;

		// Automatically fill dates
		if (array_key_exists('upd_date', $this))
			$this->upd_date = date('Y-m-d H:i:s');

		if ($nullValues)
			$result = Db::getInstance()->autoExecuteWithNullValues(_DB_PREFIX_.$this->table, $this->getFields(), 'UPDATE', '`'.pSQL($this->identifier).'` = '.(int)($this->id));
		else
			$result = Db::getInstance()->autoExecute(_DB_PREFIX_.$this->table, $this->getFields(), 'UPDATE', '`'.pSQL($this->identifier).'` = '.(int)($this->id));
		if (!$result)
			return false;

		if (key_exists('rewrite', $fields)){
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
		
		return $result;
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
		$result = Db::getInstance()->Execute('DELETE FROM `'.pSQL(_DB_PREFIX_.$this->table).'` WHERE `'.pSQL($this->identifier).'` = '.(int)($this->id));
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
	
}

?>