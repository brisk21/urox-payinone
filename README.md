# Urox PayinOne - 北径科技统一支付平台
---
## 1. 程序说明
### 1.1 简介
PayinOne将各大支付平台的接口集中为单点平台，将支付需求应用化，弹性控制，数据分析方便，一定程度上有效解决了各大支付平台接口复杂，流程复杂的弊端，为企业和个人快速接入支付能力提供了方便。
### 1.2 功能
- 支付需求应用化：为你每个项目建立一个**独立的**PayinOne应用，可以随时控制支付的开关，添加支付网关等。
- 支付过程简洁：在最多两个页面内完成整个支付过程
- 无须担心被暴力破解出对接第三方支付时的MD5或Sign_Key等内容
- API简洁明快：为开发者提供了清晰的思路，甚至只需要执行**两行代码**，即可完成整个发起支付过程
- 多语言支持：目前默认支持简体中文（zh-CN）和英语（en-US），可自由扩展，任意选用
### 1.3 术语
- 应用：这里的应用指每一个独立的支付项目，该应用为统一支付的起点。例如，为公司的商城项目在PayinOne建立一个**应用**。
- 支付网关：指PayinOne将对接的第三方支付平台接口，PayinOne默认支持的支付网关如下：
  - [支付宝 - 电脑网站支付](https://b.alipay.com/signing/productDetail.htm?productId=I1011000290000001000)
  - [支付宝 - 手机网站支付](https://b.alipay.com/signing/productDetail.htm?productId=I1011000290000001001)
  - [微信 - 扫码支付](https://pay.weixin.qq.com/guide/qrcode_payment.shtml)
  - [微信 - H5支付](https://pay.weixin.qq.com/wiki/doc/api/H5.php?chapter=15_1)
## 2. 部署
### 2.1 需求
- 环境需求
  - PHP版本 >= 5.3.0，测试环境为5.6.31
  - MySQL 版本 >= 5.1，测试环境为5.5.56
  - Web服务器推荐使用 [Apache](http://www.apache.org/) 或 [nginx](http://nginx.org/)
- 资源需求
  - 三个域名：在默认配置中，使用以下域名：
    - pay-frontend.\*为前缀作为前台（用户可见部分）域名
    - pay-backend.\*为前缀作为后台（应用管理后台）域名
    - pay-api.\*为前缀作为API接口域名
- 网关需求
  - 你需要从第三方支付平台获取MD5，SIGN_KEY等用于对接的凭据
### 2.2 部署过程
