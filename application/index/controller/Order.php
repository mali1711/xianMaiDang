<?php

namespace app\index\controller;

use app\index\model\Address;
use think\Controller;
use think\Request;
use think\Session;


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
     * 跳转选择收货地址界面
     * */
    public function getselectaddress()
    {
        $id = Session::get('islogin')->users_id;
        $address = new Address();
        $list = $address->all(['users_id'=>$id]);
        return $this->fetch('index/ShouHuoDiZhi',['list'=>$list]);
    }

    /*
     * 给新的订单选择收货地址
     * */
    public function getselect()
    {
//        $id = request()->get('id')=19;
        $id=19;
        $wher['address_id'] = $id;
        $where['users_id'] = Session::get('islogin')->users_id;
        $address = new Address();
        $address->where($where)->update(['address_select'=>0]);
        $res = $address->where($wher)->update(['address_select'=>1]);
        return $res;
    }

    /*
     * 添加信息的收货地址
     * */
    public function getaddaddress()
    {
        return $this->fetch('index/ShouHuoDiZhi_ZX');
    }
    public function postaddaddress()
    {
        $data = request()->param();
        $data['users_id'] = Session::get('islogin')->users_id;
        $address = new Address();
        $res = $address->allowField(true)->data($data)->save();
        if($res){
            echo "<script>alert('收货地址添加成功')</script>";
            return $this->getselectaddress('index/ShouHuoDiZhi');
        }else{
            $this->error('收货地址新增失败');
        }
    }

    public function gettext()
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
        return $this->fetch('index/');
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

    public function getdemo()
    {
      return $this->fetch('index/demo');  
    }

}
