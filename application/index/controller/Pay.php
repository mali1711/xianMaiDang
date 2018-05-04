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
     * 支付
     * @return bool
     */
    public function postdoPay($res = 1)
    {
        if($res){
          return true;  
        }else{
            return false;
        }
    }
}
