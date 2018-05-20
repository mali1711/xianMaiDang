<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

/**
 * Class User
 * @package app\admin\controller
 * 查看用户列表
 */
class User extends Controller
{
    /**
     * 显示用户列表
     * @return \think\Response
     */
    public function getindex()
    {
        //
    }
    
    /**
     * 查看用户评价列表
     * @return 
     */
    public function getshow()
    {
        
    }

    /**
     * 会员列表
     */
    public function getuser_list()
    {
        return $this->fetch('admin/user_list');
    }

    /**
     * 等级管理
     */
    public function getmember_Grading()
    {
        return $this->fetch('admin/member_Grading');
    }

    /**
     * 会员记录管理
     */
    public function getintegration()
    {
        return $this->fetch('admin/integration');
    }
}
