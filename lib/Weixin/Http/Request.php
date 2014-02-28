<?php
/**
 * 处理HTTP请求
 * 
 * 使用Guzzle http client库做为请求发起者，以便日后采用异步请求等方式加快代码执行速度
 * 
 * @author young <youngyang@icatholic.net.cn>
 *
 */
namespace Weixin\Http;

use Weixin\Exception;
use Guzzle\Http\Client;
use Guzzle\Http\Message\PostFile;
use Guzzle\Http\ReadLimitEntityBody;

class Request
{

    private $_serviceBaseUrl = 'https://api.weixin.qq.com/cgi-bin/';

    private $_mediaBaseUrl = 'http://file.api.weixin.qq.com/cgi-bin/';

    private $_accessToken = null;

    public function __construct($accessToken)
    {
        $this->_accessToken = $accessToken;
        if (empty($this->_accessToken)) {
            throw new Exception("access_token为空");
        }
    }

    /**
     * 获取微信服务器信息
     *
     * @param string $url            
     * @param array $params            
     * @return mixed
     */
    public function get($url, $params = array())
    {
        $client = new Client($this->_serviceBaseUrl);
        $params['access_token'] = $this->_accessToken;
        $request = $client->get($url, array(), array(
            'query' => $params
        ));
        $response = $client->send($request);
        if ($response->isSuccessful()) {
            return $response->json();
        } else {
            throw new Exception("微信服务器未有效的响应请求");
        }
    }

    /**
     * 推送消息给到微信服务器
     *
     * @param string $url            
     * @param array $params            
     * @return mixed
     */
    public function post($url, $params = array())
    {
        $client = new Client($this->_serviceBaseUrl);
        $client->setDefaultOption('query', array(
            'access_token' => $this->_accessToken
        ));
        $client->setDefaultOption('body', json_encode($params, JSON_UNESCAPED_UNICODE));
        $request = $client->post($url);
        $response = $client->send($request);
        if ($response->isSuccessful()) {
            return $response->json();
        } else {
            throw new Exception("微信服务器未有效的响应请求");
        }
    }

    /**
     * 上传微信多媒体文件
     *
     * @param string $type            
     * @param string $media
     *            url或者filepath
     * @throws Exception
     * @return mixed
     */
    public function upload($type, $media)
    {
        $client = new Client('http://file.api.weixin.qq.com/cgi-bin/');
        $client->setDefaultOption('query', array(
            'access_token' => $this->_accessToken,
            'type' => $type
        ));
        $request = $client->post('media/upload');
        if (filter_var($media, FILTER_VALIDATE_URL) !== false) {
            $fileInfo = $this->getFileByUrl($media);
            var_dump($fileInfo);
            $fileName = $fileInfo['name'];
            $tmp = tempnam(sys_get_temp_dir(), 'temp_file');
            file_put_contents($tmp, $fileInfo['bytes']);
            $request->addPostFile(new PostFile('media', $tmp));
            unlink($tmp);
        } elseif (is_readable($media)) {
            $request->addPostFile(new PostFile('media', $media));
        } else {
            throw new Exception("无效的上传文件");
        }
        
        $response = $client->send($request);
        if ($response->isSuccessful()) {
            return $response->json();
        } else {
            throw new Exception("微信服务器未有效的响应请求");
        }
    }

    /**
     * 下载指定路径的文件资源
     *
     * @param string $mediaId            
     * @return array
     */
    public function download($mediaId)
    {
        $url = 'http://file.api.weixin.qq.com/cgi-bin/media/get' . '?access_token=' . $this->_accessToken . '&media_id=' . $mediaId;
        return $this->getFileByUrl($url);
    }

    /**
     * 下载文件
     *
     * @param string $url            
     * @throws Exception
     * @return array
     */
    private function getFileByUrl($url = '')
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new Exception('无效的URL');
        }
        
        $client = new Client($url);
        $request = $client->get();
        $response = $client->send($request);
        if ($response->isSuccessful()) {
            $disposition = $response->getContentDisposition();
            $reDispo = '/^.*?filename=(?<f>[^\s]+|\x22[^\x22]+\x22)\x3B?.*$/m';
            if (preg_match($reDispo, $disposition, $mDispo)) {
                $filename = trim($mDispo['f'], ' ";');
                $entityBody = $response->getBody();
                $filter = $entityBody->getContentEncoding();
                if($filter!==false) {
                    $entityBody->uncompress($filter);
                }
                $length = $entityBody->getContentLength();
                $objReader = new ReadLimitEntityBody($entityBody,$length);
                $fileBytes = $objReader->read($length);
                return array(
                    'name' => $filename,
                    'bytes' => $fileBytes
                );
            } else {
                return $response->json();
            }
        } else {
            throw new Exception("获取文件失败，请检查下载文件的URL是否有效");
        }
    }

    public function __destruct()
    {}
}