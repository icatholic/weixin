<?php
namespace Weixin\Manager;

use Weixin\Client;

/**
 * 礼品卡
 *
 * @author guoyongrong <handsomegyr@gmail.com>
 * @author young <youngyang@icatholic.net.cn>
 */
class Giftcard
{

    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 5.2 创建-礼品卡货架接口
     * 接口说明
     * 开发者可以通过该接口创建一个礼品卡货架并且用于公众号、门店的礼品卡售卖。
     * 接口调用请求说明
     * 协议 HTTPS
     * http请求方式 POST
     * 请求Url https://api.weixin.qq.com/card/giftcard/page/add?access_token=ACCESS_TOKEN
     * POST数据格式 JSON
     * 请求参数说明
     * 参数 说明 是否必填
     * access_token 调用接口凭证 是
     * JSON JSON数据 是
     *
     * POST数据示例：
     * {
     * "page": {
     * "page_title": "礼品卡"
     * "banner_pic_url": "http://mmbiz.qpic.cn/mmbiz_jpg/p98FjXy8LafBWIJsGFe7tlPvtBFxXXTPdx5cEuFMcWWsiaR1DyrN5ML3jiaVYZibovA8OrwOylUia6ywvVU6Aqboibw/0",
     * "theme_list": [
     * {
     * "theme_pic_url": "http://mmbiz.qpic.cn/mmbiz_jpg/p98FjXy8LafBWIJsGFe7tlPvtBFxXXTPdx5cEuFMcWWsiaR1DyrN5ML3jiaVYZibovA8OrwOylUia6ywvVU6Aqboibw/0",
     * "title": "title",
     * "title_color": "#FB966E",
     * "show_sku_title_first": true,
     * "item_list": [
     * {
     * "card_id": "pbLatjiSj_yVRH5XTb2Zsln7DNQg",
     * "title":"焦糖拿铁"
     * },
     * {
     * "card_id": "pbLatjlq75CPBR_tYCRdPlxSGlOs",
     * "title":"焦糖拿铁"
     * }
     * ],
     * "pic_item_list": [
     * {
     * "background_pic_url": "http://mmbiz.qpic.cn/mmbiz_jpg/p98FjXy8LafBWIJsGFe7tlPvtBFxXXTPdx5cEuFMcWWsiaR1DyrN5ML3jiaVYZibovA8OrwOylUia6ywvVU6Aqboibw/0",
     * "default_gifting_msg": "祝福语1"
     * },
     * {
     * "background_pic_url": "http://mmbiz.qpic.cn/mmbiz_jpg/p98FjXy8LafBWIJsGFe7tlPvtBFxXXTPdx5cEuFMcWWsiaR1DyrN5ML3jiaVYZibovA8OrwOylUia6ywvVU6Aqboibw/0",
     * "default_gifting_msg": "祝福语2"
     * },
     * {
     * "background_pic_url": "http://mmbiz.qpic.cn/mmbiz_jpg/p98FjXy8LafBWIJsGFe7tlPvtBFxXXTPdx5cEuFMcWWsiaR1DyrN5ML3jiaVYZibovA8OrwOylUia6ywvVU6Aqboibw/0",
     * "default_gifting_msg": "祝福语3"
     * }
     * ],
     * "category_index": 0
     * },
     * {
     * "theme_pic_url": "http://mmbiz.qpic.cn/mmbiz_jpg/p98FjXy8LafBWIJsGFe7tlPvtBFxXXTPdx5cEuFMcWWsiaR1DyrN5ML3jiaVYZibovA8OrwOylUia6ywvVU6Aqboibw/0",
     * "title": "title_lalala",
     * "title_color": "#FB966E",
     * "item_list": [
     * {
     * "card_id": "pbLatjiSj_yVRH5XTb2Zsln7DNQg",
     * "title":"焦糖拿铁"
     * },
     * {
     * "card_id": "pbLatjlq75CPBR_tYCRdPlxSGlOs",
     * "title":"蛋糕"
     * }
     * ],
     * "pic_item_list": [
     * {
     * "background_pic_url": "http://mmbiz.qpic.cn/mmbiz_jpg/p98FjXy8LafBWIJsGFe7tlPvtBFxXXTPdx5cEuFMcWWsiaR1DyrN5ML3jiaVYZibovA8OrwOylUia6ywvVU6Aqboibw/0",
     * "default_gifting_msg": "祝福语1",
     * "outer_img_id": "outer_img_id_1"
     * },
     * {
     * "background_pic_url": "http://mmbiz.qpic.cn/mmbiz_jpg/p98FjXy8LafBWIJsGFe7tlPvtBFxXXTPdx5cEuFMcWWsiaR1DyrN5ML3jiaVYZibovA8OrwOylUia6ywvVU6Aqboibw/0",
     * "default_gifting_msg": "祝福语2",
     * "outer_img_id": "outer_img_id_2"
     * },
     * {
     * "background_pic_url": "http://mmbiz.qpic.cn/mmbiz_jpg/p98FjXy8LafBWIJsGFe7tlPvtBFxXXTPdx5cEuFMcWWsiaR1DyrN5ML3jiaVYZibovA8OrwOylUia6ywvVU6Aqboibw/0",
     * "default_gifting_msg": "祝福语3",
     * "outer_img_id": "outer_img_id_3"
     * }
     * ],
     * "category_index": 1
     * },
     * {
     * "theme_pic_url": "http://mmbiz.qpic.cn/mmbiz_jpg/p98FjXy8LafBWIJsGFe7tlPvtBFxXXTPdx5cEuFMcWWsiaR1DyrN5ML3jiaVYZibovA8OrwOylUia6ywvVU6Aqboibw/0",
     * "title": "title_lalala",
     * "title_color": "#FB966E",
     * "item_list": [
     * {
     * "card_id": "pbLatjiSj_yVRH5XTb2Zsln7DNQg"
     * },
     * {
     * "card_id": "pbLatjlq75CPBR_tYCRdPlxSGlOs"
     * }
     * ],
     * "pic_item_list": [
     * {
     * "background_pic_url": "http://mmbiz.qpic.cn/mmbiz_jpg/p98FjXy8LafBWIJsGFe7tlPvtBFxXXTPdx5cEuFMcWWsiaR1DyrN5ML3jiaVYZibovA8OrwOylUia6ywvVU6Aqboibw/0",
     * "default_gifting_msg": "祝福语1",
     * "outer_img_id": "outer_img_id_1"
     * },
     * {
     * "background_pic_url": "http://mmbiz.qpic.cn/mmbiz_jpg/p98FjXy8LafBWIJsGFe7tlPvtBFxXXTPdx5cEuFMcWWsiaR1DyrN5ML3jiaVYZibovA8OrwOylUia6ywvVU6Aqboibw/0",
     * "default_gifting_msg": "祝福语2",
     * "outer_img_id": "outer_img_id_2"
     * },
     * {
     * "background_pic_url": "http://mmbiz.qpic.cn/mmbiz_jpg/p98FjXy8LafBWIJsGFe7tlPvtBFxXXTPdx5cEuFMcWWsiaR1DyrN5ML3jiaVYZibovA8OrwOylUia6ywvVU6Aqboibw/0",
     * "default_gifting_msg": "祝福语3",
     * "outer_img_id": "outer_img_id_3"
     * }
     * ],
     * "is_banner": true
     * }
     * ],
     * "category_list": [
     * {
     * "title": "主题分类一"
     * },
     * {
     * "title": "主题分类二"
     * }
     * ],
     * "address": "广州市海珠区222号",
     * "service_phone": "020-12345678",
     * "biz_description": "退款指引",
     * "cell_1": {
     * "title": "申请发票",
     * "url": "https://open.weixin.qq.com"
     * },
     * "cell_2": {
     * "title": "申请退款",
     * "url": "https://mp.weixin.qq.com"
     * }
     * }
     * }
     *
     * 请求数据说明：
     *
     * 参数 说明 是否必填
     * page 货架信息结构体，包含以下字段 是
     * * 　 page_title 礼品卡货架名称 是
     * banner_pic_url 礼品卡货架主题页顶部banner图片，须先将图片上传至CDN，建议尺寸为750px*630px 是
     * theme_list 主题结构体，是一个JSON结构 是
     * category_list 主题分类列表 否
     * address 商家地址 是
     * service_phone 商家服务电话 是
     * biz_description 商家使用说明，用于描述退款、发票等流程 是
     * need_receipt 该货架的订单是否支持开发票，填true或者false，若填true则需要调试文档2.2的流程，默认为false 否
     * cell_1 商家自定义链接，用于承载退款、发票等流程 是
     * cell_2 商家自定义链接，用于承载退款、发票等流程 是
     * theme_list是一个JSON结构，包含以下字段
     * 参数 说明 是否必填
     * theme_list 主题结构体，包含以下字段 是
     * * 　 theme_pic_url 主题的封面图片，须先将图片上传至CDN
     * 大小控制在1000px*600px 是
     * title 主题名称，如“圣诞”“感恩家人” 是
     * title_color 主题title的颜色，直接传入色值 是
     * item_list 礼品卡列表，标识该主题可选择的面额 是
     * pic_item_list 封面列表 是
     * category_index 主题标号，对应category_list内的title字段，
     * 若填写了category_list则每个主题必填该序号 是
     * show_sku_title_first 该主题购买页是否突出商品名显示 否
     * is_banner 是否将当前主题设置为banner主题（主推荐） 否
     *
     * item_list和pic_item_list是JSON结构，包含以下字段
     * 参数 说明 是否必填
     * item_list 商品结构体，包含以下字段 是
     * * 　 card_id 待上架的card_id 是
     * title 商品名，不填写默认为卡名称 否
     * pic_item_list 卡面结构体，包含以下字段 是
     * * 　 background_pic_url 卡面图片，须先将图片上传至CDN，大小控制在1000像素*600像素以下 是
     * outer_img_id 自定义的卡面的标识 否
     * default_gifting_msg 该卡面对应的默认祝福语，当用户没有编辑内容时会随卡默认填写为用户祝福内容 是
     *
     * cell1和cell2是JSON结构，包含以下字段
     * 参数 说明 是否必填
     * cell 商户自定义服务入口结构体，包含以下字段 是
     * * 　 title 自定义入口名称 是
     * url 自定义入口链接 是
     *
     * category_list是JSON结构，包含以下字段
     * 参数 说明 是否必填
     * category_list 主题分类排序结构体，包含以下字段 否
     * * 　 title 主题分类的名称 否
     *
     * 返回参数说明
     * 返回数据示例：
     * {
     * "errcode" : 0,
     * "errmsg" : "ok",
     * "page_id" : "abcedfghifk=+Uasdaseq14fadkf8123h4jk"
     * }
     * 返回数据说明：
     * 字段 说明
     * errcode 错误码，0为正常
     * errmsg 错误信息
     * page_id 货架的id，用于查询货架详情以及获得货架访问链接
     *
     * 注意事项
     * 1.货架链接拼接规则
     * 将page_id进行[UrlEncode](http://tool.chinaz.com/Tools/urlencode.aspx)之后**替换到以下链接的page_id参数的值即可访问商城页首页。
     * https://mp.weixin.qq.com/bizmall/giftcard?action=homepage&page_id=123456#wechat_redirect
     * 如page_id为：abcedfghifk=+Uasdaseq14fadkf8123h4jk
     * UrlEncode之后：abcedfghifk%3d%2bUasdaseq14fadkf8123h4jk
     * 加入链接后：
     * https://mp.weixin.qq.com/bizmall/giftcard?action=homepage&page_id= abcedfghifk%3d%2bUasdaseq14fadkf8123h4jk #wechat_redirect
     * 2. 关于渠道统计
     * 提供outer_str字段做渠道区分，将会在页面中流转，后面在查询订单的api中或者相关callback中都能获取到对应字段。
     * 例如outer_str=abc：
     * 则上述链接变为:
     * https://mp.weixin.qq.com/bizmall/giftcard?action=homepage&page_id=123456&outer_str=abc#wechat_redirect
     * 如page_id为：abcedfghifk=+Uasdaseq14fadkf8123h4jk
     * UrlEncode之后：abcedfghifk%3d%2bUasdaseq14fadkf8123h4jk
     * 加入链接后：
     * https://mp.weixin.qq.com/bizmall/giftcard?action=homepage&page_id=abcedfghifk%3d%2bUasdaseq14fadkf8123h4jk#wechat_redirect
     * 3.货架外链跳转协议
     * cell中的url，跳转时会在GET参数中带入order_id和openid
     * 比如原本数据是
     * https://mp.weixin.qq.com 将会变成
     * https://mp.weixin.qq.com/?order_id=Z2y2rY4UxUZYitvVGA&openid=oAAAAAKe1ri5AAaAiB50-Ak6Vs1w
     * 4.设置审核白名单
     * 创建后的货架处于待审核状态，不可被外界查看购买，须商户申请上线并审核通过后方可完成。
     * 开发人员可以将自己的微信号设置为白名单，用于测试流程，接口参见：[mp.weixin.qq.com]-[卡券部分]-[投放卡券]-[设置卡券白名单]
     */
    public function pageAdd(\Weixin\Model\GiftCard\Page $page)
    {
        $params = array();
        $params['page'] = $page->getParams();
        $rst = $this->_request->payPost('card/giftcard/page/add', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 5.3 查询-礼品卡货架信息接口
     * 接口说明
     * 开发者可以查询某个礼品卡货架信息。
     * 接口调用请求说明
     * 协议 HTTPS
     * http请求方式 POST
     * 请求Url https://api.weixin.qq.com/card/giftcard/page/get?access_token=ACCESS_TOKEN
     * POST数据格式 JSON
     * 请求参数说明
     * 参数 说明 是否必填
     * access_token 调用接口凭证 是
     * JSON JSON数据 是
     *
     * POST数据示例：
     * {
     * "page_id" : "abcedfghifk=+Uasdaseq14fadkf8123h4jk"
     * }
     *
     * 请求数据说明：
     *
     * 参数 说明 是否必填
     * page_id 上一步获取到货架id 是
     *
     * 返回参数说明
     * 返回数据示例：
     * {
     * "errcode" : 0,
     * "errmsg" : "ok",
     * "page" : {
     * "banner_pic_url" : "http://img.com/banner_pic",
     * "theme_list" : [
     * {
     * "theme_pic_url" : "http://img.com/theme_pic",
     * "title" : "title_lalala",
     * "title_color" : "#FFFFFF",
     * "item_list" : [
     * {
     * "card_id" : "card_id_lalala"
     * }
     * ],
     * "pic_item_list" :[
     * {
     * "background_pic_url" : "http://img.com/bg_pic1",
     * "default_gifting_msg" : "祝福语1"
     * },
     * {
     * "background_pic_url" : "http://img.com/bg_pic2",
     * "default_gifting_msg" : "祝福语2"
     * },
     * {
     * "background_pic_url" : "http://img.com/bg_pic3",
     * "default_gifting_msg" : "祝福语3"
     * }
     * ]
     * }
     * ]
     * }
     * }
     *
     *
     *
     *
     *
     * 返回数据说明：
     * 参数 说明
     * errcode 错误码
     * errmsg 错误信息
     * page 货架信息结构体，包含以下字段
     * * 　 banner_pic_url 礼品卡货架主题页顶部banner图片，须先将图片上传至CDN
     * theme_list 主题结构体，是一个JSON结构
     * category_list 主题分类列表
     * address 商家地址
     * service_phone 商家服务电话
     * biz_description 商家使用说明，用于描述退款、发票等流程
     * cell_1 商家自定义链接，用于承载退款、发票等流程
     * cell_2 商家自定义链接，用于承载退款、发票等流程
     * theme_list是一个JSON结构，包含以下字段
     * 参数 说明
     * theme_list 主题结构体，包含以下字段
     * * 　 theme_pic_url 主题的封面图片，须先将图片上传至CDN
     * title 主题名称，如“圣诞”“感恩家人”
     * title_color 主题title的颜色，直接传入色值
     * item_list 礼品卡列表，标识该主题可选择的面额
     * pic_item_list 封面列表
     * category_index 主题标号，对应category_list内的title字段，
     * 若填写了category_list则每个主题必填该序号
     * is_banner 是否将当前主题设置为banner主题（主推荐）
     *
     * item_list和pic_item_list是JSON结构，包含以下字段
     * 参数 说明
     * item_list 商品结构体，包含以下字段
     * * 　 card_id 待上架的card_id
     * pic_item_list 卡面结构体，包含以下字段
     * * 　 background_pic_url 卡面图片，须先将图片上传至CDN
     * outer_img_id 自定义的卡面的标识
     * default_gifting_msg 该卡面对应的默认祝福语，当用户没有编辑内容时会随卡默认填写为用户祝福内容
     *
     *
     * cell1和cell2是JSON结构，包含以下字段
     * 参数 说明
     * cell 商户自定义服务入口结构体，包含以下字段
     * * 　 title 自定义入口名称
     * url 自定义入口链接
     *
     *
     *
     * category_list是JSON结构，包含以下字段
     * 参数 说明
     * category_list 主题分类排序结构体，包含以下字段
     * * 　 title 主题分类的名称
     */
    public function pageGet($page_id)
    {
        $params = array();
        $params['page_id'] = $page_id;
        $rst = $this->_request->payPost('card/giftcard/page/get', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 5.4 修改-礼品卡货架信息接口
     * 接口说明
     * 开发者可以通过该接口更新礼品卡货架信息。
     * 接口调用请求说明
     * 协议 HTTPS
     * http请求方式 POST
     * 请求Url https://api.weixin.qq.com/card/giftcard/page/update?access_token=ACCESS_TOKEN
     * POST数据格式 JSON
     * 请求参数说明
     * 参数 说明 是否必填
     * access_token 调用接口凭证 是
     * JSON JSON数据 是
     *
     * POST数据示例：
     * {
     * "page" : {
     * "page_id" : "abcedfghifk=+Uasdaseq14fadkf8123h4jk",
     * "banner_pic_url" : "http://img.com/banner_pic",
     * "theme_list" : [
     * {
     * "theme_pic_url" : "http://img.com/theme_pic",
     * "title" : "title_lalala",
     * "title_color" : "#FFFFFF",
     * "item_list" : [
     * {
     * "card_id" : "card_id_lalala"
     * }
     * ],
     * "pic_item_list" :[
     * {
     * "background_pic_url" : "http://img.com/bg_pic1",
     * "default_gifting_msg" : "祝福语1"
     * },
     * {
     * "background_pic_url" : "http://img.com/bg_pic2",
     * "default_gifting_msg" : "祝福语2"
     * },
     * {
     * "background_pic_url" : "http://img.com/bg_pic3",
     * "default_gifting_msg" : "祝福语3"
     * }
     * ]
     * }
     * ]
     * }
     * }
     * 请求数据说明：
     * 参数 说明 是否必填
     * page 货架信息结构体，包含以下字段 是
     * * 　 page_id 要修改的货架id 是
     * banner_pic_url 礼品卡货架主题页顶部banner图片，须先将图片上传至CDN 是
     * theme_list 主题结构体，是一个JSON结构 是
     * category_list 主题分类列表 否
     * address 商家地址 是
     * service_phone 商家服务电话 是
     * biz_description 商家使用说明，用于描述退款、发票等流程 是
     * cell_1 商家自定义链接，用于承载退款、发票等流程 是
     * cell_2 商家自定义链接，用于承载退款、发票等流程 是
     *
     *
     *
     *
     * theme_list是一个JSON结构，包含以下字段
     * 参数 说明 是否必填
     * theme_list 主题结构体，包含以下字段 是
     * * 　 theme_pic_url 主题的封面图片，须先将图片上传至CDN 是
     * title 主题名称，如“圣诞”“感恩家人” 是
     * title_color 主题title的颜色，直接传入色值 是
     * item_list 礼品卡列表，标识该主题可选择的面额 是
     * pic_item_list 封面列表 是
     * category_index 主题标号，对应category_list内的title字段，
     * 若填写了category_list则每个主题必填该序号 是
     * is_banner 是否将当前主题设置为banner主题（主推荐） 否
     *
     * item_list和pic_item_list是JSON结构，包含以下字段
     * 参数 说明 是否必填
     * item_list 商品结构体，包含以下字段 是
     * * 　 card_id 待上架的card_id 是
     * pic_item_list 卡面结构体，包含以下字段 是
     * * 　 background_pic_url 卡面图片，须先将图片上传至CDN 是
     * outer_img_id 自定义的卡面的标识 否
     * default_gifting_msg 该卡面对应的默认祝福语，当用户没有编辑内容时会随卡默认填写为用户祝福内容 是
     *
     * cell1和cell2是JSON结构，包含以下字段
     * 参数 说明 是否必填
     * cell 商户自定义服务入口结构体，包含以下字段 是
     * * 　 title 自定义入口名称 是
     * url 自定义入口链接 是
     *
     * category_list是JSON结构，包含以下字段
     * 参数 说明 是否必填
     * category_list 主题分类排序结构体，包含以下字段 否
     * * 　 title 主题分类的名称 否
     *
     *
     *
     * 返回参数说明
     * 返回数据示例：
     * {
     * "errcode" : 0,
     * "errmsg" : "ok"
     * }
     * 返回数据说明：
     * 参数 说明
     * errcode 错误码
     * errmsg 错误信息
     */
    public function pageUpdate(\Weixin\Model\GiftCard\Page $page)
    {
        $params = array();
        $params['page'] = $page->getParams();
        $rst = $this->_request->payPost('card/giftcard/page/update', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 5.5 查询-礼品卡货架列表接口
     * 接口说明
     * 开发者可以通过该接口查询当前商户下所有的礼品卡货架id。
     * 接口调用请求说明
     * 协议 HTTPS
     * http请求方式 POST
     * 请求Url https://api.weixin.qq.com/card/giftcard/page/batchget?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 说明 是否必填
     * access_token 调用接口凭证 是
     * JSON JSON数据 是
     *
     *
     * POST数据示例：
     * {}
     *
     * 返回参数说明
     * 返回数据示例：
     * {
     * "errcode" : 0,
     * "errmsg" : "ok",
     * "page_id_list" : [
     * "abcedfghifk=+Uasdaseq14fadkf8123h4jk",
     * "abcedfghifk=+Uasdaseq14fadkf8123h4jl",
     * "abcedfghifk=+Uasdaseq14fadkf8123h4jm",
     * "abcedfghifk=+Uasdaseq14fadkf8123h4jn"
     * ]
     * }
     * 返回数据说明：
     * 参数 说明
     * errcode 错误码
     * errmsg 错误信息
     * page_id_list 礼品卡货架id列表
     */
    public function pageBatchget()
    {
        $params = array();
        $rst = $this->_request->payPost('card/giftcard/page/batchget', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 5.6 下架-礼品卡货架接口
     * 接口说明
     * 开发者可以通过该接口查询当前商户下所有的礼品卡货架id。
     * 接口调用请求说明
     * 协议 HTTPS
     * http请求方式 POST
     * 请求Url https://api.weixin.qq.com/card/giftcard/maintain/set?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 说明 是否必填
     * access_token 调用接口凭证 是
     * JSON JSON数据 是
     *
     * 请求参数说明：
     * 参数 说明
     * page_id 需要下架的page_id
     * all
     * maintain
     *
     *
     * POST数据示例：
     *
     * 将某个货架设置为下架
     *
     * {
     * "page_id": "abcedfghifk=+Uasdaseq14fadkf8123h4jk",
     * "maintain": true
     * }
     * ----
     * 或者将该商户下所有的货架设置为下架
     * {
     * "all": true,
     * "maintain": true
     * }
     * 返回参数说明
     * 返回数据示例：
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "control_info": {
     * "biz_control_type": "E_PAGE_CONTROL_BIZ",
     * "system_biz_control_type": "E_PAGE_CONTROL_NORMAL",
     * "list" : [
     * {
     * "page_id": "abcedfghifk=+Uasdaseq14fadkf8123h4jk",
     * "page_control_type": "E_PAGE_CONTROL_BIZ",
     * "system_page_control_type": "E_PAGE_CONTROL_SYSTEM"
     * }
     * ]
     * }
     * }
     * 返回数据说明：
     * 参数 说明
     * errcode 错误码
     * errmsg 错误信息
     * control_info 控制结果的结构体
     *
     * control_info是一个结构体，包含以下字段
     * 参数 说明
     * biz_control_type 商户控制的该appid下所有货架的状态
     * system_biz_control_type 系统控制的商家appid下所有的货架状态
     * list Page列表的结构体，为商户下所有page列表
     *
     * listo是一个结构体，包含以下字段
     * 参数 说明
     * page_id Page的唯一id
     * page_control_type 商户控制的货架状态
     * system_page_control_type 由系统控制的货架状态
     */
    public function maintainSet($page_id, $maintain = true)
    {
        $params = array();
        
        if ($page_id == 'all') {
            // 将该商户下所有的货架设置为下架
            $params['all'] = true;
        } else {
            // 将某个货架设置为下架
            $params['page_id'] = $page_id;
        }
        $params['maintain'] = $maintain;
        $rst = $this->_request->payPost('card/giftcard/maintain/set', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 6.礼品卡订单
     * 6.1 查询-单个礼品卡订单信息接口
     * 接口说明
     * 开发者可以通过该接口查询某个订单号对应的订单详情。
     * 接口调用请求说明
     * 协议 HTTPS
     * http请求方式 POST
     * 请求Url https://api.weixin.qq.com/card/giftcard/order/get?access_token=ACCESS_TOKEN
     * POST数据格式 JSON
     * 请求参数说明
     * 参数 说明 是否必填
     * access_token 调用接口凭证 是
     * JSON JSON数据 是
     * POST数据示例：
     * {
     * "order_id" : "Z2y2rY74ksZX1ceuGA"
     * }
     *
     * 请求参数说明：
     * 参数 说明
     * order_id 礼品卡订单号，商户可以通过购买成功的事件推送或者批量查询订单接口获得
     *
     *
     *
     *
     * 返回参数说明
     * 返回数据示例：
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "order": {
     * "order_id": "Z2y2rY74ksZX1ceuGA",
     * "page_id": "abcedfghifk=+Uasdaseq14fadkf8123h4jk",
     * "trans_id": "4001562001201608292531663351",
     * "create_time": 123,
     * "pay_finish_time": 123,
     * "total_price": 123,
     * "open_id": "123",
     * "accepter_openid": "123",
     * "card_list": [
     * {
     * "card_id": "card_id_1",
     * "price": 123,
     * "code": "code_123456",
     * "default_gifting_msg": "",
     * "background_pic_url": ""
     * }
     * ],
     * "outer_str": "web"
     * }
     * }
     * 返回数据说明：
     *
     * 参数 说明
     * errcode 错误码
     * errmsg 错误信息
     * order 订单结构体，包含以下字段
     * * 　 order_id 订单号
     * page_id 货架的id
     * trans_id 微信支付交易订单号
     * create_time 订单创建时间，十位时间戳（utc+8）
     * pay_finish_time 订单支付完成时间，十位时间戳（utc+8）
     * total_price 全部金额，以分为单位
     * open_id 购买者的openid
     * accepter_openid 接收者的openid
     * outer_str 购买货架的渠道参数
     * card_list 卡列表结构，包含以下字段
     * card_id 购买的卡card_id列表
     * price 该卡的价格
     * code 用户获得的code
     * default_gifting_msg 默认祝福语，当用户填入了祝福语时该字段为空
     * background_pic_url 用户选择的背景图
     * outer_img_id 自定义卡面说明
     */
    public function orderGet($order_id)
    {
        $params = array();
        $params['order_id'] = $order_id;
        $rst = $this->_request->payPost('card/giftcard/order/get', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 6.2 查询-批量查询礼品卡订单信息接口
     * 接口说明
     * 开发者可以通过该接口查询该商户某个时间段内创建的所有订单详情。
     * 接口调用请求说明
     * 协议 HTTPS
     * http请求方式 POST
     * 请求Url https://api.weixin.qq.com/card/giftcard/order/batchget?access_token=ACCESS_TOKEN
     * POST数据格式 JSON
     * 请求参数说明
     * 参数 说明 是否必填
     * access_token 调用接口凭证 是
     * JSON JSON数据 是
     * POST数据示例：
     * {
     * "begin_time": 1472400000,
     * "end_time": 1472716604,
     * "sort_type": "ASC",
     * "offset": 0,
     * "count": 2
     * }
     * 请求参数说明：
     * 参数 说明
     * begin_time 查询的时间起点，十位时间戳（utc+8）
     * end_time 查询的时间终点，十位时间戳（utc+8）
     * sort_type 填"ASC" / "DESC"，表示对订单创建时间进行“升 / 降”排序
     * offset 查询的订单偏移量，如填写100则表示从第100个订单开始拉取
     * count 查询订单的数量，如offset填写100，count填写10，则表示查询第100个到第110个订单
     *
     * 返回参数说明
     * 返回数据示例：
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "total_count": 47,
     * "order_list": [
     * {
     * "order_id": "Z2y2rY74ksZX1ceuGA",
     * "page_id": "abcedfghifk=+Uasdaseq14fadkf8123h4jk",
     * "trans_id": "4001562001201608292531663351",
     * "create_time": 123,
     * "pay_finish_time": 123,
     * "total_price": 123,
     * "open_id": "123",
     * "accepter_openid": "123",
     * "card_list": [
     * {
     * "card_id": "card_id_1",
     * "price": 123,
     * "code": "code_123456",
     * "default_gifting_msg": "",
     * "background_pic_url": ""
     * }
     * ],
     * "outer_str": "web"
     * },
     * {
     * "order_id": "Z2y2rY74ksZX1ceuGA",
     * "page_id": "abcedfghifk=+Uasdaseq14fadkf8123h4jk",
     * "trans_id": "4001562001201608292531663351",
     * "create_time": 123,
     * "pay_finish_time": 123,
     * "total_price": 123,
     * "open_id": "123",
     * "accepter_openid": "123",
     * "card_list": [
     * {
     * "card_id": "card_id_1",
     * "price": 123,
     * "code": "code_123456",
     * "default_gifting_msg": "",
     * "background_pic_url": ""
     * }
     * ],
     * "outer_str": "web"
     * }
     * ]
     * }
     * 返回数据说明：
     *
     * 参数 说明
     * errcode 错误码
     * errmsg 错误信息
     * total_count 总计订单数
     * order_list 订单列表结构
     * order 订单结构体，包含以下字段
     * * 　 order_id 订单号
     * page_id 货架的id
     * trans_id 微信支付交易订单号
     * create_time 订单创建时间，十位时间戳（utc+8）
     * pay_finish_time 订单支付完成时间，十位时间戳（utc+8）
     * total_price 全部金额，以分为单位
     * open_id 购买者的openid
     * accepter_openid 接收者的openid
     * outer_str 购买货架的渠道参数
     * card_list 卡列表结构，包含以下字段
     * card_id 购买的卡card_id列表
     * price 该卡的价格
     * code 用户获得的code
     * default_gifting_msg 默认祝福语，当用户填入了祝福语时该字段为空
     * background_pic_url 用户选择的背景图
     *
     * 注意事项：
     *
     * 1）返回中的total_count是在当前查询条件下的total_count，类似于分页的实现改变offset/count，直到某次请求的$offset+count \ge total_、count$时表示拉取结束。
     * 2）begin_time和end_time的跨度不能超过31天。
     * 3)count不能超过100。
     * 4) sort_type可以填"ASC" / "DESC"，表示对*订单创建时间进行“升 / 降”排序。
     */
    public function orderBatchget($begin_time = 0, $end_time = 0, $sort_type = 'ASC', $offset = 0, $count = 100)
    {
        $params = array();
        if (! empty($begin_time)) {
            $params['begin_time'] = $begin_time;
        }
        if (! empty($end_time)) {
            $params['end_time'] = $end_time;
        }
        $params['sort_type'] = $sort_type;
        $params['offset'] = $offset;
        $params['count'] = $count;
        
        $rst = $this->_request->payPost('card/giftcard/order/batchget', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 8.1 更新用户礼品卡信息接口
     * 接口说明
     * 当礼品卡被使用后，开发者可以通过该接口变更某个礼品卡的余额信息。
     * 接口调用请求说明
     * 协议 HTTPS
     * http请求方式 POST
     * 请求Url https://api.weixin.qq.com/card/generalcard/updateuser?access_token=TOKEN
     * POST数据格式 JSON
     * 请求参数说明
     * 参数 说明 是否必填
     * access_token 调用接口凭证 是
     * JSON JSON数据 是
     * POST数据示例：
     * {
     * "code": "12312313",
     * "card_id": "p1Pj9jr90_SQRaVqYI239Ka1erkI",
     * "background_pic_url": "https://mmbiz.qlogo.cn/mmbiz/0?wx_fmt=jpeg",
     * "record_bonus": "消费30元，获得3积分",
     * "bonus": 3000,
     * //可以传入第三方系统记录的积分全量值"balance": 3000,
     * //可以传入第三方系统记录的余额全量值"record_balance": "购买焦糖玛琪朵一杯，扣除金额30元。",
     * "custom_field_value1": "xxxxx"，
     * "can_give_friend" : true
     * }
     *
     *
     * 请求参数说明：
     * 参数 说明 是否必填
     * code 卡券Code码。 是
     * card_id 卡券ID。 是
     * background_pic_url 支持商家激活时针对单个礼品卡分配自定义的礼品卡背景。 否
     * balance 需要设置的余额全量值，传入的数值会直接显示。 否
     * record_balance 商家自定义金额消耗记录，不超过14个汉字。 否
     * custom_field_value1 创建时字段custom_field1定义类型的最新数值，限制为4个汉字，12字节。 否
     * custom_field_value2 创建时字段custom_field2定义类型的最新数值，限制为4个汉字，12字节。 否
     * custom_field_value3 创建时字段custom_field3定义类型的最新数值，限制为4个汉字，12字节。 否
     * can_give_friend 控制本次积分变动后转赠入口是否出现 否
     *
     *
     * 返回参数说明
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "result_bonus": 100,
     * "result_balance": 200,
     * "openid": "oFS7Fjl0WsZ9AMZqrI80nbIq8xrA"
     * }
     *
     *
     * 参数 说明
     * errcode 错误码，0为正常
     * errmsg 错误信息
     * result_bonus 当前用户积分总额
     * result_balance 当前用户预存总金额
     * openid 用户openid
     * errcode 错误码，0为正常
     * errmsg 错误信息
     */
    public function generalcardUpdateuser($code, $card_id = '', $background_pic_url = '', $balance = null, $record_balance = '', $custom_field_value1 = '', $custom_field_value2 = '', $custom_field_value3 = '', $can_give_friend = null)
    {
        $params = array();
        $params['code'] = $code;
        if (! empty($card_id)) {
            $params['card_id'] = $card_id;
        }
        if (! empty($background_pic_url)) {
            $params['background_pic_url'] = $background_pic_url;
        }
        if (! is_null($balance)) {
            $params['balance'] = $balance;
        }
        if (! empty($record_balance)) {
            $params['record_balance'] = $record_balance;
        }
        if (! empty($custom_field_value1)) {
            $params['custom_field_value1'] = $custom_field_value1;
        }
        if (! empty($custom_field_value2)) {
            $params['custom_field_value2'] = $custom_field_value2;
        }
        if (! empty($custom_field_value3)) {
            $params['custom_field_value3'] = $custom_field_value3;
        }
        if (! is_null($can_give_friend)) {
            $params['can_give_friend'] = $can_give_friend;
        }
        
        $rst = $this->_request->payPost('card/generalcard/updateuser', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 9.2.1退款接口
     * 接口说明
     * 开发者可以通过该接口对某一笔订单操作退款，注意该接口比较隐私，请开发者提高操作该功能的权限等级。
     * 接口调用请求说明
     * 协议 HTTPS
     * http请求方式 POST
     * 请求Url https://api.weixin.qq.com/card/giftcard/order/refund?access_token=ACCESS_TOKEN
     * POST数据格式 JSON
     * 请求参数说明
     * 参数 说明 是否必填
     * access_token 调用接口凭证 是
     * JSON JSON数据 是
     *
     * POST数据示例：
     * { "order_id": "xxx" }
     *
     * 请求数据说明：
     *
     * 参数 说明 是否必填
     * order_id 须退款的订单id 是
     *
     * 返回参数说明
     * 返回数据示例：
     * {
     * "errcode" : 0,
     * "errmsg" : "ok"
     * }
     * 返回数据说明：
     * 字段 说明
     * errcode 错误码，0为正常
     * errmsg 错误信息
     *
     * 注意事项：退款后，对应的礼品卡将会在用户卡包消失。
     */
    public function orderRefund($order_id)
    {
        $params = array();
        $params['order_id'] = $order_id;
        
        $rst = $this->_request->payPost('card/giftcard/order/refund', $params);
        return $this->_client->rst($rst);
    }
}
