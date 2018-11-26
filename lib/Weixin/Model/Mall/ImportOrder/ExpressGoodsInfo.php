<?php
namespace Weixin\Model\Mall\ImportOrder;

use Weixin\Model\Base;

/**
 * 包裹商品信息
 */
class ExpressGoodsInfo extends Base
{

    /**
     * item_code 是 string 商品id
     * sku_id 是 string sku_id
     */
    public $item_code = NULL;

    public $sku_id = NULL;

    public function __construct($item_code, $sku_id)
    {
        $this->item_code = $item_code;
        $this->sku_id = $sku_id;
    }

    public function set_item_code($item_code)
    {
        $this->item_code = $item_code;
    }

    public function set_sku_id($sku_id)
    {
        $this->sku_id = $sku_id;
    }

    public function getParams()
    {
        $params = array();
        if ($this->isNotNull($this->item_code)) {
            $params['item_code'] = $this->item_code;
        }
        if ($this->isNotNull($this->sku_id)) {
            $params['sku_id'] = $this->sku_id;
        }
        return $params;
    }
}
