<?php
namespace Weixin\Wx\Manager;

use Weixin\Client;
use Weixin\Wx\Manager\Mall\ImportOrder;
use Weixin\Wx\Manager\Mall\ShoppingList;

/**
 * 购物单是微信提供的小程序购物车和订单管理工具。小程序接入购物单后，购物车和订单商品将同步至购物单的“想买清单”和“已购订单”，同时也可以被微信用户搜索到。
 *
 * 开发者可通过以下接口接入购物单：
 *
 * a. 导入“想买清单”：将用户在开发者小程序内的购物车信息导入“想买清单”；
 *
 * b. 导入“已购订单”：将用户在开发者小程序内完成的订单信息导入“已购订单”；
 *
 * c. 更新订单信息：更新“已购订单”中的订单信息；
 *
 * d. 更新商品信息：更新“想买清单”与“已购订单”中的商品信息；
 *
 * e. 删除“想买清单”：将用户在开发者小程序中删除的购物车商品从“想买清单”中移除；
 *
 * @author guoyongrong <handsomegyr@gmail.com>
 * @author young <youngyang@icatholic.net.cn>
 */
class Mall
{

    private $_client;

    public function __construct(Client $client)
    {
        $this->_client = $client;
    }

    /**
     * 已购订单
     *
     * @return \Weixin\Wx\Manager\Mall\ImportOrder
     */
    public function getImportOrder()
    {
        return new ImportOrder($this->_client);
    }

    /**
     * 想买清单
     *
     * @return \Weixin\Wx\Manager\Mall\ShoppingList
     */
    public function getShoppingList()
    {
        return new ShoppingList($this->_client);
    }
}
