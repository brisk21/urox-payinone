<?php
/**
 * Project: PayinOne
 *
 * Model::AppGateway
 *
 * Create at: 2017-08-31 21:31
 *
 * @author Martian@NorthmeLLC <martian@northme.com>
 */
namespace Backend\Model;
use Think\Model;
class AppGatewayModel extends Model{
    public function createLink($appid,$gateway_id) {
        $this->data(array("appid"=>$appid,"gateway_id"=>$gateway_id))->add();
        return true;
    }
    
    public function readLinkByAppId($appid) {
        return $this->where(array("appid"=>$appid))->select();
    }
    
    public function readLinkByGatewayId($gateway_id) {
        return $this->where(array("gateway_id"=>$gateway_id))->select();
    }
    
    public function deleteAlllinkByAppId($appid) {
        return $this->where(array("appid"=>$appid))->delete();
    }
}