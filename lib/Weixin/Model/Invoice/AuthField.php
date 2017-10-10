<?php
namespace Weixin\Model\Invoice;

use Weixin\Model\Base;

/**
 * 授权页字段
 *
 * @author Administrator
 *        
 */
class AuthField extends Base
{

    /**
     * user_field Object 是 授权页个人发票字段
     *
     * @var UserField
     */
    public $user_field = NULL;

    /**
     * biz_field Object 是 授权页单位发票字段
     *
     * @var BizField
     */
    public $biz_field = NULL;

    public function __construct($user_field, $biz_field)
    {
        $this->user_field = $user_field;
        $this->biz_field = $biz_field;
    }

    public function getParams()
    {
        $params = array();
        
        if ($this->isNotNull($this->user_field)) {
            $params['user_field'] = $this->user_field->getParams();
        }
        if ($this->isNotNull($this->biz_field)) {
            $params['biz_field'] = $this->biz_field->getParams();
        }
        return $params;
    }
}
