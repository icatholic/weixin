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
use Weixin\Wx\Manager\Qrcode;
use Weixin\Wx\Manager\Merchant;
use Weixin\Wx\Manager\Card;

class Client
{

    private $_client;

    public function __construct(\Weixin\Client $client)
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

    /**
     * 获取二维码管理器
     *
     * @return \Weixin\Wx\Manager\Qrcode
     */
    public function getQrcodeManager()
    {
        return new Qrcode($this->_client);
    }

    /**
     * 获取门店小程序管理器
     *
     * @return \Weixin\Wx\Manager\Merchant
     */
    public function getMerchantManager()
    {
        return new Merchant($this->_client);
    }

    /**
     * 获取小程序卡券管理器
     *
     * @return \Weixin\Wx\Manager\Card
     */
    public function getCardManager()
    {
        return new Card($this->_client);
    }
}