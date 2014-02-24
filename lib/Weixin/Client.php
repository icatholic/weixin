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

    public function getAccessToken ()
    {
        if (empty($this->_accessToken)) {
            throw new Exception("请设定access_token");
        }
        return $this->_accessToken;
    }

    public function setAccessToken ($accessToken)
    {
        $this->_accessToken = $accessToken;
    }

    public function getFromUserName ()
    {
        if (empty($this->_from))
            throw new Exception('请设定FromUserName');
        return $this->_from;
    }

    public function getToUserName ()
    {
        if (empty($this->_to))
            throw new Exception('请设定ToUserName');
        return $this->to;
    }

    public function setFromAndTo ($fromUserName, $toUserName)
    {
        $this->_from = $fromUserName;
        $this->_to = $toUserName;
    }

    public function setRequest ()
    {
        $this->_request = new Request($this->getAccessToken());
    }

    public function getRequest ()
    {
        return $this->_request;
    }

    public function getMsgManager ()
    {
        return new Msg($this);
    }
    
    public function getMediaManager() {
        return new Media($this);
    }
    
    public function getGroupManager() {
        return new Groups($this);
    }

    public function __destruct ()
    {}
}