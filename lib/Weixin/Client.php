<?php
/**
 * 微信客户端总调度器
 * 
 * @author young <youngyang@icatholic.net.cn>
 *
 */
namespace Weixin;

use Weixin\Http\Request;
use Weixin\Exception;
use Weixin\Manager\Msg;
use Weixin\Manager\Groups;
use Weixin\Manager\Qrcode;
use Weixin\Manager\Menu;
use Weixin\Manager\User;
use Weixin\Manager\Sns\User as SnsUser;
use Weixin\Manager\Media;

class Client
{

    private $_accessToken = null;

    private $_snsAccessToken = null;

    private $_from = null;

    private $_to = null;

    private $_request = null;
    
    private $_signature = null;
    
    private $_verifyToken = null;

    public function __construct()
    {}

    /**
     * 获取服务端的accessToken
     *
     * @throws Exception
     */
    public function getAccessToken()
    {
        if (empty($this->_accessToken)) {
            throw new Exception("请设定access_token");
        }
        return $this->_accessToken;
    }

    /**
     * 设定服务端的access token
     *
     * @param string $accessToken            
     */
    public function setAccessToken($accessToken)
    {
        $this->_accessToken = $accessToken;
        $this->initRequest();
        return $this;
    }

    /**
     * 获取来源用户
     *
     * @throws Exception
     */
    public function getFromUserName()
    {
        if (empty($this->_from))
            throw new Exception('请设定FromUserName');
        return $this->_from;
    }

    /**
     * 获取目标用户
     *
     * @throws Exception
     */
    public function getToUserName()
    {
        if (empty($this->_to))
            throw new Exception('请设定ToUserName');
        return $this->_to;
    }

    /**
     * 设定来源和目标用户
     *
     * @param string $fromUserName            
     * @param string $toUserName            
     */
    public function setFromAndTo($fromUserName, $toUserName)
    {
        $this->_from = $toUserName;
        $this->_to = $fromUserName;
        return $this;
    }

    /**
     * 初始化认证的http请求对象
     */
    private function initRequest()
    {
        $this->_request = new Request($this->getAccessToken());
    }

    /**
     * 获取请求对象
     */
    public function getRequest()
    {
        if (empty($this->_request)) {
            throw new Exception('尚未初始化request对象，请确认是否设定了access token');
        }
        return $this->_request;
    }

    /**
     * 获取消息管理器
     *
     * @return \Weixin\Manager\Msg
     */
    public function getMsgManager()
    {
        return new Msg($this);
    }

    /**
     * 获取多媒体管理器
     *
     * @return \Weixin\Manager\Media
     */
    public function getMediaManager()
    {
        return new Media($this);
    }

    /**
     * 获取菜单管理器
     *
     * @return \Weixin\Manager\Menu
     */
    public function getMenuManager()
    {
        return new Menu($this);
    }

    /**
     * 获取分组管理器
     *
     * @return \Weixin\Manager\Groups
     */
    public function getGroupManager()
    {
        return new Groups($this);
    }

    /**
     * 获取用户信息管理器
     *
     * @return \Weixin\Manager\User
     */
    public function getUserManager()
    {
        return new User($this);
    }

    /**
     * 获取二维码管理器
     *
     * @return \Weixin\Manager\Qrcode
     */
    public function getQrcodeManager()
    {
        return new Qrcode($this);
    }

    public function setSnsAccessToken($accessToken)
    {
        $this->_snsAccessToken = $accessToken;
        return $this;
    }

    /**
     * 获取用户授权的token信息
     *
     * @throws Exception
     */
    public function getSnsAccessToken()
    {
        if (empty($this->_snsAccessToken))
            throw new Exception('尚未设定用户的授权access token');
        return $this->_snsAccessToken;
    }

    /**
     * 获取SNS用户管理器
     *
     * @return \Weixin\Manager\Sns\User
     */
    public function getSnsManager()
    {
        $client = clone $this;
        $client->setAccessToken($client->getSnsAccessToken());
        return new SnsUser($client);
    }

    /**
     * 签名校验
     *
     * @param string $verifyCode            
     * @return boolean
     */
    public function checkSignature($verifyCode)
    {
        if(empty($verifyCode))
            throw new Exception("请设定校验签名所需的verify_code");
        
        $verifyCode = trim($verifyCode);
        $this->_verifyToken = $verifyCode;
        $signature = isset($_GET['signature']) ? trim($_GET['signature']) : '';
        $timestamp = isset($_GET['timestamp']) ? trim($_GET['timestamp']) : '';
        $nonce = isset($_GET['nonce']) ? trim($_GET['nonce']) : '';
        $tmpArr = array(
            $verifyCode,
            $timestamp,
            $nonce
        );
        sort($tmpArr);
        $tmpStr = sha1(implode($tmpArr));
        $this->_signature = $tmpStr;
        return $tmpStr === $signature ? true : false;
    }
    
    /**
     * 获取签名
     * @return string
     */
    public function getSignature() {
        return $this->_signature;
    }

    /**
     * 有效性校验
     */
    public function verify($verifyCode)
    {
        $echoStr = isset($_GET["echostr"]) ? trim($_GET["echostr"]) : '';
        if (! empty($echoStr)) {
            if ($this->checkSignature($verifyCode)) {
                exit($echoStr);
            }
        }
    }

    /**
     * 标准化处理微信的返回结果
     */
    public function rst($rst)
    {
        return $rst;
    }

    public function __destruct()
    {}
}