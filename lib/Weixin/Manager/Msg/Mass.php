<?php
namespace Weixin\Manager\Msg;

use Weixin\Client;

/**
 * 群发消息接口
 *
 * @author Ben
 *        
 */
class Mass
{

    private $_client;

    public function __construct(Client $client)
    {
        $this->_client = $client;
    }

    /**
     * 根据分组进行群发
     *
     * @param array $params            
     * @throws Exception
     * @return array
     */
    public function sendAll($params)
    {
        $rst = $this->_client->getRequest()->post('message/mass/sendall', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 发送文本消息
     *
     * @param string $group_id            
     * @param string $content            
     * @param string $title            
     * @param string $description            
     * @return array
     */
    public function sendTextByGroup($group_id, $content, $title = "", $description = "")
    {
        $ret = array();
        $ret['filter']['group_id'] = $group_id;
        $ret['msgtype'] = 'text';
        $ret['text']['content'] = $content;
        $ret['text']['title'] = $title;
        $ret['text']['description'] = $description;
        return $this->sendAll($ret);
    }

    /**
     * 发送图片消息
     *
     * @param string $group_id            
     * @param string $media_id            
     * @param string $title            
     * @param string $description            
     * @return array
     */
    public function sendImageByGroup($group_id, $media_id, $title = "", $description = "")
    {
        $ret = array();
        $ret['filter']['group_id'] = $group_id;
        $ret['msgtype'] = 'image';
        $ret['image']['media_id'] = $media_id;
        $ret['image']['title'] = $title;
        $ret['image']['description'] = $description;
        return $this->sendAll($ret);
    }

    /**
     * 发送语音消息
     *
     * @param string $group_id            
     * @param string $media_id            
     * @param string $title            
     * @param string $description            
     * @return array
     */
    public function sendVoiceByGroup($group_id, $media_id, $title = "", $description = "")
    {
        $ret = array();
        $ret['filter']['group_id'] = $group_id;
        $ret['msgtype'] = 'voice';
        $ret['voice']['media_id'] = $media_id;
        $ret['voice']['title'] = $title;
        $ret['voice']['description'] = $description;
        return $this->sendAll($ret);
    }

    /**
     * 发送视频消息
     *
     * @param string $group_id            
     * @param string $media_id            
     * @param string $title            
     * @param string $description            
     * @return array
     */
    public function sendVideoByGroup($group_id, $media_id, $title = "", $description = "")
    {
        $ret = array();
        $ret['filter']['group_id'] = $group_id;
        $ret['msgtype'] = 'mpvideo';
        $ret['mpvideo']['media_id'] = $media_id;
        $ret['mpvideo']['title'] = $title;
        $ret['mpvideo']['description'] = $description;
        return $this->sendAll($ret);
    }

    /**
     * 发送图文消息
     *
     * @param string $group_id            
     * @param string $media_id            
     * @param string $title            
     * @param string $description            
     * @return array
     */
    public function sendGraphTextByGroup($group_id, $media_id, $title = "", $description = "")
    {
        $ret = array();
        $ret['filter']['group_id'] = $group_id;
        $ret['msgtype'] = 'mpnews';
        $ret['mpnews']['media_id'] = $media_id;
        $ret['mpnews']['title'] = $title;
        $ret['mpnews']['description'] = $description;
        return $this->sendAll($ret);
    }

    /**
     * 根据OpenID列表群发
     *
     * @param array $params            
     * @throws Exception
     * @return array
     */
    public function send($params)
    {
        $rst = $this->_client->getRequest()->post('message/mass/send', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 发送文本消息
     *
     * @param array $toUsers            
     * @param string $content            
     * @param string $title            
     * @param string $description            
     * @return array
     */
    public function sendTextByOpenid(array $toUsers, $content, $title = "", $description = "")
    {
        $ret = array();
        $ret['touser'] = $toUsers;
        $ret['msgtype'] = 'text';
        $ret['text']['content'] = $content;
        $ret['text']['title'] = $title;
        $ret['text']['description'] = $description;
        return $this->send($ret);
    }

    /**
     * 发送图片消息
     *
     * @param array $toUsers            
     * @param string $media_id            
     * @param string $title            
     * @param string $description            
     * @return array
     */
    public function sendImageByOpenid(array $toUsers, $media_id, $title = "", $description = "")
    {
        $ret = array();
        $ret['touser'] = $toUsers;
        $ret['msgtype'] = 'image';
        $ret['image']['media_id'] = $media_id;
        $ret['image']['title'] = $title;
        $ret['image']['description'] = $description;
        return $this->send($ret);
    }

    /**
     * 发送语音消息
     *
     * @param array $toUsers            
     * @param string $media_id            
     * @param string $title            
     * @param string $description            
     * @return array
     */
    public function sendVoiceByOpenid(array $toUsers, $media_id, $title = "", $description = "")
    {
        $ret = array();
        $ret['touser'] = $toUsers;
        $ret['msgtype'] = 'voice';
        $ret['voice']['media_id'] = $media_id;
        $ret['voice']['title'] = $title;
        $ret['voice']['description'] = $description;
        return $this->send($ret);
    }

    /**
     * 发送视频消息
     *
     * @param array $toUsers            
     * @param string $media_id            
     * @param string $title            
     * @param string $description            
     * @return array
     */
    public function sendVideoByOpenid(array $toUsers, $media_id, $title = "", $description = "")
    {
        $ret = array();
        $ret['touser'] = $toUsers;
        $ret['msgtype'] = 'mpvideo';
        $ret['mpvideo']['media_id'] = $media_id;
        $ret['mpvideo']['title'] = $title;
        $ret['mpvideo']['description'] = $description;
        return $this->send($ret);
    }

    /**
     * 发送图文消息
     *
     * @param array $toUsers            
     * @param string $media_id            
     * @param string $title            
     * @param string $description            
     * @return array
     */
    public function sendGraphTextByOpenid(array $toUsers, $media_id, $title = "", $description = "")
    {
        $ret = array();
        $ret['touser'] = $toUsers;
        $ret['msgtype'] = 'mpnews';
        $ret['mpnews']['media_id'] = $media_id;
        $ret['mpnews']['title'] = $title;
        $ret['mpnews']['description'] = $description;
        return $this->send($ret);
    }

    /**
     * 删除群发
     *
     * @param string $msgid            
     * @return array
     */
    public function delete($msgid)
    {
        $ret = array();
        $ret['msgid'] = $msgid;
        $rst = $this->_client->getRequest()->post("message/mass/delete", $ret);
        return $this->_client->rst($rst);
    }
}
