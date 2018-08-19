<?php

namespace app\index\controller;

use think\Controller;
use think\Request;
use think\Session;

class Users extends Controller{
    
    
    public function _initialize()
    {
        //购物车id
        if (!Session::has('islogin')) {
            return $this->error('请先登录', '/indexlogin/loginIphone');
        }
    }
  
    /**
     * 个人中心
     */
    public function getusersInfo()
    {
       echo '个人信息正在完善中';
    }
}
