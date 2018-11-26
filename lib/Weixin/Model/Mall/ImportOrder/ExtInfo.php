<?php
namespace Weixin\Model\Mall\ImportOrder;

use Weixin\Model\Base;

/**
 * 订单扩展信息
 */
class ExtInfo extends Base
{

    /**
     * product_info 是 object 商品相关信息
     * express_info 是 object 快递信息
     * promotion_info 否 object 订单优惠信息
     * brand_info 是 object 商家信息
     * invoice_info 否 object 发票信息，对于开发票订单，该字段必填
     * payment_method 是 uint32 订单支付方式，0：未知方式 1：微信支付 2：其他支付方式
     * user_open_id 是 string 用户openid
     * order_detail_page 是 object 订单详情页（小程序页面）
     */
    public $product_info = NULL;

    public $express_info = NULL;

    public $promotion_info = NULL;

    public $brand_info = NULL;

    public $invoice_info = NULL;

    public $payment_method = NULL;

    public $user_open_id = NULL;

    public $order_detail_page = NULL;

    public function __construct(ProductInfo $product_info, ExpressInfo $express_info, BrandInfo $brand_info, $payment_method, $user_open_id, OrderDetailPage $order_detail_page)
    {
        $this->product_info = $product_info;
        $this->express_info = $express_info;
        $this->brand_info = $brand_info;
        $this->payment_method = $payment_method;
        $this->user_open_id = $user_open_id;
        $this->order_detail_page = $order_detail_page;
    }

    public function set_product_info(ProductInfo $product_info)
    {
        $this->product_info = $product_info;
    }

    public function set_express_info(ExpressInfo $express_info)
    {
        $this->express_info = $express_info;
    }

    public function set_promotion_info(PromotionInfo $promotion_info)
    {
        $this->promotion_info = $promotion_info;
    }

    public function set_brand_info(BrandInfo $brand_info)
    {
        $this->brand_info = $brand_info;
    }

    public function set_invoice_info(InvoiceInfo $invoice_info)
    {
        $this->invoice_info = $invoice_info;
    }

    public function set_payment_method($payment_method)
    {
        $this->payment_method = $payment_method;
    }

    public function set_user_open_id($user_open_id)
    {
        $this->user_open_id = $user_open_id;
    }

    public function set_order_detail_page(OrderDetailPage $order_detail_page)
    {
        $this->order_detail_page = $order_detail_page;
    }

    public function getParams()
    {
        $params = array();
        if ($this->isNotNull($this->product_info)) {
            $params['product_info'] = $this->product_info->getParams();
        }
        if ($this->isNotNull($this->express_info)) {
            $params['express_info'] = $this->express_info->getParams();
        }
        if ($this->isNotNull($this->promotion_info)) {
            $params['promotion_info'] = $this->promotion_info->getParams();
        }
        if ($this->isNotNull($this->brand_info)) {
            $params['brand_info'] = $this->brand_info->getParams();
        }
        if ($this->isNotNull($this->invoice_info)) {
            $params['invoice_info'] = $this->invoice_info->getParams();
        }
        if ($this->isNotNull($this->payment_method)) {
            $params['payment_method'] = $this->payment_method;
        }
        if ($this->isNotNull($this->user_open_id)) {
            $params['user_open_id'] = $this->user_open_id;
        }
        if ($this->isNotNull($this->order_detail_page)) {
            $params['order_detail_page'] = $this->order_detail_page->getParams();
        }
        
        return $params;
    }
}
