<?php
namespace Weixin\Manager;

use Weixin\Client;

/**
 * 获取微信服务器IP地址接口
 * 如果公众号基于安全等考虑，需要获知微信服务器的IP地址列表，以便进行相关限制，可以通过该接口获得微信服务器IP地址列表。
 *
 * @author guoyongrong <handsomegyr@gmail.com>
 * @author young <youngyang@icatholic.net.cn>
 */
class Ip
{

    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 获取微信服务器IP地址接口
     * 如果公众号基于安全等考虑，需要获知微信服务器的IP地址列表，以便进行相关限制，可以通过该接口获得微信服务器IP地址列表。
     *
     * 接口调用请求说明
     *
     * http请求方式: GET
     * https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=ACCESS_TOKEN
     * 参数说明
     *
     * 参数	是否必须	说明
     * access_token 是 公众号的access_token
     * 返回说明
     *
     * 正常情况下，微信会返回下述JSON数据包给公众号：
     *
     * {
     * "ip_list":["127.0.0.1","127.0.0.1"]
     * }
     * 参数	说明
     * ip_list 微信服务器IP地址列表
     * 错误时微信会返回错误码等信息，JSON数据包示例如下（该示例为AppID无效错误）:
     *
     * {"errcode":40013,"errmsg":"invalid appid"}
     *
     * @return mixed
     */
    public function getcallbackip()
    {
        $rst = $this->_request->get('getcallbackip');
        return $this->_client->rst($rst);
    }
}
