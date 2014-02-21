微信公众平台开发模式通用接口API(Weixin)
======

is a PHP (>= 5.3) client library for the 微信公众平台开发模式通用接口API(Weixin)

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
	
	//获得access_token
	$objAccessToken = new Weixin\AccessToken($appid,$secret);
	$accessTokenInfo = $objAccessToken->getAccessToken();
	$access_token =$accessTokenInfo['access_token'];	
	echo $access_token;
	echo "<br/>";
	
	$client = new Weixin\Client($appid,$secret,$access_token);	
	$openid="xxxxxxxxxxxxxxx";
	
	//发送客服文本消息
	$client->getMsgManager()->getCustom()->sendText($openid, "测试");
	
	////下载多媒体文件
	//$mediaId= "xxxxxxxxxxxxxxx";
	//$ret= $client->getMediaManager()->get($mediaId);
	//$fileContent = base64_decode($ret['content']);
	//$tmpfname = sys_get_temp_dir().'/'.uniqid().'.jpg';
	////保存在本地
	//file_put_contents($tmpfname, $fileContent);
	
	//获取微信用户信息
	$userinfo =$client->getUserManager()->getUserInfo($openid);
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


