<?php
namespace Backend\Controller;
class GatewayController extends InitController{
    public function _initialize() {
        parent::_initialize();
        if ( isset($_SESSION['uid']) ){
            if ($_SESSION['uid']==1 or $_SESSION['uid']==2){
                $this->assign('isadmin',1);
            }
        } else {
            $this->error('Your session has timed out, now redirecting to login...','/auth/login',3);exit;
        }
        $this->assign('uid',session("uid"));
    }
    public function edit()
    {
        $this->meta_title = L('SideBar_AddPaymentGateway');
        $type_info = M('gateways_type')->where(array("name"=>I('get.type')))->select();
        if (!$type_info) {
            $this->error(L('Global_Error'),'/',3);
        }
        switch ($_GET['action']) {
            case 'create':
                $this->assign('types',M('gateways_type')->where(array("parent_id"=>$type_info[0]['id']))->select());
                $this->assign('SideBar_Selected','Gateway_'.$type_info[0]['name'].'Create');
                $this->assign('type_info_input',$type_info[0]['input']);
                $this->display('create');
                break;
            case 'edit':
                $this->assign('SideBar_Selected','Gateway_'.$type_info[0]['name'].'Edit');
                $this->display('edit');
                break;
        }
    }

    public function view()
    {
        $type_info = M('gateways_type')->where(array("name"=>I('get.type')))->select();
        if (!$type_info) {
            $this->error(L('Global_Error'),'/',3);
        }
        $this->assign('SideBar_Selected','Gateway_'.$type_info[0]['name'].'View');
        $this->meta_title = L('SideBar_ViewPaymentGateway');
        $this->display();
    }
}