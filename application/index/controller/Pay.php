<?php

namespace app\index\controller;

use think\Controller;
use think\Request;

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
        dump($_POST);
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
     * 同步跳转
     */
    public function getreturn_url()
    {
        echo 'return_url';
    }
}
