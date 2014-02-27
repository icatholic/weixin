<?php
namespace Weixin\Token;

use Weixin\Exception;

class Sns
{

    private $_appid;

    private $_secret;

    private $_redirect_uri;

    private $_scope = 'snsapi_userinfo';

    private $_state = '';

    public function __construct($appid, $secret)
    {
        if (empty($appid)) {
            throw new Exception('请设定$appid');
        }
        if (empty($secret)) {
            throw new Exception('请设定$secret');
        }
        
        $this->_appid = $appid;
        $this->_secret = $secret;
    }

    /**
     * 设定微信回调地址
     * 
     * @param string $redirect_uri            
     * @throws Exception
     */
    public function setRedirectUri($redirect_uri)
    {
        if (filter_var($redirect_uri, FILTER_VALIDATE_URL) === false) {
            throw new Exception('$redirect_uri无效');
        }
        $this->_redirect_uri = $redirect_uri;
    }

    /**
     * 设定作用域类型
     * 
     * @param string $scope            
     * @throws Exception
     */
    public function setScope($scope)
    {
        if (! in_array($scope, array(
            'snsapi_userinfo',
            'snsapi_base'
        ), true)) {
            throw new Exception('$scope无效');
        }
        $this->_scope = $scope;
    }

    /**
     * 设定携带参数信息，请使用rawurlencode编码
     * 
     * @param string $state            
     */
    public function setState($state)
    {
        $this->_state = $state;
    }

    /**
     * 获取认证地址的URL
     */
    public function getAuthorizeUrl()
    {
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$this->_appid}&redirect_uri={$this->_redirect_uri}&response_type=code&scope={$this->_scope}&state={$this->_state}#wechat_redirect";
        header("location:{$url}");
        exit();
    }

    /**
     * 获取access token
     *
     * @throws Exception
     * @return array
     */
    public function getAccessToken()
    {
        $code = isset($_GET['code']) ? trim($_GET['code']) : '';
        if ($code == '') {
            throw new Exception('code不能为空');
        }
        $response = file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid={$this->_appid}&secret={$this->_secret}&code={$code}&grant_type=authorization_code");
        $response = json_decode($response, true);
        return $response;
    }

    /**
     * 通过refresh token获取新的access token
     */
    public function getRefreshToken($refreshToken)
    {
        $response = file_get_contents("https://api.weixin.qq.com/sns/oauth2/refresh_token?appid={$this->_appid}&grant_type=refresh_token&refresh_token={$refreshToken}");
        $response = json_decode($response, true);
        return $response;
    }

    public function __destruct()
    {}
}