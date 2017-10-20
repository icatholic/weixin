<?php
/**
 * 消息控制器
 * @author young
 *
 */
namespace Weixin\Wx\Manager;

use Weixin\Client;
use Weixin\Wx\Manager\Msg\Template;

class Msg
{

    private $_client;

    public function __construct(Client $client)
    {
        $this->_client = $client;
    }

    /**
     * 获取小程序模板消息管理器
     *
     * @return \Weixin\Manager\Msg\Template
     */
    public function getTemplateSender()
    {
        return new Template($this->_client);
    }
}