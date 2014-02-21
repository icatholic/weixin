΢�Ź���ƽ̨����ģʽͨ�ýӿ�API(Weixin)
======

is a PHP (>= 5.2.11) client library for the ΢�Ź���ƽ̨����ģʽͨ�ýӿ�API(Weixin)

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


### �������� ###

```php
try {
	
	$appid="xxxxxxxxxxxx";//appID
	$secret="xxxxxxxxxxxx";//appsecret
	
	//���֮ǰ���access_token����ô�����Client�����ʱ��ֱ��ָ��
	//$access_token = "RWRVPpT1O9SEyN615puzCOQ9uQfgQK0SA63gWUxNo2ABjgHFdnCL82BnFB_wQGeZH4prBLfn17Qz0WSwcwdLW6A2YvX1yN46dDB2-BggdXkqpM0AZXO4lfZ0LSC_5ABj8NxKLxJkqv565EBja32Gpw";
	//$client = new Weixin\Client($appid,$secret,$access_token);
	
	//���֮ǰû�л�ù�access_token����ôͨ��getAccessToken���� ��ȡaccess_token
	$client = new Weixin\Client($appid,$secret);
	$rst = $client->getAccessToken();
	$access_token = $rst['access_token'];
	 
	echo $access_token;
	echo "<br/>";
	
	$openid="xxxxxxxxxxxxxxx";
	
	//���Ϳͷ��ı���Ϣ
	$client->getMsgManager()->getCustom()->sendText($openid, "����");
	
	//���ض�ý���ļ�
	$mediaId= "xxxxxxxxxxxxxxx";
	$ret= $client->getMediaManager()->get($mediaId);
	$fileContent = base64_decode($ret['content']);
	$tmpfname = sys_get_temp_dir().'/'.uniqid().'.jpg';
	//�����ڱ���
	file_put_contents($tmpfname, $fileContent);
	
	//��ȡ΢���û���Ϣ
	$userinfo =$client->getUserManager()->getUserInfo($openid);
	print_r($userinfo);
	echo "<br/>";
	
	//���ticket
	$scene_id =1;
	$ticketInfo = $client->getQrcodeManager()->create($scene_id,false);
	print_r($ticketInfo);
	echo "<br/>";

	//��ȡticket
	$ticket = urlencode($ticketInfo['ticket']);
	$url = $client->getQrcodeManager()->getQrcodeUrl($ticket);
	echo $url;
	echo "<br/>";
} catch (Exception $e) {
	echo($e->getMessage());
}
```


