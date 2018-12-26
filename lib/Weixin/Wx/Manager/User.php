<?php
namespace Weixin\Wx\Manager;

use Weixin\Client;

/**
 * 用户支付完成后，获取该用户的 UnionId
 * https://developers.weixin.qq.com/miniprogram/dev/api/getPaidUnionId.html
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

    /**
     * getPaidUnionId
     * 本接口应在后端服务器调用
     *
     * 用户支付完成后，获取该用户的 UnionId，无需用户授权。本接口支持第三方平台代理查询。
     *
     * 注意：调用前需要用户完成支付，且在支付后的五分钟内有效。
     * 请求地址
     * GET https://api.weixin.qq.com/wxa/getpaidunionid?access_token=ACCESS_TOKEN&openid=OPENID
     * 请求参数
     * 属性 类型 默认值 必填 说明 最低版本
     * access_token string 是 接口调用凭证
     * openid string 是 支付用户唯一标识
     * transaction_id string 否 微信支付订单号
     * mch_id string 否 微信支付分配的商户号，和商户订单号配合使用
     * out_trade_no string 否 微信支付商户订单号，和商户号配合使用
     * 返回值
     * Object
     * 返回的 JSON 数据包
     *
     * 属性 类型 说明 最低版本
     * unionid string 用户唯一标识，调用成功后返回
     * errcode number 错误码
     * errmsg string 错误信息
     * errcode 的合法值
     *
     * 值 说明
     * -1 系统繁忙，此时请开发者稍候再试
     * 0 请求成功
     * 40003 openid 错误
     * 89002 没有绑定开放平台帐号
     * 89300 订单无效
     * 使用说明
     * 以下两种方式任选其一。
     *
     * 微信支付订单号（transaction_id）：
     * https://api.weixin.qq.com/wxa/getpaidunionid?access_token=ACCESS_TOKEN&openid=OPENID&transaction_id=TRANSACTION_ID
     * 微信支付商户订单号和微信支付商户号（out_trade_no 及 mch_id）：
     * https://api.weixin.qq.com/wxa/getpaidunionid?access_token=ACCESS_TOKEN&openid=OPENID&mch_id=MCH_ID&out_trade_no=OUT_TRADE_NO
     * 返回数据示例
     * {
     * "unionid": "oTmHYjg-tElZ68xxxxxxxxhy1Rgk",
     * "errcode": 0,
     * "errmsg": "ok"
     * }
     */
    public function getPaidUnionId($openid, $transaction_id, $mch_id = "", $out_trade_no = "")
    {
        $params = array();
        $params['openid'] = $openid;
        if (! empty($transaction_id)) {
            $params['transaction_id'] = $transaction_id;
        } else {
            $params['mch_id'] = $mch_id;
            $params['out_trade_no'] = $out_trade_no;
        }
        $rst = $this->_request->get2('wxa/getpaidunionid', $params);
        return $this->_client->rst($rst);
    }
}
