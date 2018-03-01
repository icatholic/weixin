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

    public $is_to_all = false;

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
        if (! empty($this->is_to_all)) {
            $ret['filter']['is_to_all'] = $this->is_to_all;
        }
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
        if (! empty($this->is_to_all)) {
            $ret['filter']['is_to_all'] = $this->is_to_all;
        }
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
        if (! empty($this->is_to_all)) {
            $ret['filter']['is_to_all'] = $this->is_to_all;
        }
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
        if (! empty($this->is_to_all)) {
            $ret['filter']['is_to_all'] = $this->is_to_all;
        }
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
        if (! empty($this->is_to_all)) {
            $ret['filter']['is_to_all'] = $this->is_to_all;
        }
        $ret['msgtype'] = 'mpnews';
        $ret['mpnews']['media_id'] = $media_id;
        $ret['mpnews']['title'] = $title;
        $ret['mpnews']['description'] = $description;
        return $this->sendAll($ret);
    }

    /**
     * 发送卡券消息
     *
     * @param string $group_id            
     * @param string $card_id            
     * @param array $card_ext            
     * @return array
     */
    public function sendWxcardByGroup($group_id, $card_id, array $card_ext = array())
    {
        $ret = array();
        $ret['filter']['group_id'] = $group_id;
        if (! empty($this->is_to_all)) {
            $ret['filter']['is_to_all'] = $this->is_to_all;
        }
        $ret['msgtype'] = 'wxcard';
        $ret['wxcard']['card_id'] = $card_id;
        if (! empty($card_ext)) {
            $ret['wxcard']['card_ext'] = json_encode($card_ext);
        }
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
     * 发送卡券消息
     *
     * @param array $toUsers            
     * @param string $card_id            
     * @param array $card_ext            
     * @return array
     */
    public function sendWxcardByOpenid(array $toUsers, $card_id, array $card_ext = array())
    {
        $ret = array();
        $ret['touser'] = $toUsers;
        $ret['msgtype'] = 'wxcard';
        $ret['wxcard']['card_id'] = $card_id;
        if (! empty($card_ext)) {
            $ret['wxcard']['card_ext'] = json_encode($card_ext);
        }
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

    /**
     * 预览接口【订阅号与服务号认证后均可用】
     * 开发者可通过该接口发送消息给指定用户，在手机端查看消息的样式和排版。
     *
     * @param array $params            
     * @return array
     */
    public function preview($params)
    {
        $rst = $this->_client->getRequest()->post("message/mass/preview", $params);
        return $this->_client->rst($rst);
    }

    /**
     * 查询群发消息发送状态【订阅号与服务号认证后均可用】
     *
     * @param array $params            
     * @return array
     */
    public function get($msg_id)
    {
        $params = [
            "msg_id" => $msg_id
        ];
        $rst = $this->_client->getRequest()->post("message/mass/get", $params);
        return $this->_client->rst($rst);
    }

    /**
     * 控制群发速度
     * 开发者可以使用限速接口来控制群发速度。
     *
     * 获取群发速度
     *
     * 接口调用请求说明
     *
     * http请求方式: POST
     * https://api.weixin.qq.com/cgi-bin/message/mass/speed/get?access_token=ACCESS_TOKEN
     * 返回说明 正常情况下的返回结果为：
     *
     * {
     * "speed":3,
     * "realspeed":15
     * }
     * 参数说明
     *
     * 参数 是否必须 说明
     * speed 是 群发速度的级别
     * realspeed 是 群发速度的真实值 单位：万/分钟
     */
    public function speedGet()
    {
        $params = array();
        $rst = $this->_client->getRequest()->post("message/mass/speed/get", $params);
        return $this->_client->rst($rst);
    }

    /**
     * 设置群发速度
     *
     * 接口调用请求说明
     *
     * http请求方式: POST
     * https://api.weixin.qq.com/cgi-bin/message/mass/speed/set?access_token=ACCESS_TOKEN
     * 请求示例
     *
     * {
     * "speed":1
     * }
     * 参数说明
     *
     * 参数 是否必须 说明
     * speed 是 群发速度的级别
     * 群发速度的级别，是一个0到4的整数，数字越大表示群发速度越慢。
     *
     * speed 与 realspeed 的关系如下：
     *
     * speed realspeed
     * 0 80w/分钟
     * 1 60w/分钟
     * 2 45w/分钟
     * 3 30w/分钟
     * 4 10w/分钟
     * 返回码说明
     *
     * 返回码 说明
     * 45083 设置的 speed 参数不在0到4的范围内
     * 45084 没有设置 speed 参数
     */
    public function speedSet($speed)
    {
        $params = array(
            'speed' => $speed
        );
        $rst = $this->_client->getRequest()->post("message/mass/speed/set", $params);
        return $this->_client->rst($rst);
    }
}
