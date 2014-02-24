<?php
/**
 * 微信客户端总调度器
 * @author young <youngyang@icatholic.net.cn>
 *
 */
namespace Weixin;
use Weixin\Http\Request;
use Weixin\Exception;
use Weixin\Manager\Msg;
use Weixin\Manager\Groups;

class Client
{

    private $_accessToken;

    private $_from;

    private $_to;

    private $_request;

    public function __construct ()
    {}

    /**
     * 获取服务端的accessToken
     * @throws Exception
     */
    public function getAccessToken ()
    {
        if (empty($this->_accessToken)) {
            throw new Exception("请设定access_token");
        }
        return $this->_accessToken;
    }

    /**
     * 设定服务端的access token
     * @param string $accessToken
     */
    public function setAccessToken ($accessToken)
    {
        $this->_accessToken = $accessToken;
        $this->initRequest();
    }

    /**
     * 获取来源用户
     * @throws Exception
     */
    public function getFromUserName ()
    {
        if (empty($this->_from))
            throw new Exception('请设定FromUserName');
        return $this->_from;
    }

    /**
     * 获取目标用户
     * @throws Exception
     */
    public function getToUserName ()
    {
        if (empty($this->_to))
            throw new Exception('请设定ToUserName');
        return $this->to;
    }

    /**
     * 设定来源和目标用户
     * @param string $fromUserName
     * @param string $toUserName
     */
    public function setFromAndTo ($fromUserName, $toUserName)
    {
        $this->_from = $fromUserName;
        $this->_to = $toUserName;
    }

    /**
     * 初始化认证的http请求对象
     * 
     */
    private function initRequest ()
    {
        $this->_request = new Request($this->getAccessToken());
    }

    /**
     * 获取请求对象
     */
    public function getRequest ()
    {
        return $this->_request;
    }

    /**
     * 获取消息管理器
     * @return \Weixin\Manager\Msg
     */
    public function getMsgManager ()
    {
        return new Msg($this);
    }
    
    /**
     * 获取多媒体管理器
     * @return \Weixin\Media
     */
    public function getMediaManager() {
        return new Media($this);
    }
    
    /**
     * 获取分组管理器
     * @return \Weixin\Manager\Groups
     */
    public function getGroupManager() {
        return new Groups($this);
    }
    
    /**
     * 标准化处理微信的返回结果
     */
    public function rst($rst) {
        if (! empty ( $rst ['errcode'] )) {
            throw new Exception ( $rst ['errmsg'], $rst ['errcode'] );
        } else {
            return $rst;
        } 
    }

    public function __destruct ()
    {}
}