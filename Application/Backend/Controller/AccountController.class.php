<?php
namespace Backend\Controller;
class AccountController extends InitController{
    public function profile(){
        $this->assign('SideBar_Selected','SideBar_Profile');
        $this->meta_title = L('SideBar_Profile');
        $this->display();
    }
}