<?php
namespace Weixin\Model\Mall\ImportOrder;

use Weixin\Model\Base;

/**
 * 发票信息，对于开发票订单，该字段必填
 */
class InvoiceInfo extends Base
{

    /**
     * type 是 uint32 抬头类型，0：单位，1：个人
     * title 是 string 发票抬头
     * tax_number 否 string 发票税号
     * company_address 否 string 单位地址
     * telephone 否 string 手机号码
     * bank_name 否 string 银行名称
     * bank_account 否 string 银行账号
     * invoice_detail_page 否 object 发票详情页（小程序页面）
     */
    public $type = NULL;

    public $title = NULL;

    public $tax_number = NULL;

    public $company_address = NULL;

    public $telephone = NULL;

    public $bank_name = NULL;

    public $bank_account = NULL;

    public $invoice_detail_page = NULL;

    public function __construct($type, $title)
    {
        $this->type = $type;
        $this->title = $title;
    }

    public function set_type($type)
    {
        $this->type = $type;
    }

    public function set_title($title)
    {
        $this->title = $title;
    }

    public function set_tax_number($tax_number)
    {
        $this->tax_number = $tax_number;
    }

    public function set_company_address($company_address)
    {
        $this->company_address = $company_address;
    }

    public function set_telephone($telephone)
    {
        $this->telephone = $telephone;
    }

    public function set_bank_name($bank_name)
    {
        $this->bank_name = $bank_name;
    }

    public function set_bank_account($bank_account)
    {
        $this->bank_account = $bank_account;
    }

    public function set_invoice_detail_page(InvoiceDetailPage $invoice_detail_page)
    {
        $this->invoice_detail_page = $invoice_detail_page;
    }

    public function getParams()
    {
        $params = array();
        if ($this->isNotNull($this->type)) {
            $params['type'] = $this->type;
        }
        if ($this->isNotNull($this->title)) {
            $params['title'] = $this->title;
        }
        if ($this->isNotNull($this->tax_number)) {
            $params['tax_number'] = $this->tax_number;
        }
        if ($this->isNotNull($this->company_address)) {
            $params['company_address'] = $this->company_address;
        }
        if ($this->isNotNull($this->telephone)) {
            $params['telephone'] = $this->telephone;
        }
        if ($this->isNotNull($this->bank_name)) {
            $params['bank_name'] = $this->bank_name;
        }
        if ($this->isNotNull($this->bank_account)) {
            $params['bank_account'] = $this->bank_account;
        }
        if ($this->isNotNull($this->invoice_detail_page)) {
            $params['invoice_detail_page'] = $this->invoice_detail_page->getParams();
        }
        
        return $params;
    }
}
