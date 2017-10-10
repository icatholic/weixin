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
     * key String 是 自定义字段名称，最长5个字
     */
    public $key = NULL;

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
        return $params;
    }
}
