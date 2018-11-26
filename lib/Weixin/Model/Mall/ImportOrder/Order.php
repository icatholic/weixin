<?php
namespace Weixin\Model\Mall\ImportOrder;

use Weixin\Model\Base;

/**
 * 订单信息
 */
class Order extends Base
{

    /**
     * order_id 是 string 订单id，需要保证唯一性
     * create_time 是 uint32 订单创建时间，unix时间戳
     * pay_finish_time 是 uint32 支付完成时间，unix时间戳
     * desc 否 string 订单备注
     * fee 是 uint32 订单金额，单位：分
     * trans_id 否 string 微信支付订单id，对于使用微信支付的订单，该字段必填
     * status 是 uint32 订单状态，3：支付完成 4：已发货 5：已退款 100: 已完成
     * ext_info 是 object 订单扩展信息
     */
    public $order_id = NULL;

    public $create_time = NULL;

    public $pay_finish_time = NULL;

    public $desc = NULL;

    public $fee = NULL;

    public $trans_id = NULL;

    public $status = NULL;

    public $ext_info = NULL;

    public function __construct($order_id, $create_time, $pay_finish_time, $fee, $status, ExtInfo $ext_info)
    {
        $this->order_id = $order_id;
        $this->create_time = $create_time;
        $this->pay_finish_time = $pay_finish_time;
        $this->fee = $fee;
        $this->status = $status;
        $this->ext_info = $ext_info;
    }

    public function set_order_id($order_id)
    {
        $this->order_id = $order_id;
    }

    public function set_create_time($create_time)
    {
        $this->create_time = $create_time;
    }

    public function set_pay_finish_time($pay_finish_time)
    {
        $this->pay_finish_time = $pay_finish_time;
    }

    public function set_desc($desc)
    {
        $this->desc = $desc;
    }

    public function set_fee($fee)
    {
        $this->fee = $fee;
    }

    public function set_trans_id($trans_id)
    {
        $this->trans_id = $trans_id;
    }

    public function set_status($status)
    {
        $this->status = $status;
    }

    public function set_ext_info(ExtInfo $ext_info)
    {
        $this->ext_info = $ext_info;
    }

    public function getParams()
    {
        $params = array();
        if ($this->isNotNull($this->order_id)) {
            $params['order_id'] = $this->order_id;
        }
        if ($this->isNotNull($this->create_time)) {
            $params['create_time'] = $this->create_time;
        }
        if ($this->isNotNull($this->pay_finish_time)) {
            $params['pay_finish_time'] = $this->pay_finish_time;
        }
        if ($this->isNotNull($this->desc)) {
            $params['desc'] = $this->desc;
        }
        if ($this->isNotNull($this->fee)) {
            $params['fee'] = $this->fee;
        }
        if ($this->isNotNull($this->trans_id)) {
            $params['trans_id'] = $this->trans_id;
        }
        if ($this->isNotNull($this->status)) {
            $params['status'] = $this->status;
        }
        if ($this->isNotNull($this->ext_info)) {
            $params['ext_info'] = $this->ext_info->getParams();
        }
        
        return $params;
    }
}
