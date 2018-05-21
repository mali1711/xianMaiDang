<?php

namespace app\courier\controller;

use app\index\model\Courier;
use think\Controller;
use think\Request;
use think\Session;

class Login extends Controller
{
    /**
     * @GET
     * @return link
     */
    public function getlogin()
    {
        return $this->fetch('index/login');
    }

    /**
     * @POST
     * @return link
     */
    public function postlogin()
    {
        $request = request();
        $where = $request->post();
        $where['password'] = md5($where['password']);
        $courier = new Courier();
        $data = $courier->where($where)->find();
        if($data==null){
            $this->error('账号或者密码错误');
        }else{
            Session::set('islogin',$data);
            $this->success('登录成功','/cindex/index');
        }
        
    }

    /**
     * 快递员注册
     * @GET
     * @return link
     */
    public function getregister()
    {

    }
    
    /**
     * 快递员登录
     * @post 
     * @return link
     */
    public function postregister()
    {

    }
}
