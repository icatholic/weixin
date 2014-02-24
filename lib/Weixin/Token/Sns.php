<?php
namespace Weixin\Token;
use Weixin\Exception;

class Sns
{

    private $_appid;

    private $_secret;

    private $_redirect_uri;

    private $_scope = 'snsapi_base';

    private $_state;

    public function __construct ($appid, $secret, $redirect_uri, 
            $scope = 'snsapi_userinfo', $state = '')
    {
        if (empty($appid)) {
            throw new Exception('请设定$appid');
        }
        if (empty($secret)) {
            throw new Exception('请设定$secret');
        }
        if (filter_var($redirect_uri, FILTER_VALIDATE_URL) === false) {
            throw new Exception('$redirect_uri无效');
        }
        if (!in_array($scope, array(
                'snsapi_userinfo',
                'snsapi_base'
        ), true)) {
            throw new Exception('$scope无效');
        }
            
            $this->_appid = $appid;
        $this->_secret = $secret;
        $this->_redirect_uri = $redirect_uri;
        $this->_scope = $scope;
        $this->_state = $state;
    }

    /**
     * 获取认证地址的URL
     */
    public function getAuthorizeUrl ()
    {
        header(
                "location:https://open.weixin.qq.com/connect/oauth2/authorize?appid={$this->_appid}&redirect_uri={$this->_redirect_uri}&response_type=code&scope={$this->_scope}&state={$this->_state}#wechat_redirect");
        exit();
    }

    /**
     * 获取access token
     *
     * @throws Exception
     * @return array
     */
    public function getAccessToken ()
    {
        $code = isset($_GET['code']) ? trim($_GET['code']) : '';
        if ($code == '') {
            throw new Exception('code不能为空');
        }
        $response = file_get_contents(
                "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$this->_appid}&secret={$this->_secret}&code={$code}&grant_type=authorization_code");
        $response = json_decode($response, true);
        return $response;
    }

    /**
     * 通过refresh token获取新的access token
     */
    public function getRefreshToken ($refreshToken)
    {
        $response = file_get_contents(
                "https://api.weixin.qq.com/sns/oauth2/refresh_token?appid={$this->_appid}&grant_type=refresh_token&refresh_token={$refreshToken}");
        $response = json_decode($response, true);
        return $response;
    }

    public function __destruct ()
    {}
}