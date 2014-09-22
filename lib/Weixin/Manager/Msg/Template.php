<?php
namespace Weixin\Manager\Msg;

use Weixin\Client;

/**
 * 模板消息接口
 *
 * @author Ben
 *        
 */
class Template
{

    private $_client;

    public function __construct(Client $client)
    {
        $this->_client = $client;
    }

    /**
     * 发送模板消息
     *
     * @param string $touser            
     * @param string $template_id            
     * @param string $url            
     * @param string $topcolor            
     * @param array $data            
     *
     * @throws Exception
     * @return array
     */
    public function send($touser, $template_id, $url, $topcolor, array $data)
    {
        /**
         * {
         * "touser":"OPENID",
         * "template_id":"ngqIpbwh8bUfcSsECmogfXcV14J0tQlEpBO27izEYtY",
         * "url":"http://weixin.qq.com/download",
         * "topcolor":"#FF0000",
         * "data":{
         * "first": {
         * "value":"您好，您已成功消费。",
         * "color":"#0A0A0A"
         * },
         * "keynote1":{
         * "value":"海记汕头牛肉",
         * "color":"#CCCCCC"
         * },
         * "keynote2": {
         * "value":"8703514836",
         * "color":"#CCCCCC"
         * },
         * "keynote3":{
         * "value":"2014-08-03 19:35",
         * "color":"#CCCCCC"
         * },
         * "remark":{
         * "value":"欢迎再次购买。",
         * "color":"#173177"
         * }
         * }
         */
        $params = array();
        $params['touser'] = $touser;
        $params['template_id'] = $template_id;
        $params['url'] = $url;
        $params['topcolor'] = $topcolor;
        $params['data'] = $data;
        $rst = $this->_client->getRequest()->post('message/template/send', $params);
        return $this->_client->rst($rst);
    }
}
