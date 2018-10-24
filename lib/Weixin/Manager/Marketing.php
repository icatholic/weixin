<?php
namespace Weixin\Manager;

use Weixin\Client;

/**
 * H5/小程序广告转化行为数据接入
 *
 * @author guoyongrong <handsomegyr@gmail.com>
 * @author young <youngyang@icatholic.net.cn>
 */
class Marketing
{

    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * （二）获取 user_action_set_id，用于标识数据归属权
     * 1．创建用户行为数据源
     * 请求地址：
     * user_action_sets/add
     * 请求方法：
     * POST
     * 请求参数：
     * 名称 类型 描述
     * type enum 用户行为源类型，WEB
     * name string 用户行为源名称，必填
     * description string 用户行为源描述，字段长度最小 1 字节，长度最大 128 字
     * 节
     * 请求示例：
     * curl -i
     * "https://api.weixin.qq.com/marketing/user_action_sets/add?version=v1.0&access_token=<ACCESS_TOKEN>"
     * -H "Content-Type: application/json"
     * -d '{
     * "type": "WEB",
     * "name": "wxadtest",
     * "description": "test"
     * }'
     * 应答字段：
     * 名称 类型 描述
     * user_action_set_id integer 用户行为源 id，通过 [user_action_sets 接口] 创建用户
     * 行为源时分配的唯一 id
     * 应答示例：{
     * "code": 0,
     * "message": "",
     * "data": {
     * "user_action_set_id": "<USER_ACTION_SET_ID>"
     * }
     * }
     */
    public function useractionsetsAdd($type, $name, $description)
    {
        $params = array();
        $params['type'] = $type;
        $params['name'] = $name;
        $params['description'] = $description;
        $headers = array();
        $headers['Content-Type'] = "application/json";
        $rst = $this->_request->post2('marketing/user_action_sets/add?version=v1.0', $params, $headers);
        return $this->_client->rst($rst);
    }

    /**
     * 2．获取用户行为数据源
     * 请求地址：
     * user_action_sets/get
     * 请求方法：
     * GET
     * 请求参数：
     * 名称 类型 描述
     * user_action_set_id integer 用户行为源 id，通过 [user_action_sets 接口] 创建
     * 用户行为源时分配的唯一 id
     * 请求示例：
     * curl -G
     * 'https://api.weixin.qq.com/marketing/user_action_sets/get?version=v1.0&access_token=<ACCESS_TOKEN>'
     * -d "user_action_set_id":"<USER_ACTION_SET_ID>"
     * 应答字段：
     * 名称 类型 描述
     * list struct[] 返回数组列表
     * user_action_set_id integer 用户行为源 id，通过 [user_action_sets 接口] 创建用
     * 户行为源时分配的唯一 id
     * type enum 用户行为源类型，WEB
     * name string 用户行为源名称，必填
     * description string 用户行为源描述
     * activate_status boolean 数据接入状态， true 表示已接入， false 表示未接入
     * created_time string 创建时间，格式为 yyyy-MM-dd HH:mm:ss,如 2016-11-01 10:42:56
     */
    public function useractionsetsGet($user_action_set_id)
    {
        $params = array();
        $params['user_action_set_id'] = $user_action_set_id;
        $rst = $this->_request->get2('marketing/user_action_sets/get?version=v1.0', $params);
        return $this->_client->rst($rst);
    }

    /**
     * （三）上报网页转化行为数据
     * 在传入转化行为数据之前，请确保开发者已经：
     *  注册成为开发者，并获取了可用的在有效期内的 token
     *  获取了 user_action_set_id
     * 1．转化数据类型
     * 要上报转化行为，首先需要填写相应的转化类型（ActionType）。
     * 对应参数为action_type，如下表所示（目前只开放“下单”及“表单预约”两种行为）：
     * 转化行为 ActionType(action_type) 下单 COMPLETE_ORDER 表单预约 RESERVATION
     * 3．数据上报参数说明
     * 名称 类型 必填 限制 说明
     * user_action_set_id integer yes 用于标识数据归属权。
     * url string yes 转化行为发生页面的 URL
     * action_time integer yes 行为发生时，客户端的时间点。广告平台使用的是 GMT+8 的时间，容错范围是前后 10 秒，UNIX 时间，单位为秒，如果不填将使用服务端时间填写
     * action_type enum yes预定义的行为类型，目前只支持 COMPLETE_ORDER （ 下单）及 RESERVATION（表单预约）
     * click_id string yes目前仅支持click_id落地页 URL 中的 click_id，对于 微 信 流 量 为 URL 中 的gdt_vid，获取方法参考数据监控指引
     * action_param string no 行为所带的参数，转化行为价值（例如金额），详见附录，字段长度最小 1 字节，长度最大 204800 字节
     * value Int no 代表订单金额，单位为分，需要填写到 param 中获取，例如商品单价 40 元，需赋值为4000
     *
     * 4．转化数据上报请求示例
     * 需要统计“下单”的转化行为，开发者只需要在下单转化行为发生时，上报action_type=“COMPLETE_ORDER”，且附上由落地页获取的 click_id。请求示例如
     * 下：
     * curl -k
     * "https://api.weixin.qq.com/marketing/user_actions/add?version=v1.0&access_token=<ACCESS_TOKEN>"
     * -d '{
     * "actions":[
     * {
     * "user_action_set_id":"<USER_ACTION_SET_ID>",
     * "url":"<URL>",
     * "action_time":1513077790,
     * "action_type":"COMPLETE_ORDER",
     * "trace":{
     * "click_id":"<CLICK_ID>"
     * },
     * "action_param":{
     * "value": 40
     * }
     * }
     * ]
     * }'
     * -H "Content-Type:application/json"
     * 5. 返回值
     * 正确的返回值为：
     * {"code":0,"message":"success"}
     * 代表上报成功。
     * 关于错误的返回码详见附录中的返回码。
     */
    public function useractionsAdd($user_action_set_id, $url, $action_time, $action_type, $trace, $action_param)
    {
        $info = array();
        $info['user_action_set_id'] = $user_action_set_id;
        $info['url'] = $url;
        $info['action_time'] = $action_time;
        $info['action_type'] = $action_type;
        $info['trace'] = $trace;
        $info['action_param'] = $action_param;
        
        $params = array();
        $params['actions'] = array(
            $info
        );
        $headers = array();
        $headers['Content-Type'] = "application/json";
        
        $rst = $this->_request->post2('marketing/user_actions/add?version=v1.0', $params, $headers);
        return $this->_client->rst($rst);
    }
}
