<?php
class Currency extends ObjectBase
{
	protected 	$fields 			= array('name','iso_code','iso_code_num','sign','conversion_rate','format','active');
 	protected 	$fieldsRequired = array('name', 'iso_code','iso_code_num', 'sign', 'conversion_rate', 'format');
 	protected 	$fieldsSize = array('name' => 32, 'iso_code' => 3, 'iso_code_num' => 3, 'sign' => 8);
 	protected 	$fieldsValidate = array('name' => 'isGenericName', 'iso_code' => 'isLanguageIsoCode', 'iso_code_num' => 'isNumericIsoCode','sign' => 'isGenericName',
		'format' => 'isUnsignedId','conversion_rate' => 'isFloat','active' => 'isBool');

	/** @var Currency Current currency */
	static protected	$current = NULL;
	static protected	$currencies = array();
	
	protected 	$table = 'currency';
	protected 	$identifier = 'id_currency';

	/**
	 * Overriding check if currency with the same iso code already exists.
	 * If it's true, currency is doesn't added.
	 *
	 * @see ObjectModelCore::add()
	 */
	public function add($autodate = true, $nullValues = false)
	{
		return Currency::exists($this->iso_code) ? false : parent::add();
	}

	/**
	 * Check if a curency already exists.
	 *
	 * @param int|string $iso_code int for iso code number string for iso code
	 * @return boolean
	 */
	public static function exists ($iso_code)
	{
		if (is_int($iso_code))
			$id_currency_exists = Currency::getIdByIsoCodeNum($iso_code);
		else
			$id_currency_exists = Currency::getIdByIsoCode($iso_code);

		if ($id_currency_exists){
			return true;
		} else {
			return false;
		}
	}
	public function getFields()
	{
		parent::validation();
		if (isset($this->id))
			$fields['id_currency'] = (int)($this->id);
		$fields['name'] = pSQL($this->name);
		$fields['iso_code'] = pSQL($this->iso_code);
		$fields['iso_code_num'] = pSQL($this->iso_code_num);
		$fields['sign'] = pSQL($this->sign);
		$fields['format'] = (int)($this->format);
		$fields['conversion_rate'] = (float)($this->conversion_rate);
		$fields['active'] = (int)($this->active);

		return $fields;
	}

	public function deleteSelection($selection)
	{
		if (!is_array($selection) OR !Validate::isTableOrIdentifier($this->identifier) OR !Validate::isTableOrIdentifier($this->table))
			die(Tools::displayError());
		foreach ($selection AS $id)
		{
			$obj = new Currency((int)($id));
			$res[$id] = $obj->delete();
		}
		foreach ($res AS $value)
			if (!$value)
				return false;
		return true;
	}

	public function delete()
	{
		if ($this->id == Configuration::get('PS_CURRENCY_DEFAULT'))
		{
			$result = Db::getInstance()->getRow('SELECT `id_currency` FROM '._DB_PREFIX_.'currency WHERE `id_currency` != '.(int)($this->id).' AND `deleted` = 0');
			if (!$result['id_currency'])
				return false;
			Configuration::updateValue('PS_CURRENCY_DEFAULT', $result['id_currency']);
		}
		$this->deleted = 1;
		return $this->update();
	}

	public static function getEntity($active = true,$p=1,$limit=50,$orderBy = NULL,$orderWay = NULL,$filter=array())
	{
	 	if (!Validate::isBool($active))
	 		die(Tools::displayError());

		$where = '';
		if(!empty($filter['id_currency']) && Validate::isInt($filter['id_currency']))
			$where .= ' AND a.`id_currency`='.intval($filter['id_currency']);
		if(!empty($filter['name']) && Validate::isCatalogName($filter['name']))
			$where .= ' AND a.`name` LIKE "%'.pSQL($filter['name']).'%"';
		if(!empty($filter['active']) && Validate::isInt($filter['active']))
			$where .= ' AND a.`active`='.((int)($filter['active'])==1?'1':'0');

		
		if(!is_null($orderBy) AND !is_null($orderWay))
		{
			$postion = 'ORDER BY '.pSQL($orderBy).' '.pSQL($orderWay);
		}else{
			$postion = 'ORDER BY `id_currency` DESC';
		}

		$total  = Db::getInstance()->getRow('SELECT count(*) AS total FROM `'._DB_PREFIX_.'currency` a
				WHERE 1 '.($active?' AND a.`active`=1 ':'').'
				'.$where);
		if($total==0)
			return false;

		$result = Db::getInstance()->ExecuteS('SELECT a.* FROM `'._DB_PREFIX_.'currency` a
				WHERE 1 '.($active?' AND a.`active`=1 ':'').'
				'.$where.'
				'.$postion.'
				LIMIT '.(($p-1)*$limit).','.(int)$limit);
		$rows   = array(
				'total' => $total['total'],
				'entitys'  => $result);
		return $rows;
	}

	/**
	  * Return formated sign
	  *
	  * @param string $side left or right
	  * @return string formated sign
	  */
	public function getSign($side=NULL)
	{
		if (!$side)
			return $this->sign;
		$formated_strings = array(
			'left' => $this->sign.' ',
			'right' => ' '.$this->sign
		);
		$formats = array(
			1 => array('left' => &$formated_strings['left'], 'right' => ''),
			2 => array('left' => '', 'right' => &$formated_strings['right']),
			3 => array('left' => &$formated_strings['left'], 'right' => ''),
			4 => array('left' => '', 'right' => &$formated_strings['right']),
		);
		return ($formats[$this->format][$side]);
	}

	/**
	  * Return available currencies
	  *
	  * @return array Currencies
	  */
	public static function getCurrencies($object = false, $active = 1)
	{
		$tab = Db::getInstance()->ExecuteS('
		SELECT *
		FROM `'._DB_PREFIX_.'currency`
		WHERE `deleted` = 0
		'.($active == 1 ? 'AND `active` = 1' : '').'
		ORDER BY `name` ASC');
		if ($object)
			foreach ($tab as $key => $currency)
				$tab[$key] = Currency::getCurrencyInstance($currency['id_currency']);
		return $tab;
	}

	public static function getCurrency($id_currency)
	{
		return Db::getInstance()->getRow('
		SELECT *
		FROM `'._DB_PREFIX_.'currency`
		WHERE `id_currency` = '.(int)($id_currency));
	}

	public static function getIdByIsoCode($iso_code)
	{
		$result = Db::getInstance()->getRow('
		SELECT `id_currency`
		FROM `'._DB_PREFIX_.'currency`
		WHERE `iso_code` = \''.pSQL($iso_code).'\'');
		return $result['id_currency'];
	}
	public static function getIdByIsoCodeNum($iso_code)
	{
		$result = Db::getInstance()->getRow('
		SELECT `id_currency`
		FROM `'._DB_PREFIX_.'currency`
		WHERE `iso_code_num` = \''.pSQL($iso_code).'\'');
		return (int)$result['id_currency'];
	}

	/**
	* Refresh the currency conversion rate
	* The XML file define conversion rate for each from a default currency ($isoCodeSource).
	*
	* @param $data XML content which contains all the conversion rates
	* @param $isoCodeSource The default currency used in the XML file
	* @param $defaultCurrency The default currency object
	*/
	public function refreshCurrency($data, $isoCodeSource, $defaultCurrency)
	{
		// fetch the conversion rate of the default currency
		$conversion_rate = 1;
		if ($defaultCurrency->iso_code != $isoCodeSource)
		{
			foreach ($data->currency AS $currency)
				if ($currency['iso_code'] == $defaultCurrency->iso_code)
				{
					$conversion_rate = round((float)$currency['rate'], 6);
					break;
				}
		}

		if ($defaultCurrency->iso_code == $this->iso_code)
			$this->conversion_rate = 1;
		else
		{
			if ($this->iso_code == $isoCodeSource)
				$rate = 1;
			else
			{
				foreach ($data->currency AS $obj)
					if ($this->iso_code == strval($obj['iso_code']))
					{
						$rate = (float) $obj['rate'];
						break;
					}
			}

			$this->conversion_rate = round($rate /  $conversion_rate, 6);
		}
		$this->update();
	}

	/**
 	* @deprecated
	**/
	public static function refreshCurrenciesGetDefault($data, $isoCodeSource, $idCurrency)
	{
		Tools::displayAsDeprecated();

		$defaultCurrency = new Currency($idCurrency);

		/* Change defaultCurrency rate if not as currency of feed source */
		if ($defaultCurrency->iso_code != $isoCodeSource)
			foreach ($data->currency AS $obj)
				if ($defaultCurrency->iso_code == strval($obj['iso_code']))
					$defaultCurrency->conversion_rate = round((float)($obj['rate']), 6);

		return $defaultCurrency;
	}

	public static function getDefaultCurrency()
	{
		$id_currency = (int)Configuration::get('ID_CURRENCY_DEFAULT');
		if ($id_currency == 0)
			return false;

		return new Currency($id_currency);
	}

	public static function refreshCurrencies()
	{
		// Parse
		if (!$feed = Tools::simplexml_load_file('http://www.prestashop.com/xml/currencies.xml'))
			return Tools::displayError('Cannot parse feed.');

		// Default feed currency (EUR)
		$isoCodeSource = strval($feed->source['iso_code']);

		if (!$default_currency = self::getDefaultCurrency())
			return Tools::displayError('No default currency');

		$currencies = self::getCurrencies(true);
		foreach ($currencies as $currency)
			$currency->refreshCurrency($feed->list, $isoCodeSource, $default_currency);

	}

	public static function getCurrent()
	{
		global $cookie;

		if (!self::$current)
		{
			if (isset($cookie->id_currency) AND $cookie->id_currency)
				self::$current = new Currency((int)($cookie->id_currency));
			else
				self::$current = new Currency((int)(Configuration::get('ID_CURRENCY_DEFAULT')));
		}
		return self::$current;
	}

	public static function getCurrencyInstance($id)
	{
		if (!array_key_exists($id, self::$currencies))
			self::$currencies[(int)($id)] = new Currency((int)($id));
		return self::$currencies[(int)($id)];
	}
}

