<?php

namespace Weixin;

use Weixin\Helpers;
use Weixin\Exception;

/**
 * 微信公众平台的调用接口类.
 *
 * @author guoyongrong <handsomegyr@gmail.com>
 */
class AccessToken {
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
	private $_url = 'https://api.weixin.qq.com/cgi-bin/';
	public function __construct($appid, $secret, $options = array()) {
		$this->_appid = $appid;
		$this->_secret = $secret;
	}
	
	/**
	 * 获取access_token
	 * access_token是公众号的全局唯一票据，
	 * 公众号调用各接口时都需使用access_token。
	 * 正常情况下access_token有效期为7200秒，
	 * 重复获取将导致上次获取的access_token失效。
	 * 公众号可以使用AppID和AppSecret调用本接口来获取access_token。
	 * AppID和AppSecret可在开发模式中获得（需要已经成为开发者，且帐号没有异常状态）。
	 * 注意调用所有微信接口时均需使用https协议。
	 */
	public function getAccessToken() {
		// http请求方式: GET
		// https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=APPID&secret=APPSECRET
		$params = array ();
		$params ['grant_type'] = 'client_credential';
		$params ['appid'] = $this->_appid;
		$params ['secret'] = $this->_secret;
		$rst = Helpers::get ( $this->_url . 'token', $params );
		
		if (! empty ( $rst ['errcode'] )) {
			// 错误时微信会返回错误码等信息，JSON数据包示例如下（该示例为AppID无效错误）:
			// {"errcode":40013,"errmsg":"invalid appid"}
			throw new Exception ( $rst ['errmsg'], $rst ['errcode'] );
		} else {
			// 正常情况下，微信会返回下述JSON数据包给公众号：
			// {"access_token":"ACCESS_TOKEN","expires_in":7200}
			// 参数 说明
			// access_token 获取到的凭证
			// expires_in 凭证有效时间，单位：秒
			$this->_access_token = $rst ['access_token'];
			$rst ['grant_type'] = 'client_credential';
		}
		return $rst;
	}
	/**
	 * 获取token
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

