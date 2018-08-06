<?php
namespace Weixin\Model\Invoice;

use Weixin\Model\Base;

/**
 * 授权页个人发票字段
 *
 * @author Administrator
 *        
 */
class Invoicedetail extends Base
{

    /**
     * fphxz String 是 发票行性质 0 正常 1折扣 2 被折扣
     */
    public $fphxz = NULL;

    /**
     * spbm String 是 19位税收分类编码说明见注
     */
    public $spbm = NULL;

    /**
     * xmmc String 是 项目名称
     */
    public $xmmc = NULL;

    /**
     * dw String 否 计量单位
     */
    public $dw = NULL;

    /**
     * ggxh String 否 规格型号
     */
    public $ggxh = NULL;

    /**
     * xmsl String 是 项目数量
     */
    public $xmsl = NULL;

    /**
     * xmdj String 是 项目单价
     */
    public $xmdj = NULL;

    /**
     * xmje String 是 项目金额 不含税，单位元 两位小数
     */
    public $xmje = NULL;

    /**
     * sl String 是 税率 精确到两位小数 如0.01
     */
    public $sl = NULL;

    /**
     * se String 是 税额 单位元 两位小数
     */
    public $se = NULL;

    public function __construct($fphxz, $spbm, $xmmc, $xmsl, $xmdj, $xmje, $sl, $se)
    {
        $this->fphxz = $fphxz;
        $this->spbm = $spbm;
        $this->xmmc = $xmmc;
        $this->xmsl = $xmsl;
        $this->xmdj = $xmdj;
        $this->xmje = $xmje;
        $this->sl = $sl;
        $this->se = $se;
    }

    public function getParams()
    {
        $params = array();
        
        if ($this->isNotNull($this->fphxz)) {
            $params['fphxz'] = $this->fphxz;
        }
        if ($this->isNotNull($this->spbm)) {
            $params['spbm'] = $this->spbm;
        }
        if ($this->isNotNull($this->xmmc)) {
            $params['xmmc'] = $this->xmmc;
        }
        if ($this->isNotNull($this->dw)) {
            $params['dw'] = $this->dw;
        }
        if ($this->isNotNull($this->ggxh)) {
            $params['ggxh'] = $this->ggxh;
        }
        if ($this->isNotNull($this->xmsl)) {
            $params['xmsl'] = $this->xmsl;
        }
        if ($this->isNotNull($this->xmdj)) {
            $params['xmdj'] = $this->xmdj;
        }
        if ($this->isNotNull($this->xmje)) {
            $params['xmje'] = $this->xmje;
        }
        if ($this->isNotNull($this->sl)) {
            $params['sl'] = $this->sl;
        }
        if ($this->isNotNull($this->se)) {
            $params['se'] = $this->se;
        }
        return $params;
    }

    public function set_dw($dw)
    {
        $this->dw = $dw;
    }

    public function set_ggxh($ggxh)
    {
        $this->ggxh = $ggxh;
    }
}
