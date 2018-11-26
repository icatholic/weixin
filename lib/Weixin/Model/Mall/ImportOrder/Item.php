<?php
namespace Weixin\Model\Mall\ImportOrder;

use Weixin\Model\Base;

/**
 * 订单信息
 */
class Item extends Base
{

    /**
     * item_code 是 string 商品id
     * sku_id 是 string sku_id
     * amount 是 uint32 商品数量
     * total_fee 是 uint32 商品总价，单位：分
     * thumb_url 否 string 商品缩略图url
     * title 是 string 商品名称
     * desc 否 string 商品详细描述
     * unit_price 是 uint32 商品单价（实际售价），单位：分
     * original_price 是 uint32 商品原价，单位：分
     * stock_attr_info 否 array 商品属性列表
     * category_list 是 array 商品类目列表
     * item_detail_page 是 object 商品详情页（小程序页面）
     */
    public $item_code = NULL;

    public $sku_id = NULL;

    public $amount = NULL;

    public $total_fee = NULL;

    public $thumb_url = NULL;

    public $title = NULL;

    public $desc = NULL;

    public $unit_price = NULL;

    public $original_price = NULL;

    public $stock_attr_info = NULL;

    public $category_list = NULL;

    public $item_detail_page = NULL;

    public function __construct($item_code, $sku_id, $amount, $total_fee, $title, $unit_price, $original_price, array $category_list, ItemDetailPage $item_detail_page)
    {
        $this->item_code = $item_code;
        $this->sku_id = $sku_id;
        $this->amount = $amount;
        $this->total_fee = $total_fee;
        $this->title = $title;
        $this->unit_price = $unit_price;
        $this->original_price = $original_price;
        $this->category_list = $category_list;
        $this->item_detail_page = $item_detail_page;
    }

    public function set_item_code($item_code)
    {
        $this->item_code = $item_code;
    }

    public function set_sku_id($sku_id)
    {
        $this->sku_id = $sku_id;
    }

    public function set_amount($amount)
    {
        $this->amount = $amount;
    }

    public function set_total_fee($total_fee)
    {
        $this->total_fee = $total_fee;
    }

    public function set_thumb_url($thumb_url)
    {
        $this->thumb_url = $thumb_url;
    }

    public function set_title($title)
    {
        $this->title = $title;
    }

    public function set_desc($desc)
    {
        $this->desc = $desc;
    }

    public function set_unit_price($unit_price)
    {
        $this->unit_price = $unit_price;
    }

    public function set_original_price($original_price)
    {
        $this->original_price = $original_price;
    }

    public function set_stock_attr_info(array $stock_attr_info)
    {
        $this->stock_attr_info = $stock_attr_info;
    }

    public function set_category_list(array $category_list)
    {
        $this->category_list = $category_list;
    }

    public function set_item_detail_page($item_detail_page)
    {
        $this->item_detail_page = $item_detail_page;
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
        if ($this->isNotNull($this->amount)) {
            $params['amount'] = $this->amount;
        }
        if ($this->isNotNull($this->total_fee)) {
            $params['total_fee'] = $this->total_fee;
        }
        
        if ($this->isNotNull($this->thumb_url)) {
            $params['thumb_url'] = $this->thumb_url;
        }
        if ($this->isNotNull($this->title)) {
            $params['title'] = $this->title;
        }
        
        if ($this->isNotNull($this->desc)) {
            $params['desc'] = $this->desc;
        }
        
        if ($this->isNotNull($this->unit_price)) {
            $params['unit_price'] = $this->unit_price;
        }
        
        if ($this->isNotNull($this->original_price)) {
            $params['original_price'] = $this->original_price;
        }
        if ($this->isNotNull($this->stock_attr_info)) {
            $stock_attr_info = array();
            foreach ($this->stock_attr_info as $stock_attr) {
                $stock_attr_info[] = $stock_attr->getParams();
            }
            $params['stock_attr_info'] = $stock_attr_info;
        }
        if ($this->isNotNull($this->category_list)) {
            $params['category_list'] = $this->category_list;
        }
        if ($this->isNotNull($this->item_detail_page)) {
            $params['item_detail_page'] = $this->item_detail_page->getParams();
        }
        
        return $params;
    }
}
