<?php
/**
 * Project: PayinOne
 *
 * Model::gateways_type
 *
 * Create at: 2017-08-31 13:33
 *
 * @author Martian@NorthmeLLC <martian@northme.com>
 */
namespace Backend\Model;
use Think\Model;
class GatewaysTypeModel extends Model{
    public function getInfoById($id) {
        $q1 = $this->where(array("id"=>$id))->select();
        $q1[0]['friend_name'] = $this->parseFriendName($q1[0]['friend_name']);
        return $q1[0];
    }
    
    public function getInfoByName($name) {
        $q1 = $this->where(array("name"=>$name))->select();
        $q1[0]['friend_name'] = $this->parseFriendName($q1[0]['friend_name']);
        return $q1[0];
    }

    private function parseFriendName($_original) {
        $p1 = json_decode($_original,true);
        return $p1[LANG_SET];
    }
}