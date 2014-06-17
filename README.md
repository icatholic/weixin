微信公众平台开发模式通用接口API(Weixin)
======

is a PHP (>= 5.2.11) client library for the 微信公众平台开发模式通用接口API(Weixin)

本库在get post upload download方面依赖于zend framework1.12
如果项目非zend framework1.12 请在composer中引用相关的依赖关系

### Loading the library ###

Weixin relies on the autoloading features of PHP to load its files when needed and complies with the
[PSR-0 standard](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md) which makes
it compatible with most PHP frameworks. Autoloading is handled automatically when dependencies are
managed using Composer, but you can also leverage its own autoloader if you are going to use it in a
project or script without any PSR-0 compliant autoloading facility:

```php
// Prepend a base path if Weixin is not available in your "include_path".
require 'Weixin/Autoloader.php';

Weixin\Autoloader::register();
```

It is possible to easily create a [phar](http://www.php.net/manual/en/intro.phar.php) archive from
the repository just by launching `bin/create-phar`. The generated phar contains a stub defining an
autoloader function for Weixin, so you just need to require the phar to start using the library.
Alternatively, it is also possible to generate one single PHP file that holds every class like older
versions of Weixin by launching `bin/create-single-file`, but this practice __is not__ encouraged.


### 调用事例 ###

```php
try {
	
	$appid="xxxxxxxxxxxx";//appID
	$secret="xxxxxxxxxxxx";//appsecret
	$verifyToken = 'XXXXXXXXX';
	
	//token的获取
	$objToken = new \Weixin\Token\Server($appid,$secret);
	$arrAccessToken = $objToken->getAccessToken();
	$strAccessToken = $arrAccessToken['access_token'];
	
	//微信client对象
	$client = new Weixin\Client();
	
	//微信推送服务器验证
	$client->verify($verifyToken);
	
	//对于推送过来的消息，进行签名校验
	$client->checkSignature($verifyToken);
	
	$client->setAccessToken($strAccessToken);
	//通过微信推送过来的消息，获取相应的两个参数
    $client->setFromAndTo($formUserName,$toUserName);
	
	//被动消息
	$client->getMsgManager()->getReplySender()->sendText("测试");
	
	//主动客服消息
	$client->getMsgManager()->getCustomSender()->sendText("测试");
	
	//下载多媒体文件
	$mediaId= "xxxxxxxxxxxxxxx";
	$rst= $client->getMediaManager()->get($mediaId);
	$rst['name'];//文件名称 例如mediaId.jpg
	$rst['bytes'];//文件内容，二进制
	
	//获取微信用户信息
	$userinfo =$client->getUserManager()->getUserInfo($fromUserName);
	print_r($userinfo);
	echo "<br/>";
	
	//生成ticket
	$scene_id =1;
	$ticketInfo = $client->getQrcodeManager()->create($scene_id,false);
	print_r($ticketInfo);
	echo "<br/>";

	//获取ticket
	$ticket = urlencode($ticketInfo['ticket']);
	$url = $client->getQrcodeManager()->getQrcodeUrl($ticket);
	echo $url;
	echo "<br/>";
	
	$articles = array();
	$articles[] = array(
	    "thumb_media_id" => "o9S42TG72uC480YMC99_YKLNtaxi7FtzlWIBx2vnL1pw6zJhS5Abtv880YUzoMOl",
	    "author" => "ben",
	    "title" => "扑刺客打刺客",
	    "content_source_url" => "http://www.baidu.com/",
	    "content" => "扑刺客打刺客",
	    "digest" => "扑刺客打刺客",
	    "show_cover_pic" => "1"
	);
	$articles[] = array(
	    "thumb_media_id" => "o9S42TG72uC480YMC99_YKLNtaxi7FtzlWIBx2vnL1pw6zJhS5Abtv880YUzoMOl",
	    "author" => "ben",
	    "title" => "扑刺客打刺客",
	    "content_source_url" => "http://www.baidu.com/",
	    "content" => "扑刺客打刺客",
	    "digest" => "扑刺客打刺客",
	    "show_cover_pic" => "1"
	);
	$rst = $client->getMediaManager()->uploadNews($articles);
	print_r($$rst);
	echo "<br/>";
	
	$rst = $client->getMediaManager()->uploadVideo("D3uOxo1WNW52dVi4wZE1jwvqySduzVzCApTOmR7pL2hguFECCk2fq82cOxyewF3X", "TITLE", "Description");
	print_r($$rst);
	echo "<br/>";
	
	$group_id = '0';
	// 发送文本
	$rst = $client->getMsgManager()
	    ->getMassSender()
	    ->sendTextByGroup($group_id, 'hello');
	print_r($$rst);
	echo "<br/>";
	
	// 发送图片
	$rst = $client->getMsgManager()
	    ->getMassSender()
	    ->sendImageByGroup($group_id, 'PTI4V7PGaH2mXtdArQsih6daoyNnEJRHteXo_sJO5yGQQdscEXi7ONRtXsucRYEC');
	print_r($$rst);
	echo "<br/>";
		
	// 发送音频
	$rst = $client->getMsgManager()
	    ->getMassSender()
	    ->sendVoiceByGroup($group_id, 'yntrDDxEaYYzlBKGheHckrJyszWYL3-a0hEXtYt2oy0dfhWz2hjIZypXnupuEnMk');
	print_r($$rst);
	echo "<br/>";
	
	// 发送视频
	$rst = $client->getMsgManager()
	    ->getMassSender()
	    ->sendVideoByGroup($group_id, 'g39F9u52K_06kkFzcLilPgyFOgJufnzZr1E39xRjD1NmIu_iEqNI1Kx92eTxipeS');
	print_r($$rst);
	echo "<br/>";
	
	// 发送图文
	$rst = $client->getMsgManager()
	    ->getMassSender()
	    ->sendGraphTextByGroup($group_id, 'xjZXFr1U7x8b4MZ3CpkF3UGNddGmpHag6La84uak-bKym27gC-D1N0jmQaGzx9bR');
	print_r($$rst);
	echo "<br/>";
	
	$toUsers = array(
	    "oq_9ut1KV35fk7PDFyrfZl3LvVuk",
	    "oq_9ut0Jca_pZA02CFDyuLE0UJCQ"
	);
	// 发送文本
	$rst = $client->getMsgManager()
	    ->getMassSender()
	    ->sendTextByOpenid($toUsers, 'hello');
	print_r($$rst);
	echo "<br/>";
	
	// 发送图片
	$rst = $client->getMsgManager()
	    ->getMassSender()
	    ->sendImageByOpenid($toUsers, 'PTI4V7PGaH2mXtdArQsih6daoyNnEJRHteXo_sJO5yGQQdscEXi7ONRtXsucRYEC');
	print_r($$rst);
	echo "<br/>";
		
	// 发送音频
	$rst = $client->getMsgManager()
	    ->getMassSender()
	    ->sendVoiceByOpenid($toUsers, 'yntrDDxEaYYzlBKGheHckrJyszWYL3-a0hEXtYt2oy0dfhWz2hjIZypXnupuEnMk');
	print_r($$rst);
	echo "<br/>";
		
	// 发送视频
	$rst = $client->getMsgManager()
	    ->getMassSender()
	    ->sendVideoByOpenid($toUsers, 'xdJyQzOv2uTjWpickq3sQjGtDRj5mFFb9e-GP4HgV72ZtP_UDO0TnH29aTYLXy5p', 'testing', 'testing');
	print_r($$rst);
	echo "<br/>";
	
	// 发送图文
	$rst = $client->getMsgManager()
	    ->getMassSender()
	    ->sendGraphTextByOpenid($toUsers, 'xjZXFr1U7x8b4MZ3CpkF3UGNddGmpHag6La84uak-bKym27gC-D1N0jmQaGzx9bR');
	print_r($$rst);
	echo "<br/>";
	
	// 删除消息
	$rst = $client->getMsgManager()
	    ->getMassSender()
	    ->delete('2347904591');
	print_r($$rst);
	echo "<br/>";
	
} catch (Exception $e) {
	echo($e->getMessage());
}
```


