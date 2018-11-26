<?php
namespace Weixin\Model\Mall\ShoppingList;

use Weixin\Model\Base;

/**
 * 商品信息
 */
class SkuInfo extends Base
{

    /**
     * sku_id 是 string 商品sku_id，特殊情况下可以填入与sku_id一致
     * price 否 int 商品价格，分为单位
     * original_price 否 int 商品原价，分为单位
     * version 否 int 数据版本号，需按照更新递增，用在并发更新场景
     * status 是 int 商品状态，1：在售，2：停售
     * sku_attr_list 否 object array sku属性列表，参考attr_list
     */
    public $sku_id = NULL;

    public $price = NULL;

    public $original_price = NULL;

    public $version = NULL;

    public $status = NULL;

    public $sku_attr_list = NULL;

    public function __construct($sku_id, $status)
    {
        $this->sku_id = $sku_id;
        $this->status = $status;
    }

    public function set_sku_id($sku_id)
    {
        $this->sku_id = $sku_id;
    }

    public function set_price($price)
    {
        $this->price = $price;
    }

    public function set_original_price($original_price)
    {
        $this->original_price = $original_price;
    }

    public function set_version($version)
    {
        $this->version = $version;
    }

    public function set_status($status)
    {
        $this->status = $status;
    }

    public function set_sku_attr_list(array $sku_attr_list)
    {
        $this->sku_attr_list = $sku_attr_list;
    }

    public function getParams()
    {
        $params = array();
        if ($this->isNotNull($this->sku_id)) {
            $params['sku_id'] = $this->sku_id;
        }
        if ($this->isNotNull($this->price)) {
            $params['price'] = $this->price;
        }
        if ($this->isNotNull($this->original_price)) {
            $params['original_price'] = $this->original_price;
        }
        if ($this->isNotNull($this->version)) {
            $params['version'] = $this->version;
        }
        if ($this->isNotNull($this->status)) {
            $params['status'] = $this->status;
        }
        if ($this->isNotNull($this->sku_attr_list)) {
            $sku_attr_list = array();
            foreach ($this->sku_attr_list as $sku_attr) {
                $sku_attr_list[] = $sku_attr->getParams();
            }
            $params['sku_attr_list'] = $sku_attr_list;
        }
        return $params;
    }
}
