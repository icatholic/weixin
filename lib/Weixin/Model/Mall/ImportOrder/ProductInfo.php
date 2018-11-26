<?php
namespace Weixin\Model\Mall\ImportOrder;

use Weixin\Model\Base;

/**
 * 商品相关信息
 */
class ProductInfo extends Base
{

    /**
     * item_list 是 array 包含订单中所有商品的信息
     */
    public $item_list = NULL;

    public function __construct(array $item_list)
    {
        $this->item_list = $item_list;
    }

    public function set_item_list(array $item_list)
    {
        $this->item_list = $item_list;
    }

    public function getParams()
    {
        $params = array();
        if ($this->isNotNull($this->item_list)) {
            $item_list = array();
            foreach ($this->item_list as $item) {
                $item_list[] = $item->getParams();
            }
            $params['item_list'] = $item_list;
        }
        return $params;
    }
}
