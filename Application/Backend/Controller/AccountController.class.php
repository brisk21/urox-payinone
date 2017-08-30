<?php
namespace Backend\Controller;
class AccountController extends InitController{
    public function _initialize() {
        parent::_initialize();
        if ( isset($_SESSION['uid']) ){
            if ($_SESSION['uid']==1 or $_SESSION['uid']==2){
                $this->assign('isadmin',1);
            }
        } else {
            $this->error('Your session has timed out, now redirecting to login...','/auth/login',3);exit;
        }$this->assign('uid',session("uid"));
    }
    public function profile(){
        $this->assign('SideBar_Selected','SideBar_Profile');
        $this->meta_title = L('SideBar_Profile');
        $this->display();
    }
}