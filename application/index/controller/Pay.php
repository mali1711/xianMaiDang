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
}
