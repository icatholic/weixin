<?php
namespace Weixin\Model\GiftCard;

use Weixin\Model\Base;

/**
 * 主题分类排序结构体
 *
 * @author Administrator
 *        
 */
class Category extends Base
{

    /**
     * title 主题分类的名称 否
     */
    public $title = NULL;

    public function __construct()
    {}

    public function set_title($title)
    {
        $this->title = $title;
    }

    public function getParams()
    {
        $params = array();
        
        if ($this->isNotNull($this->title)) {
            $params['title'] = $this->title;
        }
        
        return $params;
    }
}
