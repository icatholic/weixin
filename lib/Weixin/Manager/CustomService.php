<?php
namespace Weixin\Manager;

use Weixin\Client;

/**
 * 获取客服聊天记录接口
 * 在需要时，开发者可以通过获取客服聊天记录接口，获取多客服的会话记录，
 * 包括客服和用户会话的所有消息记录和会话的创建、关闭等操作记录。
 * 利用此接口可以开发如“消息记录”、“工作监控”、“客服绩效考核”等功能。
 *
 * @author guoyongrong <handsomegyr@gmail.com>
 * @author young <youngyang@icatholic.net.cn>
 */
class CustomService
{

    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 获取客服聊天记录接口
     * 接口调用请求说明
     *
     * http请求方式: POST
     * https://api.weixin.qq.com/cgi-bin/customservice/getrecord?access_token=ACCESS_TOKEN
     * POST数据示例如下：
     * {
     * "starttime" : 123456789,
     * "endtime" : 987654321,
     * "openid" : "OPENID",
     * "pagesize" : 10,
     * "pageindex" : 1,
     * }
     *
     * @return mixed
     */
    public function getRecord($openid, $starttime, $endtime, $pageindex = 1, $pagesize = 1000)
    {
        $params = array();
        /**
         * openid 否 普通用户的标识，对当前公众号唯一
         * starttime 是 查询开始时间，UNIX时间戳
         * endtime 是 查询结束时间，UNIX时间戳，每次查询不能跨日查询
         * pagesize 是 每页大小，每页最多拉取1000条
         * pageindex 是 查询第几页，从1开始
         */
        if ($openid) {
            $params['openid'] = $openid;
        }
        $params['starttime'] = $starttime;
        $params['endtime'] = $endtime;
        $params['pageindex'] = $pageindex;
        $params['pagesize'] = $pagesize;
        
        $rst = $this->_request->post('customservice/getrecord', $params);
        return $this->_client->rst($rst);
    }
}
