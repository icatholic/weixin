<?php
namespace Weixin\Model\Invoice;

use Weixin\Model\Base;

/**
 * 商户联系方式字段
 *
 * @author Administrator
 *        
 */
class Contact extends Base
{

    /**
     * time_out int 是 开票超时时间
     *
     * @var number
     */
    public $time_out = NULL;

    /**
     * phone string 是 联系电话
     *
     * @var string
     */
    public $phone = NULL;

    public function __construct($time_out, $phone)
    {
        $this->time_out = $time_out;
        $this->phone = $phone;
    }

    public function getParams()
    {
        $params = array();
        
        if ($this->isNotNull($this->time_out)) {
            $params['time_out'] = $this->time_out;
        }
        if ($this->isNotNull($this->phone)) {
            $params['phone'] = $this->phone;
        }
        return $params;
    }
}
