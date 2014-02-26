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
	
	
	//如果之前获得access_token，那么在生成WeixinClient对象的时候，直接指定
	//$access_token = "RWRVPpT1O9SEyN615puzCOQ9uQfgQK0SA63gWUxNo2ABjgHFdnCL82BnFB_wQGeZH4prBLfn17Qz0WSwcwdLW6A2YvX1yN46dDB2-BggdXkqpM0AZXO4lfZ0LSC_5ABj8NxKLxJkqv565EBja32Gpw";
	//$client = new Weixin\WeixinClient($appid,$secret,$access_token);
	
	//如果之前没有获得过access_token，那么通过getAccessToken方法 获取access_token
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
} catch (Exception $e) {
	echo($e->getMessage());
}
```


