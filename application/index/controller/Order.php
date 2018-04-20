<?php

namespace app\index\controller;

use think\Controller;
use think\Request;


class Order extends Controller{

    
    /*
     * 通过用户id和订单状态来查看订单列表
     * */
    public function MyorderList()
    {
           }
    
    
    /*
     * 删除订单
     * */
    public function getdel()
    {
        
    }
    
    
    /*
     * 修改订单状态
     * */
    public function getStatus()
    {
        
    }


    /*
     * 选择收货地址
     * */
    public function getselectaddress()
    {

    }

    /*
     * 通过订单id查看订单详情
     * */
    public function getDetail()
    {
        $id = request()->get('id');
    }

    /*
     * 查看收货地址
     * */
    public function getshowAddres()
    {

    }

    /*
     * 删除收货地址
     * */
    public function getaddress()
    {

    }

    /*
     * 修改收货地址
     * */
    public function postaddress()
    {

    }

}
