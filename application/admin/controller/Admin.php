<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/26
 * Time: 10:20
 */
namespace app\admin\controller;

use app\admin\validate\AdminValidate;
use think\Controller;
use app\admin\model\AdminModel;
use \think\Request;

class Admin extends Allow
{

    //
    public function getIndex()
    {
        return $this->fetch("admin/index");
    }

    //首页详情显示
    public function getHome()
    {
        return $this->fetch("admin/home");
    }


    /*
     * 权限管理
     * */
    public function getAdmin_Competence()
    {
        return $this->fetch('admin/admin_Competence');
    }


    /*
     * 管理员列表
     * */
    public function getAdministrator()
    {
        $list  = AdminModel::select();
        return $this->fetch('admin/administrator',['list'=>$list]);
    }


    /*
     * 添加管理员
     * */
    public function postAdministrator()
    {
        $_POST['password'] = md5($_POST['password']);
        $_POST['addtime'] = time();
        $errorInfo  = $this->validate($_POST,'AdminValidate');
        if(true !== $errorInfo){
            $this->error($errorInfo);
        }
        $admin = new AdminModel($_POST);
        // 过滤post数组中的非数据表字段数据
        $res = $admin->allowField(true)->save();
        $this->getAdministrator();
    }
    
    /*
     * 启用管理员
     * */
    public function getAdminStart()
    {
        $request = Request::instance();
        $id = $request->get('admin_id');
        $Admin = AdminModel::get($id);
        $Admin->status = 1;
        if($Admin->save()){
            return 1;
        }else{
            return 0;
        }
    }

    /*
     * 禁用管理员
     * */
    public function getAdminStop()
    {
        $request = Request::instance();
        $id = $request->get('admin_id');
        $Admin = AdminModel::get($id);
        $Admin->status = 0;
        if($Admin->save()){
            return 1;
        }else{
            return 0;
        }
    }

    /*
     * 删除管理员
     * */
    public function getAdminDel()
    {
        $request = Request::instance();
        $id = $request->get('admin_id');
        $Admin = AdminModel::get($id);
        if($Admin->delete()){
            return 1;
        }else{
            return 0;
        };
    }

    /*
     * 管理员列表
     * */
    public function getAdminList()
    {
        $list  = json_encode(AdminModel::select());
        return json_decode($list);
    }
    /*
     * 个人信息
     * */
    public function getAdmin_info()
    {
        return $this->fetch('admin/admin_info');
    }
}

