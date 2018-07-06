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
    public function toPay($out_trade_no)
    {
        
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
    public function getOrderInfo($out_trade_no=null)
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
     * http://www.sir6xmd.com/ipay/return_url?total_amount=0.01&timestamp=2018-07-06+19%3A35%3A47&sign=BVmHELwP3cnuMnfIEoqSurAV6ZylxpSETyycudXuLEPnOzDZnFWpXhrRVUulZ2%2B76oTpSRVZAKV7A4Wi385JjgXyUVlyOCoFjaOStQUEPY381Tsm3qswbeaOYa7Ps%2FEOnAO7ZrDMfVmUzcWeh68sdkftMYeCanzG%2B5CawkPrQ7cygZl4sEvnQC%2FhW5bESAM2GKN%2FwQNIxUhIilTKdaHtHwGt0LPcraFFGdj%2FIGGt7TOia5XDih0Xko7LHHE4h1Pa88qAdTJCOvyWhg%2FgODCwrD3vBS%2FbjjuRc4ABeOMn13gyX7DPJu3D%2Byz6B69JZ%2BtSXxlG97efoqkCHBo1FxXk9g%3D%3D&trade_no=2018070621001004570597117405&sign_type=RSA2&auth_app_id=2018052460238314&charset=UTF-8&seller_id=2088131200737653&method=alipay.trade.wap.pay.return&app_id=2018052460238314&out_trade_no=2018070619350185316&version=1.0
     */
    public function getreturn_url()
    {
        $alipayData = request()->get();
        $Order_alipay = new Order_alipays($alipayData);
        $Order_alipay->allowField(true)->save();
        $where['out_trade_no'] = $alipayData['out_trade_no'];
        $data['orders_status'] = 1;
        $orders = new Orders();
        $orders->save($data,$where);
        return '支付成功';
    }
}
