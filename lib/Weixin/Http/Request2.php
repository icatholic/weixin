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

class Request2
{

    protected $_accessToken = null;

    protected $_tmp = null;

    protected $_accessTokenName = 'access_token';

    public function __construct($accessToken = '')
    {
        $this->_accessToken = $accessToken;
    }

    /**
     * 获取微信服务器信息
     *
     * @param string $url            
     * @param array $params            
     * @return mixed
     */
    public function get($url, $params = array(), $options = array())
    {
        $client = new Client();
        $query = $this->getQueryParam4AccessToken();
        $params = array_merge($params, $query);
        $request = $client->get($url, array(), array(
            'query' => $params
        ), $options);
        $request->getCurlOptions()->set(CURLOPT_SSLVERSION, 1); // CURL_SSLVERSION_TLSv1
        $response = $client->send($request);
        if ($response->isSuccessful()) {
            return $this->getJson($response); // $response->json();
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
    public function post($url, $params = array(), $options = array())
    {
        $client = new Client();
        $query = $this->getQueryParam4AccessToken();
        $client->setDefaultOption('query', $query);
        $client->setDefaultOption('body', json_encode($params, JSON_UNESCAPED_UNICODE));
        $request = $client->post($url, null, null, $options);
        $request->getCurlOptions()->set(CURLOPT_SSLVERSION, 1); // CURL_SSLVERSION_TLSv1
        $response = $client->send($request);
        if ($response->isSuccessful()) {
            return $this->getJson($response); // $response->json();
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
        $url = 'https://api.weixin.qq.com/cgi-bin/media/get?access_token=' . $this->_accessToken . '&media_id=' . $mediaId;
        return $this->getFileByUrl($url);
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
        $query = array(
            'type' => $type
        );
        return $this->sendUploadFileRequest('https://api.weixin.qq.com/cgi-bin/media/upload', $query, $media);
    }

    /**
     * 上传客服头像
     *
     * @param string $kf_account            
     * @param string $media
     *            url或者filepath
     * @throws Exception
     * @return mixed
     */
    public function uploadheadimg4KfAcount($kf_account, $media)
    {
        $query = array(
            'kf_account' => $kf_account
        );
        return $this->sendUploadFileRequest('https://api.weixin.qq.com/customservice/kfacount/uploadheadimg', $query, $media);
    }

    /**
     * 上传文件
     *
     * @param string $baseUrl            
     * @param string $uri            
     * @param string $media
     *            url或者filepath
     * @param array $options            
     * @throws Exception
     * @return mixed
     */
    public function uploadFile($baseUrl, $uri, $media, array $options = array('fieldName'=>'media'))
    {
        $query = array();
        return $this->sendUploadFileRequest($baseUrl . $uri, $query, $media, $options);
    }

    /**
     * 上传文件
     *
     * @param string $uri            
     * @param array $fileParams            
     * @param array $extraParams            
     * @throws Exception
     * @return mixed
     */
    public function uploadFiles($uri, array $fileParams, array $extraParams = array())
    {
        $client = new Client();
        $query = $this->getQueryParam4AccessToken();
        $client->setDefaultOption('query', $query);
        
        $files = array();
        foreach ($fileParams as $fileName => $media) {
            if (filter_var($media, FILTER_VALIDATE_URL) !== false) {
                $fileInfo = $this->getFileByUrl($media);
                $media = $this->saveAsTemp($fileInfo['name'], $fileInfo['bytes']);
            } elseif (is_readable($media)) {} else {
                throw new Exception("无效的上传文件");
            }
            $files[$fileName] = $media;
        }
        $request = $client->post($uri);
        // 如果需要额外的提交参数的话
        if (! empty($extraParams)) {
            $request->addPostFields($extraParams);
        }
        $request->addPostFiles($files);
        $request->getCurlOptions()->set(CURLOPT_SSLVERSION, 1); // CURL_SSLVERSION_TLSv1
        
        $response = $request->send();
        if ($response->isSuccessful()) {
            return $this->getJson($response); // $response->json();
        } else {
            throw new Exception("微信服务器未有效的响应请求");
        }
    }

    /**
     * 下载文件
     *
     * @param string $url            
     * @throws Exception
     * @return array
     */
    protected function getFileByUrl($url = '')
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new Exception('无效的URL');
        }
        
        $client = new Client($url);
        $request = $client->get();
        $request->getCurlOptions()->set(CURLOPT_SSLVERSION, 1); // CURL_SSLVERSION_TLSv1
        $response = $client->send($request);
        if ($response->isSuccessful()) {
            $disposition = $response->getContentDisposition();
            // $disposition = iconv('UTF-8', 'GBK//IGNORE', $disposition);
            // $reDispo = '/^.*?filename=(?<f>[^\s]+|\x22[^\x22]+\x22)\x3B?.*$/m';
            $reDispo = '/^.*?filename=(?<f>.*\.[^\s]+|\x22[^\x22]+\x22)\x3B?.*$/m';
            if (preg_match($reDispo, $disposition, $mDispo)) {
                $filename = trim($mDispo['f'], ' ";');
            } else {
                $filename = uniqid() . '.jpg';
            }
            $entityBody = $response->getBody();
            $filter = $entityBody->getContentEncoding();
            if ($filter !== false) {
                $entityBody->uncompress($filter);
            }
            $length = $entityBody->getContentLength();
            $objReader = new ReadLimitEntityBody($entityBody, $length);
            $fileBytes = $objReader->read($length);
            return array(
                'name' => $filename,
                'bytes' => $fileBytes
            );
        } else {
            throw new Exception("获取文件失败，请检查下载文件的URL是否有效");
        }
    }

    /**
     * 将指定文件名和内容的数据，保存到临时文件中，在析构函数中删除临时文件
     *
     * @param string $fileName            
     * @param bytes $fileBytes            
     * @return string
     */
    protected function saveAsTemp($fileName, $fileBytes)
    {
        $this->_tmp = sys_get_temp_dir() . '/temp_files_' . $fileName;
        file_put_contents($this->_tmp, $fileBytes);
        return $this->_tmp;
    }

    protected function getJson($response)
    {
        $body = $response->getBody(true);
        // die($body);
        // $body = substr(str_replace('\"', '"', json_encode($body)), 1, - 1);
        $response->setBody($body);
        return $response->json();
    }

    protected function sendUploadFileRequest($url, array $otherQuery, $media, array $options = array('fieldName'=>'media'))
    {
        $client = new Client();
        $query = $this->getQueryParam4AccessToken();
        if (! empty($otherQuery)) {
            $query = array_merge($query, $otherQuery);
        }
        $client->setDefaultOption('query', $query);
        
        if (filter_var($media, FILTER_VALIDATE_URL) !== false) {
            $fileInfo = $this->getFileByUrl($media);
            $media = $this->saveAsTemp($fileInfo['name'], $fileInfo['bytes']);
        } elseif (is_readable($media)) {} else {
            throw new Exception("无效的上传文件");
        }
        
        $request = $client->post($url)->addPostFiles(array(
            $options['fieldName'] => $media
        ));
        $request->getCurlOptions()->set(CURLOPT_SSLVERSION, 1); // CURL_SSLVERSION_TLSv1
        
        $response = $request->send();
        if ($response->isSuccessful()) {
            return $this->getJson($response); // $response->json();
        } else {
            throw new Exception("微信服务器未有效的响应请求");
        }
    }

    protected function getQueryParam4AccessToken()
    {
        $params = array();
        if (! empty($this->_accessTokenName) && ! empty($this->_accessToken)) {
            $params[$this->_accessTokenName] = $this->_accessToken;
        }
        return $params;
    }

    public function __destruct()
    {
        if (! empty($this->_tmp)) {
            unlink($this->_tmp);
        }
    }
}