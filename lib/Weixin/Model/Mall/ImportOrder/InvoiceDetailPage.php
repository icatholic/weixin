<?php
namespace Weixin\Model\Mall\ImportOrder;

use Weixin\Model\Base;

/**
 * 发票详情页（小程序页面）
 */
class InvoiceDetailPage extends Base
{

    /**
     * path 是 string 发票详情页跳转链接（小程序页面）
     */
    public $path = NULL;

    public function __construct($path)
    {
        $this->path = $path;
    }

    public function set_path($path)
    {
        $this->path = $path;
    }

    public function getParams()
    {
        $params = array();
        if ($this->isNotNull($this->path)) {
            $params['path'] = $this->path;
        }
        return $params;
    }
}
