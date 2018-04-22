<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/8
 * Time: 14:25
 * 快递员操作类
 *
 */

namespace app\admin\controller;
use app\admin\model\CourierModel;
use think\Controller;

class Courier extends Controller
{
    public function getindex()
    {
        $list = CourierModel::all();
        return $this->fetch('admin/courier',['list'=>$list]);
    }


    /**
     * 图片上传
     * @return mixed
     */
    public function getadd()
    {
        return $this->fetch('admin/courierlist');
    }

    public function postadd()
    {
        $resquest = request();
        $courier = new CourierModel();
        $data = $resquest->post();
        $data['courier_addtime '] = time();
        $data['password'] = md5($data['password']);
        $courier->data($data);
        $res = $courier->allowField(true)->save();
        if($res){
            $this->success('添加成功');
        }else{
            $this->error('添加失败');
        }
    }


    /**
     * 修改管理员
     * @param id：GET 快递员id
     */
    public function getupdateinfo()
    {

    }

    /**
     * 执行修改
     * @param array $array :POST 被提交的快递员的信息
     */
    public function postupdateinfo()
    {

    }

    /**
     * 修改快递员状态
     * @param int $id:GET
     */
    public function getstatus()
    {

    }

    /**
     * 删除快递员
     * @param int $id:GET
     * @return bool
     */
    public function getdel()
    {
        $request = request();
        $id = $request->get('id');
        $res = CourierModel::destroy($id);
        if($res){
            return 1;
        }else{
            return 0;
        }
    }

    /**
     * 查看快递员详情
     * @param int $id:GET 查看快递员详情
     * @return object
     */
    public function getDetail()
    {
        $resquest = request();
        $id = $resquest->get('id');
        $info = CourierModel::get($id);
        return $info;
    }

    /**
     * 上传头像
     * @param $file:文件上传
     * @return string 图片名
     */
    public function upFile($file)
    {

    }
}