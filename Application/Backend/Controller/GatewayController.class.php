<?php
namespace Backend\Controller;
use Backend\Model\GatewaysTypeModel;

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
                $gtw_id = I('get.id');
                $gtw_info = M('gateways')->where(array("id"=>$gtw_id,"uid"=>session('uid')))->select();
                if (!$gtw_info) {
                    $this->error(L('Global_Error_NotFound'),'/gateway/view?type='.I('get.type'));exit;
                }
                $GatewaysType = new GatewaysTypeModel();
                $this->assign('type_info',$GatewaysType->getInfoByName($gtw_info[0]['subtype']));
                $this->assign('gtw_info',$gtw_info[0]);
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
        $this->assign('user_gateways_info',M('gateways')->where(array("uid"=>session('uid'),"type"=>I('get.type')))->select());
        $this->assign('public_gateways_info',M('gateways')->where(array("type"=>I('get.type'),"access"=>"PUBLIC"))->where("`uid` !=".session('uid'))->select());
        $this->assign('SideBar_Selected','Gateway_'.$type_info[0]['name'].'View');
        $this->meta_title = L('SideBar_ViewPaymentGateway');
        $this->display();
    }

    public function actionEditSave()
    {
        switch ( $_GET['action'] )
        {
            case 'create':
                $config_arr = parseJqJSON2(json_decode($_POST['form_data'],true));
                $sub_type_id = $_POST['type_id'];
                $GatewaysType = new GatewaysTypeModel();
                $sub_type_info = $GatewaysType->getInfoById($sub_type_id);
                $type_info = $GatewaysType->getInfoById($sub_type_info['parent_id']);
                $type_name = $type_info['name'];
                $sub_type_name = $sub_type_info['name'];
                $name = $config_arr['gtw_name'];
                if (count(M('gateways')->where(array("name"=>$name))->select())!=0) {
                    echo json_encode(array(
                        "error" => true,
                        "msg" => L('GatewayAdd_GatewayNameExists'),
                    ));exit;
                }
                $friend_name = $config_arr['gtw_friend_name'];
                $support_phone = $config_arr['gtw_SupportPhone'] == 'on' ? "ON" : "OFF";
                $require_phone = $config_arr['gtw_RequirePhone'] == 'on' ? "ON" : "OFF";
                $status = $config_arr['gtw_status'];
                $access = $config_arr['gtw_access'];
                unset($config_arr['gtw_name']);
                unset($config_arr['gtw_friend_name']);
                unset($config_arr['gtw_SupportPhone']);
                unset($config_arr['gtw_RequirePhone']);
                unset($config_arr['gtw_status']);
                unset($config_arr['gtw_access']);
                $config = $config_arr;
                $con = array(
                    "name" => $name,
                    "type" => $type_name,
                    "subtype" => $sub_type_name,
                    "config" => json_encode($config),
                    "uid" => session('uid'),
                    "create_at" => getDateTime(),
                    "status" => $status,
                    "phone_support" => $support_phone,
                    "phone_required" => $require_phone,
                    "access" => $access,
                    "friend_name" => $friend_name
                );
                $id = M('gateways')->data($con)->add();
                echo json_encode(array(
                    "success" => true,
                    "msg" => L('Gateway_SubmitSuccess')
                ));exit;
                break;
            case 'edit':
                $config_arr = parseJqJSON2(json_decode($_POST['form_data'],true));
                $sub_type_id = $_POST['type_id'];
                $GatewaysType = new GatewaysTypeModel();
                $sub_type_info = $GatewaysType->getInfoById($sub_type_id);
                $type_info = $GatewaysType->getInfoById($sub_type_info['parent_id']);
                $type_name = $type_info['name'];
                $sub_type_name = $sub_type_info['name'];
                $name = $config_arr['gtw_name'];
                $q2 = M('gateways')->where(array("name"=>$name))->select();
                if (count($q2)==0) {
                    echo json_encode(array(
                        "error" => true,
                        "msg" => L('Gateway_SubmitError'),
                    ));exit;
                } else {$q2 =$q2[0];}
                $friend_name = $config_arr['gtw_friend_name'];
                $support_phone = $config_arr['gtw_SupportPhone'] == 'on' ? "ON" : "OFF";
                $require_phone = $config_arr['gtw_RequirePhone'] == 'on' ? "ON" : "OFF";
                $status = $config_arr['gtw_status'];
                $access = $config_arr['gtw_access'];
                unset($config_arr['gtw_name']);
                unset($config_arr['gtw_friend_name']);
                unset($config_arr['gtw_SupportPhone']);
                unset($config_arr['gtw_RequirePhone']);
                unset($config_arr['gtw_status']);
                unset($config_arr['gtw_access']);
                $config = $config_arr;
                $con = array(
                    "config" => json_encode($config),
                    "update_at" => getDateTime(),
                    "status" => $status,
                    "phone_support" => $support_phone,
                    "phone_required" => $require_phone,
                    "access" => $access,
                    "friend_name" => $friend_name
                );
                $id = M('gateways')->where(array("name"=>$name))->data($con)->save();
                echo json_encode(array(
                    "success" => true,
                    "msg" => L('Gateway_SubmitSuccess')
                ));exit;
                break;
            default:
                break;
        }
    }
}