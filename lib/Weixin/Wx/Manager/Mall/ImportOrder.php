<?php
namespace Weixin\Wx\Manager\Mall;

use Weixin\Client;

/**
 * 已购订单
 *
 * @author guoyongrong <handsomegyr@gmail.com>
 * @author young <youngyang@icatholic.net.cn>
 */
class ImportOrder
{

    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 导入“已购订单”
     * 开发者可以在用户支付完成后，同步订单数据至“已购订单”，同时支持历史订单的导入，接口说明如下：
     *
     * 接口调用基本信息 说明
     * 协议 https
     * http请求方式 POST
     * 请求URL https://api.weixin.qq.com/mall/importorder?action=add-order&access_token=ACCESS_TOKEN
     * POST数据格式 json
     * 接口能力 导入订单数据
     * 接口调用时机 用户完成支付
     * 请求数据样例
     * 示例代码
     * {
     * "order_list": [
     * {
     * "order_id": "AQAATGagQ7KQCxMJEj7kHuUjTxxx",
     * "create_time": 1527584231,
     * "pay_finish_time": 1527584244,
     * "desc": "xx微主页",
     * "fee": 1,
     * "trans_id": "4200000144201807116521229xxx",
     * "status": 3,
     * "ext_info": {
     * "product_info": {
     * "item_list": [
     * {
     * "item_code": "00003563372839_00000010001xxx",
     * "sku_id": "00003563372839_10000010014xxx",
     * "amount": 1,
     * "total_fee": 1,
     * "thumb_url": "https://shp.qpic.cn/wechat_bs/0/4eb3dcee0edcd34939b87f232e9fxxxx",
     * "title": "潮流T恤",
     * "desc": "xxxx",
     * "unit_price": 1,
     * "original_price": 2,
     * "stock_attr_info": [
     * {
     * "attr_name": {
     * "name": "尺码"
     * },
     * "attr_value": {
     * "name": "L"
     * }
     * }
     * ],
     * "category_list": [
     * "衣服",
     * "T-shirt"
     * ],
     * "item_detail_page": {
     * "path": "/portal/xxxx/detail?code=00003563372839_00000010001xxx"
     * }
     * }
     * ]
     * },
     * "express_info": {
     * "name": "测试用户",
     * "phone": "158xxxxxx",
     * "address": "广东省广州市tit创意园品牌街腾讯微信总部",
     * "price": 0,
     * "national_code": "440105",
     * "country": "中国",
     * "province": "广东省",
     * "city": "广州市",
     * "district": "海珠区",
     * "express_package_info_list": [
     * {
     * "express_company_id": 2001,
     * "express_company_name": "圆通",
     * "express_code": "88627337387xxx",
     * "ship_time": 1517713509,
     * "express_page": {
     * "path": "/libs/xxxxx/portal/express-detail/xxxxx"
     * },
     * "express_goods_info_list": [
     * {
     * "item_code": "00003563372839_00000010001xxx",
     * "sku_id": "00003563372839_10000010014xxx"
     * }
     * ]
     * }
     * ]
     * },
     * "promotion_info": {
     * "discount_fee": 1
     * },
     * "brand_info": {
     * "phone": "12345678",
     * "contact_detail_page": {
     * "path": "/libs/xxxxx/portal/contact_detail/xxxx"
     * }
     * },
     * "invoice_info": {
     * "type": 0,
     * "title": "xxxxxx",
     * "tax_number": "xxxxxx",
     * "company_address": "xxxxxx",
     * "telephone": "020-xxxxxx",
     * "bank_name": "招商银行",
     * "bank_account": "xxxxxxxx",
     * "invoice_detail_page": {
     * "path": "/libs/xxxxx/portal/invoice-detail/xxxxx"
     * }
     * },
     * "payment_method": 1,
     * "user_open_id": "xxxxxxx",
     * "order_detail_page": {
     * "path": "/libs/xxxxx/portal/order-detail/xxxxx"
     * }
     * }
     * }
     * ]
     * }
     * 添加订单参数列表
     * 订单基本字段 必填 字段类型 说明
     * order_list 是 array 单次请求订单数量不可超过10单
     * order_list字段 必填 字段类型 说明
     * order_id 是 string 订单id，需要保证唯一性
     * create_time 是 uint32 订单创建时间，unix时间戳
     * pay_finish_time 是 uint32 支付完成时间，unix时间戳
     * desc 否 string 订单备注
     * fee 是 uint32 订单金额，单位：分
     * trans_id 否 string 微信支付订单id，对于使用微信支付的订单，该字段必填
     * status 是 uint32 订单状态，3：支付完成 4：已发货 5：已退款 100: 已完成
     * ext_info 是 object 订单扩展信息
     * ext_info字段 必填 字段类型 说明
     * product_info 是 object 商品相关信息
     * express_info 是 object 快递信息
     * promotion_info 否 object 订单优惠信息
     * brand_info 是 object 商家信息
     * invoice_info 否 object 发票信息，对于开发票订单，该字段必填
     * payment_method 是 uint32 订单支付方式，0：未知方式 1：微信支付 2：其他支付方式
     * user_open_id 是 string 用户openid
     * order_detail_page 是 object 订单详情页（小程序页面）
     * product_info字段 必填 字段类型 说明
     * item_list 是 array 包含订单中所有商品的信息
     * item_list字段 必填 字段类型 说明
     * item_code 是 string 商品id
     * sku_id 是 string sku_id
     * amount 是 uint32 商品数量
     * total_fee 是 uint32 商品总价，单位：分
     * thumb_url 否 string 商品缩略图url
     * title 是 string 商品名称
     * desc 否 string 商品详细描述
     * unit_price 是 uint32 商品单价（实际售价），单位：分
     * original_price 是 uint32 商品原价，单位：分
     * stock_attr_info 否 array 商品属性列表
     * category_list 是 array 商品类目列表
     * item_detail_page 是 object 商品详情页（小程序页面）
     * stock_attr_info字段 必填 字段类型 说明
     * attr_name 是 object 属性名
     * attr_value 是 object 属性值
     * attr_name字段 必填 字段类型 说明
     * name 是 string 属性名称
     * attr_value字段 必填 字段类型 说明
     * name 是 string 属性值
     * item_detail_page字段 必填 字段类型 说明
     * path 是 string 商品详情页跳转链接（小程序页面）
     * express_info字段 必填 字段类型 说明
     * name 否 string 收件人姓名
     * phone 否 string 收件人联系电话
     * address 否 string 收件人地址
     * price 是 uint32 运费，单位：分
     * national_code 否 string 行政区划代码
     * country 否 string 国家
     * province 否 string 省份
     * city 否 string 城市
     * district 否 string 区
     * express_package_info_list 否 array 包裹中的商品信息
     * express_package_info_list字段 必填 字段类型 说明
     * express_company_id 是 uint32 快递公司id
     * express_company_name 是 string 快递公司名
     * express_code 是 string 快递单号
     * ship_time 是 uint32 发货时间，unix时间戳
     * express_page 是 object 快递详情页（小程序页面）
     * express_goods_info_list 是 array 包裹商品信息
     * express_page字段 必填 字段类型 说明
     * path 是 string 快递详情页跳转链接（小程序页面）
     * express_goods_info_list字段 必填 字段类型 说明
     * item_code 是 string 商品id
     * sku_id 是 string sku_id
     * promotion_info字段 必填 字段类型 说明
     * discount_fee 是 uint32 优惠金额
     * invoice_info字段 必填 字段类型 说明
     * type 是 uint32 抬头类型，0：单位，1：个人
     * title 是 string 发票抬头
     * tax_number 否 string 发票税号
     * company_address 否 string 单位地址
     * telephone 否 string 手机号码
     * bank_name 否 string 银行名称
     * bank_account 否 string 银行账号
     * invoice_detail_page 否 object 发票详情页（小程序页面）
     * brand_info字段 必填 字段类型 说明
     * phone 是 string 联系电话，必须提供真实有效的联系电话，缺少联系电话或联系电话不正确将影响商品曝光
     * contact_detail_page 是 object 联系商家页面
     * invoice_detail_page字段 必填 字段类型 说明
     * path 是 string 发票详情页跳转链接（小程序页面）
     * order_detail_page字段 必填 字段类型 说明
     * path 是 string 订单详情页跳转链接（小程序页面）
     * contact_detail_page字段 必填 字段类型 说明
     * path 是 string 联系商家页跳转链接（小程序页面）
     * 回包数据样例
     * 接口调用成功回包
     * {
     * "errcode":0,
     * "errmsg":"success"
     * }
     * 接口调用失败回包
     * {
     * "errcode": 9019101,
     * "errmsg":"订单数量超过限制"
     * }
     * 回包字段 类型 说明
     * errcode int32 错误码
     * errmsg string 错误信息
     * fail_order_list object 失败订单信息
     * fail_order_list字段 类型 说明
     * order_id string 失败订单ID
     * error_code int32 订单错误码
     * msg string 错误提示
     * 接口错误码
     * 回包错误码 说明
     * 0 成功
     * 9009099 系统错误
     * 9009098 请求参数错误
     * 9009400 订单数量超过限制
     * 订单错误码 说明
     * -1 系统错误
     * -2 订单参数错误
     */
    public function add($order_list)
    {
        $params = array();
        $params_order_list = array();
        foreach ($order_list as $order) {
            $params_order_list[] = $order->getParams();
        }
        $params['order_list'] = $params_order_list;
        
        $headers = array();
        $rst = $this->_request->post2('mall/importorder?action=add-order', $params, $headers);
        return $this->_client->rst($rst);
    }

    /**
     * 更新订单信息
     * 开发者可以对“已购订单”中的订单信息进行更新，如订单状态改变等；接口说明如下：
     *
     * 接口调用基本信息 说明
     * 协议 https
     * http请求方式 POST
     * 请求URL https://api.weixin.qq.com/mall/importorder?action=update-order&access_token=ACCESS_TOKEN
     * POST数据格式 json
     * 接口能力 更新订单数据
     * 接口调用时机 商户发货、用户退款完成、订单已完成
     * 请求数据样例
     * {
     * "order_list": [
     * {
     * "order_id": "AQAATGagQ7KQCxMJEj7kHuUjTxxx",
     * "trans_id": "4200000144201807116521229xxx",
     * "status": 4,
     * "ext_info": {
     * "express_info": {
     * "name": "测试用户",
     * "phone": "158xxxxxx",
     * "address": "广东省广州市tit创意园品牌街腾讯微信总部",
     * "price": 0,
     * "national_code": "440105",
     * "country": "中国",
     * "province": "广东省",
     * "city": "广州市",
     * "district": "海珠区",
     * "express_package_info_list": [
     * {
     * "express_company_id": 2001,
     * "express_company_name": "圆通",
     * "express_code": "88627337387xxx",
     * "ship_time": 1517713509,
     * "express_page": {
     * "path": "/libs/xxxxx/portal/express-detail/xxxxx"
     * },
     * "express_goods_info_list": [
     * {
     * "item_code": "00003563372839_00000010001xxx",
     * "sku_id": "00003563372839_10000010014xxx"
     * }
     * ]
     * }
     * ]
     * },
     * "invoice_info": {
     * "type": 0,
     * "title": "xxxxxx",
     * "tax_number": "xxxxxx",
     * "company_address": "xxxxxx",
     * "telephone": "020-xxxxxx",
     * "bank_name": "招商银行",
     * "bank_account": "xxxxxxxx",
     * "invoice_detail_page": {
     * "path": "/libs/xxxxx/portal/invoice-detail/xxxxx"
     * }
     * },
     * "user_open_id": "xxxxxxx",
     * "order_detail_page": {
     * "path": "/libs/xxxxx/portal/order-detail/xxxxx"
     * }
     * }
     * }
     * ]
     * }
     * 请求数据字段说明
     * 订单基本字段 必填 字段类型 说明
     * order_list 是 array 单次请求订单数量不可超过10单
     * order_list字段 必填 字段类型 说明
     * order_id 是 string 订单ID，需要保证唯一性
     * trans_id 否 string 微信支付订单ID，对于使用微信支付的订单，该字段必填
     * status 是 uint32 订单状态，4：已发货 5：已退款 12：已取消 100: 已完成
     * ext_info 是 object 订单扩展信息
     * ext_info字段 必填 字段类型 说明
     * express_info 否 object 快递信息，对于已发货订单，该字段必填
     * invoice_info 否 object 发票信息，对于已开发票订单，该字段必填
     * user_open_id 是 string 用户微信openid
     * order_detail_page 否 object 订单详情页（小程序页面）
     * express_info字段 必填 字段类型 说明
     * name 否 string 收件人姓名
     * phone 否 string 收件人联系电话
     * address 否 string 收件人地址
     * price 是 uint32 运费，单位：分
     * national_code 否 string 行政区划代码
     * country 否 string 国家
     * province 否 string 省份
     * city 否 string 城市
     * district 否 string 区
     * express_package_info_list 是 array 包裹信息
     * express_package_info_list字段 必填 字段类型 说明
     * express_company_id 是 uint32 快递公司id
     * express_company_name 是 string 快递公司名
     * express_code 是 string 快递单号
     * ship_time 是 uint32 发货时间，unix时间戳
     * express_page 是 object 快递详情页（小程序）
     * express_goods_info_list 是 array 包裹中的商品信息
     * express_page字段 必填 字段类型 说明
     * path 是 string 快递详情页跳转链接（小程序页面）
     * express_goods_info_list字段 必填 字段类型 说明
     * item_code 是 string 商品id
     * sku_id 是 string sku_id
     * invoice_info字段 必填 字段类型 说明
     * type 是 uint32 抬头类型，0：单位，1：个人
     * title 是 string 发票抬头
     * tax_number 否 string 发票税号
     * company_address 否 string 单位地址
     * telephone 否 string 手机号码
     * bank_name 否 string 银行名称
     * bank_account 否 string 银行账号
     * invoice_detail_page 否 object 发票详情页（小程序页面）
     * invoice_detail_page字段 必填 字段类型 说明
     * path 是 string 发票详情页跳转链接（小程序页面）
     * order_detail_page字段 必填 字段类型 说明
     * path 是 string 订单详情页跳转链接（小程序页面）
     * 快递公司信息
     * 目前支持的快递公司及其对应的编号如下：
     *
     * 快递公司编号字段 快速公司名字字段
     * 2000 EMS
     * 2001 圆通
     * 2002 DHL
     * 2004 中通
     * 2005 韵达
     * 2006 畅灵
     * 2008 百世汇通
     * 2009 德邦
     * 2010 申通
     * 2011 顺丰速运
     * 2012 顺兴
     * 2014 如风达
     * 2015 优速
     * 9999 其他快递公司名字（例如：京东物流）
     * 回包数据样例
     * 接口调用成功回包
     * {
     * "errcode":0,
     * "errmsg":"success"
     * }
     * 接口调用失败回包
     * {
     * "errcode": 9019102,
     * "errmsg":"部分订单更新失败"
     *
     * "fail_order_list":[
     * {
     * "order_id":"AQAATGagQ7KQCxMJEj7kHuUjTxxx",
     * "error_code": 10001,
     * "msg":"订单不存在，无法更新"
     * }
     * ]
     * }
     * 回包字段 类型 说明
     * errcode int32 错误码
     * errmsg string 错误信息
     * fail_order_list object 失败订单信息
     * fail_order_list字段 类型 说明
     * order_id string 失败订单id
     * error_code int32 订单错误码
     * msg string 错误提示
     * 接口错误码
     * 回包错误码 说明
     * 0 成功
     * 9009099 系统错误
     * 9009098 请求参数错误
     * 9009300 订单数量超过限制
     * 9009301 部分订单更新失败
     * 订单错误码 说明
     * -1 系统错误
     * -2 订单参数错误
     * 10001 订单不存在，无法更新
     * 10002 订单字段冲突
     */
    public function update($order_list)
    {
        $params = array();
        $params_order_list = array();
        foreach ($order_list as $order) {
            $params_order_list[] = $order->getParams();
        }
        $params['order_list'] = $params_order_list;
        $headers = array();
        $rst = $this->_request->post2('mall/importorder?action=update-order', $params, $headers);
        return $this->_client->rst($rst);
    }

    /**
     * 删除“已购订单”
     * 用户可以对“已购订单”中的订单进行删除；接口说明如下：
     *
     * 接口调用基本信息 说明
     * 协议 https
     * http请求方式 POST
     * 请求URL https://api.weixin.qq.com/mall/deleteorder?access_token=ACCESS_TOKEN
     * POST数据格式 json
     * 接口能力 删除订单数据
     * 接口调用时机 用户删除订单
     * 请求数据样例
     * {
     * "user_open_id": "xxxxxxxxxxxxxxxxxxxxxxxxx",
     * "order_id": "xxxxxxxxxxxxxxxxxxxxxxxxxxx"
     * }
     * 请求数据字段说明
     * 基本字段 必填 字段类型 说明
     * user_open_id 是 string 用户微信openid
     * order_id 是 string 订单号
     * |
     * 回包数据样例
     * 接口调用成功回包
     * {
     * "errcode":0,
     * "errmsg":"success"
     * }
     * 接口调用失败回包
     * {
     * "errcode": 9009098,
     * "errmsg": "req required field order_id"
     * }
     * 回包字段 类型 说明
     * errcode int32 错误码
     * errmsg string 错误信息
     * 接口错误码
     * 回包错误码 说明
     * 0 成功
     * 9009099 系统错误
     * 9009098 请求参数错误
     */
    public function delete($user_open_id, $order_id)
    {
        $params = array();
        $params['user_open_id'] = $user_open_id;
        $params['order_id'] = $order_id;
        $headers = array();
        $rst = $this->_request->post2('mall/deleteorder', $params, $headers);
        return $this->_client->rst($rst);
    }
}
