<?php
/**
 * 媒体上传下载管理器
 * 
 * @author young <youngyang@icatholic.net.cn>
 *
 */
namespace Weixin\Manager;

use Weixin\Client;
use Weixin;
use Weixin\Exception;

class Media
{

    /**
     * 微信客户端
     *
     * @var Weixin\Client
     */
    private $_client;

    /**
     * 上传文件
     *
     * @var Weixin\Http\Request
     */
    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    public function upload($type, $media)
    {
        return $this->_request->upload($type, $media);
    }

    public function download($mediaId)
    {
        return $this->_request->download($mediaId);
    }

    /**
     * 上传图文消息素材（用于群发图文消息）
     *
     * @param array $articles            
     * @throws Exception
     */
    public function uploadNews(array $articles)
    {
        if (count($articles) < 1 || count($articles) > 10) {
            throw new Exception("一个图文消息只支持1到10条图文");
        }
        return $this->_request->mediaPost('https://api.weixin.qq.com/cgi-bin/media/uploadnews', array(
            'articles' => $articles
        ));
    }

    /**
     * 上传视频素材（用于群发视频消息）
     *
     * @param string $media_id            
     * @param string $title            
     * @param string $description            
     */
    public function uploadVideo($media_id, $title, $description)
    {
        $video = array();
        $video["media_id"] = $media_id;
        $video["title"] = $title;
        $video["description"] = $description;
        return $this->_request->mediaPost('http://file.api.weixin.qq.com/cgi-bin/media/uploadvideo', $video);
    }
    
	public function uploadImg($img)
    {
        $options = array();
        $options['fieldName'] = 'media';
        return $this->_request->uploadFile('https://api.weixin.qq.com/cgi-bin/', 'media/uploadimg', $img);
    }
	
    public function __destruct()
    {}
}