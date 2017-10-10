<?php
namespace Weixin\Model;

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
     * custom_field1
     * 自定义会员信息类目，会员卡激活后显示
     *
     * 否
     */
    public $custom_field1 = NULL;

    /**
     * custom_field2
     * 自定义会员信息类目，会员卡激活后显示
     * 否
     */
    public $custom_field2 = NULL;

    /**
     * custom_field3
     * 自定义会员信息类目，会员卡激活后显示
     * 否
     */
    public $custom_field3 = NULL;

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
     * need_push_on_view
     * true为用户点击进入会员卡时是否推送事件。详情见六、进入会员卡事件推送。
     * 否
     */
    public $need_push_on_view = NULL;

    /**
     * 会员卡类型专属营销入口，会员卡激活前后均显示。
     * 否
     */
    public $custom_cell1 = NULL;

    /**
     * 会员卡类型专属营销入口，会员卡激活前后均显示。
     * 否
     */
    public $custom_cell2 = NULL;

    /**
     * 高级自定义字段
     * @var unknown
     */
    public $advanced_info = NULL;

    /***
     * 商家自定义会员卡背景图
     * @var unknown
     */
    public $background_pic_url = NULL;
    
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

    public function set_custom_field1(CustomField $custom_field1)
    {
        $this->custom_field1 = $custom_field1;
    }

    public function set_custom_field2(CustomField $custom_field2)
    {
        $this->custom_field2 = $custom_field2;
    }

    public function set_custom_field3(CustomField $custom_field3)
    {
        $this->custom_field3 = $custom_field3;
    }

    public function set_need_push_on_view($need_push_on_view)
    {
        $this->need_push_on_view = $need_push_on_view;
    }

    public function set_custom_cell1(CustomCell $custom_cell1)
    {
        $this->custom_cell1 = $custom_cell1;
    }

    public function set_custom_cell2(CustomCell $custom_cell2)
    {
        $this->custom_cell2 = $custom_cell2;
    }

    /**
     * 创建优惠券特有的高级字段
     *
     * @param string $accept_category            
     * @param string $reject_category            
     * @param string $can_use_with_other_discount            
     */
    public function set_advanced_info($accept_category = '', $reject_category = '', $can_use_with_other_discount = true)
    {
        if (! empty($accept_category)) {
            $this->advanced_info['use_condition']['accept_category'] = $accept_category;
        }
        if (! empty($reject_category)) {
            $this->advanced_info['use_condition']['reject_category'] = $reject_category;
        }
        if (! empty($accept_category) || ! empty($reject_category)) {
            $this->advanced_info['use_condition']['can_use_with_other_discount'] = $can_use_with_other_discount;
        }
    }

    /**
     * 封面摘要结构体名称
     *
     * @param string $abstract
     *            封面摘要简介。
     * @param array $icon_url_list
     *            封面图片列表，仅支持填入一个封面图片链接，上传图片接口上传获取图片获得链接，填写非CDN链接会报错，并在此填入。建议图片尺寸像素850*350
     */
    public function set_abstract($abstract = '', $icon_url_list = array())
    {
        if (! empty($abstract)) {
            $this->advanced_info['abstract']['abstract'] = $abstract;
        }
        if (! empty($icon_url_list)) {
            $this->advanced_info['abstract']['icon_url_list'] = $icon_url_list;
        }
    }

    /**
     * 图文列表，显示在详情内页，优惠券券开发者须至少传入一组图文列表
     *
     * @param array $text_image_list
     *            [ {
     *            "image_url": "http://mmbiz.qpic.cn/mmbiz/p98FjXy8LacgHxp3sJ3vn97bGLz0ib0Sfz1bjiaoOYA027iasqSG0sjpiby4vce3AtaPu6cIhBHkt6IjlkY9YnDsfw/0",
     *            "text": "此菜品精选食材，以独特的烹饪方法，最大程度地刺激食 客的味蕾"
     *            } ]
     */
    public function set_text_image_list($text_image_list = array())
    {
        $this->advanced_info['text_image_list'] = $text_image_list;
    }

    /**
     * 使用时段限制
     *
     * @param array $time_limit
     *            [ {
     *            "type": "MONDAY",
     *            "begin_hour":0,
     *            "end_hour":10,
     *            "begin_minute":10,
     *            "end_minute":59
     *            } ]
     *            
     */
    public function set_time_limit($time_limit = array())
    {
        $this->advanced_info['time_limit'] = $time_limit;
    }

    /**
     * 商家服务类型：
     * BIZ_SERVICE_DELIVER 外卖服务；
     * BIZ_SERVICE_FREE_PARK 停车位；
     * BIZ_SERVICE_WITH_PET 可带宠物；
     * BIZ_SERVICE_FREE_WIFI 免费wifi，
     * 可多选
     *
     * @param array $business_service            
     */
    public function set_business_service($business_service = array())
    {
        $this->advanced_info['business_service'] = $business_service;
    }

    /**
     * 卡面设计请遵循微信会员卡自定义背景设计规范  ,像素大小控制在1000像素*600像素以下
     * @param unknown $background_pic_url
     */
    public function set_background_pic_url($background_pic_url)
    {
        $this->background_pic_url = $background_pic_url;
    }
    
    public function getParams()
    {
        $params = array();
        if ($this->isNotNull($this->supply_bonus)) {
            $params['supply_bonus'] = $this->supply_bonus;
        }
        if ($this->isNotNull($this->supply_balance)) {
            $params['supply_balance'] = $this->supply_balance;
        }
        if ($this->isNotNull($this->custom_field1)) {
            $params['custom_field1'] = $this->custom_field1->getParams();
        }
        if ($this->isNotNull($this->custom_field2)) {
            $params['custom_field2'] = $this->custom_field2->getParams();
        }
        if ($this->isNotNull($this->custom_field3)) {
            $params['custom_field3'] = $this->custom_field3->getParams();
        }
        if ($this->isNotNull($this->bonus_cleared)) {
            $params['bonus_cleared'] = $this->bonus_cleared;
        }
        if ($this->isNotNull($this->bonus_rules)) {
            $params['bonus_rules'] = $this->bonus_rules;
        }
        if ($this->isNotNull($this->balance_rules)) {
            $params['balance_rules'] = $this->balance_rules;
        }
        if ($this->isNotNull($this->prerogative)) {
            $params['prerogative'] = $this->prerogative;
        }
        if ($this->isNotNull($this->bind_old_card_url)) {
            $params['bind_old_card_url'] = $this->bind_old_card_url;
        }
        if ($this->isNotNull($this->activate_url)) {
            $params['activate_url'] = $this->activate_url;
        }
        if ($this->isNotNull($this->need_push_on_view)) {
            $params['need_push_on_view'] = $this->need_push_on_view;
        }
        if ($this->isNotNull($this->custom_cell1)) {
            $params['custom_cell1'] = $this->custom_cell1->getParams();
        }
        if ($this->isNotNull($this->custom_cell2)) {
            $params['custom_cell2'] = $this->custom_cell2->getParams();
        }
        if ($this->isNotNull($this->advanced_info)) {
            $params['advanced_info'] = $this->advanced_info;
        }
        if ($this->isNotNull($this->background_pic_url)) {
            $params['background_pic_url'] = $this->background_pic_url;
        }
        return $params;
    }
}
