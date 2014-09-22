<?php
namespace Weixin\Manager;

use Weixin\Client;

/**
 * 长链接转短链接接口
 *
 * 将一条长链接转成短链接。
 *
 * 主要使用场景：
 * 开发者用于生成二维码的原链接（商品、支付二维码等）太长导致扫码速度和成功率下降，
 * 将原长链接通过此接口转成短链接再生成二维码将大大提升扫码速度和成功率。
 *
 * @author guoyongrong <handsomegyr@gmail.com>
 * @author young <youngyang@icatholic.net.cn>
 */
class ShortUrl
{

    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 将一条长链接转成短链接
     */
    public function long2short($long_url)
    {
        /**
         * 接口调用请求说明
         *
         * http请求方式: POST
         * https://api.weixin.qq.com/cgi-bin/shorturl?access_token=ACCESS_TOKEN
         * 参数说明
         *
         * 参数	是否必须	说明
         * access_token 是 调用接口凭证
         * action 是 此处填long2short，代表长链接转短链接
         * long_url 是 需要转换的长链接，支持http://、https://、weixin://wxpay 格式的url
         */
        $params = array();
        $params['action'] = "long2short";
        $params['long_url'] = $long_url;
        $rst = $this->_request->post('shorturl', $params);
        return $this->_client->rst($rst);
    }
}
