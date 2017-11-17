<?php
namespace Weixin\Wx\Manager;

use Weixin\Client;

/**
 * 小程序卡券
 *
 * @author guoyongrong <handsomegyr@gmail.com>
 * @author young <youngyang@icatholic.net.cn>
 */
class Card
{

    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 14.业务接口-门店小程序卡券
     * 第一步获取门店小程序配置的卡券：
     *
     * URL
     *
     * https://api.weixin.qq.com/card/storewxa/get?access_token=ACCESS_TOKEN
     *
     * 请求参数示例
     *
     * {
     *
     * "poi_id" : 1234567
     *
     * }
     *
     * 返回参数示例
     *
     * {
     *
     * "errcode" : 0,
     *
     * "errmsg" : "ok",
     *
     * "card_id" : "pabcedfg1234567hijklmn"
     *
     * }
     *
     * 说明：
     *
     * poi_id为门店id；
     *
     * card_id为微信卡券id；
     *
     * poi_id需要属于调用api的公众号的门店小程序；
     *
     * 若该poi_id没设置门店，则返回中无card_id字段。
     */
    public function get4store($poi_id)
    {
        $params = array();
        $params['poi_id'] = $poi_id;
        $rst = $this->_request->post2('card/storewxa/get', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 第二步设置门店小程序配置的卡券
     *
     * URL
     *
     * https://api.weixin.qq.com/card/storewxa/set?access_token=ACCESS_TOKEN
     *
     * 请求参数示例
     *
     * {
     *
     * "poi_id" : 1234567
     *
     * "card_id" : "pabcedfg1234567hijklmn"
     *
     * }
     *
     * 返回参数示例
     *
     * {
     *
     * "errcode" : 0,
     *
     * "errmsg" : "ok"
     *
     * }
     *
     * 说明
     *
     * poi_id为门店id；
     *
     * card_id为微信卡券id；
     *
     * poi_id需要属于调用api的公众号的门店小程序；
     *
     * card_id需要为非自定义code，即base_info.use_custom_code==fase；
     *
     * 附：门店开发中遇到问题可以加入QQ群463320265 交流。
     */
    public function set4store($poi_id, $card_id)
    {
        $params = array();
        $params['poi_id'] = $poi_id;
        $params['card_id'] = $card_id;
        $rst = $this->_request->post2('card/storewxa/set', $params);
        return $this->_client->rst($rst);
    }
}
