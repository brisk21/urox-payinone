<?php
// +----------------------------------------------------------------------
// | Urox PayinOne Plugins:Alipay
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2017 https://www.northme.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Victor.Chen <victor.chen@northme.com>
// +----------------------------------------------------------------------

//初始化方法，加载插件时会调用此方法，可进行引入SDK等操作
function WxPay_init()
{
    require __DIR__ . '/WxPaySdk/WxPayPubHelper/WxPayPubHelper.php';
}

//插件信息方法，具体配置方法详见文档
function WxPay_PackageInfo()
{
    return array(
        "name" => "com.wxpay",
        "friend_name" => array(
            "zh-cn" => "微信支付",
            "en-us" => "WeChat Pay",
        ),
        "icon_html" => "<i><svg class=\"icon\" viewBox=\"0 0 1024 1024\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" style=\"width: 20px;padding-top: 10px;\"><path fill=\"#c1c3c9\" d=\"M385.2052 620.794017c-4.212104 2.124114-8.948011 3.341506-13.951239 3.341506-11.624828 0-21.750495-6.401242-27.053555-15.869444l-2.022966-4.446912-84.686406-185.816633c-0.90311-2.030191-1.473875-4.298802-1.473875-6.534902 0-8.554255 6.925045-15.500975 15.493751-15.500975 3.493228 0 6.693849 1.145143 9.280356 3.08141L380.696876 470.195051c7.326026 4.768419 16.039229 7.571672 25.409895 7.571672 5.59928 0 10.94569-1.040382 15.912793-2.857439L891.965357 265.767132c-84.249301-99.277047-222.97418-164.163675-379.952714-164.163675-256.905819 0-465.148473 173.541566-465.148473 387.621922 0 116.800988 62.650528 221.944635 160.702958 292.994084 7.871504 5.624567 13.030067 14.836287 13.030067 25.250948 0 3.449879-0.736938 6.603538-1.64366 9.883633-7.831768 29.217406-20.359706 76.002103-20.944921 78.194853-0.989808 3.670238-2.50342 7.484973-2.50342 11.332221 0 8.565093 6.925045 15.5082 15.493751 15.5082 3.388468 0 6.126696-1.257129 8.966073-2.893564l101.827428-58.777994c7.661983-4.432463 15.768296-7.167079 24.69102-7.167079 4.779257 0 9.367054 0.733325 13.683919 2.05909 47.510797 13.665856 98.771305 21.251978 151.841645 21.251978 256.880532 0 465.123186-173.545178 465.123186-387.636371 0-64.836054-19.192888-125.907946-52.983642-179.617688l-535.55852 309.231997L385.2052 620.794017z\"></path></svg></i>",
        "SubPackages" => array(
            "com.wxpay.qrcode1" => array(
                "friend_name" => array("zh-cn" => "微信支付 - 扫码支付模式一", "en-us" => "WePay - Scanning Code Mode 1",),
                "input" => array(
                    "appid" => array(
                        "type" => "text",
                        "display_name" => array("zh-cn"=>"绑定支付的APPID","en-us"=>"APPID"),
                        "description" => array("zh-cn"=>"必须配置，开户邮件中可查看","en-us"=>"The APPID that you can find in the WeChat Pay Merchant Center"),
                        ),
                    "MCHID" => array(
                        "type" => "text",
                        "display_name" => array("zh-cn"=>"商户号","en-us"=>"Merchant ID"),
                        "description" => array("zh-cn"=>"必须配置，开户邮件中可查看","en-us"=>"Required, you can check it via the WeChat Pay email"),
                        ),
                    "KEY" => array(
                        "type" => "text",
                        "display_name" => array("zh-cn"=>"商户支付密钥","en-us"=>"Merchant Key"),
                        "description" => array("zh-cn"=>"必须配置，登录商户平台自行设置","en-us"=>"Required, you can set it in the WeChat Pay Merchant Center"),
                        ),
                    ),
                "payment_display_type" => "IMAGE",
                ),
            "com.wxpay.qrcode2" => array(
                "friend_name" => array("zh-cn" => "微信支付 - 扫码支付模式二", "en-us" => "WePay - Scanning Code Mode 2",),
                "input" => array(
                    "appid" => array(
                        "type" => "text",
                        "display_name" => array("zh-cn"=>"绑定支付的APPID","en-us"=>"APPID"),
                        "description" => array("zh-cn"=>"必须配置，开户邮件中可查看","en-us"=>"The APPID that you can find in the WeChat Pay Merchant Center"),
                        ),
                    "MCHID" => array(
                        "type" => "text",
                        "display_name" => array("zh-cn"=>"商户号","en-us"=>"Merchant ID"),
                        "description" => array("zh-cn"=>"必须配置，开户邮件中可查看","en-us"=>"Required, you can check it via the WeChat Pay email"),
                        ),
                    "KEY" => array(
                        "type" => "text",
                        "display_name" => array("zh-cn"=>"商户支付密钥","en-us"=>"Merchant Key"),
                        "description" => array("zh-cn"=>"必须配置，登录商户平台自行设置","en-us"=>"Required, you can set it in the WeChat Pay Merchant Center"),
                        ),
                    ),
                "payment_display_type" => "IMAGE",
                ),
            ),
    );
}

//创建支付，URL方式
function WxPay_CreatePaymentURL($params)
{
    //Public params
    $Aop = new AopClient();
    $Aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
    $Aop->appId = $params['appid'];
    $Aop->rsaPrivateKey = $params['input']['rsa2_private_key'];
    $Aop->apiVersion = '1.0';
    $Aop->signType = 'RSA2';
    $Aop->postCharset= 'utf-8';
    $Aop->format='json';
    $request = new AlipayTradePagePayRequest();
    $request->setReturnUrl($params['return_url']);
    $request->setNotifyUrl($params['notify_url']);

    //Payment params
    $payment_params = array(
        "product_code" => "FAST_INSTANT_TRADE_PAY",
        "out_trade_no" => $params['order_info']['order_no'],
        "subject" => $params['order_info']['subject'],
        "total_amount" => $params['order_info']['total_amount'],
        "body" => $params['order_info']['body'],
    );
    $request->setBizContent(json_encode($payment_params));
    return $Aop->pageExecute($request,"GET");
}