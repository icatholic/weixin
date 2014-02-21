<?php
namespace Weixin\Manager;
use Weixin\Helpers;
use Weixin\WeixinException;
use Weixin\Client;
use Weixin\Manager\Msg\Custom;
use Weixin\Manager\Msg\Reply;

/**
 * 发送消息接口
 *
 * @author guoyongrong <handsomegyr@gmail.com>
 */
class Msg
{
	private $_length = 140;
	public function getLength()
	{
		return $this->_length;
	}

	protected  $weixin;
	/**
	 * GET Client object.
	 *
	 * @return Client
	 */
	public function getWeixin()
	{
		return $this->weixin;
	}

	protected $reply;
	/**
	 * GET Reply object.
	 *
	 * @return Reply
	 */
	public function getReply()
	{
		return $this->reply;
	}

	protected $custom;
	/**
	 * GET Custom object.
	 *
	 * @return Custom
	 */
	public function getCustom()
	{
		return $this->custom;
	}

	public function __construct(Client $weixin,$options=array()) {
		$this->weixin = $weixin;
		//发送被动响应消息发射器
		$this->reply = new Reply($this,$options);
		//发送客服消息发射器
		$this->custom = new Custom($this,$options);
	}

}