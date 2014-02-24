<?php
/**
 * 媒体上传下载管理器
 * @author young <youngyang@icatholic.net.cn>
 *
 */
namespace Weixin\Manager;
use Weixin\Client;

class Media
{

    private $_client;

    private $_request;

    public function __construct (Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    public function upload ($type, $media)
    {
        return $this->_request->upload($type, $media);
    }

    public function download ($mediaId)
    {
        return $this->_request->download($mediaId);
    }

    public function __destruct ()
    {}
}