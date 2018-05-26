<?php

namespace app\index\controller;

use app\index\model\Order_alipays;
use app\index\model\Orders;
use app\index\model\Orders_detail;
use think\Controller;
use think\Request;
use think\Session;

/**
 * Class Pay
 * @package app\index\controller
 * 支付
 */
class Pay extends Controller
{
    /**
     * 支付页面
     */
    public function gettoPay($out_trade_no='2018052621201680902')
    {
        $data = $this->getOrderInfo($out_trade_no);
        return $this->fetch('index/toPay',['data'=>$data]);
    }


    public function posttoPay()
    {
        $out_trade_no = request()->post('WIDout_trade_no');

        $data = $this->getOrderInfo($out_trade_no);
        $_POST = $data;
        alipay();
    }

    /**
     * @param $id 订单id
     * @return array
     */
    public function getOrderInfo($out_trade_no=0)
    {
        $order = new Orders();
        $orderinfo = $order->get(['out_trade_no'=>$out_trade_no]);
        if($out_trade_no=='' or $out_trade_no == null){
            $this->error('请选择有效的订单');
            return false;
        }
        $data['WIDout_trade_no'] =   $out_trade_no;
        $data['WIDsubject']      =   "鲜卖当超市商品";//订单名称
        $data['WIDtotal_amount'] =   0.01;//付款金额
//        $data['WIDtotal_amount'] =   $orderinfo->orders_total;//todo 付款金额
        $data['WIDbody'] =          "鲜卖当超市商品";//商品描述
        return $data;
    }

    /**
     * 异步通知地址
     */
    public function getnotify_url()
    {
        echo 'notify_url';
    }

    /**
     * 同步跳转(支付成功跳转的地址)
     */
    public function getreturn_url()
    {
        $alipayData = request()->get();
        $Order_alipay = new Order_alipays($alipayData);
        $Order_alipay->allowField(true)->save();
        $where['out_trade_no'] = $alipayData['out_trade_no'];
        $data['orders_status'] = 1;
        $orders = new Order();
        $orders->upStatus($data,$where);
        return $this->fetch('/');
    }

}
