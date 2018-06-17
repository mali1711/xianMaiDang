<?php

namespace app\admin\controller;

use app\index\model\Orders;
use think\Controller;
use think\Request;

/**
 * Class Order
 * @package app\admin\controller
 *
 */
class Order extends Controller
{
    public $where = array();//搜索条件

    /**
     * 显示订单首页
     *
     * @return \think\Response
     */
    public function getindex()
    {
        $order = new Orders();
        $where = request()->get();
        $list = $order->where($where)->select();
        $orderCount = $this->orderList();
        return $this->fetch('admin/Order_handling',['list'=>$list,'orderCount'=>$orderCount]);
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

    public function getupdate()
    {


    }
    
    /**
     * 修改订单
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function postupdate()
    {
        $id = request()->POST('orders_id');
        $order = new Orders();
        $status = $order->get($id)->orders_status;
        $array['orders_id'] = $id;
        $array['users_name'] = 'zhangsan';
        $array['address'] = 'lisi';
        $array['iphone'] = '18396861513';
        echo $status;
        if($status==0){
            $res =  $order->isUpdate(true)->save($array);
            if($res){
                $data['success'] = true;
                $data['errorCode'] = 0;
                $data['errorMsg'] = '订单修改成功';
            }else{
                $data['success'] = false;
                $data['errorCode'] = 1;
                $data['errorMsg'] = '订单修改失败';
            }
        }else{
            $data['success'] = false;
            $data['errorCode'] = 3;
            $data['errorMsg'] = '订单已发货或者其他原因';
        }
        return json_decode($data);
    }

    /**
     * 显示指定的订单
     *
     * @get  int  $id
     * @return \think\Response
     */
    public function getread()
    {
        $order = new Orders();
        $list = $order->where($this->where)->select();
        return json_encode($list);
    }


    /**
     * 删除指定订单
     *
     * @get  int  $id
     * @return \think\Response
     */
    public function getdelete()
    {
        $where = request()->get();
        $id = Orders::destroy($where);
        if($id){
            $data['res'] = $id;
            $data['stu'] = true;
            $data['msg'] = '数据删除成功';
        }else{
            $data['res'] = $id;
            $data['stu'] = false;
            $data['msg'] = '数据删除失败';
        }
        return $id;
    }
    
    /**
     *
     * 统计一共有多少页数据
     *
     * @get $num int 每页显示多少数据
     */
    public function getpageCount()
    {
        $order = new Orders();
        $infolist = $order->where($this->where)->count();
        $num = request()->get('num');
        if($num==null){
            $num = 10;
        }
        return ceil($infolist/$num);
    }

    /**
     * 统计一共有多少条订单
     * @param $status
     */
    public function orderList()
    {
        $order = new Orders();
        $orderCount = array();
        $orderCount['orderCount0'] = $order->where(['orders_status'=>0])->count();//已完成
        $orderCount['orderCount1'] = $order->where(['orders_status'=>1])->count();//代付款
        $orderCount['orderCount2'] = $order->where(['orders_status'=>2])->count();//代发货
        $orderCount['orderCount3'] = $order->where(['orders_status'=>3])->count();//代发货
        $orderCount['orderCount'] = $order->count();//所有订单
        return $orderCount;
    }
}
