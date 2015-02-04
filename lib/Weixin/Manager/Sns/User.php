<?php
namespace Weixin\Manager\Sns;

use Weixin\Client;

/**
 * 用户管理----网页授权获取用户基本信息接口
 *
 * 如果用户在微信中（Web微信除外）访问公众号的第三方网页，
 * 公众号开发者可以通过此接口获取当前用户基本信息（包括昵称、性别、城市、国家）。
 * 利用用户信息，可以实现体验优化、用户来源统计、帐号绑定、用户身份鉴权等功能。
 * 请注意，“获取用户基本信息接口是在用户和公众号产生消息交互时，
 * 才能根据用户OpenID获取用户基本信息，而网页授权的方式获取用户基本信息，
 * 则无需消息交互，只是用户进入到公众号的网页，就可弹出请求用户授权的界面，
 * 用户授权后，就可获得其基本信息（此过程甚至不需要用户已经关注公众号。）”
 *
 * 本接口是通过OAuth2.0来完成网页授权的，是安全可靠的，关于OAuth2.0的详细介绍，
 * 可以参考OAuth2.0协议标准。在微信公众号请求用户网页授权之前，
 * 开发者需要先到公众平台网站的我的服务页中配置授权回调域名。
 * 请注意，这里填写的域名不要加http://
 *
 * 关于配置授权回调域名的说明：
 * 授权回调域名配置规范为全域名，比如需要网页授权的域名为：www.qq.com，
 * 配置以后此域名下面的页面http://www.qq.com/music.html 、
 * http://www.qq.com/login.html 都可以进行OAuth2.0鉴权。
 * 但http://pay.qq.com 、 http://music.qq.com 、 http://qq.com
 * 无法进行OAuth2.0鉴权。
 *
 * 具体而言，网页授权流程分为三步：
 * 1 引导用户进入授权页面同意授权，获取code
 * 2 通过code换取网页授权access_token（与基础支持中的access_token不同）
 * 3 如果需要，开发者可以刷新网页授权access_token，避免过期
 * 4 通过网页授权access_token和openid获取用户基本信息
 *
 * @author guoyongrong <handsomegyr@gmail.com>
 * @author young <youngyang@icatholic.net.cn>
 */
class User
{

    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    public function getSnsUserInfo($openid, $lang = 'zh_CN')
    {
        $params = array();
        $params['openid'] = $openid;
        $params['lang'] = $lang;
        $rst = $this->_request->get('sns/userinfo', $params);
        return $this->_client->rst($rst);
    }
}
