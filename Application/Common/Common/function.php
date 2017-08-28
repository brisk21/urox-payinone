<?php
/**
 * Created by PhpStorm.
 * User: Victor
 * Date: 2017-06-15
 * Time: 21:39
 */
function getUID(){
    if( isset($_SESSION['uid']) ) {
        return $_SESSION;
    }else{
        return false;
    }
}

function addEvent($uid, $event){
    $Event = M('event');
    $Event->data(array(
        "uid" =>$uid,
        "event" =>$event,
        "at" => date('Y-m-d H:i:s',time()),
        "ip" => get_client_ip(),
    ))->add();
}

function getDateTime(){
    return date('Y-m-d H:i:s',time());
}

function getRandChar($length){
    $str = null;
    $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $max = strlen($strPol)-1;

    for($i=0;$i<$length;$i++){
        $str.=$strPol[rand(0,$max)];//rand($min,$max)生成介于min和max两个数之间的一个随机整数
    }

    return $str;
}

