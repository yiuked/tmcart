<?php
/*
网站API配置有问题的时候会返回以下代码，此时应联系管理员
及时更正.
*/
class System_Response{
	//返回状态码所对应的信息
	private $_codeMsg = array(
		"-1" => "订单号错误",
		"0" => "付款失败",
		"1" => "高风险失败",
		"2" => "黑卡库黑卡",
		"3" => "单笔限额超限",
		"4" => "月交易量超限",
		"5" => "同一IP重复交易",
		"6" => "同一email重复交易",
		"7" => "同一卡号重复交易",
		"8" => "同一COOKIE重复交易",
		"9" => "中风险失败",
		"10" => "商户号不存在",
		"11" => "商户MD5KEY不存在",
		"12" => "货币未设置",
		"13" => "MD5验证错误",
		"14" => "返回网址未注册",
		"44" => "网站黑库",
		"15" => "商户未开通",
		"16" => "通道未开通",
		"17" => "黑卡",
		"19" => "异常单失败",
		"22" => "网站未注册",
		"24" => "流水号重复",
		"25" => "金额错误",
		"26" => "卡号或CVV2或有效期错误",
		"27" => "流水号不存在",
		"28" => "已存在流水号",
		"30" => "同一电话号码重复交易",
		"31" => "禁止交易地区",
		"32" => "同一流水号重复付款",
		"105" => "高风险，系统拒绝",
		"88" => "付款成功",
		"1000" => "Unknown Error",
		"1001" => "Unknown Error",
		"1002" => "Bank Declined Transaction",//银行拒绝交易
		"1003" => "No Reply from Bank",//银行未回复
		"1004" => "Expired Card",//过期卡
		"1005" => "Insufficient Funds",//存款不足
		"1006" => "Error Communicating with Bank",//与银行通信错误
		"1007" => "Payment Server System Error",//支付服务器错误
		"1008" => "Transaction Type Not Supported",//交易类型不支持
		"1009" => "Bank declined transaction (Do not contact Bank)",//银行拒绝交易
		"100A" => "Transaction Aborted",//交易中止
		"100C" => "Transaction Cancelled",//交易取消
		"100D" => "Deferred transaction has been received and is awaiting processing",//交易已收到，等待处理
		"100F" => "3D Secure Authentication failed",//3D安全验证失败
		"100I" => "Card Security Code verification failed",//信用卡安全码验证失败
		"100L" => "Shopping Transaction Locked (Please try the transaction again later)",//购物交易被锁定，请稍候重试
		"100N" => "Cardholder is not enrolled in Authentication Scheme",//持卡人不参与验证
		"100P" => "Transaction has been received by the Payment Adaptor and is being processed",//交易已处理
		"100R" => "Transaction was not processed - Reached limit of retry attempts allowed",//交易未处理，已达到重试极限
		"100S" => "Duplicate SessionID (OrderInfo)",//重启的SESSIONID
		"100T" => "Address Verification Failed",//地址验证失败
		"100U" => "Card Security Code Failed",//信用卡安全码错误
		"100V" => "Address Verification and Card Security Code Failed",//
		"?" => "Transaction status is unknown",//交易状态未知
		"default" => "Unable to be determined"//无法确定
	);

    //此数组内代码表示系统设置错误，与用户操作无关，因此仅提示联系网站管理员则可.
    private $_systemCode = array(
        '-1',//订单号错误
        '10',//商户号不存在
        '11',//商户MD5KEY不存在
        '12',//货币未设置
        '13',//MD5验证失败
        '14',//返回网址未注册
        '15',//商户未开通
        '16',//通道未开通
        '22',//网站未注册
		'24',//流水号重复
        '25',//金额错误
        '26',//卡号或者CVV2或者有效期错误
        '27',//流水号不存在
        '28',//已存在流水号
		'32',//流水号重复
        '33',//未知错误
        '44'//网站黑库
        );
		
	//此数组保存的代码可向用户展示，提示用户如何操作已提高成功率.
	private $_userCode = array(
		'0',//付款失败
		'1',//高风险失败
		'2',//黑卡库黑卡
		'3',//单笔交易超限
		'4',//月交易量超限
		'5',//同一IP重复交易
		'6',//
		'7',//
		'8',//
		'9',//
		'17',//
		'30',//
		'31',//
		'105',//
	);
	
	//以下状态码为支付成功
	private $_succeedCode = array(
		"16",
		"88",
	);
	
	
	//此数组保存的代码可向用户展示，提示用户如何操作已提高成功率.
	public $userCodeMsg = array(
		'0'=>"Payment failure,Please try again!",//付款失败
		'1'=>"Your card can't trade through the bank.please change to visa card.",//高风险失败
		'2'=>"Your card can't trade through the bank.please change to visa card.",//黑卡库黑卡
		'3'=>"The amout of the order is huge, please split it into two orders, then pay them.",//单笔交易超限
		'4'=>"Volume overrun this month",//月交易量超限
		'5'=>"Your IP Repeat trade",//同一IP重复交易
		'6'=>"Please try again after changing your billing e-mail address.",//
		'7'=>"Repeat trade",//
		'8'=>"Please try again after deleting the website cookie.",//
		'9'=>"Your card can't trade through the bank.please change to visa card.",//
		'17'=>"Your card can't trade through the bank.please change to visa card.",//
		'30'=>"Please try again after changing your billing phone number.",//
		'31'=>"Your area is not allowed to perform this transaction.",//
		'105'=>"",//
	);
	
	

	public function isSucceed($code)
	{
        if(in_array($code, $this->_succeedCode)){
            return true;
        }
        return false;
	}
	
    public function isSystem($code){
        if(in_array($code, $this->_systemCode)){
            return true;
        }
        return false;
    }
	
	public function isUser($code){
        if(in_array($code, $this->_userCode)){
            return true;
        }
        return false;
	}
	
	public function getMsg($code)
	{
		if(isset($this->_codeMsg[$code]))
			return $this->_codeMsg[$code];
		return "Not fount the code!";
	}
}