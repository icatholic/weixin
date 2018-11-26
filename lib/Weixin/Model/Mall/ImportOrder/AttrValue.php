<?php
namespace Weixin\Model\Mall\ImportOrder;

use Weixin\Model\Base;

/**
 * 属性值
 */
class AttrValue extends Base
{

    /**
     * name 是 string 属性值
     */
    public $name = NULL;

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function set_name($name)
    {
        $this->name = $name;
    }

    public function getParams()
    {
        $params = array();
        if ($this->isNotNull($this->name)) {
            $params['name'] = $this->name;
        }
        return $params;
    }
}
