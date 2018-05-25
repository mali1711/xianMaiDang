<?php

namespace app\index\controller;

use app\index\model\Address;
use app\index\model\Orders;
use app\index\model\Orders_detail;
use think\Config;
use think\Controller;
use think\Loader;
use think\Request;
use think\Session;


class Order extends Controller
{


    static $orders_id = '';

    //获取登录者的用户id
    protected $users_id;

    public function _initialize()
    {
        $this->users_id = Session::get('islogin')->users_id;
    }
    /*
     * 接受提交的订单
     * */
    public function postsuborder()
    {
        //初始化订单信息，将购物的基本信息放入订单中

        $shopCar = new Shopcart();
        $orderdata = $shopCar->orderinfo();
        $data['desc'] = request()->post('desc');//注释
        $data['users_id'] = Session::get('islogin')->users_id;//用户id
        $data['orders_total'] = $orderdata['orders']['total'];//总价
        $data['iphone'] = request()->post('iphone');//手机好
        $data['users_name'] = request()->post('users_name');//收件人
        $data['address'] = request()->post('address');//收货地址
        $data['orders_addtime'] = time();//添加时间
        $orders = new Orders();
        $orders->allowField(true)->save($data);
        $id = $orders->orders_id;
        $res = $this->addordetail($orderdata['orderDetail'], $id);
        if ($res) {
            $shopCar->getcleartItem();//清空购物车
            echo '去支付';
//            return $this->fetch('index/pay');todo
        } else {
            return $this->error('订单提交失败');
        }
        //将订单中的商品详情放入订单详情中
    }

    public function addordetail($orderdata, $id)
    {
        foreach ($orderdata as $key => $value) {
            $orderdata[$key]['orders_id'] = $id;
        }

        $orderDeta = new Orders_detail();
        return $orderDeta->allowField(true)->saveAll($orderdata);
    }

    /*
     * 通过用户id和订单状态来查看订单列表
     * */
    public function getMyorderList()
    {
        $where['users_id'] = $this->users_id;
        $order = new Orders();
        $orderDetail = new Orders_detail();
        $list = $order->all($where);
        foreach ($list as $key=>$value){
            $list[$key]->orderDetail = $orderDetail->all(['orders_id'=>$value->orders_id]);
        }
        return $this->fetch('index/GeRenZhongXin_WoDeDingDan',['list'=>$list]);
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
        $list = $address->all(['users_id' => $id]);
        return $this->fetch('index/ShouHuoDiZhi', ['list' => $list]);
    }

    /*
     * 给新的订单选择收货地址
     * */
    public function getselect()
    {
        $id = request()->get('id');
        $wher['address_id'] = $id;
        $where['users_id'] = Session::get('islogin')->users_id;
        $address = new Address();
        $address->where($where)->update(['address_select' => 0]);
        $res = $address->where($wher)->update(['address_select' => 1]);
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
        if ($res) {
            echo "<script>alert('收货地址添加成功')</script>";
            return $this->getselectaddress('index/ShouHuoDiZhi');
        } else {
            $this->error('收货地址新增失败');
        }
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
     * 
     * */
    public function getdelress()
    {
        $address = new Address();
        $request = request();
        $id = $request->param('id');
        $res = $address->destroy($id);
        if ($res) {
            $this->success('删除成功');
        } else {
            $this->error('删除失败');
        }
    }

    /*
     * 修改收货地址
     * */
    public function postaddress()
    {

    }

    
}
