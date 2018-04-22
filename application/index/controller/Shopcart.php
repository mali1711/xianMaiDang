<?php

namespace app\index\controller;

use app\index\model\Address;
use app\index\model\Cart;
use app\index\model\Cart_item;
use app\index\model\Products;
use think\Controller;
use think\Request;
use think\Session;

class Shopcart extends Controller
{


    //购物车id
    public $cart_id = '';

    public function _initialize()
    {
        //购物车id
        $this->cart_id = $this->__getCartID();
        if (!Session::has('islogin')) {
            return $this->error('请先登录', '/indexlogin/loginIphone');
        }
    }

    /*
     * 如果用户没有购物车创建购物车
     * 如果购物车存在就返回购物车id
     * */
    protected function __getCartID()
    {
        $id = session::get('islogin')->users_id;
        $catr = new Cart();
        $res = $catr->get(['users_id' => $id]);
        if ($res == NUll) {
            $data['addtime'] = date('Y-m-d : H:i:s');
            $data['users_id'] = $id;
            $catr->data($data)->save();
            $cart_id = $catr->cart_id;
        } else {
            $cart_id = $res->cart_id;
        }

        return $cart_id;
    }


    /*
     * 向购物车添加一件商品
     * 'product_id' => string '22' (length=2)
     * */
    public function getAdditem()
    {
        $request = request();
        $getdata = $request->get();
        //判断当前商品是否存在当前用户的购物车中，如果不存在就创建，存在就将数量加一
        $where['product_id'] = $getdata['product_id'];
        $where['cart_id'] = $this->cart_id;
        $cartItem = new Cart_item();
        $res = $cartItem->get($where);
        if ($res) {               //存在购物车,数量加一
            return $cartItem->where($where)->setInc('goods_number', 1);
        } else {                  //不存在购物车
            $getdata['cart_id'] = $this->cart_id;
            $res = $cartItem->data($getdata)->save();
            if ($res) {
                return 1;
            } else {
                return 0;
            }
        }
    }


    /*
     * 根据商品id删除购物车商品数量，如果商品数量是0就删除该商品
     * */
    public function getremoveItem()
    {
        $catrItem = new Cart_item();
        $request = request();
        $where['cart_item_id'] = $request->get('id');
        if ($catrItem->get($where)->goods_number == 1) {
            return 2;
        }
        return $catrItem->where($where)->setDec('goods_number', 1);
    }

    /*
    * 根据商品id增加购物车商品数量，
    * */
    public function getaddItemnum()
    {
        $catrItem = new Cart_item();
        $request = request();
        $where['cart_item_id'] = $request->get('id');
        return $catrItem->where($where)->setInc('goods_number', 1);
    }


    /*
     * 根据购物项id删除购物车个别商品
     * */
    public function getdelitem()
    {
        $id = request()->get('id');
        $cartItem = new Cart_item();
        return $cartItem->destroy(['cart_item_id' => $id]);

    }

    /*
     * 根据购物车id，清空购物车
     * */
    public function getcleartItem()
    {
        $cartItem = new Cart_item();
        return $cartItem->destroy(['cart_id' => $this->cart_id]);
    }

    /*
 * 根据购物车id获取购物车商品数量
 * */
    public function getitemCount()
    {
        $cartItem = new Cart_item();
        return $cartItem->count('cart_id', $this->cart_id);
    }

    /*
     *根据购物车id，查找购物车商品
     * */
    public function getcheckGoods()
    {
        $cartItem = new Cart_item();
        $list = $cartItem->all(['cart_id' => $this->cart_id]);
        $num = $this->getitemCount();
        return $this->fetch('index/wanagid_GouWuChe', ['list' => $list, 'num' => $num]);
    }

    /*
     * 统计购物车数据，提交到订单中
     * 根据购物车中商品项和商品总价生成订单初始数据
     * */
    public function getSettlement()
    {
        $data = $this->orderinfo();
        return $this->fetch('index/wanagid_JieSuan', ['list' => $data['orderDetail'], 'order' => $data['orders']]);
    }

    /*
     * 获取被选择的地址
     * */
    public function address()
    {
        $where['users_id'] = Session::get('islogin')->users_id;
        $where['address_select'] = 1;
        $addre = new Address();
        $data = $addre->get($where);
        return $data;

    }


    /**
     * 初始化提交信息
     * @return array
     */
    public function orderinfo()
    {
        $cart_item = new cart_item();
        $list = json_decode(json_encode($cart_item->all(['cart_id' => $this->cart_id])));
        $orderDetail = array();
        $orders['total'] = '';//订单总金额
        $orders['address'] = $this->address();
        foreach ($list as $key => $value) {
            $orders['total'] += $value->goods_price;
            foreach ($value as $k => $v) {
                $orderDetail[$key][$k] = $v;
            }
            $orderDetail[$key]['goodspic'] = Products::get($value->product_id)->products_pic;
        }
        $data['orderDetail'] = $orderDetail;
        $data['orders'] = $orders;
        return $data;
    }

}