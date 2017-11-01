<?php
namespace Weixin\Manager;

use Weixin\Client;

/**
 * 评论数据管理
 *
 * @author guoyongrong <handsomegyr@gmail.com>
 * @author young <youngyang@icatholic.net.cn>
 */
class Comment
{

    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 2.1 打开已群发文章评论（新增接口）
     * 接口调用请求说明
     * https 请求方式: POST
     * https://api.weixin.qq.com/cgi-bin/comment/open?access_token=ACCESS_TOKEN
     * 参数说明
     * 参数 是否必须 类型 说明
     * msg_data_id 是 Uint32 群发返回的msg_data_id
     * index 否 Uint32 多图文时，用来指定第几篇图文，从0开始，不带默认操作该msg_data_id的第一篇图文
     *
     * 调用示例
     * {
     * “msg_data_id” : MSG_DATA_ID,
     * “index” : INDEX
     * }
     *
     * 返回（json格式）
     * {
     * “errcode”: ERRCODE,
     * “errmsg” : ERRMSG
     * }
     *
     * 返回码定义
     * {
     * “errcode” : 45009,
     * “errmsg” : “reach max api daily quota limit” //没有剩余的调用次数
     * }
     * {
     * “errcode” : 88000，
     * “errmsg” : “without comment privilege” //没有留言权限
     * }
     * {
     * “errcode” : 88001,
     * “errmsg” : “msg_data is not exists” //该图文不存在
     * }
     * {
     * “errcode”: 88002,
     * “errmsg” : “the article is limit for safety” //文章存在敏感信息
     * }
     */
    public function open($msg_data_id, $index = 0)
    {
        $params = array();
        $params['msg_data_id'] = $msg_data_id;
        $params['index'] = $index;
        $rst = $this->_request->post('comment/open', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 2.2 关闭已群发文章评论（新增接口）
     * 接口调用请求说明
     * https 请求方式: POST
     * https://api.weixin.qq.com/cgi-bin/comment/close?access_token=ACCESS_TOKEN
     * 参数说明
     * 参数 是否必须 类型 说明
     * msg_data_id 是 Uint32 群发返回的msg_data_id
     * index 否 Uint32 多图文时，用来指定第几篇图文，从0开始，不带默认操作该msg_data_id的第一篇图文
     *
     * 调用示例
     * {
     * “msg_data_id” : MSG_DATA_ID,
     * “index” : INDEX,
     * }
     *
     * 返回（json格式）
     * {
     * “errcode”: ERRCODE,
     * “errmsg” : ERRMSG
     * }
     */
    public function close($msg_data_id, $index = 0)
    {
        $params = array();
        $params['msg_data_id'] = $msg_data_id;
        $params['index'] = $index;
        $rst = $this->_request->post('comment/close', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 2.3 查看指定文章的评论数据（新增接口）
     * 接口调用请求说明
     * https 请求方式: POST
     * https://api.weixin.qq.com/cgi-bin/comment/list?access_token=ACCESS_TOKEN
     * 参数说明
     * 参数 是否必须 类型 说明
     * msg_data_id 是 Uint32 群发返回的msg_data_id
     * index 否 Uint32 多图文时，用来指定第几篇图文，从0开始，不带默认返回该msg_data_id的第一篇图文
     * begin 是 Uint32 起始位置
     * count 是 Uint32 获取数目（>=50会被拒绝）
     * type 是 Uint32
     * type=0 普通评论&精选评论
     * type=1 普通评论
     * type=2 精选评论
     *
     * 调用示例
     * {
     * “msg_data_id” : MSG_DATA_ID,
     * “index” : INDEX,
     * “begin”: BEGIN,
     * “count”: COUNT,
     * “type” : TYPE
     * }
     *
     * 返回（json格式）
     * {
     * “errcode”: 0,
     * “errmsg” : “ok”,
     * “total”: TOTAL //总数，非comment的size
     * “comment”: [{
     * user_comment_id : USER_COMMENT_ID //用户评论id
     * openid : OPENID //openid
     * create_time : CREATE_TIME //评论时间
     * content : CONTENT //评论内容
     * comment_type : IS_ELECTED //是否精选评论，0为即非精选，1为true，即精选
     * reply : {
     * content : CONTENT //作者回复内容
     * create_time : CREATE_TIME //作者回复时间
     * }
     * }]
     * }
     *
     * 返回码定义
     * {
     * “errcode” : 45009,
     * “errmsg” : “reach max api daily quota limit” //没有剩余的调用次数
     * }
     * {
     * “errcode” : 88000，
     * “errmsg” : “open comment without comment privilege” //没有留言权限
     * }
     * {
     * “errcode” : 88001,
     * “errmsg” : “msg_data is not exists” //该图文不存在
     * }
     * {
     * “errcode” : 88010,
     * “errmsg” : “count range error. cout <= 0 or count > 50” //获取评论数目不合法
     * }
     */
    public function getlist($msg_data_id, $index = 0, $type = 0, $begin = 0, $count = 50)
    {
        $params = array();
        $params['msg_data_id'] = $msg_data_id;
        $params['index'] = $index;
        $params['begin'] = $begin;
        $params['count'] = $count;
        $params['type'] = $type;
        $rst = $this->_request->post('comment/list', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 2.4 将评论标记精选（新增接口）
     * 接口调用请求说明
     * https 请求方式: POST
     * https://api.weixin.qq.com/cgi-bin/comment/markelect?access_token=ACCESS_TOKEN
     * 参数说明
     * 参数 是否必须 类型 说明
     * msg_data_id 是 Uint32 群发返回的msg_data_id
     * index 否 Uint32 多图文时，用来指定第几篇图文，从0开始，不带默认操作该msg_data_id的第一篇图文
     * user_comment_id 是 Uint32 用户评论id
     *
     * 调用示例
     * {
     * “msg_data_id” : MSG_DATA_ID,
     * “index”: INDEX,
     * “user_comment_id”: COMMENT_ID,
     * }
     *
     * 返回格式（json）
     * {
     * “errcode”: ERRCODE,
     * “errmsg” : ERRMSG
     * }
     *
     * 返回码定义
     * {
     * “errcode” : 45009,
     * “errmsg” : “reach max api daily quota limit” //没有剩余的调用次数
     * }
     * {
     * “errcode” : 88000，
     * “errmsg” : “open comment without comment privilege” //没有留言权限
     * }
     *
     * {
     * “errcode” : 88001,
     * “errmsg” : “msg_data is not exists” //该图文不存在
     * }
     * {
     * “errcode” : 88003,
     * “errmsg” : “elected comment upper limit” //精选评论数已达上限
     * }
     * {
     * “errcode” : 88004,
     * “errmsg” : “comment was deleted by user” //已被用户删除，无法精选
     * }
     * {
     * “errcode” : 88008,
     * “errmsg” : “comment is not exists” //该评论不存在
     * }
     */
    public function markelect($user_comment_id, $msg_data_id, $index = 0)
    {
        $params = array();
        $params['msg_data_id'] = $msg_data_id;
        $params['index'] = $index;
        $params['user_comment_id'] = $user_comment_id;
        $rst = $this->_request->post('comment/markelect', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 2.5 将评论取消精选
     * 接口调用请求说明
     * https 请求方式: POST
     * https://api.weixin.qq.com/cgi-bin/comment/unmarkelect?access_token=ACCESS_TOKEN
     * 参数说明
     * 参数 是否必须 类型 说明
     * msg_data_id 是 Uint32 群发返回的msg_data_id
     * index 否 Uint32 多图文时，用来指定第几篇图文，从0开始，不带默认操作该msg_data_id的第一篇图文
     * user_comment_id 是 Uint32 用户评论id
     *
     * 调用示例
     * {
     * “msg_data_id” : MSG_DATA_ID,
     * “index”: INDEX,
     * “user_comment_id”: COMMENT_ID,
     * }
     *
     * 返回格式（json）
     * {
     * “errcode”: ERRCODE,
     * “errmsg” : ERRMSG
     * }
     *
     * 返回码定义
     * {
     * “errcode” : 45009,
     * “errmsg” : “reach max api daily quota limit” //没有剩余的调用次数
     * }
     * {
     * “errcode” : 88000，
     * “errmsg” : “open comment without comment privilege” //没有留言权限
     * }
     *
     * {
     * “errcode” : 88001,
     * “errmsg” : “msg_data is not exists” //该图文不存在
     * }
     * {
     * “errcode” : 88008,
     * “errmsg” : “comment is not exists” //该评论不存在
     * }
     */
    public function unmarkelect($user_comment_id, $msg_data_id, $index = 0)
    {
        $params = array();
        $params['msg_data_id'] = $msg_data_id;
        $params['index'] = $index;
        $params['user_comment_id'] = $user_comment_id;
        $rst = $this->_request->post('comment/unmarkelect', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 2.6 删除评论（新增接口）
     * 接口调用请求说明
     * https 请求方式: POST
     * https://api.weixin.qq.com/cgi-bin/comment/delete?access_token=ACCESS_TOKEN
     * 参数说明
     * 参数 是否必须 类型 说明
     * msg_data_id 是 Uint32 群发返回的msg_data_id
     * index 否 Uint32 多图文时，用来指定第几篇图文，从0开始，不带默认操作该msg_data_id的第一篇图文
     * user_comment_id 是 Uint32 评论id
     *
     * 调用示例
     * {
     * “msg_data_id” : MSG_DATA_ID,
     * “index” : INDEX,
     * “user_comment_id”: COMMENT_ID,
     * }
     *
     * 返回格式（json）
     * {
     * “errcode”: ERRCODE,
     * “errmsg” : ERRMSG
     * }
     *
     * 返回码定义
     * {
     * “errcode” : 45009,
     * “errmsg” : “reach max api daily quota limit” //没有剩余的调用次数
     * }
     * {
     * “errcode” : 88000，
     * “errmsg” : “open comment without comment privilege” //没有留言权限
     * }
     * {
     * “errcode” : 88001,
     * “errmsg” : “msg_data is not exists” //该图文不存在
     * }
     * {
     * “errcode” : 88008,
     * “errmsg” : “comment is not exists” //该评论不存在
     * }
     */
    public function delete($user_comment_id, $msg_data_id, $index = 0)
    {
        $params = array();
        $params['msg_data_id'] = $msg_data_id;
        $params['index'] = $index;
        $params['user_comment_id'] = $user_comment_id;
        $rst = $this->_request->post('comment/delete', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 2.7 回复评论（新增接口）
     * 接口调用请求说明
     * https 请求方式: POST
     * https://api.weixin.qq.com/cgi-bin/comment/reply/add?access_token=ACCESS_TOKEN
     * 参数说明
     * 参数 是否必须 类型 说明
     * msg_data_id 是 Uint32 群发返回的msg_data_id
     * index 否 Uint32 多图文时，用来指定第几篇图文，从0开始，不带默认操作该msg_data_id的第一篇图文
     * user_comment_id 是 Uint32 评论id
     * content 是 string 回复内容
     *
     * 调用示例
     * {
     * “msg_data_id” : MSG_DATA_ID,
     * “index” : INDEX,
     * “user_comment_id”: COMMENT_ID,
     * “content”: CONTENT
     * }
     *
     * 返回格式（json）
     * {
     * “errcode”: ERRCODE,
     * “errmsg” : ERRMSG
     * }
     *
     * 返回码定义
     * {
     * “errcode” : 45009,
     * “errmsg” : “reach max api daily quota limit” //没有剩余的调用次数
     * }
     * {
     * “errcode” : 88000，
     * “errmsg” : “open comment without comment privilege” //没有留言权限
     * }
     * {
     * “errcode” : 88001,
     * “errmsg” : “msg_data is not exists” //该图文不存在
     * }
     * {
     * “errcode” : 88005,
     * “errmsg” : “already reply” //已经回复过了
     * }
     * {
     * “errcode” : 88007,
     * “errmsg” : “reply content beyond max len or content len is zero”//回复超过长度限制或为0
     * }
     * {
     * “errcode” : 88008,
     * “errmsg” : “comment is not exists” //该评论不存在
     * }
     */
    public function replyAdd($user_comment_id, $content, $msg_data_id, $index = 0)
    {
        $params = array();
        $params['msg_data_id'] = $msg_data_id;
        $params['index'] = $index;
        $params['user_comment_id'] = $user_comment_id;
        $params['content'] = $content;
        $rst = $this->_request->post('comment/reply/add', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 2.8 删除回复（新增接口）
     * 接口调用请求说明
     * https 请求方式: POST
     * https://api.weixin.qq.com/cgi-bin/comment/reply/delete?access_token=ACCESS_TOKEN
     * 参数说明
     * 参数 是否必须 类型 说明
     * msg_data_id 是 Uint32 群发返回的msg_data_id
     * index 否 Uint32 多图文时，用来指定第几篇图文，从0开始，不带默认操作该msg_data_id的第一篇图文
     * user_comment_id 是 Uint32 评论id
     *
     * 调用示例
     * {
     * “msg_data_id” : MSG_DATA_ID,
     * “index” : INDEX,
     * “user_comment_id”: COMMENT_ID,
     * }
     *
     * 返回格式（json）
     * {
     * “errcode”: ERRCODE,
     * “errmsg” : ERRMSG
     * }
     *
     * 返回码定义
     * {
     * “errcode” : 45009,
     * “errmsg” : “reach max api daily quota limit” //没有剩余的调用次数
     * }
     * {
     * “errcode” : 88000，
     * “errmsg” : “open comment without comment privilege” //没有留言权限
     * }
     *
     * {
     * “errcode” : 88001,
     * “errmsg” : “msg_data is not exists” //该图文不存在
     * }
     * {
     * “errcode” : 88008,
     * “errmsg” : “comment is not exists” //该评论不存在
     * }
     * {
     * “errcode” : 87009,
     * “errmsg” : “reply is not exists” //该回复不存在
     * }
     */
    public function replyDelete($user_comment_id, $msg_data_id, $index = 0)
    {
        $params = array();
        $params['msg_data_id'] = $msg_data_id;
        $params['index'] = $index;
        $params['user_comment_id'] = $user_comment_id;
        $rst = $this->_request->post('comment/reply/delete', $params);
        return $this->_client->rst($rst);
    }
}
