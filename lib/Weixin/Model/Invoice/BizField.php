<?php
namespace Weixin\Model\Invoice;

use Weixin\Model\Base;

/**
 * 授权页单位发票字段
 *
 * @author Administrator
 *        
 */
class BizField extends Base
{

    /**
     * show_title Int 否 是否填写抬头，0为否，1为是
     */
    public $show_title = 1;

    /**
     * show_tax_no Int 否 是否填写税号，0为否，1为是
     */
    public $show_tax_no = 1;

    /**
     * show_addr Int 否 是否填写单位地址，0为否，1为是
     */
    public $show_addr = 1;

    /**
     * show_phone Int 否 是否填写电话号码，0为否，1为是
     */
    public $show_phone = 1;

    /**
     * show_bank_type Int 否 是否填写开户银行，0为否，1为是
     */
    public $show_bank_type = 1;

    /**
     * show_bank_no Int 否 是否填写银行帐号，0为否，1为是
     */
    public $show_bank_no = 1;

    /**
     * require_tax_no Int 否 税号是否必填，0为否，1为是
     */
    public $require_tax_no = 1;

    /**
     * require_addr Int 否 单位地址是否必填，0为否，1为是
     */
    public $require_addr = 1;

    /**
     * require_phone Int 否 电话号码是否必填，0为否，1为是
     */
    public $require_phone = 1;

    /**
     * require_bank_type Int 否 开户类型是否必填，0为否，1为是
     */
    public $require_bank_type = 1;

    /**
     * require_bank_no Int 否 税号是否必填，0为否，1为是
     */
    public $require_bank_no = 1;

    /**
     * custom_field Object 否 自定义字段
     *
     * @var CustomField
     */
    public $custom_field = NULL;

    public function __construct()
    {}

    public function getParams()
    {
        $params = array();
        
        if ($this->isNotNull($this->show_title)) {
            $params['show_title'] = $this->show_title;
        }
        if ($this->isNotNull($this->show_tax_no)) {
            $params['show_tax_no'] = $this->show_tax_no;
        }
        if ($this->isNotNull($this->show_addr)) {
            $params['show_addr'] = $this->show_addr;
        }
        if ($this->isNotNull($this->show_phone)) {
            $params['show_phone'] = $this->show_phone;
        }
        if ($this->isNotNull($this->show_bank_type)) {
            $params['show_bank_type'] = $this->show_bank_type;
        }
        if ($this->isNotNull($this->show_bank_no)) {
            $params['show_bank_no'] = $this->show_bank_no;
        }
        
        if ($this->isNotNull($this->require_tax_no)) {
            $params['require_tax_no'] = $this->require_tax_no;
        }
        if ($this->isNotNull($this->require_addr)) {
            $params['require_addr'] = $this->require_addr;
        }
        if ($this->isNotNull($this->require_phone)) {
            $params['require_phone'] = $this->require_phone;
        }
        if ($this->isNotNull($this->require_bank_type)) {
            $params['require_bank_type'] = $this->require_bank_type;
        }
        if ($this->isNotNull($this->require_bank_no)) {
            $params['require_bank_no'] = $this->require_bank_no;
        }
        if ($this->isNotNull($this->custom_field)) {
            $params['custom_field'] = $this->custom_field->getParams();
        }
        return $params;
    }

    public function set_show_title($show_title)
    {
        $this->show_title = $show_title;
    }

    public function set_show_tax_no($show_tax_no)
    {
        $this->show_tax_no = $show_tax_no;
    }

    public function set_show_addr($show_addr)
    {
        $this->show_addr = $show_addr;
    }

    public function set_show_phone($show_phone)
    {
        $this->show_phone = $show_phone;
    }

    public function set_show_bank_type($show_bank_type)
    {
        $this->show_bank_type = $show_bank_type;
    }

    public function set_show_bank_no($show_bank_no)
    {
        $this->show_bank_no = $show_bank_no;
    }

    public function set_require_tax_no($require_tax_no)
    {
        $this->require_tax_no = $require_tax_no;
    }

    public function set_require_addr($require_addr)
    {
        $this->require_addr = $require_addr;
    }

    public function set_require_phone($require_phone)
    {
        $this->require_phone = $require_phone;
    }

    public function set_require_bank_type($require_bank_type)
    {
        $this->require_bank_type = $require_bank_type;
    }

    public function set_require_bank_no($require_bank_no)
    {
        $this->require_bank_no = $require_bank_no;
    }

    public function set_custom_field($custom_field)
    {
        $this->custom_field = $custom_field;
    }
}
