<?php
namespace Weixin;

use Weixin\Helpers;
use Weixin\Exception;
use Weixin\Http\Request;

/**
 * 微信支付接口
 *
 * @author guoyongrong <handsomegyr@gmail.com>
 */
class Pay337
{

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
     * Mchid
     * 商户 ID ，身份标识
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
     * Key
     * 商户支付密钥。登录微信商户后台，进入栏目【账设置】【密码安全】【 API密钥】，进入设置 API密钥。
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

    public function getPaySignKey()
    {
        return $this->getKey();
    }

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
    
    // access_token微信公众平台凭证。
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

    private $_request = null;

    /**
     * 初始化认证的http请求对象
     */
    private function initRequest()
    {
        $this->_request = new Request($this->getAccessToken());
    }

    /**
     * 获取请求对象
     *
     * @return \Weixin\Http\Request
     */
    public function getRequest()
    {
        if (empty($this->_request)) {
            $this->initRequest();
        }
        return $this->_request;
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
        $xml = $this->arrayToXml($postData);
        $rst = $this->getRequest()->pay337Post('pay/unifiedorder', $xml);
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
        $xml = $this->arrayToXml($postData);
        $rst = $this->getRequest()->pay337Post('pay/orderquery', $xml);
        return $this->returnResult($rst);
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
        return $this->xmlToArray($xml);
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

    private function returnResult($rst)
    {
        $rst = $this->xmlToArray($rst);
        if (! empty($rst['return_code'])) {
            if ($rst['return_code'] == 'FAIL') {
                throw new \Exception($rst['return_msg']);
            } else {
                if ($rst['result_code'] == 'FAIL') {
                    throw new \Exception($rst['err_code_des'], $rst['err_code']);
                } else {
                    return $rst;
                }
            }
        } else {
            throw new \Exception("网络请求失败");
        }
    }

    /**
     * 作用：array转xml
     */
    private function arrayToXml($arr)
    {
        $xml = "<xml>";
        foreach ($arr as $key => $val) {
            if (is_numeric($val)) {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            } else
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
        }
        $xml .= "</xml>";
        return $xml;
    }

    /**
     * 作用：将xml转为array
     */
    private function xmlToArray($xml)
    {
        $object = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        return @json_decode(preg_replace('/{}/', '""', @json_encode($object)), 1);
    }
}

