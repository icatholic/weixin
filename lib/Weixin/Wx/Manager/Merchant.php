<?php
namespace Weixin\Wx\Manager;

use Weixin\Exception;
use Weixin\Client;

/**
 * 微信门店小程序接口文档
 * 一、简介须知
 * 门店小程序是公众平台向商户提供的对其线下门店相关功能的管理能力。
 * 门店小程序可设置到公众号介绍页、自定义菜单和图文消息中，
 * 通过附近关联导入出现在“附近的小程序”，
 * 也可应用在卡券、广告、WIFI等业务使用。
 *
 * 门店小程序接口是为商户提供批量新增、查询、修改、删除门店等主要功能，
 * 包括创建小程序商家账号，方便商户快速高效进行门店管理和操作。
 *
 * 备注：原门店管理权限可通过升级为门店小程序使用相关权限。
 *
 * @author guoyongrong <handsomegyr@gmail.com>
 * @author young <youngyang@icatholic.net.cn>
 */
class Merchant
{

    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 1.拉取门店小程序类目
     * 请求方式：GET（请使用https协议）
     * https://api.weixin.qq.com/wxa/get_merchant_category?access_token=TOKEN
     * 请求参数：
     * 参数 说明
     * access_token 调用接口凭证
     * 返回json示例（门店小程序类目分一级和二级类目）：
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "data": {
     * "all_category_info": {
     * "categories": [
     * {
     * "id": 0,
     * "name": "root",
     * "level": 0, //根节点，对应子节点是一级类目的id
     * "children": [ //子节点列表
     * 269,278
     * ]
     * },
     * {
     * "id": 278,
     * "name": "购物",
     * "level": 1,//一级类目
     * "father": 0,
     * "children": [
     * 279,280
     * ]
     * },
     * {
     * "id": 280,
     * "name": "便利店",
     * "level": 2, //二级类目
     * "father": 278,
     * "children": [],
     * "qualify": {
     * "exter_list": [{
     * "inner_list": [{
     * "name": "若涉及食品，请提供《食品经营许可证》或《卫生许可证》" //需要提交的证件名字
     * }]
     * }]
     * },
     * "scene": 3,
     * "sensitive_type": 1 //如果sensitive_type=1，在创建门店小程序时，需要添加相关证件
     * },
     * …
     * ]
     * }}}
     *
     * 返回参数说明：
     * 参数 说明 备注
     * id 类目id 必填
     * level 类目的级别，一级或者二级类目 必填
     * sensitive_type 0或者1，0表示不用特殊处理 1表示创建该类目的门店小程序时，需要添加相关证件 必填
     * qualify.exter_list.inner_list.name 相关证件的名字 必填
     *
     * 可参考：门店小程序类目对应表
     */
    public function getCategory()
    {
        $params = array();
        $rst = $this->_request->post2('wxa/get_merchant_category', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 2.创建门店小程序
     * 说明：创建门店小程序提交后需要公众号管理员确认通过后才可进行审核。如果主管理员24小时超时未确认，才能再次提交。
     * 请求方式: POST（请使用https协议）
     * https://api.weixin.qq.com/wxa/apply_merchant?access_token=TOKEN
     *
     * POST数据示例：
     *
     * {
     * "first_catid": 476, //get_store_category接口获取的一级类目id
     * 　　　"second_catid": 477, //get_store_category接口获取的二级类目id
     * 　　　"qualification_list": "RTZgKZ386yFn5kQSWLTxe4bqxwgzGBjs3OE02cg9CVQk1wRVE3c8fjUFX7jvpi-P",
     * "headimg_mediaid": "RTZgKZ386yFn5kQSWLTxe4bqxwgzGBjs3OE02cg9CVQk1wRVE3c8fjUFX7jvpi-P",
     * "nickname": "hardenzhang308",
     * "intro": "hardenzhangtest",
     * "org_code": "",
     * "other_files": ""
     * }
     *
     * 请求参数说明：
     * 参数 说明 备注
     * first_catid 一级类目id 必填
     * second_catid 二级类目id 必填
     * qualification_list 类目相关证件的临时素材mediaid 如果second_catid对应的sensitive_type为1，则qualification_list字段需要填 支持0~5个mediaid，例如mediaid1|mediaid2 选填
     * headimg_mediaid 头像 --- 临时素材mediaidmediaid用现有的media/upload接口得到的,获取链接：https://mp.weixin.qq.com/wiki?t=t=resource/res_main&id=mp1444738726 (支持jpg和png格式的图片，后续加上其他格式) 必填
     * nickname 门店小程序的昵称 名称长度为4-30个字符（中文算两个字符）必填
     * intro 门店小程序的介绍 必填
     * org_code 营业执照或组织代码证 --- 临时素材mediaid 如果返回错误码85024，则该字段必填，否则不用填 选填
     * other_files 补充材料 --- 临时素材mediaid 如果返回错误码85024，则可以选填 支持0~5个mediaid，例如mediaid1|mediaid2 选填
     * access_token 调用接口凭证 必填
     *
     * 返回json示例：
     * {
     * "errcode" : 0,
     * "errmsg" : "ok"
     * }
     *
     * 错误码说明：
     * 返回码 说明
     * 85024 你申请的名称需要补充相应资料进行审核，此时请求参数org_code和other_files需要填写
     * 85025 管理员手机登记数量已超过上限，不能使用该主体开通门店
     * 85026 该微信号已绑定5个管理员，请使用另一个微信号完成信息登记
     * 85027 管理员身份证已登记过5次，请使用另一个身份证完成用户信息登记
     * 85028 该主体登记数量已超过上限，不能使用该主体开通门店
     * 85029 商家名称已被占用，请换一个重试
     * 85030 名称长度为4-30个字符（一个中文占两个字符），不能含有特殊字符及“微信”等保留字"
     * 85031 不能使用该名称
     * 85032 该名称在侵权投诉保护期，暂不支持申请，请重新提交一个新的名称
     * 85033 名称不能包含违反公众平台协议、相关法律法规和政策的内容，不得使用“微信”等保留字
     * 85034 商家名称在改名15天保护期内，请换一个重试。
     * 85035 需与该帐号相同主体才可申请
     * 85036 介绍中不得含有虚假的、冒充、利用他人名义的、容易构成混淆、误认的、法律、法规和政策禁止的内容
     * 85049 头像或者简介修改达到每个月上限
     * 43104 没有权限
     * 85050 正在审核中，请勿重复提交
     * 85053 请先成功创建门店后再调用
     * 85056 临时mediaid无效
     */
    public function apply($first_catid, $second_catid, $qualification_list, $headimg_mediaid, $nickname, $intro, $org_code, $other_files)
    {
        $params = array();
        $params['first_catid'] = $first_catid;
        $params['second_catid'] = $second_catid;
        if (! empty($qualification_list)) {
            $params['qualification_list'] = $qualification_list;
        }
        $params['headimg_mediaid'] = $headimg_mediaid;
        $params['nickname'] = $nickname;
        $params['intro'] = $intro;
        $params['org_code'] = $org_code;
        $params['other_files'] = $other_files;
        
        $rst = $this->_request->post2('wxa/apply_merchant', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 3.查询门店小程序审核结果
     * 请求方式: GET（请使用https协议）
     * https://api.weixin.qq.com/wxa/get_merchant_audit_info?access_token=TOKEN
     * 请求参数：
     * 参数说明备注
     * access_token调用接口凭证必填
     * 返回json示例：
     * {
     * "errcode":0,
     * "errmsg":"ok",
     * "data": {
     * "audit_id": 414569513,
     * "status": 1,
     * "reason": ""
     * }
     * 返回参数说明：
     * 参数说明备注
     * audit_id 审核单id 必填
     * status 审核状态，0：未提交审核，1：审核成功，2：审核中，3：审核失败，4：管理员拒绝 必填
     * reason 审核状态为3或者4时，reason列出审核失败的原因 必填
     */
    public function getAuditInfo()
    {
        $params = array();
        $rst = $this->_request->post2('wxa/get_merchant_audit_info', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 4.修改门店小程序信息
     * 请求方式: POST（请使用https协议）
     * https://api.weixin.qq.com/wxa/modify_merchant?access_token=TOKEN
     * POST数据示例：
     * {
     * 　　"headimg_mediaid":"xxxxx",
     * "intro":"x"
     * }
     * 请求参数说明：
     * 参数说明 备注
     * headimg_mediaid 门店头像的临时素材mediaid,如果不想改，参数传空值 获取mediaid可以通过接口https://mp.weixin.qq.com/wiki?t=t=resource/res_main&id=mp1444738726 必填
     * intro 门店小程序的介绍,如果不想改，参数传空值 必填
     * access_token 调用接口凭证 必填
     * 直接复用创建门店小程序的错误码！！
     *
     * 返回json示例：
     * {
     * "errcode" : 0,
     * "errmsg" : "ok"
     * }
     */
    public function modify($headimg_mediaid, $intro)
    {
        $params = array();
        $params['headimg_mediaid'] = $headimg_mediaid;
        $params['intro'] = $intro;
        $rst = $this->_request->post2('wxa/modify_merchant', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 5.从腾讯地图拉取省市区信息
     * 请求方式: GET（请使用https协议）
     * https://api.weixin.qq.com/wxa/get_district?access_token=TOKEN
     * 请求参数：
     * 参数说明备注
     * access_token调用接口凭证必填
     * 返回json示例：
     * {
     * "status": 0,
     * "message": "query ok",
     * "data_version": "20170510",
     * "result": [ //result是二维数组
     * [ //result[0]:第一维是省的信息
     * {
     * "id": "440000",
     * "name": "广东",
     * "fullname": "广东省",
     * "pinyin": [
     * "guang",
     * "dong"
     * ],
     * "location": {
     * "lat": 23.13171,
     * "lng": 113.26627
     * },
     * "cidx": [ //列出了广东省下面所有的市的下标（result[1]的下标）
     * 246,
     * 266
     * ]
     * },
     * ......
     * ],
     * [ //result[1]:第二维是市的信息
     * {
     * "id": "440100",
     * "name": "广州",
     * "fullname": "广州市",
     * "pinyin": [
     * "guang",
     * "zhou"
     * ],
     * "location": {
     * "lat": 23.12908,
     * "lng": 113.26436
     * },
     * "cidx": [ //列出了广东市下面所有的区的下标（result[2]的下标）
     * 1667,
     * 1677
     * ]
     * },
     * ......
     * ],
     * [
     * {
     * "id": "440105",
     * "fullname": "海珠区",
     * "location": {
     * "lat": 23.08331,
     * "lng": 113.3172
     * }
     * },
     * {
     * "id": "440106",
     * "fullname": "天河区",
     * "location": {
     * "lat": 23.12463,
     * "lng": 113.36199
     * }
     * }
     * ......
     * ]
     * ]
     * }
     * 返回参数说明：
     * 参数说明备注
     * result 二维数组，第一维表示省的信息，第二维表示市的信息，第三维表示区的信息 必填
     * id 区域id，也叫做districtid 必填
     * cidx 通过广东省的cidx，可以在result[1]中找到广东省下的所有市 必填
     * fullname 省市区的名字必填
     *
     * 可参考：地图省市区信息对应表
     */
    public function getDistrict()
    {
        $params = array();
        $rst = $this->_request->post2('wxa/get_district', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 6.在腾讯地图中搜索门店
     * 请求方式: POST（请使用https协议）
     * https://api.weixin.qq.com/wxa/search_map_poi?access_token=TOKEN
     * POST数据示例：
     * {
     * 　　"districtid":440105,
     * "keyword":"x"
     * }
     *
     * 请求参数说明：
     * 参数 说明 备注
     * districtid 对应拉取省市区信息接口中的id字段 必填
     * keyword 搜索的关键词 必填
     * access_token 调用接口凭证 必填
     *
     * 返回json示例：
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "data": {
     * "item": [
     *
     * 　　{
     * "branch_name": "X-MAX工厂",
     * "address": "广东省广州市海珠区怡安路172-174号怡安花园二、三层(中海名都)",
     * "longitude": 113.274810791,
     * "latitude": 23.1088695526,
     * "telephone": " 020-89190388",
     * "category": "运动健身:健身中心",
     * "sosomap_poi_uid": "2708071440732747189",
     * "data_supply": 2,
     * "pic_urls": [],
     * "card_id_list": []　
     * },
     *
     * 　　....　
     *
     * ]
     * }
     * }
     *
     * 返回参数说明：
     * 参数 说明 备注
     * sosomap_poi_uid 从腾讯地图换取的位置点id，即后面创建门店接口中的map_poi_id参数 必填
     * address 详细地址 必填
     */
    public function searchMapPoi($districtid, $keyword)
    {
        $params = array();
        $params['districtid'] = $districtid;
        $params['keyword'] = $keyword;
        $rst = $this->_request->post2('wxa/search_map_poi', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 7.在腾讯地图中创建门店
     * https://api.weixin.qq.com/wxa/create_map_poi?access_token=TOKEN
     * 请求方式: POST（请使用https协议）
     * POST数据示例：
     * {
     * "name": "hardenzhang",
     * "longitude": "113.323753357",
     * "latitude": "23.0974903107",
     * "province": "广东省",
     * "city": "广州市",
     * "district": "海珠区",
     * "address": "TIT",
     * "category": "类目1:类目2",
     * "telephone": "12345678901",
     * "photo": "http://mmbiz.qpic.cn/mmbiz_png/tW66AWE2K6ECFPcyAcIZTG8RlcR0sAqBibOm8gao5xOoLfIic9ZJ6MADAktGPxZI7MZLcadZUT36b14NJ2cHRHA/0?wx_fmt=png",
     * "license": "http://mmbiz.qpic.cn/mmbiz_png/tW66AWE2K6ECFPcyAcIZTG8RlcR0sAqBibOm8gao5xOoLfIic9ZJ6MADAktGPxZI7MZLcadZUT36b14NJ2cHRHA/0?wx_fmt=png",
     * "introduct": "test",
     * "districtid": "440105",
     * }
     *
     * 请求参数说明：
     * 参数 说明 备注
     * name 名字 必填
     * longitude 经度 必填
     * latitude 纬度 必填
     * province 省份 必填
     * city 城市 必填
     * district 区 必填
     * address 详细地址 必填
     * category 类目，比如美食:中餐厅必填
     * telephone 电话，可多个，使用英文分号间隔 010-6666666-111; 010-6666666; 010-6666666-222 必填
     * photo 门店图片url 必填
     * license 营业执照url 必填
     * introduct 介绍 必填
     * districtid 腾讯地图拉取省市区信息接口返回的id 必填
     * poi_id 如果是迁移门店，必须填poi_id字段 选填
     * access_token 调用接口凭证 必填
     * 返回json示例：
     * {
     *
     * "error": null, //指出错误原因
     * "data": {
     * "base_id": 42160,
     * "rich_id": 42010
     * }
     * }
     */
    public function createMapPoi($name, $longitude, $latitude, $province, $city, $district, $address, $category, $telephone, $photo, $license, $introduct, $districtid, $poi_id)
    {
        $params = array();
        $params['name'] = $name;
        $params['longitude'] = $longitude;
        $params['latitude'] = $latitude;
        $params['province'] = $province;
        $params['city'] = $city;
        $params['district'] = $district;
        $params['address'] = $address;
        $params['category'] = $category;
        $params['telephone'] = $telephone;
        $params['photo'] = $photo;
        $params['license'] = $license;
        $params['introduct'] = $introduct;
        $params['districtid'] = $districtid;
        $params['poi_id'] = $poi_id;
        $rst = $this->_request->post2('wxa/create_map_poi', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 8.添加门店
     * https://api.weixin.qq.com/wxa/add_store?access_token=TOKEN
     * 请求方式: POST（请使用https协议）
     *
     * POST数据示例：
     * {
     * "poi_id": "",
     * "map_poi_id": "2880741500279549033",
     * "pic_list":"{\"list\":[\"http://mmbiz.qpic.cn/mmbiz_jpg/tW66AWvE2K4EJxIYOVpiaGOkfg0iayibiaP2xHOChvbmKQD5uh8ymibbEKlTTPmjTdQ8ia43sULLeG1pT2psOfPic4kTw/0?wx_fmt=jpeg\"]}",
     * "contract_phone": "1111222222",
     * "credential": "22883878-0",
     * "qualification_list": "RTZgKZ386yFn5kQSWLTxe4bqxwgzGBjs3OE02cg9CVQk1wRVE3c8fjUFX7jvpi-P"
     * }
     *
     * 请求参数说明：
     * 参数 说明 备注
     * map_poi_id 从腾讯地图换取的位置点id，即search_map_poi接口返回的sosomap_poi_uid字段 必填
     * pic_list 门店图片，可传多张图片 pic_list字段是一个json 必填
     * contract_phone 联系电话 必填
     * hour 营业时间，格式11:11-12:12 必填
     * credential 经营资质证件号 必填
     * company_name 主体名字 临时素材mediaid 如果复用公众号主体，则company_name为空 如果不复用公众号主体，则company_name为具体的主体名字 选填
     * qualification_list 相关证明材料 临时素材mediaid 不复用公众号主体时，才需要填支持0~5个mediaid，例如mediaid1|mediaid2 选填
     * card_id 卡券id，如果不需要添加卡券，该参数可为空 目前仅开放支持会员卡、买单和刷卡支付券，不支持自定义code，需要先去公众平台卡券后台创建cardid 必填
     * poi_id 如果是从门店管理迁移门店到门店小程序，则需要填该字段 选填
     * access_token 调用接口凭证 必填
     *
     * 返回json示例：
     * {
     * "errcode" : 0,
     * "errmsg" : "ok",
     * "data" : {"audit_id":111}
     * }
     *
     * 错误码说明：
     * 数值 说明
     * -1 系统错误
     * 85038 请勿添加重复门店
     * 85039 此门店状态不能被获取信息
     * 85040 此门店已被绑定，无需重复绑定
     * 85041 该经营资质已添加，请勿重复添加。
     * 85042 附近地点添加数量达到上线，无法继续添加。
     * 85054 由于门店小程序还没升级成功，需要添写poi_id进行门店迁移
     * 85055 map_poi_id无效
     * 85056 临时mediaid无效
     */
    public function addStore($map_poi_id, $pic_list, $contract_phone, $hour, $credential, $company_name, $qualification_list, $card_id, $poi_id)
    {
        $params = array();
        $params['map_poi_id'] = $map_poi_id;
        $params['pic_list'] = $pic_list;
        $params['contract_phone'] = $contract_phone;
        $params['hour'] = $hour;
        $params['credential'] = $credential;
        $params['company_name'] = $company_name;
        $params['qualification_list'] = $qualification_list;
        $params['card_id'] = $card_id;
        $params['poi_id'] = $poi_id;
        $rst = $this->_request->post2('wxa/add_store', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 9.更新门店信息
     * 请求方式: POST（请使用https协议）
     * https://api.weixin.qq.com/wxa/update_store?access_token=TOKEN
     * POST数据示例：
     * {
     * "map_poi_id":"5938314494307741153",
     * "poi_id":"472671857",
     * "hour":"10:00-21:00",
     * "contract_phone":"123456",
     * "pic_list":"{\"list\":[\"http://mmbiz.qpic.cn/mmbiz_jpg/tW66AWvE2K4EJxIYOVpiaGOkfg0iayibiaP2xHOChvbmKQD5uh8ymibbEKlTTPmjTdQ8ia43sULLeG1pT2psOfPic4kTw/0?wx_fmt=jpeg\"]}"
     * }
     *
     * 参数说明:
     * 参数 说明 备注
     * access_token 调用接口凭证 必填
     * poi_id 为门店小程序添加门店，审核成功后返回的门店id 必填
     * hour 自定义营业时间，格式为10:00-12:00 必填
     * contract_phone 自定义联系电话 必填
     * pic_list 门店图片，可传多张图片
     * pic_list字段是一个json 必填
     * card_id 卡券id，如果不想修改的话，设置为空 必填 card_id字段，可以通过https://api.weixin.qq.com/card/storewxa/get?access_token=ACCESS_TOKEN接口拉取
     *
     * 需要注意的是，如果要更新门店的图片，实际相当于走一次重新为门店添加图片的流程，之前的旧图片会全部废弃。并且如果重新添加的图片中有与之前旧图片相同的，此时这个图片不需要重新审核。
     *
     * 成功返回：
     * {
     * "errcode" : 0,
     * "errmsg" : "ok",
     * //has_audit_id表示是否需要审核(1表示需要，0表示不需要)
     * //audit_id表示具体的审核单id
     * "data" : {"has_audit_id":1,"audit_id":1111}
     * }
     *
     * 错误码说明：
     * 数值 说明
     * -1 系统失败
     * 40097 输入参数有误
     * 65115 门店不存在
     * 65118 该门店状态不允许更新
     * 85053 请先成功创建门店后再调用
     *
     * 更新门店的时候，如果修改了门店图片，则需要进行审核。
     */
    public function updateStore($map_poi_id, $pic_list, $contract_phone, $hour, $card_id, $poi_id)
    {
        $params = array();
        $params['map_poi_id'] = $map_poi_id;
        $params['pic_list'] = $pic_list;
        $params['contract_phone'] = $contract_phone;
        $params['hour'] = $hour;
        $params['card_id'] = $card_id;
        $params['poi_id'] = $poi_id;
        $rst = $this->_request->post2('wxa/update_store', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 10.获取单个门店信息
     * 请求方式: POST（请使用https协议）
     * https://api.weixin.qq.com/wxa/get_store_info?access_token=TOKEN
     * POST数据示例:
     * {
     * "poi_id":"472671857"
     * }
     *
     * 参数说明:
     * 参数 说明 备注
     * access_token 调用接口凭证 必填
     * poi_id 为门店小程序添加门店，审核成功后返回的门店id 必填
     * 成功返回举例：
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "business": {
     * "base_info": {
     * "business_name": "龙涤小区熟食店",
     * "address": "舍利街道中都大道龙涤小区阿升电脑旁",
     * "telephone": "12345678",
     * "city": "哈尔滨市",
     * "province": "黑龙江省",
     * "longitude": 126.94355011,
     * "latitude": 45.556098938,
     * "photo_list": [
     * {
     * "photo_url": "http://mmbiz.qpic.cn/mmbiz_png/tW66AWvE2K6icjle1q6nbfKr0HMibzxKqOUfG1hARktHV84ZZojt9cXZ0UicDevZQUicckPw68lfo2Le3RjpEo6oLg/0?wx_fmt=png"
     * }
     * ],
     * "open_time": "11:00-12:00",
     * "poi_id": "472671857",
     * 　"status":2,
     * "district": "value",
     * "qualification_num": "91750100ME2XCR6A70",
     * "qualification_name": "龙涤小区熟食店"
     * }
     * }
     * }
     *
     * 成功返回的结果中status字段值说明：
     * 数值 说明
     * 1 审核通过
     * 2 审核中
     * 3 审核失败
     *
     * 错误码说明：
     * 数值 说明
     * -1 系统错误
     * 40097 输入参数有误
     * 65115 门店不存在
     */
    public function getStoreInfo($poi_id)
    {
        $params = array();
        $params['poi_id'] = $poi_id;
        $rst = $this->_request->post2('wxa/get_store_info', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 11.获取门店信息列表
     * 求方式: POST（请使用https协议）
     * https://api.weixin.qq.com/wxa/get_store_list?access_token=TOKEN
     * POST数据示例:
     * {
     * "offset": 0,
     * "limit": 10
     * }
     * 参数说明:
     * 参数 说明 备注
     * access_token 调用接口凭证 必填
     * offset 获取门店列表的初始偏移位置，从0开始计数 必填
     * limit 获取门店个数 必填 假如某个门店小程序有10个门店，那么offset最大是9。limit参数最大不能超过50，并且如果传入的limit参数是0，那么按默认值20处理。
     * 成功返回举例：
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "business_list": [
     * {
     * "base_info": {
     * "business_name": "超速天使俱乐部",
     * "address": "新华路19",
     * "telephone": "12345678",
     * "categories": [],
     * "city": "邯郸市",
     * "province": "河北省",
     * "longitude": 114.958480835,
     * "latitude": 36.7714881897,
     * "photo_list": [
     * {
     * "photo_url": "http://mmbiz.qpic.cn/mmbiz_jpg/tW66AWvE2K4e52sLYyA90ZKuicdfhkf5ibQk1icmcRWjrMxmVibo8sVQAllABxG5ic0D5x62gfsPVL4aibxQ2SicfPyjQ/0?wx_fmt=jpeg"
     * }
     * ],
     * "open_time": "10:00-21:00",
     * "poi_id": "472665875",
     * 　"status":1,
     * "district": "曲周县",
     * "qualification_list": [],
     * "qualification_num": "01650100NE2XCT6Z70",
     * "qualification_name": "超速天使俱乐部"
     * }
     * },
     * {
     *
     * "base_info": {
     * "business_name": "龙涤小区熟食店",
     * "address": "舍利街道中都大道龙涤小区阿升电脑旁",
     * "telephone": "12345678",
     * "categories": [],
     * "city": "哈尔滨市",
     * "province": "黑龙江省",
     * "longitude": 126.94355011,
     * "latitude": 45.556098938,
     * "photo_list": [
     * {
     * "photo_url": "http://mmbiz.qpic.cn/mmbiz_png/tW66AWvE2K6icjle1q6nbfKr0HMibzxKqOUfG1hARktHV84ZZojt9cXZ0UicDevZQUicckPw68lfo2Le3RjpEo6oLg/0?wx_fmt=png"
     * }
     * ],
     * "open_time": "11:00-12:00",
     * "poi_id": "472671857",
     * 　"status":3,
     * "district": "阿城区",
     * "qualification_list": [],
     * "qualification_num": "91750100ME2XCR6A70",
     * "qualification_name": "龙涤小区熟食店"
     * }
     * }
     * ],
     * "total_count": 2
     * }
     *
     * 成功返回的结果中status字段值说明：
     * 数值 说明
     * 1 审核通过
     * 2 审核中
     * 3 审核失败
     *
     * 错误码说明：
     * 数值 说明
     * -1 系统错误
     * 40097 输入参数有误
     */
    public function getStoreList($offset = 0, $limit = 20)
    {
        $params = array();
        $params['offset'] = $offset;
        $params['limit'] = min($limit, 50);
        $rst = $this->_request->post2('wxa/get_store_list', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 12.删除门店
     * 请求方式: POST（请使用https协议）
     * https://api.weixin.qq.com/wxa/del_store?access_token=TOKEN
     * POST数据示例:
     * {
     * "poi_id":"472671857"
     * }
     * 参数说明:
     * 参数 说明 备注
     * access_token 调用接口凭证必填
     * poi_id 为门店小程序添加门店，审核成功后返回的门店id必填
     *
     * 错误码说明：
     * 数值说明
     * -1 删除失败
     * 85053 请先成功创建门店后再调用
     */
    public function deleteStore($poi_id)
    {
        $params = array();
        $params['poi_id'] = $poi_id;
        $rst = $this->_request->post2('wxa/del_store', $params);
        return $this->_client->rst($rst);
    }
}
