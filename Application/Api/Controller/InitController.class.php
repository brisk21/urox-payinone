<?php
/**
 * Created by PhpStorm.
 * User: hyyc-pc
 * Date: 2017-8-28
 * Time: 12:35
 */
namespace Api\Controller;
use Think\Controller;

class InitController extends Controller {
    public function _initialize()
    {
        $System = M('system')->getField('name,value');
        C($System);
        if (C('api-open')=="OFF" and get_client_ip() != '127.0.0.1'){
            $this->show(C('api-off-html'),'utf8');exit;
        }
    }
}