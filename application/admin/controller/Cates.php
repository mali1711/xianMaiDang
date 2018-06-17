<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/27
 * Time: 11:34
 */

namespace app\admin\controller;

use app\admin\model\CatesModel;
use think\Controller;
use think\Db;
use \think\Request;
use think\session\driver\Memcache;


class Cates extends controller
{
    /**
     * @return mixed
     * 分类首页
     */
    public function getIndex()
    {
        $list = $this->catesList();
        return $this->fetch('admin/Category_Manage',['list'=>$list]);
    }

    /*
     * 获取分类列表
     * */
    public function catesList()
    {
        $cate=Db::query("select *,concat(cates_path,',',cates_id) as paths from cates order by paths");
        foreach($cate as $key=>$value){
            // echo $value['path']."<br>";
            //获取path
            $path=$value['cates_path'];
            //把path 转换为数组
            $arr=explode(",",$path);
            // echo "<pre>";
            // var_dump($arr);
            //获取逗号个数
            $len=count($arr)-1;
            // echo $len."<br>";
            //str_repeat 重复字符串
            $cate[$key]['cates_name']=str_repeat("---|",$len).$value['cates_name'];

        }
        return $cate;
    }

    /*
     * 跳转到添加分类页面
     * */
    public function getProduct_category_add()
    {
        $request =  Request::instance();
        $id = $request->get('id');
        $list['id'] = $id;
        return $this->fetch('admin/product_category_add',['list'=>$list]);
    }
    /*
     * 执行分类添加动作
     * */
    public function postProduct_category_add()
    {
        $request =  Request::instance();
        $data = $request->post();
        if($data['cates_pid']==''){
            $data['cates_path']='';
        }else{
            $res = CatesModel::get($data['cates_pid']);
            $data['cates_path'] = $res->cates_path.','.$data['cates_pid'];
        }
        $Cates = new CatesModel($data);
        // 过滤post数组中的非数据表字段数据
        $res = $Cates->allowField(true)->save();
        if($res){
            $this->success('添加成功');  
        }else{
            $this->success('添加失败');
        }
    }

    /*
     * 修改分类
     * */
    public function getProduct_category_edit()
    {
        $request =  Request::instance();
//      $where['cates_pid'] = $request->get('id');
//      $list = Db::table('cates')->where($where)->find();
        $id = $request->get('id');
        $list = CatesModel::get($id);
        return $this->fetch('admin/product_category_edit',['list'=>$list]);
    }

    /*
     * 执行修改动作
     * */
    public function postProduct_category_edit()
    {
        $request =  Request::instance();
        $data = $request->post();
        $id =  $data['cates_id'];
        unset($data['cates_id']);
        $Cates = new CatesModel();
        $res = $Cates->allowField(true)->save($data,['cates_id'=>$id]);
        if($res){
            $this->success('修改成功');
        }else{
            $this->error('修改失败');
        }
    }

    /*
     * 删除分类
     * */
    public function getProduct_category_del()
    {
        $request =  Request::instance();
        $id = $request->get('id');
        $res = CatesModel::destroy($id);
        if($res){
            return 1;
        }else{
            return 0;
        }
        return $info;
    }

}