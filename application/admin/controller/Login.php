<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/29
 * Time: 17:09
 */


namespace app\admin\controller;

use app\admin\model\AdminModel;
use think\Controller;
use think\Db;
use \think\Request;
use think\Session;

/*
 * 产品控制器
 * */
class Login extends controller{
    
    /*
     * 登录界面
     * */
    public function getAdminIndex()
    {
        return $this->fetch('admin/login');
    }

    /*
     * 验证码的使用
     * */
    public function postAdminLogin()
    {
        $request = Request::instance();
        $data= $request->post();
        $data['password'] = md5($data['password']);
        $res = AdminModel::get($data);
        if($res){
            Session::set('islogin',$res);
            $nodeList = $this->getquan();
            Session::set('nodeList',$nodeList);
            //获取用户的权限信息，并且把用户的权限信息存到sesion里面，然后对比。
            $this->success('登录成功','/admin/index');
        }else{
            $this->error('用户名或者密码错误');
        }
    }


    /*
     * 获取用户权限信息
     * */
    public function getquan()
    {
        $where['uid'] = 1;
        $join = [
            ['role_node r','a.rid=r.rid'],
            ['node n','n.id=r.nid'],
        ];
        $nodeList['admin'][] = "getindex";
        $nodeList['admin'][] = "gethome";
        $res =  Db::table('admin_role')->field('name,mname,aname')->alias('a')->join($join)->where($where)->select();
        foreach ($res as $k=>$v){
           $nodeList[$v['mname']][] = $v['aname'];
        }
        return $nodeList;
    }
}