<?php

namespace Weixin;
use Weixin\WeixinOAuthRequest;

/**
 * Defines a few helper methods.
 *
 * @author guoyongrong <handsomegyr@gmail.com>
 */
class Helpers {
	/**
	 *
	 *
	 * 检测一个字符串否为Json字符串
	 * 
	 * @param string $string        	
	 * @return true/false
	 *
	 */
	public static function isJson($string) {
		if (strpos ( $string, "{" ) !== false) {
			json_decode ( $string );
			return (json_last_error () == JSON_ERROR_NONE);
		} else {
			return false;
		}
	}
	
	/**
	 * 除去数组中的空值和签名参数
	 * 
	 * @param $para 签名参数组
	 *        	return 去掉空值与签名参数后的新签名参数组
	 */
	public static function paraFilter($para) {
		$para_filter = array ();
		while ( list ( $key, $val ) = each ( $para ) ) {
			if ($key == "sign" || $key == "sign_type" || $val == "")
				continue;
			else
				$para_filter [$key] = $para [$key];
		}
		return $para_filter;
	}
	/**
	 * 对数组排序
	 * 
	 * @param $para 排序前的数组
	 *        	return 排序后的数组
	 */
	public static function argSort($para) {
		ksort ( $para );
		reset ( $para );
		return $para;
	}
	
// 	/**
// 	 * POST 信息到指定的URL
// 	 * 
// 	 * @param string $url        	
// 	 * @param string $json        	
// 	 * @return array
// 	 */
// 	public static function post($url, $parameters = array(), $multi = false) {
// 		$client = new \Zend_Http_Client ();
// 		$client->setUri ( $url );
// 		if ((is_array ( $parameters ) || is_object ( $parameters ))) {
// 			$client->setParameterPost ( $parameters );
// 		} else {
// 			$client->setRawData ( $parameters );
// 		}
// 		$client->setEncType ( \Zend_Http_Client::ENC_URLENCODED );
// 		$client->setConfig ( array (
// 				'maxredirects' => 3 
// 		) );
// 		$response = $client->request ( 'POST' );
// 		$message = $response->getBody ();
// 		$message = preg_replace ( "/^\xEF\xBB\xBF/", '', $message );
// 		$message = preg_replace ( "/[\n\t\s\r]+/", '', $message );
// 		return json_decode ( $message, true );
// 	}
	
// 	/**
// 	 * 执行GET操作
// 	 * 
// 	 * @param string $url        	
// 	 * @param array $params        	
// 	 * @return string
// 	 */
// 	public static function get($url, $params = array()) {
// 		$client = new \Zend_Http_Client ();
// 		$client->setUri ( $url );
// 		$client->setParameterGet ( $params );
// 		$client->setEncType ( \Zend_Http_Client::ENC_URLENCODED );
// 		$client->setConfig ( array (
// 				'maxredirects' => 3 
// 		) );
// 		$response = $client->request ( 'GET' );
// 		$message = $response->getBody ();
// 		$message = preg_replace ( "/^\xEF\xBB\xBF/", '', $message );
// 		$message = preg_replace ( "/[\n\t\s\r]+/", '', $message );
// 		return $message;
// 	}
	
	/**
	 * GET wrappwer for oAuthRequest.
	 *
	 * @return mixed
	 */
	public static function get ($url, $parameters = array())
	{
		$request = new WeixinOAuthRequest();
		return $request->get($url, $parameters);
	}
	
	/**
	 * POST wreapper for oAuthRequest.
	 *
	 * @return mixed
	 */
	public static function post ($url, $parameters = array(), $multi = false)
	{
		$request = new WeixinOAuthRequest();
		return $request->post($url, $parameters, $multi);
	}
}

