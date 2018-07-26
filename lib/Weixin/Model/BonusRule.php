<?php
namespace Weixin\Model;

/**
 * 积分规则。用于微信买单功能。
 */
class BonusRule extends Base
{

    /**
     * cost_money_unit 否 int 100 消费金额。以分为单位。
     */
    public $cost_money_unit = NULL;

    /**
     * increase_bonus 否 int 100 对应增加的积分。
     */
    public $increase_bonus = NULL;

    /**
     * max_increase_bonus 否 int 10000 用户单次可获取的积分上限。
     */
    public $max_increase_bonus = NULL;

    /**
     * init_increase_bonus 否 int 10 初始设置积分。
     */
    public $init_increase_bonus = NULL;

    /**
     * cost_bonus_unit 否 int 10 每使用5积分。
     */
    public $cost_bonus_unit = NULL;

    /**
     * reduce_money 否 int 10 抵扣xx元，（这里以分为单位）
     */
    public $reduce_money = NULL;

    /**
     * least_money_to_use_bonus 否 int 100 抵扣条件，满xx元（这里以分为单位）可用。
     */
    public $least_money_to_use_bonus = NULL;

    /**
     * max_reduce_bonus 否 int 10 抵扣条件，单笔最多使用xx积分。
     */
    public $max_reduce_bonus = NULL;

    public function __construct()
    {}

    public function getParams()
    {
        $params = array();
        
        if ($this->isNotNull($this->cost_money_unit)) {
            $params['cost_money_unit'] = $this->cost_money_unit;
        }
        
        if ($this->isNotNull($this->increase_bonus)) {
            $params['increase_bonus'] = $this->increase_bonus;
        }
        
        if ($this->isNotNull($this->max_increase_bonus)) {
            $params['max_increase_bonus'] = $this->max_increase_bonus;
        }
        
        if ($this->isNotNull($this->init_increase_bonus)) {
            $params['init_increase_bonus'] = $this->init_increase_bonus;
        }
        
        if ($this->isNotNull($this->cost_bonus_unit)) {
            $params['cost_bonus_unit'] = $this->cost_bonus_unit;
        }
        
        if ($this->isNotNull($this->reduce_money)) {
            $params['reduce_money'] = $this->reduce_money;
        }
        
        if ($this->isNotNull($this->least_money_to_use_bonus)) {
            $params['least_money_to_use_bonus'] = $this->least_money_to_use_bonus;
        }
        
        if ($this->isNotNull($this->max_reduce_bonus)) {
            $params['max_reduce_bonus'] = $this->max_reduce_bonus;
        }
        return $params;
    }
}
