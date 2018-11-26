<?php
namespace Weixin\Model\Mall\ImportOrder;

use Weixin\Model\Base;

/**
 * 商家信息
 */
class BrandInfo extends Base
{

    /**
     * phone 是 string 联系电话，必须提供真实有效的联系电话，缺少联系电话或联系电话不正确将影响商品曝光
     * contact_detail_page 是 object 联系商家页面
     */
    public $phone = NULL;

    public $contact_detail_page = NULL;

    public function __construct($phone, ContactDetailPage $contact_detail_page)
    {
        $this->phone = $phone;
        $this->contact_detail_page = $contact_detail_page;
    }

    public function set_phone($phone)
    {
        $this->phone = $phone;
    }

    public function set_contact_detail_page(ContactDetailPage $contact_detail_page)
    {
        $this->contact_detail_page = $contact_detail_page;
    }

    public function getParams()
    {
        $params = array();
        if ($this->isNotNull($this->phone)) {
            $params['phone'] = $this->phone;
        }
        if ($this->isNotNull($this->contact_detail_page)) {
            $params['contact_detail_page'] = $this->contact_detail_page->getParams();
        }
        return $params;
    }
}
