<?php
namespace Backend\Controller;
class GatewayController extends InitController{
    public function create()
    {
        switch (I('get.type'))
        {
            case 'com.alipay':
                $Aop = new \AopClient();
                $Aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
                $Aop->appId = '2017082508384197';
                $Aop->rsaPrivateKey = 'MIIEogIBAAKCAQEAwGXgYh3s9N43XjOt8Vo0x4Ydcq9kufOTniPDEyK1L9fyJxAFQjiSrL8BGPhpdKVD7ROylb29wSMju+jzh7FyPdbTh+nGOl/8CxcLPsUaIfGpvbfl1n86U2HpP4zK7d1DJgCzhZhdGFK8pHMJ0GA4PITWQKv/oE0fQcwikYAgonCnmCLSi77J4c2CR6rq7m4gVFsFB6Wt7vaz8umpoD9/nefZflZ/kEB1737oCE+x6YVA8UnNorLfs3KfR/3FavU/FNmoujjGqAKc8cWhn0VJ01u7GksOM/TG+/yWYuH7ai4E0LP7ujGCFyNoeIOv2eMQnTXzYAONQmoFPwSUNn1/QQIDAQABAoIBABUy5G9LJtGwLl+VyCOgsdIOJ+57/tgyS2CQRi00lMwpugetzzaFrzuTbBaJQG1WzE4x7mprVp4SNhy9RR/9YD4KDpKaInpKGyZJqraG1yNIUlCSE6P3rsCDOEUFSVK+H2jviNg+ent0mk5wUnOANpIMfOLxUKAj/z6rtF9dw7rCB6hMcVOEVFdVnVEbZDUsFfPMyE4hi1U8XW/fKotYRrXDZf89sLu2Ma4h0Rxio9QiBlKBxYe5C/NoZEGD1krjwMOtx4rqLi7Dzhorn+DMKOHtx2SPxU5qKYPz8gPTHSOcCLFFgHBevVkdRfCYylZYUDugGpX6RXNmE5SM1PHUuuUCgYEA+VQzThfyd00zpccLKmLGWQVFWtkMn+mTnA5Dc6gKKc70cwWFvpkOFGimeWvF1uCn2SYI65mdz3IKROyeP572ZO/S/gM3HXCGJnYLR9IRpOdwM5vwX8ZeG/hHIka6XEKMiogNE6sXMGw2fwpVZe1d/tPgucNp/TrPgkKz17oK0MsCgYEAxYu5AVoJYE/3m/Q1WVwaiGKp4vGpNFpFLu29NFspYshRQCkzdBdRq9u8WGlIlKJ793+GOd5OeNvTN7k2MTe7paj+wM/5gOjajrvDozVAoYzrlrnWTsWHWuyKzkXgnMD9m2u1D+lpLLI99BspU+qnOZDhkpf/AvEbsza51Zkj6qMCgYBPjcU9ArkTxedX2vW+FXwyRVNG1ICJua6mmYp+KbzscCNhW/67vPxYGLgdf/zFPjNwPwmTmxVWbo3GRjWMGT2HIVqSQBZi51d2iC27QdTtaAdOAFCnTpUSmZqg3i5yZ62OOjDp+KpSggS1bmenOSDHwXUv8KEt8ojpiDz39V2kFwKBgHym4AS0VbpKe4oTHR7X+X4aE+06ZHS+iW1FYuCIraLBmFOOLAOTO1vgegan2L7BkMvp0j7twkKNI8jDvChubJ/p9WahVWU8ib0LSjXQQoouK/KeLVbjWbfMDwJ+IW+Ib/8EheoWdOFZT7Ka+QcUyJSQkWY5NxcaIUqCu9zGl11VAoGAAuO/WzdXaxE8c37ZKdVGATRkW56u8hgk7ZGHFdm7giPo1ECkf15aHP+fsZyD6KCoRPgOdJP3SsbZEjuranXdjtIFO0lwr1g4XFTdw2xOzv5f2l2dDiFT+PXRx6UYT6rDsGtb4aSWKvI8CFQYVLJoPNpHXrMLRN82p/LrMdZLUt4=';
                $Aop->apiVersion = '1.0';
                $Aop->signType = 'RSA2';
                $Aop->postCharset= 'utf-8';
                $Aop->format='json';
                $request = new \AlipayTradePagePayRequest();
                $request->setReturnUrl('https://pay-frontend.urox.cn/gateways/alipay/callbackRedirect');
                $request->setNotifyUrl('https://pay-api.urox.cn/gateways/alipay/callbackNotify');
                $params = array(
                    "product_code" => "FAST_INSTANT_TRADE_PAY",
                    "out_trade_no" => date('Y-m-d H:i:s').getRandChar(3),
                    "subject" => '测试商品'.getRandChar(3),
                    "total_amount" => "0.01",
                    "body" => '测试商品',
                );
                $request->setBizContent(json_encode($params));
                $result = $Aop->pageExecute ($request,"GET");
                
                echo json_encode($result);exit;
                
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