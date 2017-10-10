<?php
namespace Weixin\Model\GiftCard;

use Weixin\Model\Base;

/**
 * 卡面结构体
 *
 * @author Administrator
 *        
 */
class PicItem extends Base
{

    /**
     * background_pic_url 卡面图片，须先将图片上传至CDN，大小控制在1000像素*600像素以下 是
     */
    public $background_pic_url = NULL;

    /**
     * outer_img_id 自定义的卡面的标识 否
     */
    public $outer_img_id = NULL;

    /**
     * default_gifting_msg 该卡面对应的默认祝福语，当用户没有编辑内容时会随卡默认填写为用户祝福内容 是
     */
    public $default_gifting_msg = NULL;

    public function __construct($background_pic_url, $default_gifting_msg)
    {
        $this->background_pic_url = $background_pic_url;
        $this->default_gifting_msg = $default_gifting_msg;
    }

    public function set_outer_img_id($outer_img_id)
    {
        $this->outer_img_id = $outer_img_id;
    }

    public function getParams()
    {
        $params = array();
        
        if ($this->isNotNull($this->background_pic_url)) {
            $params['background_pic_url'] = $this->background_pic_url;
        }
        if ($this->isNotNull($this->outer_img_id)) {
            $params['outer_img_id'] = $this->outer_img_id;
        }
        if ($this->isNotNull($this->default_gifting_msg)) {
            $params['default_gifting_msg'] = $this->default_gifting_msg;
        }
        return $params;
    }
}
