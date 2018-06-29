<?php
namespace app\index\controller;

use app\admin\model\CatesModel;
use app\admin\validate\AdminValidate;
use app\index\model\Products;
use think\Controller;
use app\admin\model\AdminModel;
use \think\Request;


class Index extends Controller
{
    /**
     * @return mixed
     * 网站首页
     */
    public function index()
    {

//        return $this->fetch("index/index",['list'=>$list]); 一期项目首页

        $list['products'] = $this->newgoods_6();
        return $this->fetch("tow/shouye",['list'=>$list]);
    }

    /**
     * 最新商品（前6个）
     */
    public function newgoods_6()
    {
        $products = new Products;
        $data = $products->order('products_addtime desc')->limit('6')->select();
        return $data;
    }
}
