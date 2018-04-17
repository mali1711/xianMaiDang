<?php

namespace app\index\controller;

use app\admin\model\CatesModel;
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
}
