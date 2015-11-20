Note:
This module allows you to accept secure payments by WeChat payment.
WeChat payment currently only supports the Chinese currency, currency ISO code:CNY
Please make sure that your website has been added to the CNY currency.

Install
1.Download weixinpay.zip
2.Extract weixinpay.zip
3.Copy weixinpay folder to /moudles
4.chomd 777 modules/logs and  chomd 777 modules/views/cache 
5.Now,You can Background>>modules>>WeChat Pay

2015/11/12 v1.0.2 update
1.Update transaction settlement process,more：
Users scan the two-dimensional code before generating the "Awaiting WeChat Payment" status of the order in the background,
After the user scans the two-dimensional code and pay the success, the change of the status of the order has been paid for success
2.add "Awaiting WeChat Payment" status
3.Merchant orders number will display the order reference
4.Delete payment page button "other payment" button