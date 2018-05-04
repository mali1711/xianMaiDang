<?php

namespace app\courier\controller;

use think\Controller;
use think\Request;
use think\Session;

class Allow extends Controller
{
    /**
     * 构造方法
     * 判断是否登录
     */
    public function _initialize()
    {
        if(!Session::has('islogin')){
            $this->error('您还没有登录','/clogin/login');
        }
    }

}
