<?php
namespace Weixin\Model\Invoice;

use Weixin\Model\Base;

/**
 * 授权页个人发票字段
 *
 * @author Administrator
 *        
 */
class UserField extends Base
{

    /**
     * show_title Int 否 是否填写抬头，0为否，1为是
     */
    public $show_title = 1;

    /**
     * show_phone Int 否 是否填写电话号码，0为否，1为是
     */
    public $show_phone = 1;

    /**
     * show_email Int 否 是否填写邮箱，0为否，1为是
     */
    public $show_email = 1;

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
        if ($this->isNotNull($this->show_phone)) {
            $params['show_phone'] = $this->show_phone;
        }
        if ($this->isNotNull($this->show_email)) {
            $params['show_email'] = $this->show_email;
        }
        if ($this->isNotNull($this->custom_field)) {
            $params['custom_field'] = $this->custom_field->getParams();
        }
        return $params;
    }
}
