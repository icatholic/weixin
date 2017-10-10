<?php
namespace Weixin\Model\GiftCard;

use Weixin\Model\Base;

/**
 * 自定义会员信息类目结构体
 *
 * @author Administrator
 *        
 */
class CustomField extends Base
{

    /**
     * name 自定义信息类目名称 是
     */
    public $name = NULL;

    /**
     * url 自定义信息类目跳转链接 是
     */
    public $url = NULL;

    public function __construct($name, $url)
    {
        $this->name = $name;
        $this->url = $url;
    }

    public function getParams()
    {
        $params = array();
        
        if ($this->isNotNull($this->name)) {
            $params['name'] = $this->name;
        }
        if ($this->isNotNull($this->url)) {
            $params['url'] = $this->url;
        }
        return $params;
    }
}
