<?php
/**
 * 获取微信服务端使用的accessToken
 * @author young
 *
 */
namespace Weixin\Token;

class Server
{

    private $_appid = null;

    private $_secret = null;

    public function __construct ($appid, $secret)
    {
        $this->_appid = $appid;
        $this->_secret = $secret;
    }

    public function getAccessToken ()
    {
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->_appid}&secret={$this->_secret}";
        return json_decode(file_get_contents($url), true);
    }

    public function __destruct ()
    {}
}