<?php
namespace Weixin\Wx\Manager\Msg;

use Weixin\Client;

/**
 * 动态消息
 * 从基础库 2.4.0 开始，支持转发动态消息。动态消息对比普通消息，有以下特点：
 *
 * 消息发出去之后，开发者可以通过后台接口修改 部分 消息内容。
 * 消息有对应的提醒按钮，用户点击提醒按钮可以订阅提醒，开发者可以通过后台修改消息状态并推送一次提醒消息给订阅了提醒的用户
 * 消息属性
 * 动态消息有状态、文字内容、文字颜色。
 *
 * 状态
 * 消息有两个状态，分别有其对应的文字内容和颜色。其中状态 0 可以转移到状态 0 和 1，状态 1 无法再转移。
 *
 * 状态 文字内容 颜色 允许转移的状态
 * 0 “成员正在加入，当前 {member_count}/{room_limit} 人” #FA9D39 0, 1
 * 1 “已开始” #CCCCCC 无
 * 状态参数
 * 每个状态转移的时候可以携带参数，具体参数说明如下。
 *
 * 参数 类型 说明
 * member_count string 状态 0 时有效，文字内容变量值
 * room_limit string 状态 0 时有效，文字内容变量值
 * path string 状态 1 时有效，点击“进入”启动游戏时使用的路径，对于小游戏，没有页面的概念，可以用于传递查询字符串，如 “?foo=bar”
 * version_type string 状态 1 时有效，点击“进入”启动游戏时使用的小游戏版本。有效值 develop（开发版），trial（体验版），release（正式版）
 * 使用方法
 * 一、创建 activity_id
 * 每条动态消息可以理解为一个活动，活动发起前需要通过 createActivityId 接口创建 activity_id。后续转发动态消息以及更新动态消息都需要传入这个 activity_id。
 *
 * 活动的默认有效期是 24 小时。活动结束后，消息内容会变成统一的样式：
 *
 * 文字内容：“已结束”
 * 文字颜色：#00ff00
 * 二、在转发之前声明消息类型为动态消息
 * 通过调用 wx.updateShareMenu 接口，传入 isUpdatableMessage: true，以及 templateInfo、activityId 参数。其中 activityId 从步骤一中获得。
 *
 * wx.updateShareMenu({
 * withShareTicket: true,
 * isUpdatableMessage: true,
 * activityId: '', // 活动 ID
 * templateInfo: {
 * parameterLis: [
 * {
 * name: 'member_count',
 * value: '1'
 * },
 * {
 * name: 'room_limit',
 * value: '3'
 * }
 * ]
 * }
 * })
 * 三、修改动态消息内容
 * 动态消息发出去之后，可以通过 setUpdatableMsg 修改消息内容。
 *
 * 低版本兼容
 * 对于不支持动态消息的客户端版本，收到动态消息后会展示成普通消息
 *
 * @author guoyongrong
 *        
 */
class Updatablemsg
{

    private $_client;

    public function __construct(Client $client)
    {
        $this->_client = $client;
    }

    /**
     * setUpdatableMsg
     * 修改被分享的动态消息。
     *
     * 请求地址
     * POST https://api.weixin.qq.com/cgi-bin/message/wxopen/updatablemsg/send?access_token=ACCESS_TOKEN
     * 参数
     * string access_token
     * 接口调用凭证。
     *
     * string activity_id
     * 动态消息的 ID。
     *
     * number target_state
     * 动态消息修改后的状态
     *
     * Object template_info
     * 动态消息对应的模板信息
     *
     * 属性 类型 默认值 是否必填 说明 支持版本
     * parameter_list Array.<Object> 是 模板中需要修改的参数
     * parameter_list 的结构
     *
     * 属性 类型 默认值 是否必填 说明 支持版本
     * parameter_name string 是 修改的参数名
     * parameter_value string 是 修改后的参数值
     * 返回值
     * Object
     * 返回的 JSON 数据包。
     *
     * 属性 类型 说明 支持版本
     * errcode number 错误码
     * errmsg number 错误信息
     * errcode 的合法值
     *
     * 值 说明
     * 0 请求成功。
     * -1 系统繁忙，此时请开发者稍候再试。··
     * 42001 由于access_token过期而修改失败。
     * 44002 由于post数据为空而修改失败。
     * 47001 由于post数据中参数缺失而修改失败。
     * 47501 由于参数activity_id错误而修改失败。
     * 47502 由于参数target_state错误而修改失败。
     * 47503 由于参数version_type错误而修改失败。
     * 47504 由于activity_id过期而获取失败。
     * curl 调用示例
     * curl -d '{ "activity_id": "966_NGiqKR2V8nkfpBuZt1oxm8qLv092NAwG5W0-F4zo1j0qyKOYH2wTxVeFOQ8~n4XstT0DQLwxBE33BlwX", "target_state": 0, "template_info": { "parameter_list": [ {"name":"member_count", "value" : "2"}, { "name":"room_limit", "value" : "5" } ] } }' \
     * 'https://api.weixin.qq.com/cgi-bin/message/wxopen/updatablemsg/send?access_token=ACCESS_TOKEN'
     */
    public function send($activity_id, $target_state, $template_info)
    {
        $params = array();
        $params['activity_id'] = $activity_id;
        $params['target_state'] = $target_state;
        $params['template_info'] = $template_info;
        // die(json_encode($params, JSON_UNESCAPED_UNICODE));
        $rst = $this->_client->getRequest()->post('message/wxopen/updatablemsg/send', $params);
        return $this->_client->rst($rst);
    }

    /**
     * createActivityId
     * 获取activity_id。小程序可以通过本接口修改被分享的动态消息所对应的activity_id。
     *
     * 请求地址
     * GET https://api.weixin.qq.com/cgi-bin/message/wxopen/activityid/create?access_token=ACCESS_TOKEN
     * 参数
     * string access_token
     * 接口调用凭证。
     *
     * 返回值
     * Object
     * 返回的 JSON 数据包。
     *
     * 属性 类型 说明 支持版本
     * activity_id string 动态消息的 ID。
     * expiration_time number activity_id 的过期时间戳
     * errcode number 错误码
     * errcode 的合法值
     *
     * 值 说明
     * 0 请求成功。
     * -1 系统繁忙，此时请开发者稍候再试。
     * 42001 由于access_token过期而获取失败。
     */
    public function activityidCreate()
    {
        $params = array();
        $rst = $this->_client->getRequest()->post('message/wxopen/activityid/create', $params);
        return $this->_client->rst($rst);
    }
}
