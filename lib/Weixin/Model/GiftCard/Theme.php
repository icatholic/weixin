<?php
namespace Weixin\Model\GiftCard;

use Weixin\Model\Base;

/**
 * 主题结构体结构体
 *
 * @author Administrator
 *        
 */
class Theme extends Base
{

    /**
     * theme_pic_url 主题的封面图片，须先将图片上传至CDN 大小控制在1000px*600px 是
     */
    public $theme_pic_url = NULL;

    /**
     * title 主题名称，如“圣诞”“感恩家人” 是
     */
    public $title = NULL;

    /**
     * title_color 主题title的颜色，直接传入色值 是
     */
    public $title_color = NULL;

    /**
     * item_list 礼品卡列表，标识该主题可选择的面额 是
     */
    public $item_list = NULL;

    /**
     * pic_item_list 封面列表 是
     */
    public $pic_item_list = NULL;

    /**
     * category_index 主题标号，对应category_list内的title字段，若填写了category_list则每个主题必填该序号 是
     */
    public $category_index = NULL;

    /**
     * show_sku_title_first 该主题购买页是否突出商品名显示 否
     */
    public $show_sku_title_first = NULL;

    /**
     * is_banner 是否将当前主题设置为banner主题（主推荐） 否
     */
    public $is_banner = NULL;

    public function __construct($theme_pic_url, $title, $title_color, array $item_list, array $pic_item_list, $category_index)
    {
        $this->theme_pic_url = $theme_pic_url;
        $this->title = $title;
        $this->title_color = $title_color;
        $this->item_list = $item_list;
        $this->pic_item_list = $pic_item_list;
        $this->category_index = $category_index;
    }

    public function set_show_sku_title_first($show_sku_title_first)
    {
        $this->show_sku_title_first = $show_sku_title_first;
    }

    public function set_is_banner($is_banner)
    {
        $this->is_banner = $is_banner;
    }

    public function getParams()
    {
        $params = array();
        
        if ($this->isNotNull($this->theme_pic_url)) {
            $params['theme_pic_url'] = $this->theme_pic_url;
        }
        if ($this->isNotNull($this->title)) {
            $params['title'] = $this->title;
        }
        if ($this->isNotNull($this->title_color)) {
            $params['title_color'] = $this->title_color;
        }
        if ($this->isNotNull($this->item_list)) {
            $item_list = array();
            foreach ($this->item_list as $item) {
                $item_list[] = $item->getParams();
            }
            $params['item_list'] = $item_list;
        }
        if ($this->isNotNull($this->pic_item_list)) {
            $pic_item_list = array();
            foreach ($this->pic_item_list as $pic_item) {
                $pic_item_list[] = $pic_item->getParams();
            }
            $params['pic_item_list'] = $pic_item_list;
        }
        if ($this->isNotNull($this->category_index)) {
            $params['category_index'] = $this->category_index;
        }
        if ($this->isNotNull($this->show_sku_title_first)) {
            $params['show_sku_title_first'] = $this->show_sku_title_first;
        }
        if ($this->isNotNull($this->is_banner)) {
            $params['is_banner'] = $this->is_banner;
        }
        return $params;
    }
}
