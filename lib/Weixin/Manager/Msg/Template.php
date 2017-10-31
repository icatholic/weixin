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
    public function send($touser, $template_id, $url, $topcolor, array $data, $miniprogram = NUll)
    {
        /**
         * {
         * "touser":"OPENID",
         * "template_id":"ngqIpbwh8bUfcSsECmogfXcV14J0tQlEpBO27izEYtY",
         * "url":"http://weixin.qq.com/download",
         * "miniprogram":{
         * "appid":"xiaochengxuappid12345",
         * "pagepath":"index?foo=bar"
         * },
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
        if (! is_null($miniprogram)) {
            $params['miniprogram'] = $miniprogram;
        }
        $params['topcolor'] = $topcolor;
        $params['data'] = $data;
        $rst = $this->_client->getRequest()->post('message/template/send', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 设置所属行业
     *
     * 设置行业可在MP中完成，每月可修改行业1次，账号仅可使用所属行业中相关的模板，为方便第三方开发者，提供通过接口调用的方式来修改账号所属行业，具体如下：
     *
     * 接口调用请求说明
     *
     * http请求方式: POST
     * https://api.weixin.qq.com/cgi-bin/template/api_set_industry?access_token=ACCESS_TOKEN
     * POST数据说明
     *
     * POST数据示例如下：
     *
     * {
     * "industry_id1":"1",
     * "industry_id2":"4"
     * }
     * 参数说明
     *
     * 参数 是否必须 说明
     * industry_id1 是 公众号模板消息所属行业编号
     * industry_id2 是 公众号模板消息所属行业编号
     * 行业代码查询
     *
     * 主行业 副行业 代码
     * IT科技 互联网/电子商务 1
     * IT科技 IT软件与服务 2
     * IT科技 IT硬件与设备 3
     * IT科技 电子技术 4
     * IT科技 通信与运营商 5
     * IT科技 网络游戏 6
     * 金融业 银行 7
     * 金融业 基金|理财|信托 8
     * 金融业 保险 9
     * 餐饮 餐饮 10
     * 酒店旅游 酒店 11
     * 酒店旅游 旅游 12
     * 运输与仓储 快递 13
     * 运输与仓储 物流 14
     * 运输与仓储 仓储 15
     * 教育 培训 16
     * 教育 院校 17
     * 政府与公共事业 学术科研 18
     * 政府与公共事业 交警 19
     * 政府与公共事业 博物馆 20
     * 政府与公共事业 公共事业|非盈利机构 21
     * 医药护理 医药医疗 22
     * 医药护理 护理美容 23
     * 医药护理 保健与卫生 24
     * 交通工具 汽车相关 25
     * 交通工具 摩托车相关 26
     * 交通工具 火车相关 27
     * 交通工具 飞机相关 28
     * 房地产 建筑 29
     * 房地产 物业 30
     * 消费品 消费品 31
     * 商业服务 法律 32
     * 商业服务 会展 33
     * 商业服务 中介服务 34
     * 商业服务 认证 35
     * 商业服务 审计 36
     * 文体娱乐 传媒 37
     * 文体娱乐 体育 38
     * 文体娱乐 娱乐休闲 39
     * 印刷 印刷 40
     * 其它 其它 41
     *
     *
     * @param string $industry_id1            
     * @param string $industry_id2            
     *
     * @throws Exception
     * @return array
     */
    public function setIndustry($industry_id1, $industry_id2)
    {
        $params = array();
        $params['industry_id1'] = $industry_id1;
        $params['industry_id2'] = $industry_id2;
        $rst = $this->_client->getRequest()->post('template/api_set_industry', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取设置的行业信息
     *
     * 获取帐号设置的行业信息，可在MP中查看行业信息，为方便第三方开发者，提供通过接口调用的方式来获取帐号所设置的行业信息，具体如下:
     *
     * 接口调用请求说明
     *
     * http请求方式：GET
     * https://api.weixin.qq.com/cgi-bin/template/get_industry?access_token=ACCESS_TOKEN
     * 参数说明
     *
     * 参数 是否必须 说明
     * access_token 是 接口调用凭证
     * 返回说明
     *
     * 正确调用后的返回示例：
     *
     * {
     * "primary_industry":{"first_class":"运输与仓储","second_class":"快递"},
     * "secondary_industry":{"first_class":"IT科技","second_class":"互联网|电子商务"}
     * }
     * 返回参数说明
     *
     * 参数 说明
     * primary_industry 帐号设置的主营行业
     * secondary_industry 帐号设置的副营行业
     */
    public function getIndustry()
    {
        $params = array();
        $rst = $this->_client->getRequest()->post('template/get_industry', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获得模板ID
     *
     * 从行业模板库选择模板到账号后台，获得模板ID的过程可在MP中完成。为方便第三方开发者，提供通过接口调用的方式来修改账号所属行业，具体如下：
     *
     * 接口调用请求说明
     *
     * http请求方式: POST
     * https://api.weixin.qq.com/cgi-bin/template/api_add_template?access_token=ACCESS_TOKEN
     * POST数据说明
     *
     * POST数据示例如下：
     *
     * {
     * "template_id_short":"TM00015"
     * }
     * 参数说明
     *
     * 参数 是否必须 说明
     * template_id_short 是 模板库中模板的编号，有“TM**”和“OPENTMTM**”等形式
     * 返回码说明
     *
     * 在调用模板消息接口后，会返回JSON数据包。正常时的返回JSON数据包示例：
     *
     * {
     * "errcode":0,
     * "errmsg":"ok",
     * "template_id":"Doclyl5uP7Aciu-qZ7mJNPtWkbkYnWBWVja26EGbNyk"
     * }
     */
    public function addTemplate($template_id_short)
    {
        $params = array();
        $params['template_id_short'] = $template_id_short;
        $rst = $this->_client->getRequest()->post('template/api_add_template', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取模板列表
     *
     * 获取已添加至帐号下所有模板列表，可在MP中查看模板列表信息，为方便第三方开发者，提供通过接口调用的方式来获取帐号下所有模板信息，具体如下:
     *
     * 接口调用请求说明
     *
     * http请求方式：GET
     * https://api.weixin.qq.com/cgi-bin/template/get_all_private_template?access_token=ACCESS_TOKEN
     * 参数说明
     *
     * 参数 是否必须 说明
     * access_token 是 接口调用凭证
     * 返回说明
     *
     * 正确调用后的返回示例：
     *
     * {
     * "template_list": [{
     * "template_id": "iPk5sOIt5X_flOVKn5GrTFpncEYTojx6ddbt8WYoV5s",
     * "title": "领取奖金提醒",
     * "primary_industry": "IT科技",
     * "deputy_industry": "互联网|电子商务",
     * "content": "{ {result.DATA} }\n\n领奖金额:{ {withdrawMoney.DATA} }\n领奖 时间:{ {withdrawTime.DATA} }\n银行信息:{ {cardInfo.DATA} }\n到账时间: { {arrivedTime.DATA} }\n{ {remark.DATA} }",
     * "example": "您已提交领奖申请\n\n领奖金额：xxxx元\n领奖时间：2013-10-10 12:22:22\n银行信息：xx银行(尾号xxxx)\n到账时间：预计xxxxxxx\n\n预计将于xxxx到达您的银行卡"
     * }]
     * }
     * 返回参数说明
     *
     * 参数 说明
     * template_id 模板ID
     * title 模板标题
     * primary_industry 模板所属行业的一级行业
     * deputy_industry 模板所属行业的二级行业
     * content 模板内容
     * example 模板示例
     */
    public function getAllPrivateTemplate()
    {
        $params = array();
        $rst = $this->_client->getRequest()->post('template/get_all_private_template', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 删除模板
     *
     * 删除模板可在MP中完成，为方便第三方开发者，提供通过接口调用的方式来删除某帐号下的模板，具体如下：
     *
     * 接口调用请求说明
     *
     * http请求方式post
     * https://api,weixin.qq.com/cgi-bin/template/del_private_template?access_token=ACCESS_TOKEN
     * POST数据说明如下：
     *
     * {
     * “template_id”=”Dyvp3-Ff0cnail_CDSzk1fIc6-9lOkxsQE7exTJbwUE”
     * }
     * 参数说明
     *
     * 参数 是否必须 说明
     * template_id 是 公众帐号下模板消息ID
     * 返回说明
     *
     * 在调用接口后，会返回JSON数据包。正常时的返回JSON数据包示例：
     *
     * {
     * "errcode":0,"errmsg":"ok"
     * }
     */
    public function delPrivateTemplate($template_id)
    {
        $params = array();
        $params['template_id'] = $template_id;
        $rst = $this->_client->getRequest()->post('template/del_private_template', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 一次性订阅消息
     * 开发者可以通过一次性订阅消息授权让微信用户授权第三方移动应用（接入说明）或公众号，获得发送一次订阅消息给到授权微信用户的机会。授权微信用户可以不需要关注公众号。微信用户每授权一次，开发者可获得一次下发消息的权限。对于已关注公众号的，消息将下发到公众号会话；未关注公众号的，将下发到服务通知。
     *
     * 公众号或网页使用一次性订阅消息流程如下：
     * 第一步：需要用户同意授权，获取一次给用户推送一条订阅模板消息的机会
     * 在确保微信公众帐号拥有订阅消息授权的权限的前提下（已认证的公众号即有权限，可登陆公众平台在接口权限列表处查看），引导用户在微信客户端打开如下链接：
     * https://mp.weixin.qq.com/mp/subscribemsg?action=get_confirm&appid=wxaba38c7f163da69b&scene=1000&template_id=1uDxHNXwYQfBmXOfPJcjAS3FynHArD8aWMEFN
     * RGSbCc& redirect_url=http%3a%2f%2fsupport.qq.com&reserved=test#wechat_redirect
     * 参数说明
     * 参数
     * 是否必须 说明
     * action 是 直接填get_confirm即可
     * appid 是
     * 公众号的唯一标识
     * scene 是 重定向后会带上scene参数，开发者可以填0-10000的整形值，用来标识订阅场景值
     * template_id 是 订阅消息模板ID，登录公众平台后台，在接口权限列表处可查看订阅模板ID
     * redirect_url 是 授权后重定向的回调地址，请使用UrlEncode对链接进行处理。注：要求redirect_url的域名要跟登记的业务域名一致，且业务域名不能带路径。业务域名需登录公众号，在设置-公众号设置-功能设置里面对业务域名设置。
     * reserved 否 用于保持请求和回调的状态，授权请后原样带回给第三方。该参数可用于防止csrf攻击（跨站请求伪造攻击），建议第三方带上该参数，可设置为简单的随机数加session进行校验，开发者可以填写a-zA-Z0-9的参数值，最多128字节，要求做urlencode
     * #wechat_redirect 是 无论直接打开还是做页面302重定向时，必须带此参数
     * 用户同意或取消授权后会返回相关信息
     * 如果用户点击同意或取消授权，页面将跳转至：
     * redirect_url/?openid=OPENID&template_id=TEMPLATE_ID&action=ACTION&scene=SCENE
     * 参数说明
     * 参数 说明
     * openid 用户唯一标识，只在用户确认授权时才会带上
     * template_id 订阅消息模板ID
     * action 用户点击动作，”confirm”代表用户确认授权，”cancel”代表用户取消授权
     * scene 订阅场景值
     * reserved 请求带入原样返回
     */
    public function getAuthorizeUrl4Subscribemsg($appid, $template_id, $scene, $redirect_url, $reserved, $action = 'get_confirm')
    {
        $redirect_url = urlencode($redirect_url);
        $url = "https://mp.weixin.qq.com/mp/subscribemsg?action={$action}&appid={$appid}&scene={$scene}&template_id={$template_id}&redirect_url={$redirect_url}&reserved={$reserved}#wechat_redirect";
        return $url;
    }

    /**
     * 第二步：通过API推送订阅模板消息给到授权微信用户
     * 接口请求说明
     * http请求方式: post
     * https://api.weixin.qq.com/cgi-bin/message/template/subscribe?access_token=ACCESS_TOKEN
     * post数据示例
     * {
     * “touser”:”OPENID”,
     * “template_id”:”TEMPLATE_ID”,
     * “url”:”URL”,
     * “scene”:”SCENE”,
     * “title”:”TITLE”,
     * “data”:{
     * “content”:{
     * “value”:”VALUE”,
     * “color”:”COLOR”
     * }
     * }
     * }
     * 参数说明
     * 参数 是否必须 说明
     * touser 是 填接收消息的用户openid
     * template_id 是 订阅消息模板ID
     * url 否 点击消息跳转的链接，需要有ICP备案
     * scene 是 订阅场景值
     * title 是 消息标题，15字以内
     * data 是 消息正文，value为消息内容文本（200字以内），没有固定格式，可用\n换行，color为整段消息内容的字体颜色（目前仅支持整段消息为一种颜色）
     * 返回说明
     * 在调用接口后，会返回JSON数据包。正常时的返回JSON数据包示例：
     * {
     * “errcode”:0,
     * “errmsg”:”ok”
     * }
     */
    public function subscribe($touser, $template_id, $url, $scene, $title, array $data)
    {
        $params = array();
        $params['touser'] = $touser;
        $params['template_id'] = $template_id;
        $params['url'] = $url;
        $params['scene'] = $scene;
        $params['title'] = $title;
        $params['data'] = $data;
        
        $rst = $this->_client->getRequest()->post('message/template/subscribe', $params);
        return $this->_client->rst($rst);
    }
}
