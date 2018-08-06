<?php
namespace Weixin\Model\Invoice;

use Weixin\Model\Base;

/**
 * 自定义字段
 *
 * @author Administrator
 *        
 */
class CustomField extends Base
{

    /**
     * key String 是 字段名
     */
    public $key = NULL;

    /**
     * is_require Int 否 0：否，1：是， 默认为0
     */
    public $is_require = 0;

    /**
     * notice String 否 提示文案
     */
    public $notice = NULL;

    public function __construct($key)
    {
        $this->key = $key;
    }

    public function getParams()
    {
        $params = array();
        
        if ($this->isNotNull($this->key)) {
            $params['key'] = $this->key;
        }
        
        if ($this->isNotNull($this->is_require)) {
            $params['is_require'] = $this->is_require;
        }
        
        if ($this->isNotNull($this->notice)) {
            $params['notice'] = $this->notice;
        }
        
        return $params;
    }

    public function set_is_require($is_require)
    {
        $this->is_require = $is_require;
    }

    public function set_notice($notice)
    {
        $this->notice = $notice;
    }
}
