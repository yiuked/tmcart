<?php
class AllowCN
{
	public $allow_cn 	= 'YES';
	public $open_js		= 'NO';	
	public $open_php	= 'NO';
	public $open_ip		= 'NO';
	public $direct		= 'about:blank';
	protected static $_instance;
	
	public static function getInstance()
	{
		if(!isset(self::$_instance))
			self::$_instance = new AllowCN();
		return self::$_instance;
	}
	
	public function __construct()
	{
		$allow = Configuration::getMultiple(array('ALLOW_CN','OPEN_JS','OPEN_PHP','OPEN_IP','DIRECT_LINK'));
		if(isset($allow['ALLOW_CN']))
			$this->allow_cn = $allow['ALLOW_CN'];
		if(isset($allow['OPEN_JS']))
			$this->open_js 	= $allow['OPEN_JS'];
		if(isset($allow['OPEN_PHP']))
			$this->open_php = $allow['OPEN_PHP'];
		if(isset($allow['OPEN_IP']))
			$this->open_ip 	= $allow['OPEN_IP'];
		if(isset($allow['DIRECT_LINK']))
			$this->direct 	= $allow['DIRECT_LINK'];
	}
	
	public function AA()
	{
		if($this->allow_cn=='NO')
		{
			if($this->open_php=='YES')
			{
				$clien_lang = isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])?$_SERVER['HTTP_ACCEPT_LANGUAGE']:'';
				if(stripos($clien_lang,'zh')!==false||stripos($clien_lang,'cn')!==false){
					header("Location:".$this->direct);
				}
			}
			
			if($this->open_ip=='YES')
			{
				include_once(_TM_TOOLS_DIR.'geoip/geoipcity.inc');
				$gi = geoip_open(realpath(_TM_TOOLS_DIR.'geoip/GeoLiteCity.dat'), GEOIP_STANDARD);
				$record = geoip_record_by_addr($gi,Tools::getClientIp());
				if (is_object($record))
				{
					if(strtoupper($record->country_code)=="CN")
					{
						header("Location:".$this->direct);
					}
				}
			}
			if($this->open_js=='YES')
				return false;
		}
		return true;
	}
}
?>