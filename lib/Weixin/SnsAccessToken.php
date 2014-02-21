<?php

namespace Weixin;

use Weixin\Helpers;
use Weixin\Exception;

/**
 * 微信公众平台的网页授权调用接口类.
 *
 * @author guoyongrong <handsomegyr@gmail.com>
 */
class SnsAccessToken {
	private $_appid = null;
	public function getAppid() {
		return $this->_appid;
	}
	private $_secret = null;
	public function getAppSecret() {
		return $this->_secret;
	}
	private $_access_token = null;
	private $_refresh_token = null;
		
	public function __construct($appid, $secret, $options = array()) {
		$this->_appid = $appid;
		$this->_secret = $secret;
	}
	
	/**
	 *
	 * @ignore
	 *
	 *
	 */
	private function accessTokenURL() {
		return 'https://api.weixin.qq.com/sns/oauth2/access_token';
	}
	
	/**
	 *
	 * @ignore
	 *
	 *
	 */
	private function refreshTokenURL() {
		return 'https://api.weixin.qq.com/sns/oauth2/refresh_token';
	}
	
	/**
	 * 通过code换取网页授权access_token
	 * 首先请注意，这里通过code换取的网页授权access_token,与基础支持中的access_token不同。
	 * 公众号可通过下述接口来获取网页授权access_token。如果网页授权的作用域为snsapi_base，
	 * 则本步骤中获取到网页授权access_token的同时，
	 * 也获取到了openid，snsapi_base式的网页授权流程即到此为止。
	 */
	public function getSnsAccessToken($code) {
		// 请求方法
		// 获取code后，请求以下链接获取access_token：
		// https://api.weixin.qq.com/sns/oauth2/access_token?appid=APPID&secret=SECRET&code=CODE&grant_type=authorization_code
		// 参数说明
		// 参数 是否必须 说明
		// appid 是 公众号的唯一标识
		// secret 是 公众号的appsecret
		// code 是 填写第一步获取的code参数
		// grant_type 是 填写为authorization_code
		$params = array ();
		$params ['appid'] = $this->_appid;
		$params ['secret'] = $this->_secret;
		$params ['code'] = $code;
		$params ['grant_type'] = 'authorization_code';
		$rst = Helpers::get ( $this->accessTokenURL (), $params );
		// 返回说明
		if (! empty ( $rst ['errcode'] )) {
			// 错误时微信会返回JSON数据包如下（示例为Code无效错误）:
			// {"errcode":40029,"errmsg":"invalid code"}
			throw new Exception ( $rst ['errmsg'], $rst ['errcode'] );
		} else {
			// 正确时返回的JSON数据包如下：
			// {
			// "access_token":"ACCESS_TOKEN",
			// "expires_in":7200,
			// "refresh_token":"REFRESH_TOKEN",
			// "openid":"OPENID",
			// "scope":"SCOPE"
			// }
			// 参数 描述
			// access_token 网页授权接口调用凭证,注意：此access_token与基础支持的access_token不同
			// expires_in access_token接口调用凭证超时时间，单位（秒）
			// refresh_token 用户刷新access_token
			// openid 用户唯一标识，请注意，在未关注公众号时，用户访问公众号的网页，也会产生一个用户和公众号唯一的OpenID
			// scope 用户授权的作用域，使用逗号（,）分隔
			$this->_access_token = $rst ['access_token'];
			$this->_refresh_token = $rst ['refresh_token'];
			$rst ['grant_type'] = 'authorization_code';
			$rst ['code'] = $code;
		}
		return $rst;
	}
	
	/**
	 * 刷新access_token（如果需要）
	 * 由于access_token拥有较短的有效期，
	 * 当access_token超时后，可以使用refresh_token进行刷新，
	 * refresh_token拥有较长的有效期（7天、30天、60天、90天），
	 * 当refresh_token失效的后，需要用户重新授权。
	 */
	public function getSnsRefreshToken($refresh_token) {
		// 请求方法
		// 获取第二步的refresh_token后，请求以下链接获取access_token：
		// https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=APPID&grant_type=refresh_token&refresh_token=REFRESH_TOKEN
		// 参数 是否必须 说明
		// appid 是 公众号的唯一标识
		// grant_type 是 填写为refresh_token
		// refresh_token 是 填写通过access_token获取到的refresh_token参数
		$params = array ();
		$params ['appid'] = $this->_appid;
		$params ['grant_type'] = 'refresh_token';
		$params ['refresh_token'] = $refresh_token;
		$rst = Helpers::get ( $this->refreshTokenURL (), $params );
		// 返回说明
		if (! empty ( $rst ['errcode'] )) {
			// 错误时微信会返回JSON数据包如下（示例为Code无效错误）:
			// {"errcode":40029,"errmsg":"invalid code"}
			throw new Exception ( $rst ['errmsg'], $rst ['errcode'] );
		} else {
			// 正确时返回的JSON数据包如下：
			// {
			// "access_token":"ACCESS_TOKEN",
			// "expires_in":7200,
			// "refresh_token":"REFRESH_TOKEN",
			// "openid":"OPENID",
			// "scope":"SCOPE"
			// }
			// 参数 描述
			// access_token 网页授权接口调用凭证,注意：此access_token与基础支持的access_token不同
			// expires_in access_token接口调用凭证超时时间，单位（秒）
			// refresh_token 用户刷新access_token
			// openid 用户唯一标识
			// scope 用户授权的作用域，使用逗号（,）分隔
			$this->_access_token = $rst ['access_token'];
			$this->_refresh_token = $rst ['refresh_token'];
			$this->_access_token = $rst ['access_token'];
			$rst ['grant_type'] = 'refresh_token';
		}
		return $rst;
	}
	
	/**
	 * 获取Token
	 * @param unknown_type $key
	 * @return Ambigous <NULL>
	 */
	public function getToken($key = "access_token") {
		$token = array (
				'access_token' => $this->_access_token,
				'refresh_token' => $this->_refresh_token 
		);
		return $token [$key];
	}
	
	public function __destruct() {
	}
}

