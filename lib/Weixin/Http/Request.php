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

    private $_serviceBaseUrl2 = 'http://api.weixin.qq.com/';

    private $_snsBaseUrl = 'https://api.weixin.qq.com/';
    
    // private $_mediaBaseUrl = 'http://file.api.weixin.qq.com/cgi-bin/';
    private $_mediaBaseUrl = 'https://api.weixin.qq.com/cgi-bin/';

    private $_payBaseUrl = 'https://api.weixin.qq.com/';

    private $_pay337BaseUrl = 'https://api.mch.weixin.qq.com/';

    private $_accessToken = null;

    private $_tmp = null;

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
        if ($url == 'sns/userinfo') {
            $client = new Client($this->_snsBaseUrl);
        } else {
            $client = new Client($this->_serviceBaseUrl);
        }
        $params['access_token'] = $this->_accessToken;
        $request = $client->get($url, array(), array(
            'query' => $params
        ));
        $request->getCurlOptions()->set(CURLOPT_SSLVERSION, 1); // CURL_SSLVERSION_TLSv1
        $response = $client->send($request);
        if ($response->isSuccessful()) {
            return $this->getJson($response); // $response->json();
        } else {
            throw new Exception("微信服务器未有效的响应请求");
        }
    }

    public function get2($url, $params = array())
    {
        if ($url == 'sns/userinfo') {
            $client = new Client($this->_snsBaseUrl);
        } else {
            $client = new Client($this->_serviceBaseUrl);
        }
        $params['access_token'] = $this->_accessToken;
        $request = $client->get($url, array(), array(
            'query' => $params
        ));
        $request->getCurlOptions()->set(CURLOPT_SSLVERSION, 1); // CURL_SSLVERSION_TLSv1
        $response = $client->send($request);
        if ($response->isSuccessful()) {
            return $response->getBody(true);
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
    public function post2($url, $params = array())
    {
        $client = new Client($this->_serviceBaseUrl2);
        $client->setDefaultOption('query', array(
            'access_token' => $this->_accessToken
        ));
        $client->setDefaultOption('body', json_encode($params, JSON_UNESCAPED_UNICODE));
        $request = $client->post($url);
        $request->getCurlOptions()->set(CURLOPT_SSLVERSION, 1); // CURL_SSLVERSION_TLSv1
        $response = $client->send($request);
        if ($response->isSuccessful()) {
            return $this->getJson($response); // $response->json();
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
        $client = new Client($this->_mediaBaseUrl);
        $client->setDefaultOption('query', array(
            'access_token' => $this->_accessToken,
            'type' => $type
        ));
        
        if (filter_var($media, FILTER_VALIDATE_URL) !== false) {
            $fileInfo = $this->getFileByUrl($media);
            $media = $this->saveAsTemp($fileInfo['name'], $fileInfo['bytes']);
        } elseif (is_readable($media)) {
            $media = $media;
        } else {
            throw new Exception("无效的上传文件");
        }
        
        $request = $client->post('media/upload')->addPostFiles(array(
            'media' => $media
        ));
        $request->getCurlOptions()->set(CURLOPT_SSLVERSION, 1); // CURL_SSLVERSION_TLSv1
        
        $response = $request->send();
        if ($response->isSuccessful()) {
            return $this->getJson($response); // $response->json();
        } else {
            throw new Exception("微信服务器未有效的响应请求");
        }
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
        $client = new Client($this->_payBaseUrl);
        $client->setDefaultOption('query', array(
            'access_token' => $this->_accessToken,
            'kf_account' => $kf_account
        ));
        
        if (filter_var($media, FILTER_VALIDATE_URL) !== false) {
            $fileInfo = $this->getFileByUrl($media);
            $media = $this->saveAsTemp($fileInfo['name'], $fileInfo['bytes']);
        } elseif (is_readable($media)) {
            $media = $media;
        } else {
            throw new Exception("无效的上传文件");
        }
        
        $request = $client->post('customservice/kfacount/uploadheadimg')->addPostFiles(array(
            'media' => $media
        ));
        $request->getCurlOptions()->set(CURLOPT_SSLVERSION, 1); // CURL_SSLVERSION_TLSv1
        
        $response = $request->send();
        if ($response->isSuccessful()) {
            return $this->getJson($response); // $response->json();
        } else {
            throw new Exception("微信服务器未有效的响应请求");
        }
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
        $client = new Client($baseUrl);
        $client->setDefaultOption('query', array(
            'access_token' => $this->_accessToken
        ));
        
        if (filter_var($media, FILTER_VALIDATE_URL) !== false) {
            $fileInfo = $this->getFileByUrl($media);
            $media = $this->saveAsTemp($fileInfo['name'], $fileInfo['bytes']);
        } elseif (is_readable($media)) {
            $media = $media;
        } else {
            throw new Exception("无效的上传文件");
        }
        
        $request = $client->post($uri)->addPostFiles(array(
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

    /**
     * 推送消息给到微信服务器
     *
     * @param string $url            
     * @param array $params            
     * @return mixed
     */
    public function mediaPost($url, $params = array())
    {
        // $client = new Client($this->_mediaBaseUrl);
        $client = new Client();
        $client->setDefaultOption('query', array(
            'access_token' => $this->_accessToken
        ));
        $client->setDefaultOption('body', json_encode($params, JSON_UNESCAPED_UNICODE));
        $request = $client->post($url);
        $request->getCurlOptions()->set(CURLOPT_SSLVERSION, 1); // CURL_SSLVERSION_TLSv1
                                                                
        // $request->getCurlOptions()->set(CURLOPT_SSL_VERIFYPEER, FALSE);
                                                                
        // $request->getCurlOptions()->set(CURLOPT_SSL_VERIFYHOST, FALSE);
        
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
        $url = $this->_mediaBaseUrl . 'media/get' . '?access_token=' . $this->_accessToken . '&media_id=' . $mediaId;
        return $this->getFileByUrl($url);
    }

    /**
     * 获取微信服务器信息
     *
     * @param string $url            
     * @param array $params            
     * @return mixed
     */
    public function payGet($url, $params = array())
    {
        $client = new Client($this->_payBaseUrl);
        $params['access_token'] = $this->_accessToken;
        $request = $client->get($url, array(), array(
            'query' => $params
        ));
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
    public function payPost($url, $params = array())
    {
        $client = new Client($this->_payBaseUrl);
        $client->setDefaultOption('query', array(
            'access_token' => $this->_accessToken
        ));
        $client->setDefaultOption('body', json_encode($params, JSON_UNESCAPED_UNICODE));
        $request = $client->post($url);
        $request->getCurlOptions()->set(CURLOPT_SSLVERSION, 1); // CURL_SSLVERSION_TLSv1
        $response = $client->send($request);
        if ($response->isSuccessful()) {
            return $this->getJson($response); // $response->json();
        } else {
            throw new Exception("微信服务器未有效的响应请求");
        }
    }

    /**
     * 获取微信服务器信息
     *
     * @param string $url            
     * @param array $params            
     * @return mixed
     */
    public function pay337Get($url, $params = array())
    {
        $client = new Client($this->_pay337BaseUrl);
        $params['access_token'] = $this->_accessToken;
        $request = $client->get($url, array(), array(
            'query' => $params
        ));
        $request->getCurlOptions()->set(CURLOPT_SSLVERSION, 1); // CURL_SSLVERSION_TLSv1
        $response = $client->send($request);
        if ($response->isSuccessful()) {
            return $response->getBody(true);
        } else {
            throw new Exception("微信服务器未有效的响应请求");
        }
    }

    /**
     * 推送消息给到微信服务器
     *
     * @param string $url            
     * @param string $xml            
     * @return mixed
     */
    public function pay337Post($url, $xml)
    {
        $client = new Client($this->_pay337BaseUrl);
        $client->setDefaultOption('query', array(
            'access_token' => $this->_accessToken
        ));
        $client->setDefaultOption('body', $xml);
        $request = $client->post($url);
        $request->getCurlOptions()->set(CURLOPT_SSLVERSION, 1); // CURL_SSLVERSION_TLSv1
        $response = $client->send($request);
        if ($response->isSuccessful()) {
            return $response->getBody(true);
        } else {
            throw new Exception("微信服务器未有效的响应请求");
        }
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
        $client->setDefaultOption('query', array(
            'access_token' => $this->_accessToken
        ));
        
        $files = array();
        foreach ($fileParams as $fileName => $media) {
            if (filter_var($media, FILTER_VALIDATE_URL) !== false) {
                $fileInfo = $this->getFileByUrl($media);
                $media = $this->saveAsTemp($fileInfo['name'], $fileInfo['bytes']);
            } elseif (is_readable($media)) {
                $media = $media;
            } else {
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
    private function getFileByUrl($url = '')
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
    private function saveAsTemp($fileName, $fileBytes)
    {
        $this->_tmp = sys_get_temp_dir() . '/temp_files_' . $fileName;
        file_put_contents($this->_tmp, $fileBytes);
        return $this->_tmp;
    }

    public function __destruct()
    {
        if (! empty($this->_tmp)) {
            unlink($this->_tmp);
        }
    }

    private function getJson($response)
    {
        $body = $response->getBody(true);        
        $body = substr(str_replace('\"', '"', json_encode($body)), 1, - 1);
        $response->setBody($body);
        return $response->json();
    }
}