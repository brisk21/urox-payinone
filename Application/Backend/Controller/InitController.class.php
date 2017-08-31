<?php
/**
 * Created by PhpStorm.
 * User: hyyc-pc
 * Date: 2017-8-28
 * Time: 12:35
 */
namespace Backend\Controller;
use Backend\Model\UserModel;
use Think\Controller;
class InitController extends Controller{
    public function _initialize()
    {
        $System = M('system')->getField('name,value');
        C($System);
        if (C('site-open')=="OFF" and get_client_ip() != '127.0.0.1'){
            $this->show('
<html>
 <head>
  <style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover{color:blue;}</style>
 </head>
 <body>
  <div style="padding: 24px 48px;"> 
   <h1>:)</h1>
   <p>感谢使用 <b>统一支付</b></p>
   <p>维护中，请等待</p>
   <br />如果您有任何问题，请联系我们。
   <br />Version Mini v0.1 &copy; Victor Chen
  </div>
 </body>
 <footer id="page-footer" class="content-mini content-mini-full font-s12 bg-gray-lighter clearfix">
</html>
','utf8');exit;
        }
        if (isset($_SESSION['uid'])) {
            $User = new UserModel();
            $this->assign('user_info',$User->getUserInfoByUid($_SESSION['uid']));
            $this->assign('messages',M('messages')->field('title,create_at')->where(array("uid"=>$_SESSION['uid']))->select());
            $gateways_info = M('gateways_type')->field('name,friend_name,icon_html')->where(array("status"=>"ACTIVE","level"=>"TOP"))->where('`uid` = '.$_SESSION['uid'].' or `access` = "PUBLIC"')->select();
            for ($i=0;$i<count($gateways_info);$i++) {
                $l = json_decode($gateways_info[$i]['friend_name'],true);
                $gateways_info[$i]['friend_name'] = $l[LANG_SET];
            }
            $this->assign('app_count',M('apps')->where(array("uid"=>session('uid')))->where('`status` !=9')->count());
            $this->assign('gateways_info',$gateways_info);
        }
    }
}