<?php
class sht extends PaymentModule
{
	private $_html;
	private $_postErrors;
	
	public function getContent() {
		$this->_html = '<div class="path_bar">
			<div class="path_title">
				<h3> 
					<span id="current_obj" style="font-weight: normal;">
					<span class="breadcrumb item-1 ">速汇通</span> 
				</span></h3>
				 <div class="cc_button">
				  <ul>
					<li> <a title="Back to list" href="javascript:history.back();" class="toolbar_btn" id="desc-product-back"> <span class="process-icon-back "></span>
					  <div>返回列表</div>
					  </a> </li>
				  </ul>
				</div>
			</div>
	   </div>';
		if (isset ($_POST['submitsht'])) {
			if (empty ($_POST['seller']))
				$this->_postErrors[] = '商户号不能为空';
			if (empty ($_POST['md5key'])) $this->_postErrors[] = 'MD5KEY 不能为空';
			if (empty ($_POST['handler'])) $this->_postErrors[] = '支付地址不能为空';
			if (empty ($_POST['returnurl'])) $this->_postErrors[] = '返回地址不能为空';

			if (!sizeof($this->_postErrors)) {

				//执行修改操作
				Configuration :: updateValue('MODULE_PAYMENT_SHT_SELLER', strval($_POST['seller']));
				Configuration :: updateValue('MODULE_PAYMENT_SHT_MD5KEY', strval($_POST['md5key']));
				Configuration :: updateValue('MODULE_PAYMENT_SHT_MONEYTYPE', strval($_POST['moneytype']));
				Configuration :: updateValue('MODULE_PAYMENT_SHT_LANGUAGE', strval($_POST['language']));
				Configuration :: updateValue('MODULE_PAYMENT_SHT_HANDLER', strval($_POST['handler']));
				Configuration :: updateValue('MODULE_PAYMENT_SHT_RETURN_URL', strval($_POST['returnurl']));
				
				$this->displayConf();
			} else
				$this->displayErrors();
		}
		
		$this->displayFormSettings();
		return $this->_html;
	}
	
	public function displayConf() {
		global $_tmconfig;
		$this->_html .= '<div class="conf confirm">更新成功</div>';
	}

	public function displayErrors() {
		$nbErrors = sizeof($this->_postErrors);
		$this->_html .= '<div class="alert error"><h3>';
		foreach ($this->_postErrors AS $error)
			$this->_html .= '<li>' . $error . '</li>';
		$this->_html .= '</ol></div>';
	}

	public function hookPayment() {
		global $cookie,$smarty;
		if (!$this->active)
			return;	
		include(dirname(__FILE__)."/country.php");
		if(!isset($cookie->id_cart))
			return;
		
		$cart = new Cart($cookie->id_cart);
		$address = new Address($cart->id_address);
		$smarty->assign(array(
			'paymentid'=>$this->id,
			'address'=>$address,
			'countrys'=>$countrys,
		));
		return $this->display(__FILE__, 'sht.tpl');
		
	}
	
	public function resultPayment()
	{
		global $cookie,$smarty;
		
		return $this->display(__FILE__, 'confirmation.tpl');
	}

	public function displayFormSettings() {
		global $_tmconfig;
		$conf = Configuration :: getMultiple(array (
			'MODULE_PAYMENT_SHT_SELLER',
			'MODULE_PAYMENT_SHT_MD5KEY',
			'MODULE_PAYMENT_SHT_MONEYTYPE',
			'MODULE_PAYMENT_SHT_LANGUAGE',
			'MODULE_PAYMENT_SHT_HANDLER',
			'MODULE_PAYMENT_SHT_RETURN_URL'
		));
		$seller = array_key_exists('seller', $_POST) ? $_POST['seller'] : (array_key_exists('MODULE_PAYMENT_SHT_SELLER', $conf) ? $conf['MODULE_PAYMENT_SHT_SELLER'] : '');
		$md5key = array_key_exists('md5key', $_POST) ? $_POST['md5key'] : (array_key_exists('MODULE_PAYMENT_SHT_MD5KEY', $conf) ? $conf['MODULE_PAYMENT_SHT_MD5KEY'] : '');
		$moneytype = array_key_exists('moneytype', $_POST) ? $_POST['moneytype'] : (array_key_exists('MODULE_PAYMENT_SHT_MONEYTYPE', $conf) ? $conf['MODULE_PAYMENT_SHT_MONEYTYPE'] : '');
		$language = array_key_exists('language', $_POST) ? $_POST['language'] : (array_key_exists('MODULE_PAYMENT_SHT_LANGUAGE', $conf) ? $conf['MODULE_PAYMENT_SHT_LANGUAGE'] : '');
		$handler = array_key_exists('handler', $_POST) ? $_POST['handler'] : (array_key_exists('MODULE_PAYMENT_SHT_HANDLER', $conf) ? $conf['MODULE_PAYMENT_SHT_HANDLER'] : '');
		$returnurl = array_key_exists('returnurl', $_POST) ? $_POST['returnurl'] : (array_key_exists('MODULE_PAYMENT_SHT_RETURN_URL', $conf) ? $conf['MODULE_PAYMENT_SHT_RETURN_URL'] : '');

		$this->_html .= '<form action="' . $_SERVER['REQUEST_URI'] . '" method="post" style="clear: both;"><fieldset><legend><img src="'.$_tmconfig['ico_dir'].'tools.png" />'
		. '设置'
		. '</legend><label>'
		. '商户号'
		. '</label><div class="margin-form"><input type="text" size="33" name="seller" value="'
		. htmlentities($seller, ENT_COMPAT, 'UTF-8')
		. '" /></div><label>'
		. 'MD5 KEY'
		. '</label><div class="margin-form"><input type="text" size="33" name="md5key" value="'
		. htmlentities($md5key, ENT_COMPAT, 'UTF-8')
		. '" /></div><label>'
		. '货币'
		. '</label><div class="margin-form"><input type="radio" name="moneytype" value="USD" '
		. ($moneytype == "USD" ? 'checked="checked"' : '')
		. ' /> '
		. 'USD'
		. '<input type="radio" name="moneytype" value="CNY" '
		. ($moneytype == "CNY" ? 'checked="checked"' : '')
		. ' /> '
		. 'CNY'
		. '<input type="radio" name="moneytype" value="EUR" '
		. ($moneytype == "EUR" ? 'checked="checked"' : '')
		. ' /> '
		. 'EUR'
		. '<input type="radio" name="moneytype" value="GBP" '
		. ($moneytype == "GBP" ? 'checked="checked"' : '')
		. ' /> '
		. 'GBP'
		
		. '<input type="radio" name="moneytype" value="HKD" '
		. ($moneytype == "HKD" ? 'checked="checked"' : '')
		. ' /> '
		. 'HKD'
		. '<input type="radio" name="moneytype" value="JPY" '
		. ($moneytype == "JPY" ? 'checked="checked"' : '')
		. ' /> '
		. 'JPY'
		. '<input type="radio" name="moneytype" value="AUD" '
		. ($moneytype == "AUD" ? 'checked="checked"' : '')
		. ' /> '
		. 'AUD'
		. '<input type="radio" name="moneytype" value="CAD" '
		. ($moneytype == "CAD" ? 'checked="checked"' : '')
		. ' /> '
		. 'CAD'
		. '<input type="radio" name="moneytype" value="NOK" '
		. ($moneytype == "NOK" ? 'checked="checked"' : '')
		. ' /> '
		. 'NOK'
		
		. '</div><label>'
		. '语言'
		. '</label><div class="margin-form"><input type="radio" name="language" value="en" '
		. ($language == "en" ? 'checked="checked"' : '')
		. ' /> '
		. '英语'
		. '<input type="radio" name="language" value="es" '
		. ($language == "es" ? 'checked="checked"' : '')
		. ' /> '
		. '西班牙'
		. '<input type="radio" name="language" value="fr" '
		. ($language == "fr" ? 'checked="checked"' : '')
		. ' /> '
		. '法国'
		. '<input type="radio" name="language" value="it" '
		. ($language == "it" ? 'checked="checked"' : '')
		. ' /> '
		. '意大利'
		. '<input type="radio" name="language" value="ja" '
		. ($language == "ja" ? 'checked="checked"' : '')
		. ' /> '
		. '日文'
		. '<input type="radio" name="language" value="de" '
		. ($language == "de" ? 'checked="checked"' : '')
		. ' /> '
		. '德文'
		. '<input type="radio" name="language" value="zh" '
		. ($language == "zh" ? 'checked="checked"' : '')
		. ' /> '
		. '中文'
		
		. '</div><label>'
		. '支付地址'
		. '</label><div class="margin-form"><input type="text" size="82" name="handler" value="'
		. htmlentities($handler, ENT_COMPAT, 'UTF-8')
		. '" /></div><label>'
		. '返回地址'
		. '</label><div class="margin-form"><input type="text" size="82" name="returnurl" value="'
		. htmlentities($returnurl, ENT_COMPAT, 'UTF-8')
		. '" /></div>'
		. '<br /><center><input type="submit" name="submitsht" value="'
		. '更新设置'
		. '" class="button" /></center></fieldset></form><br /><br />';
	}
}
?>