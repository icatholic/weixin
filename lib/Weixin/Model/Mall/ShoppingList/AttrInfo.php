<?php
namespace Weixin\Model\Mall\ShoppingList;

use Weixin\Model\Base;

/**
 * 商品SPU属性
 */
class AttrInfo extends Base
{

    /**
     * name 是 string 属性名称
     * value 是 string 属性内容
     */
    public $name = NULL;

    public $value = NULL;

    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function set_name($name)
    {
        $this->name = $name;
    }

    public function set_value($value)
    {
        $this->value = $value;
    }

    public function getParams()
    {
        $params = array();
        if ($this->isNotNull($this->name)) {
            $params['name'] = $this->name;
        }
        if ($this->isNotNull($this->value)) {
            $params['value'] = $this->value;
        }
        return $params;
    }
}
