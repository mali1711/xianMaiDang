<?php

namespace app\index\controller;

use app\admin\model\CatesModel;
use app\index\model\Products;
use think\Controller;
use think\Request;

class Goods extends Controller{

    /*
     * 查看商品分类列表
     * */
    public function getgoods()
    {
        $cates = new CatesModel();
        $list = $cates->all(['cates_pid'=>24]);
        return $this->fetch('index/wangid_ShangP_FenL',['list'=>$list]);
    }

    /*
     * 一级分类列表
     * */
    public function getfirstcates()
    {
        $cates = new CatesModel();
        $list = $cates->all(['cates_pid'=>24]);
        return json_encode($list);
    }

    /*
     * 通过一级分类获取二级分类
     * */
    public function gettowcates()
    {
        $request = request();
        $id = $request->get('id');
        $cates = new CatesModel();
        $list = $cates->all(['cates_pid'=>$id]);
        return json_encode($list);
    }

    /**
     * 显示所有的商品列表
     */
    public function getAllGoodsList()
    {
        $request = request();
        $id = $request->get('id');
        $pro = new Products();
        $list = $pro->select();
        return $this->fetch('index/wangid_ShangP_LieB',['list'=>$list]);
    }

    /*
     * 根据分类显示商品列表
     * */
    public function getgoodslist()
    {
        $request = request();
        $id = $request->get('id');
        $pro = new Products();
        $list = $pro->all(['cates_id'=>$id]);
        return $this->fetch('index/wangid_ShangP_LieB',['list'=>$list]);
    }


    /*
     * 商品详情展示页
     * */
    public function getdetails()
    {
        $request = request();
        $id = $request->get('id');
        $data = Products::get($id);
        return $this->fetch('tow/xiangqing',['data'=>$data]);
//        return $this->fetch('index/XiangQ_Y',['data'=>$data]);
    }
}
