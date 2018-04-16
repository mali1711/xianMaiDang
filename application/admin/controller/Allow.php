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
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
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
/*        if(empty($nodelist[$controller]) || !in_array($action,$nodelist[$controller])){
            echo '<script>alert("您没有权限，请联系管理员")</script>';
            die;
        }*/

    }

    /*
     * 角色列表
     * */
    public function getroleList()
    {

        $list = Db::table('role')->select();
        return $this->fetch('admin/Competence',['list'=>$list]);
    }

    /*
     * 添加角色
     * */
    public function getrole()
    {

    }

    public function postrole()
    {

    }


    /*
     * 删除角色
     * */
    public function getdelRole()
    {

    }

    /*
     * 修改角色权限
     * */
    public function getupdateRole()
    {

    }

    public function postupdateRole()
    {

    }

    /*
     * 权限列表
     * */
    public function getlist()
    {

    }

    

    /*
     * 测试第三方类
     * TODO OK
     * */
    public function gettextsms()
    {
        $res = sendsms('332123','18396861513');
    }


    /*
     * 测试邮箱发送
     * TODO KO
     * */
    public function gettextemail()
    {
//       $res = sendmail('626480208@qq.com','验证码','你好');

    }
}
