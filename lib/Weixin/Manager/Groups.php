<?php
namespace Weixin\Manager;
use Weixin\Exception;
use Weixin\Client;

/**
 * 分组管理接口
 * 开发者可以使用接口，
 * 对公众平台的分组进行查询、创建、修改操作，
 * 也可以使用接口在需要时移动用户到某个分组。
 *
 * @author guoyongrong <handsomegyr@gmail.com>
 * @author young <youngyang@icatholic.net.cn>
 */
class Groups
{

    private $_client;

    private $_request;

    public function __construct (Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 查询分组
     * 接口调用请求说明
     * http请求方式: GET（请使用https协议）
     * https://api.weixin.qq.com/cgi-bin/groups/get?access_token=ACCESS_TOKEN
     * 参数 说明
     * access_token 调用接口凭证
     *
     * @return mixed
     */
    public function get ()
    {
        $rst = $this->_request->get('groups/get');
        if (! empty($rst['errcode'])) {
            // 错误时的JSON数据包示例（该示例为AppID无效错误）：
            
            // {"errcode":40013,"errmsg":"invalid appid"}
            throw new Exception($rst['errmsg'], $rst['errcode']);
        } else {
            // 返回说明 正常时的返回JSON数据包示例：
            // {
            // "groups": [
            // {
            // "id": 0,
            // "name": "未分组",
            // "count": 72596
            // },
            // {
            // "id": 1,
            // "name": "黑名单",
            // "count": 36
            // },
            // {
            // "id": 2,
            // "name": "星标组",
            // "count": 8
            // },
            // {
            // "id": 104,
            // "name": "华东媒",
            // "count": 4
            // },
            // {
            // "id": 106,
            // "name": "★不测试组★",
            // "count": 1
            // }
            // ]
            // }
            // 参数 说明
            // groups 公众平台分组信息列表
            // id 分组id，由微信分配
            // name 分组名字，UTF8编码
            // count 分组内用户数量
            return $rst;
        }
    }

    /**
     * 创建分组
     * 一个公众账号，最多支持创建500个分组
     * 接口调用请求说明
     * http请求方式: POST（请使用https协议）
     *
     * https://api.weixin.qq.com/cgi-bin/groups/create?access_token=ACCESS_TOKEN
     * POST数据格式：json
     * POST数据例子：{"group":{"name":"test"}}
     * 参数 说明
     * access_token 调用接口凭证
     * name 分组名字（30个字符以内）
     *
     * @param
     *            $name
     * @return mixed
     */
    public function create ($name)
    {
        $rst = $this->_request->post('groups/create', $params);
        if (! empty($rst['errcode'])) {
            // 错误时的JSON数据包示例（该示例为AppID无效错误）：
            // {"errcode":40013,"errmsg":"invalid appid"}
            throw new WeixinException($rst['errmsg'], $rst['errcode']);
        } else {
            // 返回说明 正常时的返回JSON数据包示例：
            // {
            // "group": {
            // "id": 107,
            // "name": "test"
            // }
            // }
            // 参数 说明
            // id 分组id，由微信分配
            // name 分组名字，UTF8编码
            return $rst;
        }
    }

    /**
     * 修改分组名
     * // 接口调用请求说明
     *
     * // http请求方式: POST（请使用https协议）
     * //
     * https://api.weixin.qq.com/cgi-bin/groups/update?access_token=ACCESS_TOKEN
     * // POST数据格式：json
     * // POST数据例子：{"group":{"id":108,"name":"test2_modify2"}}
     * // 参数 说明
     * // access_token 调用接口凭证
     * // id 分组id，由微信分配
     * // name 分组名字（30个字符以内）
     *
     * @param
     *            $id
     * @param
     *            $name
     * @return mixed
     */
    public function update ($id, $name)
    {
        $params = array();
        $params['group']['id'] = $id;
        $params['group']['name'] = $name;
        
        $rst = $this->_request->post('groups/update', $params);
        if (! empty($rst['errcode'])) {
            // 错误时的JSON数据包示例（该示例为AppID无效错误）：
            // {"errcode":40013,"errmsg":"invalid appid"}
            throw new WeixinException($rst['errmsg'], $rst['errcode']);
        } else {
            // 返回说明 正常时的返回JSON数据包示例：
            // {"errcode": 0, "errmsg": "ok"}
            return $rst;
        }
    }

    /**
     * 移动用户分组
     * // 接口调用请求说明
     * // http请求方式: POST（请使用https协议）
     * //
     * https://api.weixin.qq.com/cgi-bin/groups/members/update?access_token=ACCESS_TOKEN
     * // POST数据格式：json
     * // POST数据例子：{"openid":"oDF3iYx0ro3_7jD4HFRDfrjdCM58","to_groupid":108}
     * // 参数 说明
     * // access_token 调用接口凭证
     * // openid 用户唯一标识符
     * // to_groupid 分组id
     *
     * @param
     *            $openid
     * @param
     *            $to_groupid
     * @return mixed
     */
    public function membersUpdate ($openid, $to_groupid)
    {
        $params = array();
        $params['openid'] = $openid;
        $params['to_groupid'] = $to_groupid;
        $rst = $this->_request->post('groups/members', $params);
        if (! empty($rst['errcode'])) {
            // 错误时的JSON数据包示例（该示例为AppID无效错误）：
            // {"errcode":40013,"errmsg":"invalid appid"}
            throw new WeixinException($rst['errmsg'], $rst['errcode']);
        } else {
            // 返回说明 正常时的返回JSON数据包示例：
            // {"errcode": 0, "errmsg": "ok"}
            return $rst;
        }
    }
}
