<?php 
class Module extends ObjectBase{
	protected $fields 			= array('alias','name','type','description','active');
	protected $fieldsRequired	= array('alias','name','type');
	protected $fieldsSize 		= array('alias'=>32,'name' => 32, 'description' => 256);
	protected $fieldsValidate	= array(
		'active'=> 'isBool',
		'alias' => 'isModuleName',
		'name' => 'isModuleName', 
		'type' => 'isModuleName', 
		'description' => 'isMessage');
	
	protected $identifier 		= 'id_module';
	protected $table			= 'module';
	
	public function getFields()
	{
		parent::validation();
		if (isset($this->id))
			$fields['id_module'] = (int)($this->id);
		$fields['alias'] = pSQL($this->alias);
		$fields['name'] = pSQL($this->name);
		$fields['type'] = pSQL($this->type);
		$fields['description'] = pSQL($this->description);
		$fields['active'] = (int)($this->active);
		return $fields;
	}
	
	public static function existsModule($alias)
	{
		return Db::getInstance()->getRow('SELECT * FROM `'.DB_PREFIX.'module` WHERE `alias`="'.pSQL($alias).'"');
	}
	
	public static function loadModule($id)
	{
		$row = Db::getInstance()->getRow('SELECT * FROM `'.DB_PREFIX.'module` WHERE `id_module`='.(int)($id));
		include(_TM_MODULES_DIR.$row['type'].'/'.$row['alias'].'/'.$row['alias'].'.php');
		$alias = $row['alias'];
		return new $alias;
	}
	
	public static function getModulesByType($type)
	{
		$_modules = array();
		$result = opendir(_TM_MODULES_DIR.$type);
		while($dir = readdir($result)){
			if (Validate::isModuleName($dir) && is_dir(_TM_MODULES_DIR.$type.'/'.$dir)) {
				include(_TM_MODULES_DIR.$type.'/'.$dir.'/config.php');
				if(!$mod = Module::existsModule($dir)){
					$module = new Module();
					$module->alias = pSQL($dir);
					$module->name = pSQL($_modules[$type][$dir]['name']);
					$module->type = pSQL($type);
					$module->description = pSQL($_modules[$type][$dir]['description']);
					$module->active = 0;
					$module->add();
					$_modules[$type][$dir]['id'] = $module->id;
				} else {
					$_modules[$type][$dir]['id'] = $mod['id_module'];
					$_modules[$type][$dir]['type'] = $mod['type'];
				}
			}
		}
		return $_modules[$type];
	}
	
	public static function hook($id){
		$module = new Module((int)($id));
		//print_r($module);
		if(is_dir(_TM_MODULES_DIR.$module->type.'/'.$module->alias) && file_exists(_TM_MODULES_DIR.$module->type.'/'.$module->alias.'/'.$module->alias.'.php'))
		{
			include_once(_TM_MODULES_DIR.$module->type.'/'.$module->alias.'/'.$module->alias.'.php');
			$alias = $module->alias;
			$mod   = new $alias;
			$mod->id = (int)($id);
			$mod->load();
			return $mod;
		}
	}


	public static function hookBlock($blocks=array(), $view = false)
	{
		if(!is_array($blocks))
			$blocks = array($blocks);
		
		$html = '';
		foreach($blocks as $block){
			if(!file_exists(_TM_MODULES_DIR.'block/'.$block.'/'.$block.'.php'))
				continue;
			include(_TM_MODULES_DIR.'block/'.$block.'/'.$block.'.php');
			$mod = new $block;
			if(method_exists($mod,'hookDisplay'))
				$html .= $mod->hookDisplay($view);
		}
		return $html;
	}
	
	public function display($file, $template)
	{
		global $smarty;
		
		$smarty->assign('module_dir', _TM_ROOT_URL_.'modules/'.$this->type.'/'.basename($file, '.php').'/');
		$smarty->assign('id_module', $this->id);

		if (!file_exists(_TM_MODULES_DIR.$this->type.'/'.basename($file, '.php').'/'.$template))
			$result = Tools::displayError('No template found for module').' '.basename($file,'.php');
		else
		{
			$result = $smarty->fetch(_TM_MODULES_DIR.$this->type.'/'.basename($file, '.php').'/'.$template);
		}
		return $result;
	}
}
?>