<?php
namespace Weixin\Wx\Manager;

use Weixin\Client;

/**
 * 获取二维码
 * https://mp.weixin.qq.com/debug/wxadoc/dev/api/qrcode.html
 *
 * @author guoyongrong <handsomegyr@gmail.com>
 * @author young <youngyang@icatholic.net.cn>
 */
class Qrcode
{

    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 获取小程序码
     * 我们推荐生成并使用小程序码，它具有更好的辨识度。目前有两个接口可以生成小程序码，开发者可以根据自己的需要选择合适的接口。
     *
     * 接口A: 适用于需要的码数量较少的业务场景 接口地址：
     *
     * https://api.weixin.qq.com/wxa/getwxacode?access_token=ACCESS_TOKEN
     * 获取 access_token 详见文档
     *
     * POST 参数说明
     *
     * 参数 类型 默认值 说明
     * path String 不能为空，最大长度 128 字节
     * width Int 430 二维码的宽度
     * auto_color Bool false 自动配置线条颜色，如果颜色依然是黑色，则说明不建议配置主色调
     * line_color Object {"r":"0","g":"0","b":"0"} auth_color 为 false 时生效，使用 rgb 设置颜色 例如 {"r":"xxx","g":"xxx","b":"xxx"}
     * is_hyaline boolean false 否 是否需要透明底色，为 true 时，生成透明底色的小程序码
     * 注意：通过该接口生成的小程序码，永久有效，数量限制见文末说明，请谨慎使用。用户扫描该码进入小程序后，将直接进入 path 对应的页面。
     */
    public function getwxacode($path, $width, $auto_color = false, $line_color = array("r"=>"0","g"=>"0","b"=>"0"), $is_hyaline = false)
    {
        $params = array();
        $params['path'] = $path;
        $params['width'] = $width;
        $params['auto_color'] = $auto_color;
        if (empty($auto_color)) {
            $params['line_color'] = $line_color;
        }
        if (! empty($is_hyaline)) {
            $params['is_hyaline'] = $is_hyaline;
        }
        $rst = $this->_request->post3('wxa/getwxacode', $params);
        $rst = $this->getBody($rst);
        return $this->_client->rst($rst);
    }

    /**
     * 获取小程序码
     * 接口B：适用于需要的码数量极多，或仅临时使用的业务场景
     *
     * 接口地址：
     *
     * https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=ACCESS_TOKEN
     * 获取 access_token 详见文档
     *
     * POST 参数说明
     *
     * 参数 类型 默认值 说明
     * scene String 最大32个可见字符，只支持数字，大小写英文以及部分特殊字符：!#$&'()*+,/:;=?@-._~，其它字符请自行编码为合法字符（因不支持%，中文无法使用 urlencode 处理，请使用其他编码方式）
     * page String 必须是已经发布的小程序页面，例如 "pages/index/index" ,根路径前不要填加'/',不能携带参数（参数请放在scene字段里），如果不填写这个字段，默认跳主页面
     * width Int 430 二维码的宽度
     * auto_color Bool false 自动配置线条颜色，如果颜色依然是黑色，则说明不建议配置主色调
     * line_color Object {"r":"0","g":"0","b":"0"} auto_color 为 false 时生效，使用 rgb 设置颜色 例如 {"r":"xxx","g":"xxx","b":"xxx"}
     * is_hyaline boolean false 否 是否需要透明底色，为 true 时，生成透明底色的小程序
     * 注意：通过该接口生成的小程序码，永久有效，数量暂无限制。用户扫描该码进入小程序后，开发者需在对应页面获取的码中 scene 字段的值，再做处理逻辑。使用如下代码可以获取到二维码中的 scene 字段的值。调试阶段可以使用开发工具的条件编译自定义参数 scene=xxxx 进行模拟，开发工具模拟时的 scene 的参数值需要进行 urlencode
     *
     * // 这是首页的 js
     * Page({
     * onLoad: function(options) {
     * // options 中的 scene 需要使用 decodeURIComponent 才能获取到生成二维码时传入的 scene
     * var scene = decodeURIComponent(options.scene)
     * }
     * })
     */
    public function getwxacodeunlimit($scene, $page, $width, $auto_color = false, $line_color = array("r"=>"0","g"=>"0","b"=>"0"), $is_hyaline = false)
    {
        $params = array();
        $params['scene'] = $scene;
        $params['page'] = $page;
        $params['width'] = $width;
        $params['auto_color'] = $auto_color;
        if (empty($auto_color)) {
            $params['line_color'] = $line_color;
        }
        if (! empty($is_hyaline)) {
            $params['is_hyaline'] = $is_hyaline;
        }
        $rst = $this->_request->post3('wxa/getwxacodeunlimit', $params);
        $rst = $this->getBody($rst);
        // var_dump($rst);
        // die;
        return $this->_client->rst($rst);
    }

    /**
     * 获取小程序二维码
     * 接口C：适用于需要的码数量较少的业务场景
     *
     * 接口地址：
     *
     * https://api.weixin.qq.com/cgi-bin/wxaapp/createwxaqrcode?access_token=ACCESS_TOKEN
     * 获取 access_token 详见文档
     *
     * POST 参数说明
     *
     * 参数 类型 默认值 说明
     * path String 不能为空，最大长度 128 字节
     * width Int 430 二维码的宽度
     * 注意：通过该接口生成的小程序二维码，永久有效，数量限制见文末说明，请谨慎使用。用户扫描该码进入小程序后，将直接进入 path 对应的页面。
     *
     * 示例：
     *
     * {"path": "pages/index?query=1", "width": 430}
     * 注：pages/index 需要在 app.json 的 pages 中定义
     */
    public function createwxaqrcode($path, $width)
    {
        $params = array();
        $params['path'] = $path;
        $params['width'] = $width;
        $rst = $this->_request->post3('wxaapp/createwxaqrcode', $params);
        $rst = $this->getBody($rst);
        return $this->_client->rst($rst);
    }

    private function getBody($body)
    {
        $ret = array(
            'errcode' => 0,
            'errmsg' => '',
            'wxacode' => ''
        );
        
        // 如果为空值就是错误
        if (empty($body)) {
            $ret['errcode'] = 99999;
            $ret['errmsg'] = "生成失败";
            return $ret;
        }
        $result = json_decode($body, true);
        if (empty($result)) {
            $ret['wxacode'] = $body;
            return $ret;
        } else {
            return $result;
        }
    }
}
