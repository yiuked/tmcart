<?php
/**
 * NEWORDER 支付模块类
 * Class NEWORDER
 */
class neworder extends PaymentModule {
	private $_postErrors = array();
    public $IVersion = "V7.0-A-100(1.4)";
    
    /**
     * 后台配置模块
     * @return string
     */
    public function getContent() {
		 if (Tools::isSubmit('Submit_Cardpay_CheckOut')){
			if (empty($_POST['NEWORDER_MERCHANT_NO']))
				$this->_postErrors[] = 'Merchant No is required.';
			if (!isset($_POST['NEWORDER_MERCHANT_KEY']))
				$this->_postErrors[] = 'Sign Key is required.';
			if (!sizeof($this->_postErrors))
			{
				Configuration::updateValue('NEWORDER_MERCHANT_NO', strval($_POST['NEWORDER_MERCHANT_NO']));
				Configuration::updateValue('NEWORDER_MERCHANT_KEY', strval($_POST['NEWORDER_MERCHANT_KEY']));
				Configuration::updateValue('NEWORDER_MERCHANT_LANG', strval($_POST['NEWORDER_MERCHANT_LANG']));
				$this->displayConf();
			}
			else
				$this->displayErrors();
		 }
		 $conf = Configuration :: getMultiple(array (
			'NEWORDER_MERCHANT_NO',
			'NEWORDER_MERCHANT_KEY',
			'NEWORDER_MERCHANT_LANG',
		));
		
		$lang = array_key_exists('NEWORDER_MERCHANT_LANG', $_POST) ? $_POST['NEWORDER_MERCHANT_LANG'] : (array_key_exists('NEWORDER_MERCHANT_LANG', $conf) ? $conf['NEWORDER_MERCHANT_LANG'] : '');
        $html = '<h2>Create a new order</h2>
        <form action="'.$_SERVER['REQUEST_URI'].'" method="post">
            <fieldset>
            <legend><img src="../modules/payment/neworder/logo.png" />Settings</legend>
                <p>First use the sandbox to test out the module then you can use the real mode if everything\'s fine. Don\'t forget to change your merchant key and id according to the mode!</p>
                <label>Merchant No.</label>
                <div class="margin-form">
                    <input type="text" name="NEWORDER_MERCHANT_NO" value="'.Tools::getRequest('NEWORDER_MERCHANT_NO', Configuration::get('NEWORDER_MERCHANT_NO')).'" size="30" />
                </div>
				<label>Sign Key</label>
                <div class="margin-form">
                    <input type="text" name="NEWORDER_MERCHANT_KEY" value="'.Tools::getRequest('NEWORDER_MERCHANT_KEY', Configuration::get('NEWORDER_MERCHANT_KEY')).'" size="30"/>
                </div>
				<label>Language</label>
                <div class="margin-form">
                    <input type="radio" name="NEWORDER_MERCHANT_LANG" value="en" '.($lang == "en" ? 'checked="checked"' : '').'/>英国
					<input type="radio" name="NEWORDER_MERCHANT_LANG" value="fr" '.($lang == "fr" ? 'checked="checked"' : '').'/>法国
					<input type="radio" name="NEWORDER_MERCHANT_LANG" value="de" '.($lang == "de" ? 'checked="checked"' : '').'/>德国
					<input type="radio" name="NEWORDER_MERCHANT_LANG" value="it" '.($lang == "it" ? 'checked="checked"' : '').'/>意大利
					<input type="radio" name="NEWORDER_MERCHANT_LANG" value="da" '.($lang == "da" ? 'checked="checked"' : '').'/>丹麦
					<input type="radio" name="NEWORDER_MERCHANT_LANG" value="es" '.($lang == "es" ? 'checked="checked"' : '').'/>西班牙
					<input type="radio" name="NEWORDER_MERCHANT_LANG" value="in" '.($lang == "in" ? 'checked="checked"' : '').'/>印度尼西亚
					<input type="radio" name="NEWORDER_MERCHANT_LANG" value="iw" '.($lang == "iw" ? 'checked="checked"' : '').'/>希伯来
					<input type="radio" name="NEWORDER_MERCHANT_LANG" value="ja" '.($lang == "ja" ? 'checked="checked"' : '').'/>日本
					<input type="radio" name="NEWORDER_MERCHANT_LANG" value="ms" '.($lang == "ms" ? 'checked="checked"' : '').'/>马来西亚
					<input type="radio" name="NEWORDER_MERCHANT_LANG" value="nl" '.($lang == "nl" ? 'checked="checked"' : '').'/>荷兰
					<input type="radio" name="NEWORDER_MERCHANT_LANG" value="nn" '.($lang == "nn" ? 'checked="checked"' : '').'/>挪威
					<input type="radio" name="NEWORDER_MERCHANT_LANG" value="pl" '.($lang == "pl" ? 'checked="checked"' : '').'/>波兰
					<input type="radio" name="NEWORDER_MERCHANT_LANG" value="ru" '.($lang == "ru" ? 'checked="checked"' : '').'/>俄罗斯
					<input type="radio" name="NEWORDER_MERCHANT_LANG" value="sv" '.($lang == "sv" ? 'checked="checked"' : '').'/>瑞典
					<input type="radio" name="NEWORDER_MERCHANT_LANG" value="tr" '.($lang == "tr" ? 'checked="checked"' : '').'/>土耳其
                </div>
				 <div class="margin-form"><input type="submit" name="Submit_Cardpay_CheckOut" class="button" value="Save And Update" /></div>
            </fieldset>
        </form>';

        return $html;
    }
	public function displayConf()
	{
		$this->_html .= '
		<div class="conf confirm">Settings updated</div>';
	}
	public function displayErrors()
	{
		$nbErrors = sizeof($this->_postErrors);
		$this->_html .= '
		<div class="alert error">
			<h3>'.($nbErrors > 1 ? 'There are' : 'There is').' '.$nbErrors.' '.($nbErrors > 1 ? 'errors' : 'error').'</h3>
			<ol>';
		foreach ($this->_postErrors AS $error)
			$this->_html .= '<li>'.$error.'</li>';
		$this->_html .= '
			</ol>
		</div>';
	}
	

    public function hookPayment(){
		global $smarty,$cookie;
		
        $this -> getNewOrderConfig();
		$orderNo = $this->generateOrderNo($cookie->id_cart);
		$this->postMonitor($orderNo);
        $messages = $_SESSION['newOrderConfig']['messages'];

        $UserAgent = $_SERVER['HTTP_USER_AGENT'];
		$cardInputType = 'text';
		if(strpos($UserAgent,'webkit') || strpos($UserAgent,'firefox') || strpos($UserAgent,'trident') || strpos($UserAgent,'safari')){
			$cardInputType='tel';
		}

        $smarty->assign(array(
			'paymentid'=>$this->id,
            'messages'=> $messages,
			'cardInputType'=>$cardInputType
        ));
        return $this->display(__FILE__, 'payment.tpl');
    }

    private function getNewOrderConfig(){
        $newOrderConfig = null;
        $lang = Configuration::get('NEWORDER_MERCHANT_LANG');
        session_start();
        if (!isset($_SESSION['newOrderConfig'])) {
            $result = $this->http_response('https://merchant.paytos.com/CubePaymentGateway/gateway/action.PayConfigService.do?Language=' . $lang);
            $newOrderConfig = json_decode($result,TRUE);
            $_SESSION['newOrderConfig'] = $newOrderConfig;
            $_SESSION['lang'] = $lang;
        } else {
            $newOrderConfig = $_SESSION['newOrderConfig'];
        }

        return $newOrderConfig;
    }

	private function http_response($url,$data=null,$status = null, $wait = 3){ 
		$time = microtime(true);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url); 
		curl_setopt($ch, CURLOPT_HEADER, FALSE);  
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
		$returnInfo = curl_exec($ch);         
		return $returnInfo;
	}
	
    public function getGatewayUrl() {
		$_url = $_SESSION['newOrderConfig']['gatewayUrl'];
        return $_url;
    }
	public function getMonitorUrl() {
        $_url = $_SESSION['newOrderConfig']['monitorUrl'];
        return $_url;
    }

    public function getMessages() {
        return  $_SESSION['newOrderConfig']['messages'];
    }
	
	public function generateOrderNo($orderNo){
		return date('Ymd').$orderNo;
	}
	
	function postMonitor($orderNo) {
		$merNo = Configuration::get('NEWORDER_MERCHANT_NO');
		$CMSVersion = _TM_VERSION_;
		$PHPVersion = phpversion();
		$data = array(
			'IVersion' => $this->IVersion,
			'CartID' => $orderNo,
			'AcctNo' =>$merNo,
			'CMSVersion'=>$CMSVersion,
			'PHPVersion'=>$PHPVersion,
			'Framework'=>'tmshop'
		);

		$url = $this->getMonitorUrl();
		$this->curl_post($url,http_build_query($data, '', '&'));
	}
	function curl_post($payUrl, $data) {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $payUrl);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		@curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		if(isset($_SERVER['HTTP_REFERER']))
			curl_setopt($curl, CURLOPT_REFERER, $_SERVER['HTTP_REFERER']);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_TIMEOUT, 300);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$tmpInfo = curl_exec($curl);
		if (curl_errno($curl)) {
			return false;
		}
		curl_close($curl);
		return $tmpInfo;
	}	

	public function resultPayment()
	{
		global $cookie,$smarty;
		
		return $this->display(__FILE__, 'confirmation.tpl');
	}

}
?>