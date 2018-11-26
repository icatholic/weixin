<?php
namespace Weixin\Model\Mall\ImportOrder;

use Weixin\Model\Base;

/**
 * 包裹中的商品信息
 */
class ExpressPackageInfo extends Base
{

    /**
     * express_company_id 是 uint32 快递公司id
     * express_company_name 是 string 快递公司名
     * express_code 是 string 快递单号
     * ship_time 是 uint32 发货时间，unix时间戳
     * express_page 是 object 快递详情页（小程序页面）
     * express_goods_info_list 是 array 包裹商品信息
     */
    public $express_company_id = NULL;

    public $express_company_name = NULL;

    public $express_code = NULL;

    public $ship_time = NULL;

    public $express_page = NULL;

    public $express_goods_info_list = NULL;

    public function __construct($express_company_id, $express_company_name, $express_code, $ship_time, ExpressPage $express_page, array $express_goods_info_list)
    {
        $this->express_company_id = $express_company_id;
        $this->express_company_name = $express_company_name;
        $this->express_code = $express_code;
        $this->ship_time = $ship_time;
        $this->express_page = $express_page;
        $this->express_goods_info_list = $express_goods_info_list;
    }

    public function set_express_company_id($express_company_id)
    {
        $this->express_company_id = $express_company_id;
    }

    public function set_express_company_name($express_company_name)
    {
        $this->express_company_name = $express_company_name;
    }

    public function set_express_code($express_code)
    {
        $this->express_code = $express_code;
    }

    public function set_ship_time($ship_time)
    {
        $this->ship_time = $ship_time;
    }

    public function set_express_page(ExpressPage $express_page)
    {
        $this->express_page = $express_page;
    }

    public function set_express_goods_info_list(array $express_goods_info_list)
    {
        $this->express_goods_info_list = $express_goods_info_list;
    }

    public function getParams()
    {
        $params = array();
        if ($this->isNotNull($this->express_company_id)) {
            $params['express_company_id'] = $this->express_company_id;
        }
        if ($this->isNotNull($this->express_company_name)) {
            $params['express_company_name'] = $this->express_company_name;
        }
        if ($this->isNotNull($this->express_code)) {
            $params['express_code'] = $this->express_code;
        }
        if ($this->isNotNull($this->ship_time)) {
            $params['ship_time'] = $this->ship_time;
        }
        if ($this->isNotNull($this->express_page)) {
            $params['express_page'] = $this->express_page->getParams();
        }
        if ($this->isNotNull($this->express_goods_info_list)) {
            $express_goods_info_list = array();
            foreach ($this->express_goods_info_list as $express_goods_info) {
                $express_goods_info_list[] = $express_goods_info->getParams();
            }
            $params['express_goods_info_list'] = $express_goods_info_list;
        }
        return $params;
    }
}
