<?php
namespace Weixin\Model\Mall\ImportOrder;

use Weixin\Model\Base;

/**
 * 订单优惠信息
 */
class PromotionInfo extends Base
{

    /**
     * discount_fee 是 uint32 优惠金额
     */
    public $discount_fee = NULL;

    public function __construct($discount_fee)
    {
        $this->discount_fee = $discount_fee;
    }

    public function set_discount_fee($discount_fee)
    {
        $this->discount_fee = $discount_fee;
    }

    public function getParams()
    {
        $params = array();
        if ($this->isNotNull($this->discount_fee)) {
            $params['discount_fee'] = $this->discount_fee;
        }
        return $params;
    }
}
