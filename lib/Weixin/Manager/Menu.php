<?php
/**
 * 自定义菜单接口
 * 自定义菜单能够帮助公众号丰富界面，
 * 让用户更好更快地理解公众号的功能。
 * @author guoyongrong <handsomegyr@gmail.com>
 * @author young <youngyang@icatholic.net.cn>
 */
namespace Weixin\Manager;

use Weixin\Client;

class Menu
{

    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    public function create($menus)
    {
        $rst = $this->_request->post('menu/create', $menus);
        return $this->_client->rst($rst);
    }

    public function get()
    {
        $rst = $this->_request->post('menu/get');
        return $this->_client->rst($rst);
    }

    public function delete($menus)
    {
        $rst = $this->_request->post('menu/delete', $menus);
        return $this->_client->rst($rst);
    }

    private function validateSubbutton($menus)
    {
        $ret = 0;
        foreach ($menus as $menu) {
            if (key_exists("sub_button", $menu)) {
                $sub_button_num = count($menu['sub_button']);
                if ($sub_button_num > 5 || $sub_button_num < 1) {
                    $ret = 40023;
                    break;
                }
                $ret = $this->validateSubbutton($menu['sub_button']);
                if ($ret)
                    break;
            }
        }
        return $ret;
    }

    private function validateKey($menu)
    {
        // 类型为click必须
        if (strtolower($menu['type']) == 'click') {
            if (strlen(trim($menu['key'])) < 1)
                return 40019;
        }
        // 按钮KEY值，用于消息接口(event类型)推送，不超过128字节
        if (strlen(trim($menu['key'])) > 128)
            return 40019;
        return 0;
    }

    private function validateName($menu)
    {
        // 按钮描述，既按钮名字，不超过16个字节，子菜单不超过40个字节
        if ($menu['fatherNode'])         // 子菜单
        {
            if (strlen($menu['name']) > 40)
                return 40018;
        } else         // 按钮
        {
            if (strlen($menu['name']) > 16)
                return 40018;
        }
        return 0;
    }

    public function validateMenu($menu)
    {
        $errcode = $this->validateName($menu);
        if ($errcode) {
            return $errcode;
        }
        $errcode = $this->validateKey($menu);
        if ($errcode) {
            return $errcode;
        }
        return 0;
    }

    public function validateAllMenus($menus)
    {
        // 按钮数组，按钮个数应为1~3个
        $button_num = count($menus);
        if ($button_num > 3 || $button_num < 1) {
            return 40017;
        }
        
        // 子按钮数组，按钮个数应为1~5个
        if ($this->validateSubbutton($menus)) {
            return 40023;
        }
    }
}
