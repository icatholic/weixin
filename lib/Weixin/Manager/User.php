<?php
namespace Weixin\Manager;

use Weixin\Client;
use Weixin\Http\Request;

/**
 * 用户管理-----获取用户基本信息接口
 * 在关注者与公众号产生消息交互后，
 * 公众号可获得关注者的OpenID（
 * 加密后的微信号，每个用户对每个公众号的OpenID是唯一的。
 * 对于不同公众号，同一用户的openid不同）。
 * 公众号可通过本接口来根据OpenID获取用户基本信息，
 * 包括昵称、头像、性别、所在城市、语言和关注时间。
 *
 * @author guoyongrong <handsomegyr@gmail.com>
 * @author young <youngyang@icatholic.net.cn>
 */
class User
{

    /**
     * 微信客户端
     *
     * @var Client
     */
    private $_client;

    /**
     * 请求对象
     *
     * @var Request
     */
    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 获取用户基本信息
     * 开发者可通过OpenID来获取用户基本信息。请使用https协议。
     */
    public function getUserInfo($openid, $lang = "zh_CN")
    {
        // http请求方式: GET
        // https://api.weixin.qq.com/cgi-bin/user/info?access_token=ACCESS_TOKEN&openid=OPENID&lang=zh_CN
        // access_token 是 调用接口凭证
        // openid 是 普通用户的标识，对当前公众号唯一
        // lang 否 返回国家地区语言版本，zh_CN 简体，zh_TW 繁体，en 英语
        $params = array();
        $params['openid'] = $openid;
        $params['lang'] = $lang;
        $rst = $this->_request->get('user/info', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取关注者列表
     * 公众号可通过本接口来获取帐号的关注者列表，
     * 关注者列表由一串OpenID（加密后的微信号，每个用户对每个公众号的OpenID是唯一的）组成。
     * 一次拉取调用最多拉取10000个关注者的OpenID，
     * 可以通过多次拉取的方式来满足需求。
     */
    public function getUser($next_openid = "")
    {
        // http请求方式: GET（请使用https协议）
        // https://api.weixin.qq.com/cgi-bin/user/get?access_token=ACCESS_TOKEN&next_openid=NEXT_OPENID
        // access_token 是 调用接口凭证
        // next_openid 是 第一个拉取的OPENID，不填默认从头开始拉取
        $params = array();
        $params['next_openid'] = $next_openid;
        $rst = $this->_request->get('user/get', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 设置备注名
     * 开发者可以通过该接口对指定用户设置备注名，该接口暂时开放给微信认证的服务号
     */
    public function updateRemark($openid, $remark)
    {
        /**
         * https://api.weixin.qq.com/cgi-bin/user/info/updateremark?access_token=ACCESS_TOKEN
         * POST数据格式：JSON
         * POST数据例子：
         * {
         * "openid":"oDF3iY9ffA-hqb2vVvbr7qxf6A0Q",
         * "remark":"pangzi"
         * }
         */
        $params = array();
        $params['openid'] = $openid;
        $params['remark'] = $remark; // 新的备注名，长度必须小于30字符
        $rst = $this->_request->post('user/info/updateremark', $params);
        return $this->_client->rst($rst);
    }
    
    /**
     * 批量获取用户信息
     */
    public function getUserInfoBatchget(array $userList){
        $params = array();
        $params['user_list'] = $userList;
        $rst = $this->_request->post('user/info/batchget', $params);
        return $this->_client->rst($rst);
    }
    
}
