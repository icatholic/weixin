<?php
namespace Weixin;

use Weixin\Helpers;
use Weixin\Exception;
use Weixin\Http\Request;
use Guzzle\Http\Client;

/**
 * 微信支付接口
 *
 * @author guoyongrong <handsomegyr@gmail.com>
 */
class Pay337
{

    private $_url = 'https://api.mch.weixin.qq.com/';

    /**
     * 获取微信支付版本
     *
     * @return string
     */
    public function getVersion()
    {
        return '3.3.7';
    }

    /**
     * appId
     * 微信公众号身份的唯一标识。
     *
     * @var string
     */
    private $appId = "";

    public function setAppId($appId)
    {
        $this->appId = $appId;
    }

    public function getAppId()
    {
        if (empty($this->appId)) {
            throw new Exception('AppId未设定');
        }
        return $this->appId;
    }

    /**
     * appSecret
     * 微信公众号秘钥。
     *
     * @var string
     */
    private $appSecret = "";

    public function setAppSecret($appSecret)
    {
        $this->appSecret = $appSecret;
    }

    public function getAppSecret()
    {
        if (empty($this->appSecret)) {
            throw new Exception('AppSecret未设定');
        }
        return $this->appSecret;
    }

    /**
     * access_token微信公众平台凭证。
     */
    private $accessToken = "";

    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    public function getAccessToken()
    {
        if (empty($this->accessToken)) {
            throw new Exception('access token未设定');
        }
        return $this->accessToken;
    }

    /**
     * Mchid 商户 ID ，身份标识
     */
    private $mchid = "";

    public function setMchid($mchid)
    {
        $this->mchid = $mchid;
    }

    public function getMchid()
    {
        if (empty($this->mchid)) {
            throw new Exception('Mchid未设定');
        }
        return $this->mchid;
    }

    /**
     * 子商户号 sub_mch_id
     */
    private $sub_mch_id = "";

    public function setSubMchId($sub_mch_id)
    {
        $this->sub_mch_id = $sub_mch_id;
    }

    public function getSubMchId()
    {
        // if (empty($this->sub_mch_id)) {
        // throw new Exception('Mchid未设定');
        // }
        return $this->sub_mch_id;
    }

    /**
     * Key 商户支付密钥。登录微信商户后台，进入栏目【账设置】【密码安全】【 API密钥】，进入设置 API密钥。
     */
    private $key = "";

    public function setKey($key)
    {
        $this->key = $key;
    }

    public function getKey()
    {
        if (empty($this->key)) {
            throw new Exception('Key未设定');
        }
        return $this->key;
    }

    /**
     * cert 商户证书。
     *
     * @var string
     */
    private $cert = "";

    public function setCert($cert)
    {
        $this->cert = $cert;
    }

    public function getCert()
    {
        if (empty($this->cert)) {
            throw new Exception('商户证书未设定');
        }
        return $this->cert;
    }

    /**
     * certKey 商户证书秘钥。
     *
     * @var string
     */
    private $certKey = "";

    public function setCertKey($certKey)
    {
        $this->certKey = $certKey;
    }

    public function getCertKey()
    {
        if (empty($this->certKey)) {
            throw new Exception('商户证书秘钥未设定');
        }
        return $this->certKey;
    }

    public function __construct()
    {}

    /**
     * 统一支付接口
     * URL地址:https://api.mch.weixin.qq.com/pay/unifiedorder
     *
     * 请求参数： 请求参数： 字段名 变量名 必填 类型 说明
     * 公众账号ID appid 是 String(32) 微信分配的公众账号ID
     * 商户号 mch_id 是 String(32)微信支付分配的商户号
     * 设备号device_info否String(32)微信支付分配的终端设备号
     * 随机字符串nonce_str是String(32)随机字符串，不长于32位
     * 签名sign是String(32)签名,详细签名方法见3.2节
     * 商品描述body是String(127)商品描述
     * 附加数据attach否String(127)附加数据，原样返回
     * 商户订单号out_trade_no是String(32)商户系统内部的订单号,32个字符内、可包含字母,确保在商户系统唯一,详细说明微信公众号支付接口文档见7.3节第四项
     * 总金额total_fee是Int订单总金额，单位为分，不能带小数点
     * 终端IP spbill_create_ip是String(16)订单生成的机器IP
     * 交易起始时间time_start否String(14)订单生成时间，格式为yyyyMMddHHmmss，如2009年12月25日9点10分10秒表示为20091225091010。时区为GMT+8
     * beijing。该时间取自商户服务器
     * 交易结束时间time_expire否String(14)订单失效时间，格式为yyyyMMddHHmmss，如2009年12月27日9点10分10秒表示为20091227091010。时区为GMT+8
     * beijing。该时间取自商户服务器
     * 商品标记goods_tag否String(32)商品标记，该字段不能随便填，不使用请填空，使用说明详见第5节
     * 通知地址notify_url是String(256)接收微信支付成功通知
     * 交易类型trade_type是String(16)JSAPI、NATIVE、APP
     * 用户标识openid否String(128)用户在商户appid下的唯一标识，trade_type为JSAPI时，此参数必传，获取方式见表头说明。
     * 商品IDproduct_id否String(32)只在trade_type为NATIVE时需要填写。此id为二维码中包含的商品ID，商户自行维护。
     *
     * 返回参数： 返回参数： 字段名 变量名 必填 类型 说明
     * 返回状态码return_code是String(16)SUCCESS/FAIL此字段是通信标识，非交易标识，交易是否成功需要查看result_code来判断
     * 返回信息return_msg否String(128)返回信息，如非空，为错误原因签名失败 参数格式校验错误
     * 以下字段在return_code为SUCCESS的时候有返回
     * 公众账号ID appid是String(32)微信分配的公众账号ID
     * 商户号mch_id是String(32)微信支付分配的商户号微信公众号支付接口文档
     * 设备号device_info否String(32)微信支付分配的终端设备号，
     * 随机字符串nonce_str是String(32)随机字符串，不长于32位
     * 签名sign是String(32)签名,详细签名方法见3.2节
     *
     * 业务结果result_code是String(16)SUCCESS/FAIL
     * 错误代码err_code否String(32)列表第6节
     * 错误代码描述err_code_des否String(128)结果信息描述
     *
     * 以下字段在return_code 和result_code都为SUCCESS的时候有返回
     * 交易类型trade_type是String(16)JSAPI、NATIVE、APP
     * 预支付IDprepay_id是String(64)微信生成的预支付ID，用于后续接口调用中使用
     * 二维码链接code_url否String(64)trade_type为NATIVE是有返回，此参数可直接生成二维码展示出来进行扫码支付
     */
    public function unifiedorder($device_info, $nonce_str, $body, $attach, $out_trade_no, $total_fee, $spbill_create_ip, $time_start, $time_expire, $goods_tag, $notify_url, $trade_type, $openid, $product_id)
    {
        $postData = array();
        $postData["appid"] = $this->getAppId();
        $postData["mch_id"] = $this->getMchid();
        $postData["device_info"] = $device_info;
        $postData["nonce_str"] = $nonce_str;
        $postData["body"] = $body;
        $postData["attach"] = $attach;
        $postData["out_trade_no"] = $out_trade_no;
        $postData["total_fee"] = $total_fee;
        $postData["spbill_create_ip"] = $spbill_create_ip;
        $postData["time_start"] = $time_start;
        $postData["time_expire"] = $time_expire;
        $postData["goods_tag"] = $goods_tag;
        $postData["notify_url"] = $notify_url;
        $postData["trade_type"] = $trade_type;
        $postData["openid"] = $openid;
        $postData["product_id"] = $product_id;
        
        $sign = $this->getSign($postData);
        $postData["sign"] = $sign;
        $xml = Helpers::arrayToXml($postData);
        $rst = $this->post($this->_url . 'pay/unifiedorder', $xml);
        return $this->returnResult($rst);
    }

    /**
     * 订单查询接口
     * 接口链：https://api.mch.weixin.qq.com/pay/orderquery
     * 该接口提供所有微信支付订单的查询，当支付通知处理异常或丢失情况
     * 商户可以通过该接口查询订单支付状态
     *
     * 请求参数： 请求参数： 字段名 变量名 必填 类型 说明
     * 公众账号ID appid是String(32)微信分配的公众账号ID
     * 商户号mch_id是String(32)微信支付分配的商户号
     * 微信订单号transaction_id否String(32)微信的订单号，优先使用
     * 商户订单号out_trade_no是String(32)商户系统内部的订单号,transaction_id、out_trade_no二选一，如果同时存在优先级：transaction_id>
     * out_trade_no
     * 随机字符串nonce_str是String(32)随机字符串，不长于32位
     * 签名sign是String(32)签名,详细签名方法见3.2节
     * 同步返回结果：
     * 字段名 变量名 必填 类型 说明
     * 返回状态码return_code是String(16)SUCCESS/FAIL此字段是通信标识，非交易标识，交易是否成功需要查看trade_state来判断
     * 返回信息return_msg否String(128)返回信息，如非空，为错误原因签名失败参数格式校验错误
     * 以下字段在return_code为SUCCESS的时候有返回
     * 公众账号ID appid是String(32)微信分配的公众账号ID
     * 商户号mch_id是String(32)微信支付分配的商户号微信公众号支付接口文档
     * 随机字符串nonce_str是String(32)随机字符串，不长于32位
     * 签名sign是String(32)签名,详细签名方法见3.2节
     * 业务结果result_code是String(16)SUCCESS/FAIL
     * 错误代码err_code否String(32)错误码见第6节
     * 错误代码描述err_code_des否String(128)结果信息描述
     * 以下字段在return_code 和result_code都为SUCCESS的时候有返回
     * 交易状态
     * trade_state是String(32)SUCCESS—支付成功REFUND—转入退款NOTPAY—未支付CLOSED—已关闭REVOKED—已撤销USERPAYING--用户支付中NOPAY--未支付(输入密码或确认支付超时)
     * PAYERROR--支付失败(其他原因，如银行返回失败) 以下字段在return_code 和result_code都为SUCCESS的时候有返回
     * 设备号device_info否String(32)微信支付分配的终端设备号，
     * 用户标识openid是String(128)用户在商户appid下的唯一标识
     * 是否关注公众账号is_subscribe是String(1)用户是否关注公众账号，Y-关注，N-未关注，仅在公众账号类型支付有效
     * 交易类型trade_type是String(16)JSAPI、NATIVE、MICROPAY、APP
     * 付款银行bank_type是String(16)银行类型，采用字符串类型的银行标识
     * 总金额total_fee是Int订单总金额，单位为分
     * 现金券金额coupon_fee否Int现金券支付金额<=订单总金额，订单总金额-现金券金额为现金支付金额
     * 货币种类fee_type否String(8)货币类型，符合ISO 4217标准的三位字母代码，默认人民币：CNY
     * 微信支付订单号transaction_id否String(32)微信支付订单号
     * 商户订单号out_trade_no否String(32)商户系统的订单号，与请求一致。
     * 商家数据包attach否String(128)商家数据包，原样返回
     * 支付完成时间time_end是String(14)支付完成时间，格式为yyyyMMddhhmmss，如2009年12月27日9点10分10秒表示为20091227091010。时区微信公众号支付接口文档为GMT+8
     * beijing。该时间取自微信支付服务器
     */
    public function orderquery($transaction_id, $out_trade_no, $nonce_str)
    {
        $postData = array();
        $postData["appid"] = $this->getAppId();
        $postData["mch_id"] = $this->getMchid();
        $postData["transaction_id"] = $transaction_id;
        $postData["out_trade_no"] = $out_trade_no;
        $postData["nonce_str"] = $nonce_str;
        $postData["sign"] = $this->getSign($postData);
        $xml = Helpers::arrayToXml($postData);
        $rst = $this->post($this->_url . 'pay/orderquery', $xml);
        return $this->returnResult($rst);
    }

    public function closeorder($out_trade_no, $nonce_str)
    {
        $postData = array();
        $postData["appid"] = $this->getAppId();
        $postData["mch_id"] = $this->getMchid();
        $postData["out_trade_no"] = $out_trade_no;
        $postData["nonce_str"] = $nonce_str;
        $sign = $this->getSign($postData);
        $postData["sign"] = $sign;
        $xml = Helpers::arrayToXml($postData);
        $rst = $this->post($this->_url . 'pay/closeorder', $xml);
        return $this->returnResult($rst);
    }

    /**
     * 现金红包 API接口
     * 发放现金红包
     * 接口说明
     * 用于企业向微信用户个人収现金红包
     * 目前支持向指定微信用户的 openid 収放固定金额红包。
     *
     * 接口调用请求说明
     * 请求 Url https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack
     * 是否需要证书 是（证书及使用说明见 3.2.3 商户证书）
     * 请求方式 POST
     *
     * 请求参数
     * 字段名 字段 必填 示例值 类型 说明
     * 随机字符串nonce_str 是 5K8264ILTKCH16CQ2502SI8ZNMTM67VSString(32)随机字符串， 32位
     * 签名 sign 是 C380BEC2BFD727A4B6845133519F3AD6String(32)生成签名方式查看 3.2.1 节
     * 商户订单号mch_billno 是 10000098201411111234567890String(28)商户订单号（每个订单号必须唯一）组成： mch_id+yyyymmdd+10 位一天内不能重复的数字。接口根据商户订单号支持重入， 如出现超 时可再调用。
     * 商户号 mch_id 是 10000098 String(32)微信支付分配的商户号
     * 子商户号 sub_mch_id 否 10000090 String(32)微信支付分配的子商户号，受理模式下必填
     * 公众账号appid wxappid 是 wx888888888 8888888String(32)商户 appid
     * 提供方名称nick_name 是 天虹百货 String(32)提供方名称
     * 商户名称 send_name 是 天虹百货 String(32)红包収送者名称
     * 用户openid re_openid 是 oxTWIuGaIt6gTKsQRLau2M0yL16EString(32) 接收红包的用户用户在wxappid下的openid
     * 付款金额 total_amount是 1000 int付款金额，单位分
     * 最小红包 min_value 是 1000 int 最小红包金额，单位分金额
     * 最大红包金额 max_value是 1000 int 最大红包金额，单位分（ 最 小 金 额 等 于 最 大 金 额 ：min_value=max_value =total_amount）
     * 红包収放总人数total_num是 1 int 红包収放总人数total_num=1
     * 红包祝福 wishing是 感谢您参加猜灯谜活劢，祝您元宵节快乐！String(128) 红包祝福诧
     * Ip 地址 client_ip 是 192.168.0.1 String(15)调用接口的机器 Ip 地址
     * 活动名称 act_name是 猜灯谜抢红包活动String(32)活动名称
     * 备注 remark 是 猜越多得越多，快来抢！String(256) 备注信息
     * 商户logo 的url logo_imgurl 否 https://wx.gtimg.com/mch/img/ico-logo.pngString(128)商户logo的url
     * 分享文案share_content否 快来参加猜灯谜活动 String(256)分享文案
     * 分享链接 share_url 否 http://www.qq.com String(128)分享链接
     * 分享的图片share_imgurl否 https://wx.gtimg.com/mch/img/ico-logo.pngString(128)分享的图片url
     * 数据示例：
     * <xml>
     * <sign>![CDATA[E1EE61A91C8E90F299DE6AE075D60A2D]]</sign>
     * <mch_billno>![CDATA[0010010404201411170000046545]]</mch_billno>
     * <mch_id>![CDATA[888]]</mch_id>
     * <wxappid>![CDATA[wxcbda96de0b165486]]</wxappid>
     * <nick_name>![CDATA[nick_name]]</nick_name>
     * <send_name>![CDATA[send_name]]</send_name>
     * <re_openid>![CDATA[onqOjjmM1tad-3ROpncN-yUfa6uI]]</re_openid>
     * <total_amount>![CDATA[200]]</total_amount>
     * <min_value>![CDATA[200]]</min_value>
     * <max_value>![CDATA[200]]</max_value>
     * <total_num>![CDATA[1]]</total_num>
     * <wishing>![CDATA[恭喜发财]]</wishing>
     * <client_ip>![CDATA[127.0.0.1]]</client_ip>
     * <act_name>![CDATA[新年红包]]</act_name>
     * <act_id>![CDATA[act_id]]</act_id>
     * <remark>![CDATA[新年红包]]</remark>
     * <logo_imgurl>![CDATA[https://xx/img/wxpaylogo.png]]</logo_imgurl>
     * <share_content>![CDATA[share_content]]</share_content>
     * <share_url>![CDATA[https://xx/img/wxpaylogo.png]]</share_url>
     * <share_imgurl>![CDATA[https:/xx/img/wxpaylogo.png]]</share_imgurl>
     * <nonce_str>![CDATA[50780e0cca98c8c8e814883e5caa672e]]</nonce_str>
     * </xml>
     * 返回参数
     * 字段名 变量名 必填示例值 类型 说明
     * 返回状态码return_code 是 SUCCESS String(16)SUCCESS/FAIL此字段是通信标识，非交易标识，交易是否成功需要查看 result_code 来判断
     * 返回信息 return_msg 否 签名失败 String(128)返回信息，如非空，为错误原因 签名失败 参数格式校验错误
     * 以下字段在 return_code 为 SUCCESS 的时候有返回
     * 签名 sign 是 C380BEC2BFD727A4B6845133519F3AD6String(32)生成签名方式查看 2.1 节
     * 业务结果 result_code 是 SUCCESS String(16)SUCCESS/FAIL
     * 错误代码 err_code 否 SYSTEMERRORString(32)错误码信息
     * 错误代码描述err_code_des否 系统错误 String(128)结果信息描述
     * 以下字段在 return_code 和 result_code 都为 SUCCESS 的时候有返回
     * 商户订单号mch_billno 是 10000098201411111234567890String(28)
     * 商户订单号（每个订单号必须唯一）组成： mch_id+yyyymmdd+10 位一天内不能重复的数字
     * 商户号 mch_id 是 10000098 String(32)微信支付分配的商户号
     * 公众账号appidwxappid 是 wx8888888888888888 String(32) 商户 appid
     * 用户 openid re_openid 是 oxTWIuGaIt6gTKsQRLau2M0yL16E String(32) 接收红包的用户 用户在 wxappid 下的 openid
     * 付款金额 total_amount 是 1000 int 付款金额，单位分
     * 发放成功时间
     * 微信单号
     * 成功示例：
     * <xml>
     * <return_code><![CDATA[SUCCESS]]></return_code>
     * <return_msg><![CDATA[发放成功.]]></return_msg>
     * <result_code><![CDATA[SUCCESS]]></result_code>
     * <err_code><![CDATA[0]]></err_code>
     * <err_code_des><![CDATA[发放成功.]]></err_code_des>
     * <mch_billno><![CDATA[0010010404201411170000046545]]></mch_billno>
     * <mch_id>10010404</mch_id>
     * <wxappid><![CDATA[wx6fa7e3bab7e15415]]></wxappid>
     * <re_openid><![CDATA[onqOjjmM1tad-3ROpncN-yUfa6uI]]></re_openid>
     * <total_amount>1</total_amount>
     * </xml>
     * 失败示例：
     * <xml>
     * <return_code><![CDATA[FAIL]]></return_code>
     * <return_msg><![CDATA[系统繁忙,请稍后再试.]]></return_msg>
     * <result_code><![CDATA[FAIL]]></result_code>
     * <err_code><![CDATA[268458547]]></err_code>
     * <err_code_des><![CDATA[系统繁忙,请稍后再试.]]></err_code_des>
     * <mch_billno><![CDATA[0010010404201411170000046542]]></mch_billno>
     * <mch_id>10010404</mch_id>
     * <wxappid><![CDATA[wx6fa7e3bab7e15415]]></wxappid>
     * <re_openid><![CDATA[onqOjjmM1tad-3ROpncN-yUfa6uI]]></re_openid>
     * <total_amount>1</total_amount>
     * </xml>
     */
    public function sendredpack($nonce_str, $mch_billno, $nick_name, $send_name, $re_openid, $total_amount, $min_value, $max_value, $total_num, $wishing, $client_ip, $act_id, $act_name, $remark, $logo_imgurl, $share_content, $share_url, $share_imgurl)
    {
        $postData = array();
        $postData["nonce_str"] = $nonce_str;
        $postData["mch_billno"] = $mch_billno;
        $postData["mch_id"] = $this->getMchid();
        // $postData["sub_mch_id"] = $this->getSubMchId();
        $postData["wxappid"] = $this->getAppId();
        // $postData["nick_name"] = $nick_name;
        $postData["send_name"] = $send_name;
        $postData["re_openid"] = $re_openid;
        $postData["total_amount"] = $total_amount;
        // $postData["min_value"] = $min_value;
        // $postData["max_value"] = $max_value;
        $postData["total_num"] = $total_num;
        $postData["wishing"] = $wishing;
        $postData["client_ip"] = $client_ip;
        // $postData["act_id"] = $act_id;
        $postData["act_name"] = $act_name;
        $postData["remark"] = $remark;
        // $postData["logo_imgurl"] = $logo_imgurl;
        // $postData["share_content"] = $share_content;
        // $postData["share_url"] = $share_url;
        // $postData["share_imgurl"] = $share_imgurl;
        
        $sign = $this->getSign($postData);
        $postData["sign"] = $sign;
        $xml = Helpers::arrayToXml($postData);
        $options = array();
        $options['cert'] = $this->getCert();
        $options['ssl_key'] = $this->getCertKey();
        $rst = $this->post($this->_url . 'mmpaymkttransfers/sendredpack', $xml, $options);
        return $this->returnResult($rst);
    }

    /**
     * 使用说明
     * 用于商户对已发放的红包进行查询红包的具体信息，可支持普通红包和裂变包。
     * 接口调用请求说明
     * 请求Url https://api.mch.weixin.qq.com/mmpaymkttransfers/gethbinfo
     * 是否需要证书 是（证书及使用说明详见商户证书）
     * 请求方式 POST
     * 请求参数
     * 字段名 字段 必填 示例值 类型 说明
     * 随机字符串 nonce_str 是 5K8264ILTKCH16CQ2502SI8ZNMTM67VS String(32) 随机字符串，不长于32位
     * 签名 sign 是 C380BEC2BFD727A4B6845133519F3AD6 String(32) 详见签名生成算法
     * 商户订单号 mch_billno 是 10000098201411111234567890 String(28) 商户发放红包的商户订单号
     * 商户号 mch_id 是 10000098 String(32) 微信支付分配的商户号
     * Appid appid 是 wxe062425f740d30d8 String(32) 微信分配的公众账号ID（企业号corpid即为此appId），接口传入的所有appid应该为公众号的appid（在mp.weixin.qq.com申请的），不能为APP的appid（在open.weixin.qq.com申请的）。
     * 订单类型 bill_type 是 MCHT String(32) MCHT:通过商户订单号获取红包信息。
     * 数据示例：
     *
     * <xml>
     * <sign><![CDATA[E1EE61A91C8E90F299DE6AE075D60A2D]]></sign>
     * <mch_billno><![CDATA[0010010404201411170000046545]]></mch_billno>
     * <mch_id><![CDATA[10000097]]></mch_id>
     * <appid><![CDATA[wxe062425f740c30d8]]></appid>
     * <bill_type><![CDATA[MCHT]]></ bill_type>
     * <nonce_str><![CDATA[50780e0cca98c8c8e814883e5caa672e]]></nonce_str>
     * </xml>
     * 返回参数
     * 字段名 变量名 必填 示例值 类型 说明
     * 返回状态码 return_code 是 SUCCESS String(16) SUCCESS/FAIL
     * 此字段是通信标识，非交易标识，交易是否成功需要查看result_code来判断
     * 返回信息 return_msg 否 签名失败 String(128) 返回信息，如非空，为错误原因
     * 签名失败
     * 参数格式校验错误
     * 以下字段在return_code为SUCCESS的时候有返回
     * 字段名 变量名 必填 示例值 类型 说明
     * 签名 sign 是 C380BEC2BFD727A4B6845133519F3AD6 String(32) 详见签名生成算法
     * 业务结果 result_code 是 SUCCESS String(16) SUCCESS/FAIL
     * 错误代码 err_code 否 SYSTEMERROR String(32) 错误码信息
     * 错误代码描述 err_code_des 否 系统错误 String(128) 结果信息描述
     * 以下字段在return_code 和result_code都为SUCCESS的时候有返回
     *
     * 字段名 变量名 必填 示例值 类型 描述
     * 商户订单号 mch_billno 是 10000098201411111234567890 String(28) 商户使用查询API填写的商户单号的原路返回
     * 商户号 mch_id 是 10000098 String(32) 微信支付分配的商户号
     * 红包单号 detail_id 是 1000000000201503283103439304 String(32) 使用API发放现金红包时返回的红包单号
     * 红包状态 status 是 RECEIVED string(16) SENDING:发放中
     * SENT:已发放待领取
     * FAILED：发放失败
     * RECEIVED:已领取
     * REFUND:已退款
     * 发放类型 send_type 是 API String(32) API:通过API接口发放
     * UPLOAD:通过上传文件方式发放
     * ACTIVITY:通过活动方式发放
     * 红包类型 hb_type 是 GROUP String(32) GROUP:裂变红包
     * NORMAL:普通红包
     * 红包个数 total_num 是 1 int 红包个数
     * 红包金额 total_amount 是 5000 int 红包总金额（单位分）
     * 失败原因 reason 否 余额不足 String(32) 发送失败原因
     * 红包发送时间 send_time 是 2015-04-21 20:00:00 String(32)
     * 红包退款时间 refund_time 否 2015-04-21 23:03:00 String(32) 红包的退款时间（如果其未领取的退款）
     * 红包退款金额 refund_amount 否 8000 Int 红包退款金额
     * 祝福语 wishing 否 新年快乐 String(128) 祝福语
     * 活动描述 remark 否 新年红包 String(256) 活动描述，低版本微信可见
     * 活动名称 act_name 否 新年红包 String(32) 发红包的活动名称
     * 裂变红包领取列表 hblist 否 内容如下表 裂变红包的领取列表
     * 领取红包的Openid openid 是 ohO4GtzOAAYMp2yapORH3dQB3W18 String(32) 领取红包的openid
     * 金额 amount 是 100 int 领取金额
     * 接收时间 rcv_time 是 2015-04-21 20:00:00 String(32) 领取红包的时间
     * 成功示例：
     *
     * <xml>
     * <return_code><![CDATA[SUCCESS]]></return_code>
     * <return_msg><![CDATA[获取成功]]></return_msg>
     * <result_code><![CDATA[SUCCESS]]></result_code>
     * <mch_id>10000098</mch_id>
     * <appid><![CDATA[wxe062425f740c30d8]]></appid>
     * <detail_id><![CDATA[1000000000201503283103439304]]></detail_id>
     * <mch_billno><![CDATA[1000005901201407261446939628]]></mch_billno>
     * <status><![CDATA[RECEIVED]]></status>
     * <send_type><![CDATA[API]]></send_type>
     * <hb_type><![CDATA[GROUP]]></hb_type>
     * <total_num>4</total_num>
     * <total_amount>650</total_amount>
     * <send_time><![CDATA[2015-04-21 20:00:00]]></send_time>
     * <wishing><![CDATA[开开心心]]></wishing>
     * <remark><![CDATA[福利]]></remark>
     * <act_name><![CDATA[福利测试]]></act_name>
     * <hblist>
     * <hbinfo>
     * <openid><![CDATA[ohO4GtzOAAYMp2yapORH3dQB3W18]]></openid>
     * <status><![CDATA[RECEIVED]]></status>
     * <amount>1</amount>
     * <rcv_time><![CDATA[2015-04-21 20:00:00]]></rcv_time>
     * </hbinfo>
     * <hbinfo>
     * <openid><![CDATA[ohO4GtzOAAYMp2yapORH3dQB3W17]]></openid>
     * <status><![CDATA[RECEIVED]]></status>
     * <amount>1</amount>
     * <rcv_time><![CDATA[2015-04-21 20:00:00]]></rcv_time>
     * </hbinfo>
     * <hbinfo>
     * <openid><![CDATA[ohO4GtzOAAYMp2yapORH3dQB3W16]]></openid>
     * <status><![CDATA[RECEIVED]]></status>
     * <amount>1</amount>
     * <rcv_time><![CDATA[2015-04-21 20:00:00]]></rcv_time>
     * </hbinfo>
     * <hbinfo>
     * <openid><![CDATA[ohO4GtzOAAYMp2yapORH3dQB3W15]]></openid>
     * <status><![CDATA[RECEIVED]]></status>
     * <amount>1</amount>
     * <rcv_time><![CDATA[2015-04-21 20:00:00]]></rcv_time>
     * </hbinfo>
     * </hblist>
     * </xml>
     * 失败示例：
     *
     * <xml>
     * <return_code><![CDATA[FAIL]]></return_code>
     * <return_msg><![CDATA[指定单号数据不存在]]></return_msg>
     * <result_code><![CDATA[FAIL]]></result_code>
     * <err_code><![CDATA[SYSTEMERROR]]></err_code>
     * <err_code_des><![CDATA[指定单号数据不存在]]></err_code_des>
     * <mch_id>666</mch_id>
     * <mch_billno><![CDATA[1000005901201407261446939688]]></mch_billno>
     * </xml>
     * 5.错误码
     * 错误代码 描述 解决方案
     * CA_ERROR 请求未携带证书，或请求携带的证书出错 到商户平台下载证书，请求带上证书后重试。
     * SIGN_ERROR 商户签名错误 按文档要求重新生成签名后再重试。
     * NO_AUTH 没有权限 请联系微信支付开通api权限
     * NOT_FOUND 指定单号数据不存在 查询单号对应的数据不存在，请使用正确的商户订单号查询
     * FREQ_LIMIT 受频率限制 请对请求做频率控制
     * XML_ERROR 请求的xml格式错误，或者post的数据为空 检查请求串，确认无误后重试
     * PARAM_ERROR 参数错误 请查看err_code_des，修改设置错误的参数
     * SYSTEMERROR 系统繁忙，请再试。 红包系统繁忙。
     */
    public function gethbinfo($nonce_str, $mch_billno, $bill_type = 'MCHT')
    {
        $postData = array();
        $postData["nonce_str"] = $nonce_str;
        $postData["mch_billno"] = $mch_billno;
        $postData["mch_id"] = $this->getMchid();
        $postData["appid"] = $this->getAppId();
        $postData["bill_type"] = $bill_type;
        $sign = $this->getSign($postData);
        $postData["sign"] = $sign;
        $xml = Helpers::arrayToXml($postData);
        $options = array();
        $options['cert'] = $this->getCert();
        $options['ssl_key'] = $this->getCertKey();
        $rst = $this->post($this->_url . 'mmpaymkttransfers/gethbinfo', $xml, $options);
        return $this->returnResult($rst);
    }

    /**
     * 发放代金券
     * 接口请求链接
     * https://api.mch.weixin.qq.com/mmpaymkttransfers/send_coupon
     * 是否需要证书
     * 请求需要双向证书。 详见证书使用
     * 请求参数
     * 字段名 变量名 必填 示例值 类型 说明
     * 代金券批次id coupon_stock_id 是 1757 String 代金券批次id
     * openid记录数 openid_count 是 1 int openid记录数（目前支持num=1）
     * 商户单据号 partner_trade_no 是 1000009820141203515766 String 商户此次发放凭据号（格式：商户id+日期+流水号），商户侧需保持唯一性
     * 用户openid openid 是 onqOjjrXT-776SpHnfexGm1_P7iE String Openid信息
     * 公众账号ID appid 是 wx5edab3bdfba3dc1c String(32) 微信分配的公众账号ID（企业号corpid即为此appId）
     * 商户号 mch_id 是 10000098 String(32) 微信支付分配的商户号
     * 操作员 op_user_id 否 10000098 String(32) 操作员帐号, 默认为商户号
     * 可在商户平台配置操作员对应的api权限
     * 设备号 device_info 否 String(32) 微信支付分配的终端设备号
     * 随机字符串 nonce_str 是 1417574675 String(32) 随机字符串，不长于32位
     * 签名 sign 是 841B3002FE2220C87A2D08ABD8A8F791 String(32) 签名，具体参见3.2.1
     * 协议版本 version 否 1.0 String(32) 默认1.0
     * 协议类型 type 否 XML String(32) XML【目前仅支持默认XML】
     * 请求参数示例：
     *
     * <xml>
     * <appid> wx5edab3bdfba3dc1c</appid>
     * <coupon_stock_id>1757</coupon_stock_id>
     * <mch_id>10010405</mch_id>
     * <nonce_str>1417574675</nonce_str>
     * <openid>onqOjjrXT-776SpHnfexGm1_P7iE</openid>
     * <openid_count>1</openid_count>
     * <partner_trade_no>1000009820141203515766</partner_trade_no>
     * <sign>841B3002FE2220C87A2D08ABD8A8F791</sign>
     * </xml>
     * CURL请求带证书代码样例：
     *
     * curl --cert 10010405.pem --key 10010405.key -H
     * "Content-Type：text/xml" -d
     * '<xml><mch_id>10010405</mch_id><appid>121512345</appid><nonce_str>1417582740</nonce_str><coupon_stock_id>1757</coupon_stock_id><openid_count>1</openid_count><openid>onqOjjrXT-776SpHnfexGm1_P7iE</openid><partner_trade_no>121512345456</partner_trade_no></xml>' https://api.mch.weixin.qq.com/secapi/promotion/send_coupon/ -i
     * 返回参数
     * 字段名 变量名 必填 示例值 类型 说明
     * 返回状态码 return_code 是 SUCCESS或者FAIL String(16)
     * SUCCESS/FAIL
     * 此字段是通信标识，非交易标识，交易是否成功需要查看result_code来判断
     * 返回信息 return_msg 否 成功：返回空” String(128) 返回信息，如非空，为通信错误原因
     * 公众账号ID appid 是 wx5edab3bdfba3dc1c String(32) 微信分配的公众账号ID（企业号corpid即为此appId）
     * 商户号 mch_id 是 10000098 String(32) 微信支付分配的商户号
     * 设备号 device_info 否 123456sb String(32) 微信支付分配的终端设备号，
     * 随机字符串 nonce_str 是 1417574675 String(32) 随机字符串，不长于32位
     * 签名 sign 是 841B3002FE2220C87A2D08ABD8A8F791 String(32) 请具体参见3.2.1
     * 业务结果 result_code 是 SUCCESS或者FAIL String(16) SUCCESS/FAIL
     * 错误代码 err_code 否 十进制表示 String(32) 详见业务错误代码章节
     * 错误代码描述 err_code_des 否 错误描述信息 String(128) 结果信息描述
     * 代金券批次id coupon_stock_id 是 1757 String 用户在商户appid下的唯一标识
     * 返回记录数 resp_count 是 1 Int 返回记录数
     * 成功记录数 success_count 是 1或者0 Int 成功记录数
     * 失败记录数 failed_count 是 1或者0 Int 失败记录数
     * 用户标识 openid 是 onqOjjrXT-776SpHnfexGm1_P7iE String 用户在商户appid下的唯一标识
     * 返回码 ret_code 是 SUCCESS或者FAILED String 返回码，SUCCESS/FAILED
     * 代金券id coupon_id 是 1870 String
     * 对一个用户成功发放代金券则返回代金券id，即ret_code为SUCCESS的时候；
     * 如果ret_code为FAILED则填写空串""
     * 返回信息 ret_msg 是 失败描述信息，例如：“用户已达领用上限” String 返回信息，当返回码是FAILED的时候填写，否则填空串“”
     * 返回参数示例：
     * 成功示例格式：
     *
     * <xml>
     * <return_code>SUCCESS</return_code>
     * <appid>wx5edab3bdfba3dc1c</appid>
     * <mch_id>10000098</mch_id>
     * <nonce_str>1417579335</nonce_str>
     * <sign>841B3002FE2220C87A2D08ABD8A8F791</sign>
     * <result_code>SUCCESS</result_code>
     * <coupon_stock_id>1717</coupon_stock_id>
     * <resp_count>1</resp_count>
     * <success_count>1</success_count>
     * <failed_count>0</failed_count>
     * <openid>onqOjjrXT-776SpHnfexGm1_P7iE</openid>
     * <ret_code>SUCCESS</ret_code>
     * <coupon_id>6954</coupon_id>
     * </xml>
     * 失败示例格式：
     * <xml>
     * <return_code>SUCCESS</return_code>
     * <appid>wx5edab3bdfba3dc1c</appid>
     * <mch_id>10000098</mch_id>
     * <nonce_str>1417579335</nonce_str>
     * <sign>841B3002FE2220C87A2D08ABD8A8F791</sign>
     * <result_code>FAIL</result_code>
     * <err_code>268456007</err_code>
     * <err_code_des>你已领取过该代金券</err_code_des>
     * <coupon_stock_id>1717</coupon_stock_id>
     * <resp_count>1</resp_count>
     * <success_count>0</success_count>
     * <failed_count>1</failed_count>
     * <openid>onqOjjrXT-776SpHnfexGm1_P7iE</openid>
     * <ret_code>FAIL</ret_code>
     * <ret_msg>你已领取过该代金券<ret_msg/>
     * <coupon_id></coupon_id>
     * </xml>
     * 错误码
     * 错误代码 描述 解决方案
     * USER_AL_GET_COUPON 你已领取过该代金券 用户已领过，正常逻辑报错
     * NETWORK ERROR 网络环境不佳，请重试 请重试
     * AL_STOCK_OVER 活动已结束 活动已结束，属于正常逻辑错误
     * FREQ_OVER_LIMIT 超过发放频率限制，请稍后再试 请求对发放请求做频率控制
     * PARAM_ERROR 校验参数错误（会返回具体哪个参数错误） 根据错误提示确认参数无误并更正
     * SIGN_ERROR 签名错误 验证签名有误，参见3.2.1
     * CA_ERROR 证书有误 确认证书正确，或者联系商户平台更新证书
     * REQ_PARAM_XML_ERR 输入参数xml格式有误 检查入参的xml格式是否正确
     * COUPON_STOCK_ID_EMPTY 批次ID为空 确保批次id正确传入
     * MCH_ID_EMPTY 商户ID为空 确保商户id正确传入
     * CODE_2_ID_ERR 商户id有误 检查商户id是否正确并合法
     * OPEN_ID_EMPTY 用户openid为空 检查用户openid是否正确并合法
     * ERR_VERIFY_SSL_SERIAL 获取客户端证书序列号失败! 检查证书是否正确
     * ERR_VERIFY_SSL_SN 获取客户端证书特征名称(DN)域失败! 检查证书是否正确
     * CA_VERIFY_FAILED 证书验证失败 检查证书是否正确
     * STOCK_IS_NOT_VALID 抱歉，该代金券已失效
     */
    public function sendcoupon($openid, $coupon_stock_id, $partner_trade_no, $nonce_str, $openid_count = 1, $op_user_id = "", $device_info = "", $version = "1.0", $type = "XML")
    {
        $postData = array();
        $postData["coupon_stock_id"] = $coupon_stock_id;
        $postData["openid_count"] = $openid_count;
        $postData["partner_trade_no"] = $partner_trade_no;
        $postData["openid"] = $openid;
        $postData["appid"] = $this->getAppId();
        $postData["mch_id"] = $this->getMchid();
        $postData["op_user_id"] = $op_user_id;
        $postData["device_info"] = $device_info;
        $postData["nonce_str"] = $nonce_str;
        $postData["version"] = $version;
        $postData["type"] = $type;
        
        $sign = $this->getSign($postData);
        $postData["sign"] = $sign;
        $xml = Helpers::arrayToXml($postData);
        $options = array();
        $options['cert'] = $this->getCert();
        $options['ssl_key'] = $this->getCertKey();
        $rst = $this->post($this->_url . 'mmpaymkttransfers/send_coupon', $xml, $options);
        return $this->returnResult($rst);
    }

    /**
     * 查询代金券批次
     * 接口请求链接
     * https://api.mch.weixin.qq.com/mmpaymkttransfers/query_coupon_stock
     * 是否需要证书
     * 不需要。
     * 请求参数
     * 字段名 变量名 必填 示例值 类型 说明
     * 代金券批次id coupon_stock_id 是 1757 String 代金券批次id
     * 公众账号ID appid 是 wx5edab3bdfba3dc1c String(32) 微信分配的公众账号ID（企业号corpid即为此appId）
     * 商户号 mch_id 是 10000098 String(32) 微信支付分配的商户号
     * 操作员 op_user_id 否 10000098 String(32) 操作员帐号, 默认为商户号
     * 可在商户平台配置操作员对应的api权限
     * 设备号 device_info 否 String(32) 微信支付分配的终端设备号
     * 随机字符串 nonce_str 是 1417574675 String(32) 随机字符串，不长于32位
     * 签名 sign 是 841B3002FE2220C87A2D08ABD8A8F791 String(32) 签名，详见签名生成算法
     * 协议版本 version 否 1.0 String(32) 默认1.0
     * 协议类型 type 否 XML String(32) XML【目前仅支持默认XML】
     * 请求参数示例：
     *
     * <xml>
     * <appid>121512345</appid>
     * <coupon_stock_id>1757</coupon_stock_id>
     * <mch_id>10000098</mch_id>
     * <nonce_str>1417575000</nonce_str>
     * <sign>BBB998301C99F96F41E6EA727ADFC45D</sign>
     * </xml>
     * 返回参数
     * 字段名 变量名 必填 示例值 类型 说明
     * 返回状态码 return_code 是 SUCCESS或者FAIL String(16) SUCCESS/FAIL
     * 此字段是通信标识，非交易标识，交易是否成功需要查看result_code来判断
     * 返回信息 return_msg 否 成功：返回空” String(128) 返回信息，如非空，为通信错误原因
     * 公众账号ID appid 是 wx5edab3bdfba3dc1c String(32) 微信分配的公众账号ID
     * 商户号 mch_id 是 10000098 String(32) 微信支付分配的商户号
     * 设备号 device_info 否 123456sb String(32) 微信支付分配的终端设备号，
     * 随机字符串 nonce_str 是 1417574675 String(32) 随机字符串，不长于32位
     * 签名 sign 是 841B3002FE2220C87A2D08ABD8A8F791 String(32) 签名，详见签名生成算法
     * 业务结果 result_code 是 SUCCESS或者FAIL String(16) SUCCESS/FAIL
     * 错误代码 err_code 否 COUPON_STOCK_ID_NOT_VALID String(32) 详见业务错误代码章节
     * 错误代码描述 err_code_des 否 错误描述信息 String(128) 结果信息描述
     * 代金券批次ID coupon_stock_id 是 1757 String 代金券批次Id
     * 代金券名称 coupon_name 否 测试代金券 String 代金券名称
     * 代金券面额 coupon_value 是 5 Unsinged int 代金券面值,单位是分
     * 代金券使用最低限额 coupon_mininumn 否 10 Unsinged int 代金券使用最低限额,单位是分
     * 代金券类型 coupon_type 是 1 int 代金券类型：1-代金券无门槛，2-代金券有门槛互斥，3-代金券有门槛叠加，
     * 代金券批次状态 coupon_stock_status 是 4 int 批次状态： 1-未激活；2-审批中；4-已激活；8-已作废；16-中止发放；
     * 代金券数量 coupon_total 是 100 Unsigned int 代金券数量
     * 代金券最大领取数量 max_quota 否 1 Unsigned int 代金券每个人最多能领取的数量, 如果为0，则表示没有限制
     * 代金券锁定数量 locked_num 否 0 Unsigned int 代金券锁定数量
     * 代金券已使用数量 used_num 否 0 Unsigned int 代金券已使用数量
     * 代金券已经发送的数量 is_send_num 否 0 Unsigned int 代金券已经发送的数量
     * 生效开始时间 begin_time 是 1943787483 String 格式为yyyyMMddhhmmss，如2009年12月27日9点10分10秒表示为20091227091010。
     * 生效结束时间 end_time 是 1943787490 String 格式为yyyyMMddhhmmss，如2009年12月27日9点10分10秒表示为20091227091010。
     * 创建时间 create_time 是 1943787420 String 格式为yyyyMMddhhmmss，如2009年12月27日9点10分10秒表示为20091227091010。
     * 代金券预算额度 coupon_budget 否 500 Unsigned int 代金券预算额度
     * 返回参数示例：
     * 成功示例
     *
     * <return_code>SUCCESS</return_code>
     * <appid>wx5edab3bdfba3dc1c</appid>
     * <mch_id>10000098</mch_id>
     * <nonce_str>1417583379</nonce_str>
     * <sign>841B3002FE2220C87A2D08ABD8A8F791</sign>
     * <result_code>SUCCESS</result_code>
     * <coupon_stock_id>1717</coupon_stock_id>
     * <coupon_value>5</coupon_value>
     * <coupon_mininumn>10</coupon_mininumn>
     * <coupon_type>1</coupon_type>
     * <coupon_stock_status>4</coupon_stock_status>
     * <coupon_total>100</coupon_total>
     * <begin_time>1943787483</begin_time>
     * <end_time>1943787490</end_time>
     * <create_time>1943787420</create_time>
     * <coupon_budget>500</coupon_budget>
     * </xml>
     * 失败示例
     *
     * <xml>
     * <return_code>SUCCESS</return_code>
     * <appid>wx5edab3bdfba3dc1c</appid>
     * <mch_id>10000098</mch_id>
     * <nonce_str>1417583379</nonce_str>
     * <sign>841B3002FE2220C87A2D08ABD8A8F791</sign>
     * <result_code>SUCCESS</result_code>
     * <err_code>268456007</err_code>
     * <err_code_des>批次ID信息不正确</err_code_des>
     * <coupon_stock_id>1717</coupon_stock_id>
     * </xml>
     * 错误码
     * 错误代码 描述 解决方案
     * COUPON_STOCK_ID_NOT_VALID 批次id不正确 确认批次id正确性，以及和商户id所属关系是否正确
     * SIGN_ERROR 签名错误 验证签名有误，参见3.2.1
     * REQ_PARAM_XML_ERR 输入参数xml格式有误 检查入参的xml格式是否正确
     * COUPON_STOCK_ID_EMPTY 批次ID为空 确保批次id正确传入
     * MCH_ID_EMPTY 商户ID为空 确保商户id正确传入
     * CODE_2_ID_ERR 商户id有误 检查商户id是否正确并合法
     * GET_COUPON_STOCK_FAIL 获取批次信息失败 确认批次id信息正确
     * COUPON_STOCK_NOT_FOUND 批次信息不存在 确认批次id信息正确
     */
    public function querycouponstock($coupon_stock_id, $nonce_str, $op_user_id = "", $device_info = "", $version = "1.0", $type = "XML")
    {
        $postData = array();
        $postData["coupon_stock_id"] = $coupon_stock_id;
        $postData["appid"] = $this->getAppId();
        $postData["mch_id"] = $this->getMchid();
        
        $postData["op_user_id"] = $op_user_id;
        $postData["device_info"] = $device_info;
        $postData["nonce_str"] = $nonce_str;
        $postData["version"] = $version;
        $postData["type"] = $type;
        
        $sign = $this->getSign($postData);
        $postData["sign"] = $sign;
        $xml = Helpers::arrayToXml($postData);
        $options = array();
        // $options['cert'] = $this->getCert();
        // $options['ssl_key'] = $this->getCertKey();
        $rst = $this->post($this->_url . 'mmpaymkttransfers/query_coupon_stock', $xml, $options);
        return $this->returnResult($rst);
    }

    /**
     * 查询代金券信息
     * 接口请求链接
     * https://api.mch.weixin.qq.com/mmpaymkttransfers/querycouponsinfo
     * 请求参数
     * 字段名 变量名 必填 示例值 类型 说明
     * 代金券id coupon_id 是 1565 String 代金券id
     * 用户标识 openid 是 onqOjjrXT-776SpHnfexGm1_P7iE String 用户在商户appid下的唯一标识
     * 公众账号ID appid 是 wx5edab3bdfba3dc1c String(32) 微信分配的公众账号ID
     * 商户号 mch_id 是 10000098 String(32) 微信支付分配的商户号
     * 批次号 stock_id 是 58818 String(32) 代金劵对应的批次号
     * 操作员 op_user_id 否 10000098 String(32) 操作员帐号, 默认为商户号
     * 可在商户平台配置操作员对应的api权限
     * 设备号 device_info 否 String(32) 微信支付分配的终端设备号
     * 随机字符串 nonce_str 是 1417574675 String(32) 随机字符串，不长于32位
     * 签名 sign 是 841B3002FE2220C87A2D08ABD8A8F791 String(32) 签名，详见签名生成算法
     * 协议版本 version 否 1.0 String(32) 默认1.0
     * 协议类型 type 否 XML String(32) XML【目前仅支持默认XML】
     * 请求参数示例：
     *
     * <xml>
     * <appid>121512345</appid>
     * <coupon_id>121512345456</coupon_id>
     * <mch_id>10010405</mch_id>
     * <nonce_str>1417575784</nonce_str>
     * <openid>onqOjjrXT-776SpHnfexGm1_P7iE</openid>
     * <sign>16F1415792512A5C340170B35F6C60E6</sign>
     * </xml>
     * 返回参数
     * 字段名 变量名 必填 示例值 类型 说明
     * 返回状态码 return_code 是 SUCCESS或者FAIL String(16) SUCCESS/FAIL
     * 此字段是通信标识，非交易标识，交易是否成功需要查看result_code来判断
     * 返回信息 return_msg 否 成功：返回空” String(128) 返回信息，如非空，为通信错误原因
     * 公众账号ID appid 是 wx5edab3bdfba3dc1c String(32) 微信分配的公众账号ID
     * 商户号 mch_id 是 10000098 String(32) 微信支付分配的商户号
     * 子商户号 sub_mch_id 否 10000098 String(32) 微信支付分配的子商户号，受理模式下必填
     * 设备号 device_info 否 123456sb String(32) 微信支付分配的终端设备号，
     * 随机字符串 nonce_str 是 1417574675 String(32) 随机字符串，不长于32位
     * 签名 sign 是 841B3002FE2220C87A2D08ABD8A8F791 String(32) 签名，详见签名生成算法
     * 业务结果 result_code 是 SUCCESS或者FAIL String(16) SUCCESS/FAIL
     * 错误代码 err_code 否 十进制表示 String(32) 详见业务错误代码章节
     * 错误代码描述 err_code_des 否 错误描述信息 String(128) 结果信息描述
     * 批次ID coupon_stock_id 是 1567 String 代金券批次Id
     * 批次类型 coupon_stock_type 是 1 int 批次类型；1-批量型，2-触发型
     * 代金券id coupon_id 是 4242 String 代金券id
     * 代金券面额 coupon_value 是 4 Unsinged int 代金券面值,单位是分
     * 代金券使用门槛 coupon_mininum 是 10 Unsinged int 代金券使用最低限额,单位是分
     * 代金券名称 coupon_name 是 测试代金券 String 代金券名称
     * 代金券状态 coupon_state 是 2 int 代金券状态：2-已激活，4-已锁定，8-已实扣
     * 代金券类型 coupon_type 是 1 int 代金券类型：1-代金券无门槛，2-代金券有门槛互斥，3-代金券有门槛叠加，
     * 代金券描述 coupon_desc 是 微信支付-代金券 String 代金券描述
     * 实际优惠金额 coupon_use_value 是 0 Unsinged int 代金券实际使用金额
     * 优惠剩余可用额 coupon_remain_value 是 4 Unsinged int 代金券剩余金额：部分使用情况下，可能会存在券剩余金额
     * 生效开始时间 begin_time 是 1943787483 String 格式为yyyyMMddhhmmss，如2009年12月27日9点10分10秒表示为20091227091010。
     * 生效结束时间 end_time 是 1943787484 String 格式为yyyyMMddhhmmss，如2009年12月27日9点10分10秒表示为20091227091010。
     * 发放时间 send_time 是 1943787420 String 格式为yyyyMMddhhmmss，如2009年12月27日9点10分10秒表示为20091227091010。
     * 使用时间 use_time 否 1943787483 String 格式为yyyyMMddhhmmss，如2009年12月27日9点10分10秒表示为20091227091010。
     * 使用单号 trade_no 否 20091227091010 String 代金券使用后，关联的大单收单单号
     * 消耗方商户id consumer_mch_id 否 10000098 String 代金券使用后，消耗方商户id
     * 消耗方商户名称 consumer_mch_name 否 测试商户 String 代金券使用后，消耗方商户名称
     * 消耗方商户appid consumer_mch_appid 否 wx5edab3bdfba3dc1c String 代金券使用后，消耗方商户appid
     * 发放来源 send_source 是 1 String 代金券发放来源:JIFA-即发即用 NORMAL-普通发劵 FULL_SEND-满送活动送劵 SCAN_CODE-扫码领劵 OZ-刮奖领劵 AJUST-对账调账
     * 是否允许部分使用 is_partial_use 否 1 String 该代金券是否允许部分使用标识：1-表示支持部分使用
     * 返回参数示例：
     * 成功示例
     *
     * <xml>
     * <return_code>SUCCESS</return_code>
     * <appid>wx5edab3bdfba3dc1c</appid>
     * <mch_id>10000098</mch_id>
     * <nonce_str>1417586982</nonce_str>
     * <sign>841B3002FE2220C87A2D08ABD8A8F791</sign>
     * <result_code>SUCCESS</result_code>
     * <coupon_stock_id>1717</coupon_stock_id>
     * <coupon_stock_type>1</coupon_stock_type>
     * <coupon_id>1442</coupon_id>
     * <coupon_value>5</coupon_value>
     * <coupon_mininum>10</coupon_mininum>
     * <coupon_name>测试代金券</coupon_name>
     * <coupon_state>2</coupon_state>
     * <coupon_type>1</coupon_type>
     * <coupon_desc>微信支付-代金券</coupon_desc>
     * <coupon_use_value>0</coupon_use_value>
     * <coupon_remain_value>5</coupon_remain_value>
     * <begin_time>1943787483</begin_time>
     * <end_time>1943787484</end_time>
     * <send_time>1943787420</send_time>
     * <send_source>1</send_source>
     * </xml>
     * 失败示例
     *
     * <xml>
     * <return_code>SUCCESS</return_code>
     * <appid>wx5edab3bdfba3dc1c</appid>
     * <mch_id>10000098</mch_id>
     * <nonce_str>1417586982</nonce_str>
     * <sign>841B3002FE2220C87A2D08ABD8A8F791</sign>
     * <result_code>SUCCESS</result_code>
     * <err_code>268456007</err_code>
     * <err_code_des>你已领取过包</err_code_des>
     * <coupon_stock_id>1717</coupon_stock_id>
     * <coupon_stock_type>1</coupon_stock_type>
     * <coupon_id>1442</coupon_id>
     * <coupon_value>5</coupon_value>
     * <coupon_mininum>10</coupon_mininum>
     * <coupon_name>测试代金券</coupon_name>
     * <coupon_state>2</coupon_state>
     * <coupon_type>1</coupon_type>
     * <coupon_desc>微信支付-代金券</coupon_desc>
     * <coupon_use_value>0</coupon_use_value>
     * <coupon_remain_value>5</coupon_remain_value>
     * <begin_time>1943787483</begin_time>
     * <end_time>1943787484</end_time>
     * <send_time>1943787420</send_time>
     * <send_source>1</send_source>
     * </xml>
     * 错误码
     * 错误代码 描述 解决方案
     * COUPON_NOT_FOUND 券没有查找成功 确认券id、用户openid的正确性
     * SIGN_ERROR 签名错误 验证签名有误，参见3.2.1
     * COUPON_STOCK_ID_NOT_VALID 批次id不正确 确认批次id正确性以及和商户id的所属关系是否正确
     * REQ_PARAM_XML_ERR 输入的参数xml格式有误 检查输入的xml格式是否正确
     * COUPON_STOCK_ID_EMPTY 批次id为空 确认批次id正确传入
     * MCH_ID_EMPTY 商户id为空 确认商户id正确传入
     * CODE_2_ID_ERR 商户id有误 确认商户id是否正确并合法
     * GET_COUPON_STOCK_FAIL 获取批次信息失败 确认批次id信息正确
     * COUPON_STOCK_NOT_FOUND 批次信息不存在 确认批次id信息正确
     * NETWORKERROR 网络环境不佳,请重试 请重试
     */
    public function querycouponsinfo($openid, $coupon_id, $stock_id, $nonce_str, $op_user_id = "", $device_info = "", $version = "1.0", $type = "XML")
    {
        $postData = array();
        $postData["coupon_id"] = $coupon_id;
        $postData["openid"] = $openid;
        $postData["stock_id"] = $stock_id;
        
        $postData["appid"] = $this->getAppId();
        $postData["mch_id"] = $this->getMchid();
        
        $postData["op_user_id"] = $op_user_id;
        $postData["device_info"] = $device_info;
        $postData["nonce_str"] = $nonce_str;
        $postData["version"] = $version;
        $postData["type"] = $type;
        
        $sign = $this->getSign($postData);
        $postData["sign"] = $sign;
        $xml = Helpers::arrayToXml($postData);
        $options = array();
        // $options['cert'] = $this->getCert();
        // $options['ssl_key'] = $this->getCertKey();
        $rst = $this->post($this->_url . 'mmpaymkttransfers/querycouponsinfo', $xml, $options);
        return $this->returnResult($rst);
    }

    /**
     * 申请退款
     * 应用场景
     * 当交易发生之后一段时间内，由于买家或者卖家的原因需要退款时，卖家可以通过退款接口将支付款退还给买家，微信支付将在收到退款请求并且验证成功之后，按照退款规则将支付款按原路退到买家帐号上。
     * 注意：
     * 1、交易时间超过一年的订单无法提交退款
     * 2、微信支付退款支持单笔交易分多次退款，多次退款需要提交原支付订单的商户订单号和设置不同的退款单号。申请退款总金额不能超过订单金额。 一笔退款失败后重新提交，请不要更换退款单号，请使用原商户退款单号
     *
     * 3、请求频率限制：150qps，即每秒钟正常的申请退款请求次数不超过150次
     * 错误或无效请求频率限制：6qps，即每秒钟异常或错误的退款申请请求不超过6次
     * 4、每个支付订单的部分退款次数不能超过50次
     * 接口地址
     * 接口链接：https://api.mch.weixin.qq.com/secapi/pay/refund
     *
     * 是否需要证书
     * 请求需要双向证书。 详见证书使用
     * 请求参数
     * 字段名 变量名 必填 类型 示例值 描述
     * 公众账号ID appid 是 String(32) wx8888888888888888 微信分配的公众账号ID（企业号corpid即为此appId）
     * 商户号 mch_id 是 String(32) 1900000109 微信支付分配的商户号
     * 随机字符串 nonce_str 是 String(32) 5K8264ILTKCH16CQ2502SI8ZNMTM67VS 随机字符串，不长于32位。推荐随机数生成算法
     * 签名 sign 是 String(32) C380BEC2BFD727A4B6845133519F3AD6 签名，详见签名生成算法
     * 签名类型 sign_type 否 String(32) HMAC-SHA256 签名类型，目前支持HMAC-SHA256和MD5，默认为MD5
     * 微信订单号 transaction_id 二选一 String(28) 1217752501201407033233368018 微信生成的订单号，在支付通知中有返回
     * 商户订单号 out_trade_no String(32) 1217752501201407033233368018 商户系统内部订单号，要求32个字符内，只能是数字、大小写字母_-|*@ ，且在同一个商户号下唯一。
     * 商户退款单号 out_refund_no 是 String(64) 1217752501201407033233368018 商户系统内部的退款单号，商户系统内部唯一，只能是数字、大小写字母_-|*@ ，同一退款单号多次请求只退一笔。
     * 订单金额 total_fee 是 Int 100 订单总金额，单位为分，只能为整数，详见支付金额
     * 退款金额 refund_fee 是 Int 100 退款总金额，订单总金额，单位为分，只能为整数，详见支付金额
     * 货币种类 refund_fee_type 否 String(8) CNY 货币类型，符合ISO 4217标准的三位字母代码，默认人民币：CNY，其他值列表详见货币类型
     * 退款原因 refund_desc 否 String(80) 商品已售完 若商户传入，会在下发给用户的退款消息中体现退款原因
     * 退款资金来源 refund_account 否 String(30) REFUND_SOURCE_RECHARGE_FUNDS
     * 仅针对老资金流商户使用
     * REFUND_SOURCE_UNSETTLED_FUNDS---未结算资金退款（默认使用未结算资金退款）
     * REFUND_SOURCE_RECHARGE_FUNDS---可用余额退款
     * 举例如下：
     *
     * <xml>
     * <appid>wx2421b1c4370ec43b</appid>
     * <mch_id>10000100</mch_id>
     * <nonce_str>6cefdb308e1e2e8aabd48cf79e546a02</nonce_str>
     * <out_refund_no>1415701182</out_refund_no>
     * <out_trade_no>1415757673</out_trade_no>
     * <refund_fee>1</refund_fee>
     * <total_fee>1</total_fee>
     * <transaction_id></transaction_id>
     * <sign>FE56DD4AA85C0EECA82C35595A69E153</sign>
     * </xml>
     * 返回结果
     * 字段名 变量名 必填 类型 示例值 描述
     * 返回状态码 return_code 是 String(16) SUCCESS SUCCESS/FAIL
     * 返回信息 return_msg 否 String(128) 签名失败
     * 返回信息，如非空，为错误原因
     * 签名失败
     * 参数格式校验错误
     * 以下字段在return_code为SUCCESS的时候有返回
     *
     * 字段名 变量名 必填 类型 示例值 描述
     * 业务结果 result_code 是 String(16) SUCCESS
     * SUCCESS/FAIL
     * SUCCESS退款申请接收成功，结果通过退款查询接口查询
     * FAIL 提交业务失败
     * 错误代码 err_code 否 String(32) SYSTEMERROR 列表详见错误码列表
     * 错误代码描述 err_code_des 否 String(128) 系统超时 结果信息描述
     * 公众账号ID appid 是 String(32) wx8888888888888888 微信分配的公众账号ID
     * 商户号 mch_id 是 String(32) 1900000109 微信支付分配的商户号
     * 随机字符串 nonce_str 是 String(32) 5K8264ILTKCH16CQ2502SI8ZNMTM67VS 随机字符串，不长于32位
     * 签名 sign 是 String(32) 5K8264ILTKCH16CQ2502SI8ZNMTM67VS 签名，详见签名算法
     * 微信订单号 transaction_id 是 String(28) 4007752501201407033233368018 微信订单号
     * 商户订单号 out_trade_no 是 String(32) 33368018 商户系统内部订单号，要求32个字符内，只能是数字、大小写字母_-|*@ ，且在同一个商户号下唯一。
     * 商户退款单号 out_refund_no 是 String(64) 121775250 商户系统内部的退款单号，商户系统内部唯一，只能是数字、大小写字母_-|*@ ，同一退款单号多次请求只退一笔。
     * 微信退款单号 refund_id 是 String(32) 2007752501201407033233368018 微信退款单号
     * 退款金额 refund_fee 是 Int 100 退款总金额,单位为分,可以做部分退款
     * 应结退款金额 settlement_refund_fee 否 Int 100 去掉非充值代金券退款金额后的退款金额，退款金额=申请退款金额-非充值代金券退款金额，退款金额<=申请退款金额
     * 标价金额 total_fee 是 Int 100 订单总金额，单位为分，只能为整数，详见支付金额
     * 应结订单金额 settlement_total_fee 否 Int 100 去掉非充值代金券金额后的订单总金额，应结订单金额=订单金额-非充值代金券金额，应结订单金额<=订单金额。
     * 标价币种 fee_type 否 String(8) CNY 订单金额货币类型，符合ISO 4217标准的三位字母代码，默认人民币：CNY，其他值列表详见货币类型
     * 现金支付金额 cash_fee 是 Int 100 现金支付金额，单位为分，只能为整数，详见支付金额
     * 现金支付币种 cash_fee_type 否 String(16) CNY 货币类型，符合ISO 4217标准的三位字母代码，默认人民币：CNY，其他值列表详见货币类型
     * 现金退款金额 cash_refund_fee 否 Int 100 现金退款金额，单位为分，只能为整数，详见支付金额
     * 代金券类型 coupon_type_$n 否 String(8) CASH
     * CASH--充值代金券
     * NO_CASH---非充值代金券
     * 订单使用代金券时有返回（取值：CASH、NO_CASH）。$n为下标,从0开始编号，举例：coupon_type_0
     * 代金券退款总金额 coupon_refund_fee 否 Int 100 代金券退款金额<=退款金额，退款金额-代金券或立减优惠退款金额为现金，说明详见代金券或立减优惠
     * 单个代金券退款金额 coupon_refund_fee_$n 否 Int 100 代金券退款金额<=退款金额，退款金额-代金券或立减优惠退款金额为现金，说明详见代金券或立减优惠
     * 退款代金券使用数量 coupon_refund_count 否 Int 1 退款代金券使用数量
     * 退款代金券ID coupon_refund_id_$n 否 String(20) 10000 退款代金券ID, $n为下标，从0开始编号
     * 举例如下：
     *
     * <xml>
     * <return_code><![CDATA[SUCCESS]]></return_code>
     * <return_msg><![CDATA[OK]]></return_msg>
     * <appid><![CDATA[wx2421b1c4370ec43b]]></appid>
     * <mch_id><![CDATA[10000100]]></mch_id>
     * <nonce_str><![CDATA[NfsMFbUFpdbEhPXP]]></nonce_str>
     * <sign><![CDATA[B7274EB9F8925EB93100DD2085FA56C0]]></sign>
     * <result_code><![CDATA[SUCCESS]]></result_code>
     * <transaction_id><![CDATA[1008450740201411110005820873]]></transaction_id>
     * <out_trade_no><![CDATA[1415757673]]></out_trade_no>
     * <out_refund_no><![CDATA[1415701182]]></out_refund_no>
     * <refund_id><![CDATA[2008450740201411110000174436]]></refund_id>
     * <refund_channel><![CDATA[]]></refund_channel>
     * <refund_fee>1</refund_fee>
     * </xml>
     * 错误码
     * 名称 描述 原因 解决方案
     * SYSTEMERROR 接口返回错误 系统超时等 请不要更换商户退款单号，请使用相同参数再次调用API。
     * BIZERR_NEED_RETRY 退款业务流程错误，需要商户触发重试来解决 并发情况下，业务被拒绝，商户重试即可解决 请不要更换商户退款单号，请使用相同参数再次调用API。
     * TRADE_OVERDUE 订单已经超过退款期限 订单已经超过可退款的最大期限(支付后一年内可退款) 请选择其他方式自行退款
     * ERROR 业务错误 申请退款业务发生错误 该错误都会返回具体的错误原因，请根据实际返回做相应处理。
     * USER_ACCOUNT_ABNORMAL 退款请求失败 用户帐号注销 此状态代表退款申请失败，商户可自行处理退款。
     * INVALID_REQ_TOO_MUCH 无效请求过多 连续错误请求数过多被系统短暂屏蔽 请检查业务是否正常，确认业务正常后请在1分钟后再来重试
     * NOTENOUGH 余额不足 商户可用退款余额不足 此状态代表退款申请失败，商户可根据具体的错误提示做相应的处理。
     * INVALID_TRANSACTIONID 无效transaction_id 请求参数未按指引进行填写 请求参数错误，检查原交易号是否存在或发起支付交易接口返回失败
     * PARAM_ERROR 参数错误 请求参数未按指引进行填写 请求参数错误，请重新检查再调用退款申请
     * APPID_NOT_EXIST APPID不存在 参数中缺少APPID 请检查APPID是否正确
     * MCHID_NOT_EXIST MCHID不存在 参数中缺少MCHID 请检查MCHID是否正确
     * REQUIRE_POST_METHOD 请使用post方法 未使用post传递参数 请检查请求参数是否通过post方法提交
     * SIGNERROR 签名错误 参数签名结果不正确 请检查签名参数和方法是否都符合签名算法要求
     * XML_FORMAT_ERROR XML格式错误 XML格式错误 请检查XML参数格式是否正确
     * FREQUENCY_LIMITED 频率限制 2个月之前的订单申请退款有频率限制 该笔退款未受理，请降低频率后重试
     */
    public function refund($nonce_str, $transaction_id, $out_trade_no, $out_refund_no, $total_fee, $refund_fee, $sign_type = 'MD5', $refund_fee_type = 'CNY', $refund_desc = '', $refund_account = '')
    {
        $postData = array();
        $postData["appid"] = $this->getAppId();
        $postData["mch_id"] = $this->getMchid();
        $postData["nonce_str"] = $nonce_str;
        $postData["sign_type"] = $sign_type;
        $postData["transaction_id"] = $transaction_id;
        $postData["out_trade_no"] = $out_trade_no;
        $postData["out_refund_no"] = $out_refund_no;
        $postData["total_fee"] = $total_fee;
        $postData["refund_fee"] = $refund_fee;
        $postData["refund_fee_type"] = $refund_fee_type;
        $postData["refund_desc"] = $refund_desc;
        $postData["refund_account"] = $refund_account;
        // $postData["op_user_id"] = $this->getMchid();
        
        $sign = $this->getSign($postData);
        $postData["sign"] = $sign;
        $xml = Helpers::arrayToXml($postData);
        $options = array();
        $options['cert'] = $this->getCert();
        $options['ssl_key'] = $this->getCertKey();
        $rst = $this->post($this->_url . 'secapi/pay/refund', $xml, $options);
        return $this->returnResult($rst);
    }

    /**
     * 接口介绍
     * 业务流程 接口 简介
     * 付款 企业付款 用于企业向微信用户个人付款
     * 目前支持向指定微信用户的openid付款。（获取openid参见微信公众平台开发者文档： 网页授权获取用户基本信息）
     * 接口调用规则：
     * ◆ 给同一个实名用户付款，单笔单日限额2W/2W
     * ◆ 不支持给非实名用户打款
     * ◆ 一个商户同一日付款总额限额100W
     * ◆ 单笔最小金额默认为1元
     * ◆ 每个用户每天最多可付款10次，可以在商户平台--API安全进行设置
     * ◆ 给同一个用户付款时间间隔不得低于15秒
     * 注意1-当返回错误码为“SYSTEMERROR”时，一定要使用原单号重试，否则可能造成重复支付等资金风险。
     * 注意2-根据监管要求，新申请商户号使用企业付款需要满足两个条件：1、入驻时间超过90天 2、连续正常交易30天。
     * 接口地址
     * 接口链接：https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers
     *
     * 是否需要证书
     * 请求需要双向证书。 详见证书使用
     * 请求参数
     * 字段名 变量名 必填 示例值 类型 描述
     * 商户账号appid mch_appid 是 wx8888888888888888 String 微信分配的账号ID（企业号corpid即为此appId）
     * 商户号 mchid 是 1900000109 String(32) 微信支付分配的商户号
     * 设备号 device_info 否 013467007045764 String(32) 微信支付分配的终端设备号
     * 随机字符串 nonce_str 是 5K8264ILTKCH16CQ2502SI8ZNMTM67VS String(32) 随机字符串，不长于32位
     * 签名 sign 是 C380BEC2BFD727A4B6845133519F3AD6 String(32) 签名，详见签名算法
     * 商户订单号 partner_trade_no 是 10000098201411111234567890 String 商户订单号，需保持唯一性
     * (只能是字母或者数字，不能包含有符号)
     * 用户openid openid 是 oxTWIuGaIt6gTKsQRLau2M0yL16E String 商户appid下，某用户的openid
     * 校验用户姓名选项 check_name 是 FORCE_CHECK String NO_CHECK：不校验真实姓名
     * FORCE_CHECK：强校验真实姓名
     * 收款用户姓名 re_user_name 可选 王小王 String 收款用户真实姓名。
     * 如果check_name设置为FORCE_CHECK，则必填用户真实姓名
     * 金额 amount 是 10099 int 企业付款金额，单位为分
     * 企业付款描述信息 desc 是 理赔 String 企业付款操作说明信息。必填。
     * Ip地址 spbill_create_ip 是 192.168.0.1 String(32) 调用接口的机器Ip地址
     * 数据示例：
     *
     * <xml>
     * <mch_appid>wxe062425f740c30d8</mch_appid>
     * <mchid>10000098</mchid>
     * <nonce_str>3PG2J4ILTKCH16CQ2502SI8ZNMTM67VS</nonce_str>
     * <partner_trade_no>100000982014120919616</partner_trade_no>
     * <openid>ohO4Gt7wVPxIT1A9GjFaMYMiZY1s</openid>
     * <check_name>FORCE_CHECK</check_name>
     * <re_user_name>张三</re_user_name>
     * <amount>100</amount>
     * <desc>节日快乐!</desc>
     * <spbill_create_ip>10.2.3.10</spbill_create_ip>
     * <sign>C97BDBACF37622775366F38B629F45E3</sign>
     * </xml>
     * 返回参数
     * 字段名 变量名 必填 示例值 类型 描述
     * 返回状态码 return_code 是 SUCCESS String(16) SUCCESS/FAIL
     * 此字段是通信标识，非交易标识，交易是否成功需要查看result_code来判断
     * 返回信息 return_msg 否 签名失败 String(128) 返回信息，如非空，为错误原因
     * 签名失败
     * 参数格式校验错误
     * 以下字段在return_code为SUCCESS的时候有返回
     *
     * 字段名 变量名 必填 示例值 类型 描述
     * 商户appid mch_appid 是 wx8888888888888888 String 微信分配的公众账号ID（企业号corpid即为此appId）
     * 商户号 mchid 是 1900000109 String(32) 微信支付分配的商户号
     * 设备号 device_info 否 013467007045764 String(32) 微信支付分配的终端设备号，
     * 随机字符串 nonce_str 是 5K8264ILTKCH16CQ2502SI8ZNMTM67VS String(32) 随机字符串，不长于32位
     * 业务结果 result_code 是 SUCCESS String(16) SUCCESS/FAIL
     * 错误代码 err_code 否 SYSTEMERROR String(32) 错误码信息
     * 错误代码描述 err_code_des 否 系统错误 String(128) 结果信息描述
     * 以下字段在return_code 和result_code都为SUCCESS的时候有返回
     *
     * 字段名 变量名 必填 示例值 类型 描述
     * 商户订单号 partner_trade_no 是 1217752501201407033233368018 String(32) 商户订单号，需保持唯一性
     * (只能是字母或者数字，不能包含有符号)
     * 微信订单号 payment_no 是 1007752501201407033233368018 String 企业付款成功，返回的微信订单号
     * 微信支付成功时间 payment_time 是 2015-05-19 15：26：59 String 企业付款成功时间
     * 成功示例：
     *
     * <xml>
     * <return_code><![CDATA[SUCCESS]]></return_code>
     * <return_msg><![CDATA[]]></return_msg>
     * <mch_appid><![CDATA[wxec38b8ff840bd989]]></mch_appid>
     * <mchid><![CDATA[10013274]]></mchid>
     * <device_info><![CDATA[]]></device_info>
     * <nonce_str><![CDATA[lxuDzMnRjpcXzxLx0q]]></nonce_str>
     * <result_code><![CDATA[SUCCESS]]></result_code>
     * <partner_trade_no><![CDATA[10013574201505191526582441]]></partner_trade_no>
     * <payment_no><![CDATA[1000018301201505190181489473]]></payment_no>
     * <payment_time><![CDATA[2015-05-19 15：26：59]]></payment_time>
     * </xml>
     * 错误示例：
     *
     * <xml>
     * <return_code><![CDATA[FAIL]]></return_code>
     * <return_msg><![CDATA[系统繁忙,请稍后再试.]]></return_msg>
     * <result_code><![CDATA[FAIL]]></result_code>
     * <err_code><![CDATA[SYSTEMERROR]]></err_code>
     * <err_code_des><![CDATA[系统繁忙,请稍后再试.]]></err_code_des>
     * </xml>
     * 错误码
     * 错误代码 描述 原因 解决方案
     * NO_AUTH 没有该接口权限 没有授权请求此api 请关注是否满足接口调用条件
     * AMOUNT_LIMIT 付款金额不能小于最低限额 付款金额不能小于最低限额 每次付款金额必须大于1元
     * PARAM_ERROR 参数错误 参数缺失，或参数格式出错，参数不合法等 请查看err_code_des，修改设置错误的参数
     * OPENID_ERROR Openid错误 Openid格式错误或者不属于商家公众账号 请核对商户自身公众号appid和用户在此公众号下的openid。
     * SEND_FAILED 付款错误 付款失败，请换单号重试 付款失败，请换单号重试
     * NOTENOUGH 余额不足 帐号余额不足 请用户充值或更换支付卡后再支付
     * SYSTEMERROR 系统繁忙，请稍后再试。 系统错误，请重试 请使用原单号以及原请求参数重试，否则可能造成重复支付等资金风险
     * NAME_MISMATCH 姓名校验出错 请求参数里填写了需要检验姓名，但是输入了错误的姓名 填写正确的用户姓名
     * SIGN_ERROR 签名错误 没有按照文档要求进行签名
     * 签名前没有按照要求进行排序。
     * 没有使用商户平台设置的密钥进行签名
     * 参数有空格或者进行了encode后进行签名。
     * XML_ERROR Post内容出错 Post请求数据不是合法的xml格式内容 修改post的内容
     * FATAL_ERROR 两次请求参数不一致 两次请求商户单号一样，但是参数不一致 如果想重试前一次的请求，请用原参数重试，如果重新发送，请更换单号。
     * FREQ_LIMIT 超过频率限制，请稍后再试。 接口请求频率超时接口限制 请关注接口的使用条件
     * MONEY_LIMIT 已经达到今日付款总额上限/已达到付款给此用户额度上限 接口对商户号的每日付款总额，以及付款给同一个用户的总额有限制 请关注接口的付款限额条件
     * CA_ERROR 证书出错 请求没带证书或者带上了错误的证书
     * 到商户平台下载证书
     * 请求的时候带上该证书
     * V2_ACCOUNT_SIMPLE_BAN 无法给非实名用户付款 用户微信支付账户未知名，无法付款 引导用户在微信支付内进行绑卡实名
     * PARAM_IS_NOT_UTF8 请求参数中包含非utf8编码字符 接口规范要求所有请求参数都必须为utf8编码 请关注接口使用规范
     * AMOUNT_LIMIT 付款失败，因你已违反《微信支付商户平台使用协议》，单笔单次付款下限已被调整为5元 商户号存在违反协议内容行为，单次付款下限提高 请遵守《微信支付商户平台使用协议》
     */
    public function promotionTransfers($openid, $amount, $partner_trade_no, $nonce_str, $desc, $spbill_create_ip, $check_name = "NO_CHECK", $re_user_name = "", $device_info = "")
    {
        /**
         * 商户账号appid mch_appid 是 wx8888888888888888 String 微信分配的账号ID（企业号corpid即为此appId）
         * 商户号 mchid 是 1900000109 String(32) 微信支付分配的商户号
         * 设备号 device_info 否 013467007045764 String(32) 微信支付分配的终端设备号
         * 随机字符串 nonce_str 是 5K8264ILTKCH16CQ2502SI8ZNMTM67VS String(32) 随机字符串，不长于32位
         * 签名 sign 是 C380BEC2BFD727A4B6845133519F3AD6 String(32) 签名，详见签名算法
         * 商户订单号 partner_trade_no 是 10000098201411111234567890 String 商户订单号，需保持唯一性(只能是字母或者数字，不能包含有符号)
         * 用户openid openid 是 oxTWIuGaIt6gTKsQRLau2M0yL16E String 商户appid下，某用户的openid
         * 校验用户姓名选项 check_name 是 FORCE_CHECK String NO_CHECK：不校验真实姓名 FORCE_CHECK：强校验真实姓名
         * 收款用户姓名 re_user_name 可选 王小王 String 收款用户真实姓名。
         * 如果check_name设置为FORCE_CHECK，则必填用户真实姓名
         * 金额 amount 是 10099 int 企业付款金额，单位为分
         * 企业付款描述信息 desc 是 理赔 String 企业付款操作说明信息。必填。
         * Ip地址 spbill_create_ip 是 192.168.0.1 String(32) 调用接口的机器Ip地址
         */
        $postData = array();
        $postData["mch_appid"] = $this->getAppId();
        $postData["mchid"] = $this->getMchid();
        $postData["nonce_str"] = $nonce_str;
        $postData["partner_trade_no"] = $partner_trade_no;
        $postData["openid"] = $openid;
        $postData["amount"] = $amount;
        $postData["desc"] = $desc;
        $postData["spbill_create_ip"] = $spbill_create_ip;
        $postData["device_info"] = $device_info;
        
        $sign = $this->getSign($postData);
        $postData["sign"] = $sign;
        $xml = Helpers::arrayToXml($postData);
        $options = array();
        $options['cert'] = $this->getCert();
        $options['ssl_key'] = $this->getCertKey();
        $rst = $this->post($this->_url . 'mmpaymkttransfers/promotion/transfers', $xml, $options);
        return $this->returnResult($rst);
    }

    /**
     * 查询企业付款
     * 简介
     * 用于商户的企业付款操作进行结果查询，返回付款操作详细结果。
     * 查询企业付款API只支持查询30天内的订单，30天之前的订单请登录商户平台查询。
     * 接口说明
     * 请求Url https://api.mch.weixin.qq.com/mmpaymkttransfers/gettransferinfo
     * 是否需要证书 请求需要双向证书。 详见证书使用
     * 请求方式 POST
     * 请求参数
     * 字段名 字段 必填 示例值 类型 说明
     * 随机字符串 nonce_str 是 5K8264ILTKCH16CQ2502SI8ZNMTM67VS String(32) 随机字符串，不长于32位
     * 签名 sign 是 C380BEC2BFD727A4B6845133519F3AD6 String(32) 生成签名方式查看3.2.1节
     * 商户订单号 partner_trade_no 是 10000098201411111234567890 String(28) 商户调用企业付款API时使用的商户订单号
     * 商户号 mch_id 是 10000098 String(32) 微信支付分配的商户号
     * Appid appid 是 wxe062425f740d30d8 String(32) 商户号的appid
     * 数据示例：
     *
     * <xml>
     * <sign><![CDATA[E1EE61A91C8E90F299DE6AE075D60A2D]]></sign>
     * <partner_trade_no><![CDATA[0010010404201411170000046545]]></partner_trade_no>
     * <mch_id ><![CDATA[10000097]]></mch_id >
     * <appid><![CDATA[wxe062425f740c30d8]]></appid>
     * <nonce_str><![CDATA[50780e0cca98c8c8e814883e5caa672e]]></nonce_str>
     * </xml>
     * 返回参数
     * 字段名 变量名 必填 示例值 类型 说明
     * 返回状态码 return_code 是 SUCCESS String(16)
     * SUCCESS/FAIL
     * 此字段是通信标识，非交易标识，交易是否成功需要查看result_code来判断
     * 返回信息 return_msg 否 签名失败 String(128)
     * 返回信息，如非空，为错误原因
     * 签名失败
     * 参数格式校验错误
     * 以下字段在return_code为SUCCESS的时候有返回
     * 业务结果 result_code 是 SUCCESS String(16) SUCCESS/FAIL
     * 错误代码 err_code 否 SYSTEMERROR String(32) 错误码信息
     * 错误代码描述 err_code_des 否 系统错误 String(128) 结果信息描述
     * 以下字段在return_code 和result_code都为SUCCESS的时候有返回
     * 商户单号 partner_trade_no 是 10000098201411111234567890 String(28) 商户使用查询API填写的单号的原路返回.
     * 商户号 mch_id 是 10000098 String(32) 微信支付分配的商户号
     * 付款单号 detail_id 是 1000000000201503283103439304 String(32) 调用企业付款API时，微信系统内部产生的单号
     * 转账状态 status 是 SUCCESS string(16)
     * SUCCESS:转账成功
     * FAILED:转账失败
     * PROCESSING:处理中
     * 失败原因 reason 否 余额不足 String 如果失败则有失败原因
     * 收款用户openid openid 是 oxTWIuGaIt6gTKsQRLau2M0yL16E 转账的openid
     * 收款用户姓名 transfer_name 否 马华 String 收款用户姓名
     * 付款金额 payment_amount 是 5000 int 付款金额单位分）
     * 转账时间 transfer_time 是 2015-04-21 20:00:00 String 发起转账的时间
     * 付款描述 desc 是 车险理赔 String 付款时候的描述
     * 示例：
     *
     * <xml> // 按照格式补充
     * <return_code><![CDATA[SUCCESS]]></return_code>
     * <return_msg><![CDATA[获取成功]]></return_msg>
     * <result_code><![CDATA[SUCCESS]]></result_code>
     * <mch_id>10000098</mch_id>
     * <appid><![CDATA[wxe062425f740c30d8]]></appid>
     * <detail_id><![CDATA[1000000000201503283103439304]]></detail_id>
     * <partner_trade_no><![CDATA[1000005901201407261446939628]]></partner_trade_no>
     * <status><![CDATA[SUCCESS]]></status>
     * <payment_amount>650</payment_amount >
     * <openid ><![CDATA[oxTWIuGaIt6gTKsQRLau2M0yL16E]]></openid>
     * <transfer_time><![CDATA[2015-04-21 20:00:00]]></transfer_time>
     * <transfer_name ><![CDATA[测试]]></transfer_name >
     * <desc><![CDATA[福利测试]]></desc>
     * </xml>
     * 错误码
     * 错误代码 描述 解决方案
     * CA_ERROR 请求未携带证书，或请求携带的证书出错 到商户平台下载证书，请求带上证书后重试。
     * SIGN_ERROR 商户签名错误 按文档要求重新生成签名后再重试。
     * NO_AUTH 没有权限 请联系微信支付开通api权限
     * FREQ_LIMIT 受频率限制 请对请求做频率控制
     * XML_ERROR 请求的xml格式错误，或者post的数据为空 检查请求串，确认无误后重试
     * PARAM_ERROR 参数错误 请查看err_code_des，修改设置错误的参数
     * SYSTEMERROR 系统繁忙，请再试。 系统繁忙。
     * NOT_FOUND 指定单号数据不存在 查询单号对应的数据不存在，请使用正确的商户订单号查询
     */
    public function gettransferinfo($nonce_str, $partner_trade_no)
    {
        /**
         * 随机字符串 nonce_str 是 5K8264ILTKCH16CQ2502SI8ZNMTM67VS String(32) 随机字符串，不长于32位
         * 签名 sign 是 C380BEC2BFD727A4B6845133519F3AD6 String(32) 生成签名方式查看3.2.1节
         * 商户订单号 partner_trade_no 是 10000098201411111234567890 String(28) 商户调用企业付款API时使用的商户订单号
         * 商户号 mch_id 是 10000098 String(32) 微信支付分配的商户号
         * Appid appid 是 wxe062425f740d30d8 String(32) 商户号的appid
         */
        $postData = array();
        $postData["nonce_str"] = $nonce_str;
        $postData["partner_trade_no"] = $partner_trade_no;
        $postData["mch_id"] = $this->getMchid();
        $postData["appid"] = $this->getAppId();
        
        $sign = $this->getSign($postData);
        $postData["sign"] = $sign;
        $xml = Helpers::arrayToXml($postData);
        $options = array();
        $options['cert'] = $this->getCert();
        $options['ssl_key'] = $this->getCertKey();
        $rst = $this->post($this->_url . 'mmpaymkttransfers/gettransferinfo', $xml, $options);
        return $this->returnResult($rst);
    }

    /**
     * Sign签名生成方法
     *
     * @param array $para            
     * @throws Exception
     * @return string
     */
    public function getSign(array $para)
    {
        /**
         * a.除sign 字段外，对所有传入参数按照字段名的ASCII 码从小到大排序（字典序）后，
         * 使用URL 键值对的格式（即key1=value1&key2=value2…）拼接成字符串string1，
         * 注意： 值为空的参数不参与签名 ；
         */
        // 过滤不参与签名的参数
        $paraFilter = Helpers::paraFilter($para);
        // 对数组进行（字典序）排序
        $paraFilter = Helpers::argSort($paraFilter);
        // 进行URL键值对的格式拼接成字符串string1
        $string1 = Helpers::createLinkstring($paraFilter);
        /**
         * b.
         * 在string1 最后拼接上key=Key(商户支付密钥 ) 得到stringSignTemp 字符串，
         * 并对stringSignTemp 进行md5 运算，再将得到的字符串所有字符转换为大写，得到sign 值signValue。
         */
        $sign = $string1 . '&key=' . $this->getKey();
        $sign = strtoupper(md5($sign));
        
        return $sign;
    }

    /**
     * 通用通知接口
     * 通知参数： 通知参数： 字段名 变量名 必填 类型 说明
     * 返回状态码return_code是String(16)SUCCESS/FAIL此字段是通信标识，非交易标识，交易是否成功需要查微信公众号支付接口文档看result_code来判断
     * 返回信息return_msg否String(128)返回信息，如非空，为错误原因签名失败参数格式校验错误
     * 以下字段在return_code为SUCCESS的时候有返回
     * 公众账号ID appid是String(32)微信分配的公众账号ID
     * 商户号mch_id是String(32)微信支付分配的商户号
     * 设备号device_info否String(32)微信支付分配的终端设备号，
     * 随机字符串nonce_str是String(32)随机字符串，不长于32位
     * 签名sign是String(32)签名,详细签名方法见3.2节
     * 业务结果result_code是String(16)SUCCESS/FAIL
     * 错误代码err_code否String(32)错误码见第6节
     * 错误代码描述err_code_des否String(128)
     * 结果信息描述
     * 以下字段在return_code 和result_code都为SUCCESS的时候有返回
     * 用户标识openid是String(128)用户在商户appid下的唯一标识
     * 是否关注公众账号is_subscribe是String(1)用户是否关注公众账号，Y-关注，N-未关注，仅在公众账号类型支付有效
     * 交易类型trade_type是String(16)JSAPI、NATIVE、MICROPAY、APP
     * 付款银行bank_type是String(16)银行类型，采用字符串类型的银行标识
     * 总金额total_fee是Int订单总金额，单位为分
     * 现金券金额coupon_fee否Int现金券支付金额<=订单总金额，订单总金额-现金券金额为现金支付金额
     * 货币种类fee_type否String(8)货币类型，符合ISO 4217标准的三位字母代码，默认人民币：CNY
     * 微信支付订单号transaction_id是String(32)微信支付订单号
     * 商户订单号out_trade_no是String(32)商户系统的订单号，与请求一致。
     * 商家数据包attach否String(128)商家数据包，原样返回
     * 支付完成时间time_end是String(14)支付完成时间，格式为yyyyMMddhhmmss，如2009年12月27日9点10分10秒表示为20091227091010。时区为GMT+8beijing。该时间取自微信支付服务器
     * 商户处理后同步返回给微信参数：微信公众号支付接口文档
     * 字段名 变量名 必填 类型 说明
     * 返回状态码return_code是String(16)SUCCESS/FAILSUCCESS表示商户接收通知成功并校验成功
     * 返回信息return_msg否String(128)返回信息，如非空，为错误原因签名失败参数格式校验错误
     */
    public function getNotifyData($xml)
    {
        return Helpers::xmlToArray($xml);
    }

    public function returnResult($rst)
    {
        $api_response_xml = $rst;
        $rst = Helpers::xmlToArray($rst);
        if (! empty($rst['return_code'])) {
            if ($rst['return_code'] == 'FAIL') {
                throw new \Exception($rst['return_msg']);
            } else {
                if ($rst['result_code'] == 'FAIL') {
                    throw new \Exception($rst['err_code'] . ":" . $rst['err_code_des']);
                } else {
                    $rst['api_response_xml'] = $api_response_xml;
                    return $rst;
                }
            }
        } else {
            throw new \Exception("网络请求失败");
        }
    }

    /**
     * 获取微信服务器信息
     *
     * @param string $url            
     * @param array $params            
     * @param array $options            
     * @return mixed
     */
    public function get($url, $params = array(), $options = array())
    {
        $client = new Client();
        $params['access_token'] = $this->getAccessToken();
        $request = $client->get($url, array(), array(
            'query' => $params
        ), $options);
        
        $request->getCurlOptions()->set(CURLOPT_SSLVERSION, 1); // CURL_SSLVERSION_TLSv1
        $response = $client->send($request);
        if ($response->isSuccessful()) {
            return $response->getBody(true);
        } else {
            throw new Exception("微信服务器未有效的响应请求");
        }
    }

    /**
     * 推送消息给到微信服务器
     *
     * @param string $url            
     * @param string $xml            
     * @param array $options            
     * @return mixed
     */
    public function post($url, $xml, $options = array())
    {
        $client = new Client();
        $client->setDefaultOption('query', array(
            'access_token' => $this->getAccessToken()
        ));
        $client->setDefaultOption('body', $xml);
        $request = $client->post($url, null, null, $options);
        $request->getCurlOptions()->set(CURLOPT_SSLVERSION, 1); // CURL_SSLVERSION_TLSv1
        $response = $client->send($request);
        if ($response->isSuccessful()) {
            return $response->getBody(true);
        } else {
            throw new Exception("微信服务器未有效的响应请求");
        }
    }

    /**
     * 以下部分的接口基本已废弃,请不要在使用
     */
    public function getPaySignKey()
    {
        return $this->getKey();
    }

    /**
     * 支付签名（paySign）生成方法
     *
     * @param array $para            
     * @throws Exception
     * @return string
     */
    public function getPaySign(array $para)
    {
        return $this->getSign($para);
    }

    /**
     * 获取JS API 时所需的订单详情（package）
     *
     * 在商户调起JS API 时，
     * 商户需要此时确定该笔订单详情，
     * 并将该订单详情通过一定的
     * 方式进行组合放入package。
     * JS API 调用后，微信将通过package 的内容生成预支付单。
     * 下面将定义package的所需字段列表以及签名方法。
     *
     * @param string $body            
     * @param string $attach            
     * @param string $out_trade_no            
     * @param string $total_fee            
     * @param string $notify_url            
     * @param string $spbill_create_ip            
     * @param string $time_start            
     * @param string $time_expire            
     * @param string $transport_fee            
     * @param string $product_fee            
     * @param string $goods_tag            
     * @param string $bank_type            
     * @param string $fee_type            
     * @param string $input_charset            
     * @return string
     */
    public function getPackage4JsPay($body, $attach, $out_trade_no, $total_fee, $notify_url, $spbill_create_ip, $time_start, $time_expire, $transport_fee, $product_fee, $goods_tag, $bank_type = "WX", $fee_type = 1, $input_charset = "GBK", $device_info = "", $nonce_str = "", $openid = "")
    {
        $ret = $this->unifiedorder($device_info, $nonce_str, $body, $attach, $out_trade_no, $total_fee, $spbill_create_ip, $time_start, $time_expire, $goods_tag, $notify_url, "JSAPI", $openid, "");
        
        return "prepay_id={$ret['prepay_id']}";
    }

    /**
     * 获取Native（原生）支付URL定义
     *
     * @param string $productid            
     * @param string $noncestr            
     * @param string $timestamp            
     * @return string
     */
    public function getNativePayUrl($productid, $noncestr, $timestamp)
    {
        return "";
    }

    /**
     * Native（原生）支付回调商户后台获取package 在公众平台接到用户点击上述特殊Native（原生）支付的URL
     * 之后，会调用注册时填写的商家获取订单Package 的回调URL。 假设回调URL
     * 为https://www.outdomain.com/cgi-bin/bizpay337Getpackage
     *
     *
     * @param string $package            
     * @param string $noncestr            
     * @param string $timestamp            
     * @param string $SignMethod            
     * @param string $retcode            
     * @param string $reterrmsg            
     * @return string
     */
    public function getPackageForNativeUrl($package, $noncestr, $timestamp, $SignMethod = "sha1", $retcode = 0, $reterrmsg = "ok")
    {
        return "";
    }

    /**
     * package 生成方法
     *
     * @param array $para            
     * @throws Exception
     * @return string
     */
    public function createPackage(array $para)
    {
        return "";
    }

    /**
     * 标记客户的投诉处理状态。 updatefeedback
     *
     *
     * @param string $openid            
     * @param string $feedbackid            
     * @throws Exception
     * @return Ambigous <mixed, string>
     */
    public function updateFeedback($openid, $feedbackid)
    {}
}