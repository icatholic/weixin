<?php
namespace Weixin\Model\Mall\ShoppingList;

use Weixin\Model\Base;

/**
 * 商品信息
 */
class SkuProduct extends Base
{

    /**
     * item_code 是 string 商品ID，需要保证唯一性
     * title 是 string 商品名称
     * desc 否 string 商品描述
     * category_list 是 string array 商品类目列表，用于搜索排序
     * image_list 是 string array 商品图片链接列表
     * src_wxapp_path 是 string 商品来源小程序路径
     * attr_list 否 object array 商品SPU属性
     * sku_info 是 object 商品SKU信息，微信后台会合并多次导入的SKU
     * version 否 int 数据版本号，需按照更新递增，用在并发更新场景
     */
    public $item_code = NULL;

    public $title = NULL;

    public $desc = NULL;

    public $category_list = NULL;

    public $image_list = NULL;

    public $src_wxapp_path = NULL;

    public $attr_list = NULL;

    public $sku_info = NULL;

    public $version = NULL;

    public function __construct($item_code, $title, array $category_list, array $image_list, $src_wxapp_path, SkuInfo $sku_info)
    {
        $this->item_code = $item_code;
        $this->title = $title;
        $this->category_list = $category_list;
        $this->image_list = $image_list;
        $this->src_wxapp_path = $src_wxapp_path;
        $this->sku_info = $sku_info;
    }

    public function set_item_code($item_code)
    {
        $this->item_code = $item_code;
    }

    public function set_title($title)
    {
        $this->title = $title;
    }

    public function set_desc($desc)
    {
        $this->desc = $desc;
    }

    public function set_category_list($category_list)
    {
        $this->category_list = $category_list;
    }

    public function set_image_list($image_list)
    {
        $this->image_list = $image_list;
    }

    public function set_src_wxapp_path($src_wxapp_path)
    {
        $this->src_wxapp_path = $src_wxapp_path;
    }

    public function set_attr_list(array $attr_list)
    {
        $this->attr_list = $attr_list;
    }

    public function set_sku_info(SkuInfo $sku_info)
    {
        $this->sku_info = $sku_info;
    }

    public function set_version($version)
    {
        $this->version = $version;
    }

    public function getParams()
    {
        $params = array();
        if ($this->isNotNull($this->item_code)) {
            $params['item_code'] = $this->item_code;
        }
        if ($this->isNotNull($this->title)) {
            $params['title'] = $this->title;
        }
        if ($this->isNotNull($this->desc)) {
            $params['desc'] = $this->desc;
        }
        if ($this->isNotNull($this->category_list)) {
            $params['category_list'] = $this->category_list;
        }
        if ($this->isNotNull($this->image_list)) {
            $params['image_list'] = $this->image_list;
        }
        if ($this->isNotNull($this->src_wxapp_path)) {
            $params['src_wxapp_path'] = $this->src_wxapp_path;
        }
        if ($this->isNotNull($this->attr_list)) {
            $attr_list = array();
            foreach ($this->attr_list as $sku_attr) {
                $attr_list[] = $sku_attr->getParams();
            }
            $params['attr_list'] = $attr_list;
        }
        if ($this->isNotNull($this->sku_info)) {
            $params['sku_info'] = $this->sku_info->getParams();
        }
        if ($this->isNotNull($this->version)) {
            $params['version'] = $this->version;
        }
        
        return $params;
    }
}
