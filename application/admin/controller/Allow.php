<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/1
 * Time: 20:55
 */
namespace app\admin\controller;
//导入Controller
use think\Controller;
use think\Db;
use think\Session;
class Allow extends Controller
{
    //初始化方法
    public function _initialize()
    {
        //检测session
        if(!Session::get('islogin')){

            $this->error('您还没有登录','/login/AdminIndex');
            return false;
        }

        $request=request();
        $controller=strtolower($request->controller());
        $action=$request->action();
        $nodelist=Session::get('nodeList');
        if(empty($nodelist[$controller]) || !in_array($action,$nodelist[$controller])){
            echo '<script>alert("您没有权限，请联系管理员")</script>';
            die;
        }

    }

}
/*
<?php
namespace app\admin\controller;
//导入Controller
use think\Controller;
use think\Db;
use think\Session;
class Allow extends Controller
{
    //初始化方法
    public function _initialize()
    {
        //检测session
        if(!Session::get('islogin')){
            $this->error("请先登录后台","/adminlogin/login");
        }
        $request=request();
        // (4)对比
        //获取当前用户访问的控制器和方法(名字)
        //控制器
        $controller=strtolower($request->controller());
        //方法
        $action=$request->action();

        // echo $controller.":".$action;
        //获取session信息
        $nodelist=Session::get('nodelist');

        //判断
        if(empty($nodelist[$controller]) || !in_array($action,$nodelist[$controller])){
            $this->error("抱歉您没有该权限,请联系超级管理员","/admin/index");
        }


    }

}
*/
