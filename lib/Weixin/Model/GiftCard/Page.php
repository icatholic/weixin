<?php
namespace Weixin\Model\GiftCard;

use Weixin\Model\Base;

/**
 * 货架信息结构体
 *
 * @author Administrator
 *        
 */
class Page extends Base
{

    /**
     * 更新时候所需
     * page_id 要修改的货架id
     */
    public $page_id = NULL;

    /**
     * page_title 礼品卡货架名称 是
     */
    public $page_title = NULL;

    /**
     * support_multi 是否支持一次购买多张及发送至群，填 true 或者 false，若填 true 则支持，默认为 false 否
     */
    public $support_multi = NULL;

    /**
     * banner_pic_url 礼品卡货架主题页顶部banner图片，须先将图片上传至CDN，建议尺寸为750px*630px 是
     */
    public $banner_pic_url = NULL;

    /**
     * theme_list 主题结构体，是一个JSON结构 是
     */
    public $theme_list = NULL;

    /**
     * category_list 主题分类列表 否
     */
    public $category_list = NULL;

    /**
     * address 商家地址 是
     */
    public $address = NULL;

    /**
     * service_phone 商家服务电话 是
     */
    public $service_phone = NULL;

    /**
     * biz_description 商家使用说明，用于描述退款、发票等流程 是
     */
    public $biz_description = NULL;

    /**
     * need_receipt 该货架的订单是否支持开发票，填true或者false，若填true则需要调试文档2.2的流程，默认为false 否
     */
    public $need_receipt = NULL;

    /**
     * cell_1 商家自定义链接，用于承载退款、发票等流程 是
     */
    public $cell_1 = NULL;

    /**
     * cell_2 商家自定义链接，用于承载退款、发票等流程 是
     */
    public $cell_2 = NULL;

    public function __construct($page_title, $banner_pic_url, array $theme_list, $address, $service_phone, $biz_description, Cell $cell_1, Cell $cell_2)
    {
        $this->page_title = $page_title;
        $this->banner_pic_url = $banner_pic_url;
        $this->theme_list = $theme_list;
        $this->address = $address;
        $this->service_phone = $service_phone;
        $this->biz_description = $biz_description;
        $this->cell_1 = $cell_1;
        $this->cell_2 = $cell_2;
    }

    public function set_category_list($category_list)
    {
        $this->category_list = $category_list;
    }

    public function set_need_receipt($need_receipt)
    {
        $this->need_receipt = $need_receipt;
    }

    public function set_support_multi($support_multi)
    {
        $this->support_multi = $support_multi;
    }

    public function getParams()
    {
        $params = array();
        
        // 更新时候所需
        if ($this->isNotNull($this->page_id)) {
            $params['page_id'] = $this->page_id;
        }
        
        if ($this->isNotNull($this->page_title)) {
            $params['page_title'] = $this->page_title;
        }
        if ($this->isNotNull($this->banner_pic_url)) {
            $params['banner_pic_url'] = $this->banner_pic_url;
        }
        
        if ($this->isNotNull($this->theme_list)) {
            $theme_list = array();
            foreach ($this->theme_list as $theme) {
                $theme_list[] = $theme->getParams();
            }
            $params['theme_list'] = $theme_list;
        }
        if ($this->isNotNull($this->category_list)) {
            $category_list = array();
            foreach ($this->category_list as $category) {
                $category_list[] = $category->getParams();
            }
            $params['category_list'] = $category_list;
        }
        if ($this->isNotNull($this->address)) {
            $params['address'] = $this->address;
        }
        if ($this->isNotNull($this->service_phone)) {
            $params['service_phone'] = $this->service_phone;
        }
        
        if ($this->isNotNull($this->biz_description)) {
            $params['biz_description'] = $this->biz_description;
        }
        if ($this->isNotNull($this->need_receipt)) {
            $params['need_receipt'] = $this->need_receipt;
        }
        if ($this->isNotNull($this->cell_1)) {
            $params['cell_1'] = $this->cell_1->getParams();
        }
        if ($this->isNotNull($this->cell_2)) {
            $params['cell_2'] = $this->cell_2->getParams();
        }
        if ($this->isNotNull($this->support_multi)) {
            $params['support_multi'] = $this->support_multi;
        }
        return $params;
    }
}
