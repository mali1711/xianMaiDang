<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/29
 * Time: 17:09
 */


namespace app\admin\controller;

use app\admin\model\CatesModel;
use app\admin\model\ProductsModel;
use think\Controller;
use think\Db;
use \think\Request;
use think\session\driver\Memcache;


/*
 * 产品控制器
 * */
class Products extends controller
{
    /*
     * 产品列表
     * */
    public function getProducts_List()
    {
        $products_List = ProductsModel::all();//获取所有商品的信息
        $list = action('cates/catesList');
        return $this->fetch('admin/products_List',['products_List'=>$products_List,'list'=>$list]);
    }



    /*
     * 产品添加页面
     * getpicture_add
     * */
    public function getPicture_add()
    {
        $catesList = action('cates/catesList');//获取商品分类
        return $this->fetch('admin/picture_add',['catesList'=>$catesList]);
    }

    /*
     * 执行产品添加动作
     * */
    public function postPicture_add()
    {
        $request =  Request::instance();
        $data = $request->post();
        $data['products_pic'] = $this->upload('products_pic','products');//文件上传
        $data['products_addtime'] = time();
        //如果商品第一次添加，且没有关联任何商品
        if($data['products_relevance']==''){
            $data['products_relevance'] = time().mt_rand(100000,999999);
        }
        if($data['products_pic']==false){
            $info['code'] = 0;
            $info['info'] = '文件上传失败';
        }else{
            $products = new ProductsModel;
            $products->data($data)->save();
        }

    }

    /*
     * 验证添加的字段是否合法
     * */
    private function addPorVerify($data)
    {
        if(empty($data['products_unit'])){
            $info = '请填写商品单位';
        }elseif(empty($data['products_pic_title'])){
            $info = '请填写正确的商品标题';
        }
        elseif(empty('products_newprice')){
            $info = '请填写商品现价';
        }
        else{
            $info = true;
        }
        $this->error($info);
    }

    /*
     * 查看商品详情
     * getProductsDetail
     * */
    public function getProDet()
    {
        $request = Request::instance();
        $id = $request->get('id');
        $proInfo = ProductsModel::get($id);
    }

    /*
     * 删除商品
     * */
    public function getProDel()
    {
        $request = Request::instance();
        $id = $request->get('id');
        $this->getDelFil($id);
        $res = ProductsModel::destroy($id);
        if($res){
            return 1;
        }else{
            return 0;
        }
    }

    /*
     * 删除商品中包含的静态文件。
     * 删除被商品关联的其他的信息，如评价
     * */
    public function getDelFil($id)
    {
        $list = ProductsModel::get($id);
        $path = $list['products_pic'];
        $res = @unlink(ROOT_PATH . 'public' . DS . "uploads/products/"."$path");//删除商品展示图片
    }

    /*
     * 跳转到修改页面
     * */
    public function getProEdi()
    {
        $request = Request::instance();
        $id = $request->get('id');
        $proInfo = ProductsModel::get($id);
    }

    /*
     * 执行修改页面
     * */
    public function postProEdi()
    {

    }

    /*
     * 单文件上传
     * 参数  上传文件名   文件位置
     * */
    public function upload($name,$path){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file($name);

        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            $info = $file->move(ROOT_PATH.'public'.DS."uploads/$path");
            if($info){
                return $info->getSaveName();
            }else{
                // 上传失败获取错误信息
                return false;
            }
        }
    }
}