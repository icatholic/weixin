<?php

namespace Weixin;

use Weixin\Helpers;
use Weixin\WeixinException;
use Weixin\Manager\Groups;
use Weixin\Manager\Media;
use Weixin\Manager\Menu;
use Weixin\Manager\Msg;
use Weixin\Manager\Qrcode;
use Weixin\Manager\User;

/**
 * 微信公众平台的调用接口类.
 *
 * @author guoyongrong <handsomegyr@gmail.com>
 */
class Client {
	private $_appid = null;
	public function getAppid() {
		return $this->_appid;
	}
	private $_secret = null;
	public function getAppSecret() {
		return $this->_secret;
	}
	private $_access_token = null;
	public function setAccessToken($accessToken) {
		$this->_access_token = $accessToken;
	}
	private $_refresh_token = null;
	private $_url = 'https://api.weixin.qq.com/cgi-bin/';
	protected $msgManager;
	/**
	 * GET MsgManager object.
	 *
	 * @return MsgManager
	 */
	public function getMsgManager() {
		return $this->msgManager;
	}
	protected $userManager;
	/**
	 * GET UserManager object.
	 *
	 * @return UserManager
	 */
	public function getUserManager() {
		return $this->userManager;
	}
	protected $qrcodeManager;
	/**
	 * GET QrcodeManager object.
	 *
	 * @return QrcodeManager
	 */
	public function getQrcodeManager() {
		return $this->qrcodeManager;
	}
	protected $menuManager;
	/**
	 * GET MenuManager object.
	 *
	 * @return MenuManager
	 */
	public function getMenuManager() {
		return $this->menuManager;
	}
	protected $groupsManager;
	/**
	 * GET GroupsManager object.
	 *
	 * @return GroupsManager
	 */
	public function getGroupsManager() {
		return $this->groupsManager;
	}
	protected $mediaManager;
	/**
	 * GET MediaManager object.
	 *
	 * @return MediaManager
	 */
	public function getMediaManager() {
		return $this->mediaManager;
	}
	public function __construct($appid, $secret, $access_token = NULL, $refresh_token = NULL, $options = array()) {
		$this->_appid = $appid;
		$this->_secret = $secret;
		$this->_access_token = $access_token;
		$this->_refresh_token = $refresh_token;
		
		// 发送消息管理
		$this->msgManager = new Msg ( $this, $options );
		// 用户管理
		$this->userManager = new User ( $this, $options );
		// 推广支持
		$this->qrcodeManager = new Qrcode ( $this, $options );
		// 自定义菜单
		$this->menuManager = new Menu ( $this, $options );
		// 分组管理
		$this->groupsManager = new Groups ( $this, $options );
		// 上传下载多媒体文件管理
		$this->mediaManager = new Media ( $this, $options );
	}
	
	/**
	 * 获取token
	 */
	public function getToken($key = "access_token") {
		$token = array (
				'access_token' => $this->_access_token,
				'refresh_token' => $this->_refresh_token 
		);
		return $token [$key];
	}
	
	/**
	 * GET wrappwer for Request.
	 *
	 * @return mixed
	 */
	public function get($url, $parameters = array()) {
		$response = Helpers::get ( $url, $parameters );
		return $response;
	}
	
	/**
	 * POST wreapper for Request.
	 *
	 * @return mixed
	 */
	public function post($url, $parameters = array(), $multi = false) {
		$response = Helpers::post ( $url, $parameters, $multi );
		return $response;
	}
	public function __destruct() {
	}
}

