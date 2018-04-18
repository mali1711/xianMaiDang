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
    public function index()
    {

        $list = CatesModel::all(['cates_pid'=>24]);
        foreach ($list as $k=>$v){
            $pro = new Products();
            $id = $v->cates_id;
            $list[$k]['goods'] = $pro->where(['cates_id'=>$id])
                ->limit(3)
                ->order('products_id','desc')
                ->select();
        }
        return $this->fetch("index/index",['list'=>$list]);
    }
}
