<?php
namespace Backend\Controller;
class GatewayController extends InitController{
    public function create()
    {
        switch (I('get.type'))
        {
            case 'com.alipay':
                $this->assign('SideBar_Selected','Gateway_AlipayCreate');
                break;
            case 'com.wxpay':
                $this->assign('SideBar_Selected','Gateway_WxPayCreate');
                break;
            default:
                $this->error('发生错误，请尝试联系管理员','/',3);
        }
        $this->meta_title = L('SideBar_AddPaymentGateway');
        $this->display();
    }

    public function view()
    {
        switch (I('get.type'))
        {
            case 'com.alipay':
                $this->assign('SideBar_Selected','Gateway_AlipayView');
                break;
            case 'com.wxpay':
                $this->assign('SideBar_Selected','Gateway_WxPayView');
                break;
            default:
                $this->error('发生错误，请尝试联系管理员','/',3);
        }
        $this->meta_title = L('SideBar_ViewPaymentGateway');
        $this->display();
    }
}