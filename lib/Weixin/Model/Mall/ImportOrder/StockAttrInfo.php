<?php
namespace Weixin\Model\Mall\ImportOrder;

use Weixin\Model\Base;

/**
 * 商品属性列表
 */
class StockAttrInfo extends Base
{

    /**
     * attr_name 是 object 属性名
     * attr_value 是 object 属性值
     */
    public $attr_name = NULL;

    public $attr_value = NULL;

    public function __construct(AttrName $attr_name, AttrValue $attr_value)
    {
        $this->attr_name = $attr_name;
        $this->attr_value = $attr_value;
    }

    public function set_attr_name(AttrName $attr_name)
    {
        $this->attr_name = $attr_name;
    }

    public function set_attr_value(AttrValue $attr_value)
    {
        $this->attr_value = $attr_value;
    }

    public function getParams()
    {
        $params = array();
        if ($this->isNotNull($this->attr_name)) {
            $params['attr_name'] = $this->attr_name->getParams();
        }
        if ($this->isNotNull($this->attr_value)) {
            $params['attr_value'] = $this->attr_value->getParams();
        }
        return $params;
    }
}
