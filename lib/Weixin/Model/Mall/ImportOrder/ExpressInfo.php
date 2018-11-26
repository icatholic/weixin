<?php
namespace Weixin\Model\Mall\ImportOrder;

use Weixin\Model\Base;

/**
 * 快递信息
 */
class ExpressInfo extends Base
{

    /**
     * name 否 string 收件人姓名
     * phone 否 string 收件人联系电话
     * address 否 string 收件人地址
     * price 是 uint32 运费，单位：分
     * national_code 否 string 行政区划代码
     * country 否 string 国家
     * province 否 string 省份
     * city 否 string 城市
     * district 否 string 区
     * express_package_info_list 否 array 包裹中的商品信息
     */
    public $name = NULL;

    public $phone = NULL;

    public $address = NULL;

    public $price = NULL;

    public $national_code = NULL;

    public $country = NULL;

    public $province = NULL;

    public $city = NULL;

    public $district = NULL;

    public $express_package_info_list = NULL;

    public function __construct($price)
    {
        $this->price = $price;
    }

    public function set_name($name)
    {
        $this->name = $name;
    }

    public function set_phone($phone)
    {
        $this->phone = $phone;
    }

    public function set_address($address)
    {
        $this->address = $address;
    }

    public function set_price($price)
    {
        $this->price = $price;
    }

    public function set_national_code($national_code)
    {
        $this->national_code = $national_code;
    }

    public function set_country($country)
    {
        $this->country = $country;
    }

    public function set_province($province)
    {
        $this->province = $province;
    }

    public function set_district($district)
    {
        $this->district = $district;
    }

    public function set_express_package_info_list(array $express_package_info_list)
    {
        $this->express_package_info_list = $express_package_info_list;
    }

    public function set_city($city)
    {
        $this->city = $city;
    }

    public function getParams()
    {
        $params = array();
        if ($this->isNotNull($this->name)) {
            $params['name'] = $this->name;
        }
        if ($this->isNotNull($this->phone)) {
            $params['phone'] = $this->phone;
        }
        if ($this->isNotNull($this->address)) {
            $params['address'] = $this->address;
        }
        if ($this->isNotNull($this->price)) {
            $params['price'] = $this->price;
        }
        if ($this->isNotNull($this->national_code)) {
            $params['national_code'] = $this->national_code;
        }
        if ($this->isNotNull($this->country)) {
            $params['country'] = $this->country;
        }
        if ($this->isNotNull($this->province)) {
            $params['province'] = $this->province;
        }
        if ($this->isNotNull($this->city)) {
            $params['city'] = $this->city;
        }
        if ($this->isNotNull($this->district)) {
            $params['district'] = $this->district;
        }
        if ($this->isNotNull($this->express_package_info_list)) {
            $express_package_info_list = array();
            foreach ($this->express_package_info_list as $express_package_info) {
                $express_package_info_list[] = $express_package_info->getParams();
            }
            $params['express_package_info_list'] = $express_package_info_list;
        }
        return $params;
    }
}
