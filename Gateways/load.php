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
define('GW_LIB_DIR',GW_PATH.'/lib');
define('GW_PLUG_DIR',GW_PATH.'/plugins');
require (GW_LIB_DIR . '/class.GWHandler.php');

$Handler = new GWHandler();
