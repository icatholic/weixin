<?php
namespace Weixin\Model\Invoice;

use Weixin\Model\Base;

/**
 * 授权页字段
 *
 * @author Administrator
 *        
 */
class PaymchInfo extends Base
{

    /**
     * mchid String 是 微信支付商户号
     */
    public $mchid = NULL;

    /**
     * s_pappid String 是 开票平台id，需要找开票平台提供
     */
    public $s_pappid = NULL;

    public function __construct($mchid, $s_pappid)
    {
        $this->mchid = $mchid;
        $this->s_pappid = $s_pappid;
    }

    public function getParams()
    {
        $params = array();
        
        if ($this->isNotNull($this->mchid)) {
            $params['mchid'] = $this->mchid;
        }
        if ($this->isNotNull($this->s_pappid)) {
            $params['s_pappid'] = $this->s_pappid;
        }
        return $params;
    }
}
