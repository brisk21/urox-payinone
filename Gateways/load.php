<?php
/**
 * Project: Pay
 *
 * Loader::Payment Gateways
 *
 * Create at: 2017/8/26 1:13
 *
 * @author Martian@NorthmeLLC <martian@northme.com>
 */

define('GW_PATH',__DIR__);

require (__DIR__ . '/lib/class.GWHandler.php');

$Handler = new GWHandler();

//引入支付宝Aop
require(__DIR__ . '/Alipay/AopSdk.php');

//引入微信支付
require(__DIR__ . '/WxPayPubHelper/WxPayPubHelper.php');
require(__DIR__ . '/WxPay/WxPay.Api.php');
require(__DIR__ . '/WxPay/WxPay.Notify.php');