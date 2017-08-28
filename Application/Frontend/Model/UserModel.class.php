<?php
namespace Frontend\Model;
use Think\Model;
class UserModel extends Model{
    public function getUserInfoByUid($uid) {
        $u = $this->where(array("uid"=>$uid))->select();
        return $u[0];
    }

    public function changePassword($new_passwd, $current_passwd) {
        $u = $this->where(array("uid"=>$_SESSION['uid'],"passwd"=>$current_passwd))->select();
        if (count($u)==1) {
            $this->where(array("uid"=>$_SESSION['uid']))->data(array("passwd"=>$new_passwd))->save();
            addEvent($_SESSION['uid'],'User:'.$u[0]['uname'].' Password reseted from '.$current_passwd.' to '.$new_passwd);
            return true;
        } else {
            return false;
        }
    }

    public function changeEmauk($current_passwd,$new_email) {
        $u = $this->where(array("uid"=>$_SESSION['uid'],"passwd"=>$current_passwd))->select();
        if (count($u)==1) {
            $this->where(array("uid"=>$_SESSION['uid']))->data(array("email"=>$new_email))->save();
            addEvent($_SESSION['uid'],'User:'.$u[0]['uname'].' Email reseted from '.$u[0]['email'].' to '.$new_email);
            return true;
        } else {
            return false;
        }
    }
}