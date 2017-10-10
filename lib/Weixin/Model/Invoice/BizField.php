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
        if ($this->isNotNull($this->custom_field)) {
            $params['custom_field'] = $this->custom_field->getParams();
        }
        return $params;
    }
}
