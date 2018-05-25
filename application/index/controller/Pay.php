<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
use think\Session;

/**
 * Class Pay
 * @package app\index\controller
 * 支付
 */
class Pay extends Controller
{
    /**
     * 支付页面
     */
    public function gettoPay()
    {
        return $this->fetch('index/toPay');
    }


    public function posttoPay()
    {
        alipay();
    }

    /**
     * 异步通知地址
     */
    public function getnotify_url()
    {
        echo 'notify_url';
    }

    /**
     * 同步跳转(支付成功跳转的地址)
     */
    public function getreturn_url($res)
    {
        dump($res);
        dump(Session::get('ipay'));
        echo 'return_url'.'支付成功跳转的地址';
    }
}
