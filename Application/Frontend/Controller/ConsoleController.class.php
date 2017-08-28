<?php
namespace Frontend\Controller;
use Frontend\Model\UserModel;
class ConsoleController extends InitController{
    public function _initialize() {
        if ( isset($_SESSION['uid']) ){
            if ($_SESSION['uid']==1 or $_SESSION['uid']==2){
                $this->assign('isadmin',1);
            }
        } else {
            $this->error('Your session has timed out, now redirecting to login...','/auth/login',3);exit;
        }$this->assign('uid',session("uid"));
    }

    public function account_profile(){
        $this->meta_title = "My Profile";
        $User = new UserModel();
        $user_info = $User->getUserInfoByUid(session('uid'));
        $service_info = M('services')->where(array("uid"=>session('uid')))->select();
        $this->assign('user_info',$user_info);
        $this->assign('service_info',$service_info);
        $this->display();
    }

    public function account_settings(){
        $this->meta_title = "Account Settings";

        $this->display();
    }

    public function accoumt_change(){
        if (isset($_POST['change'])) {
            switch ($_POST['change']) {
                case 'passwd':
                    $current_passwd = $_POST['current_passwd'];
                    $new_passwd = $_POST['new_passwd'];
                    $new_passwd2 = $_POST['new_passwd2'];
                    if (!$new_passwd == $new_passwd2) {$this->error('Two passwords you have enteres is not the same!','/account/settings',3);}
                    $User = new UserModel();
                    if ($User->changePassword($new_passwd,$current_passwd)) {
                        $this->success('Your password has successfully changed!','/account/settings',3);
                    } else {
                        $this->error('The current password you have entered is nor correct...','/account/settings',3);
                    }
                    break;
                case 'email':
                    break;
            }
        }
    }
}