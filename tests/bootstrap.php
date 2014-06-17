// <?php
require __DIR__ . '/../autoload.php';
$appid = "wx31b06d5a578863c1"; // appID
$secret = "36920522135088ff042256ca567ff752"; // appsecret
                                              // token的获取
$objToken = new \Weixin\Token\Server($appid, $secret);
$arrAccessToken = $objToken->getAccessToken();
$strAccessToken = $arrAccessToken['access_token'];
// 微信client对象
$client = new Weixin\Client();
$client->setAccessToken($strAccessToken);

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

$rst = $client->getMediaManager()->uploadVideo("D3uOxo1WNW52dVi4wZE1jwvqySduzVzCApTOmR7pL2hguFECCk2fq82cOxyewF3X", "TITLE", "Description");

$group_id = '0';
// 发送文本
$rst = $client->getMsgManager()
    ->getMassSender()
    ->sendTextByGroup($group_id, 'hello');
// 发送图片
$rst = $client->getMsgManager()
    ->getMassSender()
    ->sendImageByGroup($group_id, 'PTI4V7PGaH2mXtdArQsih6daoyNnEJRHteXo_sJO5yGQQdscEXi7ONRtXsucRYEC');
// 发送音频
$rst = $client->getMsgManager()
    ->getMassSender()
    ->sendVoiceByGroup($group_id, 'yntrDDxEaYYzlBKGheHckrJyszWYL3-a0hEXtYt2oy0dfhWz2hjIZypXnupuEnMk');
// 发送视频
$rst = $client->getMsgManager()
    ->getMassSender()
    ->sendVideoByGroup($group_id, 'g39F9u52K_06kkFzcLilPgyFOgJufnzZr1E39xRjD1NmIu_iEqNI1Kx92eTxipeS');
// 发送图文
$rst = $client->getMsgManager()
    ->getMassSender()
    ->sendGraphTextByGroup($group_id, 'xjZXFr1U7x8b4MZ3CpkF3UGNddGmpHag6La84uak-bKym27gC-D1N0jmQaGzx9bR');

$toUsers = array(
    "oq_9ut1KV35fk7PDFyrfZl3LvVuk",
    "oq_9ut0Jca_pZA02CFDyuLE0UJCQ"
);
// 发送文本
$rst = $client->getMsgManager()
    ->getMassSender()
    ->sendTextByOpenid($toUsers, 'hello');
// 发送图片
$rst = $client->getMsgManager()
    ->getMassSender()
    ->sendImageByOpenid($toUsers, 'PTI4V7PGaH2mXtdArQsih6daoyNnEJRHteXo_sJO5yGQQdscEXi7ONRtXsucRYEC');
// 发送音频
$rst = $client->getMsgManager()
    ->getMassSender()
    ->sendVoiceByOpenid($toUsers, 'yntrDDxEaYYzlBKGheHckrJyszWYL3-a0hEXtYt2oy0dfhWz2hjIZypXnupuEnMk');

// 发送视频
$rst = $client->getMsgManager()
    ->getMassSender()
    ->sendVideoByOpenid($toUsers, 'xdJyQzOv2uTjWpickq3sQjGtDRj5mFFb9e-GP4HgV72ZtP_UDO0TnH29aTYLXy5p', 'testing', 'testing');
// 发送图文
$rst = $client->getMsgManager()
    ->getMassSender()
    ->sendGraphTextByOpenid($toUsers, 'xjZXFr1U7x8b4MZ3CpkF3UGNddGmpHag6La84uak-bKym27gC-D1N0jmQaGzx9bR');
// 删除消息
$rst = $client->getMsgManager()
    ->getMassSender()
    ->delete('2347904591');
