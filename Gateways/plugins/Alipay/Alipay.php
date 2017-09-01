<?php
// +----------------------------------------------------------------------
// | Urox PayinOne Plugins:Alipay
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2017 https://www.northme.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Victor.Chen <victor.chen@northme.com>
// +----------------------------------------------------------------------

//初始化方法，加载插件时会调用此方法，可进行引入SDK等操作
function Alipay_init()
{
    require __DIR__ . '/AopSdk/AopSdk.php';
}

//插件信息方法，具体配置方法详见文档
function Alipay_PackageInfo()
{
    return array(
        "name" => "com.alipay",
        "friend_name" => array(
            "zh-cn" => "支付宝",
            "en-us" => "Alipay",
        ),
        "icon_html" => "<i><svg class=\"icon\" width=\"22px\" viewBox=\"0 0 1294 1024\" version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" style=\"padding-top: 12px;width: 21px;fill:#c1c3c9;\"><path fill=\"#c1c3c9\" d=\"M826.028178 645.045106c88.693053-161.26482 120.946646-314.457186 120.946646-314.457186l-16.129159 0 0 0-137.069506 0-145.134086 0 0-112.888366 354.773785 0 0-48.374879L648.642073 169.324675 648.642073 0 487.383553 0l0 169.324675-322.520191 0 0 48.374879 322.520191 0 0 112.888366L213.239815 330.58792l0 48.376454 556.348904 0c0 8.06458 0 8.06458-8.06458 16.12286 0 56.441033-40.311874 137.074231-72.563893 201.575119C277.745428 435.402258 156.797207 532.161465 124.545188 548.284325-149.593825 741.794864 108.423903 983.689732 148.740502 975.625152c290.269747 64.504038 475.714132-56.441033 604.725358-209.641274 8.05828 8.066154 16.12286 8.066154 24.18744 8.066154 88.693053 48.374879 516.032306 249.949998 516.032306 249.949998L1293.685605 782.114613C1229.178417 782.114613 995.351278 701.48299 826.028178 645.045106L826.028178 645.045106zM616.390054 717.609c-201.575119 258.016153-443.460538 177.386105-483.778712 161.255371-96.751333-24.18744-129.004927-201.575119-8.06458-258.016153 201.575119-64.499314 378.962799 8.06458 507.97245 72.570193C624.453059 709.54442 616.390054 717.609 616.390054 717.609L616.390054 717.609zM616.390054 717.609\"></path></svg></i>",
        "SubPackages" => array(
            "com.alipay.pagepay" => array(
                "friend_name" => array("zh-cn" => "支付宝 - 电脑网站支付新版接口", "en-us" => "Alipay-PC Website Payment",),
                "input" => array(
                    "appid" => array(
                        "type" => "text",
                        "display_name" => array("zh-cn"=>"支付宝应用ID","en-us"=>"Alipay Application APPID"),
                        "description" => array("zh-cn"=>"蚂蚁金服应用ID，可在蚂蚁金服开放平台查看","en-us"=>"Ant Finical application id, you can find this in the ant-open platform"),
                        ),
                    "rsa2_private_key" => array(
                        "type" => "textarea",
                        "display_name" => array("zh-cn"=>"RSA2密钥","en-us"=>"RSA2 Key"),
                        "description" => array("zh-cn"=>"RSA2加密所用密钥","en-us"=>"The key for encryption"),
                        ),
                    ),
                "payment_display_type" => "URL",
                ),
            "com.alipay.wappay" => array(
                "friend_name" => array("zh-cn"=>"支付宝 - 手机网站支付","en-us"=>"Alipay-Phone Website Payment"),
                "input" => array(
                    "appid" => array(
                        "type" => "text",
                        "display_name" => array("zh-cn"=>"支付宝应用ID","en-us"=>"Alipay Application APPID"),
                        "description" => array("zh-cn"=>"蚂蚁金服应用ID，可在蚂蚁金服开放平台查看","en-us"=>"Ant Finical application id, you can find this in the ant-open platform"),
                        ),
                    "rsa2_private_key" => array(
                        "type" => "textarea",
                        "display_name" => array("zh-cn"=>"RSA2密钥","en-us"=>"RSA2 Key"),
                        "description" => array("zh-cn"=>"RSA2加密所用密钥","en-us"=>"The key for encryption"),
                        ),
                    ),
                "payment_display_type" => "URL",
                ),
            ),
    );
}

//创建支付，URL方式
function Alipay_CreatePaymentURL($params)
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