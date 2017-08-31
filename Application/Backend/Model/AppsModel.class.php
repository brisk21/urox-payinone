<?php
namespace Backend\Model;
use Think\Model;
class AppsModel extends Model{
    public function getAppsInfoByAppId($appid)
    {
        $q = $this->where(array("appid"=>$appid))->select();
        if (count($q)==1) {
            return $q[0];
        } else {
            return false;
        }
    }
}