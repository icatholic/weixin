<?php
namespace Weixin\Model;

/**
 * 商品信息
 */
class Sku
{

    /**
     * quantity
     * 上架的数量。(不支持填写0 或无限大)
     * 是
     */
    public $quantity = NULL;

    public function __construct($quantity)
    {
        $this->quantity = $quantity;
    }

    public function getParams()
    {
        $params = array();
        
        if ($this->quantity != NULL) {
            $params['quantity'] = $this->quantity;
        }
        
        return $params;
    }
}

/**
 * 使用日期，有效期的信息
 */
class DateInfo
{

    /**
     * type
     * 使用时间的类型是1：固定日期区间，2：固定时长（自领取后按天算）
     * 是
     */
    public $type = NULL;

    /**
     * begin_timestamp
     * 固定日期区间专用，表示起用时间。
     * 从1970 年1 月1 日00:00:00 至起用时间的秒数，最终需转换为字符串形态传入，下同。（单位为秒）
     * 是
     */
    public $begin_timestamp = NULL;

    /**
     * end_timestamp
     * 固定日期区间专用，表示结束时间。（单位为秒）
     * 是
     */
    public $end_timestamp = NULL;

    /**
     * fixed_term
     * 固定时长专用，表示自领取后多少天内有效。（单位为天）
     * 是
     */
    public $fixed_term = NULL;

    /**
     * fixed_begin_term
     * 固定时长专用，表示自领取后多少天开始生效。（单位为天）
     * 是
     */
    public $fixed_begin_term = NULL;

    public function __construct($type, $begin_timestamp, $end_timestamp, $fixed_term, $fixed_begin_term)
    {
        if (! is_int($type))
            exit("DateInfo.type must be integer");
        
        $this->type = $type;
        if ($type == 1)         // 固定日期区间
        {
            if (! is_int($begin_timestamp) || ! is_int($end_timestamp))
                exit("begin_timestamp and  end_timestamp must be integer");
            $this->begin_timestamp = $begin_timestamp;
            $this->end_timestamp = $end_timestamp;
        } else 
            if ($type == 2)             // 固定时长（自领取后多少天内有效）
            {
                if (! is_int($fixed_term) || ! is_int($fixed_begin_term))
                    exit("fixed_term must be integer");
                $this->fixed_term = $fixed_term;
                $this->fixed_begin_term = $fixed_begin_term;
            } else
                exit("DateInfo.tpye Error");
    }

    public function getParams()
    {
        $params = array();
        
        if ($this->type != NULL) {
            $params['type'] = $this->type;
        }
        if ($this->begin_timestamp != NULL) {
            $params['begin_timestamp'] = $this->begin_timestamp;
        }
        if ($this->end_timestamp != NULL) {
            $params['end_timestamp'] = $this->end_timestamp;
        }
        if ($this->fixed_term != NULL) {
            $params['fixed_term'] = $this->fixed_term;
        }
        if ($this->fixed_begin_term != NULL) {
            $params['fixed_begin_term'] = $this->fixed_begin_term;
        }
        
        return $params;
    }
}

/**
 * 基本的卡券数据
 */
class BaseInfo
{

    /**
     * logo_url
     * 卡券的商户logo，尺寸为300*300。
     * 是
     */
    public $logo_url = NULL;

    /**
     * code_type code 码展示类型。是
     * "CODE_TYPE_TEXT"，文本"CODE_TYPE_BARCODE"，一维码"CODE_TYPE_QRCODE"，二维码
     * 是
     */
    public $code_type = NULL;

    /**
     * brand_name
     * 商户名字,字数上限为12 个汉字。（填写直接提供服务的商户名， 第三方商户名填写在source 字段）
     * 是
     */
    public $brand_name = NULL;

    /**
     * title
     * 券名，字数上限为9 个汉字。(建议涵盖卡券属性、服务及金额)
     * 是
     */
    public $title = NULL;

    /**
     * sub_title
     * 券名的副标题，字数上限为18个汉字。
     * 否
     */
    public $sub_title = NULL;

    /**
     * color
     * 券颜色。按色彩规范标注填写Color010-Color100
     * 是
     */
    public $color = NULL;

    /**
     * notice
     * 使用提醒，字数上限为9 个汉字。（一句话描述，展示在首页，示例：请出示二维码核销卡券）
     * 是
     */
    public $notice = NULL;

    /**
     * service_phone
     * 客服电话。
     * 否
     */
    public $service_phone = NULL;

    /**
     * source
     * 第三方来源名，例如同程旅游、格瓦拉。
     * 否
     */
    public $source = NULL;

    /**
     * description
     * 使用说明。长文本描述，可以分行，上限为1000 个汉字。
     * 是
     */
    public $description = NULL;

    /**
     * use_limit
     * 每人使用次数限制。
     * 否
     */
    public $use_limit = NULL;

    /**
     * get_limit
     * 每人最大领取次数，不填写默认等于quantity。否
     */
    public $get_limit = NULL;

    /**
     * use_custom_code
     * 是否自定义code 码。填写true或false，不填代表默认为false。（该权限申请及说明详见Q&A)
     * 否
     */
    public $use_custom_code = false;

    /**
     * bind_openid
     * 是否指定用户领取，填写true或false。不填代表默认为否。
     * 否
     */
    public $bind_openid = false;

    /**
     * can_share
     * 领取卡券原生页面是否可分享，填写true 或false，true 代表可分享。默认可分享。
     * 否
     */
    public $can_share = true;

    /**
     * can_give_friend
     * 卡券是否可转赠，填写true 或false,true 代表可转赠。默认可转赠。
     * 否
     */
    public $can_give_friend = true;

    /**
     * location_id_list
     * 门店位置ID。商户需在mp 平台上录入门店信息或调用批量导入门店信息接口获取门店位置ID。
     * 否
     */
    public $location_id_list = NULL;

    /**
     * date_info
     * 使用日期，有效期的信息
     * 是
     *
     * @var DateInfo
     */
    public $date_info = NULL;

    /**
     * sku
     * 商品信息。
     * 是
     *
     * @var Sku
     */
    public $sku = NULL;

    /**
     * url_name_type
     * 商户自定义cell 名称
     * 否
     * "URL_NAME_TYPE_TAKE_AWAY"，外卖
     * "URL_NAME_TYPE_RESERVATION"，在线预订
     * "URL_NAME_TYPE_USE_IMMEDIATELY"，立即使用
     * "URL_NAME_TYPE_APPOINTMENT”,在线预约
     * URL_NAME_TYPE_EXCHANGE,在线兑换
     * URL_NAME_TYPE_MALL,在线商城
     * "URL_NAME_TYPE_VEHICLE_INFORMATION，车辆信息（该权限申请及说明详见Q&A)
     * 否
     */
    public $url_name_type = NULL;

    /**
     * custom_url
     * 商户自定义url 地址，支持卡券页内跳转,跳转页面内容需与自定义cell 名称保持一致。
     * 否
     */
    public $custom_url = NULL;

    public function __construct($logo_url, $brand_name, $code_type, $title, $color, $notice, $description, DateInfo $date_info, Sku $sku)
    {
        if (! $date_info instanceof DateInfo)
            exit("date_info Error");
        if (! $sku instanceof Sku)
            exit("sku Error");
        
        $this->logo_url = $logo_url;
        $this->code_type = $code_type;
        $this->brand_name = $brand_name;
        $this->title = $title;
        $this->color = $color;
        $this->notice = $notice;
        $this->description = $description;
        $this->date_info = $date_info;
        $this->sku = $sku;
    }

    public function set_sub_title($sub_title)
    {
        $this->sub_title = $sub_title;
    }

    public function set_service_phone($service_phone)
    {
        $this->service_phone = $service_phone;
    }

    public function set_source($source)
    {
        $this->source = $source;
    }

    public function set_use_limit($use_limit)
    {
        if (! is_int($use_limit))
            exit("use_limit must be integer");
        $this->use_limit = $use_limit;
    }

    public function set_get_limit($get_limit)
    {
        if (! is_int($get_limit))
            exit("get_limit must be integer");
        $this->get_limit = $get_limit;
    }

    public function set_use_custom_code($use_custom_code)
    {
        $this->use_custom_code = $use_custom_code;
    }

    public function set_bind_openid($bind_openid)
    {
        $this->bind_openid = $bind_openid;
    }

    public function set_can_share($can_share)
    {
        $this->can_share = $can_share;
    }

    public function set_can_give_friend($can_give_friend)
    {
        $this->can_give_friend = $can_give_friend;
    }

    public function set_location_id_list(array $location_id_list)
    {
        $this->location_id_list = $location_id_list;
    }

    public function set_url_name_type($url_name_type)
    {
        $this->url_name_type = $url_name_type;
    }

    public function set_custom_url($custom_url)
    {
        $this->custom_url = $custom_url;
    }

    public function getParams()
    {
        $params = array();
        if ($this->logo_url != NULL) {
            $params['logo_url'] = $this->logo_url;
        }
        if ($this->code_type != NULL) {
            $params['code_type'] = $this->code_type;
        }
        if ($this->brand_name != NULL) {
            $params['brand_name'] = $this->brand_name;
        }
        if ($this->title != NULL) {
            $params['title'] = $this->title;
        }
        if ($this->sub_title != NULL) {
            $params['sub_title'] = $this->sub_title;
        }
        if ($this->color != NULL) {
            $params['color'] = $this->color;
        }
        if ($this->notice != NULL) {
            $params['notice'] = $this->notice;
        }
        if ($this->service_phone != NULL) {
            $params['service_phone'] = $this->service_phone;
        }
        if ($this->source != NULL) {
            $params['source'] = $this->source;
        }
        if ($this->description != NULL) {
            $params['description'] = $this->description;
        }
        if ($this->use_limit != NULL) {
            $params['use_limit'] = $this->use_limit;
        }
        if ($this->get_limit != NULL) {
            $params['get_limit'] = $this->get_limit;
        }
        if ($this->use_custom_code != NULL) {
            $params['use_custom_code'] = $this->use_custom_code;
        }
        if ($this->bind_openid != NULL) {
            $params['bind_openid'] = $this->bind_openid;
        }
        if ($this->can_share != NULL) {
            $params['can_share'] = $this->can_share;
        }
        if ($this->can_give_friend != NULL) {
            $params['can_give_friend'] = $this->can_give_friend;
        }
        if ($this->location_id_list != NULL) {
            $params['location_id_list'] = $this->location_id_list;
        }
        if ($this->date_info != NULL) {
            $params['date_info'] = $this->date_info->getParams();
        }
        if ($this->sku != NULL) {
            $params['sku'] = $this->sku->getParams();
        }
        if ($this->url_name_type != NULL) {
            $params['url_name_type'] = $this->url_name_type;
        }
        if ($this->custom_url != NULL) {
            $params['custom_url'] = $this->custom_url;
        }
        return $params;
    }
}

/**
 * 卡的基类
 */
abstract class CardBase
{

    public static $CARD_TYPE = Array(
        "GENERAL_COUPON" => "GENERAL_COUPON",
        "GROUPON" => "GROUPON",
        "DISCOUNT" => "DISCOUNT",
        "GIFT" => "GIFT",
        "CASH" => "CASH",
        "MEMBER_CARD" => "MEMBER_CARD",
        "SCENIC_TICKET" => "SCENIC_TICKET",
        "MOVIE_TICKET" => "MOVIE_TICKET",
        "BOARDING_PASS" => "BOARDING_PASS",
        "LUCKY_MONEY" => "LUCKY_MONEY"
    );

    /**
     *
     * @var BaseInfo
     */
    public $base_info = NULL;

    public $card_type = NULL;

    public $create_key = NULL;

    public $card_id = NULL;

    public function __construct(BaseInfo $base_info)
    {
        $this->base_info = $base_info;
    }

    protected function getParams()
    {
        $params = array();
        return $params;
    }

    public function getParams4Create()
    {
        $params = array();
        $params['card_type'] = $this->card_type;
        $params[$this->create_key]['base_info'] = $this->base_info->getParams();
        
        $selfParams = $this->getParams();
        foreach ($selfParams as $key => $value) {
            $params[$this->create_key][$key] = $value;
        }
        return $params;
    }

    public function getParams4Update()
    {
        $params = array();
        $params['card_id'] = $this->card_id;
        $params[$this->create_key]['base_info'] = $this->base_info->getParams();
        $selfParams = $this->getParams();
        foreach ($selfParams as $key => $value) {
            $params[$this->create_key][$key] = $value;
        }
        return $params;
    }
}

/**
 * 通用券
 */
class GeneralCoupon extends CardBase
{

    /**
     * default_detail
     * 描述文本
     * 是
     */
    public $default_detail = NULL;

    public function __construct(BaseInfo $base_info, $default_detail)
    {
        parent::__construct($base_info);
        $this->card_type = self::$CARD_TYPE["GENERAL_COUPON"];
        $this->create_key = 'general_coupon';
        $this->default_detail = $default_detail;
    }

    protected function getParams()
    {
        $params = array();
        if ($this->default_detail != NULL) {
            $params['default_detail'] = $this->default_detail;
        }
        return $params;
    }
}

/**
 * 团购券
 */
class Groupon extends CardBase
{

    /**
     * deal_detail
     * 团购券专用，团购详情.
     * 是
     */
    public $deal_detail = NULL;

    public function __construct(BaseInfo $base_info, $deal_detail)
    {
        parent::__construct($base_info);
        $this->card_type = self::$CARD_TYPE["GROUPON"];
        $this->create_key = 'groupon';
        $this->deal_detail = $deal_detail;
    }

    protected function getParams()
    {
        $params = array();
        if ($this->deal_detail != NULL) {
            $params['deal_detail'] = $this->deal_detail;
        }
        return $params;
    }
}

/**
 * 礼品券
 */
class Gift extends CardBase
{

    /**
     * gift
     * 礼品券专用，表示礼品名字。
     * 是
     */
    public $gift = NULL;

    public function __construct(BaseInfo $base_info, $gift)
    {
        parent::__construct($base_info);
        $this->card_type = self::$CARD_TYPE["GIFT"];
        $this->create_key = 'gift';
        $this->gift = $gift;
    }

    protected function getParams()
    {
        $params = array();
        if ($this->gift != NULL) {
            $params['gift'] = $this->gift;
        }
        return $params;
    }
}

/**
 * 代金券
 */
class Cash extends CardBase
{

    /**
     * least_cost
     * 代金券专用，表示起用金额（单位为分）
     * 否
     */
    public $least_cost = NULL;

    /**
     * reduce_cost
     * 代金券专用，表示减免金额（单位为分）
     * 是
     */
    public $reduce_cost = NULL;

    public function __construct(BaseInfo $base_info, $reduce_cost)
    {
        parent::__construct($base_info);
        $this->card_type = self::$CARD_TYPE["CASH"];
        $this->create_key = 'cash';
        $this->reduce_cost = $reduce_cost;
    }

    public function set_least_cost($least_cost)
    {
        $this->least_cost = $least_cost;
    }

    protected function getParams()
    {
        $params = array();
        if ($this->least_cost != NULL) {
            $params['least_cost'] = $this->least_cost;
        }
        if ($this->reduce_cost != NULL) {
            $params['reduce_cost'] = $this->reduce_cost;
        }
        return $params;
    }
}

/**
 * 折扣券
 */
class Discount extends CardBase
{

    /**
     * discount
     * 折扣券专用，表示打折额度（百分比）。填30 就是七折。
     * 是
     */
    public $discount = NULL;

    public function __construct(BaseInfo $base_info, $discount)
    {
        parent::__construct($base_info);
        $this->card_type = self::$CARD_TYPE["DISCOUNT"];
        $this->create_key = 'discount';
        $this->discount = $discount;
    }

    protected function getParams()
    {
        $params = array();
        if ($this->discount != NULL) {
            $params['discount'] = $this->discount;
        }
        return $params;
    }
}

/**
 * 会员卡
 */
class MemberCard extends CardBase
{

    /**
     * supply_bonus
     * 是否支持积分，填写true 或false，如填写true，积分相关字段均为必填。填写false，积分字段无需填写。储值字段处理方式相同。
     * 是
     */
    public $supply_bonus = NULL;

    /**
     * supply_balance
     * 是否支持储值，填写true 或false。（该权限申请及说明详见Q&A)
     * 是
     */
    public $supply_balance = NULL;

    /**
     * bonus_cleared
     * 积分清零规则
     * 否
     */
    public $bonus_cleared = NULL;

    /**
     * bonus_rules
     * 积分规则
     * 否
     */
    public $bonus_rules = NULL;

    /**
     * balance_rules
     * 储值说明
     * 否
     */
    public $balance_rules = NULL;

    /**
     * prerogative
     * 特权说明
     * 是
     */
    public $prerogative = NULL;

    /**
     * bind_old_card_url
     * 绑定旧卡的url，与“activate_url”字段二选一必填。
     * 否
     */
    public $bind_old_card_url = NULL;

    /**
     * activate_url
     * 激活会员卡的url，与“bind_old_card_url”字段二选一必填。
     * 否
     */
    public $activate_url = NULL;

    public function __construct(BaseInfo $base_info, $supply_bonus, $supply_balance, $prerogative)
    {
        parent::__construct($base_info);
        $this->card_type = self::$CARD_TYPE["MEMBER_CARD"];
        $this->create_key = 'member_card';
        $this->supply_bonus = $supply_bonus;
        $this->supply_balance = $supply_balance;
        $this->prerogative = $prerogative;
    }

    public function set_bonus_cleared($bonus_cleared)
    {
        $this->bonus_cleared = $bonus_cleared;
    }

    public function set_bonus_rules($bonus_rules)
    {
        $this->bonus_rules = $bonus_rules;
    }

    public function set_balance_rules($balance_rules)
    {
        $this->balance_rules = $balance_rules;
    }

    public function set_bind_old_card_url($bind_old_card_url)
    {
        $this->bind_old_card_url = $bind_old_card_url;
    }

    public function set_activate_url($activate_url)
    {
        $this->activate_url = $activate_url;
    }

    protected function getParams()
    {
        $params = array();
        if ($this->supply_bonus != NULL) {
            $params['supply_bonus'] = $this->supply_bonus;
        }
        if ($this->supply_balance != NULL) {
            $params['supply_balance'] = $this->supply_balance;
        }
        if ($this->bonus_cleared != NULL) {
            $params['bonus_cleared'] = $this->bonus_cleared;
        }
        if ($this->bonus_rules != NULL) {
            $params['bonus_rules'] = $this->bonus_rules;
        }
        if ($this->balance_rules != NULL) {
            $params['balance_rules'] = $this->balance_rules;
        }
        if ($this->prerogative != NULL) {
            $params['prerogative'] = $this->prerogative;
        }
        if ($this->bind_old_card_url != NULL) {
            $params['bind_old_card_url'] = $this->bind_old_card_url;
        }
        if ($this->activate_url != NULL) {
            $params['activate_url'] = $this->activate_url;
        }
        return $params;
    }
}

/**
 * 门票
 */
class ScenicTicket extends CardBase
{

    /**
     * ticket_class
     * 票类型，例如平日全票，套票等。
     * 否
     */
    public $ticket_class = NULL;

    /**
     * guide_url
     * 导览图url
     * 否
     */
    public $guide_url = NULL;

    public function __construct(BaseInfo $base_info)
    {
        parent::__construct($base_info);
        $this->card_type = self::$CARD_TYPE["SCENIC_TICKET"];
        $this->create_key = 'scenic_ticket';
    }

    public function set_ticket_class($ticket_class)
    {
        $this->ticket_class = $ticket_class;
    }

    public function set_guide_url($guide_url)
    {
        $this->guide_url = $guide_url;
    }

    protected function getParams()
    {
        $params = array();
        
        if ($this->ticket_class != NULL) {
            $params['ticket_class'] = $this->ticket_class;
        }
        if ($this->guide_url != NULL) {
            $params['guide_url'] = $this->guide_url;
        }
        return $params;
    }
}

/**
 * 电影票
 */
class MovieTicket extends CardBase
{

    /**
     * detail 电影票详情
     * 否
     */
    public $detail = NULL;

    public function __construct(BaseInfo $base_info)
    {
        parent::__construct($base_info);
        $this->card_type = self::$CARD_TYPE["MOVIE_TICKET"];
        $this->create_key = 'movie_ticket';
    }

    public function set_detail($detail)
    {
        $this->detail = $detail;
    }

    protected function getParams()
    {
        $params = array();
        
        if ($this->detail != NULL) {
            $params['detail'] = $this->detail;
        }
        return $params;
    }
}

/**
 * 飞机票
 */
class BoardingPass extends CardBase
{

    /**
     * from
     * 起点，上限为18 个汉字。
     * 是
     */
    public $from = NULL;

    /**
     * to
     * 终点，上限为18 个汉字。
     * 是
     */
    public $to = NULL;

    /**
     * flight
     * 航班
     * 是
     */
    public $flight = NULL;

    /**
     * departure_time
     * 起飞时间，上限为17 个汉字。
     * 否
     */
    public $departure_time = NULL;

    /**
     * landing_time
     * 降落时间，上限为17 个汉字。
     * 否
     */
    public $landing_time = NULL;

    /**
     * check_in_url
     * 在线值机的链接
     * 否
     */
    public $check_in_url = NULL;

    /**
     * air_model
     * 机型，上限为8 个汉字
     * 否
     */
    public $air_model = NULL;

    public function __construct(BaseInfo $base_info, $from, $to, $flight)
    {
        parent::__construct($base_info);
        $this->card_type = self::$CARD_TYPE["BOARDING_PASS"];
        $this->create_key = 'boarding_pass';
        $this->from = $from;
        $this->to = $to;
        $this->flight = $flight;
    }

    public function set_departure_time($departure_time)
    {
        $this->departure_time = $departure_time;
    }

    public function set_landing_time($landing_time)
    {
        $this->landing_time = $landing_time;
    }

    public function set_check_in_url($check_in_url)
    {
        $this->check_in_url = $check_in_url;
    }

    public function set_air_model($air_model)
    {
        $this->air_model = $air_model;
    }

    protected function getParams()
    {
        $params = array();
        
        if ($this->from != NULL) {
            $params['from'] = $this->from;
        }
        if ($this->to != NULL) {
            $params['to'] = $this->to;
        }
        if ($this->flight != NULL) {
            $params['flight'] = $this->flight;
        }
        if ($this->departure_time != NULL) {
            $params['departure_time'] = $this->departure_time;
        }
        if ($this->landing_time != NULL) {
            $params['landing_time'] = $this->landing_time;
        }
        if ($this->check_in_url != NULL) {
            $params['check_in_url'] = $this->check_in_url;
        }
        if ($this->air_model != NULL) {
            $params['air_model'] = $this->air_model;
        }
        return $params;
    }
}

/**
 * 红包
 */
class LuckyMoney extends CardBase
{

    public function __construct(BaseInfo $base_info)
    {
        parent::__construct($base_info);
        $this->create_key = 'lucky_money';
        $this->card_type = self::$CARD_TYPE["LUCKY_MONEY；"];
    }
}

class Signature
{

    public function __construct()
    {
        $this->data = array();
    }

    public function add_data($str)
    {
        array_push($this->data, (string) $str);
    }

    public function get_signature()
    {
        sort($this->data);
        return sha1(implode($this->data));
    }
}

// ------------------------set base_info-----------------------------
$base_info = new BaseInfo("http://www.supadmin.cn/uploads/allimg/120216/1_120216214725_1.jpg", "海底捞", 0, "132元双人火锅套餐", "Color010", "使用时向服务员出示此券", "020-88888888", "不可与其他优惠同享\n 如需团购券发票，请在消费时向商户提出\n 店内均可使用，仅限堂食\n 餐前不可打包，餐后未吃完，可打包\n 本团购券不限人数，建议2人使用，超过建议人数须另收酱料费5元/位\n 本单谢绝自带酒水饮料", new DateInfo(1, 1397577600, 1399910400), new Sku(50000000));
$base_info->set_sub_title("");
$base_info->set_use_limit(1);
$base_info->set_get_limit(3);
$base_info->set_use_custom_code(false);
$base_info->set_bind_openid(false);
$base_info->set_can_share(true);
$base_info->set_url_name_type(1);
$base_info->set_custom_url("http://www.qq.com");
// ---------------------------set_card--------------------------------

$card = new Groupon($base_info, "以下锅底2 选1（有菌王锅、麻辣锅、大骨锅、番茄锅、清补凉锅、酸菜鱼锅可选）：\n 大锅1 份12 元\n 小锅2 份16 元\n 以下菜品2 选1\n 特级肥牛1 份30 元\n 洞庭鮰鱼卷1 份20元\n 其他\n鲜菇猪肉滑1 份18 元\n 金针菇1 份16 元\n 黑木耳1 份9 元\n 娃娃菜1 份8 元\n 冬瓜1份6 元\n 火锅面2 个6 元\n 欢乐畅饮2 位12 元\n 自助酱料2 位10 元");

// ----------------------check signature------------------------
$signature = new Signature();
$signature->add_data("123");
$signature->add_data("wasda");
$signature->add_data("_()@#(&");
echo $signature->get_signature();
?>