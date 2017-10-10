<?php
namespace Weixin\Model\GiftCard;

use Weixin\Model\Base;

/**
 * 商品结构体
 *
 * @author Administrator
 *        
 */
class Item extends Base
{

    /**
     * card_id 待上架的card_id 是
     */
    public $card_id = NULL;

    /**
     * title 商品名，不填写默认为卡名称 否
     */
    public $title = NULL;

    public function __construct($card_id)
    {
        $this->card_id = $card_id;
    }

    public function set_title($title)
    {
        $this->title = $title;
    }

    public function getParams()
    {
        $params = array();
        
        if ($this->isNotNull($this->card_id)) {
            $params['card_id'] = $this->card_id;
        }
        
        if ($this->isNotNull($this->title)) {
            $params['title'] = $this->title;
        }
        
        return $params;
    }
}
