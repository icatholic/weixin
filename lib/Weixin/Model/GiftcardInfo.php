<?php
namespace Weixin\Model;

/**
 * 礼品卡信息
 */
class GiftcardInfo extends Base
{

    /**
     * price
     * 礼品卡的价格，以分为单位
     * 是
     */
    public $price = NULL;

    public function __construct($price)
    {
        if (intval($price) <= 0) {
            throw new \Exception('礼品卡的价格不能小于0');
        }
        $this->price = $price;
    }

    public function getParams()
    {
        $params = array();
        
        if ($this->isNotNull($this->price)) {
            $params['price'] = $this->price;
        }
        
        return $params;
    }
}
