<?php
namespace Weixin\Manager;

use Weixin\Client;
use Weixin\Http\Request;

/**
 * 用户标签管理接口
 * 开发者可以使用接口，
 * 对公众平台的分组进行查询、创建、修改操作，
 * 也可以使用接口在需要时移动用户到某个标签。
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Tags
{

    /**
     * 微信客户端
     *
     * @var Client
     */
    private $_client;

    /**
     * 请求对象
     *
     * @var Request
     */
    private $_request;

    private $_url = '';

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 获取公众号已创建的标签
     */
    public function get()
    {
        $rst = $this->_request->get($this->_url . 'tags/get');
        return $this->_client->rst($rst);
    }

    /**
     * 创建标签
     * 一个公众号，最多可以创建100个标签。
     */
    public function create($name)
    {
        $params = array(
            "tag" => array(
                "name" => $name
            )
        );
        $rst = $this->_request->post($this->_url . 'tags/create', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 编辑标签
     */
    public function update($id, $name)
    {
        $params = array();
        $params['tag']['id'] = $id;
        $params['tag']['name'] = $name;
        
        $rst = $this->_request->post($this->_url . 'tags/update', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 删除标签
     * 请注意，当某个标签下的粉丝超过10w时，后台不可直接删除标签。
     * 此时，开发者可以对该标签下的openid列表，先进行取消标签的操作，直到粉丝数不超过10w后，才可直接删除该标签。
     */
    public function delete($id)
    {
        $params = array(
            "tag" => array(
                "id" => $id
            )
        );
        $rst = $this->_request->post($this->_url . 'tags/delete', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取标签下的粉丝
     * "tagid" : 134,
     * "next_openid":""//第一个拉取的OPENID，不填默认从头开始拉取
     */
    public function tagUser($tagID, $next_openid)
    {
        $params = array(
            "tagid" => $tagID,
            "next_openid" => $next_openid
        );
        $rst = $this->_request->post($this->_url . 'user/tag/get', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 批量为用户打标签
     * 标签功能目前支持公众号为用户打上最多三个标签。
     * {
     * "openid_list" : [//粉丝列表
     * "ocYxcuAEy30bX0NXmGn4ypqx3tI0",
     * "ocYxcuBt0mRugKZ7tGAHPnUaOW7Y"
     * ],
     * "tagid" : 134
     */
    public function batchtagging($tagid, $openidList)
    {
        $params = array(
            "openid_list" => $openidList,
            'tagid' => $tagid
        );
        $rst = $this->_request->post($this->_url . 'tags/members/batchtagging', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 批量为用户取消标签
     *
     * {
     * "openid_list" : [//粉丝列表
     * "ocYxcuAEy30bX0NXmGn4ypqx3tI0",
     * "ocYxcuBt0mRugKZ7tGAHPnUaOW7Y"
     * ],
     * "tagid" : 134
     * }
     */
    public function batchuntagging($tagid, $openidList)
    {
        $params = array(
            "openid_list" => $openidList,
            'tagid' => $tagid
        );
        $rst = $this->_request->post($this->_url . 'tags/members/batchuntagging', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取用户身上的标签列表
     */
    public function userTagList($openid)
    {
        $params = array(
            "openid" => $openid
        );
        $rst = $this->_request->post($this->_url . 'tags/getidlist', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 黑名单管理
     * 公众号可登录微信公众平台，对粉丝进行拉黑的操作。同时，我们也提供了一套黑名单管理API，以便开发者直接利用接口进行操作。
     *
     * 1. 获取公众号的黑名单列表
     *
     * 公众号可通过该接口来获取帐号的黑名单列表，黑名单列表由一串 OpenID（加密后的微信号，每个用户对每个公众号的OpenID是唯一的）组成。
     *
     * 该接口每次调用最多可拉取 10000 个OpenID，当列表数较多时，可以通过多次拉取的方式来满足需求。
     *
     * 接口调用请求说明
     *
     * http请求方式：POST（请使用https协议）
     * https://api.weixin.qq.com/cgi-bin/tags/members/getblacklist?access_token=ACCESS_TOKEN
     * JSON 数据说明
     *
     * {
     * "begin_openid":"OPENID1"
     * }
     * 当 begin_openid 为空时，默认从开头拉取。
     *
     * 返回说明
     *
     * 正确时返回 JSON数据包
     *
     * {
     * "total":23000,
     * "count":10000,
     * "data":{"
     * openid":[
     * "OPENID1",
     * "OPENID2",
     * ...,
     * "OPENID10000"
     * ]
     * },
     * "next_openid":"OPENID10000"
     * }
     * 错误时返回 JSON数据包（示例为无效AppID错误）
     *
     * {"errcode":40013,"errmsg":"invalid appid"}
     * 返回码说明
     *
     * 返回码 说明
     * -1 系统繁忙
     * 40003 传入非法的openid
     * 49003 传入的openid不属于此AppID
     * 同时，请注意：
     *
     * 当公众号黑名单列表数量超过 10000 时，可通过填写 next_openid 的值，从而多次拉取列表的方式来满足需求。
     *
     * 具体而言，就是在调用接口时，将上一次调用得到的返回中的 next_openid 的值，作为下一次调用中的 next_openid 值。
     */
    public function getblacklist($begin_openid = "")
    {
        $params = array(
            "begin_openid" => $begin_openid
        );
        $rst = $this->_request->post($this->_url . 'tags/members/getblacklist', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 2.拉黑用户
     *
     * 公众号可通过该接口来拉黑一批用户，黑名单列表由一串 OpenID （加密后的微信号，每个用户对每个公众号的OpenID是唯一的）组成。
     *
     * 接口调用请求说明
     *
     * http请求方式：POST（请使用https协议）
     * https://api.weixin.qq.com/cgi-bin/tags/members/batchblacklist?access_token=ACCESS_TOKEN
     * 参数说明
     *
     * 参数 是否必须 说明
     * access_token 是 调用接口凭证
     * openid_list 是 需要拉入黑名单的用户的openid，一次拉黑最多允许20个
     * JSON 数据说明
     *
     * {
     * "openid_list":["OPENID1”,” OPENID2”]
     * }
     * 返回说明
     *
     * 正确时返回 JSON数据包
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok"
     * }
     * 错误时返回 JSON数据包（示例为无效AppID错误）
     *
     * {"errcode":40013,"errmsg":"invalid appid"}
     * 返回码说明
     *
     * 返回码 说明
     * -1 系统繁忙
     * 40003 传入非法的openid
     * 49003 传入的openid不属于此AppID
     * 40032 一次只能拉黑20个用户
     */
    public function batchblacklist(array $openid_list)
    {
        $params = array(
            "openid_list" => $openid_list
        );
        $rst = $this->_request->post($this->_url . 'tags/members/batchblacklist', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 3.
     * 取消拉黑用户
     *
     * 公众号可通过该接口来取消拉黑一批用户，黑名单列表由一串OpenID（加密后的微信号，每个用户对每个公众号的OpenID是唯一的）组成。
     *
     * 接口调用请求说明
     *
     * http请求方式：POST（请使用https协议）
     * https://api.weixin.qq.com/cgi-bin/tags/members/batchunblacklist?access_token=ACCESS_TOKEN
     * 参数说明
     *
     * 参数 是否必须 说明
     * access_token 是 调用接口凭证
     * openid_list 是 需要拉入黑名单的用户的openid，一次拉黑最多允许20个
     * JSON 数据说明
     *
     * {
     * "openid_list":["OPENID1”,” OPENID2”]
     * }
     * 返回说明
     *
     * 正确时返回 JSON数据包
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok"
     * }
     * 错误时返回 JSON数据包（示例为无效AppID错误）
     *
     * {"errcode":40013,"errmsg":"invalid appid"}
     * 返回码说明
     *
     * 返回码 说明
     * -1 系统繁忙
     * 40003 传入非法的openid
     * 49003 传入的openid不属于此AppID
     * 40032 一次只能拉黑20个用户
     */
    public function batchunblacklist(array $openid_list)
    {
        $params = array(
            "openid_list" => $openid_list
        );
        $rst = $this->_request->post($this->_url . 'tags/members/batchunblacklist', $params);
        return $this->_client->rst($rst);
    }
}


