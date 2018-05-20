<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Pay extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
    }


    /**
     * 账户管理
     */
    public function getcover_management()
    {
        return $this->fetch('admin/cover_management');
    }

    /*
     * 支付方式
     * */
    public function getpayment_method()
    {
        return $this->fetch('admin/payment_method');
    }

    /**
     * 支付配置
     */
    public function getpayment_Configure()
    {
        return $this->fetch('admin/payment_Configure');
    }

    /**
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //
    }

    /**
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /**
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /**
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
}
