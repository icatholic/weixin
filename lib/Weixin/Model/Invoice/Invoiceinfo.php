<?php
namespace Weixin\Model\Invoice;

use Weixin\Model\Base;

/**
 * 电子发票字段
 *
 * @author Administrator
 *        
 */
class Invoiceinfo extends Base
{

    /**
     * 参数 类型 是否必填 描述
     */
    /**
     * wxopenid String 是 用户的openid 用户知道是谁在开票
     */
    public $wxopenid = NULL;

    /**
     * ddh String 是 订单号，企业自己内部的订单号码。注1
     */
    public $ddh = NULL;

    /**
     * fpqqlsh String 是 发票请求流水号，唯一识别开票请求的流水号。注2
     */
    public $fpqqlsh = NULL;

    /**
     * nsrsbh String 是 纳税人识别码
     */
    public $nsrsbh = NULL;

    /**
     * nsrmc String 是 纳税人名称
     */
    public $nsrmc = NULL;

    /**
     * nsrdz String 是 纳税人地址
     */
    public $nsrdz = NULL;

    /**
     * nsrdh String 是 纳税人电话
     */
    public $nsrdh = NULL;

    /**
     * nsrbank String 是 纳税人开户行
     */
    public $nsrbank = NULL;

    /**
     * nsrbankid String 是 纳税人银行账号
     */
    public $nsrbankid = NULL;

    /**
     * ghfmc Sring 是 购货方名称
     */
    public $ghfmc = NULL;

    /**
     * ghfnsrsbh String 否 购货方识别号
     */
    public $ghfnsrsbh = NULL;

    /**
     * ghfdz String 否 购货方地址
     */
    public $ghfdz = NULL;

    /**
     * ghfdh String 否 购货方电话
     */
    public $ghfdh = NULL;

    /**
     * ghfbank String 否 购货方开户行
     */
    public $ghfbank = NULL;

    /**
     * ghfbankid String 否 购货方银行帐号
     */
    public $ghfbankid = NULL;

    /**
     * kpr String 是 开票人
     */
    public $kpr = NULL;

    /**
     * skr String 否 收款人
     */
    public $skr = NULL;

    /**
     * fhr String 否 复核人
     */
    public $fhr = NULL;

    /**
     * jshj String 是 价税合计
     */
    public $jshj = NULL;

    /**
     * hjse String 是 合计金额
     */
    public $hjse = NULL;

    /**
     * bz String 否 备注
     */
    public $bz = NULL;

    /**
     * hylx String 否 行业类型 0 商业 1其它
     */
    public $hylx = NULL;

    /**
     * invoicedetail_list List 是 发票行项目数据
     */
    public $invoicedetail_list = NULL;

    public function __construct($wxopenid, $ddh, $fpqqlsh, $nsrsbh, $nsrmc, $nsrdz, $nsrdh, $nsrbank, $nsrbankid, $ghfmc, $kpr, $jshj, $hjse, $invoicedetail_list)
    {
        $this->wxopenid = $wxopenid;
        $this->ddh = $ddh;
        $this->fpqqlsh = $fpqqlsh;
        $this->nsrsbh = $nsrsbh;
        $this->nsrmc = $nsrmc;
        $this->nsrdz = $nsrdz;
        $this->nsrdh = $nsrdh;
        $this->nsrbank = $nsrbank;
        $this->nsrbankid = $nsrbankid;
        $this->ghfmc = $ghfmc;
        $this->kpr = $kpr;
        $this->jshj = $jshj;
        $this->hjse = $hjse;
        $this->invoicedetail_list = $invoicedetail_list;
    }

    public function getParams()
    {
        $params = array();
        
        if ($this->isNotNull($this->wxopenid)) {
            $params['wxopenid'] = $this->wxopenid;
        }
        if ($this->isNotNull($this->ddh)) {
            $params['ddh'] = $this->ddh;
        }
        if ($this->isNotNull($this->fpqqlsh)) {
            $params['fpqqlsh'] = $this->fpqqlsh;
        }
        if ($this->isNotNull($this->nsrsbh)) {
            $params['nsrsbh'] = $this->nsrsbh;
        }
        if ($this->isNotNull($this->nsrmc)) {
            $params['nsrmc'] = $this->nsrmc;
        }
        if ($this->isNotNull($this->nsrdz)) {
            $params['nsrdz'] = $this->nsrdz;
        }
        if ($this->isNotNull($this->nsrdh)) {
            $params['nsrdh'] = $this->nsrdh;
        }
        if ($this->isNotNull($this->nsrbank)) {
            $params['nsrbank'] = $this->nsrbank;
        }
        if ($this->isNotNull($this->nsrbankid)) {
            $params['nsrbankid'] = $this->nsrbankid;
        }
        if ($this->isNotNull($this->ghfmc)) {
            $params['ghfmc'] = $this->ghfmc;
        }
        
        if ($this->isNotNull($this->ghfdz)) {
            $params['ghfdz'] = $this->ghfdz;
        }
        
        if ($this->isNotNull($this->ghfdh)) {
            $params['ghfdh'] = $this->ghfdh;
        }
        
        if ($this->isNotNull($this->ghfbank)) {
            $params['ghfbank'] = $this->ghfbank;
        }
        
        if ($this->isNotNull($this->ghfbankid)) {
            $params['ghfbankid'] = $this->ghfbankid;
        }
        
        if ($this->isNotNull($this->kpr)) {
            $params['kpr'] = $this->kpr;
        }
        
        if ($this->isNotNull($this->skr)) {
            $params['skr'] = $this->skr;
        }
        
        if ($this->isNotNull($this->fhr)) {
            $params['fhr'] = $this->fhr;
        }
        
        if ($this->isNotNull($this->jshj)) {
            $params['jshj'] = $this->jshj;
        }
        
        if ($this->isNotNull($this->hjje)) {
            $params['hjje'] = $this->hjje;
        }
        
        if ($this->isNotNull($this->hjse)) {
            $params['hjse'] = $this->hjse;
        }
        
        if ($this->isNotNull($this->bz)) {
            $params['bz'] = $this->bz;
        }
        
        if ($this->isNotNull($this->hylx)) {
            $params['hylx'] = $this->hylx;
        }
        
        if ($this->isNotNull($this->invoicedetail_list)) {
            $params['invoicedetail_list'] = $this->invoicedetail_list;
        }
        
        return $params;
    }

    public function set_ghfnsrsbh($ghfnsrsbh)
    {
        $this->ghfnsrsbh = $ghfnsrsbh;
    }

    public function set_ghfdz($ghfdz)
    {
        $this->ghfdz = $ghfdz;
    }

    public function set_ghfdh($ghfdh)
    {
        $this->ghfdh = $ghfdh;
    }

    public function set_ghfbank($ghfbank)
    {
        $this->ghfbank = $ghfbank;
    }

    public function set_ghfbankid($ghfbankid)
    {
        $this->ghfbankid = $ghfbankid;
    }

    public function set_skr($skr)
    {
        $this->skr = $skr;
    }

    public function set_fhr($fhr)
    {
        $this->fhr = $fhr;
    }

    public function set_bz($bz)
    {
        $this->bz = $bz;
    }

    public function set_hylx($hylx)
    {
        $this->hylx = $hylx;
    }
}
