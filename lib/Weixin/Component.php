<?php
namespace Weixin;

use Weixin\Http\Request2;
use Weixin\Helpers;
use Weixin\Exception;

class Component
{
    // 接口地址
    private $_url = 'https://api.weixin.qq.com/cgi-bin/component/';

    private $_appid = null;

    private $_secret = null;

    private $_accessToken = null;

    protected $_request = null;

    /**
     * 初始化认证的http请求对象
     */
    protected function initRequest()
    {
        $this->_request = new Request2();
    }

    /**
     * 获取请求对象
     *
     * @return \Weixin\Http\Request2
     */
    protected function getRequest()
    {
        if (empty($this->_request)) {
            $this->initRequest();
        }
        return $this->_request;
    }

    public function __construct($component_appid, $component_appsecret)
    {
        $this->_appid = $component_appid;
        $this->_secret = $component_appsecret;
        $this->_request = $this->getRequest();
    }

    /**
     * 获取服务端的accessToken
     *
     * @throws Exception
     */
    public function getAccessToken()
    {
        if (empty($this->_accessToken)) {
            throw new Exception("请设定access_token");
        }
        return $this->_accessToken;
    }

    /**
     * 设定服务端的access token
     *
     * @param string $accessToken            
     */
    public function setAccessToken($accessToken)
    {
        $this->_accessToken = $accessToken;
        return $this;
    }

    /**
     * 2、获取第三方平台component_access_token
     * 第三方平台compoment_access_token是第三方平台的下文中接口的调用凭据，也叫做令牌（component_access_token）。每个令牌是存在有效期（2小时）的，且令牌的调用不是无限制的，请第三方平台做好令牌的管理，在令牌快过期时（比如1小时50分）再进行刷新。
     * 接口调用请求说明
     * http请求方式: POST（请使用https协议）
     * https://api.weixin.qq.com/cgi-bin/component/api_component_token
     * POST数据示例:
     * {
     * "component_appid":"appid_value" ,
     * "component_appsecret": "appsecret_value",
     * "component_verify_ticket": "ticket_value"
     * }
     * 请求参数说明
     * 参数 说明
     * component_appid 第三方平台appid
     * component_appsecret 第三方平台appsecret
     * component_verify_ticket 微信后台推送的ticket，此ticket会定时推送，具体请见本页的推送说明
     * 返回结果示例
     * {
     * "component_access_token":"61W3mEpU66027wgNZ_MhGHNQDHnFATkDa9-2llqrMBjUwxRSNPbVsMmyD-yq8wZETSoE5NQgecigDrSHkPtIYA",
     * "expires_in":7200
     * }
     *
     * 结果参数说明
     * 参数 说明
     * component_access_token 第三方平台access_token
     * expires_in 有效期
     *
     * @return mixed
     */
    public function apiComponentToken($component_verify_ticket)
    {
        $params = array(
            'component_appid' => $this->_appid,
            'component_appsecret' => $this->_secret,
            'component_verify_ticket' => $component_verify_ticket
        );
        $rst = $this->_request->post($this->_url . 'api_component_token', $params);
        if (! empty($rst['errcode'])) {
            // 如果有异常，会在errcode 和errmsg 描述出来。
            throw new Exception($rst['errmsg'], $rst['errcode']);
        } else {
            return $rst;
        }
    }

    /**
     * 3、获取预授权码pre_auth_code
     * 该API用于获取预授权码。预授权码用于公众号授权时的第三方平台方安全验证。
     * 接口调用请求说明
     * http请求方式: POST（请使用https协议）
     * https://api.weixin.qq.com/cgi-bin/component/api_create_preauthcode?component_access_token=xxx
     * POST数据示例:
     * {
     * "component_appid":"appid_value"
     * }
     * 请求参数说明
     * 参数 说明
     * component_appid 第三方平台方appid
     * 返回结果示例
     * {
     * "pre_auth_code":"Cx_Dk6qiBE0Dmx4EmlT3oRfArPvwSQ-oa3NL_fwHM7VI08r52wazoZX2Rhpz1dEw",
     * "expires_in":600
     * }
     * 结果参数说明
     * 参数 说明
     * pre_auth_code 预授权码
     * expires_in 有效期，为20分钟
     */
    public function apiCreatePreauthcode()
    {
        $params = array(
            'component_appid' => $this->_appid
        );
        $rst = $this->_request->post($this->_url . 'api_create_preauthcode?component_access_token=' . $this->getAccessToken(), $params);
        if (! empty($rst['errcode'])) {
            // 如果有异常，会在errcode 和errmsg 描述出来。
            throw new Exception($rst['errmsg'], $rst['errcode']);
        } else {
            return $rst;
        }
    }

    /**
     * 4、使用授权码换取公众号的接口调用凭据和授权信息
     * 该API用于使用授权码换取授权公众号的授权信息，并换取authorizer_access_token和authorizer_refresh_token。 授权码的获取，需要在用户在第三方平台授权页中完成授权流程后，在回调URI中通过URL参数提供给第三方平台方。请注意，由于现在公众号可以自定义选择部分权限授权给第三方平台，因此第三方平台开发者需要通过该接口来获取公众号具体授权了哪些权限，而不是简单地认为自己声明的权限就是公众号授权的权限。
     * 接口调用请求说明
     * http请求方式: POST（请使用https协议）
     * https://api.weixin.qq.com/cgi-bin/component/api_query_auth?component_access_token=xxxx
     * POST数据示例:
     * {
     * "component_appid":"appid_value" ,
     * "authorization_code": "auth_code_value"
     * }
     *
     * 请求参数说明
     * 参数 说明
     * component_appid 第三方平台appid
     * authorization_code 授权code,会在授权成功时返回给第三方平台，详见第三方平台授权流程说明
     * 返回结果示例
     * {
     * "authorization_info": {
     * "authorizer_appid": "wxf8b4f85f3a794e77",
     * "authorizer_access_token": "QXjUqNqfYVH0yBE1iI_7vuN_9gQbpjfK7hYwJ3P7xOa88a89-Aga5x1NMYJyB8G2yKt1KCl0nPC3W9GJzw0Zzq_dBxc8pxIGUNi_bFes0qM",
     * "expires_in": 7200,
     * "authorizer_refresh_token": "dTo-YCXPL4llX-u1W1pPpnp8Hgm4wpJtlR6iV0doKdY",
     * "func_info": [
     * {
     * "funcscope_category": {
     * "id": 1
     * }
     * },
     * {
     * "funcscope_category": {
     * "id": 2
     * }
     * },
     * {
     * "funcscope_category": {
     * "id": 3
     * }
     * }
     * ]
     * }
     *
     * 结果参数说明
     * 参数 说明
     * authorization_info 授权信息
     * authorizer_appid 授权方appid
     * authorizer_access_token 授权方接口调用凭据（在授权的公众号具备API权限时，才有此返回值），也简称为令牌
     * expires_in 有效期（在授权的公众号具备API权限时，才有此返回值）
     * authorizer_refresh_token 接口调用凭据刷新令牌（在授权的公众号具备API权限时，才有此返回值），刷新令牌主要用于公众号第三方平台获取和刷新已授权用户的access_token，只会在授权时刻提供，请妥善保存。 一旦丢失，只能让用户重新授权，才能再次拿到新的刷新令牌
     * func_info 公众号授权给开发者的权限集列表，ID为1到15时分别代表：
     * 消息管理权限
     * 用户管理权限
     * 帐号服务权限
     * 网页服务权限
     * 微信小店权限
     * 微信多客服权限
     * 群发与通知权限
     * 微信卡券权限
     * 微信扫一扫权限
     * 微信连WIFI权限
     * 素材管理权限
     * 微信摇周边权限
     * 微信门店权限
     * 微信支付权限
     * 自定义菜单权限
     *
     * 请注意：
     * 1）该字段的返回不会考虑公众号是否具备该权限集的权限（因为可能部分具备），请根据公众号的帐号类型和认证情况，来判断公众号的接口权限。
     *
     * @throws Exception
     * @return unknown
     */
    public function apiQueryAuth($authorization_code)
    {
        $params = array(
            'component_appid' => $this->_appid,
            'authorization_code' => $authorization_code
        );
        $rst = $this->_request->post($this->_url . 'api_query_auth?component_access_token=' . $this->getAccessToken(), $params);
        if (! empty($rst['errcode'])) {
            // 如果有异常，会在errcode 和errmsg 描述出来。
            throw new Exception($rst['errmsg'], $rst['errcode']);
        } else {
            return $rst;
        }
    }

    /**
     * 5、获取（刷新）授权公众号的接口调用凭据（令牌）
     * 该API用于在授权方令牌（authorizer_access_token）失效时，可用刷新令牌（authorizer_refresh_token）获取新的令牌。请注意，此处token是2小时刷新一次，开发者需要自行进行token的缓存，避免token的获取次数达到每日的限定额度。缓存方法可以参考：http://mp.weixin.qq.com/wiki/2/88b2bf1265a707c031e51f26ca5e6512.html
     * 接口调用请求说明
     * http请求方式: POST（请使用https协议）
     * https:// api.weixin.qq.com /cgi-bin/component/api_authorizer_token?component_access_token=xxxxx
     * POST数据示例:
     * {
     * "component_appid":"appid_value",
     * "authorizer_appid":"auth_appid_value",
     * "authorizer_refresh_token":"refresh_token_value",
     * }
     *
     * 请求参数说明
     * 参数 说明
     * component_appid 第三方平台appid
     * authorizer_appid 授权方appid
     * authorizer_refresh_token 授权方的刷新令牌，刷新令牌主要用于公众号第三方平台获取和刷新已授权用户的access_token，只会在授权时刻提供，请妥善保存。一旦丢失，只能让用户重新授权，才能再次拿到新的刷新令牌
     * 返回结果示例
     * {
     * "authorizer_access_token": "aaUl5s6kAByLwgV0BhXNuIFFUqfrR8vTATsoSHukcIGqJgrc4KmMJ-JlKoC_-NKCLBvuU1cWPv4vDcLN8Z0pn5I45mpATruU0b51hzeT1f8",
     * "expires_in": 7200,
     * "authorizer_refresh_token": "BstnRqgTJBXb9N2aJq6L5hzfJwP406tpfahQeLNxX0w"
     * }
     *
     * 结果参数说明
     * 参数 说明
     * authorizer_access_token 授权方令牌
     * expires_in 有效期，为2小时
     * authorizer_refresh_token 刷新令牌
     */
    public function apiAuthorizerToken($authorizer_appid, $authorizer_refresh_token)
    {
        $params = array(
            'component_appid' => $this->_appid,
            'authorizer_appid' => $authorizer_appid,
            'authorizer_refresh_token' => $authorizer_refresh_token
        );
        $rst = $this->_request->post($this->_url . 'api_authorizer_token?component_access_token=' . $this->getAccessToken(), $params);
        if (! empty($rst['errcode'])) {
            // 如果有异常，会在errcode 和errmsg 描述出来。
            throw new Exception($rst['errmsg'], $rst['errcode']);
        } else {
            return $rst;
        }
    }

    /**
     * 6、获取授权方的公众号帐号基本信息
     * 该API用于获取授权方的公众号基本信息，包括头像、昵称、帐号类型、认证类型、微信号、原始ID和二维码图片URL。
     * 需要特别记录授权方的帐号类型，在消息及事件推送时，对于不具备客服接口的公众号，需要在5秒内立即响应；而若有客服接口，则可以选择暂时不响应，而选择后续通过客服接口来发送消息触达粉丝。
     * 接口调用请求说明
     * http请求方式: POST（请使用https协议）
     * https://api.weixin.qq.com/cgi-bin/component/api_get_authorizer_info?component_access_token=xxxx
     * POST数据示例:
     * {
     * "component_appid":"appid_value" ,
     * "authorizer_appid": "auth_appid_value"
     * }
     *
     * 请求参数说明
     * 参数 说明
     * component_appid 服务appid
     * authorizer_appid 授权方appid
     * 返回结果示例
     *
     *
     * {
     * "authorizer_info": {
     * "nick_name": "微信SDK Demo Special",
     * "head_img": "http://wx.qlogo.cn/mmopen/GPyw0pGicibl5Eda4GmSSbTguhjg9LZjumHmVjybjiaQXnE9XrXEts6ny9Uv4Fk6hOScWRDibq1fI0WOkSaAjaecNTict3n6EjJaC/0",
     * "service_type_info": { "id": 2 },
     * "verify_type_info": { "id": 0 },
     * "user_name":"gh_eb5e3a772040",
     * "business_info": {"open_store": 0, "open_scan": 0, "open_pay": 0, "open_card": 0, "open_shake": 0},
     * "alias":"paytest01"
     * },
     * "qrcode_url":"URL",
     * "authorization_info": {
     * "appid": "wxf8b4f85f3a794e77",
     * "func_info": [
     * { "funcscope_category": { "id": 1 } },
     * { "funcscope_category": { "id": 2 } },
     * { "funcscope_category": { "id": 3 } }
     * ]
     * }
     * }
     *
     * 结果参数说明
     * 参数 说明
     * nick_name 授权方昵称
     * head_img 授权方头像
     * service_type_info 授权方公众号类型，0代表订阅号，1代表由历史老帐号升级后的订阅号，2代表服务号
     * verify_type_info 授权方认证类型，-1代表未认证，0代表微信认证，1代表新浪微博认证，2代表腾讯微博认证，3代表已资质认证通过但还未通过名称认证，4代表已资质认证通过、还未通过名称认证，但通过了新浪微博认证，5代表已资质认证通过、还未通过名称认证，但通过了腾讯微博认证
     * user_name 授权方公众号的原始ID
     * alias 授权方公众号所设置的微信号，可能为空
     * business_info
     * 用以了解以下功能的开通状况（0代表未开通，1代表已开通）：
     * open_store:是否开通微信门店功能
     * open_scan:是否开通微信扫商品功能
     * open_pay:是否开通微信支付功能
     * open_card:是否开通微信卡券功能
     * open_shake:是否开通微信摇一摇功能
     * qrcode_url 二维码图片的URL，开发者最好自行也进行保存
     * authorization_info 授权信息
     * appid 授权方appid
     * func_info 公众号授权给开发者的权限集列表，ID为1到15时分别代表：
     * 消息管理权限
     * 用户管理权限
     * 帐号服务权限
     * 网页服务权限
     * 微信小店权限
     * 微信多客服权限
     * 群发与通知权限
     * 微信卡券权限
     * 微信扫一扫权限
     * 微信连WIFI权限
     * 素材管理权限
     * 微信摇周边权限
     * 微信门店权限
     * 微信支付权限
     * 自定义菜单权限
     *
     * 请注意：
     * 1）该字段的返回不会考虑公众号是否具备该权限集的权限（因为可能部分具备），请根据公众号的帐号类型和认证情况，来判断公众号的接口权限。
     */
    public function apiGetAuthorizerInfo($authorizer_appid)
    {
        $params = array(
            'component_appid' => $this->_appid,
            'authorizer_appid' => $authorizer_appid
        );
        $rst = $this->_request->post($this->_url . 'api_get_authorizer_info?component_access_token=' . $this->getAccessToken(), $params);
        if (! empty($rst['errcode'])) {
            // 如果有异常，会在errcode 和errmsg 描述出来。
            throw new Exception($rst['errmsg'], $rst['errcode']);
        } else {
            return $rst;
        }
    }

    /**
     * 7、获取授权方的选项设置信息
     * 该API用于获取授权方的公众号的选项设置信息，如：地理位置上报，语音识别开关，多客服开关。注意，获取各项选项设置信息，需要有授权方的授权，详见权限集说明。
     * 接口调用请求说明
     * http请求方式: POST（请使用https协议）https://api.weixin.qq.com/cgi-bin/component/ api_get_authorizer_option?component_access_token=xxxx
     * POST数据示例
     * {
     * "component_appid":"appid_value",
     * "authorizer_appid": " auth_appid_value ",
     * "option_name": "option_name_value"
     * }
     *
     * 请求参数说明
     * 参数 说明
     * component_appid 第三方平台appid
     * authorizer_appid 授权公众号appid
     * option_name 选项名称
     * 返回结果示例
     * {
     * "authorizer_appid":"wx7bc5ba58cabd00f4",
     * "option_name":"voice_recognize",
     * "option_value":"1"
     * }
     *
     * 结果参数说明
     * 参数 说明
     * authorizer_appid 授权公众号appid
     * option_name 选项名称
     * option_value 选项值
     */
    public function apiGetAuthorizerOption($authorizer_appid, $option_name)
    {
        $params = array(
            'component_appid' => $this->_appid,
            'authorizer_appid' => $authorizer_appid,
            'option_name' => $option_name
        );
        $rst = $this->_request->post($this->_url . 'api_get_authorizer_option?component_access_token=' . $this->getAccessToken(), $params);
        if (! empty($rst['errcode'])) {
            // 如果有异常，会在errcode 和errmsg 描述出来。
            throw new Exception($rst['errmsg'], $rst['errcode']);
        } else {
            return $rst;
        }
    }

    /**
     * 8、设置授权方的选项信息
     * 该API用于设置授权方的公众号的选项信息，如：地理位置上报，语音识别开关，多客服开关。注意，设置各项选项设置信息，需要有授权方的授权，详见权限集说明。
     * 接口调用请求说明
     * http请求方式: POST（请使用https协议）https://api.weixin.qq.com/cgi-bin/component/ api_set_authorizer_option?component_access_token=xxxx
     * POST数据示例
     * {
     * "component_appid":"appid_value",
     * "authorizer_appid": " auth_appid_value ",
     * "option_name": "option_name_value",
     * "option_value":"option_value_value"
     * }
     *
     * 请求参数说明
     * 参数 说明
     * component_appid 第三方平台appid
     * authorizer_appid 授权公众号appid
     * option_name 选项名称
     * option_value 设置的选项值
     * 返回结果示例
     * {
     * "errcode":0,
     * "errmsg":"ok"
     * }
     *
     * 结果参数说明
     * 参数 说明
     * errcode 错误码
     * errmsg 错误信息
     * 选项名和选项值表
     * option_name option_value 选项值说明
     * location_report(地理位置上报选项) 0 无上报
     * 1 进入会话时上报
     * 2 每5s上报
     * voice_recognize（语音识别开关选项） 0 关闭语音识别
     * 1 开启语音识别
     * customer_service（多客服开关选项） 0 关闭多客服
     * 1 开启多客服
     *
     * @throws Exception
     * @return unknown
     */
    public function apiSetAuthorizerOption($authorizer_appid, $option_name, $option_value)
    {
        $params = array(
            'component_appid' => $this->_appid,
            'authorizer_appid' => $authorizer_appid,
            'option_name' => $option_name,
            'option_value' => $option_value
        );
        $rst = $this->_request->post($this->_url . 'api_set_authorizer_option?component_access_token=' . $this->getAccessToken(), $params);
        if (! empty($rst['errcode'])) {
            // 如果有异常，会在errcode 和errmsg 描述出来。
            throw new Exception($rst['errmsg'], $rst['errcode']);
        } else {
            return $rst;
        }
    }

    /**
     * 获取授权页的URL
     */
    public function getComponentLoginPage($pre_auth_code, $redirect_uri, $is_redirect = true)
    {
        $redirect_uri = trim($redirect_uri);
        if (filter_var($redirect_uri, FILTER_VALIDATE_URL) === false) {
            throw new Exception('$redirect_uri无效');
        }
        $redirect_uri = urlencode($redirect_uri);
        $url = "https://mp.weixin.qq.com/cgi-bin/componentloginpage?component_appid={$this->_appid}&pre_auth_code={$pre_auth_code}&redirect_uri={$redirect_uri}";
        if (! empty($is_redirect)) {
            header("location:{$url}");
            exit();
        } else {
            return $url;
        }
    }

    public function __destruct()
    {}
}