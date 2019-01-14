<?php
namespace Weixin\Model;

/**
 * 刷卡功能结构体信息
 */
class SwipeCard extends Base
{

    /**
     * is_swipe_card
     * 否
     * bool
     * 是否设置该会员卡支持拉出微信支付刷卡界面
     */
    public $is_swipe_card = NULL;

    public function __construct()
    {}

    public function set_is_swipe_card($is_swipe_card)
    {
        $this->is_swipe_card = $is_swipe_card;
    }

    public function getParams()
    {
        $params = array();
        
        if ($this->isNotNull($this->is_swipe_card)) {
            $params['is_swipe_card'] = $this->is_swipe_card;
        }
        
        return $params;
    }
}
