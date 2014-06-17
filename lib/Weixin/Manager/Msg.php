<?php
/**
 * 消息控制器
 * @author young
 *
 */
namespace Weixin\Manager;
use Weixin\Client;
use Weixin\Manager\Msg\Custom;
use Weixin\Manager\Msg\Reply;
use Weixin\Manager\Msg\Mass;

class Msg
{

    private $_client;

    public function __construct (Client $client)
    {
        $this->_client = $client;
    }

    /**
     * 获取被动回复发送器
     * 
     * @return \Weixin\Manager\Msg\Reply
     */
    public function getReplySender ()
    {
        return new Reply($this->_client);
    }

    /**
     * 获取主动客户回复发送器
     * 
     * @return \Weixin\Manager\Msg\Custom
     */
    public function getCustomSender ()
    {
        return new Custom($this->_client);
    }
    
    /**
     * 获取群发管理器
     *
     * @return \Weixin\Manager\Msg\Mass
     */
    public function getMassSender()
    {
    	return new Mass($this->_client);
    }

    public function __destruct ()
    {}
}