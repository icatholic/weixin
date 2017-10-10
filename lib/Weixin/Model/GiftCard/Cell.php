<?php
namespace Weixin\Model\GiftCard;

use Weixin\Model\Base;

/**
 * 商户自定义服务入口结构体
 *
 * @author Administrator
 *        
 */
class Cell extends Base
{

    /**
     * title 自定义入口名称 是
     */
    public $title = NULL;

    /**
     * url 自定义入口链接 是
     */
    public $url = NULL;

    public function __construct($title, $url)
    {
        $this->title = $title;
        $this->url = $url;
    }

    public function getParams()
    {
        $params = array();
        
        if ($this->isNotNull($this->title)) {
            $params['title'] = $this->title;
        }
        if ($this->isNotNull($this->url)) {
            $params['url'] = $this->url;
        }
        return $params;
    }
}
