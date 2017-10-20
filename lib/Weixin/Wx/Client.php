<?php
/**
 * 小程序客户端总调度器
 * 
 * @author young <youngyang@icatholic.net.cn>
 *
 */
namespace Weixin\Wx;

use Weixin\Client;
use Weixin\Wx\Manager\Msg;

class Client
{

    private $_client;

    public function __construct(Client $client)
    {
        $this->_client = $client;
    }

    /**
     * 获取小程序消息管理器
     *
     * @return \Weixin\Wx\Manager\Msg
     */
    public function getMsgManager()
    {
        return new Msg($this->_client);
    }
}