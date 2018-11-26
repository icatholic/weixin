<?php
namespace Weixin\Wx\Manager\Mall;

use Weixin\Client;

/**
 * 想买清单
 *
 * @author guoyongrong <handsomegyr@gmail.com>
 * @author young <youngyang@icatholic.net.cn>
 */
class ShoppingList
{

    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 导入“想买清单”
     * 开发者可以在用户添加商品到购物车时，同步商品数据至“想买清单”，接口说明如下：
     *
     * 接口调用基本信息 说明
     * 协议 https
     * http请求方式 POST
     * 请求URL https://api.weixin.qq.com/mall/addshoppinglist?access_token=ACCESS_TOKEN
     * POST数据格式 json
     * 接口能力 同步用户添加商品到微信购物单
     * 接口调用时机 用户添加商品到购物车
     * 请求数据样例
     * {
     * "user_open_id": "user_open_id",
     * "sku_product_list":[
     * {
     * "item_code": "here_is_spu_id",
     * "title": "product_name",
     * "desc": "product_description",
     * "category_list": ["服装", "上衣", "短袖衬衫"],
     * "image_list": ["image_url1", "image_url2"],
     * "src_wxapp_path": "/detail?item_code=xxxx",
     * "attr_list": [
     * {"name": "材质", "value": "纯棉"},
     * {"name": "款式", "value": "短袖"},
     * {"name": "季度", "value": "2018年秋"}
     * ],
     * "version": 100,
     * "sku_info":
     * {
     * "sku_id": "sku_id2",
     * "price": 10010,
     * "original_price": 20010,
     * "status": 1,
     * "sku_attr_list": [
     * {"name": "颜色", "value": "黑色"},
     * {"name": "码数", "value": "XXL"}
     * ],
     * "version": 1200
     * }
     * }
     * ]
     * }
     * 商品基本字段 必填 字段类型 说明
     * user_open_id 是 string 用户的openid，用来指定添加到具体用户的购物单
     * sku_product_list 是 array 单次请求商品数量不可超过10个
     * sku_product_list字段 必填 字段类型 说明
     * item_code 是 string 商品ID，需要保证唯一性
     * title 是 string 商品名称
     * desc 否 string 商品描述
     * category_list 是 string array 商品类目列表，用于搜索排序
     * image_list 是 string array 商品图片链接列表
     * src_wxapp_path 是 string 商品来源小程序路径
     * attr_list 否 object array 商品SPU属性
     * sku_info 是 object 商品SKU信息，微信后台会合并多次导入的SKU
     * version 否 int 数据版本号，需按照更新递增，用在并发更新场景
     * attr_list字段 必填 字段类型 说明
     * name 是 string 属性名称
     * value 是 string 属性内容
     * sku_info字段 必填 字段类型 说明
     * sku_id 是 string 商品sku_id，特殊情况下可以填入与item_code一致
     * price 否 int 商品价格，分为单位
     * original_price 否 int 商品原价，分为单位
     * version 否 int 数据版本号，需按照更新递增，用在并发更新场景
     * status 是 int 商品状态，1：在售，2：停售
     * sku_attr_list 否 object array sku属性列表，参考attr_list
     * 回包数据样例
     * 接口调用成功回包
     * {
     * "errcode":0,
     * "errmsg":"success"
     * }
     * 错误码 说明
     * 9009099 系统失败
     * 9009202 商品数量超过限制
     * 9009203 非法的user_open_id，请检查该openid是否归属该appid
     */
    public function add($user_open_id, array $sku_product_list)
    {
        $params = array();
        $params['user_open_id'] = $user_open_id;
        $params_sku_product_list = array();
        foreach ($sku_product_list as $sku_product) {
            $params_sku_product_list[] = $sku_product->getParams();
        }
        $params['sku_product_list'] = $params_sku_product_list;
        $headers = array();
        $rst = $this->_request->post2('mall/addshoppinglist', $params, $headers);
        return $this->_client->rst($rst);
    }

    /**
     * 删除“想买清单”
     * 开发者可以在用户从购物车删除商品时，同步商品数据从“想买清单”中删除，接口说明如下：
     *
     * 接口调用基本信息 说明
     * 协议 https
     * http请求方式 POST
     * 请求URL https://api.weixin.qq.com/mall/deleteshoppinglist?access_token=ACCESS_TOKEN
     * POST数据格式 json
     * 接口能力 删除微信购物单商品
     * 接口调用时机 用户从购物车删除商品
     * 请求数据样例
     * {
     * "user_open_id": "user_open_id",
     * "sku_product_list": [
     * {
     * "item_code": "here_is_spu_id",
     * "sku_id": "here_is_sku_id"
     * }
     * ]
     * }
     * 商品基本字段 必填 字段类型 说明
     * user_open_id 是 string 用户的openid，用来指定删除具体用户的购物单
     * sku_product_list 是 array 单次请求商品数量不可超过100个
     * sku_product_list字段 必填 字段类型 说明
     * item_code 是 string 商品ID，需要保证唯一性
     * sku_id 是 string 商品sku_id，特殊情况下可以填入与item_code一致
     * 回包数据样例
     * 接口调用成功回包
     * {
     * "errcode":0,
     * "errmsg":"success"
     * }
     * 错误码 说明
     * 9009099 系统失败
     * 9009202 商品数量超过限制
     * 9009203 非法的user_open_id，请检查该openid是否归属该appid
     */
    public function delete($user_open_id, array $sku_product_list)
    {
        $params = array();
        $params['user_open_id'] = $user_open_id;
        $params['sku_product_list'] = $sku_product_list;
        $headers = array();
        $rst = $this->_request->post2('mall/deleteshoppinglist', $params, $headers);
        return $this->_client->rst($rst);
    }
}
