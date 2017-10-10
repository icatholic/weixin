<?php
namespace Weixin\Model;

/**
 * 通用卡
 */
class GeneralCard extends CardBase
{

    /**
     * background_pic_url 礼品卡背景图片 否
     */
    public $background_pic_url = NULL;

    /**
     * sub_card_type 卡类型，
     * 目前支持
     * GIFT_CARD 礼品卡
     * VOUCHER 兑换卡
     * 是
     */
    public $sub_card_type = NULL;

    /**
     * auto_activate
     * 是否自动激活，若开发者不需要额外激活流程则填写true。
     * 否
     */
    public $auto_activate = NULL;

    /**
     * init_balance
     * 初始余额，用户购买礼品卡后卡面上显示的初始余额
     * 否
     */
    public $init_balance = NULL;

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

    public function __construct(BaseInfo $base_info, $sub_card_type, $supply_bonus, $supply_balance)
    {
        parent::__construct($base_info);
        $this->card_type = self::$CARD_TYPE["GENERAL_CARD"];
        $this->create_key = 'general_card';
        $this->sub_card_type = $sub_card_type;
        $this->supply_bonus = $supply_bonus;
        $this->supply_balance = $supply_balance;
    }

    public function set_background_pic_url($background_pic_url)
    {
        $this->background_pic_url = $background_pic_url;
    }

    public function set_auto_activate($auto_activate)
    {
        $this->auto_activate = $auto_activate;
    }

    public function set_init_balance($init_balance)
    {
        $this->init_balance = $init_balance;
    }

    public function set_custom_field1(\Weixin\Model\GiftCard\CustomField $custom_field1)
    {
        $this->custom_field1 = $custom_field1;
    }

    public function set_custom_field2(\Weixin\Model\GiftCard\CustomField $custom_field2)
    {
        $this->custom_field2 = $custom_field2;
    }

    public function set_custom_field3(\Weixin\Model\GiftCard\CustomField $custom_field3)
    {
        $this->custom_field3 = $custom_field3;
    }

    public function getParams()
    {
        $params = array();
        
        if ($this->isNotNull($this->background_pic_url)) {
            $params['background_pic_url'] = $this->background_pic_url;
        }
        if ($this->isNotNull($this->sub_card_type)) {
            $params['sub_card_type'] = $this->sub_card_type;
        }
        if ($this->isNotNull($this->auto_activate)) {
            $params['auto_activate'] = $this->auto_activate;
        }
        if ($this->isNotNull($this->init_balance)) {
            $params['init_balance'] = $this->init_balance;
        }
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
        
        return $params;
    }
}
