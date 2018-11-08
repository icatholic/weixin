<?php
namespace Weixin\Wx\Manager\Msg;

use Weixin\Client;

/**
 * 小程序模板消息接口
 *
 * @author guoyongrong
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
     * 1.获取小程序模板库标题列表
     * 接口地址
     *
     * https://api.weixin.qq.com/cgi-bin/wxopen/template/library/list?access_token=ACCESS_TOKEN
     * HTTP请求方式：
     *
     * POST
     * POST参数说明：
     *
     * 参数 必填 说明
     * access_token 是 接口调用凭证
     * offset 是 offset和count用于分页，表示从offset开始，拉取count条记录，offset从0开始，count最大为20。
     * count 是 offset和count用于分页，表示从offset开始，拉取count条记录，offset从0开始，count最大为20。
     * 示例：
     *
     * {
     * "offset":0,
     * "count":5
     * }
     * 返回码说明：
     *
     * 在调用模板消息接口后，会返回JSON数据包。
     *
     * 正常时的返回JSON数据包示例：
     *
     * {
     * "errcode":0,
     * "errmsg":"ok",
     * "list":[
     * {"id":"AT0002","title":"购买成功通知"},
     * {"id":"AT0003","title":"购买失败通知"},
     * {"id":"AT0004","title":"交易提醒"},
     * {"id":"AT0005","title":"付款成功通知"},
     * {"id":"AT0006","title":"付款失败通知"}
     * ],
     * "total_count":599
     * }
     * 返回参数说明：
     *
     * 参数 说明
     * id 模板标题id（获取模板标题下的关键词库时需要）
     * title 模板标题内容
     * total_count 模板库标题总数
     */
    public function libraryList($offset = 0, $count = 20)
    {
        $params = array();
        $params['offset'] = $offset;
        $params['count'] = $count;
        $rst = $this->_client->getRequest()->post('wxopen/template/library/list', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 2.获取模板库某个模板标题下关键词库
     * 接口地址
     *
     * https://api.weixin.qq.com/cgi-bin/wxopen/template/library/get?access_token=ACCESS_TOKEN
     * HTTP请求方式：
     *
     * POST
     * POST参数说明：
     *
     * 参数 必填 说明
     * access_token 是 接口调用凭证
     * id 是 模板标题id，可通过接口获取，也可登录小程序后台查看获取
     * 示例：
     *
     * {
     * "id":"AT0002"
     * }
     * 返回码说明：
     *
     * 在调用模板消息接口后，会返回JSON数据包。
     *
     * 正常时的返回JSON数据包示例：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "id": "AT0002",
     * "title": "购买成功通知",
     * "keyword_list": [
     * {
     * "keyword_id": 3,
     * "name": "购买地点",
     * "example": "TIT造舰厂"
     * },
     * {
     * "keyword_id": 4,
     * "name": "购买时间",
     * "example": "2016年6月6日"
     * },
     * {
     * "keyword_id": 5,
     * "name": "物品名称",
     * "example": "咖啡"
     * }
     * ]
     * }
     * 返回参数说明：
     *
     * 参数 说明
     * keyword_id 关键词id，添加模板时需要
     * name 关键词内容
     * example 关键词内容对应的示例
     */
    public function libraryGet($id)
    {
        $params = array();
        $params['id'] = $id;
        $rst = $this->_client->getRequest()->post('wxopen/template/library/get', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 3.组合模板并添加至帐号下的个人模板库
     * 接口地址
     *
     * https://api.weixin.qq.com/cgi-bin/wxopen/template/add?access_token=ACCESS_TOKEN
     * HTTP请求方式：
     *
     * POST
     * POST参数说明：
     *
     * 参数 必填 说明
     * access_token 是 接口调用凭证
     * id 是 模板标题id，可通过接口获取，也可登录小程序后台查看获取
     * keyword_id_list 是 开发者自行组合好的模板关键词列表，关键词顺序可以自由搭配（例如[3,5,4]或[4,5,3]），最多支持10个关键词组合
     * 示例：
     *
     * {
     * "id":"AT0002",
     * "keyword_id_list":[3,4,5]
     * }
     * 返回码说明：
     *
     * 在调用模板消息接口后，会返回JSON数据包。
     *
     * 正常时的返回JSON数据包示例：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "template_id": "wDYzYZVxobJivW9oMpSCpuvACOfJXQIoKUm0PY397Tc"
     * }
     * 返回参数说明：
     *
     * 参数 说明
     * template_id 添加至帐号下的模板id，发送小程序模板消息时所需
     */
    public function add($id, array $keyword_id_list)
    {
        $params = array();
        $params['id'] = $id;
        $params['keyword_id_list'] = $keyword_id_list;
        $rst = $this->_client->getRequest()->post('wxopen/template/add', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 4.获取帐号下已存在的模板列表
     * 接口地址
     *
     * https://api.weixin.qq.com/cgi-bin/wxopen/template/list?access_token=ACCESS_TOKEN
     * HTTP请求方式：
     *
     * POST
     * POST参数说明：
     *
     * 参数 必填 说明
     * access_token 是 接口调用凭证
     * offset 是 offset和count用于分页，表示从offset开始，拉取count条记录，offset从0开始，count最大为20。最后一页的list长度可能小于请求的count
     * count 是 offset和count用于分页，表示从offset开始，拉取count条记录，offset从0开始，count最大为20。最后一页的list长度可能小于请求的count
     * 示例：
     *
     * {
     * "offset":0,
     * "count":1
     * }
     * 返回码说明：
     *
     * 在调用模板消息接口后，会返回JSON数据包。
     *
     * 正常时的返回JSON数据包示例：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "list": [
     * {
     * "template_id": "wDYzYZVxobJivW9oMpSCpuvACOfJXQIoKUm0PY397Tc",
     * "title": "购买成功通知",
     * "content": "购买地点{{keyword1.DATA}}\n购买时间{{keyword2.DATA}}\n物品名称{{keyword3.DATA}}\n",
     * "example": "购买地点：TIT造舰厂\n购买时间：2016年6月6日\n物品名称：咖啡\n"
     * }
     * ]
     * }
     * 返回参数说明：
     *
     * 参数 说明
     * list 帐号下的模板列表
     * template_id 添加至帐号下的模板id，发送小程序模板消息时所需
     * title 模板标题
     * content 模板内容
     * example 模板内容示例
     */
    public function getlist($offset = 0, $count = 20)
    {
        $params = array();
        $params['offset'] = $offset;
        $params['count'] = $count;
        $rst = $this->_client->getRequest()->post('wxopen/template/list', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 5.删除帐号下的某个模板
     * 接口地址
     *
     * https://api.weixin.qq.com/cgi-bin/wxopen/template/del?access_token=ACCESS_TOKEN
     * HTTP请求方式：
     *
     * POST
     * POST参数说明：
     *
     * 参数 必填 说明
     * access_token 是 接口调用凭证
     * template_id 是 要删除的模板id
     * 示例：
     *
     * {
     * "template_id":"wDYzYZVxobJivW9oMpSCpuvACOfJXQIoKUm0PY397Tc"
     * }
     * 返回码说明：
     *
     * 在调用模板消息接口后，会返回JSON数据包。
     *
     * 正常时的返回JSON数据包示例：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok"
     * }
     */
    public function del($template_id)
    {
        $params = array();
        $params['template_id'] = $template_id;
        $rst = $this->_client->getRequest()->post('wxopen/template/del', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 发送模板消息
     * 接口地址：(ACCESS_TOKEN 需换成上文获取到的 access_token)
     *
     * https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=ACCESS_TOKEN
     * HTTP请求方式：
     *
     * POST
     * POST参数说明：
     *
     * 参数 必填 说明
     * touser 是 接收者（用户）的 openid
     * template_id 是 所需下发的模板消息的id
     * page 否 点击模板卡片后的跳转页面，仅限本小程序内的页面。支持带参数,（示例index?foo=bar）。该字段不填则模板无跳转。
     * form_id 是 表单提交场景下，为 submit 事件带上的 formId；支付场景下，为本次支付的 prepay_id
     * data 是 模板内容，不填则下发空模板
     * color 否 模板内容字体的颜色，不填默认黑色
     * emphasis_keyword 否 模板需要放大的关键词，不填则默认无放大
     * 示例：
     *
     * {
     * "touser": "OPENID",
     * "template_id": "TEMPLATE_ID",
     * "page": "index",
     * "form_id": "FORMID",
     * "data": {
     * "keyword1": {
     * "value": "339208499",
     * "color": "#173177"
     * },
     * "keyword2": {
     * "value": "2015年01月05日 12:30",
     * "color": "#173177"
     * },
     * "keyword3": {
     * "value": "粤海喜来登酒店",
     * "color": "#173177"
     * } ,
     * "keyword4": {
     * "value": "广州市天河区天河路208号",
     * "color": "#173177"
     * }
     * },
     * "emphasis_keyword": "keyword1.DATA"
     * }
     * 返回码说明：
     *
     * 在调用模板消息接口后，会返回JSON数据包。
     *
     * 正常时的返回JSON数据包示例：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok"
     * }
     * 错误时会返回错误码信息，说明如下：
     *
     * 返回码 说明
     * 40037 template_id不正确
     * 41028 form_id不正确，或者过期
     * 41029 form_id已被使用
     * 41030 page不正确
     * 45009 接口调用超过限额（目前默认每个帐号日调用限额为100万）
     */
    public function send($touser, $template_id, array $data, $form_id, $page = '', $color = '', $emphasis_keyword = '')
    {
        $params = array();
        $params['touser'] = $touser;
        $params['template_id'] = $template_id;
        $params['data'] = $data;
        $params['form_id'] = $form_id;
        $params['page'] = $page;
        $params['color'] = $color;
        $params['emphasis_keyword'] = $emphasis_keyword;
        $rst = $this->_client->getRequest()->post('message/wxopen/template/send', $params);
        return $this->_client->rst($rst);
    }

    /**
     * sendUniformMessage
     * 下发小程序和公众号统一的服务消息
     *
     * 请求地址
     * POST https://api.weixin.qq.com/cgi-bin/message/wxopen/template/uniform_send?access_token=ACCESS_TOKEN
     * 参数
     * string access_token
     * 接口调用凭证
     *
     * string touser
     * 用户openid，可以是小程序的openid，也可以是mp_template_msg.appid对应的公众号的openid
     *
     * Object weapp_template_msg
     * 小程序模板消息相关的信息，可以参考小程序模板消息接口; 有此节点则优先发送小程序模板消息
     *
     * 属性 类型 默认值 是否必填 说明 支持版本
     * template_id string 是 小程序模板ID
     * page string 是 小程序页面路径
     * form_id string 是 小程序模板消息formid
     * data string 是 小程序模板数据
     * emphasis_keyword string 是 小程序模板放大关键词
     * Object mp_template_msg
     * 公众号模板消息相关的信息，可以参考公众号模板消息接口；有此节点并且没有weapp_template_msg节点时，发送公众号模板消息
     *
     * 属性 类型 默认值 是否必填 说明 支持版本
     * appid string 是 公众号appid，要求与小程序有绑定且同主体
     * template_id string 是 公众号模板id
     * url string 是 公众号模板消息所要跳转的url
     * miniprogram string 是 公众号模板消息所要跳转的小程序，小程序的必须与公众号具有绑定关系
     * data string 是 公众号模板消息的数据
     * 返回值
     * Object
     * 返回的 JSON 数据包
     *
     * 属性 类型 说明 支持版本
     * errcode number 错误码
     * errmsg string 错误信息
     * 错误
     * 错误码 错误信息 说明
     * 40037 模板id不正确，weapp_template_msg.template_id或者mp_template_msg.template_id
     * 41028 weapp_template_msg.form_id过期或者不正确
     * 41029 weapp_template_msg.form_id已被使用
     * 41030 weapp_template_msg.page不正确
     * 45009 接口调用超过限额
     * 40003 touser不是正确的openid
     * 40013 appid不正确，或者不符合绑定关系要求
     * POST 数据格式：JSON
     * 请求数据示例
     * {
     * "touser":"OPENID",
     * "weapp_template_msg":{
     * "template_id":"TEMPLATE_ID",
     * "page":"page/page/index",
     * "form_id":"FORMID",
     * "data":{
     * "keyword1":{
     * "value":"339208499"
     * },
     * "keyword2":{
     * "value":"2015年01月05日 12:30"
     * },
     * "keyword3":{
     * "value":"腾讯微信总部"
     * },
     * "keyword4":{
     * "value":"广州市海珠区新港中路397号"
     * }
     * },
     * "emphasis_keyword":"keyword1.DATA"
     * },
     * "mp_template_msg":{
     * "appid":"APPID ",
     * "template_id":"TEMPLATE_ID",
     * "url":"http://weixin.qq.com/download",
     * "miniprogram":{
     * "appid":"xiaochengxuappid12345",
     * "pagepath":"index?foo=bar"
     * },
     * "data":{
     * "first":{
     * "value":"恭喜你购买成功！",
     * "color":"#173177"
     * },
     * "keyword1":{
     * "value":"巧克力",
     * "color":"#173177"
     * },
     * "keyword2":{
     * "value":"39.8元",
     * "color":"#173177"
     * },
     * "keyword3":{
     * "value":"2014年9月22日",
     * "color":"#173177"
     * },
     * "remark":{
     * "value":"欢迎再次购买！",
     * "color":"#173177"
     * }
     * }
     * }
     * }
     * 返回数据示例
     * {
     * "errcode": 0,
     * "errmsg": "ok"
     * }
     */
    public function uniformSend($touser, array $mp_template_msg, array $weapp_template_msg)
    {
        $params = array();
        $params['touser'] = $touser;
        $params['mp_template_msg'] = $mp_template_msg;
        $params['weapp_template_msg'] = $weapp_template_msg;
        $rst = $this->_client->getRequest()->post('message/wxopen/template/uniform_send', $params);
        return $this->_client->rst($rst);
    }
}
