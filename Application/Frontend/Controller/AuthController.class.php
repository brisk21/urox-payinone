<?php
namespace Frontend\Controller;
class AuthController extends InitController {
    public function _initialize(){
        parent::_initialize();
        if (isset($_SESSION['uid']) and ACTION_NAME!='logout' and ACTION_NAME !='register'){
            redirect('/app/view');
        }
        $uid = $_SESSION['uid'];
        if ($uid=2 or $uid=1) $this->assign('isadmin',TRUE);
    }

    public function login(){
        if (isset($_POST['loginSubmit'])) {
            $uname = $_POST['uname'];
            $passwd = $_POST['passwd'];
            $Q = M('user')->where(array("uname"=>$uname,"passwd"=>$passwd))->select();
            if (count($Q)==1) {
                session('uid',$Q[0]['uid']);
                M('user')->where(array("uid"=>$Q[0]['uid']))->data(array(
                    "ip"=>get_client_ip(),
                    "last_login_time"=>getDateTime(),
                ))->save();
                addEvent($_SESSION['uid'],'User:'.$uname.' logon from '.get_client_ip());
                redirect('/app/view');
            }else {
                $this->error('The credentials you have inputed cannot be validated.',"/auth/login",3);
            }
        }
        $this->meta_title="Login to TC";
        $this->display();
    }

    public function logout(){
        session(null);
        cookie(null);
        $this->success('Sign out success, redirecting to login...','/auth/login',3);
    }

    public function register(){
        $this->meta_title = "Sign up";
        if (isset($_POST['registerSubmit'])) {
            $email = I('post.email');
            $uname = I('post.uname');
            $passwd = I('post.passwd');
            if (!preg_match('/^[a-z]([a-z0-9]*[-_]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[\.][a-z]{2,3}([\.][a-z]{2})?$/i',$email)||
                trim($uname)=='' ||
                trim($passwd) == ''
            ) {$this->error('The info you entered has somthing wrong.','/register',3);exit;}
            else {
                $uid = M('user')->data(array(
                    "uname" => $uname,
                    "passwd" => $passwd,
                    "email"=>$email,
                    "ip" => get_client_ip(),
                    "reg_time" => getDateTime(),
                ))->add();
                session('uid',$uid);
                $this->success('Registration succeed! Now restricting to the panel...','/app/view',3);exit;
            }
        }
        $this->display();
    }
}